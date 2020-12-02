<?php
/**
 * Date: 12/2/20
 * Time: 9:00 AM
 */

namespace Elhelper\modules\reglogCustomer\controller;


use Elhelper\common\Controller;

class RegLogController extends Controller {
	private static $_instance = null;
	private $view_path = '';

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
		add_action( "wp_ajax_action_active_ajax", [ $this, "actionActiveAjax" ] );
		add_action( "wp_ajax_nopriv_action_active_ajax", [ $this, "actionActiveAjax" ] );
		$this->view_path = plugin_dir_path( __DIR__ );
	}

	public function actionActiveAjax() {
		$res            = [
			'code' => 200,
			'data' => '',
			'msg'  => 'Active Success',
		];
		$user_meta_data = $_POST;
		if ( ! isset( $_GET['active_key'] ) ) {
			$transient_key = $_COOKIE['summit-signup'];
		} else {
			$transient_key = $_GET['active_key'];
		}
		$user_data = get_transient( $transient_key );
		$userdata  = array(
			'ID'                   => 0,    //(int) User ID. If supplied, the user will be updated.
			'user_pass'            => $user_data['pass'],   //(string) The plain-text user password.
			'user_login'           => $user_data['Username'],   //(string) The user's login username.
			'user_email'           => $user_data['user_email'],   //(string) The user email address.
			'show_admin_bar_front' => false,   //(string) The user email address.
		);
		$userId    = wp_insert_user( $userdata );
		if ( ! is_wp_error( $userId ) ) {
			foreach ( $user_meta_data as $key => $val ) {
				add_user_meta( $userId, $key, $val );
			}
//			wp_update_user( array( 'ID' => $userId, 'user_email' => $data['email'] ) );
			wp_set_auth_cookie( $userId, true );
			$siteUrl     = site_url();
			$res['data'] = <<<HTML
			<div class="almost-there" style="color:white; padding:20px;">
			<p>Active Success!</p>
			<p><a href="{$siteUrl}">Click here to return to home page</a></p>
			</div>
HTML;
		} else {
			$res = ( array(
				'code'      => 500,
				'msg'       => 'Cant create user',
				'data'      => json_encode( $userId->get_error_code() ),
				'user-data' => json_encode( $user_data ),
			) );
		}
		echo json_encode( $res );
		wp_die();
	}

	public function actionRegisterAjax() {
		$res       = [
			'code' => 200,
			'data' => '',
			'msg'  => 'Register Success',
		];
		$user_data = $_POST;


		//sendmail registered
		$test            = 'test';
		$transient_key   = md5( $_POST['Username'] . $_POST['email'] );
		$site_active_url = site_url() . '/summit-active' . '?active_key=' . $transient_key;
		$email_template  = $this->getViewPathEmailTemplate();
		$message         = require $email_template;
		if ( $this->sendMailRegister( $_POST['email'], 'Please confirm your email', $message ) ) {

			set_transient( $transient_key, $_POST, 0 );
			set_transient( $_POST['email'], $transient_key, 0 );
			//https://stackoverflow.com/questions/22432616/why-is-the-browser-not-setting-cookies-after-an-ajax-request-returns
			if ( ! isset( $_COOKIE['summit-signup'] ) ) {
				setcookie( 'summit-signup', $transient_key, time() + ( 365 * 24 * 60 * 60 ), '/' );
			} else {
				$_COOKIE['summit-signup'] = $transient_key;
			}
//			$transient = get_transient( md5( $_POST['Username'] . $_POST['password'] ) );
			$activation_path = $this->getViewPathActivationTemplate();
			ob_start();
			require $activation_path;
			$almost      = ob_get_clean();
			$res['data'] = $almost;
		} else {
			$res['code'] = 500;
			$res['msg']  = "Can't send mail";
		}
		echo json_encode( $res );
		wp_die();
	}

	public function sendMailRegister( $customerEmail, $subject, $message ) {
		$to      = "$customerEmail";
		$subject = "$subject";
		$headers = "From: Summit Realty Group, Inc <admin@summitrealtygp.com>" . "\r\n" .
		           "Reply-To: admin@summitrealtygp.com" . "\r\n" .
		           "CC: admin@summitrealtygp.com" . "\r\n" .
		           "X-Mailer: PHP/" . phpversion();
		$res     = wp_mail( $to, $subject, $message, $headers );
		//dev
		$res = true;

		return $res;
	}

	public function getViewPathRegister() {
		return $this->view_path . 'views' . DIRECTORY_SEPARATOR . 'register-template.php';
	}

	public function getViewPathLogin() {
		return $this->view_path . 'views' . DIRECTORY_SEPARATOR . 'login-template.php';
	}

	public function getViewPathEmailTemplate() {
		return $this->view_path . 'views' . DIRECTORY_SEPARATOR . 'email-template.php';
	}

	public function getViewPathActivationTemplate() {
		return $this->view_path . 'views' . DIRECTORY_SEPARATOR . 'activation-template.php';
	}

	public function getViewPathActivationPage() {
		return $this->view_path . 'views' . DIRECTORY_SEPARATOR . 'activation-page.php';
	}

	public function getViewPathActivePage() {
		return $this->view_path . 'views' . DIRECTORY_SEPARATOR . 'active-page.php';
	}
}