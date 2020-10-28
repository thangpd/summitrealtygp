<?php
/**
 * Template Name: Contact
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

$ct_contact_map = isset( $ct_options['ct_contact_map'] ) ? esc_attr( $ct_options['ct_contact_map'] ) : ''; 
$ct_contact_multiple_locations = isset( $ct_options['ct_contact_multiple_locations'] ) ? esc_attr( $ct_options['ct_contact_multiple_locations'] ) : ''; 
$ct_subject = isset( $ct_options['ct_contact_subject'] ) ? esc_attr( $ct_options['ct_contact_subject'] ) : ''; 
$ct_email = isset( $ct_options['ct_contact_email'] ) ? esc_attr( $ct_options['ct_contact_email'] ) : ''; 

$ct_enable_zapier_webhooks = isset( $ct_options['ct_enable_zapier_webhooks'] ) ? $ct_options['ct_enable_zapier_webhooks'] : '';
$ct_zapier_webhook_url = isset( $ct_options['ct_zapier_webhook_url'] ) ? $ct_options['ct_zapier_webhook_url'] : '';
$ct_zapier_webhook_contact_page_form = isset( $ct_options['ct_zapier_webhook_contact_page_form'] ) ? $ct_options['ct_zapier_webhook_contact_page_form'] : '';

get_header(); ?>

<?php if($inside_page_title == "Yes") {
	echo '<header id="title-header" class="marB0">';
		echo '<div class="container">';
			echo '<div class="left">';
				echo '<h5 class="marT0 marB0">';
					the_title();
				echo '</h5>';
			echo '</div>';
			echo ct_breadcrumbs();
			echo '<div class="clear"></div>';
		echo '</div>';
	echo '</header>';
} ?>

<?php 
	if($ct_contact_multiple_locations == 'on') {
		ct_search_results_map_navigation();
		ct_multi_contact_us_map();
	} elseif($ct_contact_map == 'yes') {
		ct_contact_us_map();
	}
?>

	<!-- Container -->
	<div id="page-content" class="container marT60 padB60" <?php if($ct_options['ct_contact_map'] == "no") { ?>style="padding-top: 120px;"<?php } ?>>

		<!-- Page Content -->
   		<div class="content col span_9">
    
            <!-- Inner Content -->
            <div class="col span_11 first">
				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php the_content(); ?>
				
				<?php endwhile; ?>

				<!-- Contact Form -->
				<form id="contactform" class="formular" method="post">

	                <fieldset>
		                <div class="col span_4">
		                    <input type="text" name="name" id="name" class="validate[required] text-input" placeholder="<?php esc_html_e('Name*', 'contempo'); ?>" />
	                    </div>
	                    
	                    <div class="col span_4">
		                    <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" placeholder="<?php esc_html_e('Email*', 'contempo'); ?>" />
	                    </div>

	                    <div class="col span_4">
		                    <input type="text" name="phone" id="phone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" />                             
	                    </div>

	                    <input type="text" name="subject" id="subject" class="validate[required] text-input" placeholder="<?php esc_html_e('Subject*', 'contempo'); ?>" />
	                    
	                    <textarea class="validate[required,length[2,2000]] text-input" name="message" id="message" rows="12" cols="10" placeholder="<?php esc_html_e('Message', 'contempo'); ?>"></textarea>

	                    <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo esc_attr($ct_email); ?>" />

	                    <?php if($ct_enable_zapier_webhooks == 'yes' && $ct_zapier_webhook_url != '' && $ct_zapier_webhook_contact_page_form == 'yes') {
                            echo '<input type="hidden" id="ct_zapier_webhook_url" name="ct_zapier_webhook_url" value="' . $ct_zapier_webhook_url . '" />';
                        } ?>
	                    
	                        <div class="clear"></div>
	                    
	                    <input type="submit" name="<?php esc_html_e('Submit','contempo'); ?>" value="<?php esc_html_e('Submit','contempo'); ?>" id="submit" class="btn" />
							<div class="clear"></div>
	                </fieldset>
	            </form>
	            <!-- //Contact Form -->

	        </div>
	        <!-- //Inner Content -->

        </div>
        <!-- //Page Content -->

        <!-- Sidebar -->
        <div id="sidebar" class="col span_3">
            <div id="sidebar-inner" class="contact-details">
	            <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Right Sidebar Contact Page') ) :else: endif; ?>
            </div>
        </div>
        <!-- //Sidebar -->

			<div class="clear"></div>
	</div>
	<!-- //Container -->

<?php get_footer(); ?>