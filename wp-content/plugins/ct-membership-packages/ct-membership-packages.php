<?php
/*
     * Plugin Name:      Contempo Membership & Packages
     * Description:      This plugin adds the ability to create membership & packages for use with the front end submission system in WP Pro Real Estate 7, with Stripe, PayPal & Wire Transfer payment methods.
     * Version:          1.3.4
     * Author:           Contempo
     * Author URI:       http://contempographicdesign.com
     * License:          GPL-2.0+
     * License URI:      http://www.gnu.org/licenses/gpl-2.0.txt
     * Text Domain:      ct-membership-packages
     * Domain Path:      /languages
*/

require_once 'CreateOrder.php';
include('cronScheduler.php');
//session_start();
ob_start();

/**
 * Enqueue plugin style-file
 */

     add_action('wp_ajax_callback_url', 'callback_url');
     add_action('wp_ajax_nopriv_callback_url', 'callback_url');
       
     function callback_url() 
     {
          require_once dirname(__FILE__)."/wecashup/rest.php";
          $octWeCashUp = new ctWeCashUp();
          
          $octWeCashUp->callback();
  
     }
     
     add_action('wp_ajax_webhook_url', 'webhook_url');
     add_action('wp_ajax_nopriv_webhook_url', 'webhook_url');
       
     function webhook_url() 
     {
          require_once dirname(__FILE__)."/wecashup/rest.php";
          $octWeCashUp = new ctWeCashUp();
          
          $octWeCashUp->webhook();
  
     }

     add_action('admin_init', 'add_webhook_url_wecashup');

        function add_webhook_url_wecashup() {
            //$nonce = $_REQUEST['_wpnonce'];
            if ( current_user_can('manage_options') ) {

global $ct_options;
$fields_string = "";

                  $merchant_uid = isset($ct_options['ct_wecashup_merchant_UID'] ) ? esc_html( $ct_options['ct_wecashup_merchant_UID']) : ''; 
                  $merchant_public_key = isset($ct_options['ct_wecashup_merchant_public_key'] ) ? esc_html( $ct_options['ct_wecashup_merchant_public_key']) : ''; 
                  $merchant_secret_key = isset($ct_options['ct_wecashup_merchant_secret_key'] ) ? esc_html( $ct_options['ct_wecashup_merchant_secret_key']) : '';
                                      
 
                                   
               $webhookurl = admin_url('admin-ajax.php?action=webhook_url');
               $callbackurl = admin_url('admin-ajax.php?action=callback_url');

               $webhookurl = str_replace("http://", "https://", $webhookurl);
               $callbackurl = str_replace("http://", "https://", $callbackurl);
               
                if ($merchant_uid != '' && $merchant_public_key != '' && $merchant_secret_key != ''):
                    $url = 'https://www.wecashup.com/api/v2.0/merchants/' . $merchant_uid . '?merchant_public_key=' . $merchant_public_key;

                    $fields = array(
                        'merchant_secret' => urlencode($merchant_secret_key),
                        'merchant_default_webhook_url' => urlencode($webhookurl),
                        'merchant_callback_url' => urlencode($callbackurl),
                        '_method' => urlencode('PATCH')
                    );

                    foreach ($fields as $key => $value) {
                        $fields_string .= $key . '=' . $value . '&';
                    }

                    rtrim($fields_string, '&');
                    $args = array(
                        'body' => $fields_string,
                        'timeout' => '15',
                        'redirection' => '5',
                        'httpversion' => '1.0',
                        'blocking' => true,
                        'headers' => array(),
                        'cookies' => array()
                    );
                    $response = wp_remote_post($url, $args);
                    
                    /*
                    file_put_contents(dirname(__FILE__)."/set_url", "url: ".print_r($url, true)."\r\n", FILE_APPEND);
                    file_put_contents(dirname(__FILE__)."/set_url", "args: ".print_r($args, true)."\r\n", FILE_APPEND);
                    file_put_contents(dirname(__FILE__)."/set_url", "response: ".print_r($response, true)."\r\n", FILE_APPEND);
                    */
                    
                endif;
          }
        }



add_action( 'wp_enqueue_scripts', 'ct_styles' );

if(!function_exists('ct_styles')) {
     function ct_styles() {
          wp_register_script( 'stripe', plugins_url( 'stripe.js', __FILE__ ) );
          wp_enqueue_script( 'stripe' );   
          wp_register_style( 'packages', plugins_url('assets/css/packages.css', __FILE__) );        
          wp_enqueue_style( 'packages' );
     }
}
     
//Create Custom Post type Packages in admin
add_action('init', 'ct_create_packages');

if (!function_exists('ct_create_packages')) {

     function ct_create_packages() {
          register_post_type( 'packages',
               array(
                    'labels' => array(
                         'name' => _x('Packages', 'post type general name', 'ct-membership-packages'),
                         'singular_name' => _x('Packages', 'post type singular name', 'ct-membership-packages'),
                         'add_new' => _x( 'Add New', 'packages', 'ct-membership-packages'),
                         'add_new_item' => __('Add New Packages', 'ct-membership-packages'),
                         'edit' => __('Edit', 'ct-membership-packages'),
                         'edit_item' => __('Edit Packages', 'ct-membership-packages'),
                         'new_item' => __('New Packages', 'ct-membership-packages'),
                         'view' => __('View', 'ct-membership-packages'),
                         'view_item' => __('View Packages', 'ct-membership-packages'),
                         'search_items' => __('Search Packages', 'ct-membership-packages'),
                         'not_found' => __('No Packages found', 'ct-membership-packages'),
                         'not_found_in_trash' => __('No Packages found in Trash', 'ct-membership-packages'),
                         'parent' => 'Parent Packages'
                    ),
      
                    'public' => true,
                    'menu_position' => 15,
                    'supports' => array( 'title', 'custom-fields' ),
                    'taxonomies' => array( '' ),
                    'menu_icon' => 'dashicons-archive',
                    'has_archive' => true
               )
          );
          register_post_type( 'package_order',
               array(
                    'labels' => array(
                         'name' => _x('Package Orders', 'post type general name', 'ct-membership-packages'),
                         'singular_name' => _x('Order', 'post type singular name', 'ct-membership-packages'),
                         'add_new' => _x('Add New', 'package_order', 'ct-membership-packages'),
                         'add_new_item' => __('Add New Package Order', 'ct-membership-packages'),
                         'edit' => __('Edit', 'ct-membership-packages'),
                         'edit_item' => __('Edit Package Order', 'ct-membership-packages'),
                         'new_item' => __('New Package Order', 'ct-membership-packages'),
                         'view' => __('View', 'ct-membership-packages'),
                         'view_item' => __('View Package Orders', 'ct-membership-packages'),
                         'search_items' => __('Search Package Orders', 'ct-membership-packages'),
                         'not_found' => __('No Package Order found', 'ct-membership-packages'),
                         'not_found_in_trash' => __('No Package Orders found in Trash', 'ct-membership-packages'),
                         'parent' => 'Parent Package Orders'
                    ),
      
                    'public' => true,
                    'menu_position' => 16,
                    'supports' => array( 'title', 'author', 'custom-fields' ),
                    'taxonomies' => array( '' ),
                    'show_in_menu'  =>  'edit.php?post_type=packages',
                    //'menu_icon' => 'dashicons-id',
                    'has_archive' => true
               )
          );
          
     }
}

// Define columns for Packages
if(!function_exists('ct_packages_cols')) {
     function ct_packages_cols($columns) {
          $columns = array(
               //Create custom columns
               'cb' => '<input type="checkbox" />',
               'title' => __('Package', 'ct-membership-packages'),
               'package_price' => __('Price', 'ct-membership-packages'),
               'package_time' => __('Time', 'ct-membership-packages'),
               'package_listings' => __('# of Listings', 'ct-membership-packages'),
               'package_featured_listings' => __('# of Featured Listings', 'ct-membership-packages'),
               'package_recurring' => __('Recurring', 'ct-membership-packages'),
          );
          return $columns;
     }
}
add_filter("manage_edit-packages_columns", "ct_packages_cols");

// Add Custom CSS to Admin
add_action('admin_head', 'ct_packages_admin_css');
function ct_packages_admin_css() {
  echo '<style>
     td.image.column-image { width: 15%; overflow: hidden;}
     td.image.column-image img { width: 100%;} 
     td.pack_recurring .recurring-yes,
     td.pack_recurring .recurring-no,
     td.package_status .package-expired,
     td.package_status .package-not-expired { display: block; padding: 6px 10px; color: #fff; font-size: 10px; border-radius: 3px; text-transform: uppercase; text-align: center;}
          td.pack_recurring .recurring-yes { background: #7faf1b;}
          td.pack_recurring .recurring-no { background: #0097d6;}
          td.package_status .package-expired { background: #bc0000;}
          td.package_status .package-not-expired { background: #34495e;}
     @media screen and (max-width: 959px) {
          .column-pack_recurring,
          .column-package_user_email { display: none;}
   }
   @media screen and (max-width: 782px) {
          .column-package_name,
          .column-pack_recurring,
          .column-package_date_ordered,
          .column-package_expire_date,
          .column-package_amount,
          .column-package_user,
          .column-package_user_email { display: none;}
   }
  </style>';
}

// Output custom columns
function ct_custom_packages_cols($column, $post_id) {
     global $post;

     switch( $column ) {

          // Price
          case 'package_price' :

               global $ct_options;

               $ct_currency_placement = $ct_options['ct_currency_placement'];

               $package_price = get_post_meta( $post_id , 'price' , true );

               if($ct_currency_placement == 'after') { 
                if(!empty($package_price)) {
                         echo $package_price;
                         ct_currency();
                    } else {
                         echo __('-', 'ct-membership-packages');
                    }
            } else {
                if(!empty($package_price)) {
                         ct_currency();
                         echo $package_price;
                    } else {
                         echo __('-', 'ct-membership-packages');
                    } 
            }

          break;

          // Package Time
          case 'package_time' :

               echo get_post_meta( $post_id , 'date' , true ) . ' ' . get_post_meta( $post_id , 'time' , true );

          break;

          // # of Listings
          case 'package_listings' :

               $listings = get_post_meta( $post_id , 'listing' , true );

               if(!empty($listings)) {
                    echo $listings;
               } else {
                    echo __('-', 'ct-membership-packages');
               }

          break;

          // # of Featured Listings
          case 'package_featured_listings' :

               $featured_listings = get_post_meta( $post_id , 'featured_listing' , true );

               if(!empty($featured_listings)) {
                    echo $featured_listings;
               } else {
                    echo __('-', 'ct-membership-packages');
               }

          break;

          // Recurring
          case 'package_recurring' :

               $recurring_yes_no = get_post_meta( $post_id , 'recurring' , true );

               if(!empty($recurring_yes_no)) {
                    echo '<span class="recurring-yes">' .  __('Yes', 'ct-membership-packages') . '</span>';
               } else {
                    echo '<span class="recurring-no">' .  __('No', 'ct-membership-packages') . '</span>';
               }

          break;

     }
     
}
add_action('manage_posts_custom_column', 'ct_custom_packages_cols', 10, 2);

// Define columns for Orders
if(!function_exists('ct_package_order_cols')) {
     function ct_package_order_cols($columns) {
          $columns = array(
               //Create custom columns
               'cb' => '<input type="checkbox" />',
               //'image' => __('Image', 'ct-membership-packages'),
               //'title' => __('Title', 'ct-membership-packages'),
               'package_invoice' => __('Invoice', 'ct-membership-packages'),
               'package_name' => __('Package', 'ct-membership-packages'),
               'pack_recurring' => __('Recurring', 'ct-membership-packages'),
               'package_date_ordered' => __('Date Ordered', 'ct-membership-packages'),
               'package_expire_date' => __('Expire Date', 'ct-membership-packages'),
               'package_status' => __('Status', 'ct-membership-packages'),
               'package_amount' => __('Total', 'ct-membership-packages'),
               'package_user' => __('User', 'ct-membership-packages'),
               'package_user_email' => __('User Email', 'ct-membership-packages'),
               //'date' => __('Listed', 'ct-membership-packages')
          );
          return $columns;
     }
}
add_filter("manage_edit-package_order_columns", "ct_package_order_cols");

// Add Custom CSS to Admin
add_action('admin_head', 'ct_package_order_admin_css');
function ct_package_order_admin_css() {
  echo '<style>
     td.image.column-image { width: 15%; overflow: hidden;}
     td.image.column-image img { width: 100%;} 
     td.pack_recurring .recurring-yes,
     td.pack_recurring .recurring-no,
     td.package_status .package-expired,
     td.package_status .package-not-expired { display: block; padding: 6px 10px; color: #fff; font-size: 10px; border-radius: 3px; text-transform: uppercase; text-align: center;}
          td.pack_recurring .recurring-yes { background: #7faf1b;}
          td.pack_recurring .recurring-no { background: #0097d6;}
          td.package_status .package-expired { background: #bc0000;}
          td.package_status .package-not-expired { background: #34495e;}
     @media screen and (max-width: 959px) {
          .column-pack_recurring,
          .column-package_user_email { display: none;}
   }
   @media screen and (max-width: 782px) {
          .column-package_name,
          .column-pack_recurring,
          .column-package_date_ordered,
          .column-package_expire_date,
          .column-package_amount,
          .column-package_user,
          .column-package_user_email { display: none;}
   }
  </style>';
}

// Output custom columns
function ct_custom_package_order_cols($column, $post_id) {
     global $post;

     switch( $column ) {

          // Image
          case 'image' :

               if(has_post_thumbnail()) {
                    the_post_thumbnail('thumb');
               }

          break;

          // Invoice
          case 'package_invoice' :

               echo '<a href="post.php?post=' . $post_id . '&action=edit">' . $post_id . '</a>';

          break;

          // Name
          case 'package_name' :

               echo '<strong>' . get_post_meta( $post_id , 'package_name' , true ) . '</strong>';

          break;

          // Recurring
          case 'pack_recurring' :

               $recurring_yes_no = get_post_meta( $post_id , 'pack_recurring' , true );

               if($recurring_yes_no == 'Yes') {
                    echo '<span class="recurring-yes">' .  __('Yes', 'ct-membership-packages') . '</span>';
               } else {
                    echo '<span class="recurring-no">' .  __('No', 'ct-membership-packages') . '</span>';
               }

          break;

          // Date Ordered
          case 'package_date_ordered' :

               echo get_post_meta( $post_id , 'package_current_date' , true );

          break;

          // Expire Date
          case 'package_expire_date' :

               echo get_post_meta( $post_id , 'package_expire_date' , true );

          break;

          case 'package_status' :

               $today = strtotime(date("Y-m-d"));
               if($today >= strtotime(get_post_meta($post->ID, 'package_expire_date', true))) {
                    echo '<span class="package-expired">' . __('Expired', 'ct-membership-packages') . '</span>';
               } else {
                    echo '<span class="package-not-expired">' . __('Current', 'ct-membership-packages') . '</span>';
               }

          break;

          // Amount
          case 'package_amount' :

               global $ct_options;

               $ct_currency_placement = $ct_options['ct_currency_placement'];

               $paypal_payment_amount = get_post_meta( $post_id , 'paypal_payment_amount' , true );
               $stripe_payment_amount = get_post_meta( $post_id , 'stripe_payment_amount' , true );
               $payment_amount = get_post_meta( $post_id , 'payment_amount' , true );

               if($ct_currency_placement == 'after') { 
                if(!empty($paypal_payment_amount) && is_numeric($paypal_payment_amount)) {
                         echo $paypal_payment_amount;
                         ct_currency();
                    } elseif(!empty($stripe_payment_amount) && is_numeric($stripe_payment_amount)) {
                         echo $stripe_payment_amount;
                         ct_currency();
                    } elseif(!empty($payment_amount)) {
                         if($payment_amount != 'N/A') {
                              echo $payment_amount;
                              ct_currency();
                         } else {
                              echo $payment_amount;
                         }
                    } else {
                         echo __('%u2013', 'ct-membership-packages');
                    }
            } else {
                if(!empty($paypal_payment_amount) && is_numeric($paypal_payment_amount)) {
                    ct_currency();
                         echo $paypal_payment_amount;
                    } elseif(!empty($stripe_payment_amount) && is_numeric($stripe_payment_amount)) {
                         ct_currency();
                         echo $stripe_payment_amount;
                    } elseif(!empty($payment_amount)) {
                         if($payment_amount != 'N/A') {
                              ct_currency();
                              echo $payment_amount;
                         } else {
                              echo $payment_amount;
                         }
                    } else {
                         echo __('%u2013', 'ct-membership-packages');
                    } 
            }

               

          break;

          // User
          case 'package_user' :

               $package_current_user_id = get_post_meta( $post_id , 'current_user_id' , true );
               $package_user_info = get_userdata($package_current_user_id);

               if(!empty($package_user_info)) {
                    echo '<a href="user-edit.php?user_id=' . $package_current_user_id . '&wp_http_referer=%2Fwordpress%2Fwp-admin%2Fusers.php">' . $package_user_info->first_name . ' ' . $package_user_info->last_name . '</a>';
               } else {
                    echo __('Unknown', 'ct-membership-packages');
               }

          break;

          // User
          case 'package_user_email' :

               echo get_post_meta( $post_id , 'current_user_email' , true );

          break;

     }
     
}
add_action('manage_posts_custom_column', 'ct_custom_package_order_cols', 10, 2);

//Add MetaBox
add_action( 'add_meta_boxes', 'ct_add_packages_meta_fields' );
/*
*
* Display none of admin side Custom meta field(Add custom field)
*/

if (!function_exists('ct_add_packages_meta_fields')) {
     function ct_add_packages_meta_fields()
     {
          add_meta_box( 'my-meta-box-id', 'Package Fields', 'ct_input_meta_box_fields', 'packages', 'normal', 'high' );
     }
}

//add fields in custom meta
if (!function_exists('ct_input_meta_box_fields')) {
          function ct_input_meta_box_fields()
               {
                    global $post;
                    $price = get_post_meta( @$post->ID, 'price', true );
                    $price = isset( $price ) ? $price : '';  
                    $time = get_post_meta( @$post->ID, 'time', true );
                    $time = isset( $time ) ? $time : '';  
                    $listing = get_post_meta( @$post->ID, 'listing', true );
                    $listing = isset( $listing ) ? $listing : '';     
                    $featured_listing = get_post_meta( @$post->ID, 'featured_listing', true );
                    $featured_listing = isset( $featured_listing ) ? $featured_listing : '';  
                    $recurring = get_post_meta( @$post->ID, 'recurring', true );
                    $recurring = isset( $recurring ) ? $recurring : ''; 
                    $popular = get_post_meta( @$post->ID, 'popular', true );
                    $popular = isset( $popular ) ? $popular : ''; 
                    $date = get_post_meta( @$post->ID, 'date', true );
                    $date = isset( $date ) ? $date : '';  
                    
                    // We'll use this nonce field later on when saving.
                    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
                    ?>
                    <p>
                         <label for="packages_boxes">Price (<?php ct_currency(); ?>)</label>                       
                         <input type="text" name="price" id="price" value="<?php echo $price; ?>" style="width: 100%;" />
                    </p> 
                    <p>
                         <label for="packages_boxes">Time</label>                                        
                         <select name="date">                         
                              <option value="0"><?php _e('None', 'ct-membership-packages'); ?></option>
                              <?php 
                                   $ab = range(1, 31);
                                    foreach ($ab as $i) {                            
                                        $sel = '';
                                        if($i == $date){
                                             $sel= 'selected=selected';
                                        }                        
                                        echo '<option '.$sel.' value="'.$i.'">'.$i.'</option>';
                                   }
                              ?>
                         </select>
                          
                         <select name="time" class="time_admin">
                              <option value="0"><?php _e('None', 'ct-membership-packages'); ?></option>
                              <?php 
                                   $time_day = 'Day(s)';
                                   $time_week = 'Week(s)';
                                   $time_month = 'Month(s)';
                                   $time_year = 'Year(s)';
                                    $timevalues = array($time_day, $time_week, $time_month, $time_year);
                                    foreach ($timevalues as $values) {                              
                                        $timesel = '';
                                        if($values == $time){
                                             $timesel= 'selected=selected';
                                        }                        
                                        echo '<option '.$timesel.' value="'.$values.'">'.$values.'</option>';
                                   }
                              ?>
                         </select>
                    </p> 
                    <p>
                         <label for="packages_boxes"><?php _e('Listing', 'ct-membership-packages'); ?></label>
                         <input type="text" name="listing" id="listing" value="<?php echo $listing; ?>" style="width: 100%;" />
                    </p> 
                    <p>
                         <label for="packages_boxes"><?php _e('Featured Listing', 'ct-membership-packages'); ?></label>
                         <input type="text" name="featured_listing" id="featured_listing" value="<?php echo $featured_listing; ?>" style="width: 100%;" />
                    </p>
                    <p>
                         <label for="packages_boxes"><?php _e('Recurring Subscription', 'ct-membership-packages'); ?></label><br/>
                         <input type="checkbox" name="recurring" value='Yes'<?php checked(1, $recurring); ?> /><?php _e('Enable Recurring Payment', 'ct-membership-packages'); ?>
                    </p>
                    <p>
                         <label for="packages_boxes"><?php _e('Mark as Popular', 'ct-membership-packages'); ?></label><br/>
                         <input type="checkbox" name="popular" value='Yes'<?php checked(1, $popular); ?> /><?php _e('Mark as Popular', 'ct-membership-packages'); ?>
                    </p>
               
                    <?php    
               }
     }

//save the custom meta field

add_action( 'save_post', 'ct_save_packages_meta_fields' );

if(!function_exists('ct_save_packages_meta_fields')){

     function ct_save_packages_meta_fields( $post_id )

     {

          if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

          // if our nonce isn't there, or we can't verify it, bail

          if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

          // if our current user can't edit this post, bail

          if( !current_user_can( 'edit_post' ) ) return;

          // now we can actually save the data

          $allowed = array( 

               'a' => array( // on allow a tags

                    'href' => array() // and those anchors can only have href attribute

               )

          );

          // Make sure your data is set before trying to save it      

          if( isset( $_POST['price'] ) )
               update_post_meta( $post_id, 'price', wp_kses( ucwords($_POST['price']), $allowed ) );
               
          if( isset( $_POST['time'] ) )
               update_post_meta( $post_id, 'time', wp_kses( $_POST['time'], $allowed ) );

          if( isset( $_POST['listing'] ) )
               update_post_meta( $post_id, 'listing', wp_kses( $_POST['listing'], $allowed ) );
               
          if( isset( $_POST['featured_listing'] ) )
               update_post_meta( $post_id, 'featured_listing', wp_kses( $_POST['featured_listing'], $allowed ) );  
               
          if ( isset( $_REQUEST['recurring'] ) ) { update_post_meta($post_id, 'recurring', TRUE);}
               else { update_post_meta($post_id, 'recurring', FALSE); }

          if ( isset( $_REQUEST['popular'] ) ) { update_post_meta($post_id, 'popular', TRUE);}
               else { update_post_meta($post_id, 'popular', FALSE); }
          
          if( isset( $_POST['date'] ) )
               update_post_meta( $post_id, 'date', wp_kses( $_POST['date'], $allowed ) );
     } 
}

//Show Posts on Frontend

if(!function_exists('ct_frontend_packages')){
function ct_frontend_packages(){
     //global $ct_options;

if(is_user_logged_in()) { 
     
     $current_user = wp_get_current_user(); 
     $current_user_id = $current_user->ID;
     $today = strtotime(date("Y-m-d"));
     
     global $wpdb;                      
     $Orders = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts p, ".$wpdb->prefix."postmeta m1 WHERE p.ID = m1.post_id 
                    AND m1.meta_key = 'order_status' AND m1.meta_value = '1'
                    AND p.post_type = 'package_order' AND p.post_status = 'publish' AND p.post_author = '$current_user_id'"); 
     /*    echo "<pre>"; print_r($wire_users);
          die; 
     $Orders = get_posts(
               array(
                    'post_type' => 'package_order',
                    'posts_per_page' => 1,
                    'author' => $current_user_id,
                    'post_status' => 'publish',
                    'meta_key' => 'order_status',
                    'meta_value' => 1
               )
          ); */
          
     foreach($Orders as $packagepost){
          $pack_id = $packagepost->ID;
          $order_status = get_post_meta($pack_id,'order_status', true); 
          $pack_expire_date = get_post_meta($pack_id,'package_expire_date', true);
     
     }
     //if(!empty($pack_id)){
          @$packExpire_date = strtotime($pack_expire_date);
     //}
     
     

     if($today >= @$packExpire_date || @$packExpire_date == '' || @$_GET['package'] == 'update' || @$_GET['package'] == 'package-change'){
     ?>
          <div class="packages-container">
          
          
               <div id='loadingmessage' style='display:none'>
                    <img src="<?php echo plugins_url('assets/images/dark-loader.gif',__FILE__) ?>"/>
               </div>    
               <div class="packages-tab">
                    <div class="tablinks active">
                      <div><?php _e('Select a Package', 'ct-membership-packages'); ?></div>  
                      <div class="tablinks-bar"></div>
                    </div>
                    <div class="tablinks">
                      <div><?php _e('Payment', 'ct-membership-packages'); ?></div>
                      <div class="tablinks-bar"></div>
                    </div>  
                    <div class="tablinks">
                      <div><?php _e('Complete', 'ct-membership-packages'); ?></div>
                      <div class="tablinks-bar"></div>
                    </div>
               </div>
                    
               <?php     
               
                    $admin_email = get_option('admin_email');                        
                    $ct_id1 = get_option('ct_options');     
                    $adminCurrencySign = $ct_id1['ct_submission_currency'];
                    $adminCurrencyCode1 =  $ct_id1['ct_currency_code'];
                    //$adminCurrencyCode1 =  isset( $ct_id1['ct_currency_code'] ) ? strtolower($ct_id1['ct_currency_code']) : 'USD';   
                    $paypalMerchantEmail=  $ct_id1['ct_paypal_email'];                    
                    $paypalUrlmode=  $ct_id1['ct_paypal_mode'];                 
                    $wiretransfer=  $ct_id1['ct_wire_transfer_instructions'];                  
                    $stripeSecertkey=  $ct_id1['ct_stripe_secret_key'];         
                    $current_user = wp_get_current_user();  
                    $current_user_email = $current_user->user_email;
                    $current_user_id = $current_user->ID;
                    $package_current_date1 = date("Y-m-d"); 
                    $getPackage = get_posts(
                    array(
                              'post_type' => 'package_order',
                              'posts_per_page' => -1,
                              'author' => $current_user_id,
                         )
                    );        
                    foreach($getPackage as $order){    
                          $order_author =  $order->post_author;                 
                          $package_expire_date1 = get_post_meta( $order->ID, 'package_expire_date',true);          
                    }
                    ?>
               
               <div class="package-tab-content">



                         <div id="package" class="tabcontent" style="display: block;">                   
                              <?php 
                              $args = array(
                                   'post_type' => 'packages',
                                   'posts_per_page' => 4,
                                   'order' =>'asc'                         
                              );
                              // Query the posts:
                              $obituary_query = new WP_Query($args);

                              while ($obituary_query->have_posts()) : $obituary_query->the_post();
                                   $time= get_post_meta( get_the_ID(), 'time', true );
                                   $date= get_post_meta( get_the_ID(), 'date', true );
                                   $price = get_post_meta( get_the_ID(), 'price', true );                     
                                   $listing = get_post_meta( get_the_ID(), 'listing', true );
                                   $featured_listing = get_post_meta( get_the_ID(), 'featured_listing', true );
                                   $recurring = get_post_meta( get_the_ID(), 'recurring', true );
                                   $popular = get_post_meta( get_the_ID(), 'popular', true );

                                   $day = __('Day', 'ct-membership-packages');
                                   $days = __('Days', 'ct-membership-packages');
                                   $week = __('Week', 'ct-membership-packages');
                                   $weeks = __('Weeks', 'ct-membership-packages');
                                   $month = __('Month', 'ct-membership-packages');
                                   $months = __('Months', 'ct-membership-packages');
                                   $year = __('Year', 'ct-membership-packages');
                                   $years = __('Years', 'ct-membership-packages');
                              ?>
                              <div class="package-posts col span_3 <?php if(!empty($popular)) { echo 'popular'; } ?>" id="<?php echo get_the_ID(); ?>">
                                   <?php if(!empty($popular)) {
                                        echo '<p class="popular-heading">' . __('Popular', 'ct-membership-packages') . '</p>';
                                   } ?>
                                   <h5 class="pack_title_<?php echo get_the_ID(); ?>" packtitle="<?php the_title(); ?>"><?php the_title(); ?></h5>    
                                   <?php

                                   global $ct_options;
                                   $ct_currency_placement = $ct_options['ct_currency_placement'];
                                   
                                   
                                   if($ct_currency_placement == 'after') { ?>
                                        <p class="price"><span class="price_<?php echo get_the_ID(); ?>" packprice="<?php echo $price . ' ' . ct_currency() ?>" packprice1="<?php echo $price; ?>"><?php echo $price; ct_currency(); ?></span></p>
                                   <?php } else { ?>
                                        <p class="price"><span class="price_<?php echo get_the_ID(); ?>" packprice="<?php echo ct_currency() . ' ' . $price ?>" packprice1="<?php echo $price; ?>"><?php echo ct_currency() . $price; ?></span></p>
                                   <?php } ?>

                                   <ul class="pack-boxes marB20">
                                        <li class="pack_time_<?php echo get_the_ID(); ?>" pack_date ="<?php if(($date) != 0){ echo $date; } else { _e('N/A', 'ct-membership-packages'); } ?>" pack_time="<?php echo $time; ?>" packtime="<?php if(($time && $date) != 0){ echo $date .' '. $time ; } else { _e('N/A', 'ct-membership-packages'); } ?>" >

                                             <?php if(($time && $date) != 0){
                                                  if($time == 'Day(s)' && $date == '1') {
                                                       echo $date .' '. $day;
                                                  } elseif($time == 'Day(s)') {
                                                       echo $date .' '. $days;
                                                  } elseif($time == 'Week(s)' && $date == '1') {
                                                       echo $date .' '. $week;
                                                  } elseif($time == 'Week(s)') {
                                                       echo $date .' '. $weeks;
                                                  } elseif($time == 'Month(s)' && $date == '1') {
                                                       echo $date .' '. $month;
                                                  } elseif($time == 'Month(s)') {
                                                       echo $date .' '. $months;
                                                  } elseif($time == 'Year(s)' && $date == '1') {
                                                       echo $date .' '. $year;
                                                  } elseif($time == 'Year(s)') {
                                                       echo $date .' '. $years;
                                                  }
                                             } else {
                                                  _e('N/A', 'ct-membership-packages');
                                             } ?>

                                        </li>
                                        
                                        <li class="pack_listing_<?php echo get_the_ID() ?>" listing="<?php if($listing != ''){ echo $listing;} else { echo "Unlimited"; } ?>"><i class="fa fa-check" aria-hidden="true"></i><b><?php if($listing != ''){ echo $listing;} else { echo "Unlimited"; } ?></b> <?php if($listing == '1') { _e('Listing', 'ct-membership-packages'); } else { _e('Listings', 'ct-membership-packages'); } ?></li>  
                                        
                                        <li class="pack_featured_listing_<?php echo get_the_ID() ?>" featured_listing="<?php if($featured_listing != ''){ echo $featured_listing;} else{ echo "Unlimited"; } ?>"><i class="fa fa-check" aria-hidden="true"></i><b><?php if($featured_listing != ''){ echo $featured_listing;} else{ echo "Unlimited"; } ?></b> <?php _e('Featured Listings', 'ct-membership-packages'); ?></li>
                                        
                                        <input type="hidden" value="<?php echo $recurring;?>" class="pack_recurring_<?php echo get_the_ID() ?>" recurring="<?php echo $recurring;?>"/>
                                   </ul>
                                   <?php
                                   if($ct_currency_placement == 'after') { ?>
                                        <button class="selected-package_<?php echo get_the_ID() ?>" id="<?php echo get_the_ID() ?>"><?php _e('Get Started', 'ct-membership-packages'); ?> - <?php echo $price; ?><?php ct_currency(); ?></button>
                                   <?php } else { ?>
                                        <button class="selected-package_<?php echo get_the_ID() ?>" id="<?php echo get_the_ID() ?>"><?php _e('Get Started', 'ct-membership-packages'); ?> - <?php ct_currency(); ?><?php echo $price; ?></button>
                                   <?php } ?>
                              </div>
                              <script>
                              jQuery(document).ready(function($) {
                                    $('.selected-package_<?php echo get_the_ID() ?>').click(function(){
                                         var title = $(".pack_title_<?php echo get_the_ID() ?>").attr('packtitle');     
                                         var packid = "<?php echo get_the_ID() ?>";  
                                         var current_user_email = "<?php echo $current_user_email; ?>";  
                                         var current_user_id = "<?php echo $current_user_id; ?>";   
                                         var price = $(".price_<?php echo get_the_ID() ?>").attr('packprice');
                                         var price1 = $(".price_<?php echo get_the_ID() ?>").attr('packprice1');
                                         var time = $(".pack_time_<?php echo get_the_ID() ?>").attr('packtime');                             
                                         var recurring = $(".pack_recurring_<?php echo get_the_ID() ?>").attr('recurring');
                                         var listing = $(".pack_listing_<?php echo get_the_ID() ?>").attr('listing');
                                         var featured_listing = $(".pack_featured_listing_<?php echo get_the_ID() ?>").attr('featured_listing');
                                         var pack_date = $(".pack_time_<?php echo get_the_ID() ?>").attr('pack_date');
                                         var pack_time = $(".pack_time_<?php echo get_the_ID() ?>").attr('pack_time');
                                         var paypalMerchantEmail1 = "<?php echo $paypalMerchantEmail; ?>";
                                         var paypalUrlmode = "<?php echo $paypalUrlmode; ?>";  
                                         var pack_currency = "<?php echo ct_currency(); ?>";
                                         var currency_placement = "<?php echo $ct_currency_placement; ?>";
                                         var currency_code11 = "<?php echo $adminCurrencyCode1; ?>";
                                         var currency_sign1 = "<?php echo $adminCurrencySign; ?>";
                                        if(price1 == 0){
                                             var data = {
                                                  action: 'packages_free_action',
                                                  current_user_email: current_user_email,
                                                  current_user_id: current_user_id,
                                                  title: title,
                                                  time: time,
                                                  packid: packid,
                                                  price: price,
                                                  price1: price1,
                                                  listing: listing,
                                                  recurring: recurring,
                                                  featured_listing: featured_listing,
                                                  pack_date: pack_date,
                                                  pack_time: pack_time,
                                                  paypalMerchantEmail1: paypalMerchantEmail1,
                                                  paypalUrlmode: paypalUrlmode,
                                                  pack_currency: pack_currency,
                                                  currency_placement: currency_placement

                                             };
                                             $('#loadingmessage').show();
                                             $.ajax({
                                                  type: 'POST',
                                                  url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                                                  data: data,
                                                  success: function(response) { 
                                                        if(response !=""){                                                   
                                                            $(".response").html('').html(response);
                                                            $(".tablinks").removeClass('active');
                                                            $(".tablinks:nth-child(3)").addClass('active')
                                                            $(".tabcontent").css('display','none');
                                                            $("#Done").css('display','block'); 
                                                            $('#loadingmessage').hide();
                                                        }
                                                       else{
                                                            console.log('empty');    
                                                       }    
                                                  }
                                             })
                                        }
                                        else{
                                             var data = {
                                                  action: 'packages_pass_action',
                                                  current_user_email: current_user_email,
                                                  current_user_id: current_user_id,
                                                  title: title,
                                                  time: time,
                                                  packid: packid,
                                                  price: price,
                                                  price1: price1,
                                                  listing: listing,
                                                  recurring: recurring,
                                                  featured_listing: featured_listing,
                                                  pack_date: pack_date,
                                                  pack_time: pack_time,
                                                  paypalMerchantEmail1: paypalMerchantEmail1,
                                                  paypalUrlmode: paypalUrlmode,
                                                  pack_currency: pack_currency,
                                                  currency_placement: currency_placement,
                                                  currency_code11: currency_code11,
                                                  currency_sign1: currency_sign1
                                                  

                                             };
                                             $('#loadingmessage').show();
                                             $.ajax({
                                                  type: 'POST',
                                                  url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                                                  data: data,
                                                  success: function(response) { 
                                                        if(response !=""){                                                   
                                                            $(".payment-content").html('').html(response);
                                                            $(".tablinks").removeClass('active');
                                                            $(".tablinks:nth-child(2)").addClass('active')
                                                            $(".tabcontent").css('display','none');
                                                            $("#Payment").css('display','block'); 
                                                            $('#loadingmessage').hide();
                                                        }
                                                       else{
                                                            console.log('empty');    
                                                       }    
                                                  }
                                             })
                                        }
                                   });
                              });
                              </script>
                         <?php endwhile; ?>
                              <div class="clear"></div>
                         </div>
                         <div id="Payment" class="tabcontent">
                              <div class="payment-content">
                              </div>
                         </div>

                         <div id="Done" class="tabcontent">
                           <div class="response">
                           </div>
                         </div>
                         <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->
                         <script>
                         jQuery(document).on("click",'.membership',function($){ 
                         
                              var inputid = jQuery('input[class=payment_method]:checked').val();                   
                              var bankTransfer = jQuery('input[id=bankTransfer]:checked').val();    

                              if(inputid == 'paypal'){
                                   var pack_title1 = jQuery(".pack_title").val();
                                   var pack_price1 = jQuery(".pack_price").val();    
                                   var pack_id1 = jQuery(".pack_id").val();                                        
                                   var rcurrent_user_email1 = jQuery(".rcurrent_user_email").val();
                                   var rcurrent_user_id1= jQuery(".rcurrent_user_id").val();                                      
                                   var packageExpiredate1 = jQuery(".packageExpiredate").val();                                        
                                   var packageCurrentdate1 = jQuery(".packageCurrentdate").val();   
                                   var recurring_value_paypal = jQuery(".recurring_value").val();   
                                   var currency_code11 = "<?php echo $adminCurrencyCode1; ?>";
                                   var currency_sign1 = "<?php echo $adminCurrencySign; ?>";
                                   var paypaldata = {
                                        action: 'paypalPayment_pass_action',
                                        pack_title1: pack_title1,
                                        pack_price1: pack_price1,
                                        rcurrent_user_email1: rcurrent_user_email1,
                                        rcurrent_user_id1: rcurrent_user_id1,
                                        currency_code11: currency_code11,
                                        pack_id1: pack_id1,
                                        packageExpiredate1: packageExpiredate1,
                                        packageCurrentdate1: packageCurrentdate1,
                                        currency_sign1: currency_sign1,
                                        recurring_value_paypal: recurring_value_paypal
                                   };
                                   
                                   jQuery.ajax({
                                        type: 'POST',
                                        url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                                        data: paypaldata,
                                        success: function(response) {
                                             //if(response != 0){
                                                  console.log(response);
                                                  
                                                  jQuery(".paypal_itemnumber").val(response);
                                                  jQuery(".return_url").val(jQuery(".return_url").val()+response+"&");
                                                  
                                                  jQuery(".paymentform").submit();
                                             //}
                                        }
                                   });
                                   return false;
                              }
                              
                              if(inputid == 'stripe'){           
                                   var stripecheck = jQuery('input[class=stripe-recurring]:checked').val();
                                   var pack_title = jQuery(".pack_title").val();
                                   var pack_price = jQuery(".pack_price").val();
                                   var pack_id = jQuery(".pack_id").val();
                                   var rcurrent_user_email = jQuery(".rcurrent_user_email").val();
                                   var rcurrent_user_id = jQuery(".rcurrent_user_id").val();
                                   var package_time = jQuery(".package_time").val();
                                   var recurring_value_stripe = jQuery(".recurring_value").val();   
                                   var currency_code1 = "<?php echo $adminCurrencyCode1; ?>";
                                   var admin_email = "<?php echo $admin_email; ?>";                                
                                   var stripeSecertkey1 = "<?php echo $stripeSecertkey; ?>";
                                   var currency_sign = "<?php echo $adminCurrencySign; ?>";                                       
                                   var cardNumber = jQuery('.cardNumber').val();
                                   var expDate = jQuery('.expDate').val();
                                   var expYear = jQuery('.expYear').val();
                                   var cardcvv = jQuery('.cardcvv').val();
                                   
                                   //alert(stripeSecertkey1);
                                   
                                   if(expDate == 'Month'){
                                        jQuery('span.form_error_month').text('*Please Select a vaild option');
                                        jQuery('.form-control.expDate').css('box-shadow','0 0 1.5px 1px #ff0000');
                                        return false;
                                   }
                                   if(!cardNumber){
                                        jQuery('span.form_error_cardnumber').text('*Please fill out the details');
                                        jQuery('.form-control.cardNumber').css('box-shadow','0 0 1.5px 1px #ff0000');
                                        return false;
                                   }                        
                                   if(!cardcvv){
                                        jQuery('span.form_error_cardcvv').text('*Please fill out the details');
                                        jQuery('.form-control.cardcvv').css('box-shadow','0 0 1.5px 1px #ff0000');
                                        return false;
                                   }
                                   var data1 = {
                                             action: 'payment_pass_action',
                                             stripecheck: stripecheck,
                                             rcurrent_user_email: rcurrent_user_email,
                                             rcurrent_user_id: rcurrent_user_id,
                                             package_time: package_time,
                                             currency_code1: currency_code1,
                                             cardNumber: cardNumber,
                                             expDate: expDate,
                                             pack_id: pack_id,
                                             pack_title: pack_title,
                                             pack_price: pack_price,
                                             expYear: expYear,
                                             cardcvv: cardcvv,
                                             admin_email: admin_email,
                                             stripeSecertkey1: stripeSecertkey1,
                                             currency_sign: currency_sign,
                                             recurring_value_stripe: recurring_value_stripe
                                        };
                                             
                                        jQuery('#loadingmessage').show();
                                         jQuery.ajax({
                                             type: 'POST',
                                             url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                                             data: data1,
                                             success: function(response) { 
                                                  if(response != ""){
                                                       console.log(response);
                                                       jQuery(".response").html('').html(response);
                                                       jQuery(".tablinks").removeClass('active');
                                                       jQuery(".tablinks:nth-child(3)").addClass('active')
                                                       jQuery(".tabcontent").css('display','none');
                                                       jQuery("#Done").css('display','block'); 
                                                       jQuery('#loadingmessage').hide();
                                                  }
                                                  else{
                                                       jQuery(".tablinks").removeClass('active');
                                                       jQuery(".tablinks:nth-child(2)").addClass('active')
                                                       jQuery(".tabcontent").css('display','none');
                                                       jQuery("#Payment").css('display','block'); 
                                                       jQuery('#loadingmessage').hide();
                                                  }
                                                  
                                             } 
                                        })
                                        return false;
                                   }

                                   if(inputid == 'bankTransfer'){
                                        var pack_title2 = jQuery(".pack_title").val();
                                        var pack_price2 = jQuery(".pack_price").val();    
                                        var pack_id2 = jQuery(".pack_id").val();          
                                        var recurring_value_bank = jQuery(".recurring_value").val();                                             
                                        var rcurrent_user_email2 = jQuery(".rcurrent_user_email").val();
                                        var rcurrent_user_id2= jQuery(".rcurrent_user_id").val();                                      
                                        var packageExpiredate2 = jQuery(".packageExpiredate").val();                                        
                                        var packageCurrentdate2 = jQuery(".packageCurrentdate").val(); 
                                        var bankaccountNumber =jQuery(".bankaccountNumber").val(); 
                                        var currency_code2 = "<?php echo $adminCurrencyCode1; ?>";  
                                        var admin_email2 = "<?php echo $admin_email; ?>";
                                        var currency_sign2 = "<?php echo $adminCurrencySign; ?>";
               
                                        
                                        var bankData = {
                                             action: 'bankPayment_pass_action',
                                             pack_title2: pack_title2,
                                             pack_price2: pack_price2,
                                             pack_id2: pack_id2,
                                             rcurrent_user_email2: rcurrent_user_email2,
                                             rcurrent_user_id2: rcurrent_user_id2,
                                             packageExpiredate2: packageExpiredate2,
                                             packageCurrentdate2: packageCurrentdate2,
                                             currency_code2: currency_code2,
                                             bankaccountNumber: bankaccountNumber,
                                             admin_email2: admin_email2,
                                             currency_sign2: currency_sign2,
                                             recurring_value_bank: recurring_value_bank
                                        };
                                        
                                        jQuery('#loadingmessage').show();
                                          jQuery.ajax({
                                             type: 'POST',
                                             url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                                             data: bankData,
                                             success: function(response) { 
                                                  if(response != 0){
                                                       console.log(response);
                                                       jQuery(".response").html('').html(response);
                                                       jQuery(".tablinks").removeClass('active');
                                                       jQuery(".tablinks:nth-child(3)").addClass('active')
                                                       jQuery(".tabcontent").css('display','none');
                                                       jQuery("#Done").css('display','block'); 
                                                       jQuery('#loadingmessage').hide();
                                                  }
                                                  else{
                                                       jQuery(".tablinks").removeClass('active');
                                                       jQuery(".tablinks:nth-child(2)").addClass('active')
                                                       jQuery(".tabcontent").css('display','none');
                                                       jQuery("#Payment").css('display','block'); 
                                                       jQuery('#loadingmessage').hide();
                                                  }
                                                  
                                             }
                                        }) 
                                   }    
                                   
                                   
               
                                   if(inputid == 'wecashup'){
                                        var pack_title1 = jQuery(".pack_title").val();
                                        var pack_price1 = jQuery(".pack_price").val();    
                                        var pack_id1 = jQuery(".pack_id").val();                                        
                              
                                        var packageExpiredate1 = jQuery(".packageExpiredate").val();                                        
                                        var packageCurrentdate1 = jQuery(".packageCurrentdate").val();   
                                        var currency_code11 = "<?php echo $adminCurrencyCode1; ?>";
                                        var currency_sign1 = "<?php echo $adminCurrencySign; ?>";
                                        var paypaldata = {
                                             
                                             pack_title1: pack_title1,
                                             pack_price1: pack_price1,
                                             rcurrent_user_email1: rcurrent_user_email1,
                                             rcurrent_user_id1: rcurrent_user_id1,
                                             currency_code11: currency_code11,
                                             pack_id1: pack_id1,
                                             packageExpiredate1: packageExpiredate1,
                                             packageCurrentdate1: packageCurrentdate1,
                                             currency_sign1: currency_sign1
                                        };
                                        
                                   

                                        return false;
                                   }



                              });
                    </script>
               </div>
          </div>




<?php 
      } elseif($today < $packExpire_date){
          echo '<div class="inner-content">';
          echo '<div class="must-be-logged-in">';
                    echo '<h4 class="center marB20">' . __('You currently have an active package.', 'ct-membership-packages') . '</h4>';
                    echo '<p class="center login-register-btn marB0"><a class="btn" href="'.get_site_url()."/membership".'">' . __('Go to Details', 'ct-membership-packages') . '</a>
                    <a class="btn btn-tertiary marL10" href="'.get_site_url()."/package-list?package=update".'">' . __('Upgrade Package', 'ct-membership-packages') . '</a></p>';
               echo '</div>';
          echo '</div>';
     } 
} else {
     echo '<div class="inner-content">';
     echo '<div class="must-be-logged-in">';
               echo '<h4 class="center marB20">You must be logged in to view this page.</h4>';
              echo '<p class="center login-register-btn marB0"><a class="btn login-register" href="#">' . __('Login/Register', 'ct-membership-packages') . '</a></p>';
          echo '</div>';
     echo '</div>';
}?>

<script>
jQuery(document).on("click",'.payment_method',function(){        
     var Button = jQuery(this).val();
     //var paypalUrl= "<?php echo 'https://www.sandbox.paypal.com/cgi-bin/webscr'; ?>";
     //console.log(paypalUrl);
     if(Button == 'stripe'){                 
          jQuery(".stripe-form").slideDown('slow');
          jQuery('.paymentform').attr('id','payment-form');
          
     }else{
          jQuery(".stripe-form").slideUp('slow');
          jQuery('.paymentform').attr('id','');
          
     }
                    
     if(Button == 'paypal-recurring'){                 
          console.log(Button+'pay-rec');                     
     }
     if(Button == 'paypal'){                 
           jQuery(".paypal-recurring").slideDown('slow');
           
     }else{
          jQuery(".paypal-recurring").slideUp('slow');
     }    
     


     if(Button == 'wecashup'){                    
           jQuery(".wecashup-recurring").slideDown('slow');
           
     }else{
          jQuery(".wecashup-recurring").slideUp('slow');
     }    
     


     if(Button == 'bankTransfer'){ 
          jQuery(".directbank_transfer").slideDown('slow');
     }else{
          jQuery(".directbank_transfer").slideUp('slow');
     }              
          
});

function openCity(evt, cityName) { 
     var i, tabcontent, tablinks;
     tabcontent = document.getElementsByClassName("tabcontent");
     for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
     }
     tablinks = document.getElementsByClassName("tablinks");
     for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
     }
     document.getElementById(cityName).style.display = "block";
     evt.currentTarget.className += " active";
}

</script>  
<?php
     }
}
add_shortcode('packages','ct_frontend_packages');

//Packages thank you page
add_shortcode('packages-thankyou','ct_packages_thankyou_callback');
if(!function_exists('ct_packages_thankyou_callback')){
     function ct_packages_thankyou_callback() {
          include('paypal/success.php');          
     }
}
//Create custom page
if(!function_exists('ct_add_custom_page')){  
     
     $author_id = 1;

     function ct_add_custom_page() {
          
          // Packages page
          $pagetitle = get_page_by_title('Packages');
          if(empty($pagetitle)){
          // Create post object
               $packages_page = array(
                 'post_title'      => wp_strip_all_tags( 'Packages' ),
                 'post_name'       => 'package-list',
                 'post_content'    => '[packages]',
                 'post_status'     => 'publish',
                 'post_author'     => $author_id,
                 'post_type'       => 'page',
                 'page_template'   => 'template-full-width.php'
               );

               // Insert the post into the database
               wp_insert_post( $packages_page );
          }

          // Packages thank you page
          $pagetitle = get_page_by_title('Packages Thank You');
          if(empty($pagetitle)){
          // Create post object
               $packages_thank_you_page = array(
                 'post_title'      => wp_strip_all_tags( 'Packages Thank You' ),
                 'post_content'    => '[packages-thankyou]',
                 'post_status'     => 'publish',
                 'post_author'     => $author_id,
                 'post_type'       => 'page',
                 'page_template'   => 'template-packages-thank-you.php'
               );

               // Insert the post into the database
               wp_insert_post( $package_page );
          }
          
          // Packges Membership Page
          $the_pagetitle = get_page_by_title('Membership');
          if(empty($the_pagetitle)){
          // Create post object
               $package_membership_page = array(
                 'post_title'      =>   wp_strip_all_tags( 'Membership' ),
                 'post_content'    =>   '[packages_orderdata]',
                 'post_status'     =>   'publish',
                 'post_author'     =>   $author_id,
                 'post_type'       =>   'page',
                 'page_template'   =>   'template-membership.php'
               );

               // Insert the post into the database
               wp_insert_post($package_membership_page);
          }

          // Packges Invoice Page
          $the_pagetitle = get_page_by_title('Invoices');
          if(empty($the_pagetitle)){
          // Create post object
               $package_invoices_page = array(
                 'post_title'      =>   wp_strip_all_tags( 'Invoices' ),
                 'post_content'    =>   '',
                 'post_name'       => 'view-invoices',
                 'post_status'     =>   'publish',
                 'post_author'     =>   $author_id,
                 'post_type'       =>   'page',
                 'page_template'   =>   'template-view-invoices.php'
               );

               // Insert the post into the database
               wp_insert_post($package_invoices_page);
          }
     }
}
register_activation_hook(__FILE__, 'ct_add_custom_page');

// Free trial
add_action('wp_ajax_packages_free_action', 'ct_packages_free_callback');
add_action('wp_ajax_nopriv_packages_free_action', 'ct_packages_free_callback');
if (!function_exists('ct_packages_free_callback')) {
function ct_packages_free_callback(){
     session_start();
     global $ct_options;
     global $current_user;
     $_SESSION['packages'] =  $_POST;   

     $user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';

    $ct_logo = isset( $ct_options['ct_logo']['url'] ) ? esc_html( $ct_options['ct_logo']['url'] ) : '';
    $ct_logo_highres = isset( $ct_options['ct_logo_highres']['url'] ) ? esc_html( $ct_options['ct_logo_highres']['url'] ) : '';
    $ct_email_alerts_footer_company_info = isset($ct_options['ct_email_alerts_footer_company_info']) ? $ct_options['ct_email_alerts_footer_company_info'] : '' ;
     
     $user_id = $current_user->ID;
     $admin_email = get_option('admin_email');              
     $pack_title = $_POST['title'];
     $pack_price = $_POST['price1'];
     $pack_id = $_POST['packid'];
     $pack_time = $_POST['time'];
     $current_user_email = $_POST['current_user_email'];    
     $current_user_id = $_POST['current_user_id'];     
     $recurring = $_POST['recurring'];  
     $packageCurrentdate = date("Y-m-d");         
     $packageExpiredate = date("Y-m-d", strtotime(($packageCurrentdate)."+".$pack_time));
     if($recurring == 1){
          $pack_recurring = "Yes";
     }
     else{
          $pack_recurring = "No";
     }
     
     $CreateOrder = new CreateOrder();
     
     $post["post_title"] = "Order ".$pack_title.'-'.$packageCurrentdate;   
     $post["package_name"] = $pack_title;    
     $post["post_type"] = "package_order";
     $post['post_author']   = $user_id;
     $post["packageID"] = $pack_id;
     $post["post_status"] = "publish";
     $post["current_user_email"] = $current_user_email;
     $post["payment_amount"] = $pack_price;  
     $post["package_current_date"] = $packageCurrentdate;   
     $post["package_expire_date"] = $packageExpiredate;     
     $post["current_user_id"] = $user_id;    
     $post["order_status"] = 1;    
     $post["pack_recurring"] = $pack_recurring;   
     
     $freeorder_id = $CreateOrder->getRequiredContents($post);
     $freeorder_id = $CreateOrder->getRequiredContents($post,$freeorder_id );
     
     if($freeorder_id){
          $html.='<div class="email-data">
                         <h3 id="thanks" class="marT20">' . __('Thanks for your purchase!', 'ct-membership-packages') . '</h3>
                         <h5>' . __('Order Details:', 'ct-membership-packages') . '</h5>
                         <p class="marB0">' . __('Package Name:', 'ct-membership-packages') . ' ' . $pack_title.'</p>                            
                         <p class="marB0">' . __('Payment Method: Free', 'ct-membership-packages') . '</p>                             
                         <p class="marB0">' . __('Amount:', 'ct-membership-packages') . ' ' . $pack_price.'</p>
                         <p class="marB20">' . __('User email:', 'ct-membership-packages') . ' ' . $current_user_email.'</p>

                         <p class="marB20"><a class="btn" href="' . get_page_link($user_listings) . '">' . __('View Your Listings', 'ct-membership-packages') . '</a></p>
                    </div>';
          echo $html;
          $to = array($admin_email,$current_user_email);
          $subject = 'New Packages Order!';
          $body = '<table border="0">';
               if(!empty($ct_options['ct_logo']['url'])) {
                  $body = '<div style="text-align: center; background-color:#29333d; padding: 16px 0;">
                            <a href="'. esc_url(home_url()) . '"><img class="logo left" src="' . esc_url($ct_logo) . '" srcset="' . esc_url($ct_logo_highres) . ' 2x" /></a>
                        </div>';
              }

              $body .= '<div style="padding-top: 30px; padding-bottom: 30px; font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;">

                        <div style="width: 640px; background-color:#ffff; margin: 0 auto;">
                            ' . __('Order Details:', 'ct-membership-packages') . '
                        </div>
                    </div>';

            $body .= '<div style="background-color: #F6F6F6; padding: 30px;">
                        <div style="margin: 0 auto; width: 620px; background-color: #fff;border:1px solid #eee; padding:30px;">
                            <div style="font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;font-size:100%;line-height:1.6em;display:block;max-width:600px;margin:0 auto;padding:0">';

                    $body .= '<table border="0">
                              <tr>
                                   <td>' . __('Payment Method:', 'ct-membership-packages') . '</td>
                                   <td>' . __('Free', 'ct-membership-packages') . '</td>
                              </tr>
                              <tr>
                                   <td>' . __('Package Name:', 'ct-membership-packages') . '</td>
                                   <td>'.$pack_title.'</td>
                              </tr>                                        
                              <tr>
                                   <td>' . __('User Email:', 'ct-membership-packages') . '</td>
                                   <td>' . $current_user_email . '</td>
                              </tr>
                              <tr><td>' . __('No need for any action this is just a notification.', 'ct-membership-packages') . '</td></tr> 
                         </table>';

               $body .= '</div>
                        </div>
                    </div>';

            $body .= '<div style="padding-top: 30px; padding-bottom: 30px; font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;">

                        <div style="width: 640px; background-color:#ffff; margin: 0 auto;">
                            ' . __('You\'re receiving this email because you purchased a listings package from ', 'ct-membership-packages') . $_SERVER['HTTP_HOST'] . '
                        </div>
                    </div>';

            if(!empty($ct_email_alerts_footer_company_info)) {
                  $body .= '<div style="padding-top: 30px; padding-bottom: 30px; font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;">

                                  <div style="width: 640px; background-color:#ffff; margin: 0 auto;">
                                      ' . $ct_email_alerts_footer_company_info . '
                                  </div>
                              </div>';
              }
               
               $headers = 'From: No Reply <noreply@' . $_SERVER['HTTP_HOST'] . '>';
              $headers .= 'MIME-Version: 1.0';
              $headers .= 'Content-Type: text/html; charset=UTF-8';

               wp_mail( $to, $subject, $body, $headers ); 
     }
     else{
          echo "0";
     }
     die;
     
}
}

//Set session for Post to pass data to next tab
add_action('wp_ajax_packages_pass_action', 'ct_packages_callback');
add_action('wp_ajax_nopriv_packages_pass_action', 'ct_packages_callback');
if (!function_exists('ct_packages_callback')) {
function ct_packages_callback(){
     session_start();
     $_SESSION['packages'] =  $_POST;

     $html = "";
     
     global $ct_options;
     
     $ct_currency_placement = $ct_options['ct_currency_placement'];
     $wire_transfer_enable = $ct_options['ct_enable_wire_transfer'];
     $paypal_enable = $ct_options['ct_enable_paypal'];
     $wecashup_enable = $ct_options['ct_enable_wecashup'];
     $stripe_enable = $ct_options['ct_enable_stripe'];
     $terms_conditions = isset( $ct_options['ct_terms_conditions'] ) ? esc_html( $ct_options['ct_terms_conditions'] ) : '';
     $wiretransfer = isset( $ct_options['ct_wire_transfer_account_number'] ) ? esc_html( $ct_options['ct_wire_transfer_account_number'] ) : 'N/A';
     $pack_currency = isset($_SESSION['packages']['pack_currency']) ? $_SESSION['packages']['pack_currency'] : 'N/A';
     $price = isset($_SESSION['packages']['price1']) ? $_SESSION['packages']['price1'] : 'N/A';               
     $currency_placement = isset($_SESSION['packages']['currency_placement']) ? $_SESSION['packages']['currency_placement'] : 'N/A';
     $rtitle = isset($_SESSION['packages']['title']) ? $_SESSION['packages']['title'] : 'N/A'; 
     $rcurrent_user_email = isset($_SESSION['packages']['current_user_email']) ? $_SESSION['packages']['current_user_email'] : 'N/A'; 
     $rcurrent_user_id = isset($_SESSION['packages']['current_user_id']) ? $_SESSION['packages']['current_user_id'] : 'N/A'; 
     $rpackid = isset($_SESSION['packages']['packid']) ? $_SESSION['packages']['packid'] : 'N/A'; 
     $rtime = isset($_SESSION['packages']['time']) ? $_SESSION['packages']['time'] : 'N/A';
     $rlisting = isset($_SESSION['packages']['listing']) ? $_SESSION['packages']['listing'] : 'N/A';
     $rfeatured_listing = isset($_SESSION['packages']['featured_listing']) ? $_SESSION['packages']['featured_listing'] : 'N/A';
     $rprice = isset($_SESSION['packages']['price']) ? $_SESSION['packages']['price'] : 'N/A';
     $paypalprice = isset($_SESSION['packages']['price1']) ? $_SESSION['packages']['price1'] : 'N/A';
     $pack_date = isset($_SESSION['packages']['pack_date']) ? $_SESSION['packages']['pack_date'] : 'N/A';     
     $pack_time = isset($_SESSION['packages']['pack_time']) ? $_SESSION['packages']['pack_time'] : 'N/A';
     $paypalMerchantEmail1 = isset($_SESSION['packages']['paypalMerchantEmail1']) ? $_SESSION['packages']['paypalMerchantEmail1'] : 'N/A';
     $paypalUrlmode = isset($_SESSION['packages']['paypalUrlmode']) ? $_SESSION['packages']['paypalUrlmode'] : 'N/A';
     $recurring_value = $_SESSION['packages']['recurring'];
     $currency_sign1 = $_SESSION['packages']['currency_sign1'];
     $currency_code1 = $_SESSION['packages']['currency_code11'];
     
     $paypalId = $paypalMerchantEmail1;
     
     if($paypalUrlmode == 'live'){
          $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
     }
     
     if($paypalUrlmode == 'sandbox'){
          $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
     } 
     
     $adminCurrencyCode = $ct_id['ct_currency_code'];
     
     //Paypal-recurring
     //$total_cycle = $_POST['select_cycles'];
     if($pack_date == 'N/A'){
          $pack_date = 1;
     }
     if($pack_time == 0){
          $cycle_amount = $paypalprice;
          $cycle = 'M';
     }

     $time_day = 'Day(s)';
     $time_week = 'Week(s)';
     $time_month = 'Month(s)';
     $time_year = 'Year(s)';

     if ($pack_time == $time_day) {
          $cycle_amount = $paypalprice;
          $cycle = 'D';
     } else if ($pack_time == $time_week) {
          $cycle_amount = $paypalprice;
          $cycle = 'W';
     } else if ($pack_time == $time_month) {
          $cycle_amount = $paypalprice;
          $cycle = 'M';
     } else if ($pack_time == $time_year) {
          $cycle_amount = $paypalprice;
          $cycle = 'Y';
     }
     
          $packageCurrentdate = date("Y-m-d");
          if($rpackage_time == 'N/A'){
               $packageExpiredate = date("Y-m-d", strtotime(($packageCurrentdate)."+1000 year"));   
          }
          else{
               $packageExpiredate = date("Y-m-d", strtotime(($packageCurrentdate)."+".$rtime));     
          }
     ?>
     
     <script>
     var paypal_payment = '<input type="hidden" name="business" value="<?php echo $paypalId ?>"><input type="hidden" name="cmd" value="_xclick"><input type="hidden" name="item_number" class="paypal_itemnumber" value=""><input type="hidden" name="no_shipping" value="1"><input type="hidden" name="currency_code" value="<?php echo $currency_code1 ?>"><input type="hidden" name="notify_url" value="<?php echo home_url().'/packages-thank-you' ?>"><input type="hidden"  name="return" value="<?php echo home_url().'/packages-thank-you' ?>">';
                         
     var paypal_recurring = '<input type="hidden" name="cmd" value="_xclick-subscriptions"><input type = "hidden" name = "business" value="<?php echo $paypalId ?>"><input type="hidden" name="item_number" class="paypal_itemnumber" value=""><input type="hidden" name="no_note" value="1"><input type="hidden" name="src" value="1"><input type="hidden" name="a3" value="<?php echo $cycle_amount ?>"><input type="hidden" name="p3" value="<?php echo $pack_date ?>"><input type="hidden" name="t3" value="<?php echo $cycle ?>"><input type="hidden" name="currency_code" value="<?php echo $currency_code1 ?>"><input type = "hidden" name = "cancel_return" value = ""><input type="hidden" name="notify_url" value="<?php echo home_url().'/packages-thank-you' ?>"><input class="return_url"  type="hidden" name ="return" value="<?php echo home_url().'/packages-thank-you/?order_id=' ?>"><input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest">';
     
     jQuery(document).on("click", ".paypalRecurring", function(){          
          if(jQuery(this).is(':checked')){
               jQuery(".pay-rec").html('').html(paypal_recurring);              
          }else{
               jQuery(".pay-rec").html('').html(paypal_payment);
          }
     });
     jQuery(document).on("click", "#paypalbutton", function(){        
     
          jQuery(".pay-rec").html('').html(paypal_payment);
          
     });
     
     </script>
     <?php
//echo $pack_price = $currency_sign.$price;
     /* echo $ct_currency_placement;
     echo "1111"; */
     $html.= '<h3 class="marB0">' . __('Payment Method', 'ct-membership-packages') . '</h3>
          <p class="muted marB20">' . __('All transactions are secure and encrypted. Credit card information is never stored.', 'ct-membership-packages') . '</p>

          <div class="payment-block-left col span_9 first">                     
          
               <form action='.$paypalURL.' class="form-horizontal paymentform" method="POST" id="">
               <!--extra for stripe-->
               <input type="hidden" name="item_name" value="'.$rtitle.'" class="pack_title">
               <input type="hidden" name="amount" value="'.$paypalprice.'" class="pack_price">
               <input type="hidden" name="rpackid" value="'.$rpackid.'" class="pack_id">  
               <input type="hidden" name="rcurrent_user_email" value="'.$rcurrent_user_email.'" class="rcurrent_user_email"> 
               <input type="hidden" name="rcurrent_user_id" value="'.$rcurrent_user_id.'" class="rcurrent_user_id">
               <input type="hidden" name="package_time" value="'.$rtime.'" class="package_time">
               <input type="hidden" name="packageCurrentdate" value="'.$packageCurrentdate.'" class="packageCurrentdate">
               <input type="hidden" name="packageExpiredate" value="'.$packageExpiredate.'" class="packageExpiredate">
               <input type="hidden" name="recurring_value" value="'.$recurring_value.'" class="recurring_value">
               <div class="pay-rec"></div>
               <div class="payment-methods-container">
                    <ul class="payment-methods">';


                    if($paypal_enable == 'yes'){
                         $html.= '<li>
                              <div class="col span_11">
                                   <input type="radio" name="payment_method[]" value="paypal" class="payment_method" id="paypalbutton" />
                                   <div class="col span_6">
                                        <img class="left" src="'. plugins_url('assets/images/paypal-logo.png',__FILE__).'" srcset="'. plugins_url('assets/images/paypal-logo@2x.png',__FILE__).' 2x" />
                                   </div>
                              </div>';
                         if($recurring_value == 1){    
                              $html.= '<div class="paypal-recurring col span_12 first" style="display:none;">
                                        <input type="checkbox" name="payment_method[]" value="paypal-recurring" class="paypalRecurring"/>
                                        <div class="left">
                                             ' . __('Set as recurring payment', 'ct-membership-packages') . '                                              
                                        </div>
                                   </div>';
                              }
                    
                         $html.='</li>';     
                    }         
                              
                    if($stripe_enable == 'yes'){  
                    $html.= '<li>
                              <div class="col span_11">
                                   <input type="radio" name="payment_method[]" value="stripe" id="stripebutton" class="payment_method" />
                                   <div class="col span_6">
                                        <img class="left" src="'. plugins_url('assets/images/stripe-logo.png',__FILE__).'" srcset="'. plugins_url('assets/images/stripe-logo@2x.png',__FILE__).' 2x" />
                                   </div>
                                   <div class="col span_5">
                                        <img id="stripe-cc-icons" class="right" src="'. plugins_url('assets/images/cc.png',__FILE__).'" srcset="'. plugins_url('assets/images/cc@2x.png',__FILE__).' 2x" />
                                   </div>
                              </div>';
                         
                              $html.='<div class="stripe-form col span_12 first" style="display:none;">                                     
                                   <fieldset>';                                                     
                                   $html.='<div class="form-group">
                                             <label for="accountNumber">' . __('Card Number', 'ct-membership-packages') . '</label>
                                             <input type="text" class="cardNumber" size="20" data-stripe="number" value="" required>
                                             <span class="form_error_cardnumber"></span>
                                        </div>
                                        <div class="form-group">
                                             <label for="expirationMonth">' . __('Expiration Date', 'ct-membership-packages') . '</label>
                                             <div class="col span_6 first">
                                                  <select class="form-control expDate col-sm-3" data-stripe="exp_month" required>
                                                       <option>Month</option>
                                                       <option value="01">Jan (01)</option>
                                                       <option value="02">Feb (02)</option>
                                                       <option value="03">Mar (03)</option>
                                                       <option value="04">Apr (04)</option>
                                                       <option value="05">May (05)</option>
                                                       <option value="06">June (06)</option>
                                                       <option value="07">July (07)</option>
                                                       <option value="08">Aug (08)</option>
                                                       <option value="09">Sep (09)</option>
                                                       <option value="10">Oct (10)</option>
                                                       <option value="11">Nov (11)</option>
                                                       <option value="12" selected="">Dec (12)</option>
                                                  </select>
                                                       <span class="form_error_month"></span>
                                             </div>
                                             <div class="col span_6">
                                                  <select class="form-control expYear" data-stripe="exp_year">
                                                       <option value="17">2017</option>
                                                       <option value="18">2018</option>
                                                       <option value="19">2019</option>
                                                       <option value="20" selected="">2020</option>
                                                       <option value="21">2021</option>
                                                       <option value="22">2022</option>
                                                       <option value="23">2023</option>
                                                       <option value="23">2024</option>
                                                       <option value="23">2025</option>
                                                       <option value="23">2026</option>
                                                       <option value="23">2027</option>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="cvNumber">' . __('Card CVV', 'ct-membership-packages') . '</label>
                                             <input type="text" class="form-control cardcvv" data-stripe="cvc" value="123">
                                             <span class="form_error_cardcvv"></span>
                                        </div>';

                                        if($recurring_value == 1){    
                                             $html.='<div class="col span_12 first">
                                                            <input type="checkbox" name="payment_method[]" value="stripe-recurring" class="stripe-recurring marT10" />
                                                            <div class="left pad0">
                                                                 ' . __('Set as recurring payment', 'ct-membership-packages') . '                                              
                                                            </div>                                       
                                                       </div>';
                                        }

                                   $html.='</fieldset>
                              
                              </div>
                              
                              
                         </li>';
                    }
                         if($wire_transfer_enable == 'yes'){
                         $html.='<li id="direct-bank-transfer">
                              <div class="col span_11">
                                   <div class="col span_10 first">
                                        <input type="radio" name="payment_method[]" value="bankTransfer" class="payment_method"/>
                                        <div class="col span_6">
                                             <div class="left marL0">
                                                  ' . __('Wire Transfer', 'ct-membership-packages') . '
                                             </div>
                                        </div>
                                   </div>
                                   <div class="directbank_transfer col span_10 first" style="display:none">
                                        <p>' . __('Click the "Complete Membership" button below for wire transfer instructions.', 'ct-membership-packages') . '</p>
                                        <label style="display:none" for="directbankTransfer">' . __('Account Number', 'ct-membership-packages') . '</label>
                                        <input type="text" name="directbankTransfer" value="'.$wiretransfer.'" class="bankaccountNumber" disabled style="display:none">
                                   </div>
                              </div>
                         </li>';
                         }




                         if($wecashup_enable == 'yes'){
                              $html.= '<li>
                                   <div class="col span_11">
                                        <input type="radio" name="payment_method[]" value="wecashup" class="payment_method" id="wecashupbutton" />
                                        <div class="col span_6">
                                             <img class="left" src="'. plugins_url('wecashup/wecashup.png',__FILE__).'" />
                                        </div>
                                   </div>';

                              
                                   $html.= '<div class="wecashup-recurring col span_12 first" style="display:none;">
                                   
                                        <div class="left">
                                             ';

                                             $logo = "";

                                             if(!empty($ct_options['ct_logo']['url'])) { 
                                       $logo = esc_url($ct_options['ct_logo']['url']);
                                    } else {
                                        $logo = get_template_directory_uri()."/images/re7-logo.png";
                                    }



                                   $call_url = admin_url('admin-ajax.php?action=callback_url');
                                   $call_url = str_replace("http://","https://",$call_url);
                                   
                                   $mode = $ct_options["ct_wecashup_mode"];                  
                                   $merchant_uid = $ct_options["ct_wecashup_merchant_UID"];            
                                   $merchant_public_key = $ct_options["ct_wecashup_merchant_public_key"]; 
                                   $merchant_secret = $ct_options["ct_wecashup_merchant_secret_key"];
        



                                             $html.= '
                                             <script language="javascript">
var pack_title1 = jQuery(".pack_title").val();
                                        var pack_price1 = jQuery(".pack_price").val();    
                                        var pack_id1 = jQuery(".pack_id").val();                                        
                              
                                        </script>
                                             <form action="'.$call_url.'" method="POST" id="wecashup">

                                                  <script async src="https://www.wecashup.com/library/MobileMoney.js" class="wecashup_button"
                                                  '.(($mode=="testing")?"data-demo":"").'
                                                  data-sender-lang="en"
                                                  data-sender-phonenumber=""
                                                  data-receiver-uid="'.$merchant_uid.'"
                                                  data-receiver-public-key="'.$merchant_public_key.'"
                                                  data-transaction-parent-uid=""
                                                  data-transaction-receiver-total-amount="'.$paypalprice.'"
                                                  data-transaction-receiver-reference="'.$rpackid.';'.$packageCurrentdate.';'.$packageExpiredate.'"
                                                  data-transaction-sender-reference="'.$rpackid.'"
                                                  data-sender-firstname=""
                                                  data-sender-lastname=""
                                                  data-transaction-method="pull"';

                                                  if ( $logo != "" ) {
                                                       $html.= 'data-image="'.$logo.'"';
                                                  }

                                                  $html.='
                                                  data-name="'.get_bloginfo("name").'"
                                                  data-crypto="true"
                                                  data-cash="true"
                                                  data-telecom="true"
                                                  data-m-wallet="true"
                                                  data-split="true"
                                                  configuration-id="3"
                                                  data-marketplace-mode="false"
                                                  data-product-1-name="'.$rtitle.'"
                                                  data-product-1-quantity="1"
                                                  data-product-1-unit-price="594426"
                                                  data-product-1-reference="'.$rpackid.'"
                                                  data-product-1-category="Real Estate"
                                                  data-product-1-description="'.get_bloginfo("description").'"
                                                  >
                                                  </script>
                                                  </form>';

                                   $html.='                                               
                                        </div>
                                   </div>';
                                        
                         
                              $html.='</li>';     
                         }         
                    
                         

                    $html.='</ul>
                         <div class="clear"></div>
               </div>
               <a class="membership btn" href="#" type="button">' . __('Complete Membership', 'ct-membership-packages') . '</a>';

               if(!empty($terms_conditions)) {
                    $html.='<div class="complete-membership">
                         <p>' . __('By clicking "Complete Membership" you agree to our', 'ct-membership-packages') . '<a href="' . get_page_link($terms_conditions) . '">' . __(' Terms & Conditions', 'ct-membership-packages') . '</a></p>                             
                    </div>';
               }

               $html.='</form>
            </div>
            <div class="payemt-block-right col span_3">
               <h5 class="marB20">' . __('Membership Package', 'ct-membership-packages') . '</h5>
               <ul class="payment-right">
                    <li>
                         <div id="package-type" class="left">
                              '. $rtitle .'
                         </div>
                         <div class="right">
                              <a href="Package" class="change-package">
                                   <span class="payment-right-data muted">change package</span>
                              </a>
                         </div>
                              <div class="clear"></div>
                    </li>
                    <li>
                         <div class="left">' . __('Time Period:', 'ct-membership-packages') . '</div>
                         <div class="right">
                              <span class="payment-right-data">'.$rtime.'</span>
                         </div>
                              <div class="clear"></div>
                    </li>
                    <li>
                         <div class="left">' . __('Listings Included:', 'ct-membership-packages') . '</div>
                         <div class="right">
                              <span class="payment-right-data">'.$rlisting.'</span>
                         </div>
                              <div class="clear"></div>
                    </li>
                    <li>
                          <div class="left">' . __('Featured Listings Included:', 'ct-membership-packages') . '</div>
                          <div class="right">
                              <span class="payment-right-data">'.$rfeatured_listing.'</span>
                          </div>
                              <div class="clear"></div>
                     </li>';
                     if($currency_placement == 'after'){
                         $html .='<li>
                              <div class="left"><strong>' . __('Total:', 'ct-membership-packages') . '</strong></div>
                              <div class="right"> 
                                   <span class="payment-right-data rprice">'.$price.$pack_currency.'</span>
                              </div>
                                   <div class="clear"></div>
                         </li>';
                     }
                     else{
                         $html .='<li>
                              <div class="left"><strong>' . __('Total:', 'ct-membership-packages') . '</strong></div>
                              <div class="right"> 
                                   <span class="payment-right-data rprice">'.$pack_currency.$price.'</span>
                              </div>
                                   <div class="clear"></div>
                         </li>'; 
                     }
          $html .='</ul>
          </div>';
     echo $html;
     die;
}
}
add_action('wp_ajax_payment_pass_action', 'ct_payment_callback');
add_action('wp_ajax_nopriv_payment_pass_action', 'ct_payment_callback');
if (!function_exists('ct_payment_callback')) {
function ct_payment_callback(){
     session_start();

     global $ct_options;

     $user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';

     $currency_code1 = $_POST['currency_code1'];
     $pack_title = $_POST['pack_title'];
     $rcurrent_user_email = $_POST['rcurrent_user_email'];
     $rcurrent_user_id = $_POST['rcurrent_user_id'];   
     $pack_id = $_POST['pack_id'];
     $pack_price = $_POST['pack_price'];
     $stripecheck = $_POST['stripecheck'];
     $stripe_cardNo = $_POST['cardNumber'];
     $stripe_expDate = $_POST['expDate'];
     $stripe_expYear = $_POST['expYear'];
     $stripe_cardcvv = $_POST['cardcvv'];
     $stripe_payment_price = $_POST['payment_price']; 
     $admin_email1 = $_POST['admin_email']; 
     $stripeSecertkey1 = $_POST['stripeSecertkey1']; 
     $currency_sign = $_POST['currency_sign']; 
     $recurring_value = $_POST['recurring_value_stripe']; 
     
     if($recurring_value == 1){
          $pack_recurring = "Yes";
     }
     else{
          $pack_recurring = "No";
     }    
     
     require('stripe/Stripe.php');
     
     $current_date = date('Y-m-d H:i:s');
     $createOrder = new CreateOrder();
     $post["post_title"] = "Order ".$pack_title.'-'.$current_date;    
     $post["package_name"] = $pack_title;    
     $post["post_type"] = "package_order";
     $post['post_author']   = $rcurrent_user_id;
     $post["packageID"] = $pack_id;
     $post["post_status"] = "publish";
     $post["current_user_email"] = $rcurrent_user_email;    
     $post["current_user_id"] = $rcurrent_user_id;     
     $post["currency"] = $currency_code1;         
     $post["stripe_payment_amount"] = $currency_sign.$pack_price;     
     $post["stripe_package_title"] = $pack_title; 
     $post["pack_recurring"] = $pack_recurring;   
     $post["order_status"] = 1;    
          
     $order_id = $createOrder->getRequiredContents($post);
          
     //Stripe::setApiKey("sk_test_6FOXMUcr8MtueyezTmq9Z53t");
     Stripe::setApiKey($stripeSecertkey1);
     $error = '';
      $status = '';
      $token = Stripe_Token::create(array(
             "card" => array(
                "number" => $stripe_cardNo,
                "exp_month" => $stripe_expDate,
                "exp_year" => $stripe_expYear,
                "cvc" => $stripe_cardcvv
             )
          ));  
          if($stripecheck == 'stripe-recurring'){
               try{
                    $plan = Stripe_Plan::create(array(
                         "amount" => (str_replace(',', '', $pack_price) * 100),
                         "interval" => "month",
                         "name" => $pack_title,
                         "interval_count"=> 1,
                         "trial_period_days"=>null,
                         "currency" => $currency_code1,
                         "id" =>  (string)$order_id )
                    );
                                             
                    $customer = Stripe_Customer::create(array(   
                         "source" => $token->id,             
                         "email" => $rcurrent_user_email,   
                         "plan" =>  (string)$order_id,             
                    )); 
                     $html .='<div class="email-data">
                                   <h3 id="thanks">' . __('Thanks for your purchase!', 'ct-membership-packages') . '</h3>
                                   <h5>' . __('Order Details:', 'ct-membership-packages') . '</h5>
                                   <span>' . __('Package Name: ', 'ct-membership-packages') .$pack_title.'</span><br/>                                
                                   <span>' . __('Payment Method: Stripe', 'ct-membership-packages') . '</span><br/>';
                    global $ct_options;
                    $ct_currency_placement = $ct_options['ct_currency_placement'];

                    if($ct_currency_placement == 'after') {                          
                         $html .='<span>' . __('Amount: ', 'ct-membership-packages') .$pack_price.$currency_sign.'</span><br/>';
                    } else {
                         $html .='<span>' . __('Amount: ', 'ct-membership-packages') .$currency_sign.$pack_price.'</span><br/>';
                    }
                         $html .='<span>' . __('User Email: ', 'ct-membership-packages') . $rcurrent_user_email.'</span>
                                   <p class="marT20 marB20"><a class="btn" href="' . get_page_link($user_listings) . '">' . __('View Your Listings', 'ct-membership-packages') . '</a></p>
                              </div>';
                    echo $html;
               }
               catch (Exception $e) {
                    $status = $e->getMessage();
               }
          }
          else{
               try {
                     $charge = Stripe_Charge::create(array(
                       "amount" => (str_replace(',', '', $pack_price) * 100),
                       "currency" => $currency_code1,
                       "source" => $token->id,
                       "description" =>  $pack_title, 
                       "receipt_email" => $rcurrent_user_email   
                     ));
                     
                     $html .='<div class="email-data">
                                   <h3 id="thanks">' . __('Thanks for your purchase!', 'ct-membership-packages') . '</h3>
                                   <h5>' . __('Order Details:', 'ct-membership-packages') . '</h5>
                                   <span>' . __('Package Name: ', 'ct-membership-packages') .$pack_title.'</span><br/>                                
                                   <span>' . __('Payment Method: Stripe', 'ct-membership-packages') . '</span><br/>';

                                   global $ct_options;
                                   $ct_currency_placement = $ct_options['ct_currency_placement'];

                                   if($ct_currency_placement == 'after') {                          
                                        $html .='<span>' . __('Amount: ', 'ct-membership-packages') .$pack_price.$currency_sign.'</span><br/>';
                                   } else {
                                        $html .='<span>' . __('Amount: ', 'ct-membership-packages') .$currency_sign.$pack_price.'</span><br/>';
                                   }    

                                   $html .='<span>' . __('User Email: ', 'ct-membership-packages') . $rcurrent_user_email.'</span>
                                   <p class="marT20 marB20"><a class="btn" href="' . get_page_link($user_listings) . '">' . __('View Your Listings', 'ct-membership-packages') . '</a></p>
                              </div>';
                    echo $html;
                } 
               catch (Exception $e) {
                    $status = $e->getMessage();
               }               
          }
          //Stripe recurring response
          
          $customerdata = $customer->subscriptions->data;
               foreach($customerdata as $cdata){            
                    $package_recurring_start = $cdata['current_period_start'];
                    $package_recurring_end = $cdata['current_period_end'];                
                    $stripe_status = $cdata['status'];                
               }
                         
          $customerdata1 = $plan->interval;
          $amount = $plan->amount;
          $stripeAmount = (strip_tags($amount) / 100);      
          $post["stripe_customerid"] =  $customer->id;           
          $post["package_recurring_start"] = $package_recurring_start;
          $post["package_recurring_end"] = $package_recurring_end;
          $post['stripe_pack_interval']   = $customerdata1;
          $post['stripeAmount']   = $stripeAmount;
          $post['stripeRecurringstatus']   = $stripe_status;
          $post['stripe_recurring_payment_method']   = "Stripe Recurring";
          
          //Stripe response
          $stripe_success = $charge->outcome->seller_message;
          $post["stripe_balance_transaction"] = $charge->balance_transaction;
          $post["stripe_success"] = $stripe_success;        
          $post["stripe_payment_method"] = "Stripe";
          
          $rpackage_time = $_POST['package_time'];     
          
          $package_current_date = date("Y-m-d");
          if($rpackage_time == 'N/A'){
               $package_expire_date = date("Y-m-d", strtotime(($current_date)."+1000 year"));  
          }
          else{
               $package_expire_date = date("Y-m-d", strtotime(($current_date)."+".$rpackage_time)); 
          }
          
          $post["package_expire_date"] = $package_expire_date;
          $post['package_current_date']   = $package_current_date;
          
          $order_id = $createOrder->getRequiredContents($post,$order_id,$package_current_date,$package_expire_date);    
     
          
          //Email to admin
          if($stripe_status == 'active'){
          $to = array($admin_email1);
          $subject = __('Packages Order', 'ct-membership-packages');
               
               $body = '<table border="0">
                         <tr><th>' . __('Order Details:', 'ct-membership-packages') . '</th></tr>
                         <tr>
                              <td>' . __('Payment Method:', 'ct-membership-packages') . '</td>
                              <td>' . __('Stripe Recurring', 'ct-membership-packages') . '</td>
                         </tr>
                         <tr>
                              <td>' . __('Package Name:', 'ct-membership-packages') . '</td>
                              <td>'.$pack_title.'</td>
                         </tr>';
                         global $ct_options;
                         $ct_currency_placement = $ct_options['ct_currency_placement'];

                         if($ct_currency_placement == 'after') {                          
                              $body .= '<tr>
                                   <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                                   <td>'.$pack_price.$currency_sign.'</td>
                              </tr>';
                         } else {
                              $body .= '<tr>
                                   <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                                   <td>'.$currency_sign.$pack_price.'</td>
                              </tr>';
                         }    
                         $body .= '<tr>
                              <td>' . __('Payment Status', 'ct-membership-packages') . '</td>
                              <td>'.$stripe_status.'</td>
                         </tr>                         
                         <tr>
                              <td>' . __('User Email:', 'ct-membership-packages') . '</td>
                              <td>'. $rcurrent_user_email . '</td>
                         </tr>
                    </table>';
               $headers = array('Content-Type: text/html; charset=UTF-8');
          
               wp_mail( $to, $subject, $body, $headers ); 
          }    
          if($stripe_success == 'Payment complete.'){
          $to = array($admin_email1,$rcurrent_user_email);
          $subject = __('Package Order Receipt from ', 'ct-membership-packages') . $_SERVER['HTTP_HOST'];
          $body = '<table border="0">
                         <tr><th>' . __('Order Details', 'ct-membership-packages') . ':</th></tr>
                         <tr>
                              <td>' . __('Payment Method', 'ct-membership-packages') . ':</td>
                              <td>Stripe</td>
                         </tr>
                         <tr>
                              <td>' . __('Package Name', 'ct-membership-packages') . '</td>
                              <td>'.$pack_title.'</td>
                         </tr>';
                         global $ct_options;
                         $ct_currency_placement = $ct_options['ct_currency_placement'];

                         if($ct_currency_placement == 'after') {                          
                              $body .= '<tr>
                                   <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                                   <td>'.$pack_price.$currency_sign.'</td>
                              </tr>';
                         } else {
                              $body .= '<tr>
                                   <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                                   <td>'.$currency_sign.$pack_price.'</td>
                              </tr>';
                         }
                         $body .='<tr>
                              <td>' . __('Payment Status', 'ct-membership-packages') . ':</td>
                              <td>'.$stripe_success.'</td>
                         </tr>                         
                         <tr>
                              <td>' . __('User Email', 'ct-membership-packages') . ':</td>
                              <td>'. $rcurrent_user_email . '</td>
                         </tr>
                    </table>';
               $headers = array('Content-Type: text/html; charset=UTF-8');

               wp_mail( $to, $subject, $body, $headers );              
          }
     echo $status;
     die();
}
}
add_action('wp_ajax_paypalPayment_pass_action', 'ct_paypalPayment_callback');
add_action('wp_ajax_nopriv_paypalPayment_pass_action', 'ct_paypalPayment_callback');
if (!function_exists('ct_paypalPayment_callback')) {
function ct_paypalPayment_callback(){
     session_start();    
     global $current_user;
     $user_id = $current_user->ID;
     $currency_code11 = $_POST['currency_code11'];
     $currency_sign1 = $_POST['currency_sign1']; 
     $pack_title1 = $_POST['pack_title1'];
     $rcurrent_user_email1 = $_POST['rcurrent_user_email1'];     
     $pack_id1 = $_POST['pack_id1'];
     $pack_price1 = $_POST['pack_price1'];
     $rcurrent_user_id1 = $_POST['rcurrent_user_id1'];
     $packageCurrentdate1 = $_POST['packageCurrentdate1'];
     $packageExpiredate1 = $_POST['packageExpiredate1'];
     $recurring_value = $_POST['recurring_value_paypal'];
     $current_date1 = date('Y-m-d H:i:s');
     
     if($recurring_value == 1){
          $pack_recurring = "Yes";
     }
     else{
          $pack_recurring = "No";
     }
     
     $CreateOrder = new CreateOrder();
     
     $post["post_title"] =  __('Order', 'ct-membership-packages') . $pack_title1 .'-' . $current_date1;  
     $post["package_name"] = $pack_title1;   
     $post["post_type"] = "package_order";
     $post['post_author']   = $rcurrent_user_id;
     $post["packageID"] = $pack_id1;
     $post["post_status"] = "publish";
     $post["current_user_email"] = $rcurrent_user_email1;   
     $post["current_user_id"] = $user_id;    
     $post["currency"] = $currency_code11;   
     $post["paypal_payment_amount"] = $currency_sign1.$pack_price1;   
     $post["package_current_date"] = $packageCurrentdate1;  
     $post["package_expire_date"] = $packageExpiredate1;    
     $post["pack_recurring"] = $pack_recurring;   
     $post["order_status"] = 1;    
     
     $current_user = wp_get_current_user();
     $datablock = json_encode($post);

     update_user_meta($current_user->ID, 'package-data' , $datablock);
     // print_r($_SESSION);
     //$order_id = $CreateOrder->getRequiredContents($post);
     //$order_id = $CreateOrder->getRequiredContents($post,$order_id );


     if($order_id){
          echo $order_id; 
     }
     else{
          echo "0";
     }
     die;
}
}
add_action('wp_ajax_bankPayment_pass_action', 'ct_bankPayment_callback');
add_action('wp_ajax_nopriv_bankPayment_pass_action', 'ct_bankPayment_callback');
if (!function_exists('ct_bankPayment_callback')) {
function ct_bankPayment_callback(){
     session_start();
     global $ct_options;
     global $current_user;
     $user_id = $current_user->ID;
     $user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';
     //$ct_wire_transfer_instructions = isset( $ct_options['ct_wire_transfer_instructions'] ) ? esc_html( $ct_options['ct_wire_transfer_instructions'] ) : '';
     $ct_wire_transfer_instructions = $ct_options['ct_wire_transfer_instructions'];

     $pack_title2 = $_POST['pack_title2'];
     $pack_price2 = $_POST['pack_price2'];
     $pack_id2 = $_POST['pack_id2'];
     $rcurrent_user_email2 = $_POST['rcurrent_user_email2'];     
     $rcurrent_user_id2 = $_POST['rcurrent_user_id2'];
     $currency_code2 = $_POST['currency_code2'];
     $currency_sign2 = $_POST['currency_sign2']; 
     $packageCurrentdate2 = $_POST['packageCurrentdate2'];
     $packageExpiredate2 = $_POST['packageExpiredate2'];
     $bankaccountNumber = $_POST['bankaccountNumber'];
     $admin_email2 = $_POST['admin_email2'];
     $recurring_value = $_POST['recurring_value_bank'];
     $current_date2 = date('Y-m-d H:i:s');   

     $CreateOrder = new CreateOrder();
     
     if($recurring_value == 1){
          $pack_recurring = "Yes";
     }
     else{
          $pack_recurring = "No";
     }
     
     $post["post_title"] = "Order ".$pack_title2.'-'.$current_date2;  
     $post["package_name"] = $pack_title2;   
     $post["post_type"] = "package_order";
     $post['post_author']   = $rcurrent_user_id2;
     $post["packageID"] = $pack_id2;
     $post["post_status"] = "publish";
     $post["current_user_email"] = $rcurrent_user_email2;   
     $post["currency"] =$currency_sign2.$currency_code2;    
     $post["payment_amount"] = $pack_price2; 
     $post["package_current_date"] = $packageCurrentdate2;  
     $post["package_expire_date"] = $packageExpiredate2;    
     $post["bankaccountNumber"] = $bankaccountNumber;  
     $post["payment_method"] = "wire_transfer";   
     $post["wirepayment_status"] = "Not Paid";    
     $post["current_user_id"] = $user_id;    
     $post["pack_recurring"] = $pack_recurring;   
     $post["order_status"] = 1;    
     
     $bankorder_id = $CreateOrder->getRequiredContents($post);
     $bankorder_id = $CreateOrder->getRequiredContents($post, $bankorder_id); 
     
     if($bankorder_id){
          $html.='<div class="email-data">
                         <h3 id="thanks" class="marT20">' . __('Thanks for your purchase!', 'ct-membership-packages') . '</h3>
                         <h5>' . __('Order Details:', 'ct-membership-packages') . '</h5>
                         <p class="marB0">' . __('Package Name:', 'ct-membership-packages') . ' ' . $pack_title2 .'</p>                          
                         <p class="marB0">' . __('Payment Method: Direct Bank Transfer', 'ct-membership-packages') . '</p>';
                         global $ct_options;
                         $ct_currency_placement = $ct_options['ct_currency_placement'];

                         if($ct_currency_placement == 'after') {                
                              $html.='<p class="marB0">' . __('Amount:', 'ct-membership-packages') . ' ' .$pack_price2.$currency_sign2.'</p>';
                         } else {
                              $html.='<p class="marB0">' . __('Amount:', 'ct-membership-packages') . ' ' . $currency_sign2.$pack_price2.'</p>';
                         }
                         $html .= '<p class="marB0">' . __('User email:', 'ct-membership-packages') . ' ' . $rcurrent_user_email2.'</p>

                         <p class="marB20">' . __('Order #:', 'ct-membership-packages') . ' ' . $bankorder_id .'</p>

                         <h5 class="marB20">' . __('Contact your bank and supply the following information:', 'ct-membership-packages') . '</h5>

                         '. $ct_wire_transfer_instructions . '

                         <p class="marB20">' . __('Please use your Order ID as payment reference.', 'ct-membership-packages') . '</p>
                         <p class="marB20"><a class="btn" href="' . get_page_link($user_listings) . '">' . __('View Your Listings', 'ct-membership-packages') . '</a></p>
                    </div>';
          echo $html;
          $to = array($admin_email2);
          $subject = __('New Wire Transfer Package Order on ', 'ct-membership-packages') . $_SERVER['HTTP_HOST'];
          $body = '<table border="0">
                         <tr><th>' . __('Order Details:', 'ct-membership-packages') . '</th></tr>
                         <tr>
                              <td>' . __('Payment Method:', 'ct-membership-packages') . '</td>
                              <td>' . __('Direct Bank Transfer', 'ct-membership-packages') . '</td>
                         </tr>
                         <tr>
                              <td>' . __('Package Name:', 'ct-membership-packages') . '</td>
                              <td>'.$pack_title2.'</td>
                         </tr>';
                         global $ct_options;
                         $ct_currency_placement = $ct_options['ct_currency_placement'];

                         if($ct_currency_placement == 'after') {                          
                              $body .= '<tr>
                                   <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                                   <td>'.$pack_price2.$currency_sign2.'</td>
                              </tr>';
                         } else {
                              $body .= '<tr>
                                   <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                                   <td>'.$currency_sign2.$pack_price2.'</td>
                              </tr>';
                         }
                         $body .= '<tr>
                              <td>' . __('Bank Account Number:', 'ct-membership-packages') . '</td>
                              <td>'.$bankaccountNumber.'</td>
                         </tr>
                                        
                         <tr>
                              <td>' . __('User Email:', 'ct-membership-packages') . '</td>
                              <td>' . $rcurrent_user_email2 . '</td>
                         </tr>
                    </table>';
               $headers = array('Content-Type: text/html; charset=UTF-8');

               wp_mail( $to, $subject, $body, $headers ); 

          $to = array($rcurrent_user_email2);
          $subject = __('Wire Transfer Package Order Receipt from ', 'ct-membership-packages') . $_SERVER['HTTP_HOST'];
          $body = '<table border="0">
                         <tr><th><h3>' . __('Thanks for your purchase!', 'ct-membership-packages') . '</h3></th></tr>
                         <tr><th>' . __('Order Details:', 'ct-membership-packages') . '</th></tr>
                         <tr>
                              <td>' . __('Payment Method:', 'ct-membership-packages') . '</td>
                              <td>' . __('Direct Bank Transfer', 'ct-membership-packages') . '</td>
                         </tr>
                         <tr>
                              <td>' . __('Package Name:', 'ct-membership-packages') . '</td>
                              <td>'.$pack_title2.'</td>
                         </tr>';
                         global $ct_options;
                         $ct_currency_placement = $ct_options['ct_currency_placement'];

                         if($ct_currency_placement == 'after') {                          
                              $body .= '<tr>
                                   <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                                   <td>'.$pack_price2.$currency_sign2.'</td>
                              </tr>';
                         } else {
                              $body .= '<tr>
                                   <td>' . __('Amount:', 'ct-membership-packages') . '</td>
                                   <td>'.$currency_sign2.$pack_price2.'</td>
                              </tr>';
                         }
                         $body .= '<tr>
                              <td>' . __('Bank Account Number:', 'ct-membership-packages') . '</td>
                              <td>'.$bankaccountNumber.'</td>
                         </tr>
                    </table>';
               $headers = array('Content-Type: text/html; charset=UTF-8');

               wp_mail( $to, $subject, $body, $headers ); 
     }
     else {
          echo "0";
     } 
     die;
}
}

// Wire Transfer Orders

add_action('admin_menu','ct_wire_transfer_users');

if(!function_exists('ct_wire_transfer_users')) {
      function ct_wire_transfer_users() {
        add_submenu_page('edit.php?post_type=packages', __('Wire Transfer Orders', 'ct-membership-packages'), __('Wire Transfer Orders', 'ct-membership-packages'), 'manage_options', __FILE__, 'ct_wire_transfer_payment');
     }
}

 function ct_wire_transfer_payment() { ?>
       <div class='wrap'>
             <style>
             #wire-transfer-users { width: 50%;}
                    #wire-transfer-users td { vertical-align: middle; border-bottom: 1px solid #e5e5e5;}
                    #wire-transfer-users tbody tr:nth-child(odd) { background-color: #f9f9f9;}
                         #no-orders { text-align: center;}
             </style>
               <h1 class="wp-heading-inline" style="margin-bottom: 20px;"><?php _e('Wire Transfer Orders','contempo'); ?></h1>
               <div class="content">
                    <table id="wire-transfer-users" class="wp-list-table widefat fixed">
                         <thead>
                              <tr>
                                   <th><?php _e('Invoice', 'ct-membership-packages'); ?></th>
                                   <th><?php _e('User ID', 'ct-membership-packages'); ?></th>
                                   <th><?php _e('Status', 'ct-membership-packages'); ?></th>
                              </tr>
                         </thead>
                         <tbody>
                         <?php
                         global $wpdb;                      
                         $wire_users = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts p, ".$wpdb->prefix."postmeta m1, ".$wpdb->prefix."postmeta m2 WHERE p.ID = m1.post_id and p.ID = m2.post_id
                                   AND m1.meta_key = 'payment_method' AND m1.meta_value = 'wire_transfer'
                                   AND m2.meta_key = 'wirepayment_status' AND m2.meta_value =  'Not Paid'
                                   AND p.post_type = 'package_order' AND p.post_status = 'publish'");
                    
                              if(!empty($wire_users)){
                                   foreach($wire_users as $wire_users_data){    
                                        $wire_post_id = $wire_users_data->ID;
                                        $user_post_id = $wire_users_data->post_author;
                                        $wirepayment_status = $wire_users_data->meta_value;
                                        
                                        echo '<tr class="wire_' . $wire_post_id . '">
                                                  <td><span>' . $wire_post_id . '</span></td>
                                                  <td><span class="user_id_' . $wire_post_id . '" user_id=' . $user_post_id . '>' . $user_post_id . '</span></td>
                                                  <td><span class="wire-paystatus_' . $wire_post_id . ' button action" wire_post_id=' . $wire_post_id . '>' . __('Mark as Paid', 'ct-membership-packages') . '</span></td>
                                             </tr>';   

                                        ?>
                                        <script>
                                             jQuery(".wire-paystatus_<?php echo $wire_post_id ?>").click(function(){
                                                  var user_id = jQuery(".user_id_<?php echo $wire_post_id ?>").attr('user_id');
                                                  var wire_post_id = jQuery(".wire-paystatus_<?php echo $wire_post_id ?>").attr('wire_post_id');
                                                  var data={
                                                       action: 'wire_post_update',
                                                       user_id: user_id,
                                                       wire_post_id: wire_post_id
                                                  }
                                                       jQuery.ajax({
                                                       type: 'POST',
                                                       url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                                                       data: data,
                                                       success: function(response) { 
                                                             if(response == 1){                                                   
                                                                 console.log(response);   
                                                                 jQuery(".wire_<?php echo $wire_post_id ?>").remove();
                                                             }
                                                            else{
                                                                 console.log('empty');    
                                                            }    
                                                       }
                                                  })
                                             })
                                             
                                        </script>
                                        <?php
                                   }
                              } else {
                                   echo '<tr>';
                                        echo '<td id="no-orders" colspan="3">' . __('No current orders to approve.', 'ct-membership-packages') . '</td>';
                                   echo '</tr>';
                              }
                         ?>
                         </tbody>
                    </table>
               
               </div>
<?php
} 
 add_action('wp_ajax_wire_post_update', 'ct_wire_post_callback');
add_action('wp_ajax_nopriv_wire_post_update', 'ct_wire_post_callback');
if (!function_exists('ct_wire_post_callback')) {
function ct_wire_post_callback(){
     ini_set("display_errors", 1);
     //echo "<pre>"; print_r($update_price);
     $pack_orderid = $_POST['wire_post_id'];
     $userid = $_POST['user_id'];
     global $wpdb;  
     //$listing_posts = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."posts WHERE post_author = $userid AND post_type = 'listings' AND post_status='pending'" );
/*
     $update_listing_posts = $wpdb->query($wpdb->prepare("Update " . $wpdb->prefix . "posts
                         Set post_status = 'publish'
                         Where post_author = $userid
                         AND post_type = 'listings' AND post_status='pending'"));
*/                   
     $update_listing_posts = $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."posts SET post_status = 'publish' WHERE post_author =  %d", $userid));
     if($update_listing_posts == 1){
          $wire_status = 1;
     }
     else{
          $wire_status = 0;
     }
 
/*   $update_packages_order = $wpdb->query($wpdb->prepare("Update " . $wpdb->prefix . "postmeta
                         Set meta_value = 'Paid'
                         Where meta_key ='wirepayment_status' AND post_id = $pack_orderid "));
*/
    $update_packages_order = $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."postmeta SET meta_value = 'Paid' WHERE meta_key ='wirepayment_status' AND post_id =%d", $pack_orderid));
     
     if($update_packages_order == 1){
          $wire_status = 1;
     }
     else{
          $wire_status = 0;
     }
     echo $wire_status;
     die;
}
} 

// Membership page
if(!function_exists('packages_membership_data')) {
     function packages_membership_data(){
          global $current_user;
          global $ct_options;
          $uid = $current_user->ID;
          global $wpdb;
          
          $today = strtotime(date("Y-m-d"));
          $ct_user_listings_count = ct_listing_post_count($current_user->ID, 'listings');
          $ct_package_list = isset( $ct_options['ct_package_list'] ) ? esc_html( $ct_options['ct_package_list'] ) : '';
          //$ct_package_list = get_site_url().'/package-list';
          
          /* echo "SELECT * FROM ".$wpdb->prefix."posts WHERE post_author = $uid AND post_type = 'package_order' order by id" ;
          exit; */
          
          
          $events = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."posts WHERE post_author = $uid AND post_type = 'package_order' order by id" );
          //$aa= count()
          

     /* $events = get_posts(
               array(
                    'post_type' => 'package_order',
                    'posts_per_page' => 1,
                    'author' => $uid,
               )
          );  */
          foreach($events as $data){    
               $post_id = $data->ID;
          }
          
          $post_listing = array(
               'post_type' => 'listings',
               'post_status' => 'any',
               'posts_per_page' => -1,
               'author' =>  $uid        
          );
               
         $post_loop = new WP_Query($post_listing);
          
          $post_listing_count = $post_loop->post_count;


      
     //Featured listings 

     $featured_listing = array(
               'post_type' => 'listings',
               'post_status' => 'any',
               'posts_per_page' => -1,
               'author' =>  $uid,
               'tax_query' => array(
                    array(
                         'taxonomy' => 'ct_status',
                         'field' => 'slug',
                         'terms' => 'featured'
                    )
               )
          );
               
         $loop = new WP_Query($featured_listing);
          
          $featured_listing_count = $loop->post_count;

           if(empty($post_id)) { ?>
               <div class="col span_12 first packages-notification-large">
                    <h4 class="marB20"><?php esc_html_e('You haven\'t chosen a package yet…', 'ct-membership-packages'); ?></h4>
                    <p class="marB0"><a class="btn" href="<?php echo get_page_link($ct_package_list); ?>"><?php esc_html_e('Get Started!', 'ct-membership-packages'); ?></a></p>
               </div>    
         <div class="clear"></div>
          <?php } 
          
          if(!empty($post_id)){    
          $purchased_date = get_post_meta($post_id,'package_current_date',true);
          $expiration_date = get_post_meta($post_id,'package_expire_date',true);
          $order_status = get_post_meta($post_id,'order_status',true);
          $post_meta_id = get_post_meta($post_id,'packageID',true);
          $post_data = get_post($post_meta_id);
          $package_name = $post_data->post_title;
          $package_id = $post_data->ID;
          $price = get_post_meta($package_id,'price',true);
          $date = get_post_meta($package_id,'date',true);
          $time = get_post_meta($package_id,'time',true);
          $recurring = get_post_meta($package_id,'recurring',true);
          $listing_included = get_post_meta($package_id,'listing',true);
          //$listing_remaining = $listing_included - $ct_user_listings_count;
          $listing_remaining = $listing_included - $post_listing_count;
          $featured_listing = get_post_meta($package_id,'featured_listing',true);
          $featured_listing_remaining = $featured_listing - $featured_listing_count; 

          $day = __('Day', 'ct-membership-packages');
          $days = __('Days', 'ct-membership-packages');
          $week = __('Week', 'ct-membership-packages');
          $weeks = __('Weeks', 'ct-membership-packages');
          $month = __('Month', 'ct-membership-packages');
          $months = __('Months', 'ct-membership-packages');
          $year = __('Year', 'ct-membership-packages');
          $years = __('Years', 'ct-membership-packages');
          
          ?>

          <?php $redirect = add_query_arg( array('package' => 'update'), get_permalink($ct_package_list) ); ?>
          <?php $change_package = add_query_arg( array('package' => 'package-change'), get_permalink($ct_package_list) ); ?>
          <?php //if($ct_user_listings_count >= $listing_included) {?>

          <?php if($post_listing_count >= $listing_included) {?> 
               <div class="col span_12 first packages-notification-small marB20">
                    <h6 class="marB0 left"><?php esc_html_e('You\'ve reached the limit of your current package.', 'ct-membership-packages'); ?></h6>
                    <a class="btn btn-tertiary right" href="<?php echo $redirect //get_page_link($ct_package_list); ?>"><?php esc_html_e('Upgrade Today', 'ct-membership-packages'); ?></a>
               </div>
               <div class="clear"></div>
          <?php } ?>
          
          <?php if($today >= strtotime($expiration_date) && !empty($expiration_date)) {?>
               <div class="col span_12 first packages-notification-small marB20">
                    <h6 class="marB0 left"><?php esc_html_e('Your package has expired.', 'ct-membership-packages'); ?></h6>
                    <a class="btn btn-tertiary right" href="<?php echo get_page_link($ct_package_list); ?>"><?php esc_html_e('Renew Today', 'ct-membership-packages'); ?></a>
               </div>
          
               <div class="clear"></div>
          <?php } ?>

          <?php if(empty($expiration_date)) { ?>
               <div class="col span_12 first packages-notification-large">
                    <h4 class="marB20"><?php esc_html_e('You haven\'t chosen a package yet…', 'ct-membership-packages'); ?></h4>
                    <p class="marB0"><a class="btn" href="<?php echo get_page_link($ct_package_list); ?>"><?php esc_html_e('Get Started', 'ct-membership-packages'); ?></a></p>
               </div>    
         <div class="clear"></div>
          <?php } ?>

          <?php if(!empty($expiration_date)) { ?>
          <div class="inner-content">

             <h3 class="marT0 marB0"><?php _e('Current Package Details', 'ct-membership-packages'); ?> </h3>
               <p class="muted"><?php _e('Overview of your existing membership & package information.', 'ct-membership-packages'); ?></p>

               <ul id="membership-package-information">
                    <li id="package-name" class="clr"><span class="left"><strong><?php echo $package_name; ?></strong></span><span class="right"><a class="btn" href="<?php echo $change_package //get_page_link($ct_package_list); ?>"><?php _e('change package', 'ct-membership-packages'); ?></a></span></li>
                    <?php

                    global $ct_options;
                    $ct_currency_placement = $ct_options['ct_currency_placement'];

                    if($ct_currency_placement == 'after') { ?>
                         <li id="package-price" class="clr"><span class="left"><strong><?php _e('Price:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $price; ?><?php ct_currency()?></span></li>
                    <?php } else { ?>
                         <li id="package-price" class="clr"><span class="left"><strong><?php _e('Price:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php ct_currency()?><?php echo $price; ?></span></li>
                    <?php } ?>
                    <li id="time-period" class="clr"><span class="left">
                         <strong><?php _e('Time Period:', 'ct-membership-packages'); ?></strong></span>
                         <span class="right">
                              <?php if(($time && $date) != 0){
                                   if($time == 'Day(s)' && $date == '1') {
                                        echo $date .' '. $day;
                                   } elseif($time == 'Day(s)') {
                                        echo $date .' '. $days;
                                   } elseif($time == 'Week(s)' && $date == '1') {
                                        echo $date .' '. $week;
                                   } elseif($time == 'Week(s)') {
                                        echo $date .' '. $weeks;
                                   } elseif($time == 'Month(s)' && $date == '1') {
                                        echo $date .' '. $month;
                                   } elseif($time == 'Month(s)') {
                                        echo $date .' '. $months;
                                   } elseif($time == 'Year(s)' && $date == '1') {
                                        echo $date .' '. $year;
                                   } elseif($time == 'Year(s)') {
                                        echo $date .' '. $years;
                                   }
                              } else {
                                   _e('N/A', 'ct-membership-packages');
                              } ?>
                         </span>
                    </li>
                    <li id="purchased-date" class="clr"><span class="left"><strong><?php _e('Purchased Date:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $purchased_date; ?></span></li>
                    <li id="expiration-date" class="clr"><span class="left"><strong><?php _e('Expiration Date:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $expiration_date; ?></span></li>
                    <li id="recurring" class="clr"><span class="left"><strong><?php _e('Recurring:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php if($recurring == 1){ echo "Yes"; } else{ echo "No"; } ?></span></li>
                    <li id="listings-included" class="clr"><span class="left"><strong><?php _e('Listings Included:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $listing_included; ?></span></li>
                    <li id="listings-remaining" class="clr muted"><span class="left"><strong><?php _e('Listings Remaining:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $listing_remaining; ?></span></li>
                    <li id="featured-included" class="clr"><span class="left"><strong><?php _e('Featured Listings:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $featured_listing; ?></span></li>
                    <li id="featured-remaining" class="clr muted"><span class="left"><strong><?php _e('Featured Listings Remaining:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $featured_listing_remaining; ?></span></li>
               </ul>
          <?php } }?>

                    <div class="clear"></div>
               
         </div>
     <?php
          
     }
}
add_shortcode('packages_orderdata', 'packages_membership_data');

// Dashboard Membership Package
if(!function_exists('dashboard_membership_package')) {
     function dashboard_membership_package(){
          global $current_user;
          global $ct_options;
          $uid = $current_user->ID;
          global $wpdb;
          
          $today = strtotime(date("Y-m-d"));
          $ct_user_listings_count = ct_listing_post_count($current_user->ID, 'listings');
          $ct_membership = isset( $ct_options['ct_membership'] ) ? esc_html( $ct_options['ct_membership'] ) : '';
          $ct_package_list = isset( $ct_options['ct_package_list'] ) ? esc_html( $ct_options['ct_package_list'] ) : '';
          
          $events = $wpdb->get_results ("SELECT * FROM ".$wpdb->prefix."posts WHERE post_author = $uid AND post_type = 'package_order' order by id" );

          foreach($events as $data){    
               $post_id = $data->ID;
          }
          
          $post_listing = array(
               'post_type' => 'listings',
               'post_status' => 'any',
               'posts_per_page' => -1,
               'author' =>  $uid        
          );
               
         $post_loop = new WP_Query($post_listing);
          
          $post_listing_count = $post_loop->post_count;

          //Featured listings 
          $featured_listing = array(
               'post_type' => 'listings',
               'post_status' => 'any',
               'posts_per_page' => -1,
               'author' =>  $uid,
               'tax_query' => array(
                    array(
                         'taxonomy' => 'ct_status',
                         'field' => 'slug',
                         'terms' => 'featured'
                    )
               )
          );
               
         $loop = new WP_Query($featured_listing);
          
          $featured_listing_count = $loop->post_count; ?>

               <?php if(empty($post_id)) { ?>
                    <h4 class="marB0 left"><?php esc_html_e('You haven\'t chosen a package yet…', 'ct-membership-packages'); ?></h4>
                    <a class="btn btn-tertiary right" href="<?php echo get_page_link($ct_package_list); ?>"><?php esc_html_e('Get Started!', 'ct-membership-packages'); ?></a>
                      <div class="clear"></div>
               <?php } 
               
               if(!empty($post_id)){    

                    $purchased_date = get_post_meta($post_id,'package_current_date',true);
                    $expiration_date = get_post_meta($post_id,'package_expire_date',true);
                    $order_status = get_post_meta($post_id,'order_status',true);
                    $post_meta_id = get_post_meta($post_id,'packageID',true);
                    $post_data = get_post($post_meta_id);
                    $package_name = $post_data->post_title;
                    $package_id = $post_data->ID;
                    $price = get_post_meta($package_id,'price',true);
                    $date = get_post_meta($package_id,'date',true);
                    $time = get_post_meta($package_id,'time',true);
                    $recurring = get_post_meta($package_id,'recurring',true);
                    $listing_included = get_post_meta($package_id,'listing',true);
                    //$listing_remaining = $listing_included - $ct_user_listings_count;
                    $listing_remaining = $listing_included - $post_listing_count;
                    $featured_listing = get_post_meta($package_id,'featured_listing',true);
                    $featured_listing_remaining = $featured_listing - $featured_listing_count; 
               
               ?>

                    <?php $redirect = add_query_arg( array('package' => 'update'), get_permalink($ct_package_list) ); ?>
                    <?php $change_package = add_query_arg( array('package' => 'package-change'), get_permalink($ct_package_list) ); ?>

                    <?php if($post_listing_count >= $listing_included) { ?>
                         <div id="package-notification" class="clr">  
                              <h5 class="left"><?php esc_html_e('You\'ve reached the limit of your current package.', 'ct-membership-packages'); ?></h5>
                              <a class="btn btn-tertiary right" href="<?php echo $redirect; ?>"><?php esc_html_e('Upgrade Today', 'ct-membership-packages'); ?></a>
                         </div>
                    <?php } ?>
                    
                    <?php if($today >= strtotime($expiration_date) && !empty($expiration_date)) {?>
                         <div id="package-notification" class="clr">  
                              <h5 class="left"><?php esc_html_e('Your package has expired.', 'ct-membership-packages'); ?></h5>
                              <a class="btn btn-tertiary right" href="<?php echo get_page_link($ct_package_list); ?>"><?php esc_html_e('Renew Today', 'ct-membership-packages'); ?></a>
                         </div>
                    <?php } ?>

                    <?php if(empty($expiration_date)) { ?>
                         <div id="package-notification" class="clr">  
                              <h5 class="left"><?php esc_html_e('You haven\'t chosen a package yet…', 'ct-membership-packages'); ?></h5>
                              <a class="btn btn-tertiary right" href="<?php echo get_page_link($ct_package_list); ?>"><?php esc_html_e('Get Started', 'ct-membership-packages'); ?></a>
                         </div>
                    <?php } ?>

                    <?php if(!empty($expiration_date)) { ?>

                              <div class="clear"></div>

                         <h3 id="membership-package-name" class="marT0 marB20"><a href="<?php echo $change_package; ?>"><strong><?php echo $package_name; ?></strong> <small class="muted right"><?php _e('(change package)', 'ct-membership-packages'); ?></small></a></h3>

                         <ul class="col span_6 first">
                              <li id="time-period" class="clr"><span class="left"><strong><?php _e('Time Period:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $date." ".$time; ?></span></li>
                              <li id="purchased-date" class="clr"><span class="left"><strong><?php _e('Purchased Date:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $purchased_date; ?></span></li>
                              <li id="expiration-date" class="clr"><span class="left"><strong><?php _e('Expiration Date:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $expiration_date; ?></span></li>
                              <li id="recurring" class="clr"><span class="left"><strong><?php _e('Recurring:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php if($recurring == 1){ echo "Yes"; } else{ echo "No"; } ?></span></li>
                         </ul>

                         <ul class="col span_6">
                              <li id="listings-included" class="clr"><span class="left"><strong><?php _e('Listings Included:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $listing_included; ?></span></li>
                              <li id="listings-remaining" class="clr muted"><span class="left"><strong><?php _e('Listings Remaining:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $listing_remaining; ?></span></li>
                              <li id="featured-included" class="clr"><span class="left"><strong><?php _e('Featured Listings:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $featured_listing; ?></span></li>
                              <li id="featured-remaining" class="clr muted"><span class="left"><strong><?php _e('Featured Listings Remaining:', 'ct-membership-packages'); ?></strong></span><span class="right"><?php echo $featured_listing_remaining; ?></span></li>
                         </ul>

                              <div class="clr"></div>

                    <?php } ?>

                         <div class="clr"></div>

               <?php } ?>

     <?php
          
     }
}
add_shortcode('dashboard_membership_package', 'dashboard_membership_package');


// Add WeCashUp call back url
/*
add_action('rest_api_init', "ctWeCashUpCallBack");
function ctWeCashUpCallBack()
{
     require_once dirname(__FILE__)."/wecashup/rest.php";
     $octWeCashUp = new ctWeCashUp();

     register_rest_route('ct/v1', '/wecashup-callback/', array(
          'methods' => 'POST',
          'callback' => array( $octWeCashUp, 'callback'),
     ));
}
*/


// Add WeCashUp web hook url
add_action('rest_api_init', "ctWeCashUpWebHook");
function ctWeCashUpWebHook()
{
     require_once dirname(__FILE__)."/wecashup/rest.php";
     $octWeCashUp = new ctWeCashUp();

     register_rest_route('ct/v1', '/wecashup-webhook/', array(
          'methods' => 'POST',
          'callback' => array( $octWeCashUp, 'webhook'),
     ));
}
