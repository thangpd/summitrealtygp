<?php
/**
 * Template Name: Open Houses
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options; 

$count = 0; 
$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$top_page_margin = get_post_meta($post->ID, "_ct_top_page_margin", true);
$bottom_page_margin = get_post_meta($post->ID, "_ct_bottom_page_margin", true);

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

if($inside_page_title == "Yes") { 
    // Custom Page Header Background Image
    if(get_post_meta($post->ID, '_ct_page_header_bg_image', true) != '') {
        echo'<style type="text/css">';
        echo '#single-header { background: url(';
            echo get_post_meta($post->ID, '_ct_page_header_bg_image', true);
        echo ') no-repeat center center; background-size: cover;}';
        //echo '.listing { margin: 0 1% 1% 1%;}';
        echo '.propinfo li { list-style: none;}';
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

<div id="page-content" class="container <?php if($top_page_margin != "No") { echo 'marT60'; } ?> <?php if($bottom_page_margin != "No") { echo 'padB60'; } ?>">

    <article class="col span_12 first marB60">

        <div id="listings-results">

            <?php the_content(); ?>

            <?php endwhile; endif; wp_reset_postdata(); ?>

            <?php

                $args = array(
                    'post_type'         => 'listings',
                    'posts_per_page'    => -1,
                );
                $wp_query = new wp_query( $args ); 

                echo '<ul class="open-listing">';
                
                    if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
                        
                        $ct_open_house_entries = get_post_meta( get_the_ID(), '_ct_open_house', true );
    				
                        foreach ( (array) $ct_open_house_entries as $key => $entry ) {

                            $ct_open_house_date = '';

                            if ( isset( $entry['_ct_open_house_date'] ) )
                                $ct_open_house_date = esc_html( $entry['_ct_open_house_date'] );				
                        } 

                        if($ct_open_house_entries != '' && $ct_open_house_date != '') {
                          
                            $ct_todays_date = date("mdY");

                            $ct_open_house_date = $ct_open_house_start_time = $ct_open_house_end_time = $open_house_rsvp = '';

                            if ( isset( $entry['_ct_open_house_date'] ) )
                                $ct_open_house_date = esc_html( $entry['_ct_open_house_date'] );
                                $ct_open_house_date_formatted = strftime('%m%d%Y', $ct_open_house_date);
                                $ct_open_house_date_formatted_year = strftime('%Y', $ct_open_house_date);

                            if ( isset( $entry['_ct_open_house_start_time'] ) )
                                $ct_open_house_start_time = esc_html( $entry['_ct_open_house_start_time'] );

                            if ( isset( $entry['_ct_open_house_end_time'] ) )
                                $ct_open_house_end_time = esc_html( $entry['_ct_open_house_end_time'] );

                            if ( isset( $entry['_ct_open_house_rsvp'] ) ) {
                                $ct_open_house_rsvp = $entry['_ct_open_house_rsvp'];
                            }

                            //echo $ct_todays_date;

                            if($ct_open_house_date_formatted_year != '2018' && $ct_open_house_date_formatted > $ct_todays_date) { ?>
        						
                                <li class="listing col span_4 standard">

                                        <?php if(has_post_thumbnail()) { ?>
                                        <figure>
                                            <?php ct_status_featured(); ?>
                                            <?php ct_status(); ?>
                                            <?php ct_property_type_icon(); ?>
                                            <?php ct_listing_actions(); ?>
                                            <?php ct_first_image_linked(); ?>
                                        </figure>
                                        <?php } ?>
                                        <div class="grid-listing-info">
                                            <header>
                                                <h5 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
                                                <p class="location muted marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?></p>
                                            </header>
                                            <p class="price marB0"><?php ct_listing_price(); ?></p>
                                            <div class="propinfo">
                                                <p><?php echo ct_excerpt(); ?></p>
                                                <ul class="marB0 marL0">
                                                    <?php ct_propinfo(); ?>
                                                </ul>
                                            </div>
                                            <?php ct_upcoming_open_house(); ?>
                                            <?php ct_listing_creation_date(); ?>
                                            <?php ct_brokered_by(); ?>
                                        </div>
                            
                                </li>

                            <?php

                                $count++;

                if($count % 3 == 0) {
                    echo '<div class="clear"></div>';
                }

                            }

                        }
                
                endwhile; endif; wp_reset_postdata();

            echo '</ul>';
            echo '<!-- //Open House -->';

            ?>

                <div class="clear"></div>

        </div>

    </article>
    
        <div class="clear"></div>

</div>

<?php get_footer(); ?>