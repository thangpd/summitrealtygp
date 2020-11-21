<?php // phpcs:ignore

namespace WP2FA;

use WP2FA\Admin\SettingsPage;
use WP2FA\Utils\DateTimeUtils;

/**
 * Main WP2FA Class.
 */
class WP2FA {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = WP_2FA_VERSION;

	/**
	 * Options variables.
	 *
	 * @var array
	 */
	protected static $wp_2fa_options;
	protected static $wp_2fa_email_templates;

	/**
	 * Instance wrapper.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Return plugin instance.
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Contructor.
	 */
	private function __construct() {
		if ( self::is_this_multisite() ) {
			self::$wp_2fa_options         = get_network_option( null, 'wp_2fa_settings' );
			self::$wp_2fa_email_templates = get_network_option( null, 'wp_2fa_email_settings' );
		} else {
			self::$wp_2fa_options         = get_option( 'wp_2fa_settings' );
			self::$wp_2fa_email_templates = get_option( 'wp_2fa_email_settings' );
		}

		// Activation/Deactivation.
		register_activation_hook( WP_2FA_FILE, '\WP2FA\Core\activate' );
		register_deactivation_hook( WP_2FA_FILE, '\WP2FA\Core\deactivate' );
		// Register our uninstallation hook.
		register_uninstall_hook( WP_2FA_FILE, '\WP2FA\Core\uninstall' );
	}

	/**
	 * Fire up classes.
	 */
	public function init() {
		// Bootstrap.
		Core\setup();

		$this->settings        = new Admin\SettingsPage();
		$this->wizard          = new Admin\SetupWizard();
		$this->authentication  = new Authenticator\Authentication();
		$this->backupcodes     = new Authenticator\BackupCodes();
		$this->login           = new Authenticator\Login();
		$this->user_notices    = new Admin\UserNotices();
		$this->crontasks       = new Cron\CronTasks();
		$this->user_registered = new Admin\UserRegistered();
		$this->shortcodes      = new Shortcodes\Shortcodes();
		$this->bg_processing   = new BackgroundProcessing\ProcessUserMetaUpdate();

		global $pagenow;
		if ( 'profile.php' !== $pagenow || 'user-edit.php' !== $pagenow ) {
			$this->user_profiles = new Admin\UserProfile();
		}

		$this->add_actions();
	}

	/**
	 * Add our plugins actions.
	 */
	public function add_actions() {
		// Plugin redirect on activation, only if we have no settings currently saved.
		if ( empty( self::$wp_2fa_options ) || ! isset( self::$wp_2fa_options ) ) {
			add_action( 'admin_init', array( $this, 'setup_redirect' ), 10 );
		}

		// SettingsPage.
		if ( self::is_this_multisite() ) {
			add_action( 'network_admin_menu', array( $this->settings, 'create_settings_admin_menu_multisite' ) );
			add_action( 'network_admin_edit_update_wp2fa_network_options', array( $this->settings, 'update_wp2fa_network_options' ) );
			add_action( 'network_admin_edit_update_wp2fa_network_email_options', array( $this->settings, 'update_wp2fa_network_email_options' ) );
			add_action( 'network_admin_notices', array( $this->settings, 'settings_saved_network_admin_notice' ) );
		} else {
			add_action( 'admin_menu', array( $this->settings, 'create_settings_admin_menu' ) );
		}
		add_action( 'wp_ajax_get_all_users', array( $this->settings, 'get_all_users' ) );
		add_action( 'wp_ajax_get_all_network_sites', array( $this->settings, 'get_all_network_sites' ) );
		add_action( 'wp_ajax_unlock_account', array( $this->settings, 'unlock_account' ), 10, 1 );
		add_action( 'admin_action_unlock_account', array( $this->settings, 'unlock_account' ), 10, 1 );
		add_action( 'admin_action_remove_user_2fa', array( $this->settings, 'remove_user_2fa' ), 10, 1 );
		add_action( 'wp_ajax_remove_user_2fa', array( $this->settings, 'remove_user_2fa' ), 10, 1 );
		add_action( 'admin_menu', array( $this->settings, 'hide_settings' ), 999 );
		add_action( 'plugin_action_links_' . WP_2FA_BASE, array( $this->settings, 'add_plugin_action_links' ) );
		add_filter( 'display_post_states',  array( $this->settings, 'add_display_post_states' ), 10, 2 );

		// SetupWizard.
		if ( self::is_this_multisite() ) {
			add_action( 'network_admin_menu', array( $this->wizard, 'network_admin_menus' ), 10 );
			add_action( 'admin_menu', array( $this->wizard, 'admin_menus' ), 10 );
		} else {
			add_action( 'admin_menu', array( $this->wizard, 'admin_menus' ), 10 );
		}
		add_action( 'plugins_loaded', array( $this, 'add_wizard_actions' ), 10 );
		add_action( 'wp_ajax_send_authentication_setup_email', array( $this->wizard, 'send_authentication_setup_email' ) );
		add_action( 'wp_ajax_regenerate_authentication_key', array( $this->wizard, 'regenerate_authentication_key' ) );

		// UserNotices.
		add_action( 'wp_ajax_dismiss_nag', array( $this->user_notices, 'dismiss_nag' ) );
		add_action( 'wp_ajax_dismiss_nag', array( $this->user_notices, 'dismiss_reconfigure_nag' ) );
		add_action( 'clear_auth_cookie', array( $this->user_notices, 'reset_nag' ) );

		// UserProfile.
		global $pagenow;
		if ( 'profile.php' !== $pagenow || 'user-edit.php' !== $pagenow ) {
			add_action( 'show_user_profile', array( $this->user_profiles, 'user_2fa_options' ) );
			add_action( 'edit_user_profile', array( $this->user_profiles, 'user_2fa_options' ) );
			if ( self::is_this_multisite() ) {
				add_action( 'personal_options_update', array( $this->user_profiles, 'save_user_2fa_options' ) );
			}
		}
		add_filter( 'user_row_actions', array( $this->user_profiles, 'user_2fa_row_actions' ), 10, 2 );
		if ( self::is_this_multisite() ) {
			add_filter( 'ms_user_row_actions', array( $this->user_profiles, 'user_2fa_row_actions' ), 10, 2 );
		}
		add_action( 'wp_ajax_validate_authcode_via_ajax', array( $this->user_profiles, 'validate_authcode_via_ajax' ) );
		add_action( 'wp_ajax_wp2fa_test_email', array( $this, 'handle_send_test_email_ajax' ) );

		// Login.
		add_action( 'init', array( $this->login, 'get_providers' ) );
		add_action( 'wp_login', array( $this->login, 'wp_login' ), 10, 2 );
		add_action( 'login_form_validate_2fa', array( $this->login, 'login_form_validate_2fa' ) );
		add_action( 'login_form_backup_2fa', array( $this->login, 'backup_2fa' ) );

		/**
		 * Keep track of all the user sessions for which we need to invalidate the
		 * authentication cookies set during the initial password check.
		 */
		add_action( 'set_auth_cookie', array( $this->login, 'collect_auth_cookie_tokens' ) );
		add_action( 'set_logged_in_cookie', array( $this->login, 'collect_auth_cookie_tokens' ) );

		// Run only after the core wp_authenticate_username_password() check.
		add_filter( 'authenticate', array( $this->login, 'filter_authenticate' ), 50 );
		add_filter( 'wp_authenticate_user', array( $this->login, 'is_user_locked' ), 10, 2 );

		// User Register.
		add_action( 'set_user_role', array( $this->user_registered, 'check_user_upon_role_change' ), 10, 3 );

		// Block users from admin if needed.
		$user_block_hook = is_admin() || is_network_admin() ? 'init' : 'wp';
		add_action( $user_block_hook, array( $this,  'block_unconfigured_users_from_admin' ), 10 );
	}

	/**
	 * Add actions specific to the wizard.
	 */
	public function add_wizard_actions() {
		new BackgroundProcessing\ProcessUserMetaUpdate();
		if ( function_exists( 'wp_get_current_user' ) && current_user_can( 'read' ) ) {
			add_action( 'admin_init', array( $this->wizard, 'setup_page' ), 10 );
		}
	}

	/**
	 * Redirect user to 1st time setup.
	 */
	public function setup_redirect() {

		// Bail early before the redirect if the user can't manage options.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( get_option( 'wp_2fa_redirect_on_activate', false ) ) {
			// Delete redirect option.
			delete_option( 'wp_2fa_redirect_on_activate' );

			// Redirect URL.
			$redirect = '';

			// If current site is multisite and user is super-admin then redirect to network audit log.
			if ( self::is_this_multisite() && is_super_admin() ) {
				$redirect = add_query_arg( 'page', 'wp-2fa-setup', network_admin_url( 'index.php' ) );
			} else {
				// Otherwise redirect to main audit log view.
				$redirect = add_query_arg( 'page', 'wp-2fa-setup', admin_url( 'options-general.php' ) );
			}
			wp_safe_redirect( $redirect );
			exit();
		}
	}

	/**
	 * Check is this is a multisite setup.
	 */
	public static function is_this_multisite() {
		return function_exists( 'is_multisite' ) && is_multisite();
	}

	/**
	 * Return user roles.
	 *
	 * @return array User roles.
	 */
	public static function wp_2fa_get_roles() {
		global $wp_roles;
		$roles = $wp_roles->role_names;
		return $roles;
	}

	/**
	 * Check to see if the user or user role is excluded.
	 *
	 * @param  int $user_id User id.
	 * @return boolean Is user excluded or not.
	 */
	public static function is_user_excluded( $user_id, $excluded_users = '', $excluded_roles = '', $excluded_sites = '' ) {

		// Check if the $user_id is actually an object, if so lets just use it.
		if ( ! is_a( $user_id, '\WP_User' ) ) {
			if ( isset( $user_id ) ) {
				if ( is_object( $user_id ) && isset( $user_id->ID ) ) {
					$user       = get_userdata( $user_id->ID );
					$user_roles = $user->roles;
				} else {
					$user       = get_user_by( 'id', $user_id );
					$user_roles = $user->roles;
				}
			} elseif ( isset( $_GET['user_id'] ) ) {
				$user_id    = (int) $_GET['user_id'];
				$user       = get_user_by( 'id', $user_id );
				$user_roles = $user->roles;
			} else {
				$user       = wp_get_current_user();
				$user_roles = $user->roles;
			}
		} else {
			$user = $user_id;
			$user_roles = $user->roles;
		}

		$user_excluded = false;

		if ( isset( $excluded_users ) && ! empty( $excluded_users ) ) {
			$excluded_users = $excluded_users;
		} else {
			$excluded_users = WP2FA::get_wp2fa_setting( 'excluded_users' );
		}

		if ( ! empty( $excluded_users ) ) {
			// Turn it into an array.
			$excluded_users_array = explode( ',', $excluded_users );
			// Compare our roles with the users and see if we get a match.
			$result = in_array( $user->user_login, $excluded_users_array, true );
			if ( $result ) {
				$user_excluded = true;
				return true;
			}
		}

		if ( isset( $excluded_roles ) && ! empty( $excluded_roles )  ) {
			$excluded_roles = $excluded_roles;
		} else {
			$excluded_roles = WP2FA::get_wp2fa_setting( 'excluded_roles' );
		}

		if ( ! empty( $excluded_roles ) ) {
			// Turn it into an array.
			$excluded_roles_array = explode( ',', strtolower( $excluded_roles ) );
			// Compare our roles with the users and see if we get a match.
			$result = array_intersect( $excluded_roles_array, $user->roles );
			if ( $result ) {
				$user_excluded = true;
				return true;
			}
		}

		if ( self::is_this_multisite() ) {
			if ( isset( $excluded_sites )  && ! empty( $excluded_sites ) ) {
				$excluded_sites = $excluded_sites;
			} else {
				$excluded_sites = WP2FA::get_wp2fa_setting( 'excluded_sites' );
			}

			if ( ! empty( $excluded_sites ) ) {
				// Turn it into an array.
				$excluded_site_array = explode( ',', strtolower( $excluded_sites ) );
				$site_ids_only       = array();
				// Remove everything but the excluded sites ID, which we will use to check if user is a member.
				foreach ( $excluded_site_array as $excluded_site ) {
					if ( isset( explode( ':', $excluded_site )[1] ) ) {
						$id              = trim( explode( ':', $excluded_site )[1] );
						$site_ids_only[] = $id;
					}
				}
				foreach ( $site_ids_only as $site_id ) {
					if ( is_user_member_of_blog( $user->ID, $site_id ) ) {
						// User is a member of the a blog we are excluding from 2FA.
						$user_excluded = true;
						return true;
					} else {
						// User is NOT a member of the a blog we are excluding.
						$user_excluded = false;
					}
				}
			}
		}

		if ( true === $user_excluded ) {
			return true;
		}

		return false;
	}

	/**
	 * Util function to grab settings or apply defaults if no settings are saved into the db.
	 *
	 * @param  string $setting_name Settings to grab value of.
	 * @return string               Settings value or default value.
	 */
	public static function get_wp2fa_setting( $setting_name = '' ) {
		$default_settings = array(
			'enable_totp'                  => 'enable_totp',
			'enable_email'                 => 'enable_email',
			'enforcment-policy'            => 'do-not-enforce',
			'excluded_users'               => '',
			'excluded_roles'               => '',
			'enforced_users'               => '',
			'enforced_roles'               => '',
			'grace-period'                 => 3,
			'grace-period-denominator'     => 'days',
			'enable_grace_cron'            => '',
			'enable_destroy_session'       => '',
			'limit_access'                 => '',
			'2fa_settings_last_updated_by' => '',
			'2fa_main_user'                => '',
			'grace-period-expiry-time'     => '',
			'plugin_version'               => WP_2FA_VERSION,
			'delete_data_upon_uninstall'   => '',
			'excluded_sites'               => '',
			'create-custom-user-page'      => 'no',
			'custom-user-page-url'         => '',
			'custom-user-page-id'          => '',
			'hide_remove_button'           => '',
			'grace-policy'                 => 'use-grace-period',
		);

		$apply_defaults = false;

		// If we have no setting name, return them all.
		if ( empty( $setting_name ) ) {
			return self::$wp_2fa_options;
		}

		// First lets check if any options have been saved.
		if ( empty( self::$wp_2fa_options ) || ! isset( self::$wp_2fa_options ) ) {
			$apply_defaults = true;
		}

		if ( $apply_defaults ) {
			return $default_settings[ $setting_name ];
		} elseif ( ! isset( self::$wp_2fa_options[ $setting_name ] ) ) {
			return false;
		} else {
			return self::$wp_2fa_options[ $setting_name ];
		}
	}

	/**
	 * Util function to grab EMAIL settings or apply defaults if no settings are saved into the db.
	 *
	 * @param  string $setting_name Settings to grab value of.
	 * @return string               Settings value or default value.
	 */
	public static function get_wp2fa_email_templates( $setting_name = '', $grab_default = '' ) {

		if ( ! empty( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) ) ) {
			// Setup enable 2fa email.
			$enable_2fa_message = sprintf(
				/* translators: %1$s: is the user name, %2$s is the website address */
				'<p>%1$s %2$s %3$s <strong>%4$s</strong> %5$s <strong>%6$s.</strong></p><p>%11$s <a href="%12$s" target="_blank">%12$s.</a></p><p>%7$s</p><p>%8$s</p><p>%9$s <a href="https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/" target="_blank">%10$s</a></p>',
				esc_html__( 'The administrator of the website', 'wp-2fa' ),
				'{site_url}',
				esc_html__( 'enforced two-factor authentication. You have', 'wp-2fa' ),
				'{grace_period}',
				esc_html__( 'to enable and configure 2FA on your WordPress user', 'wp-2fa' ),
				'{user_login_name}',
				esc_html__( 'Failing to enable 2FA within the grace period will result in a locked account. In case that happens contact the website’s administrator.', 'wp-2fa' ),
				esc_html__( 'Thank you.', 'wp-2fa' ),
				esc_html__( 'Email sent by', 'wp-2fa' ),
				esc_html__( 'WP 2FA plugin.', 'wp-2fa' ),
				esc_html__( 'You can configure 2FA from this page:', 'wp-2fa' ),
				'{2fa_settings_page_url}'
			);
		} else {
			// Setup enable 2fa email.
			$enable_2fa_message = sprintf(
				/* translators: %1$s: is the user name, %2$s is the website address */
				'<p>%1$s %2$s %3$s <strong>%4$s</strong> %5$s <strong>%6$s.</strong></p><p>%7$s</p><p>%8$s</p><p>%9$s <a href="https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/" target="_blank">%10$s</a></p>',
				esc_html__( 'The administrator of the website', 'wp-2fa' ),
				'{site_url}',
				esc_html__( 'enforced two-factor authentication. You have', 'wp-2fa' ),
				'{grace_period}',
				esc_html__( 'to enable and configure 2FA on your WordPress user', 'wp-2fa' ),
				'{user_login_name}',
				esc_html__( 'Failing to enable 2FA within the grace period will result in a locked account. In case that happens contact the website’s administrator.', 'wp-2fa' ),
				esc_html__( 'Thank you.', 'wp-2fa' ),
				esc_html__( 'Email sent by', 'wp-2fa' ),
				esc_html__( 'WP 2FA plugin.', 'wp-2fa' )
			);
		}

		$enable_2fa_subject = __( 'Please enable 2FA on {site_url}', 'wp-2fa' );
		$enable_2fa_body    = $enable_2fa_message;

		// Setup login code email.
		$login_code_message = sprintf(
			/* translators: %s: the token for the user to use */
			'<p>%1$s <strong>%2$s</strong> %3$s</p><p>%4$s</p><p>%5$s <a href="https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/" target="_blank">%6$s</a></p>',
			esc_html__( 'Enter', 'wp-2fa' ),
			'{login_code}',
			esc_html__( 'to log in.', 'wp-2fa' ),
			esc_html__( 'Thank you.', 'wp-2fa' ),
			esc_html__( 'Email sent by', 'wp-2fa' ),
			esc_html__( 'WP 2FA plugin.', 'wp-2fa' )
		);

		$login_code_subject = __( 'Your login confirmation code for {site_name}', 'wp-2fa' );
		$login_code_body    = $login_code_message;

		// Setup user locked email.
		$user_locked_message = sprintf(
			/* translators: %1$s: is the user name, %2$s is the website name */
			'<p>%1$s</p><p>%2$s %3$s %4$s %5$s %6$s</p><p>%7$s</p><p>%8$s</p><p>%9$s <a href="https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/" target="_blank">%10$s</a></p>',
			esc_html__( 'Hello.', 'wp-2fa' ),
			esc_html__( 'Since you have not enabled two-factor authentication for the user', 'wp-2fa' ),
			'{user_login_name}',
			esc_html__( 'on the website', 'wp-2fa' ),
			'{site_name}',
			esc_html__( 'within the grace period, your account has been locked.', 'wp-2fa' ),
			esc_html__( 'Contact your website administrator to unlock your account.', 'wp-2fa' ),
			esc_html__( 'Thank you.', 'wp-2fa' ),
			esc_html__( 'Email sent by', 'wp-2fa' ),
			esc_html__( 'WP 2FA plugin.', 'wp-2fa' )
		);

		$user_locked_subject = __( 'Your user on {site_name} has been locked', 'wp-2fa' );
		$user_locked_body    = $user_locked_message;

		if ( ! empty( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) ) ) {
			// Setup user unlocked email.
			$user_unlocked_message = sprintf(
				/* translators: %1$s: is the user name, %2$s is the website address */
				'<p>%1$s</p><p>%2$s <strong>%3$s</strong> %4$s %5$s %6$s</p><p>%10$s <a href="%11$s" target="_blank">%11$s.</a></p><p>%7$s</p><p>%8$s <a href="https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/" target="_blank">%9$s</a></p>',
				esc_html__( 'Hello,', 'wp-2fa' ),
				esc_html__( 'Your user', 'wp-2fa' ),
				'{user_login_name}',
				esc_html__( 'on the website', 'wp-2fa' ),
				'{site_url}',
				esc_html__( 'has been unlocked. Please configure two-factor authentication within the grace period, otherwise your account will be locked again.', 'wp-2fa' ),
				esc_html__( 'Thank you.', 'wp-2fa' ),
				esc_html__( 'Email sent by', 'wp-2fa' ),
				esc_html__( 'WP 2FA plugin', 'wp-2fa' ),
				esc_html__( 'You can configure 2FA from this page:', 'wp-2fa' ),
				'{2fa_settings_page_url}'
			);
		} else {
			// Setup user unlocked email.
			$user_unlocked_message = sprintf(
				/* translators: %1$s: is the user name, %2$s is the website address */
				'<p>%1$s</p><p>%2$s <strong>%3$s</strong> %4$s %5$s %6$s</p><p>%7$s</p><p>%8$s <a href="https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/" target="_blank">%9$s</a></p>',
				esc_html__( 'Hello,', 'wp-2fa' ),
				esc_html__( 'Your user', 'wp-2fa' ),
				'{user_login_name}',
				esc_html__( 'on the website', 'wp-2fa' ),
				'{site_url}',
				esc_html__( 'has been unlocked. Please configure two-factor authentication within the grace period, otherwise your account will be locked again.', 'wp-2fa' ),
				esc_html__( 'Thank you.', 'wp-2fa' ),
				esc_html__( 'Email sent by', 'wp-2fa' ),
				esc_html__( 'WP 2FA plugin', 'wp-2fa' )
			);
		}

		$user_unlocked_subject = __( 'Your user on {site_name} has been unlocked', 'wp-2fa' );
		$user_unlocked_body    = $user_unlocked_message;

		// Array of defaults, now we have things setup above.
		$default_settings = array(
			'email_from_setting'                  => 'use-defaults',
			'custom_from_email_address'           => '',
			'custom_from_display_name'            => '',
			'enforced_email_subject'              => $enable_2fa_subject,
			'enforced_email_body'                 => $enable_2fa_body,
			'login_code_email_subject'            => $login_code_subject,
			'login_code_email_body'               => $login_code_body,
			'user_account_locked_email_subject'   => $user_locked_subject,
			'user_account_locked_email_body'      => $user_locked_body,
			'user_account_unlocked_email_subject' => $user_unlocked_subject,
			'user_account_unlocked_email_body'    => $user_unlocked_body,
			'send_enforced_email'                 => 'enable_enforced_email',
			'send_account_locked_email'           => 'enable_account_locked_email',
			'send_account_unlocked_email'         => 'enable_account_unlocked_email',
		);

		$apply_defaults = false;

		// If we have no setting name, return them all.
		if ( empty( $setting_name ) ) {
			return self::$wp_2fa_email_templates;
		}

		// First lets check if any options have been saved.
		if ( empty( self::$wp_2fa_email_templates ) || ! isset( self::$wp_2fa_email_templates ) ) {
			$apply_defaults = true;
		}

		if ( $apply_defaults || ! empty( $grab_default ) ) {
			return $default_settings[ $setting_name ];
		} elseif ( ! isset( self::$wp_2fa_email_templates[ $setting_name ] ) ) {
			return false;
		} else {
			return self::$wp_2fa_email_templates[ $setting_name ];
		}
	}

	/**
	 * Util which we use to replace our {strings} with actual, useful stuff.
	 *
	 * @param  string $input   Text we are working on.
	 * @param  int|string    $user_id User id, if its needed.
	 * @param  string $token   Login code, if its needed..
	 * @return string          The output, with all the {strings} swapped out.
	 */
	public static function replace_email_strings( $input = '', $user_id = '', $token = '', $override_grace_period = '' ) {

		// Gather grace period.
		$grace_period_string = '';
		if ( isset( $override_grace_period ) && ! empty( $override_grace_period ) ) {
			$grace_period_string = $override_grace_period;
		} else {
			$grace_policy = self::get_wp2fa_setting( 'grace-policy' );
			$grace_period_string = DateTimeUtils::format_grace_period_expiration_string( $grace_policy );
		}

		// Setup user data.
		if ( isset( $user_id ) && ! empty( $user_id ) ) {
			$user = get_userdata( $user_id );
		} else {
			$user = wp_get_current_user();
		}

		// Setup token.
		if ( isset( $token ) && ! empty( $token ) ) {
			$login_code = $token;
		} else {
			$login_code = '';
		}

		$new_page_id = WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
		if ( ! empty( $new_page_id ) ) {
			$new_page_permalink = get_permalink( $new_page_id );
		} else {
			$new_page_permalink = '';
		}

		// These are the strings we are going to search for, as well as there respective replacements.
		$replacements = array(
			'{site_url}'              => esc_url( get_bloginfo( 'url' ) ),
			'{site_name}'             => sanitize_text_field( get_bloginfo( 'name' ) ),
			'{grace_period}'          => sanitize_text_field( $grace_period_string ),
			'{user_login_name}'       => sanitize_text_field( $user->user_login ),
			'{login_code}'            => sanitize_text_field( $login_code ),
			'{2fa_settings_page_url}' => esc_url( $new_page_permalink ),
		);

		$replacements = apply_filters(
			'wp_2fa_replacement_email_strings',
			$replacements
		);

		$final_output = str_replace( array_keys( $replacements ), array_values( $replacements ), $input );
		return $final_output;
	}

	/**
	 * If a user is trying to access anywhere other than the 2FA config area, this blocks them.
	 */
	public function block_unconfigured_users_from_admin() {
		global $pagenow;

		if ( 'use-grace-period' !== WP2FA::get_wp2fa_setting( 'grace-policy' ) ) {
			$user                       = wp_get_current_user();
			$is_user_instantly_enforced = get_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true );
			$grace_period_expiry_time   = get_user_meta( $user->ID, 'wp_2fa_grace_period_expiry', true );
			$time_now                   = time();
			if ( $is_user_instantly_enforced && ! empty( $grace_period_expiry_time ) && $grace_period_expiry_time < $time_now ) {

				/*
				 * We should only allow:
				 * - 2FA setup wizard in the administration
				 * - custom 2FA page if enabled and created
				 * - AJAX requests originating from these 2FA setup UIs
				 */
				if ( wp_doing_ajax() && isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], [ 'send_authentication_setup_email', 'validate_authcode_via_ajax' ] )) {
					return;
				}

				if ( is_admin() || is_network_admin() ) {
					$allowed_admin_page = self::is_this_multisite() ? 'index.php' : 'options-general.php';
					if ( $pagenow === $allowed_admin_page && ( isset( $_GET['page'] ) && $_GET['page'] === 'wp-2fa-setup' ) ) {
						return;
					}
				}

				if ( is_page() ) {
					$custom_user_page_id = \WP2FA\WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
					if ( !empty( $custom_user_page_id ) && get_the_ID() == (int) $custom_user_page_id ) {
						return;
					}
				}

				//  force a redirect to the 2FA set-up page if it exists
				$custom_user_page_id = \WP2FA\WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
				if ( !empty( $custom_user_page_id ) ) {
					wp_redirect( get_permalink($custom_user_page_id) );
					exit;
				}

				//  custom 2FA page is not set-up, force redirect to the wizard in administration
				$url = self::is_this_multisite() ? 'index.php' : 'options-general.php';
				wp_redirect( add_query_arg( [
					'page' => 'wp-2fa-setup'
				], admin_url( $url ) ) );
				exit;
			}
		}
	}

	/**
	 * Handles AJAX calls for sending test emails.
	 */
	public function handle_send_test_email_ajax() {

		//  check user permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		//  check email id
		$email_id = filter_input(INPUT_POST, 'email_id', FILTER_SANITIZE_STRING);
		if ($email_id === null || $email_id === false) {
			wp_send_json_error();
		}

		//  check nonce
		$nonce = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
		if ($nonce === null || $nonce === false || ! wp_verify_nonce($nonce, 'wp-2fa-email-test-' . $email_id)) {
			wp_send_json_error();
		}

		$user_id = get_current_user_id();
		// Grab user data.
		$user = get_userdata( $user_id );
		// Grab user email.
		$email = $user->user_email;

		if ('config_test' === $email_id) {
			$email_sent = SettingsPage::send_email(
				$email,
				esc_html__('Test email from WP 2FA', 'wp-2fa'),
				esc_html__('This email was sent by the WP 2FA plugin to test the email delivery.', 'wp-2fa')
			);
			if ( $email_sent ) {
				wp_send_json_success('Test email was successfully sent to <strong>' . $email . '</strong>' );
			}

			wp_send_json_error();
		}

		/** @var EmailTemplate[] $email_templates */
		$email_templates = $this->settings->get_email_notification_definitions();
		foreach ($email_templates as $email_template) {
			if ($email_id === $email_template->getEmailContentId()) {
				//  send the test email



				// Setup the email contents.
				$subject = wp_strip_all_tags( WP2FA::get_wp2fa_email_templates( $email_id . '_email_subject' ) );
				$message = wpautop( WP2FA::get_wp2fa_email_templates( $email_id . '_email_body' ), $user_id );

				$email_sent = SettingsPage::send_email( $email, $subject, $message );
				if ( $email_sent ) {
					wp_send_json_success('Test email <strong>' . $email_template->getTitle() . '</strong> was successfully sent to <strong>' . $email . '</strong>' );
				}

				wp_send_json_error();
			}
		}
	}
}
