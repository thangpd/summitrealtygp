<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ct_la_Database
{

    var $o_ct_la_Utils = null;
    var $ct_la_Cache = null;

    /**
     * Constructor
     *
     * @return null
     */
    public function __construct( )
    {
        $this->o_ct_la_Utils = new ct_la_Utils();
        $this->ct_la_Cache = new ct_la_Cache();
    }

    function createTables()
    {
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        global $wpdb;

        $charset_collate    = $wpdb->get_charset_collate();

        // listing views table
        $table_name         = $wpdb->prefix . 'ct_listing_analytics_views';
        $sql                = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            ip tinytext NOT NULL,
            listing_id int NOT NULL,
            listing_title tinytext NOT NULL,
            user_id int NOT NULL,
            user_firstname tinytext NOT NULL,
            user_surname tinytext NOT NULL,
            user_email tinytext NOT NULL,
            user_mobile tinytext NOT NULL,
            user_role varchar(15) NOT NULL,
            user_agent tinytext NOT NULL,
            referer text NOT NULL,
            bot varchar(10) NOT NULL,
            view_count int NOT NULL,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        dbDelta( $sql );


        $table_name         = $wpdb->prefix . 'ct_listing_analytics_downloads';
        $sql                = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            ip tinytext NOT NULL,
            listing_id int NOT NULL,
            listing_title tinytext NOT NULL,
            download_name varchar(50) NOT NULL,
            user_id int NOT NULL,
            user_firstname tinytext NOT NULL,
            user_surname tinytext NOT NULL,
            user_email tinytext NOT NULL,
            user_mobile tinytext NOT NULL,
            user_role varchar(15) NOT NULL,
            user_agent tinytext NOT NULL,
            referer text NOT NULL,
            bot varchar(10) NOT NULL,
            download_count int NOT NULL,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        dbDelta( $sql );   
        

        $table_name         = $wpdb->prefix . 'ct_listing_analytics_bot_user_agents';
        $sql                = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_agent tinytext NOT NULL,
            date_added datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            added_by int NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        dbDelta( $sql );         
    }

    
}