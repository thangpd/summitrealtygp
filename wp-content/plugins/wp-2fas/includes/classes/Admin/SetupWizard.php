<?php // phpcs:ignore

namespace WP2FA\Admin;

use \WP2FA\Authenticator\Authentication as Authentication;
use \WP2FA\WP2FA as WP2FA;
use \WP2FA\Core as Core;
use \WP2FA\BackgroundProcessing\ProcessUserMetaUpdate as ProcessUserMetaUpdate;

/**
 * Our class for creating a step by step wizard for easy configuration.
 */
class SetupWizard {

	/**
	 * Wizard Steps
	 *
	 * @var array
	 */
	private $wizard_steps;

	/**
	 * Current Step
	 *
	 * @var string
	 */
	private $current_step;

	/**
	 * Notices Meta key
	 *
	 * @var array
	 */
	const NOTICES_META_KEY = 'wp_2fa_totp_notices';

	/**
	 * Method: Constructor.
	 */
	public function __construct() { }

	/**
	 * Add setup admin page. This is empty on purpose.
	 */
	public function admin_menus() {
		add_dashboard_page( '', '', 'read', 'wp-2fa-setup', '' );
	}

	public function network_admin_menus() {
		add_dashboard_page( 'index.php', '', 'read', 'wp-2fa-setup', '' );
	}

	/**
	 * Setup Page Start.
	 */
	public function setup_page() {
		// Get page argument from $_GET array.
		$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
		if ( empty( $page ) || 'wp-2fa-setup' !== $page ) {
			return;
		}

		// Clear out any old notices.
		$user = wp_get_current_user();
		delete_user_meta( $user->ID, self::NOTICES_META_KEY );

		// First lets check if any options have been saved.
		$settings_saved = true;
		$settings       = WP2FA::get_wp2fa_setting();
		if ( empty( $settings ) || ! isset( $settings ) ) {
			$settings_saved = false;
		}

		/**
		 * Wizard Steps.
		 */
		$get_array = filter_input_array( INPUT_GET );
		if ( isset( $get_array['wizard_type'] ) ) {
			$wizard_type = sanitize_text_field( $get_array['wizard_type'] );
		} else {
			$wizard_type = '';
		}

		$is_user_forced_to_setup = get_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true );
		if ( ! empty( $is_user_forced_to_setup ) ) {
			add_filter( 'wp_2fa_wizard_default_steps', array( $this, 'wp_2fa_add_intro_step' ) );
		}

		if ( ! empty( $wizard_type ) && 'user_2fa_config' === $get_array['wizard_type'] && current_user_can( 'read' ) ) {

			$wizard_steps = array(
				'user_choose_2fa_method' => array(
					'name'        => esc_html__( 'Choose Method', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_user_choose_method' ),
					'save'        => array( $this, 'wp_2fa_step_user_choose_method_save' ),
					'wizard_type' => 'welcome_wizard',
				),
				'setup_method'           => array(
					'name'        => esc_html__( 'Setup the 2FA method', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_setup_authenticator' ),
					'save'        => array( $this, 'wp_2fa_step_setup_authenticator_save' ),
					'wizard_type' => 'welcome_wizard',
				),
				'backup_codes'           => array(
					'name'        => esc_html__( 'Backup Codes', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_backup_codes' ),
					'save'        => array( $this, 'wp_2fa_step_backup_codes_save' ),
					'wizard_type' => array( 'welcome_wizard', 'backup_codes_wizard' ),
				),
			);

		} elseif ( ! empty( $wizard_type ) && 'backup_codes_config' === $wizard_type && current_user_can( 'read' ) ) {

			$wizard_steps = array(
				'backup_codes' => array(
					'name'        => esc_html__( 'Backup Codes', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_backup_codes' ),
					'save'        => array( $this, 'wp_2fa_step_backup_codes_save' ),
					'wizard_type' => array( 'welcome_wizard', 'backup_codes_wizard' ),
				),
			);

		} elseif ( ! empty( $wizard_type ) && 'user_reconfigure_config' === $wizard_type ) {

			$wizard_steps = array(
				'reconfigure_method' => array(
					'name'        => esc_html__( 'Setup the Authenticator 2FA', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_reconfigure_authenticator' ),
					'save'        => array( $this, 'wp_2fa_step_reconfigure_authenticator_save' ),
					'wizard_type' => 'reconfigure_wizard',
				),
			);

		} elseif ( current_user_can( 'manage_options' ) && ! $settings_saved ) {
			$wizard_steps = array(
				'welcome'               => array(
					'name'        => esc_html__( 'Welcome', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_welcome' ),
					'wizard_type' => 'welcome_wizard',
				),
				'choose_2fa_method'     => array(
					'name'        => esc_html__( 'Choose Method', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_choose_method' ),
					'save'        => array( $this, 'wp_2fa_step_choose_method_save' ),
					'wizard_type' => 'welcome_wizard',
				),
				'setup_method'          => array(
					'name'        => esc_html__( 'Setup the 2FA method', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_setup_authenticator' ),
					'save'        => array( $this, 'wp_2fa_step_setup_authenticator_save' ),
					'wizard_type' => 'welcome_wizard',
				),
				'finish'                => array(
					'name'        => esc_html__( 'Setup Finish', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_finish' ),
					'save'        => array( $this, 'wp_2fa_step_finish_save' ),
					'wizard_type' => 'welcome_wizard',
				),
				'settings_configuation' => array(
					'name'        => esc_html__( 'Select 2FA Methods', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_global_2fa_methods' ),
					'save'        => array( $this, 'wp_2fa_step_global_2fa_methods_save' ),
					'wizard_type' => 'welcome_wizard',
				),
				'backup_codes'          => array(
					'name'        => esc_html__( 'Backup Codes', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_backup_codes' ),
					'save'        => array( $this, 'wp_2fa_step_backup_codes_save' ),
					'wizard_type' => array( 'welcome_wizard', 'backup_codes_wizard' ),
				),
				'reconfigure_method'    => array(
					'name'        => esc_html__( 'Setup the Authenticator 2FA', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_reconfigure_authenticator' ),
					'save'        => array( $this, 'wp_2fa_step_reconfigure_authenticator_save' ),
					'wizard_type' => 'reconfigure_wizard',
				),
			);

		} elseif ( current_user_can( 'read' ) ) {

			$wizard_steps = array(
				'choose_2fa_method'  => array(
					'name'        => esc_html__( 'Choose Method', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_choose_method' ),
					'save'        => array( $this, 'wp_2fa_step_choose_method_save' ),
					'wizard_type' => 'welcome_wizard',
				),
				'setup_method'       => array(
					'name'        => esc_html__( 'Setup the 2FA method', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_setup_authenticator' ),
					'save'        => array( $this, 'wp_2fa_step_setup_authenticator_save' ),
					'wizard_type' => 'welcome_wizard',
				),
				'backup_codes'       => array(
					'name'        => esc_html__( 'Backup Codes', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_backup_codes' ),
					'save'        => array( $this, 'wp_2fa_step_backup_codes_save' ),
					'wizard_type' => array( 'welcome_wizard', 'backup_codes_wizard' ),
				),
				'reconfigure_method' => array(
					'name'        => esc_html__( 'Setup the Authenticator 2FA', 'wp-2fa' ),
					'content'     => array( $this, 'wp_2fa_step_reconfigure_authenticator' ),
					'save'        => array( $this, 'wp_2fa_step_reconfigure_authenticator_save' ),
					'wizard_type' => 'reconfigure_wizard',
				),
			);

		}

		/**
		 * Filter: `Wizard Default Steps`
		 *
		 * WSAL filter to filter wizard steps before they are displayed.
		 *
		 * @param array $wizard_steps – Wizard Steps.
		 */
		$this->wizard_steps = apply_filters( 'wp_2fa_wizard_default_steps', $wizard_steps );

		// Set current step.
		$current_step       = filter_input( INPUT_GET, 'current-step', FILTER_SANITIZE_STRING );
		$this->current_step = ! empty( $current_step ) ? $current_step : current( array_keys( $this->wizard_steps ) );

		/**
		 * Enqueue Scripts.
		 */
		wp_enqueue_style(
			'wp_2fa_setup_wizard',
			Core\style_url( 'setup-wizard', 'admin' ),
			array(),
			WP_2FA_VERSION
		);

		wp_enqueue_style(
			'wp_2fa_admin',
			Core\style_url( 'admin-style', 'admin' ),
			array(),
			WP_2FA_VERSION
		);

		wp_enqueue_script(
			'wp_2fa_admin',
			Core\script_url( 'admin', 'admin' ),
			array( 'jquery-ui-widget', 'jquery-ui-core', 'jquery-ui-autocomplete' ),
			WP_2FA_VERSION,
			true
		);

		wp_enqueue_script(
			'wp_2fa_micromodal',
			Core\script_url( 'micro-modal', 'admin' ),
			WP_2FA_VERSION,
			true
		);

		// Data array.
		$data_array = array(
			'ajaxURL' => admin_url( 'admin-ajax.php' ),
			'roles'   => WP2FA::wp_2fa_get_roles(),
			'nonce'   => wp_create_nonce( 'wp-2fa-settings-nonce' )
		);
		wp_localize_script( 'wp_2fa_admin', 'wp2faData', $data_array );

		// Data array.
		$data_array = array(
			'ajaxURL'        => admin_url( 'admin-ajax.php' ),
			'nonce'          => wp_create_nonce( 'wp2fa-verify-wizard-page' ),
			'codesPreamble'  => esc_html__( 'These are the 2FA backup codes for the user', 'wp-2fa' ),
			'readyText'      => esc_html__( 'I\'m ready', 'wp-2fa' ),
			'codeReSentText' => esc_html__( 'New code sent', 'wp-2fa' ),
		);
		wp_localize_script( 'wp_2fa_admin', 'wp2faWizardData', $data_array );

		/**
		 * Save Wizard Settings.
		 */
		$save_step = filter_input( INPUT_POST, 'save_step', FILTER_SANITIZE_STRING );
		if ( ! empty( $save_step ) && ! empty( $this->wizard_steps[ $this->current_step ]['save'] ) ) {
			call_user_func( $this->wizard_steps[ $this->current_step ]['save'] );
		}

		$this->setup_page_header();
		$this->setup_page_steps();
		$this->setup_page_content();
		$this->setup_page_footer();

		exit;
	}

	/**
	 * Setup Page Header.
	 */
	private function setup_page_header() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<head>
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title><?php esc_html_e( 'WP 2FA &rsaquo; Setup Wizard', 'wp-2fa' ); ?></title>
			<?php wp_print_scripts( 'jquery' ); ?>
			<?php wp_print_scripts( 'jquery-ui-core' ); ?>
			<?php wp_print_scripts( 'wp_2fa_setup_wizard' ); ?>
			<?php wp_print_scripts( 'wp_2fa_micromodal' ); ?>
			<?php wp_print_scripts( 'wp_2fa_admin' ); ?>
			<?php wp_print_styles( 'common' ); ?>
			<?php wp_print_styles( 'forms' ); ?>
			<?php wp_print_styles( 'buttons' ); ?>
			<?php wp_print_styles( 'wp-jquery-ui-dialog' ); ?>
			<?php wp_print_styles( 'wp_2fa_admin' ); ?>
			<?php do_action( 'admin_print_styles' ); ?>
		</head>
		<body class="wp2fa-setup wp-core-ui">
			<div class="setup-wizard-wrapper">
				<h1 id="wp2fa-logo"><a href="https://wpsecurityauditlog.com" target="_blank"><img src="<?php echo esc_url( WP_2FA_URL . '/dist/images/wizard-logo.png' ); ?>"></a></h1>
		<?php
	}

	/**
	 * Setup Page Footer.
	 */
	private function setup_page_footer() {
		$user  = wp_get_current_user();
		$roles = (array) $user->roles;

		$redirect = get_edit_profile_url( $user->ID );
		?>
		<div class="wp2fa-setup-footer">
			<?php if ( 'welcome' !== $this->current_step && 'finish' !== $this->current_step ) : // Don't show the link on the first & last step. ?>
				<?php if ( ! get_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true ) ) : ?>
					<a class="close-wizard-link" href="<?php echo esc_url( $redirect ); ?>"><?php esc_html_e( 'Close Wizard', 'wp-2fa' ); ?></a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		</div>
		<div class="wp2fa-modal micromodal-slide" id="confirm-change-2fa" aria-hidden="true">
			<div class="modal__overlay" tabindex="-1" data-micromodal-close>
				<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
				<header class="modal__header">
					<h2 class="modal__title" id="modal-1-title">
					<?php esc_html_e( 'Change 2FA Method?', 'wp-2fa' ); ?>
					</h2>
					<button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
				</header>
				<main class="modal__content" id="modal-1-content">
					<p>
						<?php esc_html_e( 'By switching to a new method the previously used method will be disabled.', 'wp-2fa' ); ?>
					</p>
				</main>
				<footer class="modal__footer">
					<a href="#" class="modal__btn modal__btn-primary" data-trigger-submit-form><?php esc_html_e( 'OK', 'wp-2fa' ); ?></a>
					<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'No thanks', 'wp-2fa' ); ?></button>
				</footer>
				</div>
			</div>
		</div>
		</body>
		</html>
		<?php
	}

	/**
	 * Setup Page Steps.
	 */
	private function setup_page_steps() {
		?>
		<ul class="steps">
			<?php
			foreach ( $this->wizard_steps as $key => $step ) :
				if ( 'welcome_wizard' === $step['wizard_type'] || is_array( $step['wizard_type'] ) && in_array( 'welcome_wizard', $step['wizard_type'], true ) ) :
					if ( $key === $this->current_step ) :
						?>
						<li class="is-active"><?php echo esc_html( $step['name'] ); ?></li>
						<?php
									else :
										?>
						<li><?php echo esc_html( $step['name'] ); ?></li>
										<?php
									endif;
				endif;
			endforeach;
			?>
		</ul>
		<?php
	}

	/**
	 * Get Next Step URL.
	 *
	 * @return string
	 */
	private function get_next_step() {
		// Get current step.
		$current_step = $this->current_step;

		// Array of step keys.
		$keys = array_keys( $this->wizard_steps );
		if ( end( $keys ) === $current_step ) { // If last step is active then return WP Admin URL.
			return admin_url();
		}

		// Search for step index in step keys.
		$step_index = array_search( $current_step, $keys, true );
		if ( false === $step_index ) { // If index is not found then return empty string.
			return '';
		}

		// Return next step.
		return add_query_arg( 'current-step', $keys[ $step_index + 1 ] );
	}

	/**
	 * Setup Page Content.
	 */
	private function setup_page_content() {
		?>
		<div class="wp2fa-setup-content">
			<?php
			if ( ! empty( $this->wizard_steps[ $this->current_step ]['content'] ) ) {
				call_user_func( $this->wizard_steps[ $this->current_step ]['content'] );
			}
			?>
		</div>
		<?php
	}

	/**
	 * Step View: `Welcome`
	 */
	private function wp_2fa_step_welcome() {
		// Grab current user.
		$user = wp_get_current_user();

		if ( WP2FA::is_this_multisite() ) {
			$redirect = add_query_arg( 'page', 'wp-2fa-settings', network_admin_url( 'settings.php' ) );
		} else {
			// Otherwise redirect to main audit log view.
			$redirect = add_query_arg( 'page', 'wp-2fa-settings', admin_url( 'options-general.php' ) );
		}

		?>
		<h3><?php esc_html_e( 'Let us help you get started', 'wp-2fa' ); ?></h3>
		<p><?php esc_html_e( 'Thank you for installing WP 2FA. This wizard will assist you setup two-factor authentication (2FA) for your WordPress user and configure the plugin’s generic settings.', 'wp-2fa' ); ?></p>

		<div class="wp2fa-setup-actions">
			<a class="button button-primary"
				href="<?php echo esc_url( $this->get_next_step() ); ?>">
				<?php esc_html_e( 'Let’s get started!', 'wp-2fa' ); ?>
			</a>
			<a class="button button-secondary"
				href="<?php echo esc_url( $redirect ); ?>">
				<?php esc_html_e( 'Skip Wizard - I know how to do this', 'wp-2fa' ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Step View: `Choose Methods`
	 */
	private function wp_2fa_step_choose_method() {
		?>
		<form method="post" class="wp2fa-setup-form" autocomplete="off">
			<?php wp_nonce_field( 'wp2fa-step-choose-method' ); ?>

			<?php
			// Change text if this is the user configuring there 2fa settings
			// Filter $_GET array for security.
			$get_array = filter_input_array( INPUT_GET );
			// If this is the user setting things up, lets show nice message.
			if ( isset( $get_array['first_time_setup'] ) ) {
				if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_totp' ) ) && ! empty( WP2FA::get_wp2fa_setting( 'enable_email' ) ) ) {
					$intro_text = esc_html__( 'Let’s get started; Choose the two-factor authentication method', 'wp-2fa' );
					$sub_text   = esc_html__( 'There are two methods available from which you can choose for 2FA:', 'wp-2fa' );
				} else {
					$intro_text = esc_html__( 'Let’s get started', 'wp-2fa' );
					$sub_text   = esc_html__( 'Only the below 2FA method is allowed on this website:', 'wp-2fa' );
				}
				?>
				<h3><?php echo sanitize_text_field( $intro_text ); ?></h3>
				<p><?php echo sanitize_text_field( $sub_text ); ?></p>
			<?php } else { ?>
				<h3><?php esc_html_e( 'Choose the 2FA authentication method', 'wp-2fa' ); ?></h3>
				<p><?php esc_html_e( 'There are two methods available from which you can choose for 2FA:', 'wp-2fa' ); ?></p>
			<?php } ?>

			<fieldset>
				<?php if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_totp' ) ) ) { ?>
					<div class="option-pill">
						<label for="basic">
							<input id="basic" name="wp_2fa_enabled_methods" type="radio" value="totp" checked>
							<?php esc_html_e( 'One-time code generated with your app of choice (most reliable and secure)', 'wp-2fa' ); ?>
						</label>
							<?php
								printf( '<p class="description">%1$s <a href="https://www.wpwhitesecurity.com/support/kb/configuring-2fa-apps/" target="_blank">%2$s</a> %3$s</p>', esc_html__( 'Note: This method requires you to install one of the following 2FA apps: Google Authenticator, FreeOTP, Microsoft Authenticator, Duo Security, Authy, LastPass and Okta Verify. All of these apps are free and can be downloaded from the Google Play and Apple Appstore. Read our guides on', 'wp-2fa' ), esc_html__( 'our knowledge base', 'wp-2fa' ), esc_html__( 'for more information on how to setup these apps.', 'wp-2fa' ) );
							?>
					</div>
				<?php } ?>
				<?php if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_email' ) ) ) { ?>
					<div class="option-pill">
						<label for="geek">
							<input id="geek" name="wp_2fa_enabled_methods" type="radio" value="email">
							<?php esc_html_e( 'One-time code sent to you over email', 'wp-2fa' ); ?>
						</label>
					</div>
				<?php } ?>
			</fieldset>
			<div class="wp2fa-setup-actions">
				<button class="button button-primary" type="submit" name="save_step" value="<?php esc_attr_e( 'Next', 'wp-2fa' ); ?>"><?php esc_html_e( 'Next', 'wp-2fa' ); ?></button>
			</div>
		</form>
		<?php
	}

	/**
	 * Step Save: `Choose Method`
	 */
	private function wp_2fa_step_choose_method_save() {
		// Check nonce.
		check_admin_referer( 'wp2fa-step-choose-method' );

		// Grab current user.
		$user = wp_get_current_user();

		// Add our enabled methods to the user metadata.
		if ( isset( $_POST['wp_2fa_enabled_methods'] ) ) {
			$next = add_query_arg( 'enabled_methods', sanitize_text_field( wp_unslash( $_POST['wp_2fa_enabled_methods'] ) ), $this->get_next_step() );
			wp_safe_redirect( esc_url_raw( $next ) );
		}

		exit();
	}

	/**
	 * Choose user 2FA method
	 */
	private function wp_2fa_step_user_choose_method() {
		$user           = wp_get_current_user();
		$enabled_method = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );

		?>
		<form id="wp2fa-setup-form" method="post" class="wp2fa-setup-form" autocomplete="off">
			<?php wp_nonce_field( 'wp2fa-step-choose-method' ); ?>

			<?php
			$nonce = wp_create_nonce( 'wp-2fa-backup-codes-generate-json-' . $user->ID );
			// Change text if this is the user configuring there 2fa settings
			// Filter $_GET array for security.
			$get_array = filter_input_array( INPUT_GET );
			// If this is the user setting things up, lets show nice message.
			if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_totp' ) ) && ! empty( WP2FA::get_wp2fa_setting( 'enable_email' ) ) ) {
				$intro_text = esc_html__( 'Choose the 2FA authentication method', 'wp-2fa' );
				$sub_text   = esc_html__( 'There are two methods available from which you can choose for 2FA:', 'wp-2fa' );
			} else {
				$intro_text = esc_html__( 'Choose the 2FA authentication method', 'wp-2fa' );
				$sub_text   = esc_html__( 'Only the below 2FA method is allowed on this website:', 'wp-2fa' );
			}
			?>
			<h3><?php echo sanitize_text_field( $intro_text ); ?></h3>
			<p><?php echo sanitize_text_field( $sub_text ); ?></p>

			<fieldset>
				<?php
				if ( 'totp' === $enabled_method ) {
					?>
					<div class="option-pill">
						<label for="basic">
							<input id="basic" name="wp_2fa_enabled_methods" type="radio" value="totp" checked>
							<?php esc_html_e( 'Reconfigure the 2FA App', 'wp-2fa' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Click the below button to reconfigure the current 2FA method. Note that once reset  reset you will have to re-scan the QR code on all devices you want this to work on because the previous codes will stop working.', 'wp-2fa' ); ?>
						</p>
						<button class="button button-primary" data-trigger-reset-key data-nonce="<?php echo esc_attr( $nonce ); ?>" data-user-id="<?php echo esc_attr( $user->ID ); ?>" type="submit" name="save_step" value="<?php esc_attr_e( 'Reset', 'wp-2fa' ); ?>"><?php esc_html_e( 'Reset', 'wp-2fa' ); ?></button>
					</div>
					<div class="option-pill">
						<p class="description">
							<label for="geek">
								<input id="email" name="wp_2fa_enabled_methods" type="radio" value="email">
								<?php esc_html_e( 'One-time code sent to you over email', 'wp-2fa' ); ?>
							</label>
						</p>
						<a href="#" class="button button-primary change-2fa-confirm" onclick="MicroModal.show('confirm-change-2fa');" data-check-on-click="#email"><?php esc_html_e( 'Configure and use this method instead', 'wp-2fa' ); ?></a>
						<button class="button button-primary change-2fa-confirm hidden" type="submit" name="save_step" value="<?php esc_attr_e( 'Configure and use this method instead', 'wp-2fa' ); ?>"><?php esc_html_e( 'Submit', 'wp-2fa' ); ?></button>
					</div>
					<?php
				}
				if ( 'email' === $enabled_method ) {
					?>
					<div class="option-pill">
						<p class="description">
							<label for="geek">
								<input id="geek" name="wp_2fa_enabled_methods" type="radio" value="email" checked>
								<?php esc_html_e( 'Reconfigure the email address for email 2FA', 'wp-2fa' ); ?>
							</label>
						</p>
						<button class="button button-primary" type="submit" name="save_step" value="<?php esc_attr_e( 'Reconfigure email 2FA', 'wp-2fa' ); ?>"><?php esc_html_e( 'Reconfigure email 2FA', 'wp-2fa' ); ?></button>
					</div>
					<div class="option-pill">
						<p class="description">
							<label for="wp_2fa_enabled_methods">
								<input id="totp" name="wp_2fa_enabled_methods" type="radio" value="totp">
								<?php esc_html_e( 'One-time code generated with your app of choice (most reliable and secure)', 'wp-2fa' ); ?>
							</label>
						</p>
						<a href="#" class="button button-primary change-2fa-confirm" onclick="MicroModal.show('confirm-change-2fa');" data-check-on-click="#totp"><?php esc_html_e( 'Configure and use this method instead', 'wp-2fa' ); ?></a>
						<button class="button button-primary change-2fa-confirm hidden" type="submit" name="save_step" value="<?php esc_attr_e( 'Configure and use this method instead', 'wp-2fa' ); ?>"><?php esc_html_e( 'Submit', 'wp-2fa' ); ?></button>
					</div>
					<?php
				}
				?>
			</fieldset>
			<div class="wp2fa-setup-actions"></div>
		</form>
		<?php
	}

	/**
	 * Step Save: `Choose Method`
	 */
	private function wp_2fa_step_user_choose_method_save() {
		// Check nonce.
		check_admin_referer( 'wp2fa-step-choose-method' );

		// Grab current user.
		$user = wp_get_current_user();

		// Add our enabled methods to the user metadata.
		if ( isset( $_POST['wp_2fa_enabled_methods'] ) ) {
			$next = add_query_arg( 'enabled_methods', sanitize_text_field( wp_unslash( $_POST['wp_2fa_enabled_methods'] ) ), $this->get_next_step() );
			wp_safe_redirect( esc_url_raw( $next ) );
		}

		exit();
	}

	/**
	 * Step View: `Setup Authenticator`
	 */
	private function wp_2fa_step_setup_authenticator() {
		// Grab current user.
		$user = wp_get_current_user();

		// Grab key from user meta.
		$key            = Authentication::get_user_totp_key( $user->ID );
		$enabled_method = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );

		// If no key is present, lets make one.
		if ( empty( $key ) ) {
			$key    = Authentication::generate_key();
			$update = update_user_meta( $user->ID, 'wp_2fa_totp_key', $key );
		}

		// Setup site information, used when generating our QR code.
		$site_name  = get_bloginfo( 'name', 'display' );
		$totp_title = apply_filters( 'wp_2fa_totp_title', $site_name . ':' . $user->user_login, $user );

		// Now lets grab the users enabled 2fa methods.
		$get_array       = filter_input_array( INPUT_GET );
		if ( isset( $_REQUEST['enabled_method'] ) ) {
			$selected_method = $_REQUEST['enabled_method'];
		} else {
			$selected_method = $get_array['enabled_methods'];
		}


		// Create a nonce incase we want to reset the key.
		$nonce = wp_create_nonce( 'wp-2fa-backup-codes-generate-json-' . $user->ID );

		// Grab notices.
		$notices = get_user_meta( $user->ID, self::NOTICES_META_KEY, true );

		if ( ! isset( $notices['error'] ) && empty( $notices['error'] ) ) {
			$is_active  = 'active';
			$is_active2 = '';
		} else {
			$is_active  = '';
			$is_active2 = 'active';
		}

		// TOTP is enabled for the user, so lets display the relevant steps.
		// Here we wrap each "sub step" (a step within a step) in .tep-setting-wrapper, and nudge to next "sub step" with next_step_setting button.
		if ( 'totp' === $selected_method ) {
			?>
			<div class="step-setting-wrapper <?php echo esc_attr( $is_active ); ?>" data-step-title="<?php esc_html_e( 'Download authenticator', 'wp-2fa' ); ?>">
				<h3><?php esc_html_e( 'Setup the 2FA method', 'wp-2fa' ); ?></h3>
				<div class="option-pill">
					<img class="qr-code" src="<?php echo esc_url( Authentication::get_google_qr_code( $totp_title, $key, $site_name ) ); ?>" id="wp-2fa-totp-qrcode" />
					<ol>
						<li><?php esc_html_e( 'Download the app of your choice', 'wp-2fa' ); ?></li>
						<li><?php esc_html_e( 'Scan the QR code to the right.', 'wp-2fa' ); ?></li>
					</ol>
					<p><?php esc_html_e( 'Otherwise, select Enter a provided key and type in the key below:', 'wp-2fa' ); ?></p>
					<code class="app-key"><?php echo esc_html( $key ); ?></code>
				</div>
				<br>
				<br>
				<br>
				<br>
				<h4><?php esc_html_e( 'For detailed guides for your desired app, click below.', 'wp-2fa' ); ?></h4>
				<div class="apps-wrapper">
				<?php foreach (Authentication::getApps() as $app): ?>
				<a href="https://www.wpwhitesecurity.com/support/kb/configuring-2fa-apps/#<?php $app['hash']; ?>" target="_blank" class="app-logo"><img style="max-width: 95px;" src="<?php echo esc_url( WP_2FA_URL . '/dist/images/' . $app['logo'] ); ?>"></a>
				<?php endforeach; ?>
				</div>
				<div class="wp2fa-setup-actions">
					<button class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'I\'m Ready', 'wp-2fa' ); ?>"><?php esc_html_e( 'I\'m Ready', 'wp-2fa' ); ?></button>
				</div>
			</div>

			<div class="step-setting-wrapper <?php echo esc_attr( $is_active2 ); ?>" data-step-title="<?php esc_html_e( 'Verify configuration', 'wp-2fa' ); ?>">
				<form method="post" class="wp2fa-setup-form" autocomplete="off">
					<?php wp_nonce_field( 'wp2fa-step-login' ); ?>
					<h3><?php esc_html_e( 'Almost there…', 'wp-2fa' ); ?></h3>
					<p><?php esc_html_e( 'Please type in the one-time code from your Google Authenticator app to finalize the setup.', 'wp-2fa' ); ?></p>
					<fieldset>
						<label for="2fa-totp-authcode">
							<?php esc_html_e( 'Authentication Code:', 'wp-2fa' ); ?>
							<input type="tel" name="wp-2fa-totp-authcode" id="wp-2fa-totp-authcode" class="input" value="" size="20" pattern="[0-9]*" />
						</label>
					</fieldset>
					<input type="hidden" name="wp-2fa-totp-key" value="<?php echo esc_attr( $key ); ?>" />
					<div class="wp2fa-setup-actions">
						<button class="button button-primary" type="submit" name="save_step" value="<?php esc_attr_e( 'Finish', 'wp-2fa' ); ?>"><?php esc_html_e( 'Finish', 'wp-2fa' ); ?></button>
					</div>
				</form>
			</div>

			<?php
			// Display any error notices if they are available.
			if ( isset( $notices['error'] ) && ! empty( $notices['error'] ) ) {
				foreach ( $notices['error'] as $notice ) {
					echo '<p class="description error">' . wp_kses_post( $notice ) . '</p>';
				}
			}
		} elseif ( 'email' === $selected_method ) {
			$setupnonce = wp_create_nonce( 'wp-2fa-send-setup-email' );
			?>
			<div class="step-setting-wrapper <?php echo esc_attr( $is_active ); ?>"  data-step-title="<?php esc_html_e( 'Configure email', 'wp-2fa' ); ?>">
				<h3><?php esc_html_e( 'Setup the 2FA method', 'wp-2fa' ); ?></h3>
				<p>
					<?php esc_html_e( 'Please select the email address where the one-time code should be sent:', 'wp-2fa' ); ?>
				</p>
				<fieldset>
					<label for="use_wp_email">
						<input type="radio" name="wp_2fa_email_address" id="use_wp_email" value="<?php echo esc_attr( $user->user_email ); ?>" checked>
						<span><?php esc_html_e( 'Use my WordPress user email (', 'wp-2fa' ); ?><small><?php echo esc_attr( $user->user_email ); ?></small><?php esc_html_e( ')', 'wp-2fa' ); ?></span>
					</label>
					<br/>
					<label for="use_custom_email">
						<input type="radio" name="wp_2fa_email_address" id="use_custom_email" value="use_custom_email">
						<span><?php esc_html_e( 'Use a different email address:', 'wp-2fa' ); ?></span>
						<input type="email" name="custom-email-address" id="custom-email-address" class="input wide" value=""/>
					</label>
				</fieldset>
				<p class="description"><?php esc_html_e( 'Note: you should be able to access the mailbox of the email address to complete the following step.', 'wp-2fa' ); ?></p>
				<div class="wp2fa-setup-actions">
					<button class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'I\'m Ready', 'wp-2fa' ); ?>" data-trigger-setup-email data-user-id="<?php echo esc_attr( $user->ID ); ?>" data-nonce="<?php echo esc_attr( $setupnonce ); ?>"><?php esc_html_e( 'I\'m Ready', 'wp-2fa' ); ?></button>
				</div>
			</div>

			<div class="step-setting-wrapper <?php echo esc_attr( $is_active2 ); ?>"  data-step-title="<?php esc_html_e( 'Verify configuration', 'wp-2fa' ); ?>">
				<form method="post" class="wp2fa-setup-form" autocomplete="off">
					<?php wp_nonce_field( 'wp2fa-step-login' ); ?>
					<h4><?php esc_html_e( 'Almost there…', 'wp-2fa' ); ?></h4>
					<p><?php esc_html_e( 'Please type in the one-time code sent to your email address to finalize the setup.', 'wp-2fa' ); ?></p>
					<fieldset>
						<label for="2fa-email-authcode">
							<?php esc_html_e( 'Authentication Code:', 'wp-2fa' ); ?>
							<input type="tel" name="wp-2fa-email-authcode" id="wp-2fa-email-authcode" class="input" value="" size="20" pattern="[0-9]*" />
						</label>
					</fieldset>

					<input type="hidden" name="wp-2fa-totp-key" value="<?php echo esc_attr( $key ); ?>" />
					<div class="wp2fa-setup-actions">
						<button class="button button-primary" type="submit" name="save_step" value="<?php esc_attr_e( 'Finish', 'wp-2fa' ); ?>"><?php esc_html_e( 'Finish', 'wp-2fa' ); ?></button>
						<a href="#" class="button button-secondary resend-email-code" data-trigger-setup-email data-user-id="<?php echo esc_attr( $user->ID ); ?>" data-nonce="<?php echo esc_attr( $setupnonce ); ?>">
							<span class="resend-inner"><?php esc_html_e( 'Send me another code', 'wp-2fa' ); ?></span>
						</a>
					</div>
				</form>
			</div>
			<?php
			// Display any error notices if they are available.
			if ( isset( $notices['error'] ) && ! empty( $notices['error'] ) ) {
				foreach ( $notices['error'] as $notice ) {
					echo '<p class="description error">' . wp_kses_post( $notice ) . '</p>';
				}
			}
		}
	}

	/**
	 * Step Save: `Setup Authenticator`
	 */
	private function wp_2fa_step_setup_authenticator_save() {
		// Check nonce.
		check_admin_referer( 'wp2fa-step-login' );

		// Grab current user.
		$user = wp_get_current_user();

		// Setup some empty arrays which will may fill later, should an error arise along the way.
		$notices = array();
		$errors  = array();

		// Grab key from the $_POST.
		if ( isset( $_POST['wp-2fa-totp-key'] ) ) {
			$current_key = sanitize_text_field( wp_unslash( $_POST['wp-2fa-totp-key'] ) );
		}

		// Grab authcode and ensure its a number.
		if ( isset( $_POST['wp-2fa-totp-authcode'] ) ) {
			$_POST['wp-2fa-totp-authcode'] = (int) $_POST['wp-2fa-totp-authcode'];
		}

		// Check if we are dealing with totp or email, if totp validate and store a new secret key.
		if ( ! empty( $_POST['wp-2fa-totp-authcode'] ) && ! empty( $current_key ) ) {
			if ( Authentication::is_valid_key( $current_key ) || ! is_numeric( $_POST['wp-2fa-totp-authcode'] ) ) {
				if ( ! Authentication::is_valid_authcode( $current_key, sanitize_text_field( wp_unslash( $_POST['wp-2fa-totp-authcode'] ) ) ) ) {
					$errors[] = esc_html__( 'Invalid Two Factor Authentication code.', 'wp-2fa' );
				}
			} else {
				$errors[] = esc_html__( 'Invalid Two Factor Authentication secret key.', 'wp-2fa' );
			}

			// If its not totp, is it email.
		} elseif ( ! empty( $_POST['wp-2fa-email-authcode'] ) ) {
			if ( ! Authentication::validate_token( $user->ID, sanitize_text_field( wp_unslash( $_POST['wp-2fa-email-authcode'] ) ) ) ) {
				$errors[] = __( 'Invalid Email Authentication code.', 'wp-2fa' );
			}
		} else {
			$errors[] = __( 'Please enter the code to finalize the 2FA setup.', 'wp-2fa' );
		}

		if ( ! empty( $errors ) ) {
			$notices['error'] = $errors;
		}

		if ( ! empty( $notices ) ) {
			update_user_meta( $user->ID, self::NOTICES_META_KEY, $notices );
		}

		// If no errors found, lets continue to next step and clear the notices, should any be present from previous attempts.
		if ( empty( $notices ) ) {
			if ( isset( $_POST['use_wp_email'] ) ) {
				update_user_meta( $user->ID, 'wp_2fa_nominated_email_address', $user->user_email );
			} elseif ( isset( $_POST['use_custom_email'] ) && isset( $_POST['custom-email-address'] ) ) {
				update_user_meta( $user->ID, 'wp_2fa_nominated_email_address', sanitize_email( wp_unslash( $_POST['custom-email-address'] ) ) );
			}

			// Now lets grab the users enabled 2fa methods.
			$get_array       = filter_input_array( INPUT_GET );
			$selected_method = sanitize_text_field( $get_array['enabled_methods'] );
			// Check its one of our options.
			if ( 'totp' === $selected_method || 'email' === $selected_method ) {
				update_user_meta( $user->ID, 'wp_2fa_enabled_methods', sanitize_text_field( wp_unslash( $selected_method ) ) );
				delete_user_meta( $user->ID, 'wp_2fa_grace_period_expiry' );
				delete_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly' );
			}

			wp_safe_redirect( esc_url_raw( $this->get_next_step() ) );
			exit();
		}
	}

	/**
	 * Step View: `Finish`
	 */
	private function wp_2fa_step_finish() {
		?>

		<?php
		$get_array = filter_input_array( INPUT_GET );
		if ( isset( $get_array['first_time_setup'] ) ) {
			$first_time_setup = sanitize_text_field( $get_array['first_time_setup'] );
		} else {
			$first_time_setup = '';
		}
		$user = wp_get_current_user();

		$redirect = get_edit_profile_url( $user->ID );
		if ( ! empty( $first_time_setup ) ) :
			?>
		<h3><?php esc_html_e( 'Your login just got more secure', 'wp-2fa' ); ?></h3>
		<p><?php esc_html_e( 'Congratulations! You have enabled two-factor authentication for your user. You’ve just helped towards making this website more secure!', 'wp-2fa' ); ?></p>

			<p><?php esc_html_e( 'You can exit this wizard now or continue to create backup codes.', 'wp-2fa' ); ?></p>

			<form method="post" class="wp2fa-setup-form" autocomplete="off">
				<?php wp_nonce_field( 'wp2fa-step-finish' ); ?>
				<div class="wp2fa-setup-actions">
					<a class="button button-primary" href="<?php echo esc_url( admin_url( 'options-general.php?page=wp-2fa-setup&current-step=backup_codes' ) ); ?>">
						<?php esc_html_e( 'Continue & configure backup codes', 'wp-2fa' ); ?>
					</a>
					<a href="<?php echo esc_url( $redirect ); ?>" class="button button-secondary">
						<?php esc_html_e( 'Close wizard, I’ll configure them later', 'wp-2fa' ); ?>
					</a>
				</div>
			</form>

		<?php else : ?>

			<h3><?php esc_html_e( 'Your website just got more secure!', 'wp-2fa' ); ?></h3>
			<p><?php esc_html_e( 'Congratulations! You have enabled two-factor authentication for your user. You’ve just helped towards making this website more secure!', 'wp-2fa' ); ?></p>

			<p><?php esc_html_e( 'You can exit this wizard now or continue to configure the plugin’s general settings. ', 'wp-2fa' ); ?></p>

			<form method="post" class="wp2fa-setup-form" autocomplete="off">
				<?php wp_nonce_field( 'wp2fa-step-finish' ); ?>
				<div class="wp2fa-setup-actions">
					<button class="button button-primary" type="submit" name="save_step" value="<?php esc_attr_e( 'Continue & configure the settings', 'wp-2fa' ); ?>">
						<?php esc_html_e( 'Continue & configure the settings', 'wp-2fa' ); ?>
					</button>
					<a href="<?php echo esc_url( $redirect ); ?>" class="button button-secondary">
						<?php esc_html_e( 'Close wizard, I’ll configure them later', 'wp-2fa' ); ?>
					</a>
				</div>
			</form>

			<p class="description"><?php esc_html_e( 'Note: all the settings can be configured from the Settings > Two-factor Authentication entry of your WordPress menu.', 'wp-2fa' ); ?></p>

			<?php
		endif;
	}

	/**
	 * Step Save: `Finish`
	 */
	private function wp_2fa_step_finish_save() {
		// Verify nonce.
		check_admin_referer( 'wp2fa-step-finish' );
		wp_safe_redirect( esc_url_raw( $this->get_next_step() ) );
		exit();
	}

	/**
	 * Step View: `Finish`
	 */
	private function wp_2fa_step_backup_codes() {
		// Grab current user.
		$user  = wp_get_current_user();
		$roles = (array) $user->roles;
		// Create a nonce for use in ajax call to generate codes.
		$nonce = wp_create_nonce( 'wp-2fa-backup-codes-generate-json-' . $user->ID );

		$redirect = get_edit_user_link( $user->ID );
		?>
		<div class="step-setting-wrapper active" data-step-title="<?php esc_html_e( 'Generate codes', 'wp-2fa' ); ?>">
			<h3><?php esc_html_e( 'Generate backup codes', 'wp-2fa' ); ?></h3>
			<p><?php esc_html_e( 'It is recommended to generate and print some backup codes in case you lose access to your primary 2FA method. ', 'wp-2fa' ); ?></p>

			<form method="post" class="wp2fa-setup-form" autocomplete="off">
				<?php wp_nonce_field( 'wp2fa-step-finish' ); ?>
				<div class="wp2fa-setup-actions">
					<button class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'Generate backup codes', 'wp-2fa' ); ?>" data-trigger-generate-backup-codes data-nonce="<?php echo esc_attr( $nonce ); ?>" data-user-id="<?php echo esc_attr( $user->ID ); ?>">
						<?php esc_html_e( 'Generate backup codes', 'wp-2fa' ); ?>
					</button>
					<a href="<?php echo esc_url( $redirect ); ?>" class="button button-secondary" type="submit" name="save_step" value="<?php esc_attr_e( 'I’ll generate them later', 'wp-2fa' ); ?>">
						<?php esc_html_e( 'I’ll generate them later', 'wp-2fa' ); ?>
					</a>
				</div>
			</form>
		</div>

		<div class="step-setting-wrapper align-center" data-step-title="<?php esc_html_e( 'Your backup codes', 'wp-2fa' ); ?>">
			<h3><?php esc_html_e( 'Backup codes generated', 'wp-2fa' ); ?></h3>
			<p><?php esc_html_e( 'Here are your backup codes:', 'wp-2fa' ); ?></p>
			<code id="backup-codes-wrapper"></code>
			<div class="wp2fa-setup-actions">
				<button class="button button-primary" type="submit" value="<?php esc_attr_e( 'Download', 'wp-2fa' ); ?>" data-trigger-backup-code-download data-user="<?php echo esc_attr( $user->display_name ); ?>" data-website-url="<?php echo esc_attr( get_home_url() ); ?>">
					<?php esc_html_e( 'Download', 'wp-2fa' ); ?>
				</button>
				<button class="button button-secondary" type="submit" value="<?php esc_attr_e( 'Print', 'wp-2fa' ); ?>" data-trigger-print data-nonce="<?php echo esc_attr( $nonce ); ?>" data-user-id="<?php echo esc_attr( $user->display_name ); ?>" data-website-url="<?php echo esc_attr( get_home_url() ); ?>">
					<?php esc_html_e( 'Print', 'wp-2fa' ); ?>
				</button>
			</div>
		</div>
		<style>
		.close-wizard-link { display: none; }
		</style>
		<?php
	}

	/**
	 * Step Save: `Finish`
	 */
	private function wp_2fa_step_backup_codes_save() {
		// Verify nonce.
		check_admin_referer( 'wp2fa-step-finish' );
	}

	/**
	 * Step View: `Choose Methods`
	 */
	private function wp_2fa_step_global_2fa_methods() {
		$enforced_roles = trim( WP2FA::get_wp2fa_setting( 'enforced_roles' ) );
		$enforced_users = trim( WP2FA::get_wp2fa_setting( 'enforced_users' ) );
		$excluded_users = trim( WP2FA::get_wp2fa_setting( 'excluded_users' ) );
		$excluded_roles = trim( WP2FA::get_wp2fa_setting( 'excluded_roles' ) );
		?>
		<form method="post" class="wp2fa-setup-form" autocomplete="off">
			<?php wp_nonce_field( 'wp2fa-step-choose-method' ); ?>
			<div class="step-setting-wrapper active" data-step-title="<?php esc_html_e( 'Choose 2FA methods', 'wp-2fa' ); ?>">
				<h3><?php esc_html_e( 'Which two-factor authentication methods can your users use on this website?', 'wp-2fa' ); ?></h3>
				<p><?php esc_html_e( 'When you disable one of the below 2FA methods none of your users can use it.', 'wp-2fa' ); ?></p>
				<fieldset>
					<div class="option-pill">
						<label for="basic">
							<input id="basic" name="wp_2fa_settings[enable_totp]" type="checkbox" value="enable_totp"
							<?php checked( 'enable_totp', WP2FA::get_wp2fa_setting( 'enable_totp' ), true ); ?>
							>
							<?php esc_html_e( 'One-time code generated with your app of choice (most reliable and secure)', 'wp-2fa' ); ?>
						</label>
						<?php
							printf( '<p class="description">%1$s <a href="https://www.wpwhitesecurity.com/support/kb/configuring-2fa-apps/" target="_blank">%2$s</a> %3$s</p>', esc_html__( 'Note: This method requires you to install one of the following 2FA apps: Google Authenticator, FreeOTP, Microsoft Authenticator, Duo Security, Authy, LastPass and Okta Verify. All of these apps are free and can be downloaded from the Google Play and Apple Appstore. Read our guides on', 'wp-2fa' ), esc_html__( 'our knowledge base', 'wp-2fa' ), esc_html__( 'for more information on how to setup these apps.', 'wp-2fa' ) );
						?>
						</p>
					</div>
					<div class="option-pill">
						<label for="geek">
							<input id="geek" name="wp_2fa_settings[enable_email]" type="checkbox" value="enable_email"
							<?php checked( WP2FA::get_wp2fa_setting( 'enable_email' ), 'enable_email' ); ?>
							>
							<?php esc_html_e( 'One-time code sent to user over email', 'wp-2fa' ); ?>
						</label>
					</div>
				</fieldset>
				<div class="wp2fa-setup-actions">
					<a class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'Continue Setup', 'wp-2fa' ); ?>"><?php esc_html_e( 'Continue Setup', 'wp-2fa' ); ?></a>
				</div>
			</div>
			<div class="step-setting-wrapper" data-step-title="<?php esc_html_e( '2FA policy', 'wp-2fa' ); ?>">
				<h3><?php esc_html_e( 'Do you want to enforce 2FA for some, or all the users?', 'wp-2fa' ); ?></h3>
				<p><?php esc_html_e( 'When you enforce 2FA the users will be prompted to configure 2FA the next time they login. Users have a grace period for configuring 2FA. You can configure the grace period and also exclude user(s) or role(s) in this settings page.', 'wp-2fa' ); ?></p>
				<fieldset class="contains-hidden-inputs">
						<label for="all-users">
							<input type="radio" name="wp_2fa_settings[enforcment-policy]" id="all-users" value="all-users"
							<?php checked( WP2FA::get_wp2fa_setting( 'enforcment-policy' ), 'all-users' ); ?>
							>
						<span><?php esc_html_e( 'All users', 'wp-2fa' ); ?></span>
						</label>
						<br/>

						<?php if ( WP2FA::is_this_multisite() ): ?>
							<label for="superadmins-only">
								<input type="radio" name="wp_2fa_settings[enforcment-policy]" id="superadmins-only" value="superadmins-only"
										<?php checked( WP2FA::get_wp2fa_setting( 'enforcment-policy' ), 'superadmins-only' ); ?> />
								<span><?php esc_html_e( 'Only super admins', 'wp-2fa' ); ?></span>
							</label>
							<br/>
						<?php endif; ?>

						<label for="certain-roles-only">
							<input type="radio" name="wp_2fa_settings[enforcment-policy]" id="certain-roles-only" value="certain-roles-only"
							<?php checked( WP2FA::get_wp2fa_setting( 'enforcment-policy' ), 'certain-roles-only' ); ?>
							data-unhide-when-checked=".certain-roles-only-inputs, .certain-users-only-inputs">
							<span><?php esc_html_e( 'Only for specific users and roles', 'wp-2fa' ); ?></span>
						</label>
						<fieldset class="hidden certain-users-only-inputs">
							<br/>
							<input type="text" id="enforced_users_search" placeholder="Search users">
							<input type="hidden" id="enforced_users" name="wp_2fa_settings[enforced_users]" value="<?php echo esc_attr( $enforced_users ); ?>">
							<div id="enforced_users_buttons"></div>
						</fieldset>
						<fieldset class="hidden certain-roles-only-inputs">
							<br/>
							<input type="text" id="enforced_roles_search" placeholder="Search roles">
							<input type="hidden" id="enforced_roles" name="wp_2fa_settings[enforced_roles]" value="<?php echo esc_attr( $enforced_roles ); ?>">
							<div id="enforced_roles_buttons"></div>
						</fieldset>

					</label>

					<br/>
					<label for="do-not-enforce">
						<input type="radio" name="wp_2fa_settings[enforcment-policy]" id="do-not-enforce" value="do-not-enforce"
						<?php checked( WP2FA::get_wp2fa_setting( 'enforcment-policy' ), 'do-not-enforce' ); ?>
						>
						<span><?php esc_html_e( 'Do not enforce 2FA on any users', 'wp-2fa' ); ?></span>
					</label>
					<br/>
				</fieldset>
				<div class="wp2fa-setup-actions">
					<a class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'Continue Setup', 'wp-2fa' ); ?>"><?php esc_html_e( 'Continue Setup', 'wp-2fa' ); ?></a>
				</div>
			</div>
			<div class="step-setting-wrapper" data-step-title="<?php esc_html_e( 'Exclude users', 'wp-2fa' ); ?>">
				<h3><?php esc_html_e( 'Do you want to exclude any users or roles from 2FA?', 'wp-2fa' ); ?></h3>
				<p><?php esc_html_e( 'If you are enforcing 2FA on all users but for some reason you would like to exclude individual user(s) or users with a specific role, you can exclude them below', 'wp-2fa' ); ?></p>
				<fieldset>
					<div class="option-pill">
						<label for="basic"><?php esc_html_e( 'Exclude the following users', 'wp-2fa' ); ?>
							<input type="text" class="input wide" id="excluded_users_search" placeholder="<?php esc_html_e( 'Search user name', 'wp-2fa' ); ?>">
							<input type="hidden" id="excluded_users" name="wp_2fa_settings[excluded_users]" value="<?php echo esc_attr( $excluded_users ); ?>">
							<div id="excluded_users_buttons"></div>
						</label>
						<label for="geek"><?php esc_html_e( 'Exclude the following roles', 'wp-2fa' ); ?>
							<input type="text" class="input wide" id="excluded_roles_search" placeholder="<?php esc_html_e( 'Search roles', 'wp-2fa' ); ?>">
							<input type="hidden" id="excluded_roles" name="wp_2fa_settings[excluded_roles]" value="<?php echo esc_attr( $excluded_roles ); ?>">
							<div id="excluded_roles_buttons"></div>
						</label>
					</div>
				</fieldset>
				<div class="wp2fa-setup-actions">
					<a class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'Continue Setup', 'wp-2fa' ); ?>"><?php esc_html_e( 'Continue Setup', 'wp-2fa' ); ?></a>
				</div>
			</div>

			<?php if ( WP2FA::is_this_multisite() ) : ?>
				<div class="step-setting-wrapper" data-step-title="<?php esc_html_e( 'Exclude sites', 'wp-2fa' ); ?>">
					<h3><?php esc_html_e( 'Do you want to exclude all the users of a site from 2FA?', 'wp-2fa' ); ?></h3>
					<p><?php esc_html_e( 'If you are enforcing 2FA on all users but for some reason you do not want to enforce it on a specific sub site, specify the sub site name below:', 'wp-2fa' ); ?></p>
					<fieldset>
						<div class="option-pill">
							<label for="excluded_sites_search"><?php esc_html_e( 'Exclude the following sites', 'wp-2fa' ); ?>
								<input type="text" id="excluded_sites_search" placeholder="Search network">
								<input type="hidden" id="excluded_sites" name="wp_2fa_settings[excluded_sites]"
								value="<?php echo trim( sanitize_text_field( WP2FA::get_wp2fa_setting( 'excluded_sites' ) ) ); ?>">
								<div id="excluded_sites_buttons"></div>
							</label>
						</div>
					</fieldset>
					<div class="wp2fa-setup-actions">
						<a class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'Continue Setup', 'wp-2fa' ); ?>"><?php esc_html_e( 'Continue Setup', 'wp-2fa' ); ?></a>
					</div>
				</div>
			<?php endif; ?>

			<?php
			$grace_period = (int) WP2FA::get_wp2fa_setting( 'grace-period' );
			$testing      = get_option( 'wp_2fa_test_grace' );
			if ( '1' === $testing ) {
				$grace_max = 600;
			} else {
				$grace_max = 10;
			}
			?>

			<div class="step-setting-wrapper" data-step-title="<?php esc_html_e( 'Grace period', 'wp-2fa' ); ?>">
				<h3><?php esc_html_e( 'How long should the grace period for your users be?', 'wp-2fa' ); ?></h3>
				<p><?php esc_html_e( 'When you configure the 2FA policies and require users to configure 2FA, they can either have a grace period to configure 2FA, or can be required to configure 2FA before the next time they login. Choose which method you\'d like to use:', 'wp-2fa' ); ?></p>
				<fieldset class="contains-hidden-inputs">
					<label for="no-grace-period">
						<input type="radio" name="wp_2fa_settings[grace-policy]" id="no-grace-period" value="no-grace-period"
						<?php checked( WP2FA::get_wp2fa_setting( 'grace-policy' ), 'no-grace-period' ); ?>
						>
					<span><?php esc_html_e( 'Users have to configure 2FA straight away.', 'wp-2fa' ); ?></span>
					</label>

					<br/>
					<label for="use-grace-period">
						<input type="radio" name="wp_2fa_settings[grace-policy]" id="use-grace-period" value="use-grace-period"
						<?php checked( WP2FA::get_wp2fa_setting( 'grace-policy' ), 'use-grace-period' ); ?>
						data-unhide-when-checked=".grace-period-inputs">
						<span><?php esc_html_e( 'Give users a grace period to configure 2FA', 'wp-2fa' ); ?></span>
					</label>
					<br>
					<fieldset class="grace-period-inputs">
						<br/>
						<input type="number" id="grace-period" name="wp_2fa_settings[grace-period]" value="<?php echo esc_attr( $grace_period ); ?>" min="1" max="<?php echo esc_attr( $grace_max ); ?>">
						<label class="radio-inline">
							<input class="js-nested" type="radio" name="wp_2fa_settings[grace-period-denominator]" value="hours"
							<?php checked( WP2FA::get_wp2fa_setting( 'grace-period-denominator' ), 'hours' ); ?>
							>
							<?php esc_html_e( 'Hours', 'wp-2fa' ); ?>
						</label>
						<label class="radio-inline">
							<input class="js-nested" type="radio" name="wp_2fa_settings[grace-period-denominator]" value="days"
							<?php checked( WP2FA::get_wp2fa_setting( 'grace-period-denominator' ), 'days' ); ?>
							>
							<?php esc_html_e( 'Days', 'wp-2fa' ); ?>
						</label>
						<?php
						$testing = get_option( 'wp_2fa_test_grace' );
						if ( '1' === $testing ) {
							?>
							<label class="js-nested" class="radio-inline">
								<input type="radio" name="wp_2fa_settings[grace-period-denominator]" value="seconds"
								<?php checked( WP2FA::get_wp2fa_setting( 'grace-period-denominator' ), 'seconds' ); ?>
								>
								<?php esc_html_e( 'Seconds', 'wp-2fa' ); ?>
							</label>
							<?php
						}
						?>
						<p><?php esc_html_e( 'Note: If users do not configure it within the configured stipulated time, their account will be locked and have to be unlocked manually.', 'wp-2fa' ); ?></p>
					</fieldset>
				</fieldset>
				<div class="wp2fa-setup-actions">
					<a class="button button-primary continue-wizard hidden" name="next_step_setting" value="<?php esc_attr_e( 'Continue Setup', 'wp-2fa' ); ?>"><?php esc_html_e( 'Continue Setup', 'wp-2fa' ); ?></a>
					<button class="button button-primary save-wizard" type="submit" name="save_step" value="<?php esc_attr_e( 'All done', 'wp-2fa' ); ?>"><?php esc_html_e( 'All done', 'wp-2fa' ); ?></button>
				</div>
			</div>

			<div class="step-setting-wrapper hidden" data-step-title="<?php esc_html_e( 'Notify users', 'wp-2fa' ); ?>">
				<h3><?php esc_html_e( 'Do you want to notify users now?', 'wp-2fa' ); ?></h3>
				<p><?php esc_html_e( 'When you require users to configure 2FA via policies, the plugin notifies the user with an email and a message in the WordPress dashboard. Do you want to send the emails now?', 'wp-2fa' ); ?></p>
				<fieldset>
					<div class="option-pill">
						<label for="notify_users">
							<input type="checkbox" id="notify_users" name="wp_2fa_settings[notify_users]" value="notify_users" checked>
							<span><?php esc_html_e( 'Notify users now.', 'wp-2fa' ); ?></span>
						</label>
					</div>

				</fieldset>
				<div class="wp2fa-setup-actions">
					<button class="button button-primary" type="submit" name="save_step" value="<?php esc_attr_e( 'All done', 'wp-2fa' ); ?>"><?php esc_html_e( 'All done', 'wp-2fa' ); ?></button>
				</div>
			</div>

		</form>
		<?php
	}

	/**
	 * Step Save: `Choose Method`
	 */
	private function wp_2fa_step_global_2fa_methods_save() {
		// Check nonce.
		check_admin_referer( 'wp2fa-step-choose-method' );

		// Grab current user.
		$user = wp_get_current_user();

		// Setup args we may need, depending if this is a MS setup or not.
		$users      = array();
		$users_args = array();
		if ( WP2FA::is_this_multisite() ) {
			$users_args['blog_id'] = 0;
		}
		$total_users = count_users();
		$batch_size  = 2000;
		$slices      = ceil( $total_users['total_users'] / $batch_size );

		// Ensure user has capacity to be making these kinds of changes.
		if ( isset( $_POST['wp_2fa_settings'] ) && current_user_can( 'manage_options' ) ) {
			$settings = array_map( 'esc_attr', wp_unslash( $_POST['wp_2fa_settings'] ) );

			// Remove grace period from users via BG process.
			for ( $count = 0; $count < $slices; $count++ ) {
				$users_args = array(
					'number' => $batch_size,
					'offset' => $count * $batch_size,
					'fields' => array( 'ID' ),
				);
				if ( WP2FA::is_this_multisite() ) {
					$users_args['blog_id'] = 0;
				}
				$users = get_users( $users_args );
				if ( ! empty( $users ) ) {
					$background_process       = new ProcessUserMetaUpdate();
					$item_to_process          = array();
					$item_to_process['users'] = $users;
					$item_to_process['task']  = 'delete_grace_period';
					$background_process->push_to_queue( $item_to_process );
				}
				$background_process->save()->dispatch();
			}

			if ( ! isset( $settings['enable_totp'] ) && ! isset( $settings['enable_email'] ) ) {
				add_settings_error(
					'wp_2fa_settings',
					esc_attr( 'settings_error' ),
					esc_html__( 'At least one 2FA method should be enabled.', 'wp-2fa' ),
					'error'
				);
			}

			// Compare current to old value to see if a method which was once enabled, has now been disabled.
			if ( ! isset( $settings['enable_totp'] ) && 'enable_totp' === WP2FA::get_wp2fa_setting( 'enable_totp' ) ) {
				for ( $count = 0; $count < $slices; $count++ ) {
					$users_args = array(
						'number' => $batch_size,
						'offset' => $count * $batch_size,
						'fields' => array( 'ID' ),
					);
					$users      = get_users( $users_args );
					if ( ! empty( $users ) ) {
						$background_process       = new ProcessUserMetaUpdate();
						$item_to_process          = array();
						$item_to_process['users'] = $users;
						$item_to_process['task']  = 'remove_enabled_methods';
						$item_to_process['method_to_remove'] = 'totp';
						$background_process->push_to_queue( $item_to_process );
					}

					$background_process->save()->dispatch();
				}
			}
			if ( ! isset( $settings['enable_email'] ) && 'enable_email' === WP2FA::get_wp2fa_setting( 'enable_email' ) ) {
				for ( $count = 0; $count < $slices; $count++ ) {
					$users_args = array(
						'number' => $batch_size,
						'offset' => $count * $batch_size,
						'fields' => array( 'ID' ),
					);
					$users      = get_users( $users_args );
					if ( ! empty( $users ) ) {
						$background_process       = new ProcessUserMetaUpdate();
						$item_to_process          = array();
						$item_to_process['users'] = $users;
						$item_to_process['task']  = 'remove_enabled_methods';
						$item_to_process['method_to_remove'] = 'email';
						$background_process->push_to_queue( $item_to_process );
					}

					$background_process->save()->dispatch();
				}
			}

			if ( isset( $settings['enable_totp'] ) && 'enable_totp' === $settings['enable_totp'] ) {
				$output['enable_totp'] = sanitize_text_field( $settings['enable_totp'] );
			}

			if ( isset( $settings['enable_email'] ) && 'enable_email' === $settings['enable_email'] ) {
				$output['enable_email'] = sanitize_text_field( $settings['enable_email'] );
			}

			if ( isset( $settings['enforcment-policy'] ) && 'all-users' === $settings['enforcment-policy'] || isset( $settings['enforcment-policy'] ) && 'certain-users-only' === $settings['enforcment-policy'] || isset( $settings['enforcment-policy'] ) && 'certain-roles-only' === $settings['enforcment-policy'] || isset( $settings['enforcment-policy'] ) && 'do-not-enforce' === $settings['enforcment-policy'] ) {
				$output['enforcment-policy'] = $settings['enforcment-policy'];
			}

			if ( isset( $settings['enforced_roles'] ) ) {
				$output['enforced_roles'] = trim( sanitize_text_field( $settings['enforced_roles'] ) );
			}

			if ( isset( $settings['enforced_users'] ) ) {
				$output['enforced_users'] = trim( sanitize_text_field( $settings['enforced_users'] ) );
			}

			if ( isset( $settings['excluded_users'] ) ) {
				$output['excluded_users'] = trim( sanitize_text_field( $settings['excluded_users'] ) );

				// Wipe user 2fa data.
				$excluded_users_array = explode( ',', $output['excluded_users'] );
				for ( $count = 0; $count < $slices; $count++ ) {
					$users_args = array(
						'number' => $batch_size,
						'offset' => $count * $batch_size,
						'fields' => array( 'ID' ),
					);
					$users      = get_users( $users_args );
					if ( ! empty( $users ) ) {
						$background_process                = new ProcessUserMetaUpdate();
						$item_to_process                   = array();
						$item_to_process['users']          = $users;
						$item_to_process['task']           = 'wipe_all_2fa_user_data';
						$item_to_process['excluded_users'] = $excluded_users_array;
						$background_process->push_to_queue( $item_to_process );
					}

					$background_process->save()->dispatch();
				}
			}

			if ( isset( $settings['excluded_roles'] ) ) {
				$output['excluded_roles'] = trim( sanitize_text_field( $settings['excluded_roles'] ) );

				// Wipe user 2fa data.
				$excluded_roles_array = array_filter( explode( ',', strtolower( $output['excluded_roles'] ) ) );
				for ( $count = 0; $count < $slices; $count++ ) {
					$users_args = array(
						'number' => $batch_size,
						'offset' => $count * $batch_size,
						'fields' => array( 'ID' ),
					);
					$users      = get_users( $users_args );
					if ( ! empty( $users ) ) {
						$background_process                = new ProcessUserMetaUpdate();
						$item_to_process                   = array();
						$item_to_process['users']          = $users;
						$item_to_process['task']           = 'wipe_all_2fa_user_data';
						$item_to_process['excluded_roles'] = $excluded_roles_array;
						$background_process->push_to_queue( $item_to_process );
					}

					$background_process->save()->dispatch();
				}

				if ( WP2FA::is_this_multisite() ) {
					if ( isset( $settings['excluded_sites'] ) ) {
						$output['excluded_sites'] = trim( sanitize_text_field( $settings['excluded_sites'] ) );
					} else {
						$output['excluded_sites'] = '';
					}
				} else {
					$output['excluded_sites'] = '';
				}

				if ( isset( $settings['grace-policy'] ) ) {
					$output['grace-policy'] = sanitize_text_field( $settings['grace-policy'] );
				}

				if ( isset( $settings['grace-period'] ) ) {
					if ( 0 === (int) $settings['grace-period'] ) {
						add_settings_error(
							'wp_2fa_settings',
							esc_attr( 'settings_error' ),
							esc_html__( 'Grace period must be at least 1 day/hour', 'wp-2fa' ),
							'error'
						);
						$output['grace-period'] = 1;
					} else {
						$output['grace-period'] = (int) $settings['grace-period'];
					}
				}

				if ( isset( $settings['grace-period-denominator'] ) && 'days' === $settings['grace-period-denominator'] || isset( $settings['grace-period-denominator'] ) && 'hours' === $settings['grace-period-denominator'] || isset( $settings['grace-period-denominator'] ) && 'seconds' === $settings['grace-period-denominator'] ) {
					$output['grace-period-denominator'] = sanitize_text_field( $settings['grace-period-denominator'] );
				}

				if ( isset( $settings['enable_grace_cron'] ) ) {
					$output['enable_grace_cron'] = (bool) $settings['enable_grace_cron'];
				}

				if ( isset( $settings['2fa_main_user'] ) ) {
					$output['2fa_settings_last_updated_by'] = (int) $settings['2fa_main_user'];
				}

				if ( isset( $settings['limit_access'] ) ) {
					$output['limit_access'] = (bool) $settings['limit_access'];
				}

				if ( isset( $settings['grace-period'] ) && isset( $settings['grace-period-denominator'] ) ) {
					// Turn inputs into a useable string.
					$create_a_string = $output['grace-period'] . ' ' . $output['grace-period-denominator'];
					// Turn that string into a time.
					$grace_expiry                       = strtotime( $create_a_string );
					$output['grace-period-expiry-time'] = sanitize_text_field( $grace_expiry );
				}

				// Ensure default is not affected.
				$output['create-custom-user-page'] = 'no';

				// Fetch users and apply the grace period tp their user meta.
				if ( isset( $settings['enforcment-policy'] ) && 'do-not-enforce' !== $settings['enforcment-policy'] && ! isset( $settings['grace-period-expiry-time'] ) ) {

					// If we are specifying to enforce 2fa for specific users, we have no need to check if they are eligble or excluded, so we dont.
					if ( isset( $settings['enforcment-policy'] ) && 'certain-roles-only' === $settings['enforcment-policy'] && isset( $settings['enforced_users'] ) && WP2FA::get_wp2fa_setting( 'enforced_users' ) !== $settings['enforced_users'] || isset( $settings['enforcment-policy'] ) && 'certain-roles-only' === $settings['enforcment-policy'] && isset( $settings['enforced_roles'] ) && WP2FA::get_wp2fa_setting( 'enforced_roles' ) !== $settings['enforced_roles'] ) {
						$enforced_users_array = array_filter( explode( ',', $settings['enforced_users'] ) );
						$grace_string         = $output['grace-period'] . ' ' . $output['grace-period-denominator'];
						// Flush the old expiry away from ALL users, we will re-apply them based on the current setup at the end of this.
						for ( $count = 0; $count < $slices; $count++ ) {
							$users_args = array(
								'number' => $batch_size,
								'offset' => $count * $batch_size,
								'fields' => array( 'ID', 'user_login' ),
							);
							if ( WP2FA::is_this_multisite() ) {
								$users_args['blog_id'] = 0;
							}
							$users = get_users( $users_args );
							if ( ! empty( $users ) ) {
								foreach ( $users as $user ) {
									if ( in_array( $user->user_login, $enforced_users_array ) ) {
										$background_process              = new ProcessUserMetaUpdate();
										$item_to_process                 = array();
										$item_to_process['user']         = $user;
										$item_to_process['task']         = 'enforce_2fa_for_user';
										$item_to_process['grace_expiry'] = $grace_expiry;
										$item_to_process['grace_policy'] = sanitize_text_field( $settings['grace-policy'] );
										$item_to_process['notify_users'] = isset( $settings['notify_users'] ) ? $settings['notify_users'] : false;
										$item_to_process['grace-period-expiry-time'] = $grace_string;
										$background_process->push_to_queue( $item_to_process );
									} else {
										if ( isset( $output['enforced_roles'] ) && empty( $output['enforced_roles'] ) ) {
											$enforced_roles = 'none';
										} else {
											$enforced_roles = $output['enforced_roles'];
										}
										if ( isset( $output['enforced_users'] ) && empty( $output['enforced_users'] ) ) {
											$enforced_users = 'none';
										} else {
											$enforced_users = $output['enforced_users'];
										}
										$is_needed        = Authentication::is_user_eligible_for_2fa( $user->ID, $settings['enforcment-policy'], $output['excluded_users'], $output['excluded_roles'], $enforced_users, $enforced_roles );
										$is_user_excluded = WP2FA::is_user_excluded( $user, $output['excluded_users'], $output['excluded_roles'], $output['excluded_sites'] );
										if ( $is_needed && ! $is_user_excluded ) {
											$item_to_process                 = array();
											$item_to_process['user']         = $user;
											$item_to_process['task']         = 'enforce_2fa_for_user';
											$item_to_process['grace_expiry'] = $grace_expiry;
											$item_to_process['grace_policy'] = sanitize_text_field( $output['grace-policy'] );
											$item_to_process['notify_users'] = isset( $settings['notify_users'] ) ? $settings['notify_users'] : false;
											$item_to_process['grace-period-expiry-time'] = $grace_string;
											$background_process->push_to_queue( $item_to_process );
										}
									}
								}
							}

							$background_process->save()->dispatch();
						}
					} else {
						$grace_string = $output['grace-period'] . ' ' . $output['grace-period-denominator'];
						for ( $count = 0; $count < $slices; $count++ ) {
							$users_args = array(
								'number' => $batch_size,
								'offset' => $count * $batch_size,
								'fields' => array( 'ID' ),
							);
							if ( WP2FA::is_this_multisite() ) {
								$users_args['blog_id'] = 0;
							}
							$users = get_users( $users_args );

							if ( ! empty( $users ) ) {
								$background_process                   = new ProcessUserMetaUpdate();
								$item_to_process                      = array();
								$item_to_process['users']             = $users;
								$item_to_process['task']              = 'enforce_2fa_for_user';
								$item_to_process['grace_expiry']      = $grace_expiry;
								$item_to_process['grace_policy']      = sanitize_text_field( $settings['grace-policy'] );
								$item_to_process['notify_users']      = isset( $settings['notify_users'] ) ? $settings['notify_users'] : false;
								$item_to_process['enforcment-policy'] = $settings['enforcment-policy'];
								$item_to_process['excluded_users']    = $output['excluded_users'];
								$item_to_process['excluded_roles']    = $output['excluded_roles'];
								$item_to_process['enforced_users']    = $output['enforced_users'];
								$item_to_process['enforced_roles']    = $output['enforced_roles'];
								$item_to_process['excluded_sites']    = $output['excluded_sites'];
								$item_to_process['grace-period-expiry-time'] = $grace_string;
								$background_process->push_to_queue( $item_to_process );
							}

							$background_process->save()->dispatch();
						}
					}
				}
			}

			if ( WP2FA::is_this_multisite() ) {
				update_network_option( null, 'wp_2fa_settings', $output );
				add_network_option( null, 'wp_2fa_setup_wizard_complete', true );
			} else {
				update_option( 'wp_2fa_settings', $output );
				add_option( 'wp_2fa_setup_wizard_complete', true );
			}
		}

		wp_safe_redirect( esc_url_raw( $this->get_next_step() ) );
		exit();
	}

	/**
	 * Send email with fresh code, or to setup email 2fa.
	 *
	 * @param int $user_id User id we want to send the message to.
	 * @param string $nonce The nonce.
	 *
	 * @return bool
	 */
	public static function send_authentication_setup_email( $user_id, $nonce = '' ) {

		// If we have a nonce posted, check it.
		if ( wp_doing_ajax() && isset( $_POST['nonce'] ) ) {
			$nonce_check = wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'wp-2fa-send-setup-email' );
			if ( ! $nonce_check ) {
				return false;
				exit();
			}
		}

		if ( isset( $_POST['user_id'] ) ) {
			$user = get_userdata( intval( $_POST['user_id'] ) );
		} else {
			$user = get_userdata( $user_id );
		}

		// Seeing as we got this far, we need to clear notices to make way for anything fresh.
		delete_user_meta( $user->ID, self::NOTICES_META_KEY );

		// Grab email address is its provided.
		if ( isset( $_POST['email_address'] ) ) {
			$email = sanitize_email( $_POST['email_address'] );
		} else {
			$email = sanitize_email( $user->user_email );
		}

		if ( wp_doing_ajax() && isset( $_POST['nonce'] ) ) {
			update_user_meta( $user->ID, 'wp_2fa_nominated_email_address', $email );
		}

		$enabled_email_address = get_user_meta( $user->ID, 'wp_2fa_nominated_email_address', true );

		// Generate a token and setup email.
		$token   = Authentication::generate_token( $user->ID );
		$subject = wp_strip_all_tags( WP2FA::replace_email_strings( WP2FA::get_wp2fa_email_templates( 'login_code_email_subject' ), $user->ID ) );
		$message = wpautop( WP2FA::replace_email_strings( WP2FA::get_wp2fa_email_templates( 'login_code_email_body' ), $user->ID, $token ) );

		if ( ! empty( $enabled_email_address ) ) {
			$email_address = $enabled_email_address;
		} else {
			$email_address = $user->user_email;
		}

		return SettingsPage::send_email( $email_address, $subject, $message );
	}

	/**
	 * Send email to setup authentication
	 */
	public function regenerate_authentication_key() {
		// Grab current user.
		$user = wp_get_current_user();

		// Delete the key and enabled methods
		Authentication::delete_user_totp_key( $user->ID );
		$wipe_enabled_methods = delete_user_meta( $user->ID, 'wp_2fa_enabled_methods' );

		// Return something, not sure why
		return true;
	}

	/**
	 * Step View: `Setup Authenticator`
	 */
	private function wp_2fa_step_reconfigure_authenticator() {
		// Grab current user
		$user = wp_get_current_user();

		// Grab key from user meta
		$key = Authentication::get_user_totp_key( $user->ID );

		// If no key is present, lets make one
		if ( empty( $key ) ) {
			$key    = Authentication::generate_key();
			$update = update_user_meta( $user->ID, 'wp_2fa_totp_key', $key );
		}

		// Setup site information, used when generating our QR code
		$site_name  = get_bloginfo( 'name', 'display' );
		$totp_title = apply_filters( 'wp_2fa_totp_title', $site_name . ':' . $user->user_login, $user );

		// Now lets grab the users enabled 2fa methods.
		$selected_method = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );

		// Create a nonce incase we want to reset the key
		$nonce = wp_create_nonce( 'wp-2fa-backup-codes-generate-json-' . $user->ID );

		if ( ! isset( $notices['error'] ) && empty( $notices['error'] ) ) {
			$is_active  = 'active';
			$is_active2 = '';
		} else {
			$is_active  = '';
			$is_active2 = 'active';
		}

		// TOTP is enabled for the user, so lets display the relevant steps.
		// Here we wrap each "sub step" (a step within a step) in .tep-setting-wrapper, and nudge to next "sub step" with next_step_setting button.
		if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_totp' ) ) ) {
			?>
			<div class="step-setting-wrapper <?php echo esc_attr( $is_active ); ?>" data-step-title="<?php esc_html_e( 'Reconfigure 2FA', 'wp-2fa' ); ?>">
				<h3>
					<?php esc_html_e( 'Reconfigure the 2FA App', 'wp-2fa' ); ?>
				</h3>
				<p>
					<?php esc_html_e( 'Click the below button to reconfigure the current 2FA method. You can use this if for example, you want to change your device or 2FA app. Note that once reset reset you will have to re-scan the QR code on all devices you want this to work on because the previous codes will stop working.', 'wp-2fa' ); ?>
				</p>
				<div class="wp2fa-setup-actions">
						<a href="<?php echo esc_url( admin_url( 'options-general.php?page=wp-2fa-setup&current-step=setup_method&enabled_method=totp' ) ); ?>" class="button button-primary do-not-reload" data-trigger-reset-key data-nonce="<?php echo esc_attr( $nonce ); ?>" data-user-id="<?php echo esc_attr( $user->ID ); ?>"><?php esc_html_e( 'Reset Key', 'wp-2fa' ); ?></a>
				</div>
			</div>

			<?php
		} elseif ( ! empty( WP2FA::get_wp2fa_setting( 'enable_email' ) ) ) {
			$setupnonce = wp_create_nonce( 'wp-2fa-send-setup-email' );
			?>
			<div class="step-setting-wrapper <?php echo esc_attr( $is_active ); ?>" data-step-title="<?php esc_html_e( 'Configure email', 'wp-2fa' ); ?>">
				<h3><?php esc_html_e( 'Setup the 2FA method', 'wp-2fa' ); ?></h3>
				<p>
					<?php esc_html_e( 'Please select the email address where the one-time code should be sent:', 'wp-2fa' ); ?>
				</p>
				<fieldset>
					<label for="use_wp_email">
						<span><?php esc_html_e( 'Type in below the new email address where you want to receive the 2FA one-time codes.', 'wp-2fa' ); ?></span>
						<input type="email" name="custom-email-address" id="custom-email-address" class="input wide" value=""/>
					</label>
				</fieldset>
				<div class="wp2fa-setup-actions">
					<button class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'I\'m Ready', 'wp-2fa' ); ?>" data-trigger-setup-email data-user-id="<?php echo esc_attr( $user->ID ); ?>" data-nonce="<?php echo esc_attr( $setupnonce ); ?>"><?php esc_html_e( 'Change email address', 'wp-2fa' ); ?></button>
				</div>
			</div>

			<div class="step-setting-wrapper <?php echo esc_attr( $is_active2 ); ?>" data-step-title="<?php esc_html_e( 'Validate email', 'wp-2fa' ); ?>">
				<form method="post" class="wp2fa-setup-form" autocomplete="off">
				<?php wp_nonce_field( 'wp2fa-step-login' ); ?>
					<h4><?php esc_html_e( 'Almost there…', 'wp-2fa' ); ?></h4>
					<p><?php esc_html_e( 'Please type in the one-time code sent to your email address to finalize the setup.', 'wp-2fa' ); ?></p>
					<fieldset>
						<label for="2fa-email-authcode">
						<?php esc_html_e( 'Authentication Code:', 'wp-2fa' ); ?>
							<input type="tel" name="wp-2fa-email-authcode" id="wp-2fa-email-authcode" class="input" value="" size="20" pattern="[0-9]*" />
						</label>
					</fieldset>

					<input type="hidden" name="2fa-totp-key" value="<?php echo esc_attr( $key ); ?>" />
					<div class="wp2fa-setup-actions">
						<button class="button button-primary" type="submit" name="save_step" value="<?php esc_attr_e( 'Finish', 'wp-2fa' ); ?>"><?php esc_html_e( 'Finish', 'wp-2fa' ); ?></button>
					</div>
				</form>
			</div>
			<?php
			// Display any error notices if they are available.
			if ( isset( $notices['error'] ) && ! empty( $notices['error'] ) ) {
				foreach ( $notices['error'] as $notice ) {
					echo '<p class="description error">' . wp_kses_post( $notice ) . '</p>';
				}
			}
		}
	}

	/**
	 * Step Save: `Setup Authenticator`
	 */
	private function wp_2fa_step_reconfigure_authenticator_save() {
		// Check nonce.
		check_admin_referer( 'wp2fa-step-login' );
		// Grab current user
		$user = wp_get_current_user();

		// Setup some empty arrays which will may fill later, should an error arise along the way.
		$notices = array();
		$errors  = array();

		// Grab key from the $_POST
		if ( isset( $_POST['wp-2fa-totp-key'] ) ) {
			$current_key = sanitize_text_field( wp_unslash( $_POST['wp-2fa-totp-key'] ) );
		}

		// Check if we are dealing with totp or email, if totp validate and store a new secret key.
		if ( ! empty( $_POST['wp-2fa-totp-authcode'] ) && ! empty( $current_key ) ) {
			if ( Authentication::is_valid_key( $current_key ) || ! is_numeric( $_POST['wp-2fa-totp-authcode'] ) ) {
				if ( ! Authentication::is_valid_authcode( $current_key, $_POST['wp-2fa-totp-authcode'] ) ) {
					$errors[] = esc_html__( 'Invalid Two Factor Authentication code.', 'wp-2fa' );
				}
			} else {
				$errors[] = esc_html__( 'Invalid Two Factor Authentication secret key.', 'wp-2fa' );
			}

			// If its not totp, is it email?
		} elseif ( ! empty( $_POST['wp-2fa-email-authcode'] ) ) {
			if ( ! Authentication::validate_token( $user->ID, $_POST['wp-2fa-email-authcode'] ) ) {
				$errors[] = __( 'Invalid Email Authentication code.', 'wp-2fa' );
			}
		} else {
			$errors[] = __( 'Please enter the code to finalize the 2FA setup.', 'wp-2fa' );
		}

		if ( ! empty( $errors ) ) {
			$notices['error'] = $errors;
		}

		if ( ! empty( $notices ) ) {
			update_user_meta( $user->ID, self::NOTICES_META_KEY, $notices );
			delete_user_meta( $user->ID, 'wp_2fa_nominated_email_address' );
		}

		// If no errors found, lets continue to next step and clear the notices, should any be present from previous attempts.
		if ( empty( $notices ) ) {
			wp_safe_redirect( esc_url_raw( $this->get_next_step() ) );
			exit();
		}
	}

	/**
	 * 3rd Party plugins
	 */
	function wp_2fa_add_intro_step( $wizard_steps ) {
		$new_wizard_steps = array(
			'test' => array(
				'name'        => __( 'Welcome to WP 2FA', 'wp-security-audit-log' ),
				'content'     => array( $this, 'introduction_step' ),
				'save'        => array( $this, 'introduction_step_save' ),
				'wizard_type' => 'welcome_wizard',
			),
		);

		// combine the two arrays.
		$wizard_steps = $new_wizard_steps + $wizard_steps;

		return $wizard_steps;
	}

	private function introduction_step() {
		?>
		<form method="post" class="wsal-setup-form">
			<?php wp_nonce_field( 'wsal-step-addon' ); ?>
			<h3><?php esc_html_e( 'You are required to configure 2FA.', 'wp-security-audit-log' ); ?></h3>
			<p><?php esc_html_e( 'In order to keep this site - and your details secure, this website’s administrator requires you to enable 2FA authentication to continue.', 'wp-security-audit-log' ); ?></p>
			<p><?php esc_html_e( 'Two factor authentication ensures only you have access to your account by creating an added layer of security when logging in -', 'wp-security-audit-log' ); ?> <a href="https://www.wpwhitesecurity.com/two-factor-authentication-wordpress/" target="_blank"><?php esc_html_e( 'Learn more', 'wp-security-audit-log' ); ?></a></p>

			<div class="wsal-setup-actions">
				<button class="button button-primary"
				type="submit"
				name="save_step"
				value="<?php esc_attr_e( 'Next', 'wp-security-audit-log' ); ?>">
				<?php esc_html_e( 'Next', 'wp-security-audit-log' ); ?>
			</button>
		</div>
	</form>
		<?php
	}

	/**
	 * Step Save: `Addons`
	 */
	private function introduction_step_save() {
		// Check nonce.
		check_admin_referer( 'wsal-step-addon' );

		wp_safe_redirect( esc_url_raw( $this->get_next_step() ) );
		exit();
	}
}
