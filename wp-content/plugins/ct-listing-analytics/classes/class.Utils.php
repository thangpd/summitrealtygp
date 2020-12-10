<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once dirname(__FILE__)."/class.Cache.php";

class ct_la_Utils
{

    var $ct_la_Cache = null;
    
    public function __construct( )
    {

        $this->ct_la_Cache = new ct_la_Cache();

    }

    function getAddress( $postId, $name )
    {
        $keyParts = array(
            "ct_la_Utils",
            "getAddress",
            $postId,
            $name
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }

        $returnValue = "";

        if( taxonomy_exists( $name ) ) {
            $terms_as_text = strip_tags( get_the_term_list( $postId, $name, '', ', ', '' ) );
            if($terms_as_text != '') {
                $returnValue = esc_html($terms_as_text);
            }
        }

        $this->ct_la_Cache->setCache( $keyParts, $returnValue, 3600 * 12 );
        return $returnValue;
    }

    function getStartEndDate( )
    {
        $dateArray = array();

        $startDate = null;
        $endDate = null;
        
        $today = new DateTime( current_time( "Y-m-d" ) );
        $yesterday = new DateTime( current_time( "Y-m-d" ) );
        $yesterday->modify('-1 day');  

        if ( isset( $_GET["endDate"] ) ) {
            $endDate = new DateTime( $_GET["endDate"] );
            $today = false;
            $yesterday = false;
        } else {
            $endDate = new DateTime( current_time( "Y-m-d" ) );
        }
        
        if ( isset( $_GET["startDate"] ) ) {
            $startDate = new DateTime( $_GET["startDate"] );
            $today = false;
            $yesterday = false;
        } else {
            $startDate = new DateTime( current_time( "Y-m-d" ) );
            $startDate->modify('-6 days');
        }

        if( $startDate > $endDate ) {
            $endDate = new DateTime( current_time( "Y-m-d" ) );
            $startDate = new DateTime( current_time( "Y-m-d" ) );
            $startDate->modify('-6 days');  
            

            $today = new DateTime( current_time( "Y-m-d" ) );
            $yesterday = new DateTime( current_time( "Y-m-d" ) );
            $yesterday->modify('-1 day');             
        }

        $dateArray["startDate"] = $startDate;
        $dateArray["endDate"] = $endDate;
        $dateArray["today"] = $today;
        $dateArray["yesterday"] = $yesterday;

        return $dateArray;

    }

    function getListingTitle( $listingId )
    {
        $keyParts = array(
            "ct_la_Utils",
            "getListingTitle",
            $listingId
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }

        $listing = get_post( $listingId );

        //if ( isset( $listing->post_title ) ) {
            $this->ct_la_Cache->setCache( $keyParts, $listing->post_title, 3600 * 12 );
            return $listing->post_title;
        //}

        return false;
    }


    
    function getUsersName( $visitorId )
    {
        $keyParts = array(
            "ct_la_Utils",
            "getUsersName",
            $visitorId
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        $user = $this->getUser($visitorId);

        if ( $user === false ) {
            return false;
        }

        $this->ct_la_Cache->setCache( $keyParts, $user->display_name, 3600 * 12 );
        return $user->display_name;

    }




    
    function getUserMeta( $visitorId )
    {
        $keyParts = array(
            "ct_la_Utils",
            "getUserMeta",
            $visitorId
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        $userMeta = get_user_meta( $visitorId );

        if ( $userMeta === false ) {
            return false;
        }

        $this->ct_la_Cache->setCache( $keyParts, $userMeta, 3600 * 12 );
        return $userMeta;

    }


    function getUser( $visitorId )
    {
        $keyParts = array(
            "ct_la_Utils",
            "getUser",
            $visitorId
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        $user = get_user_by( "id", $visitorId );

        if ( $user === false ) {
            return false;
        }

        $this->ct_la_Cache->setCache( $keyParts, $user, 3600 * 12 );
        $userString = json_encode($user);
        return json_decode($userString, true ); // do this because the cache returns an array so we want to also return an array
       // even ifs its from a get_user_by object 

    }


    function getUsersListingIds( $userId, $userRole )
    {
 
        $keyParts = array(
            "ct_la_Utils",
            "getUsersListingIds",
            $userId,
            $userRole
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }

        global $post;

        $pageTemplate = get_page_template_slug( $post->ID );
        if ( $pageTemplate != "template-user-stats.php" && $pageTemplate != "template-user-stats-detail.php" ) {
            //return;
        }

        $ids = array();
 
        $args =  array(
            'post_type' => 'listings',
            'posts_per_page' => -1,
            'post_status' => array('publish')
        );

        if ( $userRole != 'administrator' ) {
            // on the overview page and not an admin... 
            // filter search for user's properties
            $args["author__in"] = array( $userId );
        }


        $query = new WP_Query(
            $args
        ); 

        if ( is_object( $query ) && !empty( $query ) ) {
            foreach( $query->posts as $postId ) {
                $ids[] = $postId->ID;
            }
        }
        
        $this->ct_la_Cache->setCache( $keyParts, $ids, 3600 );
        return $ids;

    }
}