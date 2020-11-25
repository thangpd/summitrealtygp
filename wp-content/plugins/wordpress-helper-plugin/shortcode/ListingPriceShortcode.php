<?php
/**
 * Date: 11/19/20
 * Time: 5:24 PM
 */

namespace Elhelper\shortcode;


class ElHelperShortcode {
	public $dom = '';

	public function __construct() {
		add_shortcode( 'wporgtestsets', [ $this, 'wporg_shortcode' ] );
		//enqueue
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_script' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ] );
	}


	/**
	 * @param $hook
	 */
	function enqueue_script( $hook ) {
		wp_enqueue_script( 'elhelper-shortcode-js', plugins_url( '/assets/elhelper/js/elhelper-plugin.js', __FILE__ ), array( 'jquery' ) );
	}

	/**
	 * @param $hook
	 */
	function enqueue_style( $hook ) {
		wp_enqueue_style( 'elhelper-shortcode-css', plugins_url( '/assets/elhelper/css/elhelper-plugin.css', __FILE__ ) );
	}

	function wporg_shortcode( $atts = [], $content = null ) {
		if ( empty( $res ) ) {
			$res = 'Not found';
		}
		$res = $this->formSearchBhhs();

		return $res;
	}


}