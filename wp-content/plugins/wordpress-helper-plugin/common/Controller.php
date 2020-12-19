<?php
/**
 * Date: 12/2/20
 * Time: 9:05 AM
 */

namespace Elhelper\common;


class Controller extends Base {
	public $view_path = '';
	public static $_instance;

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
	 * @return Controller An instance of the class.
	 */
	public static function instance() {
		if ( is_null( static::$_instance ) ) {
			static::$_instance = new static();
		}

		return static::$_instance;

	}

	public function __construct() {

	}

	public function render( $path ) {
		static::enqueue_scripts_general();

		return $this->view_path . 'views' . DIRECTORY_SEPARATOR . $path;
	}


	public static function enqueue_scripts_general() {

	}

}