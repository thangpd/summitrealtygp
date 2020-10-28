<?php
/**
 * Template Name: IDX Full Width
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
	<div id="page-content" class="container padB60">

		<!-- Page Content -->
		<div class="page-content col span_12 first marB60">

			<!-- Inner Content -->
			<div class="inner-content">
				<?php the_content(); ?>
			</div>
			<!-- //Inner Content -->
			
		</div>
		<!-- //Page Content -->

	<?php endwhile; ?>

	</div>
	<!-- //Container -->

<?php get_footer(); ?>