<?php
/**
 * User Sidebar Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Includes
 */

global $ct_options;

$current_user = wp_get_current_user();

$ct_user_listings_count          = ct_listing_post_count( $current_user->ID, 'listings' );
$ct_user_dashboard               = isset( $ct_options['ct_user_dashboard'] ) ? esc_html( $ct_options['ct_user_dashboard'] ) : '';
$ct_saved_listings               = isset( $ct_options['ct_saved_listings'] ) ? esc_html( $ct_options['ct_saved_listings'] ) : '';
$ct_listing_email_alerts_page_id = isset( $ct_options['ct_listing_email_alerts_page_id'] ) ? esc_attr( $ct_options['ct_listing_email_alerts_page_id'] ) : '';
$ct_submit_listing               = isset( $ct_options['ct_submit'] ) ? esc_html( $ct_options['ct_submit'] ) : '';
$ct_view_user_listings           = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';
$ct_membership                   = isset( $ct_options['ct_membership'] ) ? esc_html( $ct_options['ct_membership'] ) : '';
$ct_invoices                     = isset( $ct_options['ct_invoices'] ) ? esc_html( $ct_options['ct_invoices'] ) : '';
$ct_listing_analytics            = isset( $ct_options['ct_listing_analytics'] ) ? esc_html( $ct_options['ct_listing_analytics'] ) : '';
$ct_user_profile                 = isset( $ct_options['ct_profile'] ) ? esc_html( $ct_options['ct_profile'] ) : '';
$ct_mortgage_caculator           = isset( $ct_options['ct_mortgage_caculator'] ) ? esc_html( $ct_options['ct_mortgage_caculator'] ) : '';
$ct_summit_resource              = isset( $ct_options['ct_summit_resource'] ) ? esc_html( $ct_options['ct_summit_resource'] ) : '';
$ct_summit_user_upload           = isset( $ct_options['ct_summit_user_upload'] ) ? esc_html( $ct_options['ct_summit_user_upload'] ) : '';

?>

<?php do_action( 'before_user_sidebar' ); ?>

    <!-- Sidebar -->
    <div id="user-sidebar" class="col span_3 first">
        <div id="sidebar-inner">

            <aside id="user-nav" class="widget left">
                <ul class="user-nav">
					<?php do_action( 'first_user_sidebar_menu' ); ?>
					<?php if ( in_array( 'administrator', (array) $current_user->roles ) || in_array( 'editor', (array) $current_user->roles ) || in_array( 'author', (array) $current_user->roles ) || in_array( 'contributor', (array) $current_user->roles ) || in_array( 'seller', (array) $current_user->roles ) || in_array( 'agent', (array) $current_user->roles ) || in_array( 'broker', (array) $current_user->roles ) ) { ?>
						<?php if ( $ct_user_dashboard != '' && function_exists( 'ct_create_packages' ) ) { ?>
                            <li class="membership"><a <?php if ( is_page( $ct_user_dashboard ) ) {
									echo 'class="current"';
								} ?> href="<?php echo get_page_link( $ct_user_dashboard ); ?>"><i
                                            class="fas fa-tachometer-alt"></i> <?php esc_html_e( 'Dashboard', 'contempo' ); ?>
                                </a></li>
						<?php } ?>
					<?php } ?>
					<?php if ( $ct_saved_listings != '' && function_exists( 'wpfp_link' ) ) { ?>
                        <li class="saved-listings"><a <?php if ( is_page( $ct_saved_listings ) ) {
								echo 'class="current"';
							} ?> href="<?php echo get_page_link( $ct_saved_listings ); ?>"><i
                                        class="fas fa-heart"></i> <?php esc_html_e( 'Favorite Listings', 'contempo' ); ?>
                            </a></li>
					<?php } ?>
					<?php if ( $ct_listing_email_alerts_page_id != '' && function_exists( 'ctea_show_alert_creation' ) ) { ?>
                        <li class="listing-email-alerts"><a <?php if ( is_page( $ct_listing_email_alerts_page_id ) ) {
								echo 'class="current"';
							} ?> href="<?php echo get_page_link( $ct_listing_email_alerts_page_id ); ?>"><i
                                        class="fas fa-exclamation-circle"></i> <?php _e( 'Listing Email Alerts', 'contempo' ); ?>
                            </a></li>
					<?php } ?>
					<?php do_action( 'middle_user_sidebar_menu' ); ?>
					<?php if ( in_array( 'administrator', (array) $current_user->roles ) || in_array( 'editor', (array) $current_user->roles ) || in_array( 'author', (array) $current_user->roles ) || in_array( 'contributor', (array) $current_user->roles ) || in_array( 'seller', (array) $current_user->roles ) || in_array( 'agent', (array) $current_user->roles ) || in_array( 'broker', (array) $current_user->roles ) ) { ?>
						<?php if ( ! empty( $ct_submit_listing ) && $ct_options['ct_enable_front_end'] == 'yes' ) { ?>
                            <li class="submit-listing"><a <?php if ( is_page( $ct_submit_listing ) ) {
									echo 'class="current"';
								} ?> href="<?php echo get_page_link( $ct_submit_listing ); ?>"><i
                                            class="fas fa-plus"></i> <?php esc_html_e( 'Submit Listing', 'contempo' ); ?>
                                </a></li>
						<?php } ?>
						<?php if ( ! empty( $ct_view_user_listings ) && $ct_options['ct_enable_front_end'] == 'yes' ) { ?>
                            <li class="my-listings"><a <?php if ( is_page( $ct_view_user_listings ) ) {
									echo 'class="current"';
								} ?> href="<?php echo get_page_link( $ct_view_user_listings ); ?>"><i
                                            class="fas fa-th-list"></i> <?php esc_html_e( 'My Listings', 'contempo' ); ?>
                                    (<?php echo esc_html( $ct_user_listings_count ); ?>)</a></li>
						<?php } ?>
						<?php if ( $ct_membership != '' && function_exists( 'ct_create_packages' ) ) { ?>
                            <li class="membership"><a <?php if ( is_page( $ct_membership ) ) {
									echo 'class="current"';
								} ?> href="<?php echo get_page_link( $ct_membership ); ?>"><i
                                            class="fas fa-id-badge"></i> <?php esc_html_e( 'Membership', 'contempo' ); ?>
                                </a></li>
						<?php } ?>
						<?php if ( $ct_invoices != '' && function_exists( 'ct_create_packages' ) ) { ?>
                            <li class="invoices"><a <?php if ( is_page( $ct_invoices ) ) {
									echo 'class="current"';
								} ?> href="<?php echo get_page_link( $ct_invoices ); ?>"><i
                                            class="fas fa-file-invoice-dollar"></i> <?php esc_html_e( 'Invoices', 'contempo' ); ?>
                                </a></li>
						<?php } ?>
						<?php if ( shortcode_exists( 'ct_listing_analytics' ) && ! empty( $ct_listing_analytics ) ) { ?>
                            <li class="listing-analytics"><a <?php if ( is_page( $ct_listing_analytics ) ) {
									echo 'class="current"';
								} ?> href="<?php echo get_page_link( $ct_listing_analytics ); ?>"><i
                                            class="fas fa-chart-line"></i> <?php esc_html_e( 'Listing Analytics', 'contempo' ); ?>
                                </a></li>
						<?php } ?>
					<?php } ?>
					<?php if ( true ) { ?>
                        <li class="mortgage-caculator"><a <?php if ( is_page( $ct_mortgage_caculator ) ) {
								echo 'class="current"';
							} ?> href="<?php echo get_page_link( $ct_mortgage_caculator ); ?>"><i
                                        class="fas fa-calculator"></i> <?php esc_html_e( 'Mortgage Caculator', 'contempo' ); ?>
                            </a></li>
                        <li class="resource"><a <?php if ( is_page( $ct_summit_resource ) ) {
								echo 'class="current"';
							} ?> href="<?php echo get_page_link( $ct_summit_resource ); ?>"><i
                                        class="fas fa-align-justify"></i> <?php esc_html_e( 'Resource', 'contempo' ); ?>
                            </a></li>
                        <li class="file-upload"><a <?php if ( is_page( $ct_summit_user_upload ) ) {
								echo 'class="current"';
							} ?> href="<?php echo get_page_link( $ct_summit_user_upload ); ?>"><i
                                        class="fas fa-file"></i> <?php esc_html_e( 'Upload', 'contempo' ); ?>
                            </a></li>
					<?php } ?>

					<?php if ( ! empty( $ct_user_profile ) ) { ?>
                        <li class="my-account"><a <?php if ( is_page( $ct_user_profile ) ) {
								echo 'class="current"';
							} ?> href="<?php echo get_page_link( $ct_user_profile ); ?>"><i
                                        class="fas fa-user-circle"></i> <?php esc_html_e( 'Account Settings', 'contempo' ); ?>
                            </a></li>
					<?php } ?>
					<?php do_action( 'last_user_sidebar_menu' ); ?>
                    <li class="logout"><a href="<?php echo wp_logout_url( home_url() ); ?>"><i
                                    class="fa fa-sign-out-alt"></i> <?php esc_html_e( 'Logout', 'contempo' ); ?></a>
                    </li>
                </ul>
            </aside>

			<?php if ( is_active_sidebar( 'user-sidebar' ) ) {
				dynamic_sidebar( 'User Sidebar' );
			} ?>
            <div class="clear"></div>
        </div>
    </div>
    <!-- //Sidebar -->

<?php do_action( 'after_user_sidebar' ); ?>