<?php // phpcs:ignore

namespace WP2FA\Cron;

use WP2FA\Admin\SettingsPage;
use \WP2FA\WP2FA as WP2FA;
use \WP2FA\Authenticator\Authentication as Authentication;

/**
 * Class for handling our crons.
 */
class CronTasks {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_2fa_check_grace_period_status', array( $this, 'wp_2fa_check_users_grace_period_status' ) );
		add_action( 'init', array( $this, 'register_check_users_grace_period_status_event' ) );
	}

	// This function will run once the 'wp_2fa_check_users_grace_period_status' is called
	public function wp_2fa_check_users_grace_period_status() {
		$users = array();

		if ( 'do-not-enforce' !== WP2FA::get_wp2fa_setting( 'enforcment-policy' ) && ! empty( WP2FA::get_wp2fa_setting( 'enable_grace_cron' ) ) ) {
			if ( WP2FA::is_this_multisite() ) {
				$users_args = array( 'blog_id' => 0 );
			} else {
				$users_args = array();
			}
			foreach ( get_users( $users_args ) as $user ) {
				$grace_period_expiry_time = get_user_meta( $user->ID, 'wp_2fa_grace_period_expiry', true );
				$grace_period_expired     = get_user_meta( $user->ID, 'wp_2fa_user_grace_period_expired', true );
				$locked_notification      = get_user_meta( $user->ID, 'wp_2fa_locked_account_notification', true );
				$is_user_forced_to_setup  = get_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true );
				$is_needed                = Authentication::is_user_eligible_for_2fa( $user->ID );
				$is_user_excluded         = WP2FA::is_user_excluded( $user->ID );
				$time_now                 = time();
				if ( $grace_period_expiry_time < $time_now && $is_needed && ! $is_user_excluded && ! $is_user_forced_to_setup ) {
					$grace_expired = update_user_meta( $user->ID, 'wp_2fa_user_grace_period_expired', true );

					// Send the email to alert the user, only if we have not done so before.
					if ( ! $locked_notification  ) {
						$this->send_expired_grace_email( $user->ID );
						$locked_account_notification = update_user_meta( $user->ID, 'wp_2fa_locked_account_notification', true );
					}

					// Check if we also want to destory the user session now that the grace period has expired.
					if ( ! empty( WP2FA::get_wp2fa_setting( 'enable_destroy_session' ) ) ) {
						// Grab user session and kill it, preferably with fire.
						$manager = \WP_Session_Tokens::get_instance( $user->ID );
						$manager->destroy_all();
					}
				}
			}
		}
	}

	// Function which will register the event
	function register_check_users_grace_period_status_event() {
		// Make sure this event hasn't been scheduled
		if ( ! wp_next_scheduled( 'wp_2fa_check_grace_period_status' ) && ! empty( WP2FA::get_wp2fa_setting( 'enable_grace_cron' ) ) ) {
			// Schedule the event
			wp_schedule_event( time(), 'hourly', 'wp_2fa_check_grace_period_status' );
		}
	}

	/**
	 * Send email to setup authentication
	 */
	public static function send_expired_grace_email( $user_id ) {
		// Bail if the user has not enabled this email.
		if ( 'enable_account_locked_email' !== WP2FA::get_wp2fa_email_templates( 'send_account_locked_email' ) ) {
			return false;
		}

		// Grab user data
		$user = get_userdata( $user_id );
		// Grab user email
		$email = $user->user_email;

		$subject = wp_strip_all_tags( WP2FA::replace_email_strings( WP2FA::get_wp2fa_email_templates( 'user_account_locked_email_subject' ), $user_id ) );
		$message = wpautop( WP2FA::replace_email_strings( WP2FA::get_wp2fa_email_templates( 'user_account_locked_email_body' ), $user_id ) );

		SettingsPage::send_email( $email, $subject, $message );
	}
}
