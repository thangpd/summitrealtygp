<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ct_la_Downloads
{

    var $ct_la_Utils = null;
    var $ct_la_Cache = null;

    /**
     * Constructor
     *
     * @return null
     */
    public function __construct( )
    {
        $this->ct_la_Utils = new ct_la_Utils();
        $this->ct_la_Cache = new ct_la_Cache();
    }


    function ct_la_updateDownloadCount( $existingDownloadId )
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';
        $wpdb->query ( "UPDATE $table_name SET download_count = download_count + 1 WHERE id = $existingDownloadId" );
    }
    
    function ct_la_addDownloadCount( $listingId, $downloadName, $userId, $ip, $userAgent, $referer, $date )
    {

        global $wpdb;

        $user = $this->ct_la_Utils->getUser($userId);
        $email = $user["data"]["user_email"];

        $role = "user";
        foreach( $user["caps"] as $key => $value) {
            $role = $key;
            break;
        }

        $userMeta = $this->ct_la_Utils->getUserMeta($userId);
        
        $firstName = $userMeta["first_name"][0];
        $lastName = $userMeta["last_name"][0];
        $mobile = $userMeta["mobile"][0];

        $listingTitle = $this->ct_la_Utils->getListingTitle($listingId);


        // listing downloads table
        $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';
        
        $return = $wpdb->insert( 
            $table_name,
            array (
                "ip" => $ip,
                "listing_id" => $listingId,
                "download_name" => $downloadName,
                "user_id" => $userId,
                "user_agent" => $userAgent,
                "referer" => $referer,
                "bot" => "unknown",
                "download_count" => 1,
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


    function ct_la_getDownloadId( $userId, $ip, $listingId, $downloadName, $date )
    {


        $keyParts = array(
            "ct_la_Downloads",
            "ct_la_getDownloadId",
            $userId, 
            $ip,
            $listingId,
            $downloadName,
            $date
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;

        if ( strlen( $date ) > 10 ) {
            $date = substr( $date, 0, 10 );
        }

        $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';

        if ( $userId == 0 ) {
            $sql = "SELECT id FROM $table_name WHERE listing_id = $listingId AND download_name = '$downloadName' AND ip = '$ip' AND time BETWEEN '$date 00:00:00' AND '$date 23:59:59'";
        } else {
            $sql = "SELECT id FROM $table_name WHERE listing_id = $listingId AND download_name = '$downloadName' AND user_id = $userId AND time BETWEEN '$date 00:00:00' AND '$date 23:59:59'";
        }

        $downloadId = $wpdb->get_var( $sql );

        if ( $downloadId === null ) {
            return false;
        }

        $this->ct_la_Cache->setCache( $keyParts, intVal( $downloadId ), 3600 );
        return intVal( $downloadId );
    }
}