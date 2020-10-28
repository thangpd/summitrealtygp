<?php // phpcs:ignore

namespace WP2FA\Admin;

use WP2FA\Utils\DateTimeUtils;
use \WP2FA\WP2FA as WP2FA;
use \WP2FA\Authenticator\Authentication as Authentication;

/**
 * UserNotices - Class for displaying notices to our users.
 */
class UserNotices {

	/**
	 * Lets set things up
	 */
	public function __construct() {
		$enforcement_policy = WP2FA::get_wp2fa_setting( 'enforcment-policy' );
		if ( ! empty( $enforcement_policy ) ) {
			// Check we are supposed to, before adding action to show nag.
			if ( in_array( $enforcement_policy, [ 'all-users', 'certain-roles-only', 'certain-users-only', 'superadmins-only' ] ) ) {
				add_action( 'admin_notices', array( $this, 'user_setup_2fa_nag' ) );
				add_action( 'network_admin_notices', array( $this, 'user_setup_2fa_nag' ) );
			} elseif ( 'do-not-enforce' === WP2FA::get_wp2fa_setting( 'enforcment-policy' ) ) {
				add_action( 'admin_notices', array( $this, 'user_reconfigure_2fa_nag' ) );
				add_action( 'network_admin_notices', array( $this, 'user_setup_2fa_nag' ) );
			}
		}
	}

	/**
	 * The nag content
	 */
	public function user_setup_2fa_nag( $is_shortcode = '', $configure_2fa_url = '' ) {

		$user = wp_get_current_user();

		if ( isset( $_GET['user_id'] ) ) {
			$current_profile_user_id = (int) $_GET['user_id'];
		} elseif ( ! empty( $user ) ) {
			$current_profile_user_id = $user->ID;
		} else {
			$current_profile_user_id = false;
		}

		if ( ! $current_profile_user_id || isset( $_GET['user_id'] ) && $_GET['user_id'] !== $user->ID || get_user_meta( $user->ID, 'wp_2fa_user_enforced_instantly', true ) ) {
			return;
		}

		$class           = 'notice notice-info wp-2fa-nag';
		$grace_expiry    = get_user_meta( $user->ID, 'wp_2fa_grace_period_expiry', true );
		$reconfigure_2fa = get_user_meta( $user->ID, 'wp_2fa_user_needs_to_reconfigure_2fa', true );
		if ( $reconfigure_2fa ) {
			$message = esc_html__( 'The 2FA method you were using is no longer allowed on this website. Please reconfigure 2FA using one of the supported methods within', 'wp-2fa' );
		} else {
			$message = esc_html__( 'This website’s administrator requires you to enable 2FA authentication', 'wp-2fa' );
		}

		$is_nag_dismissed = get_user_meta( $user->ID, 'wp_2fa_update_nag_dismissed', true );
		$is_nag_needed    = Authentication::is_user_eligible_for_2fa( $user->ID );
		$is_user_excluded = WP2FA::is_user_excluded( $user->ID );
		$enabled_methods  = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );

		// Swap URLS depending on the context of this notice's display.
		if ( isset( $is_shortcode ) && 'output_shortcode' === $is_shortcode ) {
			if ( ! empty( $configure_2fa_url ) ) {
				$setup_url = $configure_2fa_url;
			} else {
				if ( ! empty( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) ) ) {
					$new_page_id        = WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
					$new_page_permalink = get_permalink( $new_page_id );
					if ( $new_page_permalink ) {
						$setup_url = $new_page_permalink;
					} else {
						$setup_url = admin_url( 'options-general.php?page=wp-2fa-setup&current-step=choose_2fa_method&first_time_setup=true' );
					}
				} else {
					$setup_url = admin_url( 'options-general.php?page=wp-2fa-setup&current-step=choose_2fa_method&first_time_setup=true' );
				}
			}
		} else {
			if ( is_admin() ) {
				if ( ! empty( WP2FA::get_wp2fa_setting( 'custom-user-page-id' ) ) ) {
					$new_page_id        = WP2FA::get_wp2fa_setting( 'custom-user-page-id' );
					$new_page_permalink = get_permalink( $new_page_id );
					if ( $new_page_permalink ) {
						$setup_url = $new_page_permalink;
					} else {
						$setup_url = admin_url( 'options-general.php?page=wp-2fa-setup&current-step=choose_2fa_method&first_time_setup=true' );
					}
				} else {
					$setup_url = admin_url( 'options-general.php?page=wp-2fa-setup&current-step=choose_2fa_method&first_time_setup=true' );
				}
			} else {
				$setup_url = '#open-2fa-wizard';
			}
		}

		// If the nag has not already been dismissed, and of course if the user is eligible, lets show them something.
		if ( ! $is_nag_dismissed && $is_nag_needed && empty( $enabled_methods ) && ! $is_user_excluded && ! empty( $grace_expiry ) ) {
			printf(
				'<div class="%1$s"><p>%2$s <span class="grace-period-countdown">%3$s</span> <a href="%4$s" class="button button-primary">%5$s</a> <a href="#" class="button button-secondary dismiss-user-configure-nag">%6$s</a></p></div>',
				esc_attr( $class ),
				esc_html( $message ),
				esc_attr( DateTimeUtils::format_grace_period_expiration_string(null, $grace_expiry) ),
				esc_url( $setup_url ),
				esc_html__( 'Configure 2FA now', 'wp-2fa' ),
				esc_html__( 'Remind me on next login', 'wp-2fa' )
			);
		}
	}

	/**
	 * The nag content
	 */
	public function user_reconfigure_2fa_nag() {
		$class           = 'notice notice-info wp-2fa-nag';
		$grace_period    = WP2FA::get_wp2fa_setting( 'grace-period-expiry-time' );
		$user            = wp_get_current_user();
		$reconfigure_2fa = get_user_meta( $user->ID, 'wp_2fa_user_needs_to_reconfigure_2fa', true );

		$message = esc_html__( 'The 2FA method you were using is no longer allowed on this website. Please reconfigure 2FA using one of the supported methods.', 'wp-2fa' );

		$enabled_methods = get_user_meta( $user->ID, 'wp_2fa_enabled_methods', true );
		// If the nag has not already been dismissed, and of course if the user is eligible, lets show them something.
		if ( ! empty( $reconfigure_2fa ) && empty( $enabled_methods ) ) {
			printf(
				'<div class="%1$s"><p>%2$s <a href="%4$s" class="button button-primary">%5$s</a> <a href="#" class="button button-secondary dismiss-user-reconfigure-nag">%6$s</a></p></div>',
				esc_attr( $class ),
				esc_html( $message ),
				esc_attr( $grace_period ),
				esc_url( admin_url( 'options-general.php?page=wp-2fa-setup&current-step=choose_2fa_method&first_time_setup=true' ) ),
				esc_html__( 'Configure 2FA now', 'wp-2fa' ),
				esc_html__( 'I\'ll do it later', 'wp-2fa' )
			);
		}
	}

	/**
	 * Dismiss notice and setup a user meta value so we know its been dismissed
	 */
	public function dismiss_nag() {
		$user    = wp_get_current_user();
		$updated = update_user_meta( $user->ID, 'wp_2fa_update_nag_dismissed', true );
	}

	/**
	 * Dismiss reconfigure nag
	 */
	public function dismiss_reconfigure_nag() {
		$user    = wp_get_current_user();
		$updated = delete_user_meta( $user->ID, 'wp_2fa_user_needs_to_reconfigure_2fa' );
	}

	/**
	 * Reset the nag when the user logs out, so they get it again next time.
	 */
	public function reset_nag() {
		$user    = wp_get_current_user();
		$deleted = delete_user_meta( $user->ID, 'wp_2fa_update_nag_dismissed' );
	}

}
