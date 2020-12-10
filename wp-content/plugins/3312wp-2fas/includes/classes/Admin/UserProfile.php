<?php // phpcs:ignore

namespace WP2FA\Admin;

use \WP2FA\Authenticator\Authentication as Authentication;
use WP2FA\Utils\DateTimeUtils;use \WP2FA\WP2FA as WP2FA;
use \WP2FA\Core as Core;
use \WP2FA\Authenticator\BackupCodes as BackupCodes;

/**
 * UserProfile - Class for handling user things such as profile settings and admin list views.
 */
class UserProfile {

	const NOTICES_META_KEY = 'wp_2fa_totp_notices';

	/**
	 * Classs constructor
	 */
	public function __construct() {
	}

	/**
	 * Add our buttons to the user profile editing screen.
	 *
	 * @param object $user User data.
	 */
	public function user_2fa_options( $user ) {

		if ( isset( $_GET['user_id'] ) ) {
			$user_id = (int) $_GET['user_id'];
			$user    = get_user_by( 'id', $user_id );
		} else {
			$user = wp_get_current_user();
		}

		// Get current user, we going to need this regardless.
		$current_user = wp_get_current_user();

		// Bail if we still dont have an object.
		if ( ! is_a( $user, '\WP_User' ) || ! is_a( $current_user, '\WP_User' ) ) {
			return;
		}

    $roles = (array) $user->roles;

		// Grab grace period UNIX time.
		$grace_period_expired = get_user_meta( $user->ID, 'wp_2fa_user_grace_period_expired', true );
		// Grab current time, we going to compare these later.
		$time_now         = time();
		$is_user_excluded = WP2FA::is_user_excluded( $user->ID );

		// First lets see if the user already has a token.
		$enabled_methods = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );

		if ( ! $grace_period_expired && $current_user->ID === $user->ID && ! $is_user_excluded && ! empty( $roles ) ) {

			// These are the buttons we show if a user has no enabled methods.
			if ( ! empty( $enabled_methods && $user->ID === $current_user->ID ) ) {
				// Create wizard link based on which 2fa methods are allowed by admin.
				if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_totp' ) ) && ! empty( WP2FA::get_wp2fa_setting( 'enable_email' ) ) ) {
					if ( WP2FA::is_this_multisite() ) {
						$button_link = admin_url( 'index.php?page=wp-2fa-setup&current-step=user_choose_2fa_method&wizard_type=user_2fa_config' );
					} else {
						$button_link = admin_url( 'options-general.php?page=wp-2fa-setup&current-step=user_choose_2fa_method&wizard_type=user_2fa_config' );
					}

				} else {
					if ( WP2FA::is_this_multisite() ) {
						$button_link = admin_url( 'index.php?page=wp-2fa-setup&current-step=reconfigure_method&wizard_type=user_reconfigure_config' );
					} else {
						$button_link = admin_url( 'options-general.php?page=wp-2fa-setup&current-step=reconfigure_method&wizard_type=user_reconfigure_config' );
					}
				}
				// Create remove 2fa link.
				$url = add_query_arg(
					array(
						'action'       => 'remove_user_2fa',
						'user_id'      => $user->ID,
						'wp_2fa_nonce' => wp_create_nonce( 'wp-2fa-remove-user-2fa-nonce' ),
					),
					admin_url( 'user-edit.php' )
				);
				if ( WP2FA::is_this_multisite() ) {
					$backup_codes_link = admin_url( 'index.php?page=wp-2fa-setup&current-step=backup_codes&wizard_type=backup_codes_config' );
				} else {
					$backup_codes_link = admin_url( 'options-general.php?page=wp-2fa-setup&current-step=backup_codes&wizard_type=backup_codes_config' );
				}
				?>
				<h2><?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Add two-factor authentication to strengthen the security of your WordPress user account.', 'wp-2fa' ); ?></p>
				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th><label><?php esc_html_e( '2-Factor authentication', 'wp-2fa' ); ?></label></th>
							<td>

								<a href="<?php echo esc_url( $button_link ); ?>" class="button button-primary"><?php esc_html_e( 'Change 2FA Settings', 'wp-2fa' ); ?></a>
								<?php if ( UserProfile::can_user_remove_2fa( $user->ID ) ) : ?>
									<a href="#" class="button button-primary remove-2fa" onclick="MicroModal.show('confirm-remove-2fa');"><?php esc_html_e( 'Remove 2FA', 'wp-2fa' ); ?></a>
								<?php endif; ?>

								<br />
								<br />

								<a href="<?php echo esc_url( $backup_codes_link ); ?>" class="button button-primary"><?php esc_html_e( 'Generate backup codes', 'wp-2fa' ); ?></a>
								<?php
								$codes_remaining = BackupCodes::codes_remaining_for_user( $user );
								if ( $codes_remaining > 0 ) {
									?>
										<span class="description mt-5px"><?php echo esc_attr( (int) $codes_remaining ); ?> <?php esc_html_e( 'unused backup codes remaining.', 'wp-2fa' ); ?></span>
									<?php
								} elseif ( 0 === $codes_remaining ) {
									?>
									<a class="learn_more_link" href="https://www.wpwhitesecurity.com/2fa-backup-codes/?utm_source=plugin&utm_medium=referral&utm_campaign=wp2fa&utm_content=settings+pages" target="_blank"><?php esc_html_e( 'Learn more.', 'wp-2fa' ); ?></a>
									<?php
								}
								?>
							</td>
						</tr>
						</tbody>
					</table>
					<?php if ( UserProfile::can_user_remove_2fa( $user->ID ) ): ?>
					<div class="wp2fa-modal micromodal-slide" id="confirm-remove-2fa" aria-hidden="true">
						<div class="modal__overlay" tabindex="-1" data-micromodal-close>
							<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
							<header class="modal__header">
								<h4 class="modal__title" id="modal-1-title"><?php esc_html_e( 'Remove 2FA?', 'wp-2fa' ); ?></h4>
								<button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
							</header>
							<main class="modal__content" id="modal-1-content">
								<p>
									<?php esc_html_e( 'Are you sure you want to remove two-factor authentication and lower the security of your user account?', 'wp-2fa' ); ?>
								</p>
							</main>
							<footer class="modal__footer">
								<a href="<?php echo esc_url( $url ); ?>" class="modal__btn modal__btn-primary"><?php esc_html_e( 'Yes', 'wp-2fa' ); ?></a>
							  <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'No', 'wp-2fa' ); ?></button>
							</footer>
						  </div>
						</div>
				  	</div>
					<?php endif; ?>
				<?php
			} else {

				if ( WP2FA::is_this_multisite() ) {
					$first_time_setup_link = admin_url( 'index.php?page=wp-2fa-setup&current-step=choose_2fa_method&first_time_setup=true' );
				} else {
					$first_time_setup_link = admin_url( 'options-general.php?page=wp-2fa-setup&current-step=choose_2fa_method&first_time_setup=true' );
				}
				?>
				<h2><?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Add two-factor authentication to strengthen the security of your WordPress user account.', 'wp-2fa' ); ?></p>
					<table class="form-table" role="presentation">
						<tbody>
							<tr>
								<th><label><?php esc_html_e( '2-Factor authentication', 'wp-2fa' ); ?></label></th>
								<td>
									<a href="<?php echo esc_url( $first_time_setup_link ); ?>" class="button button-primary"><?php esc_html_e( 'Configure Two-factor authentication (2FA)', 'wp-2fa' ); ?></a>
								</td>
							</tr>
							</tbody>
						</table>
					<?php
			}
		} elseif ( $is_user_excluded ) {
			?>
			<h2><?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Add two-factor authentication to strengthen the security of your WordPress user account.', 'wp-2fa' ); ?></p>
			<p class="description"><?php esc_html_e( 'Your user / role is not permitted to configure 2FA. Contact your administrator for more information.', 'wp-2fa' ); ?></p>
			<?php
		} elseif ( $grace_period_expired && current_user_can( 'manage_options' ) ) {
			?>
			<h2><?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?></h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th><label><?php esc_html_e( '2-Factor authentication', 'wp-2fa' ); ?></label></th>
						<td>
							<?php
							$url = add_query_arg(
								array(
									'action'       => 'unlock_account',
									'user_id'      => $user->ID,
									'wp_2fa_nonce' => wp_create_nonce( 'wp-2fa-unlock-account-nonce' ),
								),
								admin_url( 'user-edit.php' )
							);

							if ( $grace_period_expired ) {
								?>
								<a href="<?php echo esc_url( $url ); ?>" class="button button-primary"><?php esc_html_e( 'Unlock user and reset the grace period', 'wp-2fa' ); ?></a>
								<?php
							}
							?>
						</td>
					</tr>
					</tbody>
				</table>
			<?php
		} elseif ( ! $grace_period_expired && current_user_can( 'manage_options' ) && ! empty( $enabled_methods ) ) {
			?>
			<h2><?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?></h2>
			<p class="description"><?php esc_html_e( 'By resetting this user\'s 2FA configuration you disable the currently configured 2FA so the user can log back in using a usemame and a password only. *the user if enforced to setup 2FA the user will get a prompt upon logging in, from where 2FA can be configured. The user has to configure 2FA within the configured grace period.', 'wp-2fa' ); ?></p>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th><label><?php esc_html_e( '2-Factor authentication', 'wp-2fa' ); ?></label></th>
						<td>
							<?php
							// Create remove 2fa link.
							$url = add_query_arg(
								array(
									'action'       => 'remove_user_2fa',
									'user_id'      => $user->ID,
									'wp_2fa_nonce' => wp_create_nonce( 'wp-2fa-remove-user-2fa-nonce' ),
									'admin_reset'  => 'yes',
								),
								admin_url( 'user-edit.php' )
							);
							?>
							<a href="<?php echo esc_url( $url ); ?>" class="button button-primary"><?php esc_html_e( 'Reset 2FA configuration', 'wp-2fa' ); ?></a>
						</td>
					</tr>
					</tbody>
				</table>
			<?php
		} elseif ( empty( $roles ) ) {
			echo $this->inline_2fa_profile_form();
		}

	}

	/**
	 * Produces the 2FA configuration form for network users, or any user with no roles.
	 */
	public function inline_2fa_profile_form( $is_shortcode = '', $show_preamble = 'true' ) {
		if ( isset( $_GET['user_id'] ) ) {
			$user_id = (int) $_GET['user_id'];
			$user    = get_user_by( 'id', $user_id );
		} else {
			$user = wp_get_current_user();
		}

		// Get current user, we going to need this regardless.
		$current_user = wp_get_current_user();

		// Bail if we still dont have an object.
		if ( ! is_a( $user, '\WP_User' ) || ! is_a( $current_user, '\WP_User' ) ) {
			return;
		}

		// Grab grace period UNIX time.
		$grace_period_expired = get_user_meta( $user->ID, 'wp_2fa_grace_period_expiry', true );

		// Grab current time, we going to compare these later.
		$time_now         = time();
		$is_user_excluded = WP2FA::is_user_excluded( $user->ID );

		// First lets see if the user already has a token.
		$enabled_methods = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );

		if ( ! $is_user_excluded ) {

			// Check if current user viewing the profile is the owner of the profile.
			if ( isset( $_GET['user_id'] ) ) {
				$user_id     = (int) $_GET['user_id'];
				$user        = get_user_by( 'id', $user_id );
				$curent_user = wp_get_current_user();
				if ( $curent_user->ID !== $user->ID ) {
					return;
				}
			}

			// Show this to user who has enabled methods
			if ( ! empty( $enabled_methods ) && $user->ID === $current_user->ID ) {
				?>
				<?php if ( ! isset( $is_shortcode ) && ! $is_shortcode === 'output_shortcode' ) : ?>
					<h2>
						<?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?>
					</h2>
				<?php endif; ?>
				<?php if ( 'true' === $show_preamble ) { ?>
					<p class="description">
						<?php esc_html_e( 'Add two-factor authentication to strengthen the security of your WordPress user account.', 'wp-2fa' ); ?>
					</p>
				<?php } ?>
				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th>
								<label>
									<?php esc_html_e( '2-Factor authentication', 'wp-2fa' ); ?>
								</label>
							</th>
							<td>
								<a href="#" class="button button-primary remove-2fa" onclick="MicroModal.show('configure-2fa',{
									onShow: modal => jQuery( '.wizard-step:first-of-type' ).addClass( 'active' ),
									onClose: modal => jQuery( '.wizard-step.active' ).removeClass( 'active' ),
								});"><?php esc_html_e( 'Change 2FA Settings', 'wp-2fa' ); ?></a>

								<?php if ( UserProfile::can_user_remove_2fa( $user->ID ) ) : ?>
									<a href="#" class="button button-primary remove-2fa" onclick="MicroModal.show('confirm-remove-2fa');"><?php esc_html_e( 'Remove 2FA', 'wp-2fa' ); ?></a>
								<?php endif; ?>

								<a href="#" class="button button-primary remove-2fa" onclick="MicroModal.show('configure-2fa-backup-codes',{
									onShow: modal => jQuery( '.wizard-step:first-of-type' ).addClass( 'active' ),
									onClose: modal => jQuery( '.wizard-step.active' ).removeClass( 'active' ),
								});"><?php esc_html_e( 'Generate Backup Codes', 'wp-2fa' ); ?></a>

								<?php
								$codes_remaining = BackupCodes::codes_remaining_for_user( $user );
								if ( $codes_remaining > 0 ) {
									?>
										<span class="description mt-5px"><?php echo esc_attr( (int) $codes_remaining ); ?> <?php esc_html_e( 'unused backup codes remaining.', 'wp-2fa' ); ?></span>
									<?php
								} elseif ( 0 === $codes_remaining ) {
									?>
									<a class="learn_more_link" href="https://www.wpwhitesecurity.com/2fa-backup-codes/?utm_source=plugin&utm_medium=referral&utm_campaign=wp2fa&utm_content=settings+pages" target="_blank"><?php esc_html_e( 'Learn more.', 'wp-2fa' ); ?></a>
									<?php
								}
								?>
								<div>
									<?php if ( UserProfile::can_user_remove_2fa( $user->ID ) ) : ?>
									<div class="wp2fa-modal micromodal-slide" id="confirm-remove-2fa" aria-hidden="true">
										<div class="modal__overlay" tabindex="-1" data-micromodal-close>
											<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
												<header class="modal__header">
													<button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
												</header>
												<main class="modal__content" id="modal-1-content">
													<div>
														<h4>
															<?php esc_html_e( 'Remove 2FA?', 'wp-2fa' ); ?>
														</h4>
														<p>
															<?php esc_html_e( 'Are you sure you want to remove two-factor authentication and lower the security of your user account?', 'wp-2fa' ); ?>
														</p>
													</div>
												</main>
												<footer class="modal__footer">
													<a href="#" class="modal__btn modal__btn-primary button" data-trigger-remove-2fa data-user-id="<?php echo esc_attr( $user->ID ); ?>" data-nonce="<?php echo wp_create_nonce( 'wp-2fa-remove-user-2fa-nonce' ); ?>"><?php esc_html_e( 'Yes', 'wp-2fa' ); ?></a>
													<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'No', 'wp-2fa' ); ?></button>
												</footer>
											</div>
										</div>
									</div>
									<?php endif; ?>
									<div class="wp2fa-modal micromodal-slide" id="configure-2fa" aria-hidden="true">
										<div class="modal__overlay" tabindex="-1" data-micromodal-close>
											<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
											<header class="modal__header">
												<button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
											</header>
											<main class="modal__content" id="modal-1-content">
												<?php
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
												$validate_nonce = wp_create_nonce( 'wp-2fa-validate-authcode' );
												?>

												<div class="wizard-step active">
													<fieldset>
														<?php if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_totp' ) ) ) { ?>
															<div class="option-pill">
																<h3>
																	<?php esc_html_e( 'Reconfigure the 2FA App', 'wp-2fa' ); ?>
																</h3>
																<p>
																	<?php esc_html_e( 'Click the below button to reconfigure the current 2FA method. Note that once reset  reset you will have to re-scan the QR code on all devices you want this to work on because the previous codes will stop working.', 'wp-2fa' ); ?>
																</p>
																<div class="wp2fa-setup-actions">
																		<a href="#" class="button button-primary" name="next_step_setting_modal_wizard" data-trigger-reset-key="no-reload" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-user-id="<?php echo esc_attr( $user->ID ); ?>" data-next-step="2fa-wizard-totp"><?php esc_html_e( 'Reset Key', 'wp-2fa' ); ?></a>
																</div>
															</div>
														<?php } ?>
														<?php if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_email' ) ) ) {
															$setupnonce = wp_create_nonce( 'wp-2fa-send-setup-email' );
															?>
															<br>
															<div class="option-pill">
																<h3><?php esc_html_e( 'Setup the 2FA method', 'wp-2fa' ); ?></h3>
																<p>
																	<?php esc_html_e( 'Please select the email address where the one-time code should be sent:', 'wp-2fa' ); ?>
																</p>
																<fieldset>
																	<label for="use_wp_email">
																		<span><?php esc_html_e( 'Type in below the new email address where you want to receive the 2FA one-time codes.', 'wp-2fa' ); ?></span>
																		<br><br>
																		<input type="email" name="custom-email-address" id="custom-email-address" class="input wide" value=""/>
																	</label>
																</fieldset>
																<div class="wp2fa-setup-actions">
																	<a class="button button-primary" name="next_step_setting_modal_wizard" value="<?php esc_attr_e( 'I\'m Ready', 'wp-2fa' ); ?>" data-trigger-setup-email data-user-id="<?php echo esc_attr( $user->ID ); ?>" data-nonce="<?php echo esc_attr( $setupnonce ); ?>" data-next-step="2fa-wizard-email"><?php esc_html_e( 'Change email address', 'wp-2fa' ); ?></a>
																</div>
															</div>
														<?php } ?>
													</fieldset>
												</div>

												<div class="wizard-step" id="2fa-wizard-totp">
													<fieldset>

														<div class="step-setting-wrapper active">
															<h3><?php esc_html_e( 'Setup the 2FA method', 'wp-2fa' ); ?></h3>
															<div class="option-pill">
																<ol>
																	<li><?php esc_html_e( 'Download the app of your choice', 'wp-2fa' ); ?></li>
																	<li><?php esc_html_e( 'Click the plus sign (add new icon)', 'wp-2fa' ); ?></li>
																	<li class="hide-on-mobile"><?php esc_html_e( 'Select \'Scan a barcode\'', 'wp-2fa' ); ?></li>
																	<li class="hide-on-mobile"><?php esc_html_e( 'Scan the QR code to the right.', 'wp-2fa' ); ?></li>
																	<li class="show-on-mobile"><?php esc_html_e( 'Select "Enter a provided key" and type in the key below.', 'wp-2fa' ); ?></li>
																</ol>
																<p class="hide-on-mobile"><?php esc_html_e( 'Otherwise, select Enter a provided key and type in the key below:', 'wp-2fa' ); ?></p>
																<code class="app-key"><?php echo esc_html( $key ); ?></code>
															</div>
															<img class="qr-code" src="<?php echo esc_url( Authentication::get_google_qr_code( $totp_title, $key, $site_name ) ); ?>" id="wp-2fa-totp-qrcode" />
															<br>
															<br>
															<br>
															<br>
															<br>
															<h4><?php esc_html_e( 'For detailed guides for your desired app, click below.', 'wp-2fa' ); ?></h4>
															<div class="apps-wrapper">
															<?php foreach (Authentication::getApps() as $app): ?>
																<a href="https://www.wpwhitesecurity.com/support/kb/configuring-2fa-apps/#<?php echo $app['hash']; ?>" target="_blank" class="app-logo"><img style="max-width: 110px;" src="<?php echo esc_url( WP_2FA_URL . '/dist/images/' . $app['logo'] ); ?>"></a>
															<?php endforeach; ?>
															</div>
															<div class="wp2fa-setup-actions">
																<br>
																<a class="button button-primary" name="next_step_setting"><?php esc_html_e( 'I\'m Ready', 'wp-2fa' ); ?></a>
															</div>
														</div>

														<div class="step-setting-wrapper">
															<h3><?php esc_html_e( 'Almost there…', 'wp-2fa' ); ?></h3>
															<p><?php esc_html_e( 'Please type in the one-time code from your Google Authenticator app to finalize the setup.', 'wp-2fa' ); ?></p>
															<br>
															<fieldset>
																<label for="2fa-totp-authcode">
																	<?php esc_html_e( 'Authentication Code:', 'wp-2fa' ); ?>
																	<input type="tel" name="wp-2fa-totp-authcode" id="wp-2fa-totp-authcode" class="input" value="" size="20" pattern="[0-9]*" />
																</label>
																<div class="verification-response"></div>
															</fieldset>
															<br>
															<input type="hidden" name="wp-2fa-totp-key" value="<?php echo esc_attr( $key ); ?>" />

															<a href="#" class="modal__btn modal__btn-primary button" data-validate-authcode-ajax data-nonce="<?php echo esc_attr( $validate_nonce ); ?>"><?php esc_html_e( 'Validate & Save Configuration', 'wp-2fa' ); ?></a>
															<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'Cancel', 'wp-2fa' ); ?></button>
														</div>

													</fieldset>
												</div>

												<div class="wizard-step" id="2fa-wizard-email">
													<fieldset>

														<div class="step-setting-wrapper active">
															<h4><?php esc_html_e( 'Almost there…', 'wp-2fa' ); ?></h4>
															<p><?php esc_html_e( 'Please type in the one-time code sent to your email address to finalize the setup.', 'wp-2fa' ); ?></p>
															<br>
															<fieldset>
																<label for="2fa-email-authcode">
																	<?php esc_html_e( 'Authentication Code:', 'wp-2fa' ); ?>
																	<input type="tel" name="wp-2fa-email-authcode" id="wp-2fa-email-authcode" class="input" value="" size="20" pattern="[0-9]*" />
																</label>
																<div class="verification-response"></div>
															</fieldset>

															<input type="hidden" name="wp-2fa-totp-key" value="<?php echo esc_attr( $key ); ?>" />
														</div>
														<br>
														<a href="#" class="modal__btn modal__btn-primary button" data-validate-authcode-ajax data-nonce="<?php echo esc_attr( $validate_nonce ); ?>"><?php esc_html_e( 'Validate Code', 'wp-2fa' ); ?></a>
														<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'Cancel', 'wp-2fa' ); ?></button>
													</fieldset>
												</div>

												<div class="wizard-step" id="2fa-wizard-setup-done">
													<fieldset>

														<h3><?php esc_html_e( 'Your website just got more secure!', 'wp-2fa' ); ?></h3>
														<p><?php esc_html_e( 'Congratulations! You have enabled two-factor authentication for your user. You’ve just helped towards making this website more secure!', 'wp-2fa' ); ?></p>

														<p><?php esc_html_e( 'You can exit this wizard now or continue to configure the plugin’s general settings. ', 'wp-2fa' ); ?></p>

														<p class="description"><?php esc_html_e( 'Note: all the settings can be configured from the Settings > Two-factor Authentication entry of your WordPress menu.', 'wp-2fa' ); ?></p>

													</fieldset>
													<a href="#" class="modal__btn modal__btn-primary button" name="next_step_setting_modal_wizard" data-next-step><?php esc_html_e( 'Next Step', 'wp-2fa' ); ?></a>
													<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'Close', 'wp-2fa' ); ?></button>
												</div>
											</main>
											</div>
										</div>
									</div>

									<div class="wp2fa-modal micromodal-slide" id="configure-2fa-backup-codes" aria-hidden="true">
										<div class="modal__overlay" tabindex="-1" data-micromodal-close>
											<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
											<header class="modal__header">
												<button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
											</header>
											<main class="modal__content" id="modal-1-content">
												<?php
												// Grab current user.
												$user = wp_get_current_user();
												// Create a nonce for use in ajax call to generate codes.
												$nonce = wp_create_nonce( 'wp-2fa-backup-codes-generate-json-' . $user->ID );
												?>
												<div class="step-setting-wrapper active">
													<h3><?php esc_html_e( 'Generate backup codes', 'wp-2fa' ); ?></h3>
													<p><?php esc_html_e( 'It is recommended to generate and print some backup codes in case you lose access to your primary 2FA method. ', 'wp-2fa' ); ?></p>

													<div class="wp2fa-setup-actions">
														<button class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'Generate backup codes', 'wp-2fa' ); ?>" data-trigger-generate-backup-codes data-nonce="<?php echo esc_attr( $nonce ); ?>" data-user-id="<?php echo esc_attr( $user->ID ); ?>">
															<?php esc_html_e( 'Generate backup codes', 'wp-2fa' ); ?>
														</button>
														<a href="<?php echo esc_url( admin_url() ); ?>" class="button button-secondary" type="submit" name="save_step" value="<?php esc_attr_e( 'I’ll generate them later', 'wp-2fa' ); ?>">
															<?php esc_html_e( 'I’ll generate them later', 'wp-2fa' ); ?>
														</a>
													</div>
												</div>

												<div class="step-setting-wrapper align-center">
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

											</main>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<?php

			} else {
				?>
				<?php if ( ! isset( $is_shortcode ) && ! $is_shortcode === 'output_shortcode' ) : ?>
					<h2>
						<?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?>
					</h2>
				<?php endif; ?>
				<?php
					$class           = 'notice notice-info wp-2fa-nag';
					$grace_expiry    = get_user_meta( $user->ID, 'wp_2fa_grace_period_expiry', true );
					$reconfigure_2fa = get_user_meta( $user->ID, 'wp_2fa_user_needs_to_reconfigure_2fa', true );
					if ( $reconfigure_2fa ) {
						$message = esc_html__( 'The 2FA method you were using is no longer allowed on this website. Please reconfigure 2FA using one of the supported methods within', 'wp-2fa' );
					} else {
						$message = esc_html__( 'This website’s administrator requires you to enable 2FA authentication', 'wp-2fa' );
					}

				?>
				<?php if ( 'true' === $show_preamble ) { ?>
					<?php if ( ! empty( $grace_expiry ) && ! get_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true ) ) { ?>
					<p class="description">
						<?php echo $message; ?> <span class="grace-period-countdown"><?php echo DateTimeUtils::format_grace_period_expiration_string(null, $grace_expiry); ?></span>
					</p>
					<?php } ?>
					<?php if ( get_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true ) ) { ?>
					<p class="description">
						<?php echo esc_html__( 'This website’s administrator requires you to enable 2FA authentication to continue.', 'wp-2fa' ); ?>
					</p>
					<?php } ?>
					<p class="description">
						<?php esc_html_e( 'Add two-factor authentication to strengthen the security of your WordPress user account.', 'wp-2fa' ); ?>
					</p>
				<?php } ?>
				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th>
								<label>
									<?php esc_html_e( '2-Factor authentication', 'wp-2fa' ); ?>
								</label>
							</th>

							<td>
								<a href="#" class="button button-primary remove-2fa" onclick="MicroModal.show('configure-2fa',{
									onShow: modal => jQuery( '.wizard-step:first-of-type' ).addClass( 'active' ),
									onClose: modal => jQuery( '.wizard-step.active' ).removeClass( 'active' ),
								});"><?php esc_html_e( 'Configure 2FA', 'wp-2fa' ); ?></a>

								<div>
									<div class="wp2fa-modal micromodal-slide" id="configure-2fa" aria-hidden="true">
										<div class="modal__overlay" tabindex="-1" data-micromodal-close>
											<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
											<header class="modal__header">
												<button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
											</header>
											<main class="modal__content" id="modal-1-content">
												<?php
												$user           = wp_get_current_user();
												$enabled_method = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );

												// Grab key from user meta.
												$key            = Authentication::get_user_totp_key( $user->ID );

												// If no key is present, lets make one.
												if ( empty( $key ) ) {
													$key    = Authentication::generate_key();
													$update = update_user_meta( $user->ID, 'wp_2fa_totp_key', $key );
												}
												$setupnonce     = wp_create_nonce( 'wp-2fa-send-setup-email' );
												$validate_nonce = wp_create_nonce( 'wp-2fa-validate-authcode' );

												// Setup site information, used when generating our QR code.
												$site_name  = get_bloginfo( 'name', 'display' );
												$totp_title = apply_filters( 'wp_2fa_totp_title', $site_name . ':' . $user->user_login, $user );

												if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_totp' ) ) && ! empty( WP2FA::get_wp2fa_setting( 'enable_email' ) ) ) {
													$intro_text = esc_html__( 'Choose the 2FA authentication method', 'wp-2fa' );
													$sub_text   = esc_html__( 'There are two methods available from which you can choose for 2FA:', 'wp-2fa' );
												} else {
													$intro_text = esc_html__( 'Choose the 2FA authentication method', 'wp-2fa' );
													$sub_text   = esc_html__( 'Only the below 2FA method is allowed on this website:', 'wp-2fa' );
												}
												?>

												<div class="wizard-step active">
													<h3><?php echo sanitize_text_field( $intro_text ); ?></h3>
													<p><?php echo sanitize_text_field( $sub_text ); ?></p>

													<br>

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
															<br>
															<div class="option-pill">
																<label for="geek">
																	<input id="geek" name="wp_2fa_enabled_methods" type="radio" value="email">
																	<?php esc_html_e( 'One-time code sent to you over email', 'wp-2fa' ); ?>
																</label>
															</div>
														<?php } ?>
													</fieldset>
													<br><br>
													<a href="#" class="modal__btn modal__btn-primary button 2fa-choose-method" name="next_step_setting_modal_wizard" data-next-step><?php esc_html_e( 'Next Step', 'wp-2fa' ); ?></a>
													<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'Close', 'wp-2fa' ); ?></button>
												</div>

												<div class="wizard-step" id="2fa-wizard-totp">
													<fieldset>

														<div class="step-setting-wrapper active">
															<h3><?php esc_html_e( 'Setup the 2FA method', 'wp-2fa' ); ?></h3>
															<div class="option-pill">
																<ol>
																	<li><?php esc_html_e( 'Download the app of your choice', 'wp-2fa' ); ?></li>
																	<li><?php esc_html_e( 'Click the plus sign (add new icon)', 'wp-2fa' ); ?></li>
																	<li class="hide-on-mobile"><?php esc_html_e( 'Select \'Scan a barcode\'', 'wp-2fa' ); ?></li>
																	<li class="hide-on-mobile"><?php esc_html_e( 'Scan the QR code to the right.', 'wp-2fa' ); ?></li>
																	<li class="show-on-mobile"><?php esc_html_e( 'Select "Enter a provided key" and type in the key below.', 'wp-2fa' ); ?></li>
																</ol>
																<p class="hide-on-mobile"><?php esc_html_e( 'Otherwise, select Enter a provided key and type in the key below:', 'wp-2fa' ); ?></p>
																<code class="app-key"><?php echo esc_html( $key ); ?></code>
															</div>
															<img class="qr-code" src="<?php echo esc_url( Authentication::get_google_qr_code( $totp_title, $key, $site_name ) ); ?>" id="wp-2fa-totp-qrcode" />
															<br>
															<br>
															<br>
															<br>
															<br>
															<h4 class="app-links-title"><?php esc_html_e( 'For detailed guides for your desired app, click below.', 'wp-2fa' ); ?></h4>
															<?php foreach (Authentication::getApps() as $app): ?>
																<a href="https://www.wpwhitesecurity.com/support/kb/configuring-2fa-apps/#<?php echo $app['hash']; ?>" target="_blank" class="app-logo"><img style="max-width: 95px;" src="<?php echo esc_url( WP_2FA_URL . '/dist/images/' . $app['logo'] ); ?>"></a>
															<?php endforeach; ?>
															<div class="wp2fa-setup-actions">
																<br>
																<a class="button button-primary" name="next_step_setting"><?php esc_html_e( 'I\'m Ready', 'wp-2fa' ); ?></a>
															</div>
														</div>

														<div class="step-setting-wrapper">
															<h3><?php esc_html_e( 'Almost there…', 'wp-2fa' ); ?></h3>
															<p><?php esc_html_e( 'Please type in the one-time code from your Google Authenticator app to finalize the setup.', 'wp-2fa' ); ?></p>
															<br>
															<fieldset>
																<label for="2fa-totp-authcode">
																	<?php esc_html_e( 'Authentication Code:', 'wp-2fa' ); ?>
																	<input type="tel" name="wp-2fa-totp-authcode" id="wp-2fa-totp-authcode" class="input" value="" size="20" pattern="[0-9]*" />
																</label>
																<div class="verification-response"></div>
															</fieldset>
															<input type="hidden" name="wp-2fa-totp-key" value="<?php echo esc_attr( $key ); ?>" />
															<br>
															<a href="#" class="modal__btn modal__btn-primary button" data-validate-authcode-ajax data-nonce="<?php echo esc_attr( $validate_nonce ); ?>"><?php esc_html_e( 'Validate & Save Configuration', 'wp-2fa' ); ?></a>
															<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'Cancel', 'wp-2fa' ); ?></button>
														</div>

													</fieldset>
												</div>

												<div class="wizard-step" id="2fa-wizard-email">
													<fieldset>
														<div class="step-setting-wrapper active">
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
																<a class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'I\'m Ready', 'wp-2fa' ); ?>" data-trigger-setup-email data-user-id="<?php echo esc_attr( $user->ID ); ?>" data-nonce="<?php echo esc_attr( $setupnonce ); ?>" data-next-step="2fa-wizard-email"><?php esc_html_e( 'I\'m Ready', 'wp-2fa' ); ?></a>
															</div>
														</div>

														<div class="step-setting-wrapper" id="2fa-wizard-email">
															<h4><?php esc_html_e( 'Almost there…', 'wp-2fa' ); ?></h4>
															<p><?php esc_html_e( 'Please type in the one-time code sent to your email address to finalize the setup.', 'wp-2fa' ); ?></p>
															<fieldset>
																<label for="2fa-email-authcode">
																	<?php esc_html_e( 'Authentication Code:', 'wp-2fa' ); ?>
																	<input type="tel" name="wp-2fa-email-authcode" id="wp-2fa-email-authcode" class="input" value="" size="20" pattern="[0-9]*" />
																</label>
																<div class="verification-response"></div>
															</fieldset>
															<input type="hidden" name="wp-2fa-totp-key" value="<?php echo esc_attr( $key ); ?>" />

															<a href="#" class="modal__btn modal__btn-primary button" data-validate-authcode-ajax data-nonce="<?php echo esc_attr( $validate_nonce ); ?>"><?php esc_html_e( 'Validate & Save Configuration', 'wp-2fa' ); ?></a>
															<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'Cancel', 'wp-2fa' ); ?></button>
														</div>
													</fieldset>
												</div>

												<div class="wizard-step" id="2fa-wizard-config-backup-codes">
													<?php
													// Grab current user.
													$user = wp_get_current_user();
													// Create a nonce for use in ajax call to generate codes.
													$nonce = wp_create_nonce( 'wp-2fa-backup-codes-generate-json-' . $user->ID );
													?>
													<div class="step-setting-wrapper active">
														<h3><?php esc_html_e( 'Generate backup codes', 'wp-2fa' ); ?></h3>
														<p><?php esc_html_e( 'It is recommended to generate and print some backup codes in case you lose access to your primary 2FA method. ', 'wp-2fa' ); ?></p>

														<div class="wp2fa-setup-actions">
															<button class="button button-primary" name="next_step_setting" value="<?php esc_attr_e( 'Generate backup codes', 'wp-2fa' ); ?>" data-trigger-generate-backup-codes data-nonce="<?php echo esc_attr( $nonce ); ?>" data-user-id="<?php echo esc_attr( $user->ID ); ?>">
																<?php esc_html_e( 'Generate backup codes', 'wp-2fa' ); ?>
															</button>
															<a href="#" class="button button-secondary" name="save_step" value="<?php esc_attr_e( 'I’ll generate them later', 'wp-2fa' ); ?>">
																<?php esc_html_e( 'I’ll generate them later', 'wp-2fa' ); ?>
															</a>
														</div>
													</div>

													<div class="step-setting-wrapper align-center">
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
															<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php esc_html_e( 'Close wizard & refresh', 'wp-2fa' ); ?></button>
														</div>
													</div>
												</div>
											</main>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<?php

			}

		} elseif ( $is_user_excluded ) {
			?>
			<?php if ( ! isset( $is_shortcode ) && ! $is_shortcode === 'output_shortcode' ) : ?>
				<h2><?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?></h2>
			<?php endif; ?>
			<?php if ( 'true' === $show_preamble ) { ?>
				<p class="description"><?php esc_html_e( 'Add two-factor authentication to strengthen the security of your WordPress user account.', 'wp-2fa' ); ?></p>
				<p class="description"><?php esc_html_e( 'Your user / role is not permitted to configure 2FA. Contact your administrator for more information.', 'wp-2fa' ); ?></p>
			<?php } ?>
			<?php

		} elseif ( $grace_period_expired && current_user_can( 'manage_options' ) ) {
			?>
			<?php if ( ! isset( $is_shortcode ) && ! $is_shortcode === 'output_shortcode' ) : ?>
				<h2><?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?></h2>
			<?php endif; ?>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th><label><?php esc_html_e( '2-Factor authentication', 'wp-2fa' ); ?></label></th>
						<td>
							<?php
							$url = add_query_arg(
								array(
									'action'       => 'unlock_account',
									'user_id'      => $user->ID,
									'wp_2fa_nonce' => wp_create_nonce( 'wp-2fa-unlock-account-nonce' ),
								),
								admin_url( 'user-edit.php' )
							);

							if ( $grace_period_expired ) {
								?>
								<a href="<?php echo esc_url( $url ); ?>" class="button button-primary"><?php esc_html_e( 'Unlock user and reset the grace period', 'wp-2fa' ); ?></a>
								<?php
							}
							?>
						</td>
					</tr>
					</tbody>
				</table>
			<?php
		} elseif ( ! $grace_period_expired && current_user_can( 'manage_options' ) && ! empty( $enabled_methods ) ) {
			?>
			<?php if ( ! isset( $is_shortcode ) && ! $is_shortcode === 'output_shortcode' ) : ?>
				<h2><?php esc_html_e( 'WP 2FA Settings', 'wp-2fa' ); ?></h2>
			<?php endif; ?>
			<p class="description"><?php esc_html_e( 'By resetting this user\'s 2FA configuration you disable the currently configured 2FA so the user can log back in using a usemame and a password only. *the user if enforced to setup 2FA the user will get a prompt upon logging in, from where 2FA can be configured. The user has to configure 2FA within the configured grace period.', 'wp-2fa' ); ?></p>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th><label><?php esc_html_e( '2-Factor authentication', 'wp-2fa' ); ?></label></th>
						<td>
							<?php
							// Create remove 2fa link.
							$url = add_query_arg(
								array(
									'action'       => 'remove_user_2fa',
									'user_id'      => $user->ID,
									'wp_2fa_nonce' => wp_create_nonce( 'wp-2fa-remove-user-2fa-nonce' ),
									'admin_reset'  => 'yes',
								),
								admin_url( 'user-edit.php' )
							);
							?>
							<a href="<?php echo esc_url( $url ); ?>" class="button button-primary"><?php esc_html_e( 'Reset 2FA configuration', 'wp-2fa' ); ?></a>
						</td>
					</tr>
					</tbody>
				</table>
			<?php
		}
	}

	/**
	 * Add custom unlock account link to user edit admin list.
	 *
	 * @param  string $actions     Default actions.
	 * @param  object $user_object User data.
	 * @return string              Appended actions.
	 */
	public function user_2fa_row_actions( $actions, $user_object ) {
		$nonce                = wp_create_nonce( 'wp-2fa-unlock-account-nonce' );
		$grace_period_expired = get_user_meta( $user_object->ID, 'wp_2fa_user_grace_period_expired', true );
		$url                  = add_query_arg(
			array(
				'action'       => 'unlock_account',
				'user_id'      => $user_object->ID,
				'wp_2fa_nonce' => $nonce,
			),
			admin_url( 'users.php' )
		);

		if ( $grace_period_expired ) {
			$actions['edit_badges'] = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Unlock user', 'wp-2fa' ) . '</a>';
		}
		return $actions;
	}

	/**
	 * Save user profile information.
	 */
	public function save_user_2fa_options( $input ) {

		// Ensure we have the inputs we want before we process.
		// To avoid causing issues with the rest of the user profile.
		if ( ! is_array( $input ) ) {
			return;
		}

		// Assign the input to post, in case we are dealing with saving the data from another page.
		if ( isset( $input ) ) {
			$_POST = $input;
		} else {
			$_POST = $_POST;
		}

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

		if ( ! isset( $_POST['custom-email-address'] ) || isset( $_POST['custom-email-address'] ) && empty( $_POST['custom-email-address'] ) ) {
			if ( isset( $_POST['email'] ) ) {
				update_user_meta( $user->ID, 'wp_2fa_nominated_email_address', $_POST['email'] );
			} elseif ( isset( $_POST['wp_2fa_email_address'] ) ) {
				update_user_meta( $user->ID, 'wp_2fa_nominated_email_address', $_POST['wp_2fa_email_address'] );
			}

		} elseif ( isset( $_POST['custom-email-address'] ) ) {
			update_user_meta( $user->ID, 'wp_2fa_nominated_email_address', sanitize_email( wp_unslash( $_POST['custom-email-address'] ) ) );
		}

		// Now lets grab the users enabled 2fa methods.
		$get_array       = filter_input_array( INPUT_GET );
		$selected_method = sanitize_text_field( $get_array['enabled_methods'] );
		// Check its one of our options.
		if ( isset( $_POST['wp_2fa_enabled_methods'] ) && 'totp' === $_POST['wp_2fa_enabled_methods'] || isset( $_POST['wp_2fa_enabled_methods'] ) &&  'email' === $_POST['wp_2fa_enabled_methods'] ) {
			update_user_meta( $user->ID, 'wp_2fa_enabled_methods', sanitize_text_field( wp_unslash( $_POST['wp_2fa_enabled_methods'] ) ) );
			delete_user_meta( $user->ID, 'wp_2fa_grace_period_expiry' );
			delete_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly' );
		}

		if ( isset( $_POST['wp-2fa-email-authcode'] ) && ! empty( $_POST['wp-2fa-email-authcode'] ) ) {
			update_user_meta( $user->ID, 'wp_2fa_enabled_methods', 'email' );
			delete_user_meta( $user->ID, 'wp_2fa_grace_period_expiry' );
			delete_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly' );
		}

		if ( isset( $_POST['wp-2fa-totp-authcode'] ) && ! empty( $_POST['wp-2fa-totp-authcode'] ) ) {
			update_user_meta( $user->ID, 'wp_2fa_enabled_methods', 'totp' );
			delete_user_meta( $user->ID, 'wp_2fa_grace_period_expiry' );
			delete_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly' );
		}
	}

	/**
	 * Validate a user's code when setting up 2fa via the inline form.
	 *
	 * @return json result of validation.
	 */
	public function validate_authcode_via_ajax() {
		check_ajax_referer( 'wp-2fa-validate-authcode' );

		if ( isset( $_POST['form'] ) ) {
			$input = $_POST['form'];
		} else {
			return 'No form';
		}

		$user = wp_get_current_user();

		// Setup some empty arrays which will may fill later, should an error arise along the way.
		$notices = array();
		$our_errors  = '';

		// Grab key from the $_POST.
		if ( isset( $input['wp-2fa-totp-key'] ) ) {
			$current_key = sanitize_text_field( wp_unslash( $input['wp-2fa-totp-key'] ) );
		}

		// Grab authcode and ensure its a number.
		if ( isset( $input['wp-2fa-totp-authcode'] ) ) {
			$input['wp-2fa-totp-authcode'] = (int) $input['wp-2fa-totp-authcode'];
		}

		// Check if we are dealing with totp or email, if totp validate and store a new secret key.
		if ( ! empty( $input['wp-2fa-totp-authcode'] ) && ! empty( $current_key ) ) {
			if ( Authentication::is_valid_key( $current_key ) || ! is_numeric( $input['wp-2fa-totp-authcode'] ) ) {
				if ( ! Authentication::is_valid_authcode( $current_key, sanitize_text_field( wp_unslash( $input['wp-2fa-totp-authcode'] ) ) ) ) {
					$our_errors = esc_html__( 'Invalid Two Factor Authentication code.', 'wp-2fa' );
				}
			} else {
				$our_errors = esc_html__( 'Invalid Two Factor Authentication secret key.', 'wp-2fa' );
			}

			// If its not totp, is it email.
		} elseif ( ! empty( $input['wp-2fa-email-authcode'] ) ) {
			if ( ! Authentication::validate_token( $user->ID, sanitize_text_field( wp_unslash( $input['wp-2fa-email-authcode'] ) ) ) ) {
				$our_errors = __( 'Invalid Email Authentication code.', 'wp-2fa' );
			}
		} else {
			$our_errors = __( 'Please enter the code to finalize the 2FA setup.', 'wp-2fa' );
		}

		if ( ! empty( $our_errors ) ) {
			// Send the response.
			wp_send_json_error(
				array(
					'error' => $our_errors,
				)
			);
		} else {
			$this->save_user_2fa_options( $input );
			// Send the response.
			wp_send_json_success();
		}
	}

	/**
	 * @param int $user_id User ID.
	 *
	 * @return bool True if the user can remove 2FA from their account.
	 */
	public static function can_user_remove_2fa( $user_id ) {
		//	check the "Hide the Remove 2FA button" setting
		if ( WP2FA::get_wp2fa_setting( 'hide_remove_button' ) ) {
			return false;
		}

		//	check grace period policy
		$grace_policy = WP2FA::get_wp2fa_setting( 'grace-policy' );
		if ( 'no-grace-period' === $grace_policy ) {
			//	we only need to run further checks to find out if the 2FA is enforced for the user in question if there
			//	is no grace period
			$enforcement_policy = WP2FA::get_wp2fa_setting( 'enforcment-policy');
			if ( 'all-users' === $enforcement_policy ) {
				//	enforced for all users, target user is definitely included
				return false;
			}

			if ( 'do-not-enforce' !== $enforcement_policy ) {
				//	one of possible enforcement options is set, check the target user
				return Authentication::is_user_eligible_for_2fa( $user_id );
			}
		}

		return true;
	}
}
