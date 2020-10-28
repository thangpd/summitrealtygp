<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once dirname(__FILE__)."/class.Cache.php";
require_once dirname(__FILE__)."/class.Utils.php";

class ct_la_Views
{

    var $ct_la_Cache = null;
    var $ct_la_Utils = null;
    
    public function __construct( )
    {

        $this->ct_la_Cache = new ct_la_Cache();
        $this->ct_la_Utils = new ct_la_Utils();

    }

    function ct_la_updateViewCount( $existingViewId )
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'ct_listing_analytics_views';
        $wpdb->query ( "UPDATE $table_name SET view_count = view_count + 1 WHERE id = $existingViewId" );
    }
    
    function ct_la_addViewCount( $listingId, $userId, $ip, $userAgent, $referer, $date )
    {

        global $wpdb;

        $user = $this->ct_la_Utils->getUser($userId);
        $userMeta = $this->ct_la_Utils->getUserMeta($userId);
        
        $email = isset( $user["data"]["user_email"] ) ? $user["data"]["user_email"] : '';

        $role = "user";

        if(!empty($user["caps"])) {
            foreach( $user["caps"] as $key => $value) {
                $role = $key;
                break;
            }
        }

        $firstName = isset( $userMeta["first_name"][0] ) ? $userMeta["first_name"][0] : '-';
        $lastName = isset( $userMeta["last_name"][0] ) ? $userMeta["last_name"][0] : '-';
        $mobile = isset( $userMeta["mobile"][0] ) ? $userMeta["mobile"][0] : '-';
        $email = isset( $userMeta["email"][0] ) ? $userMeta["email"][0] : '-';

        $listingTitle = $this->ct_la_Utils->getListingTitle($listingId);

        // listing views table
        $table_name = $wpdb->prefix . 'ct_listing_analytics_views';
    
        $wpdb->insert( 
            $table_name,
            array (
                "ip" => $ip,
                "listing_id" => $listingId,
                "user_id" => $userId,
                "user_agent" => $userAgent,
                "referer" => $referer,
                "bot" => "unknown",
                "view_count" => 1,
                "time" => $date,
                "user_firstname" => $firstName,
                "user_surname" => $lastName,
                "user_mobile" => $mobile,
                "user_email" => $email,
                "user_role" => $role,
                "listing_title" => $listingTitle
            )
        );

    }


    function ct_la_getViewId( $userId, $ip, $listingId, $date )
    {
        global $wpdb;

        if ( strlen( $date ) > 10 ) {
            $date = substr( $date, 0, 10 );
        }


        $keyParts = array (
            "ct_la_Views",
            "ct_la_getViewId",
            $userId,
            $ip,
            $listingId,
            $date
        );
            
        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }

        $table_name = $wpdb->prefix . 'ct_listing_analytics_views';

        if ( $userId == 0 ) {
            // get view ids
            $sql = "SELECT id FROM $table_name WHERE listing_id = $listingId AND ip = '$ip' AND time BETWEEN '$date 00:00:00' AND '$date 23:59:59'";
        } else {
            $sql = "SELECT id FROM $table_name WHERE listing_id = $listingId AND user_id = $userId AND time BETWEEN '$date 00:00:00' AND '$date 23:59:59'";
        }

        $viewId = $wpdb->get_var( $sql );

        if ( $viewId === null ) {
            return false;
        }

        $return = intVal( $viewId );

        $this->ct_la_Cache->setCache( $keyParts, $return, 3600 );

        return $return;
    }
}