<?php
/**
 * Date: 11/19/20
 * Time: 5:24 PM
 */

namespace Elhelper\shortcode;


use Elhelper\inc\HelperShortcode;
use Elhelper\model\BhhsModel;

class ElHelperShortcode {


	public function __construct() {
		add_shortcode( 'wporgtestsets', [ $this, 'wporg_shortcode' ] );
		//enqueue
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_script' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ] );
		add_action( "wp_ajax_search_bhhs_form", [ $this, "search_bhhs_form" ] );
		add_action( "wp_ajax_nopriv_search_bhhs_form", [ $this, "search_bhhs_form" ] );
	}

	public function search_bhhs_form() {
		// chua duoc.
		//		$res['bedroom'] = $this->getBedroomSection();

		$bhhs = new BhhsModel( HelperShortcode::convertAddressToUrl($_GET['address']) );
//		$this->dom        = $this->stringFilter( $this->stringyfyCrawledData() );
		$res['code']      = 200;
		$res['title']     = $bhhs->getTitle();
		$res['threedots'] = $bhhs->get3dot();
		$res['soldprice'] = $bhhs->getSoldPrice();

		$json_encode = json_encode( $res );
		echo $json_encode;

		wp_die();
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

	public function formSearchBhhs() {
		$html = <<<HTML
		<div class="form-search-bhhs-container">
		<form class="bhhs-form" action="#">
		<input id="listing-address" name="address" type="text" placeholder="Enter your home address" required>
		<div class="row btn-summit-bhhs">
		<input class="btn" type="submit" value="Get Free Report">
		</div>
	</form>
	<div class="res-search">
	
</div>
</div>			
HTML;

		return $html;

	}


}