<?php // phpcs:ignore

namespace WP2FA\Admin;

use WP2FA\EmailTemplate;
use \WP2FA\WP2FA as WP2FA;
use \WP2FA\Authenticator\Authentication as Authentication;
use \WP2FA\BackgroundProcessing\ProcessUserMetaUpdate as ProcessUserMetaUpdate;

/**
 * SettingsPage - Class for handling settings
 */
class SettingsPage {

	/**
	 * Create admin menu entru and settings page
	 */
	public function create_settings_admin_menu() {
		// Create sub menu item.
		add_options_page(
			esc_html__( 'WP 2FA Settings', 'wp-2fa' ),
			esc_html__( 'Two-factor Authentication', 'wp-2fa' ),
			'manage_options',
			'wp-2fa-settings',
			array( $this, 'settings_page_render' )
		);

		// Register our settings page.
		register_setting(
			'wp_2fa_settings',
			'wp_2fa_settings',
			array( $this, 'validate_and_sanitize' )
		);

		register_setting(
			'wp_2fa_email_settings',
			'wp_2fa_email_settings',
			array( $this, 'validate_and_sanitize_email' )
		);
	}

	/**
	 * Create admin menu entru and settings page
	 */
	public function create_settings_admin_menu_multisite() {
		// Create sub menu item.
		add_submenu_page(
			'settings.php',
			esc_html__( 'WP 2FA Settings', 'wp-2fa' ),
			esc_html__( 'Two-factor Authentication', 'wp-2fa' ),
			'manage_options',
			'wp-2fa-settings',
			array( $this, 'settings_page_render' )
		);
		// Register our settings page.
		register_setting(
			'wp_2fa_settings',
			'wp_2fa_settings',
			array( $this, 'validate_and_sanitize' )
		);

		register_setting(
			'wp_2fa_email_settings',
			'wp_2fa_email_settings',
			array( $this, 'validate_and_sanitize_email' )
		);
	}

	/**
	 * Render the settings
	 */
	public function settings_page_render() {
		$user    = wp_get_current_user();
		$user_id = (int) $user->ID;
		if ( ! empty( WP2FA::get_wp2fa_setting( '2fa_settings_last_updated_by' ) ) ) {
			$main_user = (int) WP2FA::get_wp2fa_setting( '2fa_settings_last_updated_by' );
		} else {
			$main_user = '';
		}

		// Check if new user page has been published.
		if ( ! empty( get_transient( 'wp_2fa_new_custom_page_created' ) ) ) {
			delete_transient( 'wp_2fa_new_custom_page_created' );
			$new_page_id        = WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
			$new_page_permalink = get_permalink( $new_page_id );
			?>
			<div class="wp2fa-modal micromodal-slide" id="new-page-created" aria-hidden="false">
				<div class="modal__overlay" tabindex="-1" data-micromodal-close>
					<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
					<main class="modal__content" id="modal-1-content">
						<h3><?php esc_html_e( 'The plugin created the 2FA settings page with the URL:', 'wp-2fa' ); ?></h3>
						<h4>
							<a target="_blank" href="<?php echo esc_url( $new_page_permalink ); ?>"><?php echo esc_attr( $new_page_permalink ); ?></a>
						</h4>
						<p>
							<?php esc_html_e( 'You can edit this page using the page editor, like you do with all other pages.', 'wp-2fa' ); ?>
						</p>
						<p>
							<?php esc_html_e( 'Use the', 'wp-2fa' ); ?> <strong><?php esc_html_e( '{2fa_settings_page_url}', 'wp-2fa' ); ?></strong> <?php esc_html_e( 'html tag in the email templates to include the URL of the 2FA configuration page when notifying the users to configure two-factor authentication.', 'wp-2fa' ); ?>
						</p>
					</main>
					<footer class="modal__footer">
						<a href="#" class="modal__btn modal__btn-primary" data-trigger-remove-new-page-notice onclick="MicroModal.close('new-page-created');"><?php esc_html_e( 'OK', 'wp-2fa' ); ?></a>
					</footer>
					</div>
				</div>
			</div>
			<script>
				MicroModal.show('new-page-created');
			</script>
			<?php
		}
		?>
		<div class="wp2fa-modal micromodal-slide" id="notify-users" aria-hidden="false">
			<div class="modal__overlay" tabindex="-1" data-micromodal-close>
				<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
				<main class="modal__content" id="modal-1-content">
					<h3><?php esc_html_e( 'Notify users?', 'wp-2fa' ); ?></h3>
					<p>
						<?php esc_html_e( 'Would you like to notify all applicable users based on your changes?', 'wp-2fa' ); ?>
					</p>
				</main>
				<footer class="modal__footer">
					<a href="#" id="send-notification-email" class="modal__btn modal__btn"><?php esc_html_e( 'Notify users & save settings', 'wp-2fa' ); ?></a>
					<a href="#" id="save-settings" class="modal__btn modal__btn-primary"><?php esc_html_e( 'Save settings only', 'wp-2fa' ); ?></a>
				</footer>
				</div>
			</div>
		</div>
		<div class="wrap wp-2fa-settings-wrapper">
			<h2><?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?></h2>
			<hr>
			<?php if ( ! empty( WP2FA::get_wp2fa_setting( 'limit_access' ) ) && $main_user !== $user->ID ) { ?>

				<?php
				echo esc_html__( 'These settings have been disabled by your site administrator, please contact them for further assistance.', 'wp-2fa' );
				?>

			<?php } else { ?>

				<div class="nav-tab-wrapper">
					<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'wp-2fa-settings' ), network_admin_url( 'admin.php' ) ) ); ?>" class="nav-tab <?php echo ! isset( $_REQUEST['tab'] ) ? 'nav-tab-active' : ''; ?>"><?php _e( '2FA Settings', 'wp-2fa' ); ?></a>
					<a href="
					<?php
					echo esc_url(
						add_query_arg(
							array(
								'page' => 'wp-2fa-settings',
								'tab'  => 'email-settings',
							),
							network_admin_url( 'admin.php' )
						)
					);
					?>
					" class="nav-tab <?php echo isset( $_REQUEST['tab'] ) && 'email-settings' === $_REQUEST['tab'] ? 'nav-tab-active' : ''; ?>"><?php _e( 'Email Settings & Templates', 'wp-2fa' ); ?></a>
				</div>
					<?php
					if ( ! current_user_can( 'manage_options' ) ) {
						return;
					}
					if ( WP2FA::is_this_multisite() ) {
						$action = 'edit.php?action=update_wp2fa_network_options';
					} else {
						$action = 'options.php';
					}
					if ( ! isset( $_REQUEST['tab'] ) || isset( $_REQUEST['tab'] ) && '2fa-settings' === $_REQUEST['tab'] ) :
						?>
					<br/>
						<?php
						printf( '<p class="description">%1$s <a href="mailto:support@wpwhitesecurity.com">%2$s</a></p>', esc_html__( 'Use the settings below to configure the properties of the two-factor authentication on your website and how users use it. If you have any questions send us an email at', 'wp-2fa' ), esc_html__( 'support@wpwhitesecurity.com', 'wp-2fa' ) );
						?>
					<br/>
					<?php $total_users = count_users(); ?>
					<form id="wp-2fa-admin-settings" action='<?php echo esc_attr( $action ); ?>' method='post' autocomplete="off" data-2fa-total-users="<?php echo $total_users['total_users']; ?>">
						<?php
						if ( ! current_user_can( 'manage_options' ) ) {
							return;
						}

							settings_fields( 'wp_2fa_settings' );
							$this->select_method_setting();
							$this->select_enforcment_policy_setting();
							$this->user_profile_settings();
							$this->excluded_roles_or_users_setting();
						if ( WP2FA::is_this_multisite() ) {
							$this->excluded_network_sites();
						}
							$this->grace_period_setting();
							$this->disable_2fa_removal_setting();
							$this->limit_settings_access();
							$this->remove_data_upon_uninstall();
							submit_button();
						?>
					</form>
				<?php endif; ?>

				<?php
				if ( WP2FA::is_this_multisite() ) {
					$action = 'edit.php?action=update_wp2fa_network_email_options';
				} else {
					$action = 'options.php';
				}
				?>

				<?php if ( isset( $_REQUEST['tab'] ) && 'email-settings' === $_REQUEST['tab'] ) : ?>
					<br/>
					<?php
						printf( '<p class="description">%1$s <a href="mailto:support@wpwhitesecurity.com">%2$s</a></p>', esc_html__( 'Use the settings below to configure the emails which are sent to users as part of the 2FA plugin. If you have any questions send us an email at', 'wp-2fa' ), esc_html__( 'support@wpwhitesecurity.com', 'wp-2fa' ) );
					?>
					<br/>
					<form action='<?php echo esc_attr( $action ); ?>' method='post' autocomplete="off">
						<?php
						if ( ! current_user_can( 'manage_options' ) ) {
							return;
						}

						settings_fields( 'wp_2fa_email_settings' );
						$this->email_from_settings();
						$this->email_settings();
						submit_button( 'Save email settings and templates' );
						?>
					</form>
				<?php endif; ?>

			<?php } ?>
		</div>
		<?php
	}

	/**
	 * General settings
	 */
	private function select_method_setting() {
		?>
		<h3><?php esc_html_e( 'Which two-factor authentication methods can your users use on this website?', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'When you disable one of the below 2FA methods none of your users can use it.', 'wp-2fa' ); ?>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="2fa-method"><?php esc_html_e( 'Select the methods:', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
						<label for="totp">
							<input type="checkbox" id="totp" name="wp_2fa_settings[enable_totp]" value="enable_totp"
							<?php checked( 'enable_totp', WP2FA::get_wp2fa_setting( 'enable_totp' ), true ); ?>
							>
							<?php esc_html_e( 'one-time code via 2FA App (TOTP) - ', 'wp-2fa' ); ?><a href="https://www.wpwhitesecurity.com/support/kb/configuring-2fa-apps/?utm_source=plugin&utm_medium=referral&utm_campaign=wp2fa&utm_content=settings+pages" target="_blank"><?php esc_html_e( 'complete list of supported 2FA apps.', 'wp-2fa' ); ?></a>
						</label>
						<br/>
						<label for="email">
							<input type="checkbox" id="hotp" name="wp_2fa_settings[enable_email]" value="enable_email"
							<?php checked( WP2FA::get_wp2fa_setting( 'enable_email' ), 'enable_email' ); ?>
							>
							<?php esc_html_e( 'one-time code via email (HOTP)', 'wp-2fa' ); ?>
						</label>
						<br />
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Policy settings
	 */
	private function select_enforcment_policy_setting() {
		?>
		<h3><?php esc_html_e( 'Do you want to enforce 2FA for some, or all the users? ', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'When you enforce 2FA the users will be prompted to configure 2FA the next time they login. Users have a grace period for configuring 2FA. You can configure the grace period and also exclude user(s) or role(s) in this settings page. ', 'wp-2fa' ); ?> <a href="https://www.wpwhitesecurity.com/support/kb/configure-2fa-policies-enforce/?utm_source=plugin&utm_medium=referral&utm_campaign=wp2fa&utm_content=settings+pages" target="_blank"><?php esc_html_e( 'Learn more.', 'wp-2fa' ); ?></a>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="enforcment-policy"><?php esc_html_e( 'Enforce 2FA on:', 'wp-2fa' ); ?></label></th>
					<td>
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
								<?php $checked = in_array( WP2FA::get_wp2fa_setting( 'enforcment-policy' ), [ 'certain-roles-only', 'certain-users-only' ] ); ?>
								<input type="radio" name="wp_2fa_settings[enforcment-policy]" id="certain-roles-only" value="certain-roles-only"
								<?php checked( $checked ); ?>
								data-unhide-when-checked=".certain-roles-only-inputs, .certain-users-only-inputs">
								<span><?php esc_html_e( 'Only for specific users and roles', 'wp-2fa' ); ?></span>
							</label>
							<fieldset class="hidden certain-users-only-inputs">
								<br/>
								<input type="text" id="enforced_users_search" placeholder="<?php esc_html_e( 'Search users', 'wp-2fa' ); ?>">
								<input type="hidden" id="enforced_users" name="wp_2fa_settings[enforced_users]" value="<?php echo esc_attr( WP2FA::get_wp2fa_setting( 'enforced_users' ) ); ?>">
								<div id="enforced_users_buttons"></div>
							</fieldset>
							<fieldset class="hidden certain-roles-only-inputs">
								<br/>
								<input type="text" id="enforced_roles_search" placeholder="<?php esc_html_e( 'Search roles', 'wp-2fa' ); ?>">
								<input type="hidden" id="enforced_roles" name="wp_2fa_settings[enforced_roles]" value="<?php echo esc_attr( WP2FA::get_wp2fa_setting( 'enforced_roles' ) ); ?>">
								<div id="enforced_roles_buttons"></div>
							</fieldset>

							<br/>
							<label for="do-not-enforce">
								<input type="radio" name="wp_2fa_settings[enforcment-policy]" id="do-not-enforce" value="do-not-enforce"
								<?php checked( WP2FA::get_wp2fa_setting( 'enforcment-policy' ), 'do-not-enforce' ); ?>
								>
								<span><?php esc_html_e( 'Do not enforce on any users', 'wp-2fa' ); ?></span>
							</label>
							<br/>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * User profile settings
	 */
	private function user_profile_settings() {
		?>
		<h3><?php esc_html_e( 'Can users access the WordPress dashboard or you have custom profile pages? ', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'If your users do not have access to the WordPress dashboard (because you use custom user profile pages) enable this option. Once enabled, the plugin creates a page which ONLY authenticated users can access to configure their user 2FA settings. A link to this page is sent in the 2FA welcome email.', 'wp-2fa' ); ?></a>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="enforcment-policy"><?php esc_html_e( 'Create custom 2FA settings page', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
							<label class="radio-inline">
								<input id="use_custom_page" type="radio" name="wp_2fa_settings[create-custom-user-page]" value="yes"
								<?php checked( WP2FA::get_wp2fa_setting( 'create-custom-user-page' ), 'yes' ); ?>
								>
								<?php esc_html_e( 'Yes', 'wp-2fa' ); ?>
							</label>
							<label class="radio-inline">
								<input id="dont_use_custom_page" type="radio" name="wp_2fa_settings[create-custom-user-page]" value="no"
								<?php checked( WP2FA::get_wp2fa_setting( 'create-custom-user-page' ), 'no' ); ?>
								<?php checked( WP2FA::get_wp2fa_setting( 'create-custom-user-page' ), '' ); ?>
								>
								<?php esc_html_e( 'No', 'wp-2fa' ); ?>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr class="custom-user-page-setting disabled">
					<th><label for="enforcment-policy"><?php esc_html_e( 'Custom 2FA settings page', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
							<?php
							if ( ! empty( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) ) ) {
								$custom_slug = get_post_field( 'post_name', get_post( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) ) );
							} else {
								$custom_slug = WP2FA::get_wp2fa_setting( 'custom-user-page-url' );
							}

							$has_error = false;
							$settings_errors = get_settings_errors( 'wp_2fa_settings' );
							if (!empty($settings_errors)) {
								foreach ( $settings_errors as $error ) {
									if ($error['code'] == 'no_page_slug_provided') {
										$has_error = true;
										break;
									}
								}
							}

							?>
							<?php esc_html_e( 'Specify a URL for the Custom 2FA settings page URL:', 'wp-2fa' ); ?> <?php echo trailingslashit( get_site_url() ); ?>
							<input type="text" id="custom-user-page-url" name="wp_2fa_settings[custom-user-page-url]" value="<?php echo sanitize_text_field( $custom_slug ); ?>"<?php if ($has_error): ?> class="error"<?php endif; ?>>
						</fieldset>
						<?php
						if ( ! empty( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) ) ) {
							$edit_post_link = get_edit_post_link( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) );
							$view_post_link = get_permalink( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) );
							?>
							<br>
							<a href="<?php echo esc_url( $edit_post_link ); ?>" target="_blank" class="button button-secondary" style="margin-right: 5px;"><?php esc_html_e( 'Edit Page', 'wp-2fa' ); ?></a> <a href="<?php echo esc_url( $view_post_link ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'View Page', 'wp-2fa' ); ?></a>
							<?php
						}
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Role and users exclusion settings
	 */
	private function excluded_roles_or_users_setting() {
		?>
		<br>
		<h3><?php esc_html_e( 'Do you want to exclude any users or roles from 2FA? ', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'If you are enforcing 2FA on all users but for some reason you would like to exclude individual user(s) or users with a specific role, you can exclude them below', 'wp-2fa' ); ?>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="enforcment-policy"><?php esc_html_e( 'Exclude the following users', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
								<input type="text" id="excluded_users_search" placeholder="Search user name">
								<input type="hidden" id="excluded_users" name="wp_2fa_settings[excluded_users]"
								value="<?php echo sanitize_text_field( WP2FA::get_wp2fa_setting( 'excluded_users' ) ); ?>">
								<div id="excluded_users_buttons"></div>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th><label for="enforcment-policy"><?php esc_html_e( 'Exclude the following roles:', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
							<input type="text" id="excluded_roles_search" placeholder="Search roles">
							<input type="hidden" id="excluded_roles" name="wp_2fa_settings[excluded_roles]"
							value="<?php echo sanitize_text_field( WP2FA::get_wp2fa_setting( 'excluded_roles' ) ); ?>">
							<div id="excluded_roles_buttons"></div>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Role and users exclusion settings
	 */
	private function excluded_network_sites() {
		?>
		<br>
		<h3><?php esc_html_e( 'Do you want to exclude all the users of a site from 2FA? ', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'If you are enforcing 2FA on all users but for some reason you do not want to enforce it on a specific sub site, specify the sub site name below:', 'wp-2fa' ); ?>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="enforcment-policy"><?php esc_html_e( 'Exclude the following sites', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
								<input type="text" id="excluded_sites_search" placeholder="Search sites in your network">
								<input type="hidden" id="excluded_sites" name="wp_2fa_settings[excluded_sites]"
								value="<?php echo sanitize_text_field( WP2FA::get_wp2fa_setting( 'excluded_sites' ) ); ?>">
								<div id="excluded_sites_buttons"></div>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Grace period settings
	 */
	private function grace_period_setting() {
		$user = wp_get_current_user();

		$grace_period = (int) WP2FA::get_wp2fa_setting( 'grace-period' );
		$testing      = get_option( 'wp_2fa_test_grace' );
		if ( '1' === $testing ) {
			$grace_max = 600;
		} else {
			$grace_max = 10;
		}
		?>
		<br>
		<h3><?php esc_html_e( 'Should users be asked to setup 2FA instantly or should they have a grace period?', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'When you enforce 2FA on user(s) they have a grace period to configure 2FA. If they fail to configure it within the configured stipulated time, their account will be locked and have to be unlocked manually. Maximum grace period is 10 days.', 'wp-2fa' ); ?> <a href="https://www.wpwhitesecurity.com/support/kb/configure-grace-period-2fa/?utm_source=plugin&utm_medium=referral&utm_campaign=wp2fa&utm_content=settings+pages" target="_blank"><?php esc_html_e( 'Learn more.', 'wp-2fa' ); ?></a>
		</p>

		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="grace-policy"><?php esc_html_e( 'Grace period:', 'wp-2fa' ); ?></label></th>
					<td>
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
							<fieldset class="hidden grace-period-inputs">
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
									<label class="radio-inline">
										<input class="js-nested" type="radio" name="wp_2fa_settings[grace-period-denominator]" value="seconds"
										<?php checked( WP2FA::get_wp2fa_setting( 'grace-period-denominator' ), 'seconds' ); ?>
										>
										<?php esc_html_e( 'Seconds', 'wp-2fa' ); ?>
									</label>
									<?php
								}

								if ( ! empty( WP2FA::get_wp2fa_setting( '2fa_settings_last_updated_by' ) ) ) {
									$last_user_to_update_settings = WP2FA::get_wp2fa_setting( '2fa_settings_last_updated_by' );
								} else {
									$last_user_to_update_settings = $user->ID;
								}

								?>
								<input type="hidden" id="2fa_main_user" name="wp_2fa_settings[2fa_settings_last_updated_by]" value="<?php echo esc_attr( $last_user_to_update_settings ); ?>">
							</fieldset>
							<br/>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>


		<h3><?php esc_html_e( 'How often should the plugin check if a user\'s grace period is over?', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'By default the plugin checks if a users grace periods to setup 2FA has passed when the user tries to login. If you would like the plugin to advise the user within an hour, enable the below option to add a cron job that runs every hour.', 'wp-2fa' ); ?>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="grace-period"><?php esc_html_e( 'Enable cron', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
							<input type="checkbox" id="grace-cron" name="wp_2fa_settings[enable_grace_cron]" value="enable_grace_cron"
							<?php checked( 1, WP2FA::get_wp2fa_setting( 'enable_grace_cron' ), true ); ?>
							>
							<?php esc_html_e( 'Use cron job to check grace periods', 'wp-2fa' ); ?>
						</fieldset>
					</td>
				</tr>
				<tr class="disabled destory-session-setting">
					<th><label for="destory-session"><?php esc_html_e( 'Destroy session', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
							<input type="checkbox" id="destory-session" name="wp_2fa_settings[enable_destroy_session]" value="enable_destroy_session"
							<?php checked( 1, WP2FA::get_wp2fa_setting( 'enable_destroy_session' ), true ); ?>
							>
							<?php esc_html_e( 'Destory user session when grace period expires?', 'wp-2fa' ); ?>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Disable removal of 2FA settings
	 */
	private function disable_2fa_removal_setting() {
		$user = wp_get_current_user();
		?>
		<br>
		<h3><?php esc_html_e( 'Should users be able to disable 2FA on their user profile?', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'Users can configure and also disable 2FA on their profile by clicking the "Remove 2FA" button. Enable this setting to disable the Remove 2FA button so users cannot disable 2FA from their user profile.', 'wp-2fa' ); ?>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="hide-remove-2fa"><?php esc_html_e( 'Hide the Remove 2FA button', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
							<input type="checkbox" id="hide-remove-2fa" name="wp_2fa_settings[hide_remove_button]" value="hide_remove_button"
							<?php checked( 1, WP2FA::get_wp2fa_setting( 'hide_remove_button' ), true ); ?>
							>
							<?php esc_html_e( 'Hide the Remove 2FA button on user profile pages', 'wp-2fa' ); ?>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Limit settings setting
	 */
	private function limit_settings_access() {
		?>
		<br>
		<h3><?php esc_html_e( 'Limit 2FA settings access?', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'Use this setting to hide this plugin configuration area from all other admins.', 'wp-2fa' ); ?>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="grace-period"><?php esc_html_e( 'Limited access', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
							<input type="checkbox" id="limit_access" name="wp_2fa_settings[limit_access]" value="limit_access"
							<?php checked( 1, WP2FA::get_wp2fa_setting( 'limit_access' ), true ); ?>
							>
							<?php esc_html_e( 'Hide settings from other administrators', 'wp-2fa' ); ?>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Limit settings setting
	 */
	private function remove_data_upon_uninstall() {
		?>
		<div class="danger-zone-wrapper">
			<h3><?php esc_html_e( 'Do you want to delete the plugin data from the database upon uninstall?', 'wp-2fa' ); ?></h3>
			<p class="description">
				<?php esc_html_e( 'The plugin saves its settings in the WordPress database. By default the plugin settings are kept in the database so if it is installed again, you do not have to reconfigure the plugin. Enable this setting to delete the plugin settings from the database upon uninstall.', 'wp-2fa' ); ?>
			</p>
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="delete_data"><?php esc_html_e( 'Delete data', 'wp-2fa' ); ?></label></th>
						<td>
							<fieldset>
								<input type="checkbox" id="elete_data" name="wp_2fa_settings[delete_data_upon_uninstall]" value="delete_data_upon_uninstall"
								<?php checked( 1, WP2FA::get_wp2fa_setting( 'delete_data_upon_uninstall' ), true ); ?>
								>
								<?php esc_html_e( 'Delete data upon uninstall', 'wp-2fa' ); ?>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="form-table hidden">
				<tbody>
					<tr>
						<th></th>
						<td>
							<fieldset>
								<input type="checkbox" id="notify_users" name="wp_2fa_settings[notify_users]" value="notify_users">
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Get all users
	 */
	public function get_all_users() {
		// Die if user does not have permission to view.
		if ( ! current_user_can( 'administrator' ) ) {
			die( 'Access Denied.' );
		}
		// Filter $_GET array for security.
		$get_array = filter_input_array( INPUT_GET );

		// Die if nonce verification failed.
		if ( ! wp_verify_nonce( sanitize_text_field( $get_array['wp_2fa_nonce'] ), 'wp-2fa-settings-nonce' ) ) {
			die( esc_html__( 'Nonce verification failed.', 'wp-2fa' ) );
		}
		// Fetch users.
		$users = array();
		if ( WP2FA::is_this_multisite() ) {
			$users_args = array( 'blog_id' => 0 );
		} else {
			$users_args = array();
		}

		foreach ( get_users( $users_args ) as $user ) {
			if ( strpos( $user->user_login, $get_array['term'] ) !== false ) {
				array_push( $users, [
					'value' => $user->user_login,
					'label' => $user->user_login
				]);
			}
		}
		echo wp_json_encode( $users );
		exit;
	}

	/**
	 * Get all network sites
	 */
	public function get_all_network_sites() {
		// Die if user does not have permission to view.
		if ( ! current_user_can( 'administrator' ) ) {
			die( 'Access Denied.' );
		}
		// Filter $_GET array for security.
		$get_array = filter_input_array( INPUT_GET );
		// Die if nonce verification failed.
		if ( ! wp_verify_nonce( sanitize_text_field( $get_array['wp_2fa_nonce'] ), 'wp-2fa-settings-nonce' ) ) {
			die( esc_html__( 'Nonce verification failed.', 'wp-2fa' ) );
		}
		// Fetch sites.
		$sites_found = array();

		foreach ( get_sites() as $site ) {
			$subsite_id                  = get_object_vars( $site )['blog_id'];
			$subsite_name                = get_blog_details( $subsite_id )->blogname;
			$site_details                = '';
			$site_details[ $subsite_id ] = $subsite_name;
			if ( stripos( $subsite_name, $get_array['term'] ) !== false ) {
				$site_details = $subsite_name . ':' . $subsite_id;
				array_push( $sites_found, $site_details );
			}
		}
		echo wp_json_encode( $sites_found );
		exit;
	}

	/**
	 * Unlock users accounts if they have overrun grace period
	 *
	 * @param  int $user_id User ID.
	 */
	public function unlock_account( $user_id ) {
		// Die if user does not have permission to view.
		if ( ! current_user_can( 'administrator' ) ) {
			die( 'Access Denied.' );
		}

		$grace_period             = WP2FA::get_wp2fa_setting( 'grace-period' );
		$grace_period_denominator = WP2FA::get_wp2fa_setting( 'grace-period-denominator' );
		$create_a_string          = $grace_period . ' ' . $grace_period_denominator;
		// Turn that string into a time.
		$grace_expiry = strtotime( $create_a_string );

		// Filter $_GET array for security.
		$get_array = filter_input_array( INPUT_GET );
		$nonce     = sanitize_text_field( $get_array['wp_2fa_nonce'] );

		// Die if nonce verification failed.
		if ( ! wp_verify_nonce( $nonce, 'wp-2fa-unlock-account-nonce' ) ) {
			die( esc_html__( 'Nonce verification failed.', 'wp-2fa' ) );
		}

		if ( isset( $get_array['user_id'] ) ) {
			$unlock       = delete_user_meta( intval( $get_array['user_id'] ), 'wp_2fa_user_grace_period_expired' );
			$notification = delete_user_meta( intval( $get_array['user_id'] ), 'wp_2fa_locked_account_notification' );
			$update       = update_user_meta( intval( $get_array['user_id'] ), 'wp_2fa_grace_period_expiry', $grace_expiry );
			$this->send_account_unlocked_email( intval( $get_array['user_id'] ) );
			add_action( 'admin_notices', array( $this, 'user_unlocked_notice' ) );
		}
	}

	/**
	 * Remove user 2fa config
	 *
	 * @param  int $user_id User ID.
	 */
	public function remove_user_2fa( $user_id ) {
		// Filter $_GET array for security.
		$get_array = filter_input_array( INPUT_GET );
		$nonce     = sanitize_text_field( $get_array['wp_2fa_nonce'] );

		if ( ! wp_verify_nonce( $nonce, 'wp-2fa-remove-user-2fa-nonce' ) ) {
			die( esc_html__( 'Nonce verification failed.', 'wp-2fa' ) );
		}

		if ( isset( $get_array['user_id'] ) ) {
			$user_id              = intval( $get_array['user_id'] );
			$wipe_totp_key        = delete_user_meta( $user_id, 'wp_2fa_totp_key' );
			$wipe_backup_codes    = delete_user_meta( $user_id, 'wp_2fa_backup_codes' );
			$wipe_enabled_methods = delete_user_meta( $user_id, 'wp_2fa_enabled_methods' );
			$wipe_grace_period    = delete_user_meta( $user_id, 'wp_2fa_grace_period_expiry' );
			$wipe_email_address   = delete_user_meta( $user_id, 'wp_2fa_nominated_email_address' );
			$is_needed            = Authentication::is_user_eligible_for_2fa( $user_id );
			if ( $is_needed ) {
				if ( 'do-not-enforce' !== WP2FA::get_wp2fa_setting( 'enforcment-policy' ) ) {
					// Turn inputs into a useable string.
					$create_a_string = WP2FA::get_wp2fa_setting( 'grace-period' ) . ' ' . WP2FA::get_wp2fa_setting( 'grace-period-denominator' );
					// Turn that string into a time.
					$grace_expiry = strtotime( $create_a_string );
					update_user_meta( $user_id, 'wp_2fa_grace_period_expiry', $grace_expiry );
					update_user_meta( $user_id, 'wp_2fa_update_nag_dismissed', true );
				}
			}
			if ( isset( $get_array['admin_reset'] ) ) {
				add_action( 'admin_notices', array( $this, 'admin_deleted_2fa_notice' ) );
			} else {
				add_action( 'admin_notices', array( $this, 'user_deleted_2fa_notice' ) );
			}
		}
	}

	/**
	 * Send account unlocked notification via email.
	 *
	 * @param int $user_id user ID.
	 *
	 * @return boolean
	 */
	public static function send_account_unlocked_email( $user_id ) {
		// Bail if the user has not enabled this email.
		if ( 'enable_account_unlocked_email' !== WP2FA::get_wp2fa_email_templates( 'send_account_unlocked_email' ) ) {
			return false;
		}

		// Grab user data.
		$user = get_userdata( $user_id );
		// Grab user email.
		$email = $user->user_email;
		// Setup the email contents.
		$subject = wp_strip_all_tags( WP2FA::replace_email_strings( WP2FA::get_wp2fa_email_templates( 'user_account_unlocked_email_subject' ) ) );
		$message = wpautop( WP2FA::replace_email_strings( WP2FA::get_wp2fa_email_templates( 'user_account_unlocked_email_body' ), $user_id ) );

		self::send_email($email, $subject, $message);
	}

	/**
	 * Validate options before saving
	 *
	 * @param  array $input The settings array.
	 */
	public function validate_and_sanitize( $input ) {
		// Bail if user doesnt have permissions to be here.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Setup args we may need, depending if this is a MS setup or not.
		$users      = array();
		$users_args = array();
		if ( WP2FA::is_this_multisite() ) {
			$users_args['blog_id'] = 0;
		}
		$total_users = count_users();
		$batch_size  = 2000;
		$slices      = ceil( $total_users['total_users'] / $batch_size );

		if ( ! isset( $input['enable_totp'] ) && ! isset( $input['enable_email'] ) ) {
			add_settings_error(
				'wp_2fa_settings',
				esc_attr( 'enable_email_settings_error' ),
				esc_html__( 'At least one 2FA method should be enabled.', 'wp-2fa' ),
				'error'
			);
		}

		// Compare current to old value to see if a method which was once enabled, has now been disabled.
		if ( ! isset( $input['enable_totp'] ) && 'enable_totp' === WP2FA::get_wp2fa_setting( 'enable_totp' ) || ! isset( $input['enable_email'] ) && 'enable_email' === WP2FA::get_wp2fa_setting( 'enable_email' ) ) {
			if ( ! isset( $input['enable_totp'] ) && 'enable_totp' === WP2FA::get_wp2fa_setting( 'enable_totp' ) ) {
				$removing = 'totp';
			} elseif ( ! isset( $input['enable_email'] ) && 'enable_email' === WP2FA::get_wp2fa_setting( 'enable_email' ) ) {
				$removing = 'email';
			}
			// Flush the old expiry away from ALL users, we will re-apply them based on the current setup at the end of this.
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
					$item_to_process['method_to_remove']  = $removing;
					$background_process->push_to_queue( $item_to_process );
				}

				$background_process->save()->dispatch();
			}
		}

		if ( isset( $input['enable_totp'] ) && 'enable_totp' === $input['enable_totp'] ) {
			$output['enable_totp'] = sanitize_text_field( $input['enable_totp'] );
		}

		if ( isset( $input['enable_email'] ) && 'enable_email' === $input['enable_email'] ) {
			$output['enable_email'] = sanitize_text_field( $input['enable_email'] );
		}

		if ( isset( $input['enforcment-policy'] )
			 && in_array( $input['enforcment-policy'], [ 'all-users', 'certain-users-only', 'certain-roles-only', 'do-not-enforce', 'superadmins-only' ]) ) {
			// Clear enforced roles/users if setting has changed.
			if ( 'all-users' === $input['enforcment-policy'] ) {
				$input['enforced_users'] = '';
				$input['enforced_roles'] = '';
			}

			$output['enforcment-policy'] = sanitize_text_field( $input['enforcment-policy'] );
		}

		if ( WP2FA::get_wp2fa_setting( 'enforcment-policy' ) !== $input['enforcment-policy'] && 'do-not-enforce' === $input['enforcment-policy'] ) {
			$input['enforced_users'] = '';
			$input['enforced_roles'] = '';
		}

		if ( 'certain-roles-only' === $input['enforcment-policy'] && empty( $input['enforced_roles'] ) && empty( $input['enforced_users'] ) ) {
			add_settings_error(
				'wp_2fa_settings',
				esc_attr( 'enforced_roles_settings_error' ),
				esc_html__( 'You must specify at least one role or user', 'wp-2fa' ),
				'error'
			);
		}

		if ( isset( $input['enforced_roles'] ) ) {
			$output['enforced_roles'] = trim( sanitize_text_field( $input['enforced_roles'] ) );
		}

		if ( isset( $input['enforced_users'] ) ) {
			$output['enforced_users'] = trim( sanitize_text_field( $input['enforced_users'] ) );
		}

		if ( isset( $input['excluded_users'] ) ) {
			$output['excluded_users'] = trim( sanitize_text_field( $input['excluded_users'] ) );

			// Wipe user 2fa data.
			$user_array = explode( ',', $output['excluded_users'] );
			foreach ( $user_array as $user ) {
				if ( ! empty( $user ) ) {
					$user_to_wipe         = get_user_by( 'login', $user );
					$wipe_totp_key        = delete_user_meta( $user_to_wipe->ID, 'wp_2fa_totp_key' );
					$wipe_backup_codes    = delete_user_meta( $user_to_wipe->ID, 'wp_2fa_backup_codes' );
					$wipe_enabled_methods = delete_user_meta( $user_to_wipe->ID, 'wp_2fa_enabled_methods' );
					$wipe_grace_period    = delete_user_meta( $user_to_wipe->ID, 'wp_2fa_grace_period_expiry' );
				}
			}
		}

		if ( isset( $input['excluded_roles'] ) ) {
			$output['excluded_roles'] = trim( sanitize_text_field( $input['excluded_roles'] ) );
			$excluded_roles_array     = array_filter( explode( ',', strtolower( $output['excluded_roles'] ) ) );

			// Flush the old expiry away from ALL users, we will re-apply them based on the current setup at the end of this.
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
		}

		if ( WP2FA::is_this_multisite() ) {
			if ( isset( $input['excluded_sites'] ) ) {
				$output['excluded_sites'] = trim( sanitize_text_field( $input['excluded_sites'] ) );
			}
		} else {
			$output['excluded_sites'] = '';
		}

		if ( isset( $input['grace-policy'] ) ) {
			$output['grace-policy'] = sanitize_text_field( $input['grace-policy'] );
		}

		if ( isset( $input['notify_users'] ) ) {
			$output['notify_users'] = sanitize_text_field( $input['notify_users'] );
		} else {
			$input['notify_users'] = '';
		}

		if ( isset( $input['grace-period'] ) ) {
			if ( 0 === (int) $input['grace-period'] ) {
				add_settings_error(
					'wp_2fa_settings',
					esc_attr( 'grace_settings_error' ),
					esc_html__( 'Grace period must be at least 1 day/hour', 'wp-2fa' ),
					'error'
				);
				$output['grace-period'] = 1;
			} else {
				$output['grace-period'] = (int) $input['grace-period'];
			}
		}

		if ( isset( $input['grace-period-denominator'] ) && 'days' === $input['grace-period-denominator'] || isset( $input['grace-period-denominator'] ) && 'hours' === $input['grace-period-denominator'] || isset( $input['grace-period-denominator'] ) && 'seconds' === $input['grace-period-denominator'] ) {
			$output['grace-period-denominator'] = sanitize_text_field( $input['grace-period-denominator'] );
		}

		if ( isset( $input['create-custom-user-page'] ) && 'yes' === $input['create-custom-user-page'] || isset( $input['create-custom-user-page'] ) && 'no' === $input['create-custom-user-page'] ) {
			$output['create-custom-user-page'] = sanitize_text_field( $input['create-custom-user-page'] );
		}

		if ( isset( $input['custom-user-page-url'] ) ) {
			if ( $input['custom-user-page-url'] !== WP2FA::get_wp2fa_setting( 'custom-user-page-url' ) ) {
				if ( ! empty( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) ) ) {
					$updated_post = array(
						'ID'        => WP2FA::get_wp2fa_setting( 'custom-user-page-id' ),
						'post_name' => sanitize_title_with_dashes( $input['custom-user-page-url'] ),
					);
					wp_update_post( $updated_post );
					$output['custom-user-page-url'] = sanitize_title_with_dashes( $input['custom-user-page-url'] );
					$output['custom-user-page-id']  = WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
				} elseif ( 'yes' === $input['create-custom-user-page'] && ! empty( $input['custom-user-page-url'] ) ) {
					$output['custom-user-page-url'] = sanitize_title_with_dashes( $input['custom-user-page-url'] );
					$create_page                    = $this->generate_custom_user_profile_page( $output['custom-user-page-url'] );
					$output['custom-user-page-id']  = (int) $create_page;
				}
			} else {
				$output['custom-user-page-url'] = sanitize_title_with_dashes( $input['custom-user-page-url'] );
				$output['custom-user-page-id']  = WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
			}
		}

		if ( isset( $_REQUEST['page'] ) && 'wp-2fa-setup' !== $_REQUEST['page'] || isset( $_REQUEST['wp_2fa_settings']['create-custom-user-page'] ) ) {

			if ( isset( $input['create-custom-user-page'] ) && 'no' === $input['create-custom-user-page'] ) {
				$output['custom-user-page-url'] = '';
				$output['custom-user-page-id']  = '';
				wp_delete_post( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ), true );
			}
		}

		if ( isset( $input['create-custom-user-page'] ) && 'yes' === $input['create-custom-user-page'] && empty( $input['custom-user-page-url'] ) ) {
			add_settings_error(
				'wp_2fa_settings',
				esc_attr( 'no_page_slug_provided' ),
				esc_html__( 'You must provide a new page slug.', 'wp-2fa' ),
				'error'
			);
		}

		if ( isset( $input['enable_grace_cron'] ) ) {
			$output['enable_grace_cron'] = (bool) $input['enable_grace_cron'];
		}

		if ( isset( $input['enable_destroy_session'] ) ) {
			$output['enable_destroy_session'] = (bool) $input['enable_destroy_session'];
		}

		if ( isset( $input['2fa_settings_last_updated_by'] ) ) {
			$output['2fa_settings_last_updated_by'] = esc_attr( trim( $input['2fa_settings_last_updated_by'] ) );
		}

		if ( isset( $input['limit_access'] ) ) {
			$output['limit_access'] = (bool) $input['limit_access'];
		}

		if ( isset( $input['delete_data_upon_uninstall'] ) ) {
			$output['delete_data_upon_uninstall'] = (bool) $input['delete_data_upon_uninstall'];
		}

		if ( isset( $input['grace-period'] ) && isset( $input['grace-period-denominator'] ) ) {
			// Turn inputs into a useable string.
			$create_a_string = $output['grace-period'] . ' ' . $output['grace-period-denominator'];
			// Turn that string into a time.
			$grace_expiry                       = strtotime( $create_a_string );
			$output['grace-period-expiry-time'] = sanitize_text_field( $grace_expiry );
		}

		if ( isset( $input['hide_remove_button'] ) ) {
			$output['hide_remove_button'] = (bool) $input['hide_remove_button'];
		}

		// Fetch users and apply the grace period to their user meta.
		if ( isset( $input['enforcment-policy'] ) && 'do-not-enforce' !== $input['enforcment-policy'] && ! isset( $input['grace-period-expiry-time'] ) ) {
			// Flush the old expiry away from ALL users, we will re-apply them based on the current setup at the end of this.
			for ( $count = 0; $count < $slices; $count++ ) {
				$users_args = array(
					'number' => $batch_size,
					'offset' => $count * $batch_size,
					'fields' => array( 'ID' ),
				);
				if ( WP2FA::is_this_multisite() ) {
					$users_args['blog_id'] = 0;
				}
				$users      = get_users( $users_args );
				if ( ! empty( $users ) ) {
					$background_process       = new ProcessUserMetaUpdate();
					$item_to_process          = array();
					$item_to_process['users'] = $users;
					$item_to_process['task']  = 'delete_grace_period';
					$background_process->push_to_queue( $item_to_process );
				}
				$background_process->save()->dispatch();
			}

			// If we are specifying to enforce 2fa for specific users, we have no need to check if they are eligible or excluded, so we dont.
			if ( isset( $input['enforcment-policy'] ) && 'certain-roles-only' === $input['enforcment-policy']
				 && isset( $input['enforced_users'] ) && WP2FA::get_wp2fa_setting( 'enforced_users' ) !== $input['enforced_users']
				 || isset( $input['enforcment-policy'] ) && 'certain-roles-only' === $input['enforcment-policy']
					&& isset( $input['enforced_roles'] ) && WP2FA::get_wp2fa_setting( 'enforced_roles' ) !== $input['enforced_roles'] ) {
				$enforced_users_array = array_filter( explode( ',', $input['enforced_users'] ) );

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
					$users      = get_users( $users_args );
					if ( ! empty( $users ) ) {

						if ( isset( $output['enforced_roles'] ) && empty( $output['enforced_roles'] ) ) {
							$enforced_roles = 'none';
						} else {
							$enforced_roles = SettingsPage::extract_roles_from_input( $output['enforced_roles'] );
						}
						if ( isset( $output['enforced_users'] ) && empty( $output['enforced_users'] ) ) {
							$enforced_users = 'none';
						} else {
							$enforced_users = $output['enforced_users'];
						}

						foreach ( $users as $user ) {
							if ( in_array( $user->user_login, $enforced_users_array ) ) {
								$background_process              = new ProcessUserMetaUpdate();
								$item_to_process                 = array();
								$item_to_process['user']         = $user;
								$item_to_process['task']         = 'enforce_2fa_for_user';
								$item_to_process['grace_expiry'] = $grace_expiry;
								$item_to_process['grace_policy'] = sanitize_text_field( $input['grace-policy'] );
								$item_to_process['notify_users'] = $input['notify_users'];
								$background_process->push_to_queue( $item_to_process );
							} else {
								$is_needed = Authentication::is_user_eligible_for_2fa( $user->ID, $input['enforcment-policy'], $output['excluded_users'], $output['excluded_roles'], $enforced_users, $enforced_roles );
								if ( ! $is_needed ) {
									continue;
								}

								$is_user_excluded = WP2FA::is_user_excluded( $user, $output['excluded_users'], $output['excluded_roles'], $output['excluded_sites'] );
								if ( ! $is_user_excluded ) {
									$item_to_process                 = array();
									$item_to_process['user']         = $user;
									$item_to_process['task']         = 'enforce_2fa_for_user';
									$item_to_process['grace_expiry'] = $grace_expiry;
									$item_to_process['grace_policy'] = sanitize_text_field( $input['grace-policy'] );
									$item_to_process['notify_users'] = $input['notify_users'];
									$background_process->push_to_queue( $item_to_process );
								}
							}
						}
					}

					$background_process->save()->dispatch();
				}

			} else {

				// Flush the old expiry away from ALL users, we will re-apply them based on the current setup at the end of this.
				for ( $count = 0; $count < $slices; $count++ ) {
					$users_args = array(
						'number' => $batch_size,
						'offset' => $count * $batch_size,
						'fields' => array( 'ID' ),
					);
					if ( WP2FA::is_this_multisite() ) {
						$users_args['blog_id'] = 0;
					}
					$users      = get_users( $users_args );

					if ( ! empty( $users ) ) {
						$background_process                   = new ProcessUserMetaUpdate();
						$item_to_process                      = array();
						$item_to_process['users']             = $users;
						$item_to_process['task']              = 'enforce_2fa_for_user';
						$item_to_process['grace_expiry']      = $grace_expiry;
						$item_to_process['grace_policy']      = sanitize_text_field( $input['grace-policy'] );
						$item_to_process['notify_users']      = $input['notify_users'];
						$item_to_process['enforcment-policy'] = $input['enforcment-policy'];
						$item_to_process['excluded_users']    = $output['excluded_users'];
						$item_to_process['excluded_roles']    = $output['excluded_roles'];
						$item_to_process['enforced_users']    = $output['enforced_users'];
						$item_to_process['enforced_roles']    = $output['enforced_roles'];
						$item_to_process['excluded_sites']    = $output['excluded_sites'];
						$background_process->push_to_queue( $item_to_process );
					}

					$background_process->save()->dispatch();
				}
			}
		}

		if ( isset( $input['enforcment-policy'] ) && 'do-not-enforce' === $input['enforcment-policy'] && ! isset( $input['grace-period-expiry-time'] ) ) {
			for ( $count = 0; $count < $slices; $count++ ) {
				$users_args = array(
					'number' => $batch_size,
					'offset' => $count * $batch_size,
					'fields' => array( 'ID' ),
				);
				if ( WP2FA::is_this_multisite() ) {
					$users_args['blog_id'] = 0;
				}
				$users      = get_users( $users_args );
				if ( ! empty( $users ) ) {
					$background_process       = new ProcessUserMetaUpdate();
					$item_to_process          = array();
					$item_to_process['users'] = $users;
					$item_to_process['task']  = 'delete_grace_period';
					$background_process->push_to_queue( $item_to_process );
				}
				$background_process->save()->dispatch();
			}
		}

		// Remove duplicates from settings errors. We do this as this sanitization callback is actually fired twice, so we end up with duplicates when saving the settings for the FIRST TIME only. The issue is not present once the settings are in the DB as the sanitization wont fire again. For details on this core issue - https://core.trac.wordpress.org/ticket/21989
		global $wp_settings_errors;
		if ( isset( $wp_settings_errors ) ) {
			$errors             = array_map( 'unserialize', array_unique( array_map( 'serialize', $wp_settings_errors ) ) );
			$wp_settings_errors = $errors;
		}

		return $output;
	}

	/**
	 * Hide settings menu item
	 */
	public function hide_settings() {
		$user = wp_get_current_user();

		// Check we have a user before doing anything else.
		if ( is_a( $user, '\WP_User' ) ) {
			$user_id = (int) $user->ID;
			if ( ! empty( WP2FA::get_wp2fa_setting( '2fa_settings_last_updated_by' ) ) ) {
				$main_user = (int) WP2FA::get_wp2fa_setting( '2fa_settings_last_updated_by' );
			} else {
				$main_user = '';
			}
			if ( ! empty( WP2FA::get_wp2fa_setting( 'limit_access' ) ) && $user->ID !== $main_user ) {
				// Remove admin menu item.
				remove_submenu_page( 'options-general.php', 'wp-2fa-settings' );
			}
		}
	}

	/**
	 * Add unlock user link to user actions.
	 *
	 * @param array $links Default row content.
	 */
	public function add_plugin_action_links( $links ) {

		if ( WP2FA::is_this_multisite() ) {
			$url = network_admin_url( '/settings.php?page=wp-2fa-settings' );
		} else {
			$url = admin_url( '/options-general.php?page=wp-2fa-settings' );
		}

		$links = array_merge(
			array(
				'<a href="' . esc_url( $url ) . '">' . esc_html__( 'Configure 2FA Settings', 'wp-2fa' ) . '</a>',
			),
			$links
		);

		return $links;

	}

	/**
	 * User unlocked notice.
	 */
	public function user_unlocked_notice() {
		?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'User account successfully unlocked. User can login again.', 'wp-2fa' ); ?></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'wp-2fa' ); ?></span>
				</button>
			</div>
		<?php
	}

	/**
	 * User deleted 2FA settings notification
	 */
	public function user_deleted_2fa_notice() {
		?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Your 2FA settings have been removed.', 'wp-2fa' ); ?></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'wp-2fa' ); ?></span>
				</button>
			</div>
		<?php
	}

	/**
	 * Admin deleted user 2FA settings notification
	 */
	public function admin_deleted_2fa_notice() {
		?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'User 2FA settings have been removed.', 'wp-2fa' ); ?></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'wp-2fa' ); ?></span>
				</button>
			</div>
		<?php
	}

	/**
	 * Semd email to let user know they need to enabled 2FA
	 *
	 * @param  int $user_id User ID.
	 */
	public static function send_2fa_enforced_email( $user_id, $override_grace_period = '' ) {
		// Bail if the user has not enabled this email.
		if ( 'enable_enforced_email' !== WP2FA::get_wp2fa_email_templates( 'send_enforced_email' ) ) {
			return false;
		}

		$user_id = (int) $user_id;
		// Grab user data.
		$user = get_userdata( $user_id );

		// Check if user has any enabled 2FA methods before sending.
		$enabled_methods = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );
		if ( ! empty( $enabled_methods ) ) {
			return false;
		}

		// Grab user email.
		$email = $user->user_email;

		$subject = wp_strip_all_tags( WP2FA::replace_email_strings( WP2FA::get_wp2fa_email_templates( 'enforced_email_subject' ), $user_id, '', $override_grace_period ) );
		$message = wpautop( WP2FA::replace_email_strings( WP2FA::get_wp2fa_email_templates( 'enforced_email_body' ), $user_id, '', $override_grace_period ) );

		return self::send_email( $email, $subject, $message );
	}

	public function update_wp2fa_network_options() {
		check_admin_referer( 'wp_2fa_settings-options' );

		if ( isset( $_POST['wp_2fa_settings'] ) ) {
			$options        = $this->validate_and_sanitize( wp_unslash( $_POST['wp_2fa_settings'] ) );
			$update_options = update_network_option( null, 'wp_2fa_settings', $options );
		}

		// redirect back to our options page.
		wp_safe_redirect(
			add_query_arg(
				array(
					'page'                            => 'wp-2fa-settings',
					'wp_2fa_network_settings_updated' => 'true',
				),
				network_admin_url( 'settings.php' )
			)
		);
		exit;
	}

	/**
	 * Handle saving email options to the network main site options.
	 */
	public function update_wp2fa_network_email_options() {
		if ( isset( $_POST['email_from_setting'] ) ) {
			$options = $this->validate_and_sanitize_email( wp_unslash( $_POST ) );

			if ( isset( $_POST['email_from_setting'] ) && 'use-custom-email' === $_POST['email_from_setting'] && isset( $_POST['custom_from_display_name'] ) && empty( $_POST['custom_from_display_name'] ) || isset( $_POST['email_from_setting'] ) && 'use-custom-email' === $_POST['email_from_setting'] && isset( $_POST['custom_from_email_address'] ) && empty( $_POST['custom_from_email_address'] ) ) {
				// redirect back to our options page.
				wp_safe_redirect(
					add_query_arg(
						array(
							'page' => 'wp-2fa-settings',
							'wp_2fa_network_settings_updated' => 'false',
							'tab'  => 'email-settings',
						),
						network_admin_url( 'settings.php' )
					)
				);
				exit;
			}

			$update_options = update_network_option( null, 'wp_2fa_email_settings', $options );
		}

		// redirect back to our options page.
		wp_safe_redirect(
			add_query_arg(
				array(
					'page'                            => 'wp-2fa-settings',
					'wp_2fa_network_settings_updated' => 'true',
					'tab'                             => 'email-settings',
				),
				network_admin_url( 'settings.php' )
			)
		);
		exit;
	}

	/**
	 * These are used instead of add_settings_error which in a network site. Used to show if settings have been updated or failed.
	 */
	public function settings_saved_network_admin_notice() {
		if ( isset( $_GET['wp_2fa_network_settings_updated'] ) && $_GET['wp_2fa_network_settings_updated'] == 'true' ) :
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( '2FA Settings Updated', 'wp-2fa' ); ?></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'wp-2fa' ); ?></span>
				</button>
			</div>
			<?php
		endif;
		if ( isset( $_GET['wp_2fa_network_settings_updated'] ) && $_GET['wp_2fa_network_settings_updated'] == 'false' ) :
			?>
			<div class="notice notice-error is-dismissible">
				<p><?php esc_html_e( 'Please ensure both custom email address and display name are provided.', 'wp-2fa' ); ?></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'wp-2fa' ); ?></span>
				</button>
			</div>
			<?php
		endif;
	}

	/**
	 * Email settings
	 */
	private function email_from_settings() {
		?>
		<h3><?php esc_html_e( 'Which email address should the plugin use as a from address?', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'Use these settings to customize the "from" name and email address for all correspondence sent from our plugin.', 'wp-2fa' ); ?>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="2fa-method"><?php esc_html_e( 'From email & name', 'wp-2fa' ); ?></label>
					</th>
					<td>
						<fieldset class="contains-hidden-inputs">
							<label for="use-defaults">
								<input type="radio" name="email_from_setting" id="use-defaults" value="use-defaults"
								<?php checked( WP2FA::get_wp2fa_email_templates( 'email_from_setting' ), 'use-defaults' ); ?>
								>
							<span><?php esc_html_e( 'Use the email address from the WordPress general settings.', 'wp-2fa' ); ?></span>
							</label>

							<br/>
							<label for="use-custom-email">
								<input type="radio" name="email_from_setting" id="use-custom-email" value="use-custom-email"
								<?php checked( WP2FA::get_wp2fa_email_templates( 'email_from_setting' ), 'use-custom-email' ); ?>
								data-unhide-when-checked=".custom-from-inputs">
								<span><?php esc_html_e( 'Use another email address', 'wp-2fa' ); ?></span>
							</label>
							<fieldset class="hidden custom-from-inputs">
								<br/>
								<span><?php esc_html_e( 'Email Address:', 'wp-2fa' ); ?></span> <input type="text" id="custom_from_email_address" name="custom_from_email_address" value="<?php echo WP2FA::get_wp2fa_email_templates( 'custom_from_email_address' ); ?>"><br><br>
								<span><?php esc_html_e( 'Display Name:', 'wp-2fa' ); ?></span> <input type="text" id="custom_from_display_name" name="custom_from_display_name" value="<?php echo WP2FA::get_wp2fa_email_templates( 'custom_from_display_name' ); ?>">
							</fieldset>

						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>

		<br>
		<hr>

		<h3><?php esc_html_e( 'Email delivery test', 'wp-2fa' ); ?></h3>
		<p class="description">
			<?php esc_html_e( 'The plugin sends emails to notify users to setup 2FA when the policies are enabled, to send the one-time codes and more. Use the button below to confirm the plugin can successfully send emails.', 'wp-2fa' ); ?>
		</p>
		<p>
			<button type="button" name="test_email_config_test"
					class="button js-button-test-email-trigger"
					data-email-id="config_test"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp-2fa-email-test-config_test' ) ); ?>">
				<?php esc_html_e( 'Test email delivery', 'wp-2fa' ); ?>
			</button>
		</p>

		<br>
		<hr>

		<?php
	}

	/**
	 * Creates the email notification definitions.
	 *
	 * @return EmailTemplate[]
	 */
	public function get_email_notification_definitions( ) {
		$result = [
				new EmailTemplate(
						'enforced',
						esc_html__( 'Enforced 2FA email', 'wp-2fa' ),
						esc_html__( 'This is the email sent to applicable users when you enforce 2fa.', 'wp-2fa' )
				),
				new EmailTemplate(
						'login_code',
						esc_html__( 'Login code email', 'wp-2fa' ),
						esc_html__( 'This is the email sent to a user when a login code is required.', 'wp-2fa' )
				),
				new EmailTemplate(
						'account_locked',
						esc_html__( 'User account locked email', 'wp-2fa' ),
						esc_html__( 'This is the email sent to a user upon grace period expiry.', 'wp-2fa' )
				),
				new EmailTemplate(
						'account_unlocked',
						esc_html__( 'User account unlocked email', 'wp-2fa' ),
						esc_html__( 'This is the email sent to a user when the user\'s account has been unlocked.', 'wp-2fa' )
				)
		];

		$result[1]->setCanBeToggled(false);
		$result[2]->setEmailContentId('user_account_locked');
		$result[3]->setEmailContentId('user_account_unlocked');
		return $result;
	}
	/**
	 * Email settings
	 */
	private function email_settings() {
		$custom_user_page_id = WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
		$email_template_definitions = $this->get_email_notification_definitions();
		?>
		<h1><?php esc_html_e( 'Email Templates', 'wp-2fa' ); ?></h1>
		<?php foreach ($email_template_definitions as $email_template) : ?>
		<?php $template_id = $email_template->getId(); ?>
		<h3><?php echo $email_template->getTitle(); ?></h3>
		<p class="description"><?php echo $email_template->getDescription(); ?></p>
		<table class="form-table">
			<tbody>
			<?php if ($email_template->canBeToggled()): ?>
				<tr>
					<th><label for="send_<?php echo $template_id; ?>_email"><?php esc_html_e( 'Send this email', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
							<input type="checkbox" id="send_<?php echo $template_id; ?>_email" name="send_<?php echo $template_id; ?>_email" value="enable_<?php echo $template_id; ?>_email"
							<?php checked( 'enable_' . $template_id . '_email', WP2FA::get_wp2fa_email_templates( 'send_' . $template_id . '_email' )); ?>
							>
							<label for="send_<?php echo $template_id; ?>_email"><?php esc_html_e( 'Uncheck to disable this message.', 'wp-2fa' ); ?></label>
						</fieldset>
					</td>
				</tr>
			<?php endif; ?>
				<?php $template_id = $email_template->getEmailContentId(); ?>
				<tr>
					<th><label for="<?php echo $template_id; ?>_email_subject"><?php esc_html_e( 'Email subject', 'wp-2fa' ); ?></label></th>
					<td>
						<fieldset>
							<input type="text" id="<?php echo $template_id; ?>_email_subject" name="<?php echo $template_id; ?>_email_subject" class="large-text" value="<?php esc_html_e( WP2FA::get_wp2fa_email_templates( $template_id . '_email_subject' ) ); ?>">
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>
						<label for="<?php echo $template_id; ?>_email_body"><?php esc_html_e( 'Email body', 'wp-2fa' ); ?></label>
						</br>
						<label for="<?php echo $template_id; ?>_email_tags" style="font-weight: 400;"><?php esc_html_e( 'Available template tags:', 'wp-2fa' ); ?></label>
						</br>
						</br>
						<span style="font-weight: 400;">
							{site_url}</br>
							{site_name}</br>
							{grace_period}</br>
							{user_login_name}</br>
							{login_code}
							<?php
							if ( ! empty( $custom_user_page_id ) ) {
								echo '</br>{2fa_settings_page_url}';
							}
							?>
						</span>
					</th>
					<td>
						<fieldset>
							<?php
							$message   = WP2FA::get_wp2fa_email_templates( $template_id . '_email_body' );
							$content   = $message;
							$editor_id = $template_id . '_email_body';
							$settings  = array(
								'media_buttons' => false,
								'editor_height' => 200,
							);
							wp_editor( $content, $editor_id, $settings );
							?>
						</fieldset>
						<p>
							<button type="button" name="test_email_<?php echo esc_attr( $template_id ); ?>"
									class="button js-button-test-email-trigger"
									data-email-id="<?php echo esc_attr( $template_id ); ?>"
									data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp-2fa-email-test-' . $template_id ) ); ?>">
								<?php esc_html_e( 'Send test email', 'wp-2fa' ); ?>
							</button>
						</p>
					</td>
				</tr>
			</tbody>
		</table>

		<br>
		<hr>
		<?php endforeach; ?>
		<?php
	}

	/**
	 * Validate email templates before saving
	 *
	 * @param  array $input The settings array.
	 */
	public function validate_and_sanitize_email( $input ) {

		// Bail if user doesnt have permissions to be here.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( empty( $_POST ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'wp_2fa_email_settings-options' ) && ! wp_verify_nonce( $_POST['_wpnonce'], 'wp_2fa_settings-options' ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'wp_2fa_email_settings-options' ) && ! wp_verify_nonce( $_POST['_wpnonce'], 'wp_2fa_settings-options' ) ) {
			die( esc_html__( 'Nonce verification failed.', 'wp-2fa' ) );
		}

		if ( isset( $_POST['email_from_setting'] ) && 'use-defaults' === $_POST['email_from_setting'] || isset( $_POST['email_from_setting'] ) && 'use-custom-email' === $_POST['email_from_setting'] ) {
			$output['email_from_setting'] = sanitize_text_field( wp_unslash( $_POST['email_from_setting'] ) );
		}

		if ( isset( $_POST['email_from_setting'] ) && 'use-custom-email' === $_POST['email_from_setting'] && isset( $_POST['custom_from_email_address'] ) && empty( $_POST['custom_from_email_address'] ) ) {
			add_settings_error(
				'wp_2fa_settings',
				esc_attr( 'email_from_settings_error' ),
				esc_html__( 'Please provide an email address', 'wp-2fa' ),
				'error'
			);
			$output['custom_from_email_address'] = '';
		}

		if ( isset( $_POST['email_from_setting'] ) && 'use-custom-email' === $_POST['email_from_setting'] && isset( $_POST['custom_from_display_name'] ) && empty( $_POST['custom_from_display_name'] ) ) {
			add_settings_error(
				'wp_2fa_settings',
				esc_attr( 'display_name_settings_error' ),
				esc_html__( 'Please provide a display name.', 'wp-2fa' ),
				'error'
			);
			$output['custom_from_email_address'] = '';
		}

		if ( isset( $_POST['custom_from_email_address'] ) && ! empty( $_POST['custom_from_email_address'] ) ) {
			if ( ! filter_var( $_POST['custom_from_email_address'], FILTER_VALIDATE_EMAIL ) ) {
				add_settings_error(
					'wp_2fa_settings',
					esc_attr( 'email_invalid_settings_error' ),
					esc_html__( 'Please provide a valid email address. Your email address has not been updated.', 'wp-2fa' ),
					'error'
				);
			}
			$output['custom_from_email_address'] = sanitize_email( wp_unslash( $_POST['custom_from_email_address'] ) );
		}

		if ( isset( $_POST['custom_from_display_name'] ) && ! empty( $_POST['custom_from_display_name'] ) ) {
			// Check if the string contains HTML/tags.
			preg_match( "/<\/?\w+((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/", $_POST['custom_from_display_name'], $matches );
			if ( count( $matches ) > 0 ) {
				add_settings_error(
					'wp_2fa_settings',
					esc_attr( 'display_name_invalid_settings_error' ),
					esc_html__( 'Please only use alphanumeric text. Your display name has not been updated.', 'wp-2fa' ),
					'error'
				);
			} else {
				$output['custom_from_display_name'] = sanitize_text_field( wp_unslash( $_POST['custom_from_display_name'] ) );
			}
		}

		if ( isset( $_POST['enforced_email_subject'] ) ) {
			$output['enforced_email_subject'] = wp_kses_post( wp_unslash( $_POST['enforced_email_subject'] ) );
		}

		if ( isset( $_POST['enforced_email_body'] ) ) {
			$output['enforced_email_body'] = wpautop( wp_kses_post( wp_unslash( $_POST['enforced_email_body'] ) ) );
		}

		if ( isset( $_POST['login_code_email_subject'] ) ) {
			$output['login_code_email_subject'] = wp_kses_post( wp_unslash( $_POST['login_code_email_subject'] ) );
		}

		if ( isset( $_POST['login_code_email_body'] ) ) {
			$output['login_code_email_body'] = wpautop( wp_kses_post( wp_unslash( $_POST['login_code_email_body'] ) ) );
		}

		if ( isset( $_POST['user_account_locked_email_subject'] ) ) {
			$output['user_account_locked_email_subject'] = wp_kses_post( wp_unslash( $_POST['user_account_locked_email_subject'] ) );
		}

		if ( isset( $_POST['user_account_locked_email_body'] ) ) {
			$output['user_account_locked_email_body'] = wpautop( wp_kses_post( wp_unslash( $_POST['user_account_locked_email_body'] ) ) );
		}

		if ( isset( $_POST['user_account_unlocked_email_subject'] ) ) {
			$output['user_account_unlocked_email_subject'] = wp_kses_post( wp_unslash( $_POST['user_account_unlocked_email_subject'] ) );
		}

		if ( isset( $_POST['user_account_unlocked_email_body'] ) ) {
			$output['user_account_unlocked_email_body'] = wpautop( wp_kses_post( wp_unslash( $_POST['user_account_unlocked_email_body'] ) ) );
		}

		if ( isset( $_POST['send_enforced_email'] ) && 'enable_enforced_email' === $_POST['send_enforced_email'] ) {
			$output['send_enforced_email'] = sanitize_text_field( $_POST['send_enforced_email'] );
		}

		if ( isset( $_POST['send_account_locked_email'] ) && 'enable_account_locked_email' === $_POST['send_account_locked_email'] ) {
			$output['send_account_locked_email'] = sanitize_text_field( $_POST['send_account_locked_email'] );
		}

		if ( isset( $_POST['send_account_unlocked_email'] ) && 'enable_account_unlocked_email' === $_POST['send_account_unlocked_email'] ) {
			$output['send_account_unlocked_email'] = sanitize_text_field( $_POST['send_account_unlocked_email'] );
		}

		// Remove duplicates from settings errors. We do this as this sanitization callback is actually fired twice, so we end up with duplicates when saving the settings for the FIRST TIME only. The issue is not present once the settings are in the DB as the sanitization wont fire again. For details on this core issue - https://core.trac.wordpress.org/ticket/21989.
		global $wp_settings_errors;
		if ( isset( $wp_settings_errors ) ) {
			$errors             = array_map( 'unserialize', array_unique( array_map( 'serialize', $wp_settings_errors ) ) );
			$wp_settings_errors = $errors;
		}

		if ( isset( $output ) ) {
			return $output;
		} else {
			return;
		}

	}

	/**
	 * Creates a new page with our shortcode present.
	 */
	public function generate_custom_user_profile_page( $page_slug ) {
		// Bail if user doesnt have permissions to be here.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Check if a page with slug exists.
		$page_exists = $this->get_post_by_post_name( $page_slug, 'page' );
		if ( $page_exists ) {
			// Seeing as the page exisits, return its ID.
			return $page_exists->ID;
		}

		$generated_by_message = sprintf(
			/* translators: %1$s: is the user name, %2$s is the website address */
			'<p>%1$s <a href="https://www.wpwhitesecurity.com/wordpress-plugins/wp-2fa/" target="_blank">%2$s</a></p>',
			esc_html__( 'Page generated by', 'wp-2fa' ),
			esc_html__( 'WP 2FA Plugin', 'wp-2fa' )
		);

		$user      = wp_get_current_user();
		$post_data = array(
			'post_title'   => 'WP 2FA User Profile',
			'post_name'    => $page_slug,
			'post_content' => '[wp-2fa-setup-form] ' . $generated_by_message,
			'post_status'  => 'publish',
			'post_author'  => $user->ID,
			'post_type'    => 'page',
		);

		// Lets insert the post now.
		$result = wp_insert_post( $post_data );

		if ( $result && ! is_wp_error( $result ) ) {
			$post_id = $result;
			set_transient( 'wp_2fa_new_custom_page_created', true, 60 );
			set_site_transient( 'wp_2fa_new_custom_page_created', true, 60 );
			return $post_id;
		}
	}

	/**
	 * Check if page with slug exisits.
	 */
	public function get_post_by_post_name( $slug = '', $post_type = '' ) {
		if ( ! $slug || ! $post_type ) {
			return false;
		}

		$post_object = get_page_by_path( $slug, OBJECT, $post_type );

		if ( ! $post_object ) {
			return false;
		}

		return $post_object;
	}

	/**
	 * Add our custom state to our created page.
	 */
	public function add_display_post_states( $post_states, $post ) {
		if ( ! empty( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) ) ) {
			if ( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) === $post->ID ) {
				$post_states['wp_2fa_page_for_user'] = __( 'WP 2FA User Page', 'wp-2fa' );
			}
		}

		return $post_states;
	}

	/**
	 * Handles sending of an email. It sets necessary header such as content type and custom from email address and name.
	 *
	 * @param string $recipient_email Email address to send message to.
	 * @param string $subject Email subject.
	 * @param string $message Message contents.
	 *
	 * @return bool Whether the email contents were sent successfully.
	 */
	public static function send_email( $recipient_email, $subject, $message ) {

		// Specify our desired headers.
		$headers = 'Content-type: text/html;charset=utf-8' . "\r\n";

		if ( 'use-custom-email' === WP2FA::get_wp2fa_email_templates( 'email_from_setting' ) ) {
			$headers .= 'From: ' . WP2FA::get_wp2fa_email_templates( 'custom_from_display_name' ) . ' <' . WP2FA::get_wp2fa_email_templates( 'custom_from_email_address' ) . '>' . "\r\n";
		}

		// Fire our email.
		return wp_mail( $recipient_email, $subject, $message, $headers );

	}

	/**
	 * Turns user roles data in any form and shape to an array of strings.
	 *
	 * @param mixed $value User role names (slugs) as raw value.
	 *
	 * @return string[] List of user role names (slugs).
	 */
	public static function extract_roles_from_input( $value ) {
		if ( is_array( $value ) ) {
			return $value;
		}

		if ( is_string( $value ) && ! empty( $value ) ) {
			return explode( ',', $value );
		}

		return [];
	}
}
