<?php // phpcs:ignore

namespace WP2FA\Authenticator;

use \WP2FA\WP2FA as WP2FA;
use \WP2FA\Authenticator\Authentication as Authentication;
use \WP2FA\Cron\CronTasks as CronTasks;
use \WP2FA\Authenticator\BackupCodes as BackupCodes;
use \WP2FA\Admin\SetupWizard as SetupWizard;

/**
 * Class for handling logins.
 */
class Login {

	/**
	 * Keys used for backup codes
	 *
	 * @var string
	 */
	const ENABLED_PROVIDERS_USER_META_KEY = 'wp_2fa_enabled_methods';
	const USER_META_NONCE_KEY             = 'wp_2fa_nonce';
	const INPUT_NAME_RESEND_CODE          = 'wp-2fa-email-code-resend';

	/**
	 * Keep track of all the password-based authentication sessions that
	 * need to invalidated before the second factor authentication.
	 *
	 * @var array
	 */
	private static $password_auth_tokens = array();

	/**
	 * Constructor.
	 */
	public function __construct() {

	}

	/**
	 * Grab list of possible providers.
	 *
	 * @return [type] [description]
	 */
	public static function get_providers() {
		$providers = array(
			'totp',
			'email',
			'backup_codes',
		);

		/**
		 * Filter the supplied providers.
		 *
		 * This lets third-parties either remove providers (such as Email), or
		 * add their own providers (such as text message or Clef).
		 *
		 * @param array $provider array if available options.
		 */
		$providers = apply_filters( '2fa_providers', $providers );

		return $providers;
	}

	/**
	 * Keep track of all the authentication cookies that need to be
	 * invalidated before the second factor authentication.
	 *
	 * @param string $cookie Cookie string.
	 *
	 * @return void
	 */
	public static function collect_auth_cookie_tokens( $cookie ) {
		$parsed = wp_parse_auth_cookie( $cookie );

		if ( ! empty( $parsed['token'] ) ) {
			self::$password_auth_tokens[] = $parsed['token'];
		}
	}

	/**
	 * Get all Two-Factor Auth providers that are enabled for the specified|current user.
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 * @return array
	 */
	public static function get_enabled_providers_for_user( $user = null ) {
		if ( empty( $user ) || ! is_a( $user, 'WP_User' ) ) {
			$user = wp_get_current_user();
		}

		$providers         = self::get_providers();
		$enabled_providers = get_user_meta( $user->ID, self::ENABLED_PROVIDERS_USER_META_KEY, true );
		if ( empty( $enabled_providers ) ) {
			$enabled_providers = array();
		}
		$enabled_providers = array_intersect( $enabled_providers, array_keys( $providers ) );

		return $enabled_providers;
	}

	/**
	 * Get all Two-Factor Auth providers that are both enabled and configured for the specified|current user.
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 * @return array
	 */
	public static function get_available_providers_for_user( $user = null ) {
		if ( empty( $user ) || ! is_a( $user, 'WP_User' ) ) {
			$user = wp_get_current_user();
		}

		// Lets see what 2fa method the use has chosen.
		$enabled_providers = get_user_meta( $user->ID, self::ENABLED_PROVIDERS_USER_META_KEY, true );

		// Setup an array which we will use shortly.
		$configured_providers = '';

		// Now lets confirm if the method is actually setup.
		if ( 'totp' === $enabled_providers ) {
			$configured_providers = $enabled_providers;
		} elseif ( 'email' === $enabled_providers ) {
			$configured_providers = $enabled_providers;
		}

		return $configured_providers;
	}

	/**
	 * Quick boolean check for whether a given user is using two-step.
	 *
	 * @since 0.1-dev
	 *
	 * @param int $user_id Optional. User ID. Default is 'null'.
	 * @return bool
	 */
	public static function is_user_using_two_factor( $user_id = null ) {
		$provider = get_user_meta( $user_id, self::ENABLED_PROVIDERS_USER_META_KEY, true );
		return ! empty( $provider );
	}

	/**
	 * Handle the browser-based login.
	 *
	 * @since 0.1-dev
	 *
	 * @param string  $user_login Username.
	 * @param WP_User $user WP_User object of the logged-in user.
	 */
	public static function wp_login( $user_login, $user ) {
		$is_user_instantly_enforced = get_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true );
		if ( $is_user_instantly_enforced ) {
			$new_page_id        = WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
			$new_page_permalink = get_permalink( $new_page_id );
			if ( ! empty( $new_page_permalink ) ) {
				wp_redirect( $new_page_permalink  );
				exit;
			} else {
				if ( WP2FA::is_this_multisite() ) {
					$link = admin_url( 'index.php?page=wp-2fa-setup' );
				} else {
					$link = admin_url( 'options-general.php?page=wp-2fa-setup' );
				}
				wp_safe_redirect( $link );
				exit;
			}

		}

		if ( ! self::is_user_using_two_factor( $user->ID ) ) {
			return;
		}
		// Invalidate the current login session to prevent from being re-used.
		self::destroy_current_session_for_user( $user );

		// Also clear the cookies which are no longer valid.
		wp_clear_auth_cookie();

		self::show_two_factor_login( $user );
		exit;
	}

	/**
	 * Destroy the known password-based authentication sessions for the current user.
	 *
	 * Is there a better way of finding the current session token without
	 * having access to the authentication cookies which are just being set
	 * on the first password-based authentication request.
	 *
	 * @param \WP_User $user User object.
	 *
	 * @return void
	 */
	public static function destroy_current_session_for_user( $user ) {
		$session_manager = \WP_Session_Tokens::get_instance( $user->ID );

		foreach ( self::$password_auth_tokens as $auth_token ) {
			$session_manager->destroy( $auth_token );
		}
	}

	/**
	 * Prevent login through XML-RPC and REST API for users with at least one
	 * 2FA method enabled.
	 *
	 * @param  WP_User|WP_Error $user Valid WP_User only if the previous filters
	 *                                have verified and confirmed the
	 *                                authentication credentials.
	 *
	 * @return WP_User|WP_Error
	 */
	public static function filter_authenticate( $user ) {
		if ( $user instanceof WP_User && self::is_api_request() && self::is_user_using_two_factor( $user->ID ) && ! self::is_user_api_login_enabled( $user->ID ) ) {
			return new \WP_Error(
				'invalid_application_credentials',
				esc_html__( 'Error: API login for user disabled.', 'wp-2fa' )
			);
		}

		return $user;
	}

	/**
	 * Checks if user is current out of there grace period
	 *
	 * @param  object $user     User data.
	 * @param  string $password Password.
	 */
	public static function is_user_locked( $user, $password ) {

		$grace_period_expired = false;
		$settings             = get_option( 'wp_2fa_settings' );

		if ( is_a( $user, '\WP_User' ) ) {

				if ( 'do-not-enforce' !== $settings['enforcment-policy'] ) {
					$grace_period_expiry_time = get_user_meta( $user->ID, 'wp_2fa_grace_period_expiry', true );
					$grace_period_expired     = get_user_meta( $user->ID, 'wp_2fa_user_grace_period_expired', true );
					$account_notification     = get_user_meta( $user->ID, 'wp_2fa_locked_account_notification', true );
					$is_needed                = Authentication::is_user_eligible_for_2fa( $user->ID );
					$time_now                 = time();
					$is_user_instantly_enforced = get_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true );

					if ( ! empty( $grace_period_expiry_time ) && $grace_period_expiry_time < $time_now && $is_needed ) {
						// If user has no "instant 2fa" applied, handle accordingly.
						if ( ! $is_user_instantly_enforced ) {
							$grace_expired = update_user_meta( $user->ID, 'wp_2fa_user_grace_period_expired', true );
							// Send the email to alert the user, only if we have not done so before.
							if ( ! $account_notification ) {
								CronTasks::send_expired_grace_email( $user->ID );
								$locked_account_notification = update_user_meta( $user->ID, 'wp_2fa_locked_account_notification', true );
							}

							// Grab user session and kill it, preferably with fire.
							$manager = \WP_Session_Tokens::get_instance( $user->ID );
							$manager->destroy_all();
							$grace_period_expired = true;
						}
					}

					if ( $grace_period_expired ) {
						return new \WP_Error(
							'account_locked',
							esc_html__( 'Your user account has been locked because you have not configured 2FA within the grace period. Please contact the website administrator to unlock your user and you can configure 2FA.', 'wp-2fa' )
						);
					}
				}

			return $user;

		}
	}

	/**
	 * If the current user can login via API requests such as XML-RPC and REST.
	 *
	 * @param  integer $user_id User ID.
	 *
	 * @return boolean
	 */
	public static function is_user_api_login_enabled( $user_id ) {
		return (bool) apply_filters( 'two_factor_user_api_login_enable', false, $user_id );
	}

	/**
	 * Is the current request an XML-RPC or REST request.
	 *
	 * @return boolean
	 */
	public static function is_api_request() {
		if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
			return true;
		}

		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			return true;
		}

		return false;
	}

	/**
	 * Display the login form.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 */
	public static function show_two_factor_login( $user ) {
		if ( ! $user ) {
			$user = wp_get_current_user();
		}

		$login_nonce = self::create_login_nonce( $user->ID );
		if ( ! $login_nonce ) {
			wp_die( esc_html__( 'Failed to create a login nonce.', 'wp-2fa' ) );
		}

		$redirect_to = isset( $_REQUEST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ) : admin_url();

		self::login_html( $user, $login_nonce['key'], $redirect_to );
	}

	/**
	 * Display the Backup code 2fa screen.
	 *
	 * @since 0.1-dev
	 */
	public static function backup_2fa() {
		if ( ! isset( $_GET['wp-auth-id'], $_GET['wp-auth-nonce'], $_GET['provider'] ) ) {
			return;
		}

		// Filter $_GET array for security.
		$get_array = filter_input_array( INPUT_GET );
		$auth_id   = (int) $get_array['wp-auth-id'];
		$user      = get_userdata( $auth_id );
		if ( ! $user ) {
			return;
		}

		$nonce = sanitize_text_field( $get_array['wp-auth-nonce'] );
		if ( true !== self::verify_login_nonce( $user->ID, $nonce ) ) {
			wp_safe_redirect( get_bloginfo( 'url' ) );
			exit;
		}

		if ( ! isset( $get_array['provider'] ) ) {
			wp_die( esc_html__( 'Cheatin&#8217; uh?', 'wp-2fa' ), 403 );
		} else {
			$provider = 'backup_codes';
		}

		self::login_html( $user, $nonce, esc_url_raw( wp_unslash( $get_array['redirect_to'] ) ), '', $provider );

		exit;
	}

	/**
	 * Generates the html form for the second step of the authentication process.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User       $user WP_User object of the logged-in user.
	 * @param string        $login_nonce A string nonce stored in usermeta.
	 * @param string        $redirect_to The URL to which the user would like to be redirected.
	 * @param string        $error_msg Optional. Login error message.
	 * @param string|object $provider An override to the provider.
	 */
	public static function login_html( $user, $login_nonce, $redirect_to, $error_msg = '', $provider = null ) {
		if ( ! $provider ) {
			$provider = self::get_available_providers_for_user( $user );
		}

		$codes_remaining = BackupCodes::codes_remaining_for_user( $user );

		$interim_login = ( isset( $_REQUEST['interim-login'] ) ) ? filter_var( wp_unslash( $_REQUEST['interim-login'] ), FILTER_VALIDATE_BOOLEAN ) : false;

		$rememberme = intval( self::rememberme() );

		if ( ! function_exists( 'login_header' ) ) {
			// We really should migrate login_header() out of `wp-login.php` so it can be called from an includes file.
			include_once WP_2FA_PATH . 'includes/functions/login-header.php';
		}

		login_header();

		if ( ! empty( $error_msg ) ) {
			echo '<div id="login_error"><strong>' . esc_html( $error_msg ) . '</strong><br /></div>';
		}

		?>

		<form name="validate_2fa_form" id="loginform" action="<?php echo esc_url( self::login_url( array( 'action' => 'validate_2fa' ), 'login_post' ) ); ?>" method="post" autocomplete="off">
				<input type="hidden" name="provider"      id="provider"      value="<?php echo esc_attr( $provider ); ?>" />
				<input type="hidden" name="wp-auth-id"    id="wp-auth-id"    value="<?php echo esc_attr( $user->ID ); ?>" />
				<input type="hidden" name="wp-auth-nonce" id="wp-auth-nonce" value="<?php echo esc_attr( $login_nonce ); ?>" />
				<?php if ( $interim_login ) { ?>
					<input type="hidden" name="interim-login" value="1" />
				<?php } else { ?>
					<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
				<?php } ?>
				<input type="hidden" name="rememberme"    id="rememberme"    value="<?php echo esc_attr( $rememberme ); ?>" />

				<?php
				// Check to see what provider is set and give the relevant authentication page.
				if ( 'totp' === $provider ) {
					self::totp_authentication_page( $user );
				} elseif ( 'email' === $provider ) {
					self::email_authentication_page( $user );
				} elseif ( 'backup_codes' === $provider ) {
					self::backup_codes_authentication_page( $user );
				}
				?>
		</form>

		<?php
		if ( isset( $codes_remaining ) && $codes_remaining > 0 ) :
			$login_url = self::login_url(
				array(
					'action'        => 'backup_2fa',
					'provider'      => 'backup_codes',
					'wp-auth-id'    => $user->ID,
					'wp-auth-nonce' => $login_nonce,
					'redirect_to'   => $redirect_to,
					'rememberme'    => $rememberme,
				)
			);
			?>
			<div class="backup-methods-wrap">
				<p class="backup-methods">
					<a href="<?php echo esc_url( $login_url ); ?>">
						<?php esc_html_e( 'Or, use a backup code.', 'wp-2fa' ); ?>
					</a>
				</p>
			</div>
	<?php endif; ?>

		<p id="backtoblog">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Are you lost?', 'wp-2fa' ); ?>">
				<?php
				echo esc_html(
					sprintf(
						// translators: %s: site name.
						__( '&larr; Back to %s', 'wp-2fa' ),
						get_bloginfo( 'title', 'display' )
					)
				);
				?>
			</a>
		</p>
		</div>
		<style>
		/* @todo: migrate to an external stylesheet. */
		.backup-methods-wrap {
			margin-top: 16px;
			padding: 0 24px;
		}
		.backup-methods-wrap a {
			color: #999;
			text-decoration: none;
		}
		ul.backup-methods {
			display: none;
			padding-left: 1.5em;
		}
		/* Prevent Jetpack from hiding our controls, see https://github.com/Automattic/jetpack/issues/3747 */
		.jetpack-sso-form-display #loginform > p,
		.jetpack-sso-form-display #loginform > div {
			display: block;
		}
		</style>

		<?php
		/** This action is documented in wp-login.php */
		do_action( 'login_footer' );
		?>
		<div class="clear"></div>
		</body>
		</html>
		<?php
	}

	/**
	 * Generate the 2FA login form URL.
	 *
	 * @param  array  $params List of query argument pairs to add to the URL.
	 * @param  string $scheme URL scheme context.
	 *
	 * @return string
	 */
	public static function login_url( $params = array(), $scheme = 'login' ) {
		if ( ! is_array( $params ) ) {
			$params = array();
		}

		$params = urlencode_deep( $params );

		return add_query_arg( $params, site_url( 'wp-login.php', $scheme ) );
	}

	/**
	 * Create the login nonce.
	 *
	 * @since 0.1-dev
	 *
	 * @param int $user_id User ID.
	 * @return array
	 */
	public static function create_login_nonce( $user_id ) {
		$login_nonce = array();
		try {
			$login_nonce['key'] = bin2hex( random_bytes( 32 ) );
		} catch ( Exception $ex ) {
			$login_nonce['key'] = wp_hash( $user_id . mt_rand() . microtime(), 'nonce' );
		}
		$login_nonce['expiration'] = time() + HOUR_IN_SECONDS;

		if ( ! update_user_meta( $user_id, self::USER_META_NONCE_KEY, $login_nonce ) ) {
			return false;
		}

		return $login_nonce;
	}

	/**
	 * Delete the login nonce.
	 *
	 * @since 0.1-dev
	 *
	 * @param int $user_id User ID.
	 * @return bool
	 */
	public static function delete_login_nonce( $user_id ) {
		return delete_user_meta( $user_id, self::USER_META_NONCE_KEY );
	}

	/**
	 * Verify the login nonce.
	 *
	 * @since 0.1-dev
	 *
	 * @param int    $user_id User ID.
	 * @param string $nonce Login nonce.
	 * @return bool
	 */
	public static function verify_login_nonce( $user_id, $nonce ) {
		$login_nonce = get_user_meta( $user_id, self::USER_META_NONCE_KEY, true );
		if ( ! $login_nonce ) {
			return false;
		}

		if ( $nonce !== $login_nonce['key'] || time() > $login_nonce['expiration'] ) {
			self::delete_login_nonce( $user_id );
			return false;
		}

		return true;
	}

	/**
	 * Login form validation.
	 *
	 * @since 0.1-dev
	 */
	public static function login_form_validate_2fa() {
		if ( ! isset( $_POST['wp-auth-id'], $_POST['wp-auth-nonce'] ) ) {
			return;
		}

		$auth_id = (int) $_POST['wp-auth-id'];
		$user    = get_userdata( $auth_id );
		if ( ! $user ) {
			return;
		}

		$nonce = ( isset( $_POST['wp-auth-nonce'] ) ) ? sanitize_textarea_field( wp_unslash( $_POST['wp-auth-nonce'] ) ) : '';
		if ( true !== self::verify_login_nonce( $user->ID, $nonce ) ) {
			wp_safe_redirect( get_bloginfo( 'url' ) );
			exit;
		}

		if ( isset( $_POST['provider'] ) ) {
			$provider  = sanitize_textarea_field( wp_unslash( $_POST['provider'] ) );
			$providers = self::get_available_providers_for_user( $user );
			if ( isset( $providers[ $provider ] ) ) {
				$provider = $providers[ $provider ];
			} elseif ( isset( $provider ) ) {
				$provider = $provider;
			} else {
				$provider = $provider;
			}
		}

		// If this is an email login, or if the user failed validation previously, lets send the code to the user.
		if ( 'email' === $provider && true !== self::pre_process_email_authentication( $user ) ) {
			$login_nonce = self::create_login_nonce( $user->ID );
			if ( ! $login_nonce ) {
				wp_die( esc_html__( 'Failed to create a login nonce.', 'wp-2fa' ) );
			}
		}

		// Validate TOTP.
		if ( 'totp' === $provider && true !== self::validate_totp_authentication( $user ) ) {
			do_action( 'wp_login_failed', $user->user_login );

			$login_nonce = self::create_login_nonce( $user->ID );
			if ( ! $login_nonce ) {
				wp_die( esc_html__( 'Failed to create a login nonce.', 'wp-2fa' ) );
			}

			self::login_html( $user, $login_nonce['key'], esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ), esc_html__( 'ERROR: Invalid verification code.', 'wp-2fa' ), $provider );
			exit;
		}

		// Backup Codes.
		if ( 'backup_codes' === $provider && true !== self::validate_backup_codes( $user ) ) {
			do_action( 'wp_login_failed', $user->user_login );
			$login_nonce = self::create_login_nonce( $user->ID );
			if ( ! $login_nonce ) {
				wp_die( esc_html__( 'Failed to create a login nonce.', 'wp-2fa' ) );
			}

			self::login_html( $user, $login_nonce['key'], esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ), esc_html__( 'ERROR: Invalid backup code.', 'wp-2fa' ), $provider );
			exit;
		}

		// Validate Email.
		if ( 'email' === $provider && true !== self::validate_email_authentication( $user ) ) {
			do_action( 'wp_login_failed', $user->user_login );

			$login_nonce = self::create_login_nonce( $user->ID );
			if ( ! $login_nonce ) {
				wp_die( esc_html__( 'Failed to create a login nonce.', 'wp-2fa' ) );
			}

			if ( isset( $_REQUEST['wp-2fa-email-code-resend'] ) ) {
				self::login_html( $user, $login_nonce['key'], esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ), esc_html__( 'A new code has been sent.', 'wp-2fa' ), $provider );
			} else {
				self::login_html( $user, $login_nonce['key'], esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ), esc_html__( 'ERROR: Invalid verification code.', 'wp-2fa' ), $provider );
			}

			exit;
		}

		self::delete_login_nonce( $user->ID );

		$rememberme = false;
		$remember   = ( isset( $_REQUEST['rememberme'] ) ) ? filter_var( $_REQUEST['rememberme'], FILTER_VALIDATE_BOOLEAN ) : '';
		if ( ! empty( $remember ) ) {
			$rememberme = true;
		}

		wp_set_auth_cookie( $user->ID, $rememberme );

		do_action( 'two_factor_user_authenticated', $user );

		// Must be global because that's how login_header() uses it.
		global $interim_login;
		$interim_login = ( isset( $_REQUEST['interim-login'] ) ) ? filter_var( $_REQUEST['interim-login'], FILTER_VALIDATE_BOOLEAN ) : false;

		if ( $interim_login ) {
			$message       = '<p class="message">' . __( 'You have logged in successfully.', 'wp-2fa' ) . '</p>';
			$interim_login = 'success'; // WPCS: override ok.
			login_header( '', $message );
			?>
			</div>
			<?php
			/** This action is documented in wp-login.php */
			do_action( 'login_footer' );
			?>
			</body></html>
			<?php
			exit;
		}

		// Check if user has any roles/caps set - if they dont, we know its a "network" user.
		if ( is_multisite() && ! get_active_blog_for_user( $user->ID ) && empty( $user->caps ) && empty( $user->caps ) ) {
			$redirect_to = user_admin_url();
		} else {
			$redirect_to = apply_filters( 'login_redirect', esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ), esc_url_raw( wp_unslash( $_REQUEST['redirect_to'] ) ), $user );
		}

		wp_safe_redirect( $redirect_to );

		exit;
	}

	/**
	 * Should the login session persist between sessions.
	 *
	 * @return boolean
	 */
	public static function rememberme() {
		$rememberme = false;

		if ( ! empty( $_REQUEST['rememberme'] ) ) {
			$rememberme = true;
		}

		return (bool) apply_filters( 'wp_2fa_rememberme', $rememberme );
	}

	/**
	 * Prints the form that prompts the user to authenticate.
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 */
	public static function totp_authentication_page( $user ) {
		require_once ABSPATH . '/wp-admin/includes/template.php';
		?>
		<p>
			<label for="authcode"><?php esc_html_e( 'Authentication Code:', 'wp-2fa' ); ?></label>
			<input type="tel" name="authcode" id="authcode" class="input" value="" size="20" pattern="[0-9]*" />
		</p>
		<script type="text/javascript">
			setTimeout( function(){
				var d;
				try{
					d = document.getElementById('authcode');
					d.value = '';
					d.focus();
				} catch(e){}
			}, 200);
		</script>
		<?php
		submit_button( __( 'Authenticate', 'wp-2fa' ) );
	}

	/**
	 * Validates authentication.
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 *
	 * @return bool Whether the user gave a valid code
	 */
	public static function validate_totp_authentication( $user ) {
		if ( ! empty( $_REQUEST['authcode'] ) ) { // WPCS: CSRF ok, nonce verified by login_form_validate_2fa().
			return Authentication::is_valid_authcode(
				Authentication::get_user_totp_key( $user->ID ),
				sanitize_text_field( $_REQUEST['authcode'] ) // WPCS: CSRF ok, nonce verified by login_form_validate_2fa().
			);
		}

		return false;
	}

	/**
	 * Prints the form that prompts the user to authenticate.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 */
	public static function email_authentication_page( $user ) {
		if ( ! $user ) {
			return;
		}

		$has_token = Authentication::user_has_token( $user->ID );
		if ( empty( $has_token ) || ! $has_token ) {
			SetupWizard::send_authentication_setup_email( $user->ID );
		}

		require_once ABSPATH . '/wp-admin/includes/template.php';
		?>
	<p><?php esc_html_e( 'A verification code has been sent to the email address associated with your account.', 'wp-2fa' ); ?></p>
	<p>
	</br>
		<label for="authcode"><?php esc_html_e( 'Verification Code:', 'wp-2fa' ); ?></label>
		<input type="tel" name="wp-2fa-email-code" id="authcode" class="input" value="" size="20" pattern="[0-9]*" />
		<?php submit_button( __( 'Log In', 'wp-2fa' ) ); ?>
	</p>
	<p class="2fa-email-resend">
		<input type="submit" class="button" name="<?php echo esc_attr( self::INPUT_NAME_RESEND_CODE ); ?>" value="<?php esc_attr_e( 'Resend Code', 'wp-2fa' ); ?>" />
	</p>
	<script type="text/javascript">
		setTimeout( function(){
		var d;
		try{
			d = document.getElementById('authcode');
			d.value = '';
			d.focus();
		} catch(e){}
		}, 200);
	</script>
		<?php
	}

	/**
	 * Validates the users input token.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 * @return boolean
	 */
	public static function validate_email_authentication( $user ) {
		if ( ! isset( $user->ID ) || ! isset( $_REQUEST['wp-2fa-email-code'] ) ) {
			return false;
		}
		return Authentication::validate_token( $user->ID, $_REQUEST['wp-2fa-email-code'] );
	}

	/**
	 * Send the email code if missing or requested. Stop the authentication
	 * validation if a new token has been generated and sent.
	 *
	 * @param  WP_USer $user WP_User object of the logged-in user.
	 * @return boolean
	 */
	public static function pre_process_email_authentication( $user ) {
		if ( isset( $user->ID ) && isset( $_REQUEST[ self::INPUT_NAME_RESEND_CODE ] ) ) {
			SetupWizard::send_authentication_setup_email( $user->ID );
			return true;
		}
		return false;
	}

	/**
	 * Prints the form that prompts the user to authenticate.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 */
	public static function backup_codes_authentication_page( $user ) {
		require_once ABSPATH . '/wp-admin/includes/template.php';
		?>
		<p><?php esc_html_e( 'Enter a backup verification code.', 'wp-2fa' ); ?></p><br/>
		<p>
			<label for="authcode"><?php esc_html_e( 'Verification Code:', 'wp-2fa' ); ?></label>
			<input type="tel" name="wp-2fa-backup-code" id="authcode" class="input" value="" size="20" pattern="[0-9]*" />
		</p>
		<?php
		submit_button( __( 'Submit', 'wp-2fa' ) );
	}

	/**
	 * Validates a backup code.
	 *
	 * Backup Codes are single use and are deleted upon a successful validation.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 * @param int     $code The backup code.
	 * @return boolean
	 */
	public static function validate_backup_codes( $user ) {
		if ( ! isset( $user->ID ) || ! isset( $_REQUEST['wp-2fa-backup-code'] ) ) {
			return false;
		}
		return BackupCodes::validate_code( $user, sanitize_text_field( $_POST['wp-2fa-backup-code'] ) );
	}
}
