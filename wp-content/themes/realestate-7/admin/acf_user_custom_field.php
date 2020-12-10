<?php
/**
 * Date: 11/10/20
 * Time: 6:46 PM
 */
if ( ! function_exists( 'summit_acf_user_form_func' ) ) {
	function summit_acf_user_form_func( $atts ) {

		$a = shortcode_atts( array(
			'field_group' => ''
		), $atts );

		$uid = get_current_user_id();

		if ( ! empty ( $a['field_group'] ) && ! empty ( $uid ) ) {
			$options = array(
				'post_id'      => 'user_' . $uid,
				'field_groups' => array( intval( $a['field_group'] ) ),
				'return'       => add_query_arg( 'updated', 'true', get_permalink() )
			);

			ob_start();

			acf_form( $options );
			$form = ob_get_contents();

			ob_end_clean();
		}

		return $form;
	}

	add_shortcode( 'summit_acf_user_form', 'summit_acf_user_form_func' );
}

if ( ! function_exists( 'summit_add_acf_form_head' ) ) {
//adding AFC form head
	function summit_add_acf_form_head() {
		global $post;

		if ( ! empty( $post ) && has_shortcode( $post->post_content, 'summit_acf_user_form' ) ) {
			acf_form_head();
		}
	}

	add_action( 'wp_head', 'summit_add_acf_form_head', 7 );
}