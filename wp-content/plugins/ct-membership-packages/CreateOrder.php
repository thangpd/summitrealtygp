<?php

/**
 * Create Order
 *
 * @link       http://contempographicdesign.com
 * @since      1.0.0
 *
 * @package    Contempo Membership & Packages
 */

class CreateOrder {
     public function getRequiredContents($parseData, $post_id = '') {
          //echo '<pre>';print_r($parseData);die('hi');
          if(empty($post_id)){
               //echo "fjhfj"; die;
               $post_id = wp_insert_post( $parseData, true );
          } else {
               //echo "ffj"; die;
               add_post_meta($post_id, "packageID", $parseData["packageID"]);
               add_post_meta($post_id, "package_name", $parseData["package_name"]);
               add_post_meta($post_id, "currency", $parseData["currency"]);               
               add_post_meta($post_id, "current_user_id", $parseData["current_user_id"]);           
               add_post_meta($post_id, "current_user_email", $parseData["current_user_email"]);
               add_post_meta($post_id, "package_current_date", $parseData["package_current_date"]);           
               add_post_meta($post_id, "package_expire_date", $parseData["package_expire_date"]);                  
               add_post_meta($post_id, "order_status", $parseData["order_status"]);
               add_post_meta($post_id, "pack_recurring", $parseData["pack_recurring"]);
               
               if(isset($parseData["stripe_package_title"])){                        
                    add_post_meta($post_id, "stripe_package_title", $parseData["stripe_package_title"]);
               }


               if(isset($parseData["payment_method"]) && $parseData["payment_method"]=="wecashup"){                      
                    add_post_meta($post_id, "payment_method", $parseData["payment_method"]);
                    add_post_meta($post_id, "wecashup_status", "PAID");
                    add_post_meta($post_id, "payment_amount", $parseData["payment_amount"]);
               }




               if(isset($parseData["payment_method"]) && isset($parseData["wirepayment_status"])){                      
                    add_post_meta($post_id, "payment_method", $parseData["payment_method"]);
                    add_post_meta($post_id, "wirepayment_status", $parseData["wirepayment_status"]);
               }

               if(isset($parseData["paypal_payment_amount"])){                       
                    add_post_meta($post_id, "paypal_payment_amount", $parseData["paypal_payment_amount"]);
               } 
               
               if(isset($parseData["payment_amount"]) && isset($parseData["bankaccountNumber"])){                       
                    add_post_meta($post_id, "payment_amount", $parseData["payment_amount"]);
                    add_post_meta($post_id, "bankaccountNumber", $parseData["bankaccountNumber"]);
               } 
          
               if(isset($parseData["stripe_customerid"]) && isset($parseData["stripe_payment_amount"]) && isset($parseData["package_recurring_start"]) && isset($parseData["package_recurring_end"]) && isset($parseData["stripe_pack_interval"])){
                    add_post_meta($post_id, "stripe_customerid", $parseData["stripe_customerid"]);
                    add_post_meta($post_id, "stripe_payment_amount", $parseData["stripe_payment_amount"]);              
                    add_post_meta($post_id, "package_recurring_start", $parseData["package_recurring_start"]);
                    add_post_meta($post_id, "package_recurring_end", $parseData["package_recurring_end"]);
                    add_post_meta($post_id, "stripe_pack_interval", $parseData["stripe_pack_interval"]);
                    add_post_meta($post_id, "stripeAmount", $parseData["stripeAmount"]);
                    add_post_meta($post_id, "stripeRecurringstatus", $parseData["stripeRecurringstatus"]);
                    add_post_meta($post_id, "stripe_recurring_payment_method", $parseData["stripe_recurring_payment_method"]);
                    
                    
               }

               if(isset($parseData["stripe_balance_transaction"]) && isset($parseData["stripe_success"])){
                    add_post_meta($post_id, "stripe_balance_transaction", $parseData["stripe_balance_transaction"]);
                    add_post_meta($post_id, "stripe_success", $parseData["stripe_success"]);
                    add_post_meta($post_id, "stripe_payment_method", $parseData["stripe_payment_method"]);
                    
               }
               
          }

          if(is_wp_error($post_id)) {
               return $post_id->get_error_message();
          }

          return $post_id;
     }
}


?>