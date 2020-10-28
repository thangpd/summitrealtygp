<?php
/**
 * Template Name: Listing Analytics
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

if (session_status() == PHP_SESSION_NONE) { session_start(); } 

global $ct_options; 

$submit_listing = isset( $ct_options['ct_submit'] ) ? esc_html( $ct_options['ct_submit'] ) : '';
$ct_enable_front_end_paid = isset( $ct_options['ct_enable_front_end_paid'] ) ? esc_attr( $ct_options['ct_enable_front_end_paid'] ) : '';
$ct_listing_stats_on_off = isset( $ct_options['ct_listing_stats_on_off'] ) ? esc_attr( $ct_options['ct_listing_stats_on_off'] ) : '';
$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$edit = $ct_options['ct_edit'];
$userID = get_current_user_id();

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

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
<?php }

endwhile; endif; ?>

<div id="page-content" class="container marT30">

    <?php if(is_user_logged_in()) {
        get_template_part('/includes/user-sidebar');
    } ?>

    <article id="listing-analytics-wrap" class="col <?php if(is_user_logged_in()) { echo 'span_9'; } else { echo 'span_12 first'; } ?> marB60">

        <?php if(!is_user_logged_in()) {
                
                echo '<div class="inner-content">';
                    echo '<div class="must-be-logged-in">';
                        echo '<h4 class="center marB20">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
                        echo '<p class="center login-register-btn marB0"><a class="btn login-register" href="#">Login/Register</a></p>';
                    echo '</div>';
                echo '</div>';

            } else { ?>

            <?php the_content(); ?>
            
        <?php } ?>

    </article>
	
		<div class="clear"></div>

</div>

<?php get_footer(); ?>