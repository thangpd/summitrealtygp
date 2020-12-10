<?php
/**
 * Template Name: Listing Email Alerts
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options, $current_user, $wp_roles;
wp_get_current_user();
$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

$search_params = array(); 
$loop = 0;
$search_values = array('1','2');
foreach ($search_values as $t => $s) {                                  
	$term = get_term_by('slug',$s,$t);
	if($term != '0') {
		$search_params[] = $term->name;   
	}
}
$search_params[] = isset( $_GET['ct_keyword'] ) ? $_GET['ct_keyword'] : '';
$search_params = implode(', ', $search_params);

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

        <?php if(is_user_logged_in()) {
            get_template_part('/includes/user-sidebar');
        } ?>
    
        <article class="col <?php if(is_user_logged_in()) { echo 'span_9'; } else { echo 'span_12 first'; } ?> listing-email-alerts marB60">

            <div class="inner-content">

            	<?php if(!is_user_logged_in()) {
                    echo '<div class="must-be-logged-in">';
                        echo '<h4 class="center marB20">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
                        echo '<p class="center login-register-btn marB0"><a class="btn login-register" href="#">Login/Register</a></p>';
                    echo '</div>';
                } else { ?>
                
    				<?php the_content(); ?>

                    <?php if (function_exists('ctea_show_alert_creation')) { ?>

                        <?php echo do_shortcode('[ctea_alert_creation]'); ?>

                            <div class="clear"></div>

                        <section class="col span_12 first marB60 manage-alerts">

                            <h3 class="marB5"><?php _e('Manage your alerts', 'contempo'); ?></h3>
                            <p class="muted"><?php _e('Here you can turn saved alerts on/off or remove them completely.', 'contempo'); ?></p>

                            <div class="col span_12 first current-alerts">
            					<header class="marB20">
                                    <div class="col span_7 first">
                                        <h6 class="saved-search-query"><?php _e('Query', 'contempo'); ?></h6>
                                    </div>
                                    <div class="col span_2">
                                        <h6 class="date-created"><?php _e('Date Created', 'contempo'); ?></h6>
                                    </div>
                                    <div class="col span_2">
                                        <h6><?php _e('Email Setting', 'contempo'); ?></h6>
                                    </div>
                                    <div class="col span_1 delete">
                                        <h6><?php _e('Delete', 'contempo'); ?></h6>
                                    </div>
                                        <div class="clear"></div>
                                </header>

								<?php 
								global $wpdb, $current_user, $wp_query;
								wp_get_current_user();

                                $table_name     = $wpdb->prefix . 'ct_search';
                                $results        = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE auther_id = ' . $current_user->ID . ' ORDER BY time DESC', OBJECT );

                                if ( sizeof( $results ) !== 0 ) :

                                    echo '<ul>';

                                        foreach ( $results as $ct_search_data ) :
    									
                                            get_template_part( 'layouts/saved-search-list' );
    										
                                        endforeach;

                                    echo '</ul>';

                                else :

                                    echo '<div class="no-alerts">';
                                        _e('You don\'t have any saved searches yet, create one above.', 'contempo');
                                    echo '</div>';

                                endif; 
								?>

                            </div>

                        </section>

                    <?php } else { ?>

                        <h4 class="center"><?php _e('Activate "Contempo Email Alerts" plugin via Appearance > Install Plugins.', 'contempo'); ?></h4>

                    <?php } ?>

    			<?php } ?>
                
                <?php //wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
                
                <?php endwhile; ?>
                
                    <div class="clear"></div>

            </div>

        </article>

<?php 
	echo '<div class="clear"></div>';
echo '</div>';

get_footer(); ?>