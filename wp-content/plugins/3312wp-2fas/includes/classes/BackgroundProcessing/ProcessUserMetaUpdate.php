<?php // phpcs:ignore

namespace WP2FA\BackgroundProcessing;

use \WP2FA\Admin\SettingsPage as SettingsPage;
use WP2FA\Utils\DateTimeUtils;
use \WP2FA\WP2FA as WP2FA;
use \WP2FA\Authenticator\Authentication as Authentication;

/**
 * Class for handling our crons.
 */
class ProcessUserMetaUpdate extends \WP_Background_Process {

	/**
	 * Name of the cron we are going to attach these to.
	 *
	 * @var string
	 */
	protected $action = '2fa_update_user_meta';

	/**
	 * Task to perform in the BG
	 *
	 * @param  object $item Consists of User ID, name of the job we want to do, and optional extras.
	 */
	protected function task( $item ) {

		if ( empty( $item ) || ! isset( $item ) ) {
			return false;
		}

		// Delete grace period from user meta.
		if ( isset( $item['task'] ) && 'delete_grace_period' === $item['task'] ) {
			// Check if single user.
			if ( isset( $item['user'] ) ) {
				delete_user_meta( $item['user']->ID, 'wp_2fa_grace_period_expiry' );
				delete_user_meta( $item['user']->ID, 'wp_2fa_user_enforced_instantly' );
			}
			// Check array of users.
			if ( isset( $item['users'] ) ) {
				foreach ( $item['users'] as $user ) {
					delete_user_meta( $user->ID, 'wp_2fa_grace_period_expiry' );
					delete_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly' );
				}
			}
		}

		// Remove enabled methods, happens when we disable and once enabled 2FA method.
		if ( isset( $item['task'] ) && 'remove_enabled_methods' === $item['task'] ) {
			$method_to_remove = ( isset( $item['method_to_remove'] ) && ! empty( $item['method_to_remove'] ) ) ? $item['method_to_remove'] : false;
			if ( isset( $item['user'] ) ) {
				$enabled = get_user_meta( $item['user']->ID, 'wp_2fa_enabled_methods', true );
				if ( ! empty( $method_to_remove ) && $method_to_remove === $enabled ) {
					delete_user_meta( $item['user']->ID, 'wp_2fa_enabled_methods' );
					update_user_meta( $item['user']->ID, 'wp_2fa_user_needs_to_reconfigure_2fa', true );
				}
			}
			if ( isset( $item['users'] ) ) {
				foreach ( $item['users'] as $user ) {
					$enabled = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );
					if ( ! empty( $method_to_remove ) && $method_to_remove === $enabled  ) {
						delete_user_meta( $user->ID, 'wp_2fa_enabled_methods' );
						update_user_meta( $user->ID, 'wp_2fa_user_needs_to_reconfigure_2fa', true );
					}
				}
			}
		}

		// Remove ALL 2FA user data from user meta.
		if ( isset( $item['task'] ) && 'wipe_all_2fa_user_data' === $item['task'] ) {
			if ( ! isset( $item['excluded_roles'] ) ) {
				return false;
			}

			$excluded_roles_array = $item['excluded_roles'];

			if ( isset( $item['user'] ) ) {
				// Compare the user roles to the ones we are excluding and see if we get a match.
				$user_info = get_userdata( $item['user']->ID );
				$result    = array_intersect( $excluded_roles_array, $user_info->roles );
				// If we do, lets wipe!
				if ( ! empty( $result ) ) {
					$wipe_totp_key           = delete_user_meta( $item['user']->ID, 'wp_2fa_totp_key' );
					$wipe_backup_codes       = delete_user_meta( $item['user']->ID, 'wp_2fa_backup_codes' );
					$wipe_enabled_methods    = delete_user_meta( $item['user']->ID, 'wp_2fa_enabled_methods' );
					$wipe_grace_period       = delete_user_meta( $item['user']->ID, 'wp_2fa_grace_period_expiry' );
					$wipe_enforced_instantly = delete_user_meta( $item['user']->ID, 'wp_2fa_user_enforced_instantly' );
				}
			}

			if ( isset( $item['users'] ) ) {
				foreach ( $item['users'] as $user ) {
					// Compare the user roles to the ones we are excluding and see if we get a match.
					$user_info = get_userdata( $user->ID );
					$result    = array_intersect( $excluded_roles_array, $user_info->roles );
					// If we do, lets wipe!
					if ( ! empty( $result ) ) {
						$wipe_totp_key           = delete_user_meta( $user->ID, 'wp_2fa_totp_key' );
						$wipe_backup_codes       = delete_user_meta( $user->ID, 'wp_2fa_backup_codes' );
						$wipe_enabled_methods    = delete_user_meta( $user->ID, 'wp_2fa_enabled_methods' );
						$wipe_grace_period       = delete_user_meta( $user->ID, 'wp_2fa_grace_period_expiry' );
						$wipe_enforced_instantly = delete_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly' );
					}
				}

			}
		}

		// Enforce 2FA on a user.
		if ( isset( $item['task'] ) && 'enforce_2fa_for_user' === $item['task'] ) {

			// Check if a policy has been posted, so we know the freshest setting.
			if ( isset( $item['grace_policy'] ) ) {
				$grace_policy = sanitize_text_field( $item['grace_policy'] );
			} else {
				$grace_policy = WP2FA::get_wp2fa_setting( 'grace-policy' );
			}

			// Check if want to apply the custom period, or instant expiry.
			if ( 'use-grace-period' === $grace_policy ) {
				$grace_expiry = (int) $item['grace_expiry'];
			} else {
				$grace_expiry = time();
			}

			$grace_policy_string = DateTimeUtils::format_grace_period_expiration_string( $grace_policy, $grace_expiry );

			if ( isset( $item['user'] ) ) {
				$current = (int) get_user_meta( $item['user']->ID, 'wp_2fa_grace_period_expiry', true );
				if ( $current !== $grace_expiry ) {
					if ( 'use-grace-period' === $grace_policy ) {
						delete_user_meta( $item['user']->ID, 'wp_2fa_user_enforced_instantly' );
					}
					update_user_meta( $item['user']->ID, 'wp_2fa_grace_period_expiry', $grace_expiry );
					if ( 'no-grace-period' === $grace_policy ) {
						update_user_meta( $item['user']->ID, 'wp_2fa_user_enforced_instantly', true );
					}
					if ( isset( $item['notify_users'] ) && ! empty( $item['notify_users'] ) ) {
						SettingsPage::send_2fa_enforced_email( $item['user']->ID, $grace_policy_string );
					}
				}
			}
			if ( isset( $item['users'] ) ) {
				foreach ( $item['users'] as $user ) {
					$user = get_user_by( 'ID', $user->ID );
					$current = (int) get_user_meta( $user->ID, 'wp_2fa_grace_period_expiry', true );
					$is_needed        = Authentication::is_user_eligible_for_2fa( $user->ID, $item['enforcment-policy'], $item['excluded_users'], $item['excluded_roles'], $item['enforced_users'], $item['enforced_roles'] );
					$is_user_excluded = WP2FA::is_user_excluded( $user, $item['excluded_users'], $item['excluded_roles'], $item['excluded_sites'] );
					if ( $is_needed && ! $is_user_excluded ) {
						if ( $current !== $grace_expiry ) {
							if ( 'use-grace-period' === $grace_policy ) {
								delete_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly' );
							}
							update_user_meta( $user->ID, 'wp_2fa_grace_period_expiry', $grace_expiry );
							if ( 'no-grace-period' === $grace_policy ) {
								update_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true );
							}
							if ( isset( $item['notify_users'] ) && ! empty( $item['notify_users'] ) ) {
								SettingsPage::send_2fa_enforced_email( $user->ID, $grace_policy_string );
							}
						}
					}
				}
			}
		}

		return false;
	}

	/**
	 * Fire off event so we know the above tasks have completed.
	 */
	protected function complete() {
		parent::complete();
	}

}
