<?php
/**
 * Single Listing Lead Media
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';

$ct_enable_zapier_webhooks = isset( $ct_options['ct_enable_zapier_webhooks'] ) ? $ct_options['ct_enable_zapier_webhooks'] : '';
$ct_zapier_webhook_url = isset( $ct_options['ct_zapier_webhook_url'] ) ? $ct_options['ct_zapier_webhook_url'] : '';
$ct_zapier_webhook_listing_single_form = isset( $ct_options['ct_zapier_webhook_listing_single_form'] ) ? $ct_options['ct_zapier_webhook_listing_single_form'] : '';

$ct_listing_contact_form_7 = isset( $ct_options['ct_listing_contact_form_7'] ) ? esc_html( $ct_options['ct_listing_contact_form_7'] ) : '';
$ct_listing_contact_form_7_shortcode = isset( $ct_options['ct_listing_contact_form_7_shortcode'] ) ? $ct_options['ct_listing_contact_form_7_shortcode'] : '';

$author_id = $post->post_author;

$first_name = get_the_author_meta('first_name', $author_id);
$last_name = get_the_author_meta('last_name', $author_id);
$tagline = get_the_author_meta('tagline', $author_id);
$mobile = get_the_author_meta('mobile', $author_id);
$office = get_the_author_meta('office', $author_id);
$fax = get_the_author_meta('fax', $author_id);
$email = get_the_author_meta('email', $author_id);
$agent_license = get_the_author_meta('agentlicense', $author_id);
$ct_user_url = get_the_author_meta('user_url', $author_id);
$twitterhandle = get_the_author_meta('twitterhandle', $author_id);
$facebookurl = get_the_author_meta('facebookurl', $author_id);
$instagramurl = get_the_author_meta('instagramurl', $author_id);
$linkedinurl = get_the_author_meta('linkedinurl', $author_id);
$gplus = get_the_author_meta('gplus', $author_id);
$youtubeurl = get_the_author_meta('youtubeurl', $author_id);

echo '<!-- FPO First Image -->';
echo '<figure id="first-image-for-print-only">';
    ct_first_image_lrg();
echo '</figure>';

do_action('before_single_listing_lead_media');

if($ct_listing_single_layout != 'listings-two') {

    $listingslides = get_post_meta($post->ID, "_ct_slider", true);

    if(!empty($listingslides)) {
        // Grab Slider custom field images
        $imgattachments = get_post_meta($post->ID, "_ct_slider", true);
    } else {
        // Grab images attached to post via Add Media
        $imgattachments = get_children(
        array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'post_parent' => $post->ID
        ));
    }
    echo '<div class="col span_8 first">';
        echo '<figure id="lead-media"';
                if(count($imgattachments) <= 1) { echo 'class="single-image"'; }
            echo '>';
            if(count($imgattachments) > 1) {
                echo '<div id="slider" class="flexslider">';
                    ct_property_type_icon();
                    ct_listing_actions();
                    echo '<ul class="slides">';
                        if(!empty($listingslides)) {
                            ct_slider_field_images();
                        } else {
                            ct_slider_images();
                        }
                    echo '</ul>';
                echo '</div>';
                echo '<div id="carousel" class="flexslider">';
                    echo '<ul class="slides">';
                        if(!empty($listingslides)) {
                            ct_slider_field_carousel_images();
                        } else {
                            ct_slider_carousel_images();
                        }
                    echo '</ul>';
                echo '</div>';
            } else {
                ct_property_type_icon();
                ct_listing_actions();
                ct_first_image_lrg();
            }
        echo '</figure>';
    echo '</div>';
    ?>

    <div class="col span_4 agent-contact">

        <div id="listing-agent-info" class="col span_12 first">

            <?php
            echo '<figure class="col span_3 first">';
                echo '<a href="' . esc_url(home_url()) . '/?author=' . esc_html($author_id) . '">';
                   if(get_the_author_meta('ct_profile_url', $author_id)) {  
                        echo '<img class="author-img" src="';
                            echo the_author_meta('ct_profile_url', $author_id);
                        echo '" />';
                    } else {
                        echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
                    }
                echo '</a>';
            echo '</figure>';
            ?>

            <div id="agent-info" class="col span_9 marB30">
                <h4 class="<?php if(empty($tagline)) { echo 'marB10'; } else { echo 'marB5'; } ?>"><small id="agent-print-only"><?php _e('Agent', 'contempo'); ?></small><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo esc_html($first_name); ?> <?php echo esc_html($last_name); ?></a></h4>
                <?php if($tagline) { ?>
                    <p class="muted tagline marB10"><i><?php echo esc_html($tagline); ?></i></p>
                <?php } ?>

                <ul class="marB0">
                    <?php if($mobile) { ?>
                        <li><span class="left"><i class="fa fa-phone"></i></span><span class="right"><a href="tel:<?php echo esc_html($mobile); ?>"><?php echo esc_html($mobile); ?></a></span></li>
                    <?php } ?>
                    <?php if($office) { ?>
                        <li><span class="left"><i class="fa fa-building"></i></span><span class="right"><a href="tel:<?php echo esc_html($office); ?>"><?php echo esc_html($office); ?></a></span></li>
                    <?php } ?>
                </ul>
            </div>

        </div>

            <div class="clear"></div>
        
        <?php if($ct_listing_contact_form_7 == 'yes' && $ct_listing_contact_form_7_shortcode != '') { ?>
        
            <?php echo do_shortcode($ct_listing_contact_form_7_shortcode); ?>
        
        <?php } else { ?>
        
                 <form id="listingscontact" class="formular" method="post">
                    <fieldset class="col span_12">

                        <div class="col span_12 first">
                            <select id="ctsubject" name="ctsubject">
                                <option><?php esc_html_e('Tell me more about this listing', 'contempo'); ?></option>
                                <option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
                            </select>
                        </div>
                            <div class="clear"></div>

                        <div class="col span_12 first">
                            <input type="text" name="name" id="name" class="validate[required] text-input" placeholder="<?php esc_html_e('Name', 'contempo'); ?>" />
                        </div>

                        <div class="col span_12 first">
                            <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" placeholder="<?php esc_html_e('Email', 'contempo'); ?>" />
                        </div>

                        <div class="col span_12 first">
                            <input type="text" name="ctphone" id="ctphone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" />
                        </div>

                        <div class="col span_12 first">
                            <textarea class="validate[required,length[2,1000]] text-input" name="message" id="message" rows="5" cols="10"></textarea>
                        </div>

                        <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo esc_attr($email); ?>" />
                        <input type="hidden" id="ctproperty" name="ctproperty" value="<?php the_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
                        <input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />

                        <?php if($ct_enable_zapier_webhooks == 'yes' && $ct_zapier_webhook_url != '' && $ct_zapier_webhook_listing_single_form == 'yes') {
                            echo '<input type="hidden" id="ct_zapier_webhook_url" name="ct_zapier_webhook_url" value="' . $ct_zapier_webhook_url . '" />';
                        } ?>

                        <input type="submit" name="Submit" value="<?php esc_html_e('Request Information', 'contempo'); ?>" id="submit" class="btn right" />  
                            <div class="clear"></div>
                    </fieldset>
                </form>

        <?php } ?>

    </div>
    <!-- //Lead Media -->
<?php } ?>