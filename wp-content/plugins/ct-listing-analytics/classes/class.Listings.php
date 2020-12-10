<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once dirname(__FILE__)."/class.Utils.php";
require_once dirname(__FILE__)."/class.Cache.php";

class ct_la_Listings
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

    
    function getDataDetail( $userId, $userRole, $listingIds, $startDate, $endDate, $visitorId, $paged, $perPage, &$sql="" )
    {

        $keyParts = array(
            "ct_la_Listings",
            "getDataDetail",
            $userId, 
            $userRole,
            $listingIds, 
            $startDate, 
            $endDate,
            $visitorId,
            $paged,
            $perPage
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;

        $visitorFilter = "";
        if ( $visitorId > 0 ) {
            $visitorFilter = " user_id = ".$visitorId." AND ";
        }

        $table_name = $wpdb->prefix . 'ct_listing_analytics_views';

        $sql = "SELECT *
        FROM 
            ".$table_name." 
        WHERE ";


        if ( $visitorId > 0 ) {
            $sql = $sql.$table_name.".user_id = ".$visitorId." AND ";
        } else {
            $sql = $sql.$table_name.".user_id > 0 AND ";
            $sql = $sql." listing_id IN (".implode( ",", $listingIds ).") AND ";
        }

        $sql = $sql." time between '".$startDate."' AND '".$endDate."'";

        if ( $visitorId == 0 ) {
            $sql = $sql." UNION
            SELECT 
                * 
            FROM 
                ".$table_name." 
            WHERE 
                ".$table_name.".user_id = 0 AND 
                listing_id IN (".implode( ",", $listingIds ).") AND 
                time between '".$startDate."' AND '".$endDate."'";
        }

        if ( $perPage > 0 ) {
            $sql = $sql." LIMIT ".(($paged - 1) * $perPage).", ".$perPage;
        }

        //print "sql: ".$sql."<p>";
        $results = $wpdb->get_results( $sql, ARRAY_A );
  
        //print "results: ".print_r($results, true)."<p>";

        $data = array();
        $listingTitle = "";

        if ( is_array( $results ) && count( $results ) > 0 ) {
            foreach ( $results as $result ) {
                $data[] = [
                    "userId" => $result["user_id"], 
                    "listingId" => $result["listing_id"], 
                    "listingTitle" => $result["listing_title"], 
                    "userRole" =>  $result["user_role"], 
                    "firstName" => $result["user_firstname"], 
                    "lastName" => $result["user_surname"], 
                    "email" => $result["user_email"], 
                    "mobile" => $result["user_mobile"]
                ];
            }
        }


        $this->ct_la_Cache->setCache( $keyParts, $data, 900 );
        return $data;
    }








    function getDataDetailAll( $userId, $userRole, $startDate, $endDate, &$sql="" )
    {

        $keyParts = array(
            "ct_la_Listings",
            "getDataDetailAll",
            $userId, 
            $userRole, 
            $startDate, 
            $endDate
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;

        $table_name = $wpdb->prefix . 'ct_listing_analytics_views';

        $sql = "SELECT *
        FROM 
            ".$table_name." 
        WHERE ".$table_name.".user_id > 0 AND ";

        $sql = $sql." time between '".$startDate."' AND '".$endDate."'";

            $sql = $sql." UNION
            SELECT 
                *    
            FROM 
                ".$table_name." 
            WHERE 
                ".$table_name.".user_id = 0 AND 
                time between '".$startDate."' AND '".$endDate."'";



        //print "sql: ".$sql."<p>";
        $results = $wpdb->get_results( $sql, ARRAY_A );
  
        //print "results: ".print_r($results, true)."<p>";

        $data = array();
        $listingTitle = "";

        if ( is_array( $results ) && count( $results ) > 0 ) {
            foreach ( $results as $result ) {

                $data[] = [
                    "userId" => $result["user_id"], 
                    "viewTime" => $result["time"],
                    "listingId" => $result["listing_id"], 
                    "listingTitle" => $result["listing_title"], 
                    "userRole" =>  $result["user_role"], 
                    "firstName" => $result["user_firstname"], 
                    "lastName" => $result["user_surname"], 
                    "email" => $result["user_email"], 
                    "mobile" => $result["user_mobile"]
                ];

            }
        }


        $this->ct_la_Cache->setCache( $keyParts, $data, 900 );
        return $data;
    }


    
    function getDataDetailCount( $userId, $userRole, $listingIds, $startDate, $endDate, $visitorId )
    {

        $keyParts = array(
            "ct_la_Listings",
            "getDataDetailCount",
            $userId, 
            $userRole,
            $listingIds, 
            $startDate, 
            $endDate,
            $visitorId
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;

        $table_name = $wpdb->prefix . 'ct_listing_analytics_views';

        $listingFilter = " listing_id IN (".implode( ",", $listingIds ).") AND ";

        $visitorFilter = "";
        if ( $visitorId > 0 ) {
            $visitorFilter = "user_id = ".$visitorId." AND ";
            $listingFilter = "";
        }
        
        $sql = "SELECT 
            COUNT(".$table_name.".id) AS count
        FROM 
            ".$table_name." 
        WHERE 
            ".$visitorFilter."
            ".$listingFilter."
            time between '".$startDate."' AND '".$endDate."'";

            //print "sql: ".$sql."<p>";

        $results = $wpdb->get_var( $sql );
 
        $this->ct_la_Cache->setCache( $keyParts, intVal( $results ), 900 );
        return intVal( $results );
    }


    function getData( $userId, $userRole, $listingIds, $startDateString, $endDateString, $visitorId, $paged=1, $perPage )
    {
        $keyParts = array(
            "ct_la_Listings",
            "getData",
            $userId,
            $userRole,
            $listingIds,
            $startDateString,
            $endDateString,
            $visitorId,
            $paged,
            $perPage
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;


        $table_name = $wpdb->prefix . 'ct_listing_analytics_views';

        if ( $visitorId > 0 ) {
            $sql = "SELECT listing_id, COUNT(listing_id) AS count, listing_title FROM ".$table_name." WHERE user_id = ".$visitorId." AND time BETWEEN '".$startDateString."' AND '".$endDateString."' AND listing_id IN (".implode( ",", $listingIds ).") GROUP BY listing_id ORDER BY count DESC ";
            
            if ( $perPage > 0 ) {
                $sql = $sql." LIMIT ".(($paged - 1) * $perPage).", ".$perPage.";";
            }

        } else {
            $sql = "SELECT listing_id, COUNT(listing_id) AS count, listing_title FROM ".$table_name." WHERE time BETWEEN '".$startDateString."' AND '".$endDateString."' AND listing_id IN (".implode( ",", $listingIds ).") GROUP BY listing_id ORDER BY count DESC ";
            
            if ( $perPage > 0 ) {
                $sql = $sql." LIMIT ".(($paged - 1) * $perPage).", ".$perPage.";";
            }

        }

        
        $results = $wpdb->get_results( $sql, ARRAY_A );
        
        $data = array();

        if ( is_array( $results ) && count( $results ) > 0 ) {
            foreach ( $results as $result ) {
                $data[] = [
                    "listingId" => $result["listing_id"], 
                    "title" => $result["listing_title"],
                    "count" => $result["count"]
                ];
            }
        }

        $this->ct_la_Cache->setCache( $keyParts, $data, 900 );
        return $data;
    }





    
    function getDataCount( $listingIds, $startDateString, $endDateString )
    {

        $keyParts = array(
            "ct_la_Listings",
            "getDataCount",
            $listingIds,
            $startDateString,
            $endDateString
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;

        $table_name = $wpdb->prefix . 'ct_listing_analytics_views';

        $sql = "SELECT COUNT(listing_id) AS count FROM ".$table_name." WHERE time BETWEEN '".$startDateString."' AND '".$endDateString."' AND listing_id IN (".implode( ",", $listingIds ).") ;";
        

        $results = $wpdb->get_var( $sql );

        if ( $results != null ) {
            $this->ct_la_Cache->setCache( $keyParts, intVal( $results ), 300 );
            return intVal( $results );
        }

        $this->ct_la_Cache->setCache( $keyParts, 0, 300 );
        return 0;

    }

    function getDataRowCount( $userId, $userRole, $listingIds, $startDateString, $endDateString )
    {
        $keyParts = array(
            "ct_la_Listings",
            "getDataRowCount",
            $userId,
            $userRole,
            $listingIds,
            $startDateString,
            $endDateString
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;

        $table_name = $wpdb->prefix . 'ct_listing_analytics_views';

        $sql = "SELECT COUNT(count) as count from (SELECT COUNT(listing_id) AS count FROM ".$table_name." WHERE listing_id IN (".implode( ",", $listingIds ).") AND time BETWEEN '".$startDateString."' AND '".$endDateString."' GROUP BY listing_id) a;";
        

        $results = $wpdb->get_var( $sql );

        if ( $results != null ) {
            $this->ct_la_Cache->setCache( $keyParts, intVal( $results ), 900 );
            return intVal( $results );
        }

        $this->ct_la_Cache->setCache( $keyParts, 0, 900 );
        return 0;

    }



    function getDetail( $userId, $userRole, $listingIds, $dateArray, $visitorId, $paged, $perPage )
    {
        $keyParts = array(
            "ct_la_Listings",
            "getDetail",
            $userId,
            $userRole,
            $listingIds,
            $dateArray,
            $visitorId,
            $paged,
            $perPage
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            print $cache;
            return;
        }


        $today = $dateArray["today"];
        $yesterday = $dateArray["yesterday"];
        $startDate = $dateArray["startDate"];
        $endDate = $dateArray["endDate"];

        $startDateString = "";
        $endDateString = "";

        if ( $today !== false && $yesterday !== false ) {
            $startDateString = $today->format("Y-m-d 00:00:00");
            $endDateString = $today->format("Y-m-d 23:59:59");
        } else {
            $startDateString = $startDate->format("Y-m-d 00:00:00");
            $endDateString = $endDate->format("Y-m-d 23:59:59");
        }

        $dataDetailCount = $this->getDataDetailCount( $userId, $userRole, $listingIds, $startDateString, $endDateString, $visitorId );

        $data = $this->getDataDetail( $userId, $userRole, $listingIds, $startDateString, $endDateString, $visitorId, $paged, $perPage );

        wp_localize_script( 'ct_get_detail_listing_ajax_script', 'detail_listing_ajax_object',
            array(
                'ajax_url'      => admin_url('admin-ajax.php'),
                'paged'         => 1,
                'listingId'     => $listingIds[0],
                'visitorId'     => $visitorId,
                'userId'        => $userId,
                'userRole'      => $userRole,
                'startDate'     => $startDateString,
                'endDate'       => $endDateString,
                'totalCount'    => $dataDetailCount
            )
        );


        ob_start();

        ?>


        <table>
            <thead>
                <tr>
                    <?php 
                    if ( $visitorId > 0 ) {
                    ?>
                        <th><?php _e('Listing', 'ct-listing-analytics'); ?></th>
                    <?php
                    }
                    ?>
                    <th><?php _e('Role (ID)', 'ct-listing-analytics'); ?></th>
                    <th><?php _e('First Name', 'ct-listing-analytics'); ?></th>
                    <th><?php _e('Last Name', 'ct-listing-analytics'); ?></th>
                    <th><?php _e('Email', 'ct-listing-analytics'); ?></th>
                    <th><?php _e('Phone', 'ct-listing-analytics'); ?></th>
                </tr>
            </thead>
            <tbody id="detail-listing-table">

                <?php
                if ( is_array( $data) && !empty( $data ) ) {
                    foreach ( $data as $dataLine ) {
                        ?>
                        <tr>
                            <?php
                            if ( $visitorId > 0 ) {
                                print "<td>".$dataLine["listingTitle"]."</td>";
                            }
                            ?>
                            <td>
                                <?php 
                                if ( is_numeric( $dataLine["userId"] ) ) {
                                    ?>
                                    <a href="./?listing-id=<?php print $listingIds[0]; ?>&startDate=<?php print $startDateString; ?>&endDate=<?php print $endDateString; ?>&visitorId=<?php print $dataLine["userId"]; ?>"><?php print ucfirst($dataLine["userRole"]) . " (" . $dataLine["userId"] . ")"; ?></a>
                                    <?php
                                } else {
                                    print $dataLine["userId"];
                                }
                                ?>
                            </td>
                            <td><?php print $dataLine["firstName"]; ?></td>
                            <td><?php print $dataLine["lastName"]; ?></td>
                            <td><a href="mailto:<?php print $dataLine["email"]; ?>" target="_blank"><?php print $dataLine["email"]; ?></a></td>
                            <td><?php print $dataLine["mobile"]; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>

            </tbody>


        </table>
        <?php
        $pages = intVal( $dataDetailCount / $perPage );
        $pages = $pages + (($dataDetailCount % $perPage)?1:0);

        if ( $pages > 1 ) {

            print "<div class=\"pagination\"><ul>";

                print "<li class=\"current\"><a href=\"\" data-paged=\"1\" class=\"ct-listing-paged\">1</a></li>";

                $x = 2;
                for( $x = 2; $x <= (($pages<3)?$pages:3); $x++ ) {
                    print "<li><a href=\"\" data-paged=\"".$x."\" class=\"ct-listing-paged\">".$x."</a></li>";
                }
                
                $x--;
                if ( $x < $pages ) {
                    $y = $pages - 2;
                    if ( $y <= ($x + 1) ) {
                        $y = $x + 1;
                    } else {
                        print "<li>...</li>";
                    }

                    for( $y = $y; $y <= $pages; $y++ ) {
                        print "<li><a href=\"\" data-paged=\"".$y."\" class=\"ct-listing-paged\">".$y."</a></li>";
                    }
                }

                print "<li id=\"next-page-link\"><a href=\"\" data-paged=\"2\" id=\"detail-listing-next\">Next</a></li>";

                print "<div class=\"clear\"></div>";
                print "</ul>";
            print "</div>";
        }


        $o = ob_get_contents();
        ob_end_clean();

        $this->ct_la_Cache->setCache( $keyParts, $o, 900 );
        print $o;

    }


    function getSummary( $userId, $userRole, $listingIds, $dateArray, $visitorId, $oCSV=null )
    {

        $keyParts = array(
            "ct_la_Listings",
            "getSummary",
            $userId,
            $userRole,
            $listingIds,
            $dateArray,
            $visitorId
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            print $cache;
            return;
        }


        $today = $dateArray["today"];
        $yesterday = $dateArray["yesterday"];
        $startDate = $dateArray["startDate"];
        $endDate = $dateArray["endDate"];

        $startDateString = "";
        $endDateString = "";

        if ( $today !== false && $yesterday !== false ) {
            $startDateString = $today->format("Y-m-d 00:00:00");
            $endDateString = $today->format("Y-m-d 23:59:59");
        } else {
            $startDateString = $startDate->format("Y-m-d 00:00:00");
            $endDateString = $endDate->format("Y-m-d 23:59:59");
        }

        $data = $this->getData( $userId, $userRole, $listingIds, $startDateString, $endDateString, $visitorId, 1, -1 );

        $views = 0;
        foreach( $data as $item ) {
            $views = $views + intVal( $item["count"] );
        }

        $title = $data[0]["title"];

        ob_start();
        ?>
        
        <div class="col span_12 first border-bottom marB30 padB20">
            <div class="col span_9 first">
                <h3 class="marB5"><?php print $views; ?> <?php if($views == 1) { _e('View', 'ct-listing-analytics'); } else { _e('Views', 'ct-listing-analytics'); } ?></h3>
                

                <?php
                if ( $visitorId < 1 ) {

                    $address = "";
                    $city = $this->o_ct_la_Utils->getAddress( $listingIds[0], "city" );
                    $state = $this->o_ct_la_Utils->getAddress( $listingIds[0], "state" );
                    $zipcode = $this->o_ct_la_Utils->getAddress( $listingIds[0], "zipcode" );
                    $country = $this->o_ct_la_Utils->getAddress( $listingIds[0], "country" );
        
                    if ( $city != "" ) {
                        $address = $address.$city.", ";
                    }

                    if ( $state != "" ) {
                        $address = $address.$state.", ";
                    }
                    
                    if ( $zipcode != "" ) {
                        $address = $address.$zipcode.", ";
                    }
                    
                    if ( $country != "" ) {
                        $address = $address.$country.", ";
                    }

                    if ( $address != "" ) {
                        $address = trim ( substr($address, 0, strlen( $address ) - 2 ) );
                    }
                    
                ?>
                
                    <h4 class="muted"><a href="/?p=<?php print $listingIds[0]; ?>"><?php print $title; ?></a></h4>

                    <p class="left muted marB10"> <a href="/?p=<?php print $listingIds[0]; ?>"><?php print $address; ?></a></p>

                <?php
                } else {
                    print "<h5 class=\"muted marB20\">".$this->o_ct_la_Utils->getUsersName( $visitorId )."</h5>";
                }
                ?>
                
            </div>
            <div class="col span_3">
            <p><textarea id="analytics-detail-date" class="right"><?php print $startDate->format("n/j/y"); ?> - <?php print $endDate->format("n/j/y"); ?></textarea></p>  


            <?php

            if( $oCSV != null ) {
                $link = $oCSV->makeCSV("detail", $startDate->format("Y-m-d 00:00:00"), $endDate->format("Y-m-d 23:59:59"),  $listingIds, $userId, $userRole, $visitorId );
                ?>
                <div id="analytics-detail-csv" class="right">
                    <a href="<?php print $link; ?>" target="_new"><?php _e('Download CSV', 'ct-listing-analytics'); ?></a>
                </div>
                <?php
            }
            ?>




            </div>
        </div>
        <?php

        $o = ob_get_contents();
        ob_end_clean();

        $this->ct_la_Cache->setCache( $keyParts, $o, 900 );
        print $o;

    }

    function getListings( $userId, $userRole, $listingIds, $dateArray )
    {

        $keyParts = array(
            "ct_la_Listings",
            "getListings",
            $userId,
            $userRole,
            $listingIds,
            $dateArray
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            print $cache;
            return;
        }



        $today = $dateArray["today"];
        $yesterday = $dateArray["yesterday"];
        $startDate = $dateArray["startDate"];
        $endDate = $dateArray["endDate"];

        $perPage = 10;

        ob_start();
        ?>


        <!-- Top Listings -->

        <div class="col span_6 first">
            <div class="user-stats-inner">
                <h4 class="border-bottom marT0 marB20"><?php _e('Top Listings', 'ct-listing-analytics'); ?></h4>

                 <ul class="tabs marB30">

                    <?php
                    $startDateString = "";
                    $endDateString = "";
                    if ( $today !== false && $yesterday !== false ) {
                        $startDateString = $today->format("Y-m-d 00:00:00");
                        $endDateString = $today->format("Y-m-d 23:59:59");
                    ?>
                        <li><a href="#tab-today-listings"><?php _e('Today', 'ct-listing-analytics'); ?></a></li>
                        <li><a href="#tab-yesterday-listings"><?php _e('Yesterday', 'ct-listing-analytics'); ?></a></li>                    
                    <?php
                    } else {
                        $startDateString = $startDate->format("Y-m-d 00:00:00");
                        $endDateString = $endDate->format("Y-m-d 23:59:59");                        
                    ?>
                        <li><?php print $startDate->format("n/j/y"); ?> - <?php print $endDate->format("n/j/y"); ?></li>                    
                    <?php
                    }
                    ?>

                </ul>
                
                <div class="clear"></div>

                <div class="inside">

                    <!-- Today -->
                    <div id="tab-today-listings">
                        <table class="marB0">
                            <thead>
                                <tr>
                                    <th><?php _e('Listing', 'ct-listing-analytics'); ?></th>
                                    <th class="center"><i class="fa fa-eye"></i></th>
                                </tr>
                            </thead>

                            <?php
                                

                            $totalCount = $this->getDataCount( $listingIds,  $startDateString, $endDateString, 0 );
                            $totalRowCount = $this->getDataRowCount( $userId, $userRole, $listingIds,  $startDateString, $endDateString, 0 );
                            
                
                            wp_localize_script( 'ct_get_listing_today_ajax_script', 'listing_today_ajax_object',
                                array(
                                    'ajax_url'      => admin_url('admin-ajax.php'),
                                    'paged'         => 1,
                                    'userId'        => $userId,
                                    'userRole'      => $userRole,
                                    'startDate'     => $startDateString,
                                    'endDate'       => $endDateString,
                                    'visitorId'     => 0,
                                    'linkStartDate' => $startDate->format("Y-m-d 00:00:00"),
                                    'linkEndDate'   => $endDate->format("Y-m-d 23:59:59"),
                                    'totalCount'    => $totalCount,
                                    'totalRowCount' => $totalRowCount
                                )
                            );


                            $data = $this->getData( $userId, $userRole, $listingIds, $startDateString, $endDateString, 0, 1, 10 );

                            ?>

                            <tbody id="overview-listing-today-table">    
                                
                            <?php
                                if ( is_array( $data ) && !empty( $data ) ) {

                                    foreach ( $data as $item ) {
                                        print "<tr><td><a href=\"?listing-id=".$item["listingId"]."&startDate=".$startDate->format("Y-m-d 00:00:00")."&endDate=".$endDate->format("Y-m-d 23:59:59")."\">".$item["title"]."</a></td><td class=\"center\">".$item["count"]."</td></tr>";
                                    }  

                                } else {
                                    print "<tr><td class=\"no-data\" colspan=\"2\">" . __('No analytics data yet, check back soon', 'ct-listing-analytics') . "</td></tr>";
                                }
                            ?>

                            </tbody>
                            
                            <tfoot>
                                <tr>
                                    <th><?php _e('Total Views', 'ct-listing-analytics'); ?></th>
                                    <th  class="center" id="overview-listing-today-total"><?php print $totalCount; ?></th>
                                </tr>
                            </tfoot>

                        </table>

                        <?php
                        if ( $totalRowCount > $perPage ) {
                        ?>   
                        

                            <div class="col span_12 first marT20">
                                <div class="col span_6 first">
                                    <a class="btn disabled" disabled="disabled" href="" id="overview-listing-today-previous"><?php _e('Previous', 'ct-listing-analytics'); ?></a>
                                </div>
                                <div class="col span_6 rightalign">
                                    <a class="btn" href="" id="overview-listing-today-next"><?php _e('Next', 'ct-listing-analytics'); ?></a>
                                </div>
                            </div>
                            <div class="clear"></div>

                        <?php
                        }
                        ?>
                        

                    </div>
                    <!-- //Today -->

                    <?php
                    if ( $today !== false && $yesterday !== false ) {
                        $startDateString = $yesterday->format("Y-m-d 00:00:00");
                        $endDateString = $yesterday->format("Y-m-d 23:59:59");
                    ?>
                        <!-- Yesterday -->
                        <div id="tab-yesterday-listings">
                            <table class="marB0">
                                <thead>
                                    <tr>
                                        <th><?php _e('Listing', 'ct-listing-analytics'); ?></th>
                                        <th class="center"><i class="fa fa-eye"></i></th>
                                    </tr>
                                </thead>

                                <tbody id="overview-listing-yesterday-table">

                                <?php
                                $data = $this->getData( $userId, $userRole, $listingIds, $startDateString, $endDateString, 0, 1, 10 );
                                $totalCount = $this->getDataCount( $listingIds, $startDateString, $endDateString, 0 );
                                $totalRowCount = $this->getDataRowCount( $userId, $userRole, $listingIds,$startDateString, $endDateString, 0 );

                            

                                wp_localize_script( 'ct_get_listing_yesterday_ajax_script', 'listing_yesterday_ajax_object',
                                    array(
                                        'ajax_url'      => admin_url('admin-ajax.php'),
                                        'paged'         => 1,
                                        'userId'        => $userId,
                                        'userRole'      => $userRole,
                                        'startDate'     => $startDateString,
                                        'endDate'       => $endDateString,
                                        'visitorId'     => 0,
                                        'linkStartDate' => $startDate->format("Y-m-d 00:00:00"),
                                        'linkEndDate'   => $endDate->format("Y-m-d 23:59:59"),
                                        'totalCount'    => $totalCount,
                                        'totalRowCount' => $totalRowCount

                                    )
                                );
    
                                $total = 0;
                                foreach ( $data as $item ) {
                                    $total = $total + $item["count"];
                                ?>
                                    <tr>
                                        <td><a href="?listing-id=<?php print $item["listingId"]; ?>&startDate=<?php print $startDate->format("Y-m-d 00:00:00"); ?>&endDate=<?php print $endDate->format("Y-m-d 23:59:59"); ?>"><?php print $item["title"]; ?></a></td>
                                        <td class="center"><a href="?listing-id=<?php print $item["listingId"]; ?>&startDate=<?php print $startDate->format("Y-m-d 00:00:00"); ?>&endDate=<?php print $endDate->format("Y-m-d 23:59:59"); ?>"><?php print $item["count"]; ?></a></td>
                                    </tr>
                                <?php
                                }

                                if ( $total == 0 ) {
                                    print "<tr><td class=\"no-data\" colspan=\"2\">" . __('No analytics data yet, check back soon', 'ct-listing-analytics') . "</td></tr>";
                                }
                                ?>
                                
                                </tbody>
                                <tfoot>

                                <tr>
                                    <th><?php _e('Total Views', 'ct-listing-analytics'); ?></th>
                                    <th class="center"><?php _e($totalCount, 'ct-listing-analytics'); ?></th>
                                </tr>
                                </tfoot>

                            </table>


                            <?php
                            if ( $totalRowCount > $perPage ) {
                            ?>     

                                <div class="col span_12 first marT20">
                                    <div class="col span_6 first">
                                        <a class="btn disabled" disabled="disabled" href="" id="overview-listing-yesterday-previous"><?php _e('Previous', 'ct-listing-analytics'); ?></a>
                                    </div>
                                    <div class="col span_6 rightalign">
                                        <a class="btn" href="" id="overview-listing-yesterday-next"><?php _e('Next', 'ct-listing-analytics'); ?></a>
                                    </div>
                                </div>
                                <div class="clear"></div>

                            <?php
                            }
                            ?>
                            

                        </div>
                        <!-- //Yesterday -->
                    <?php
                    }
                    ?>

                </div>
                <!-- //Inside -->
            </div>
            <!-- //User Stats Inner -->
        </div>
        <!-- //Top Listings -->
        <?php
    
        $o = ob_get_contents();
        ob_end_clean();

        $this->ct_la_Cache->setCache( $keyParts, $o, 900 );
        print $o;

    }
    
}