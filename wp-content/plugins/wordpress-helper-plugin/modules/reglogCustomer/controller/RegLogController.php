<?php
/**
 * Date: 12/2/20
 * Time: 9:00 AM
 */

namespace Elhelper\modules\reglogCustomer\controller;


use Elhelper\common\Controller;

class RegLogController extends Controller
{


    public function __construct()
    {
        parent::__construct();
        add_action("wp_ajax_action_register_ajax", [$this, "actionRegisterAjax"]);
        add_action("wp_ajax_nopriv_action_register_ajax", [$this, "actionRegisterAjax"]);
        add_action("wp_ajax_action_active_ajax", [$this, "actionActiveAjax"]);
        add_action("wp_ajax_nopriv_action_active_ajax", [$this, "actionActiveAjax"]);
	    add_action("wp_ajax_action_login_ajax", [$this, "actionLoginAjax"]);
	    add_action("wp_ajax_nopriv_action_login_ajax", [$this, "actionLoginAjax"]);
        $this->view_path = plugin_dir_path(__DIR__);
    }

	public function actionLoginAjax()
	{
		if (!$_POST) die();

		if (!$_POST['login_form_field']) die();

		if (!wp_verify_nonce($_POST['login_form_field'], 'login_form_action')) die();

		$user = get_user_by('login', $_POST['Username']);
		if ($user && wp_check_password($_POST['password'], $user->data->user_pass, $user->ID) && wp_authenticate($_POST['Username'], $_POST['password'])) {
			// Using wp_xmlrpc_server
			// $wp_xmlrpc_server = new \wp_xmlrpc_server();
			// $user = $wp_xmlrpc_server->login($_POST['Username'], $_POST['password']);
			// Create a credentials
			$creds = [
				'user_login' => $_POST['Username'],
				'user_password' => $_POST['password'],
				'remember' => true,
			];

			$user = wp_signon($creds, false);

			wp_set_current_user($user->ID);
			wp_set_auth_cookie($user->ID, true, false);

			do_action('wp_login', $_POST['Username']);

			$res = [
				'code' => 200,
				'data' => $user,
				'msg' => 'Login successfully'
			];
		} else {
			$res = [
				'code' => 500,
				'data' => $user,
				'msg'  => 'User or password is incorrect',
			];
		}

		echo json_encode($res);
		die();
	}

    public function actionActiveAjax()
    {
        $res = [
            'code' => 200,
            'data' => '',
            'msg' => 'Active Success',
        ];
        $user_meta_data = $_POST;
        if (!isset($_GET['active_key'])) {
            $transient_key = $_COOKIE['summit-signup'];
        } else {
            $transient_key = $_GET['active_key'];
        }
        $user_data = get_transient($transient_key);
        $userdata = array(
            'ID' => 0,    //(int) User ID. If supplied, the user will be updated.
            'user_pass' => $user_data['pass'],   //(string) The plain-text user password.
            'user_login' => $user_data['Username'],   //(string) The user's login username.
            'user_email' => $user_data['user_email'],   //(string) The user email address.
            'show_admin_bar_front' => false,   //(string) The user email address.
        );
        $userId = wp_insert_user($userdata);
        if (!is_wp_error($userId)) {
            foreach ($user_meta_data as $key => $val) {
                update_user_meta($userId, $key, $val);
            }
            wp_update_user(array('ID' => $userId, 'user_email' => $user_data['email']));
            wp_update_user(array('ID' => $userId, 'user_pass' => $user_data['password']));
            wp_set_auth_cookie($userId, true);
            $this->deleteTransientCookie();
            $siteUrl = site_url();
            $res['data'] = <<<HTML
			<div class="almost-there" style="color:white; padding:20px;">
			<p>Active Success!</p>
			<p><a href="{$siteUrl}">Click here to return to home page</a></p>
			</div>
HTML;
            $u = new \WP_User($userId);
            $u->add_role('subscriber ');
        } else {
            $res = (array(
                'code' => 500,
                'msg' => 'Cant create user',
                'data' => json_encode($userId->get_error_code()),
                'user-data' => json_encode($user_data),
            ));
        }
        echo json_encode($res);
        wp_die();
    }

    public function actionRegisterAjax()
    {
        $res = [
            'code' => 200,
            'data' => '',
            'msg' => 'Register Success',
        ];
        //this for email tempalte. Do not delete.
        $user_data = $_POST;
        if (username_exists($user_data['Username'])) {
            echo json_encode(['code' => 404, 'data' => '', 'msg' => 'User name already exists']);
            wp_die();
        }
        if (email_exists($user_data['email'])) {
            echo json_encode(['code' => 404, 'data' => '', 'msg' => 'Email already exists']);
            wp_die();
        }

        //sendmail registered
        $transient_key = md5($_POST['Username'] . $_POST['email']) . time();
        $site_active_url = site_url() . '/summit-active' . '?active_key=' . $transient_key;
        $email_template = $this->getViewPathEmailTemplate();
        $message = require $email_template;
        if ($this->sendMailRegister($_POST['email'], 'Please confirm your email', $message)) {

            set_transient($transient_key, $_POST, 0);
            set_transient($_POST['email'], $transient_key, 0);
            //https://stackoverflow.com/questions/22432616/why-is-the-browser-not-setting-cookies-after-an-ajax-request-returns
            if (!isset($_COOKIE['summit-signup'])) {
                setcookie('summit-signup', $transient_key, time() + (365 * 24 * 60 * 60), '/');
            } else {
                $_COOKIE['summit-signup'] = $transient_key;
            }
//			$transient = get_transient( md5( $_POST['Username'] . $_POST['password'] ) );
            $activation_path = $this->getViewPathActivationTemplate();
            ob_start();
            require $activation_path;
            $almost = ob_get_clean();
            $res['data'] = $almost;
        } else {
            $res['code'] = 500;
            $res['msg'] = "Can't send mail";
        }
        echo json_encode($res);
        wp_die();
    }

    public function sendMailRegister($customerEmail, $subject, $message)
    {
        $to = "$customerEmail";
        $subject = "$subject";
        $headers = "From: Summit Realty Group, Inc <admin@summitrealtygp.com>" . "\r\n" .
            "Reply-To: admin@summitrealtygp.com" . "\r\n" .
            "CC: admin@summitrealtygp.com" . "\r\n" .
            "X-Mailer: PHP/" . phpversion();
        $res = wp_mail($to, $subject, $message, $headers);
        //dev
        $res = true;

        return $res;
    }



    public function getViewPathRegister()
    {
        $render = $this->render('register-template.php');

        return $render;
    }

    public function getViewPathLogin()
    {
        return $this->render('login-template.php');
    }

    public function getViewPathEmailTemplate()
    {
        return $this->render('email-template.php');
    }

    public function getViewPathActivationTemplate()
    {
        return $this->render('activation-template.php');
    }

    public function getViewPathActivationPage()
    {
        return $this->render('activation-page.php');
    }

    public function getViewPathActivePage()
    {
        return $this->render('active-page.php');
    }

    public static function enqueue_scripts_general()
    {
        parent::enqueue_scripts_general(); // TODO: Change the autogenerated stub
        wp_enqueue_script('register-template-js', plugins_url('/assets/reglogcustomer.js', __DIR__), [
            'bootstrap',
            'jquery-md5-js',
            'jquery-validate'
        ]);
        wp_enqueue_style('register-template-css', plugins_url('/assets/reglogcustomer.css', __DIR__), ['bootstrap']);
    }

    public function deleteTransientCookie()
    {
        delete_transient($_COOKIE["summit-signup"]);
        setcookie("summit-signup", "", time() - 3600);
    }

}