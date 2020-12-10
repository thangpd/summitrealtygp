<?php
/**
 * Template Name: Mortgage Caculator
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
acf_form_head();
global $ct_options, $current_user, $wp_roles;

$ct_enable_front_end_account_delete = isset( $ct_options['ct_enable_front_end_account_delete'] ) ? esc_attr( $ct_options['ct_enable_front_end_account_delete'] ) : '';

$inside_page_title = get_post_meta( $post->ID, "_ct_inner_page_title", true );

get_header();

if ( ! function_exists( 'wp_handle_upload' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

while ( have_posts() ) : the_post();

	if ( $inside_page_title == "Yes" ) {
		// Custom Page Header Background Image
		if ( get_post_meta( $post->ID, '_ct_page_header_bg_image', true ) != '' ) {
			echo '<style type="text/css">';
			echo '#single-header { background: url(';
			echo get_post_meta( $post->ID, '_ct_page_header_bg_image', true );
			echo ') no-repeat center center; background-size: cover;}';
			echo '</style>';
		} ?>

        <!-- Single Header -->
        <div id="single-header">
            <div class="dark-overlay">
                <div class="container">
                    <h1 class="marT0 marB0"><?php the_title(); ?></h1>
					<?php if ( get_post_meta( $post->ID, '_ct_page_sub_title', true ) != '' ) { ?>
                        <h2 class="marT0 marB0"><?php echo get_post_meta( $post->ID, "_ct_page_sub_title", true ); ?></h2>
					<?php } ?>
                </div>
            </div>
        </div>
        <!-- //Single Header -->
	<?php } ?>

	<?php echo '<div id="page-content" class="container">'; ?>

	<?php if ( is_user_logged_in() ) {
		get_template_part( '/includes/user-sidebar' );
	} ?>

    <article class="col <?php if ( is_user_logged_in() ) {
		echo 'span_9';
	} else {
		echo 'span_12 first';
	} ?> marB60">

    <div class="inner-content">

	<?php if ( ! is_user_logged_in() ) {
		echo '<div class="must-be-logged-in">';
		echo '<h4 class="center marB20">' . __( 'You must be logged in to view this page.', 'contempo' ) . '</h4>';
		echo '<p class="center login-register-btn marB0"><a class="btn login-register" href="#">Login/Register</a></p>';
		echo '</div>';
	} else {
		the_content();
	}
endwhile; ?>

    <div class="clear"></div>


    </div>

    </article>

<?php
echo '<div class="clear"></div>';
echo '</div>';

get_footer(); ?>