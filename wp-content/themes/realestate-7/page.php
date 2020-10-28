<?php
/**
 * Page Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

get_header();

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$top_page_margin = get_post_meta($post->ID, "_ct_top_page_margin", true);
$bottom_page_margin = get_post_meta($post->ID, "_ct_bottom_page_margin", true);

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

	<?php do_action('before_page_header'); ?>

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

	<?php do_action('before_page_content'); ?>

	<!-- Container -->
	<div id="page-content" class="container <?php if($top_page_margin != "No") { echo 'marT60'; } ?> <?php if($bottom_page_margin != "No") { echo 'padB60'; } ?>">

		<!-- Page Content -->
		<div class="page-content col span_9">

			<!-- Inner Content -->
			<div class="inner-content">
				<?php

				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'contempo' ),
						'after'  => '</div>',
					)
				);

				?>
			</div>
			<!-- //Inner Content -->

			<!-- Comments -->
	        <?php if ( comments_open() || '0' != get_comments_number() ) :

		        echo '<div class="clear"></div>';

	        	// If comments are open or we have at least one comment, load up the comment template
				comments_template();
			
			endif; ?>
			<!-- End Comments -->
				<div class="clear"></div>
		</div>
		<!-- //Page Content -->

	<?php endwhile; ?>

		<?php do_action('before_page_sidebar'); ?>

		<!-- Sidebar -->
		<?php get_template_part('sidebar'); ?>
		<!-- //Sidebar -->
			<div class="clear"></div>

		<?php do_action('after_page_sidebar'); ?>
	</div>
	<!-- //Container -->

<?php get_footer(); ?>