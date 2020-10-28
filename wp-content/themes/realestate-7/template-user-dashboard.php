<?php
/**
 * Template Name: User Dashboard
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options, $current_user, $wp_roles;

$current_user = wp_get_current_user();

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

get_header();

if ( ! function_exists( 'wp_handle_upload' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

while ( have_posts() ) : the_post();

if($inside_page_title == "Yes") { 
	// Custom Page Header Background Image
	if(get_post_meta($post->ID, '_ct_page_header_bg_image', true) != '') {
		echo'<style type="text/css">';
		echo '#single-header { background: url(';
		echo get_post_meta($post->ID, '_ct_page_header_bg_image', true);
		echo ') no-repeat center center; background-size: cover;}';
		echo '</style>';
	} ?>

	<!-- Single Header -->
	<div id="single-header">
		<div class="dark-overlay">
			<div class="container">
				<h1 class="marT0 marB0"><?php the_title(); ?></h1>
				<?php if(get_post_meta($post->ID, '_ct_page_sub_title', true) != '') { ?>
					<h2 class="marT0 marB0"><?php echo get_post_meta($post->ID, "_ct_page_sub_title", true); ?></h2>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- //Single Header -->
<?php } ?>

<?php echo '<div id="page-content" class="container">'; ?>

	<?php do_action('before_user_dashboard'); ?>

	<?php if(is_user_logged_in()) {
        get_template_part('/includes/user-sidebar');
    } ?>

    <article class="col <?php if(is_user_logged_in()) { echo 'span_9'; } else { echo 'span_12 first'; } ?> marB60">

    	<?php if(!is_user_logged_in()) {
            echo '<div class="must-be-logged-in">';
				echo '<h4 class="center marB20">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
                echo '<p class="center login-register-btn marB0"><a class="btn login-register" href="#">Login/Register</a></p>';
            echo '</div>';
        } else {

        	$ct_package_list = isset( $ct_options['ct_package_list'] ) ? esc_html( $ct_options['ct_package_list'] ) : '';
        	$ct_saved_listings = isset( $ct_options['ct_saved_listings'] ) ? esc_html( $ct_options['ct_saved_listings'] ) : '';
            $ct_listing_email_alerts_page_id = isset( $ct_options['ct_listing_email_alerts_page_id'] ) ? esc_attr( $ct_options['ct_listing_email_alerts_page_id'] ) : '';
            $ct_submit_listing = isset( $ct_options['ct_submit'] ) ? esc_html( $ct_options['ct_submit'] ) : '';
            $ct_view_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';
            $ct_membership = isset( $ct_options['ct_membership'] ) ? esc_html( $ct_options['ct_membership'] ) : '';
            $ct_invoices = isset( $ct_options['ct_invoices'] ) ? esc_html( $ct_options['ct_invoices'] ) : '';
            $ct_listing_analytics = isset( $ct_options['ct_listing_analytics'] ) ? esc_html( $ct_options['ct_listing_analytics'] ) : '';
            $ct_user_profile = isset( $ct_options['ct_profile'] ) ? esc_html( $ct_options['ct_profile'] ) : '';

        ?>
        
			<?php the_content(); ?>

			<?php
            	if($ct_membership != '' && function_exists('ct_create_packages')) {
            		//echo '<a class="card-link" href="' . get_page_link($ct_membership) . '">';
	                	echo '<div class="card card-left col span_12 first card-membership">';
	                		echo '<div class="card-inner">';
	                			echo '<p class="muted">' . __('Membership', 'contempo') . '</p>';
			                	echo do_shortcode('[dashboard_membership_package]');
			               	echo '</div>';
	                	 echo '</div>';
                	//echo '</a>';
                }
            ?>

			<?php
            	$ct_user_listings = ct_listing_post_count($current_user->ID, 'listings');
            	if($ct_user_listings >= 0 && $ct_options['ct_enable_front_end'] == 'yes') {
            		echo '<a class="card-link" href="' . get_page_link($ct_view_listings) . '">';
	                	echo '<div class="card col span_4 first card-my-listings">';
	                		echo '<div class="card-inner">';
		                		echo '<div class="lrg-icon">';
			                		echo '<i class="fa fa-th-list"></i>';
			                	echo '</div>';
			                	 echo '<h1>';
			                	 	echo esc_html($ct_user_listings);
			                	 echo '</h1>';
			                	 echo '<p class="muted">' . __('My Listings', 'contempo') . '</p>';
			               	echo  '</div>';
	                	echo '</div>';
                	echo '</a>';
                }
            ?>

            <?php
            	$ct_user_featured_listings = ct_listing_featured_post_count($current_user->ID, 'listings', 'featured');
            	if($ct_user_featured_listings >= 0 && $ct_options['ct_enable_front_end'] == 'yes') {
            		echo '<a class="card-link" href="' . get_page_link($ct_view_listings) . '">';
	                	echo '<div class="card col span_4 card-featured-listings">';
	                		echo '<div class="card-inner">';
		                		echo '<div class="lrg-icon">';
			                		echo '<i class="fa fa-star"></i>';
			                	echo '</div>';
			                	 echo '<h1>';
			                	 	echo esc_html($ct_user_featured_listings);
			                	 echo '</h1>';
			                	 echo '<p class="muted">' . __('Featured Listings', 'contempo') . '</p>';
			               	echo  '</div>';
	                	echo '</div>';
                	echo '</a>';
                }
            ?>

            <?php
            	$ct_user_pending_listings = ct_listing_pending_post_count($current_user->ID, 'listings');
            	if($ct_user_pending_listings >= 0 && $ct_options['ct_enable_front_end'] == 'yes') {
            		echo '<a class="card-link" href="' . get_page_link($ct_view_listings) . '">';
	                	echo '<div class="card col span_4 card-pending-listings">';
	                		echo '<div class="card-inner">';
		                		echo '<div class="lrg-icon">';
			                		echo '<i class="fa fa-file"></i>';
			                	echo '</div>';
			                	 echo '<h1>';
			                	 	echo esc_html($ct_user_pending_listings);
			                	 echo '</h1>';
			                	 echo '<p class="muted">' . __('Pending Listings', 'contempo') . '</p>';
			               	echo  '</div>';
	                	echo '</div>';
                	echo '</a>';
                }
            ?>

            <?php if(class_exists('ctListingAnalytics')) {

					echo do_shortcode('[ct_listing_analytics_dashboard_views]');
				
					echo do_shortcode('[ct_listing_analytics_dashboard_downloads]');

			} ?>
	    
                <div class="clear"></div>

		<?php } ?>
        
        <?php //wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
        
        <?php endwhile; ?>
        
            <div class="clear"></div>

        <?php do_action('after_user_dashboard_content'); ?>             

    </article>

    <?php do_action('after_user_dashboard'); ?>

<?php 
	echo '<div class="clear"></div>';
echo '</div>';

get_footer(); ?>