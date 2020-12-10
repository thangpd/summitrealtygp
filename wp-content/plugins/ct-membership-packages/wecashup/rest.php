<?php
     
require_once dirname(__DIR__)."/CreateOrder.php";
     
class ctWeCashUp
{

    
    public function sendFailureEmail( $orderArray )
    {
        global $ct_options;
    
        $package_id = substr($orderArray["package_id"], 0, strpos($orderArray["package_id"], ";") );
        $startDate = substr($orderArray["package_id"], strpos($orderArray["package_id"], ";") + 1 );
        $startDate = substr($startDate, 0, strpos($startDate, ";") );

    
        $adminCurrencySign = $ct_options['ct_submission_currency'];
        
        $post_data = get_post($package_id);
        
        $package_name = $post_data->post_title;
        $price = get_post_meta($package_id,'price',true);
        

        $user = get_user_by( "id", $orderArray["user_id"] );
        $admin_email = get_option('admin_email');
        

        
        $to = array($admin_email);
        $subject = __('WeCashUp Package Payment Failure: ', 'ct-membership-packages') . $_SERVER['HTTP_HOST'];
        $body = 'Sorry, the wecashup payment failed for the following order:</br><table border="0">
        <tr><th>' . __('Order Details:', 'ct-membership-packages') . '</th></tr>
        <tr>
        <td>' . __('Payment Method:', 'ct-membership-packages') . '</td>
        <td>' . __('WeCashUp', 'ct-membership-packages') . '</td>
        </tr>
        <tr>
        <td>' . __('Package Name:', 'ct-membership-packages') . '</td>
        <td>'.$package_name.'</td>
        </tr>';
        
        $ct_currency_placement = $ct_options['ct_currency_placement'];
        
        if($ct_currency_placement == 'after') {                          
            $body .= '<tr>
            <td>' . __('Amount:', 'ct-membership-packages') . '</td>
            <td>'.$price.$adminCurrencySign.'</td>
            </tr>';
        } else {
            $body .= '<tr>
            <td>' . __('Amount:', 'ct-membership-packages') . '</td>
            <td>'.$adminCurrencySign.$price.'</td>
            </tr>';
        }
        
        $body .= '<tr>
        <td>' . __('User Email:', 'ct-membership-packages') . '</td>
        <td>' . $user->data->user_email . '</td>
        </tr>
        </table>';
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail( $to, $subject, $body, $headers ); 
        

        $to = array($user->data->user_email);
        $subject = __('WeCashUp Payment Failed from ', 'ct-membership-packages') . $_SERVER['HTTP_HOST'];
        $body = '<table border="0">
        <tr><th><h3>' . __('Sorry, the wecashup payment failed for the following order:', 'ct-membership-packages') . '</h3></th></tr>
        <tr><th>' . __('Order Details:', 'ct-membership-packages') . '</th></tr>
        <tr>
        <td>' . __('Payment Method:', 'ct-membership-packages') . '</td>
        <td>' . __('WeCashUp', 'ct-membership-packages') . '</td>
        </tr>
        <tr>
        <td>' . __('Package Name:', 'ct-membership-packages') . '</td>
        <td>'.$package_name.'</td>
        </tr>';
    
    
        $ct_currency_placement = $ct_options['ct_currency_placement'];
        
        if($ct_currency_placement == 'after') {                          
            $body .= '<tr>
            <td>' . __('Amount:', 'ct-membership-packages') . '</td>
            <td>'.$price.$adminCurrencySign.'</td>
            </tr>';
        } else {
            $body .= '<tr>
            <td>' . __('Amount:', 'ct-membership-packages') . '</td>
            <td>'.$adminCurrencySign.$price.'</td>
            </tr>';
        }
        $body .= '</table>';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail( $to, $subject, $body, $headers ); 
        
        
    }

  
    
    public function createTheOrder( $orderArray )
    {
        global $ct_options;
    
        $user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';
    
        //file_put_contents(dirname(__FILE__)."/webhook.log", "createTheOrder: ".print_r($orderArray, true)."\r\n", FILE_APPEND);
    

        $package_id = substr($orderArray["package_id"], 0, strpos($orderArray["package_id"], ";") );
        $startDate = substr($orderArray["package_id"], strpos($orderArray["package_id"], ";") + 1 );
        $expiryDate = substr($startDate, strpos($startDate, ";") + 1 );
        $startDate = substr($startDate, 0, strpos($startDate, ";") );

    
        
        $adminCurrencySign = $ct_options['ct_submission_currency'];
        $adminCurrencyCode =  $ct_options['ct_currency_code'];
    
        $post_data = get_post($package_id);
        
        $package_name = $post_data->post_title;
        $price = get_post_meta($package_id,'price',true);
        $date = get_post_meta($package_id,'date',true);
        $time = get_post_meta($package_id,'time',true);
        $recurring = get_post_meta($package_id,'recurring',true);
        $listing_included = get_post_meta($package_id,'listing',true);
        $featured_listing = get_post_meta($package_id,'featured_listing',true);
        


        $user = get_user_by( "id", $orderArray["user_id"] );


        
        $admin_email = get_option('admin_email');

        //session_start();
        //global $ct_options;
        //$user_id = $current_user->ID;
        //$user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';
        
        
        
        
        $current_date = date('Y-m-d H:i:s');   
        
        $CreateOrder = new CreateOrder();
        
                
        $post["post_title"] = "Order ".$package_name.'-'.$current_date;  
        $post["package_name"] = $package_name;   
        $post["post_type"] = "package_order";
        $post['post_author']   = $user->data->ID;
        $post["packageID"] = $package_id;
        $post["post_status"] = "publish";
        $post["current_user_email"] = $user->data->user_email;   
        $post["currency"] =$adminCurrencySign.$adminCurrencyCode;    
        $post["payment_amount"] = $price; 
        $post["package_current_date"] = $startDate;  
        $post["package_expire_date"] = $expiryDate;   
        $post["payment_method"] = "wecashup";    
        $post["current_user_id"] = $user->data->ID;    
        $post["pack_recurring"] = $recurring;   
        $post["order_status"] = 1;    
        
        $order_id = $CreateOrder->getRequiredContents($post);
        $order_id = $CreateOrder->getRequiredContents($post, $order_id); 
        
        
        
        
        
        
        

        if($order_id) {
            
            $to = array($admin_email);
            $subject = __('New WeCashUp Package Order on ', 'ct-membership-packages') . $_SERVER['HTTP_HOST'];
            $body = '<table border="0">
            <tr><th>' . __('Order Details:', 'ct-membership-packages') . '</th></tr>
            <tr>
            <td>' . __('Payment Method:', 'ct-membership-packages') . '</td>
            <td>' . __('WeCashUp', 'ct-membership-packages') . '</td>
            </tr>
            <tr>
            <td>' . __('Package Name:', 'ct-membership-packages') . '</td>
            <td>'.$package_name.'</td>
            </tr>';
            
            $ct_currency_placement = $ct_options['ct_currency_placement'];
            
            if($ct_currency_placement == 'after') {                          
                $body .= '<tr>
                <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                <td>'.$price.$adminCurrencySign.'</td>
                </tr>';
            } else {
                $body .= '<tr>
                <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                <td>'.$adminCurrencySign.$price.'</td>
                </tr>';
            }
            
            $body .= '<tr>
            <td>' . __('User Email:', 'ct-membership-packages') . '</td>
            <td>' . $user->data->user_email . '</td>
            </tr>
            </table>';
            
            $headers = array('Content-Type: text/html; charset=UTF-8');
            
            wp_mail( $to, $subject, $body, $headers ); 
            
            $to = array($user->data->user_email);
            $subject = __('WeCashUp Package Order Receipt from ', 'ct-membership-packages') . $_SERVER['HTTP_HOST'];
            $body = '<table border="0">
            <tr><th><h3>' . __('Thanks for your purchase!', 'ct-membership-packages') . '</h3></th></tr>
            <tr><th>' . __('Order Details:', 'ct-membership-packages') . '</th></tr>
            <tr>
            <td>' . __('Payment Method:', 'ct-membership-packages') . '</td>
            <td>' . __('WeCashUp', 'ct-membership-packages') . '</td>
            </tr>
            <tr>
            <td>' . __('Package Name:', 'ct-membership-packages') . '</td>
            <td>'.$package_name.'</td>
            </tr>';
        
        
            $ct_currency_placement = $ct_options['ct_currency_placement'];
            
            if($ct_currency_placement == 'after') {                          
                $body .= '<tr>
                <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                <td>'.$price.$adminCurrencySign.'</td>
                </tr>';
            } else {
                $body .= '<tr>
                <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                <td>'.$adminCurrencySign.$price.'</td>
                </tr>';
            }
            $body .= '</table>';
            $headers = array('Content-Type: text/html; charset=UTF-8');
            
            wp_mail( $to, $subject, $body, $headers ); 
        }
        
        
    }

  
  
    public function webhook()
    {

        global $ct_options;

 
        /****************************VERY IMPORTANT TO READ ***************************
                The possible status are : PAID or FAILED            
                                                                                    
         ***************************************************************************/
        
        $merchant_uid = $ct_options["ct_wecashup_merchant_UID"];            
        $merchant_public_key = $ct_options["ct_wecashup_merchant_public_key"]; 
        $merchant_secret = $ct_options["ct_wecashup_merchant_secret_key"];
        
        
            
        // Create and initialize variables to be sent to confirm the that the ongoing transaction is associated with the current merchant
        
        $received_transaction_merchant_secret = null;//create an empty received_transaction_merchant_secret
        $received_transaction_uid = null;//create an empty received_transaction_uid 
        $received_transaction_status  = null;//create an empty received_transaction_status
        $received_transaction_details = null;//create an empty received_transaction_details
        $received_transaction_token = null;//create an empty received_transaction_token
        $authenticated = 'false'; //create an authentication boolean and initialize it at false
        
        //extracting data from the post and filling the variable above
        if(isset($_POST['merchant_secret'])){
            $received_transaction_merchant_secret = $_POST['merchant_secret']; //Get the merchant_secret posted by WeCashUp.
            
        }
        
        if(isset($_POST['transaction_uid'])){
            $received_transaction_uid = $_POST['transaction_uid']; //Get the transaction_uid posted by WeCashUp
        }
        if(isset($_POST['transaction_status'])){
            $received_transaction_status  = $_POST['transaction_status']; //Get the transaction_status posted by WeCashUp
        }
        if(isset($_POST['transaction_amount'])){
            $received_transaction_amount  = $_POST['transaction_amount']; //Get the transaction_amount posted by WeCashUp
        }
        
        if(isset($_POST['transaction_receiver_currency'])){
            $received_transaction_receiver_currency  = $_POST['transaction_receiver_currency']; //Get the transaction_amount posted by WeCashUp
        }
        
        if(isset($_POST['transaction_details'])){
            $received_transaction_details  = $_POST['transaction_details']; //Get the transaction_details posted by WeCashUp
        }
        
        if(isset($_POST['transaction_token'])){
            $received_transaction_token  = $_POST['transaction_token']; //Get the transaction_token posted by WeCashUp
        }
        
        if(isset($_POST['transaction_type'])){
            $received_transaction_type  = $_POST['transaction_type']; //Get the transaction_type posted by WeCashUp
        } 
        
        echo '<br><br> webhook:<br>received_transaction_merchant_secret : '.$received_transaction_merchant_secret;
        echo '<br><br> received_transaction_uid : '.$received_transaction_uid;
        echo '<br><br> received_transaction_token : '.$received_transaction_token;
        echo '<br><br> received_transaction_details : '.$received_transaction_details;
        echo '<br><br> received_transaction_amount : '.$received_transaction_amount;
        echo '<br><br> received_transaction_status : '.$received_transaction_status;
        echo '<br><br> received_transaction_type : '.$received_transaction_type;
    
    /***** SAVE THIS IN YOUD DATABASE - start ****************/
        
       
        
        $txt = "received_transaction_merchant_secret : ".$received_transaction_merchant_secret."\n".
                "merchant_secret : ".$merchant_secret."\n".
                "received_transaction_uid : ".$received_transaction_uid."\n".
                "received_transaction_token : ".$received_transaction_token."\n".
                "received_transaction_details : ".$received_transaction_details."\n".
                "received_transaction_amount : ".$received_transaction_amount."\n".
                "received_transaction_receiver_currency : ".$received_transaction_receiver_currency."\n".
                "received_transaction_status : ".$received_transaction_status."\n".
                "received_transaction_type : ".$received_transaction_type."\n";
    
        //file_put_contents(dirname(__FILE__)."/webhook.log", $txt."\r\n========----------\r\n", FILE_APPEND);
        
    
    /***** SAVE THIS IN YOUD DATABASE - end ****************/
            
            
        
    //Authentication |We make sure that the received data come from a system that knows our secret key (WeCashUp only)
        if($received_transaction_merchant_secret !=null && $received_transaction_merchant_secret == $merchant_secret){
            //received_transaction_merchant_secret is Valid
            
            echo '<br><br> merchant_secret [MATCH]'; 
            
            //file_put_contents(dirname(__FILE__)."/webhook.log", "merchant_secret: ".$merchant_secret."\r\n", FILE_APPEND);
            
            
            $transient = get_transient( 'ct_membership_wecashup_'.$received_transaction_uid );
             
                    
            //file_put_contents(dirname(__FILE__)."/webhook.log", "got transient: ".print_r($transient, true)."\r\n", FILE_APPEND);   
             
            $transient = json_decode($transient, true);
             
          
            //file_put_contents(dirname(__FILE__)."/webhook.log", "got transient 1: ".print_r($transient, true)."\r\n", FILE_APPEND); 
            
            
          
            //Now check if you have a transaction with the received_transaction_uid and received_transaction_token
           
            $database_transaction_uid = $transient["transaction_uid"];
            
            $database_transaction_token = $transient["transaction_token"];
            
            
            if($received_transaction_uid != null && $received_transaction_uid == $database_transaction_uid){
                //received_transaction_merchant_secret is Valid
                
                echo '<br><br> transaction_uid [MATCH]'; 
                
                if($received_transaction_token  != null && $received_transaction_token == $database_transaction_token){
                    //received_transaction_token is Valid 
                    
                    echo '<br><br> transaction_token [MATCH]'; 
                    
                    //All the 3 parameters match, so...
                    $authenticated = 'true';
                }
            }
        }
        
        
            //file_put_contents(dirname(__FILE__)."/webhook.log", "authenticated: ".$authenticated."\r\n", FILE_APPEND);
            

        if($authenticated == 'true') {
            
            //Update and process your transaction
            
             //file_put_contents(dirname(__FILE__)."/webhook.log", "received_transaction_status: ".$received_transaction_status."\r\n", FILE_APPEND);
             
             //file_put_contents(dirname(__FILE__)."/webhook.log", "received_transaction_status: ".$received_transaction_status."\r\n", FILE_APPEND);
             
            if($received_transaction_status == "PAID"){
            
                 $this->createTheOrder($transient);
                 

            }else{ //Status = FAILED
                
                $this->sendFailureEmail($transient);
                
            }
            
            /***** SAVE THIS IN YOUD DATABASE - start ****************/
                    
            
            $txt = "received_transaction_merchant_secret : ".$received_transaction_merchant_secret."\n".
                    "received_transaction_uid : ".$received_transaction_uid."\n".
                    "received_transaction_token : ".$received_transaction_token."\n".
                    "received_transaction_details : ".$received_transaction_details."\n".
                    "received_transaction_status : ".$received_transaction_status."\n".
                    "received_transaction_type : ".$received_transaction_type."\n";
            
            
                    //file_put_contents(dirname(__FILE__)."/webhook.log", $txt."\r\n========----------\r\n", FILE_APPEND);
        
 
            
        }
        

    }


    public function callback()
    {

        global $ct_options;

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        
        $merchant_uid = $ct_options["ct_wecashup_merchant_UID"];            
        $merchant_public_key = $ct_options["ct_wecashup_merchant_public_key"]; 
        $merchant_secret = $ct_options["ct_wecashup_merchant_secret_key"];    
        
        $transaction_uid = '';// create an empty transaction_uid
        $transaction_token  = '';// create an empty transaction_token
        $transaction_provider_name  = ''; // create an empty transaction_provider_name
        $transaction_confirmation_code  = ''; // create an empty confirmation code
        
        if(isset($_POST['transaction_uid'])){
            $transaction_uid = $_POST['transaction_uid']; // Get the transaction_uid posted by the payment box
        }
        
        if(isset($_POST['transaction_token'])){
            $transaction_token  = $_POST['transaction_token']; // Get the transaction_token posted by the payment box
        }
        
        if(isset($_POST['transaction_provider_name'])){
            $transaction_provider_name  = $_POST['transaction_provider_name']; // Get the transaction_provider_name posted by the payment box
        }
        
        if(isset($_POST['transaction_confirmation_code'])){
            $transaction_confirmation_code  = $_POST['transaction_confirmation_code']; // Get the transaction_confirmation_code posted by the payment box
        }
        
        $url = 'https://www.wecashup.com/api/v2.0/merchants/'.$merchant_uid.'/transactions/'.$transaction_uid.'?merchant_public_key='.$merchant_public_key;
        




        $fields = array(
            'merchant_secret' => urlencode($merchant_secret),
            'transaction_token' => urlencode($transaction_token),
            'transaction_uid' => urlencode($transaction_uid),
            'transaction_confirmation_code' => urlencode($transaction_confirmation_code),
            'transaction_provider_name' => urlencode($transaction_provider_name),
            '_method' => urlencode('PATCH')
        );
    
        $fields_string = "";
        foreach($fields as $key=>$value) { 
            $fields_string .= $key.'='.$value.'&'; 
        }
        
        rtrim($fields_string, '&');
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        //Step 9  : Retrieving the WeCashUp Response
        
        $server_output = curl_exec ($ch);
       
        
        //file_put_contents(dirname(__FILE__)."/callback.log", "url: ".$url."\r\n", FILE_APPEND);
        //file_put_contents(dirname(__FILE__)."/callback.log", "server_output: ".$server_output."\r\n========----------\r\n", FILE_APPEND);
 
        
        curl_close ($ch);
        
        $current_user = wp_get_current_user(); 
        //file_put_contents(dirname(__FILE__)."/callback.log", "current_user: ".print_r($current_user, true)."\r\n========----------\r\n", FILE_APPEND);
       
       
        $data = json_decode($server_output, true);
        
        //file_put_contents(dirname(__FILE__)."/callback.log", "data: ".print_r($data, true)."\r\n========----------\r\n", FILE_APPEND);
        
        //file_put_contents(dirname(__FILE__)."/callback.log", "transaction_uid: ".$data["response_content"]["transaction"]["transaction_uid"]."\r\n========----------\r\n", FILE_APPEND);
        
        
        
                  
        if($data['response_status'] =="success"){
        
             $callbackArray = [
                  "transaction_uid"    => $data["response_content"]["transaction"]["transaction_uid"],
                  "transaction_token"  => $data["response_content"]["transaction"]["transaction_token"],
                  "transaction_status" => $data["response_content"]["transaction"]["transaction_status"],
                  "transaction_type"   => $data["response_content"]["transaction"]["transaction_type"],
                  "user_id"            => $current_user->ID,
                  "package_id"         => $data["response_content"]["transaction"]["transaction_receiver_reference"],
                  "amount"             => $data["response_content"]["transaction"]["transaction_receiver_total_amount"]
             ];
             
    
             
             //file_put_contents(dirname(__FILE__)."/callback.log", "setting transient\r\n", FILE_APPEND);
                     
             set_transient( 'ct_membership_wecashup_'.$data["response_content"]["transaction"]["transaction_uid"], json_encode($callbackArray), DAY_IN_SECONDS );
             
            
             $post_data = get_post($data["response_content"]["transaction"]["transaction_receiver_reference"]);
        
             $package_name = $post_data->post_title;
             

            //Do wathever you want to tell the user that it's transaction succeed or redirect him/her to a success page
            $user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';

            $html = '<div class="email-data">
            <h3 id="thanks" class="marT20">' . __('Thanks for your purchase!', 'ct-membership-packages') . '</h3>
            <h5>' . __('Order Details:', 'ct-membership-packages') . '</h5>
            <p class="marB0">' . __('Package Name:', 'ct-membership-packages') . ' ' . $package_name.'</p>                            
            <p class="marB0">' . __('Payment Method: WeCashUp', 'ct-membership-packages') . '</p>                             
            <p class="marB0">' . __('Amount:', 'ct-membership-packages') . ' ' . $data["response_content"]["transaction"]["transaction_receiver_total_amount"].'</p>
            <p class="marB20">' . __('User email:', 'ct-membership-packages') . ' ' . $current_user->user_email.'</p>

            <p class="marB20"><a class="btn" href="' . get_page_link($user_listings) . '" target="_parent">' . __('View Your Listings', 'ct-membership-packages') . '</a></p>
            </div>';

            echo $html;

        }else{
        
            //Do wathever you want to tell the user that it's transaction failed or redirect him/her to a failure page
        
            $location = 'https://www.wecashup.cloud/cdn/tests/websites/PHP/responses_pages/failure.html';
            echo '<script>top.window.location = "'.$location.'"</script>';
        }
        

    }

}
