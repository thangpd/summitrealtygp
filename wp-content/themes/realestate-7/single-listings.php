<?php
/**
 * Single Listings Template
 * Template Post Type: listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options;

$ct_single_listing_main_layout = isset( $ct_options['ct_single_listing_main_layout']['enabled'] ) ? $ct_options['ct_single_listing_main_layout']['enabled'] : '';

$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
$ct_listing_single_content_layout = isset( $ct_options['ct_listing_single_content_layout'] ) ? esc_html( $ct_options['ct_listing_single_content_layout'] ) : '';
$ct_listing_tools = isset( $ct_options['ct_listing_tools'] ) ? esc_html( $ct_options['ct_listing_tools'] ) : '';
$ct_listings_login_register = isset( $ct_options['ct_listings_login_register'] ) ? esc_html( $ct_options['ct_listings_login_register'] ) : '';
$ct_single_listing_tools_layout = isset( $ct_options['ct_single_listing_tools_layout']['enabled'] ) ? $ct_options['ct_single_listing_tools_layout']['enabled'] : '';

global $post;
$author_id = $post->post_author;
$agent_mobile = get_the_author_meta('mobile', $author_id);

get_header();
 
if (!empty($_GET['search-listings'])) {
    get_template_part('search-listings');
    return;
}

$cat = get_the_category();

do_action('before_single_listing_header');

// Header
echo '<header id="title-header"';
        if($ct_listing_single_layout == 'listings-two') { echo 'class="marB0"'; }
    echo '>';
    echo '<div class="container">';
        echo '<div class="left">';
            echo '<h5 class="marT0 marB0">';
                esc_html_e('Listings', 'contempo');
            echo '</h5>';
        echo '</div>';
        echo '<div class="breadcrumb breadcrumbs ct-breadcrumbs right muted">';
            echo '<a id="bread-home" href="'. home_url() . '" title="';
                echo bloginfo('name');
            echo '" rel="home" class="trail-begin">' . __('Home', 'contempo') . '</a>';
                echo '<span class="sep"><i class="muted fa fa-angle-right"></i></span>';
                    echo '<span class="trail-end">';
                        ct_listing_title();
                    echo '</span>';
            echo '</div>';
        echo '<div class="clear"></div>';
    echo '</div>';
echo '</header>';

// Listing Tools
if($ct_listing_tools == 'yes') { ?>

    <?php 
    echo '<!-- Listing Tools -->';
    echo '<div id="tools">';
        echo '<div id="call-email">';
            echo '<a class="btn marR5" href="tel:' . $agent_mobile . '">' . __('Call', 'contempo') . '</a>';
            echo '<a class="btn" href="#listing-contact">' . __('Email', 'contempo') . '</a>';
        echo '</div>';
         echo '<ul class="right social marB0">';

            if($ct_single_listing_tools_layout) {
                    
                foreach($ct_single_listing_tools_layout as $key => $value) {

                    switch($key) {

                        // Twitter
                        case 'listing_twitter' : ?>    

                             <li class="twitter"><a href="javascript:void(0);" onclick="popup('https://twitter.com/share?text=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&url=<?php the_permalink(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
                        
                        <?php break; ?>

                        <?php case 'listing_facebook' : ?>    

                             <li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
                        
                        <?php break; ?>

                        <?php case 'listing_linkedin' : ?>    

                             <li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
                        
                        <?php break; ?>

                        <?php case 'listing_whatsapp' : ?>    

                             <li class="whatsapp"><a href="whatsapp://send?text=<?php the_permalink() ?> - <?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>"><i class="fa fa-whatsapp"></i></a></li>
                        
                        <?php break; ?>

                        <?php case 'listing_print' : ?>    

                             <li class="print"><a class="print" href="javascript:window.print()"><i class="fa fa-print"></i></a></li>
                        
                        <?php break;

                    }
                }

            } else {

                /*-----------------------------------------------------------------------------------*/
                /* For Legacy Users */
                /*-----------------------------------------------------------------------------------*/

            ?>
           
                <li class="twitter"><a href="javascript:void(0);" onclick="popup('https://twitter.com/share?text=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&url=<?php the_permalink(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
                <li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
                <li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
                <li class="print"><a class="print" href="javascript:window.print()"><i class="fa fa-print"></i></a></li>
                <span id="tools-toggle"><a href="#"><span id="text-toggle"><?php esc_html_e('Close', 'contempo'); ?></span></a></span>
            
            <?php }
                   
        echo '</ul>';
    echo '</div>';
    echo '<!-- //Listing Tools -->';

} 

do_action('before_single_listing_content'); ?>

<!-- FPO Header --> 
<?php 
    echo '<!-- FPO Site name -->';
    echo '<h4 id="sitename-for-print-only">';
        bloginfo('name');
    echo '</h4>';
?>
<!-- //FPO Header --> 

<!-- Lead Carousel -->
<?php

if($ct_listing_single_layout == 'listings-two') {

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
    ?>
    <figure id="lead-carousel" class="<?php if(count($imgattachments) <= 1) { echo 'single-image'; } else { echo 'multi-image'; } ?> <?php if(get_post_meta($post->ID, "source", true) == 'idx-api') { echo 'idx-listing'; } ?>">
        <?php
        if(count($imgattachments) > 1) { ?>
            <div id="lrg-carousel" class="owl-carousel">
                <?php if(!empty($listingslides)) {
                    ct_slider_field_images();
                } else {
                    ct_slider_images();
                } ?>
            </div>
        <?php } else { ?>
            <?php ct_property_type_icon(); ?>
            <?php ct_listing_actions(); ?>
            <?php ct_first_image_lrg(); ?>
        <?php } ?>
    </figure>
    <!-- //Lead Carousel -->
<?php } ?>

<?php if($ct_listing_single_layout == 'listings-three') { ?>
    
    <div id="single-listing-lead" class="container marB40">
        
        <div id="listings-three-header" class="col span_12 first">
            <?php get_template_part('includes/single-listing-header'); ?>
        </div>

        <div id="listings-three-slider" class="col span_12 first">
            <?php get_template_part('includes/single-listing-lead-media'); ?>
        </div>
            <div class="clear"></div>

    </div>

<?php } ?>

<?php if($ct_listing_single_layout == 'listings-four') { ?>
    
    <div id="single-listing-lead" class="container marB40">
        
        <div id="listings-three-header" class="col span_12 first">
            <?php get_template_part('includes/single-listing-header'); ?>
        </div>

        <div id="listings-four-slider" class="col span_12 first">
            <?php get_template_part('includes/single-listing-lead-media-with-contact'); ?>
        </div>
            <div class="clear"></div>

    </div>

<?php } ?>

<?php

echo '<div id="single-listing-content" class="container">';

        if ( have_posts() ) : while ( have_posts() ) : the_post(); ct_set_listing_views(get_the_ID()); ?>

        <article class="col <?php if($ct_listing_single_content_layout == 'full-width') { echo 'span_12'; } else { echo 'span_9'; } ?> marB60">

        <?php if(!is_user_logged_in() && $ct_listings_login_register == 'yes') {
        
                echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
        
        } else {

            if($ct_single_listing_main_layout) {
        
                    foreach($ct_single_listing_main_layout as $key => $value) {
                    
                        switch($key) {

                            // Header
                            case 'listing_header' :    

                                if($ct_listing_single_layout != 'listings-three' && $ct_listing_single_layout != 'listings-four') {
                                    get_template_part('includes/single-listing-header');
                                }
                            
                            break;

                            // Price
                            case 'listing_price' :    

                                if($ct_listing_single_layout != 'listings-three' && $ct_listing_single_layout != 'listings-four') {
                                    get_template_part('includes/single-listing-price');
                                }
                            
                            break;

                            // Estimated Payment
                            case 'listing_est_payment' :    

                                if($ct_listing_single_layout != 'listings-three' && $ct_listing_single_layout != 'listings-four') {
                                    get_template_part('includes/single-listing-estimated-payment');
                                }
                            
                            break;

                            // Prop Info
                            case 'listing_prop_info' :

                                get_template_part('includes/single-listing-propinfo');
                                    echo '<div class="clear"></div>';
                                
                            break;

                            // Lead Media
                            case 'listing_lead_media' :

                                if($ct_listing_single_layout != 'listings-three' && $ct_listing_single_layout != 'listings-four') {
                                    get_template_part('includes/single-listing-lead-media');
                                }
                                
                            break;

                            // Page Builder Four
                            case 'listing_nav' :

                               get_template_part('includes/single-listing-sub-navigation');
                                
                            break;

                            // Content
                            case 'listing_content' :

                               get_template_part('includes/single-listing-content');
                                
                            break;

                            // Contact
                            case 'listing_contact' :

                               get_template_part('includes/single-listing-contact');
                                
                            break;

                            // Creation Date
                            case 'listing_creation_date':

                                ct_listing_creation_date();
                        
                            break;

                            // Brokerage
                            case 'listing_brokerage' :

                                get_template_part('includes/single-listing-brokerage');
                                
                            break;

                            // Sub Listings
                            case 'listing_sub_listings' :

                                get_template_part('includes/single-listing-sub-listings');
                                
                            break;
                        
                        }
                    }
                
                } else {

                    /*-----------------------------------------------------------------------------------*/
                    /* For Legacy Users */
                    /*-----------------------------------------------------------------------------------*/

                    get_template_part('includes/single-listing-header');

                    get_template_part('includes/single-listing-price');

                    get_template_part('includes/single-listing-propinfo');

                    get_template_part('includes/single-listing-lead-media');

                    get_template_part('includes/single-listing-sub-navigation');

                    get_template_part('includes/single-listing-content');

                    get_template_part('includes/single-listing-contact');

                    get_template_part('includes/single-listing-brokerage');

                    get_template_part('includes/single-listing-sub-listings');

                }

            } endwhile; endif; ?>
            
                    <div class="clear"></div>

            <?php do_action('after_single_listing_content'); ?>

        </article>

        <?php do_action('before_single_listing_sidebar'); ?>
        
        <?php if($ct_listing_single_content_layout != 'full-width') { ?>
            <div id="sidebar" class="col span_3">
                <div id="sidebar-inner">
                    <?php if (is_active_sidebar('listings-single-right')) {
                        dynamic_sidebar('listings-single-right');
                    } ?>
                        <div class="clear"></div>
                </div>
            </div>
        <?php } ?>

        <?php do_action('after_single_listing_sidebar'); ?>

            <div class="clear"></div>

</div>

<?php get_footer(); ?>