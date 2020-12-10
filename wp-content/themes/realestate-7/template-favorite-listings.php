<?php
/**
 * Template Name: Favorite Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;
$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

get_header();

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

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

	<!-- Container -->
	<div id="page-content" class="container marT60 padB60">

        <?php if(is_user_logged_in()) {
            get_template_part('/includes/user-sidebar');
        } ?>

		<!-- Page Content -->
		<div class="content col <?php if(is_user_logged_in()) { echo 'span_9'; } else { echo 'span_12 first'; } ?>">
			<?php the_content(); ?>
                
            <?php endwhile; wp_reset_query(); ?>

            <?php
            global $favorite_post_ids;

            if(!empty($user)) {
                if(wpfp_is_user_favlist_public($user))
                    $favorite_post_ids = wpfp_get_users_favorites($user);
            } else {
                $favorite_post_ids = wpfp_get_users_favorites();
            }

            $wpfp_before = "";
            
            echo "<div class='wpfp-span'>";
            
            if (!empty($user)) {
                if (wpfp_is_user_favlist_public($user)) {
                    $wpfp_before = "$user's Favorite Posts.";
                } else {
                    $wpfp_before = "$user's list is not public.";
                }
            }

            if ($wpfp_before):
                echo '<div class="wpfp-page-before">' . $wpfp_before . '</div>';
            endif; ?>

                <?php if(!empty($favorite_post_ids)) { ?>
                    <!-- Request More Info -->
                    <script>    
                        jQuery(document).ready(function() {
                            jQuery(".contact-form").validationEngine({
                                ajaxSubmit: true,
                                ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-favorites.php",
                                ajaxSubmitMessage: "<?php $contact_success = str_replace(array("\r\n", "\r", "\n"), " ", $ct_options['ct_contact_success']); echo esc_html($contact_success); ?>",
                                success :  false,
                                failure : function() {}
                            });
                            jQuery(".fav-contact").click(function() {
                                jQuery("#overlay.contact-modal").addClass('open');
                            });

                            jQuery(".close").click(function() {
                                jQuery("#overlay.contact-modal").removeClass('open');
                                jQuery(".formError").hide();
                            });
                        });
                    </script>

                    <div id="overlay" class="contact-modal">
                        <div id="modal">
                            <div id="modal-inner">
                                <a href="#" class="close"><i class="fa fa-close"></i></a>
                                <form id="listingscontact" class="contact-form formular" method="post">
                                    <fieldset class="col span_12">
                                        <select id="ctsubject" name="ctsubject">
                                            <option><?php esc_html_e('Tell me more about a property', 'contempo'); ?></option>
                                            <option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
                                            <option><?php esc_html_e('General Questions', 'contempo'); ?></option>
                                        </select>
                                            <div class="clear"></div>
                                        <input type="text" name="name" id="name" class="validate[required] text-input" placeholder="<?php esc_html_e('Name', 'contempo'); ?>" />

                                        <input type="text" name="email" id="email" class="validate[required] text-input" placeholder="<?php esc_html_e('Email', 'contempo'); ?>" />

                                        <input type="text" name="ctphone" id="ctphone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" />

                                        <textarea aria-label="" class="validate[required] text-input" name="message" id="message" rows="6" cols="10"></textarea>

                                        <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo esc_html($ct_options['ct_favorite_posts_contact_email']); ?>" />
                                        <input type="hidden" id="ctproperty" name="ctproperty" value="<?php ct_fav_listings_permalinks(); ?>" />

                                        <input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />
                                    </fieldset>
                                        <div class="clear"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- //Request More Info -->
                <?php } ?>

            <?php
            echo '<!-- Saved Listings -->';

            if(!empty($favorite_post_ids)) {
                    echo '<div class="clear"></div>';
                echo '<div class="col span_12 first clear-saved marB20">';
                    echo '<div class="col span_9 first">';
                        echo '<a class="fav-contact btn" href="#">' . __('Request More Information on All Favorites', 'contempo') . '</a>';
                    echo '</div>';
                            
                    echo '<div class="col span_3">';
                        wpfp_clear_list_link();
                    echo '</div>';
                        echo '<div class="clear"></div>';
                echo "</div>";
            }

            echo '<ul class="saved-listings col span_12 first">';
            if($favorite_post_ids) {

                $count = 0;
                $favorite_post_ids = array_reverse($favorite_post_ids);
                $post_per_page = wpfp_get_option("post_per_page");
                $page = intval(get_query_var('paged'));

                $args = array(
                    'post_type' => 'listings',
                    'post__in' => $favorite_post_ids,
                    'posts_per_page'=> $post_per_page,
                    'orderby' => 'post__in',
                    'paged' => $page
                );
                $wp_query = new WP_Query($args);

                while($wp_query->have_posts()) : $wp_query->the_post();

                $ct_property_type = strip_tags( get_the_term_list( $wp_query->post->ID, 'property_type', '', ', ', '' ) );
                $beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
                $baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );

                ?>

                    <li class="fav-listing listing col span_4 <?php echo esc_html($ct_search_results_listing_style); ?> <?php if(is_author()) { if($count % 3 == 0) { echo 'first'; } } else { if($ct_search_results_layout == 'sidebyside') { if($count % 2 == 0) { echo 'first'; } } else { if($count % 3 == 0) { echo 'first'; } } } ?> <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">

                        <?php do_action('before_listing_grid_img'); ?>

                        <figure>
                            <?php ct_status_featured(); ?>
                            <?php ct_status(); ?>
                            <?php ct_property_type_icon(); ?>
                            <?php ct_listing_actions_fav_remove(); ?>
                            <?php ct_first_image_linked(); ?>
                        </figure>

                        <?php do_action('before_listing_grid_info'); ?>

                            <div class="clear"></div>

                        <div class="grid-listing-info">
                            <header>
                                <?php do_action('before_listing_grid_title'); ?>
                                <h5 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
                                <?php do_action('before_listing_grid_address'); ?>
                                <p class="location muted marB0"><?php if(function_exists('city')) { city(); } ?>, <?php if(function_exists('state')) { state(); } ?> <?php if(function_exists('zipcode')) { zipcode(); } ?><?php if(function_exists('country')) { country(); } ?></p>
                            </header>
                            
                            <?php do_action('before_listing_grid_price'); ?>
                            
                            <p class="price marB0"><?php ct_listing_price(); ?></p>

                            <?php do_action('before_listing_grid_propinfo'); ?>
                            
                            <div class="propinfo">
                                <p><?php echo ct_excerpt(); ?></p>
                                <ul class="<?php if($ct_search_results_listing_style == 'modern') { echo 'marB60'; } ?>">
                                    <?php ct_propinfo(); ?>
                                </ul>
                            </div>

                            <?php if($ct_search_results_listing_style == 'modern') {
                                echo '<a class="search-view-listing btn" ';
                                    ct_listing_permalink();
                                echo '>';
                                    echo '<span>' . __('View', 'contempo') . '<i class="fas fa-chevron-right"></i></span>';
                                echo '</a>';
                            } ?>

                            <?php do_action('after_listing_grid_info'); ?>

                            <?php ct_upcoming_open_house(); ?>
                            <?php ct_listing_creation_date(); ?>
                            <?php //ct_listing_grid_agent_info(); ?>

                        </div>
                    
                    </li>
                    
                        <?php

                        $count++;

                        if($count % 3 == 0) {
                            echo '<div class="clear"></div>';
                        } ?>

                <?php endwhile;

                echo '<div class="navigation">';
                    if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
                    <div class="alignleft"><?php next_posts_link( __( 'Previous Entries', 'contempo' ) ) ?></div>
                    <div class="alignright"><?php previous_posts_link( __( 'Next Entries', 'contempo' ) ) ?></div>
                    <?php }
                echo '</div>';

                wp_reset_query();
            } else {
                $wpfp_options = wpfp_get_options();
                echo '<li class="favorite-empty">';
                    echo '<h4>' . $wpfp_options['favorites_empty'] . '</h4>';
                echo '</li>';
            }
            echo "</ul>";
            echo '<!-- //Saved Listings -->';

            //echo '<p class="center">';
               // wpfp_cookie_warning();
            //echo '</p>';
            
            ?>
                
                    <div class="clear"></div>
		</div>
		<!-- //Page Content -->
	</div>
	<!-- //Container -->

<?php get_footer(); ?>