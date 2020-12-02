<?php
/**
 * Date: 12/2/20
 * Time: 9:00 AM
 */

namespace Elhelper\modules\reglogCustomer\controller;


use Elhelper\common\Controller;

class RegLogController extends Controller {
	public static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return RegLogController An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	public function __construct() {
		add_action( "wp_ajax_action_register_ajax", [ $this, "actionRegisterAjax" ] );
		add_action( "wp_ajax_nopriv_action_register_ajax", [ $this, "actionRegisterAjax" ] );
	}

	public function actionRegisterAjax() {


		wp_die();
	}


}