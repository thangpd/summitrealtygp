<?php
/**
 * Template Name: Invoices
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$submit_listing = isset( $ct_options['ct_submit'] ) ? esc_html( $ct_options['ct_submit'] ) : '';
$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$edit = $ct_options['ct_edit'];
$userID = get_current_user_id();

$ct_currency_placement = $ct_options['ct_currency_placement'];

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

    <article class="col <?php if(is_user_logged_in()) { echo 'span_9'; } else { echo 'span_12 first'; } ?> marB60">

        <?php if(!is_user_logged_in()) {

                echo '<div class="inner-content">';
                    echo '<div class="must-be-logged-in">';
                        echo '<h4 class="center marB20">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
                        echo '<p class="center login-register-btn marB0"><a class="btn login-register" href="#">Login/Register</a></p>';
                    echo '</div>';
                echo '</div>';

        } else {

            global $current_user;
            $current_user = wp_get_current_user();
            $current_user_ID = $current_user->ID;
            $today = strtotime(date("Y-m-d"));

            $args = array(
                'post_type'         => 'package_order',
                'author__in'        => $current_user_ID,
                'posts_per_page'    => -1,
            );
            $wp_query = new wp_query($args); 
        
            if (!$wp_query->have_posts()) :

                echo '<div class="col span_12 row nomatches">';
                    echo '<p class="marB0"><strong>' . __('You haven\'t placed any orders yet…', 'contempo') . '</p>';
                echo '</div>';

            elseif($wp_query->have_posts()) : ?>

                <table>
                    <thead>
                        <tr>
                            <th><?php _e('Invoice', 'contempo'); ?></th>
                            <th><?php _e('Package', 'contempo'); ?></th>
                            <th><?php _e('Start', 'contempo'); ?></th>
                            <th><?php _e('Expire', 'contempo'); ?></th>
                            <th><?php _e('Recurring', 'contempo'); ?></th>
                            <th><?php _e('Status', 'contempo'); ?></th>
                            <th><?php _e('Total', 'contempo'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($wp_query->have_posts() ) : $wp_query->the_post();
                            $package_name = get_post_meta($post->ID, 'package_name', true);
                            $package_current_date = strtotime(get_post_meta($post->ID, 'package_current_date', true));
                            $package_expire_date = strtotime(get_post_meta($post->ID, 'package_expire_date', true));
                            $package_recurring = get_post_meta($post->ID, 'pack_recurring', true);
                            $payment_amount = get_post_meta($post->ID, 'payment_amount', true);
                        ?>
                            <tr>
                                <td><?php echo esc_html($post->ID); ?></td>
                                <td><?php echo esc_html($package_name); ?></td>
                                <td><?php if(!empty($package_current_date)) { echo date('n/j/Y', $package_current_date); } else { echo '-'; } ?></td>
                                <td><?php if(!empty($package_expire_date)) { echo date('n/j/Y', $package_expire_date); } else { echo '-'; } ?></td>
                                <td><?php if($package_recurring == 'Yes') { echo '<span class="package-recurring">' . __('Yes', 'contempo') . '</span>'; } else { echo '<span class="package-not-recurring">' . __('No', 'contempo') . '</span>'; } ?></td>
                                <td><?php if($today >= strtotime(get_post_meta($post->ID, 'package_expire_date', true))) { echo '<span class="package-expired">' . __('Expired', 'contempo') . '</span>'; } else { echo '-'; } ?></td>
                                <td>
                                <?php
                                if(is_numeric($payment_amount)) {
                                    if($ct_currency_placement == 'after') { 
                                        echo esc_html($payment_amount); ct_currency();
                                    } else {
                                        ct_currency(); echo esc_html($payment_amount); 
                                    }
                                } else { 
                                    _e('-', 'contempo');
                                } ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            <?php endif; wp_reset_postdata(); ?>
            
        <?php } ?>

    </article>
	
		<div class="clear"></div>

</div>

<?php get_footer(); ?>