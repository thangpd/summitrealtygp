<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ct_la_ListingDownloads
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



    
    function getDataCount( $userId, $userRole, $listingIds, $startDateString, $endDateString )
    {

        $keyParts = array(
            "ct_la_ListingDownloads",
            "getDataCount",
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

        $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';

        $sql = "SELECT COUNT(listing_id) AS count FROM ".$table_name." WHERE listing_id IN (".implode( ",", $listingIds ).") AND time BETWEEN '".$startDateString."' AND '".$endDateString."';";
    

        $results = $wpdb->get_var( $sql );

        if ( $results != null ) {
            $this->ct_la_Cache->setCache( $keyParts, intVal( $results ), 900 );
            return intVal( $results );
        }

        $this->ct_la_Cache->setCache( $keyParts, 0, 900 );
        return 0;

    }

    function getDataRowCount( $userId, $userRole, $listingIds, $startDateString, $endDateString )
    {

        $keyParts = array(
            "ct_la_ListingDownloads",
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

        $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';

        $sql = "SELECT COUNT(count) as count from (SELECT COUNT(download_name) AS count FROM ".$table_name." WHERE listing_id IN (".implode( ",", $listingIds ).") AND time BETWEEN '".$startDateString."' AND '".$endDateString."' GROUP BY download_name, listing_id) a;";


        $results = $wpdb->get_var( $sql );


        if ( $results != null ) {
            $this->ct_la_Cache->setCache( $keyParts, intVal( $results ), 900 );
            return intVal( $results );
        }

        $this->ct_la_Cache->setCache( $keyParts, 0, 900 );
        return 0;


    }




    function getData( $userId, $userRole, $listingIds, $startDateString, $endDateString, $downloadName="", $visitorId, $paged=1, $perPage )
    {

        $keyParts = array(
            "ct_la_ListingDownloads",
            "getData",
            $userId, 
            $userRole,
            $listingIds, 
            $startDateString,
            $endDateString,
            $downloadName,
            $visitorId,
            $paged,
            $perPage
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }

        global $wpdb;

        $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';

        $listingIdFilter = " listing_id IN (".implode( ",", $listingIds ).") AND ";

        $visitorFilter = "";
        if ( $visitorId > 0 ) {
            $visitorFilter = " user_id = ".$visitorId." AND ";
            $listingIdFilter = "";
            $downloadName = "";
        }

        if ( $downloadName != "" ) {
            $sql = "SELECT download_name, COUNT(download_name) AS count, listing_id, listing_title FROM ".$table_name." WHERE ".$visitorFilter.$listingIdFilter." download_name = '".$downloadName."' AND time BETWEEN '".$startDateString."' AND '".$endDateString."' GROUP BY download_name, listing_id ORDER BY count DESC ";
     
            if ( $perPage > 0 ) {
                $sql = $sql." LIMIT ".(($paged - 1) * $perPage).", ".$perPage.";";
            }

        } else {            
            $sql = "SELECT download_name, COUNT(download_name) AS count, listing_id, listing_title FROM ".$table_name." WHERE  time BETWEEN '".$startDateString."' AND '".$endDateString."' GROUP BY download_name, listing_id ORDER BY count DESC ";
                        
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
                    "downloadName" => $result["download_name"], 
                    "count" => $result["count"]
                ];
            }
        }
        
        $this->ct_la_Cache->setCache( $keyParts, $data, 900 );
        return $data;
    }






    function getDataDetailAll( $userId, $userRole, $startDateString, $endDateString, &$sql="" )
    {

        $keyParts = array(
            "ct_la_ListingDownloads",
            "getDataDetailAll",
            $userId, 
            $userRole,
            $startDateString,
            $endDateString,
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;

        $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';

        $sql = "SELECT 
            *
        FROM 
            ".$table_name." 
        WHERE ";
        

        $sql = $sql.$table_name.".user_id > 0 AND ";
        $sql = $sql." time between '".$startDateString."' AND '".$endDateString."' ";


        $sql = $sql." UNION
            SELECT 
                *
            FROM 
            ".$table_name." 
            WHERE 
            ".$table_name.".user_id = 0 AND 
            time between '".$startDateString."' AND '".$endDateString."';";

    
        $results = $wpdb->get_results( $sql, ARRAY_A );
  
        $data = array();

        if ( is_array( $results ) && count( $results ) > 0 ) {
            foreach ( $results as $result ) {

                $data[] = [
                    "userId" => $result["user_id"], 
                    "userRole" =>  $result["user_role"], 
                    "firstName" => $result["user_firstname"], 
                    "lastName" => $result["user_surname"], 
                    "email" => $result["user_email"], 
                    "mobile" => $result["user_mobile"], 
                    "listingId" => $result["listing_id"], 
                    "downloadName" => $result["download_name"], 
                    "listingTitle" => $result["listing_title"],
                    "viewTime" => $result["time"]
                ];
            }
        }

        $this->ct_la_Cache->setCache( $keyParts, $data, 900 );
        return $data;
    }








    function getDataDetail( $userId, $userRole, $listingIds, $startDateString, $endDateString, $downloadName, $visitorId, $paged, $perPage, &$sql="" )
    {

        $keyParts = array(
            "ct_la_ListingDownloads",
            "getDataDetail",
            $userId, 
            $userRole,
            $listingIds, 
            $startDateString,
            $endDateString,
            $downloadName,
            $visitorId,
            $paged,
            $perPage
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;

        $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';

        $sql = "SELECT 
            *
        FROM 
            ".$table_name."            
        WHERE ";
        

        if ( $visitorId > 0 ) {
            $sql = $sql.$table_name.".user_id = ".$visitorId." AND ";
        } else {
            $sql = $sql.$table_name.".user_id > 0 AND ";
        }

        if ( $visitorId == 0 ) {
            $sql = $sql." listing_id IN (".implode( ",", $listingIds ).") AND ";
        }

        $sql = $sql." time between '".$startDateString."' AND '".$endDateString."' ";

        if ( $visitorId == 0 ) {
            $sql = $sql." AND download_name = '".$downloadName."'";
        }

        if ( $visitorId == 0 ) {
            $sql = $sql." UNION
                SELECT 
                    *
                FROM 
                ".$table_name." 
                WHERE 
                ".$table_name.".user_id = 0 
                AND listing_id IN (".implode( ",", $listingIds ).")  AND 
                time between '".$startDateString."' AND '".$endDateString."' AND
                download_name = '".$downloadName."'";
        }

        if ( $perPage > 0 ) {
            $sql = $sql." LIMIT ".(($paged - 1) * $perPage).", ".$perPage;
        }

        $results = $wpdb->get_results( $sql, ARRAY_A );
  
        $data = array();

        if ( is_array( $results ) && count( $results ) > 0 ) {
            foreach ( $results as $result ) {


                $data[] = [
                    "userId" => $result["user_id"], 
                    "userRole" =>  $result["user_role"], 
                    "firstName" => $result["user_firstname"], 
                    "lastName" => $result["user_surname"], 
                    "email" => $result["user_email"], 
                    "mobile" => $result["user_mobile"], 
                    "listingId" => $result["listing_id"], 
                    "downloadName" => $result["download_name"], 
                    "listingTitle" => $result["listing_title"]
                ];
            }
        }

        $this->ct_la_Cache->setCache( $keyParts, $data, 900 );
        return $data;
    }




    function getDataDetailCount( $userId, $userRole, $listingIds, $startDateString, $endDateString, $downloadName, $visitorId )
    {

        $keyParts = array(
            "ct_la_ListingDownloads",
            "getDataDetailCount",
            $userId, 
            $userRole,
            $listingIds, 
            $startDateString,
            $endDateString,
            $downloadName,
            $visitorId
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            return $cache;
        }


        global $wpdb;

        $listingIdFilter = " listing_id IN (".implode( ",", $listingIds ).") AND ";
        $visitorFilter = "";
        if ( $visitorId > 0 ) {
            $visitorFilter = " user_id = ".$visitorId." AND ";
            $listingIdFilter = "";
        }

        $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';

        $sql = "SELECT 
        COUNT(id) AS count FROM ".$table_name." WHERE "
        .$visitorFilter
        .$listingIdFilter
        ." time between '".$startDateString."' AND '".$endDateString."'";
        
        if ( $visitorId == 0 ) {
            $sql = $sql." AND download_name = '".$downloadName."'";
        }

        $results = $wpdb->get_var( $sql );


        $return = intVal( $results );

        $this->ct_la_Cache->setCache( $keyParts, $return, 900 );
        return $return;
    }



    function getDetail( $userId, $userRole, $listingIds, $downloadName, $visitorId, $paged, $perPage )
    {

        $keyParts = array(
            "ct_la_ListingDownloads",
            "getDetail",
            $userId, 
            $userRole,
            $listingIds, 
            $downloadName,
            $visitorId,
            $paged,
            $perPage
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            print $cache;
            return;
        }

        $dateArray = $this->o_ct_la_Utils->getStartEndDate( );
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




        $data = $this->getDataDetail( $userId, $userRole, $listingIds, $startDateString, $endDateString, $downloadName, $visitorId, $paged, $perPage );

        $dataDetailCount = $this->getDataDetailCount( $userId, $userRole, $listingIds, $startDateString, $endDateString, $downloadName, $visitorId );

        wp_localize_script( 'ct_get_detail_downloads_ajax_script', 'detail_downloads_ajax_object',
            array(
                'ajax_url'      => admin_url('admin-ajax.php'),
                'paged'         => 1,
                'listingId'     => $listingIds[0],
                'downloadName'  => $downloadName,
                'userId'        => $userId,
                'userRole'      => $userRole,
                'visitorId'     => $visitorId,
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
                        <th><?php _e('Document', 'ct-listing-analytics'); ?></th>
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
            <tbody id="detail-downloads-table">

                <?php
                if ( is_array( $data) && !empty( $data ) ) {
                    foreach ( $data as $dataLine ) {
                        ?>
                        <tr>
                            <?php
                            if ( $visitorId > 0 ) {
                                print "<td>".$dataLine["downloadName"]." [".$dataLine["listingTitle"]."]</td>";
                            }
                            ?>

                            <td>
                                <?php

                                if ( is_numeric( $visitorId ) ) {
                                    print "<a href=\"./?listing-id=".$listingIds[0]."&download-name=".$downloadName."&startDate=".$startDateString."&endDate=".$endDateString."&visitorId=".$dataLine["userId"]."\">" . ucfirst($dataLine["userRole"]) . " (" . $dataLine["userId"] . ")" . "</a>"; 
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
                //print "<li><a href=\"\">Previous</a></li>";

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

                print "<li id=\"next-page-link\"><a href=\"\" data-paged=\"2\" id=\"detail-downloads-next\">Next</a></li>";

                print "<div class=\"clear\"></div>";
                print "</ul>";
            print "</div>";
        }


        $o = ob_get_contents();
        ob_end_clean();

        $this->ct_la_Cache->setCache( $keyParts, $o, 900 );
        print $o;

    }



    function getSummary( $userId, $userRole, $listingIds, $dateArray, $downloadName, $visitorId, $perPage=10, $oCSV=null)
    {

        $keyParts = array(
            "ct_la_ListingDownloads",
            "getSummary",
            $userId, 
            $userRole,
            $listingIds, 
            $dateArray,
            $downloadName,
            $visitorId,
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

        $data = $this->getData( $userId, $userRole, $listingIds, $startDateString, $endDateString, $downloadName, $visitorId, 1, -1 );

        
        $downloads = 0;

        foreach ( $data as $item ) {
            $downloads = $downloads + intVal( $item["count"] );
        }

        $title = $data[0]["title"];

        $fileattachments = get_post_meta( $listingIds[0], '_ct_files', 1 );

        $downloadLinkTest = str_replace( " ", "-", $downloadName );
        $downloadLinkTest = strtolower( str_replace( "---", ".", $downloadLinkTest ) );
         
        $downloadLink = "";

        if ( is_array( $fileattachments ) && !empty( $fileattachments ) ) {
            foreach ( $fileattachments as $key => $value ) {
                $value = strtolower( $value );
        
                if ( strstr( $value, $downloadLinkTest ) ) {
                    $downloadLink = $value;
                }
            }
        }

        ob_start();

        ?>
        
        <div class="col span_12 first border-bottom marB30 padB20">
            <div class="col span_9 first">
            
                <h3 class="marB5"><?php print $downloads; ?> <?php if($downloads == 1) { _e('Download', 'ct-listing-analytics'); } else { _e('Downloads', 'ct-listing-analytics'); } ?></h3>

                <?php
                if ( $visitorId > 0 ) {
                    print "<h4 class=\"muted\">".$this->o_ct_la_Utils->getUsersName( $visitorId )."</h4>";
                } else {
                    ?>
                    
                    <h4 class="muted"><a href="<?php print $downloadLink; ?>" target="_blank"><?php print $downloadName; ?></a></h4>

                    <p class="left muted marB10"><strong><?php _e('Listing:', 'ct-listing-analytics'); ?></strong> <a href="/?p=<?php print $listingIds[0]; ?>"><?php print $title; ?></a></p>

                    <?php
                }
                ?>
                


            </div>
            <div class="col span_3">
            <p><textarea id="analytics-detail-date" class="right"><?php print $startDate->format("n/j/y"); ?> - <?php print $endDate->format("n/j/y"); ?></textarea></p>
        
                <?php

                if( $oCSV != null ) {
                    
                    $link = $oCSV->makeCSV("download", $startDate->format("Y-m-d 00:00:00"), $endDate->format("Y-m-d 23:59:59"),  $listingIds, $userId, $userRole, $visitorId, $downloadName );
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



    function getDownloads( $userId, $userRole, $listingIds, $dateArray )
    {

        $keyParts = array(
            "ct_la_ListingDownloads",
            "getDownloads",
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


        <!-- Top Downloads -->
        <div class="col span_6">
            <div class="user-stats-inner">
                <h4 class="border-bottom marT0 marB20"><?php _e('Top Downloads', 'ct-listing-analytics'); ?></h4>

                 <ul class="tabs marB30">

                    <?php
                    $startDateString = "";
                    $endDateString = "";
                    if ( $today !== false && $yesterday !== false ) {

                        $startDateString = $today->format("Y-m-d 00:00:00");
                        $endDateString = $today->format("Y-m-d 23:59:59");
                    ?>
                        <li><a href="#tab-today-attachments"><?php _e('Today', 'ct-listing-analytics'); ?></a></li>
                        <li><a href="#tab-yesterday-attachments"><?php _e('Yesterday', 'ct-listing-analytics'); ?></a></li>                    
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
                    <div id="tab-today-attachments">
                        <table class="marB0">
                            <thead>
                                <tr>
                                    <th><?php _e('Download', 'ct-listing-analytics'); ?></th>
                                    <th><i class="fa fa-download"></i></th>
                                </tr>
                            </thead>


                            <tbody id="overview-download-today-table">

                                <?php
                                $data = $this->getData( $userId, $userRole, $listingIds, $startDateString, $endDateString, "", 0, 1, $perPage );
   
                                $totalCount = $this->getDataCount( $userId, $userRole, $listingIds, $startDateString, $endDateString );
                                $totalRowCount = $this->getDataRowCount( $userId, $userRole, $listingIds, $startDateString, $endDateString );
                                
                
                                wp_localize_script( 'ct_get_download_today_ajax_script', 'download_today_ajax_object',
                                    array(
                                        'ajax_url'      => admin_url('admin-ajax.php'),
                                        'paged'         => 1,
                                        'userId'        => $userId,
                                        'userRole'      => $userRole,
                                        'visitorId'     => 0,
                                        'startDate'     => $startDateString,
                                        'endDate'       => $endDateString,
                                        'linkStartDate' => $startDate->format("Y-m-d 00:00:00"),
                                        'linkEndDate'   => $endDate->format("Y-m-d 00:00:00"),
                                        'totalCount'    => $totalCount,
                                        'totalRowCount' => $totalRowCount
                                    )
                                );

                                $total = 0;
                                foreach ( $data as $item ) {
                                    $total = $total + $item["count"];
                                ?>
                                    <tr>
                                        <td><a href="?listing-id=<?php print $item["listingId"]; ?>&download-name=<?php print $item["downloadName"]; ?>&startDate=<?php print $startDate->format("Y-m-d 00:00:00"); ?>&endDate=<?php print $endDate->format("Y-m-d 00:00:00"); ?>"><?php print $item["downloadName"]; ?> [<?php print $item["title"]; ?>]</a></td>
                                        <td><a href="?listing-id=<?php print $item["listingId"]; ?>&download-name=<?php print $item["downloadName"]; ?>&startDate=<?php print $startDate->format("Y-m-d 00:00:00"); ?>&endDate=<?php print $endDate->format("Y-m-d 00:00:00"); ?>"><?php print $item["count"]; ?></a></td>
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
                                    <th><?php _e('Total Downloads', 'ct-listing-analytics'); ?></th>
                                    <th><?php _e($totalCount, 'ct-listing-analytics'); ?></th>
                                </tr>
                            </tfoot>


                        </table>

                        <?php
                        if ( $totalRowCount > $perPage ) {
                        ?>   
                        

                            <div class="col span_12 first marT20">
                                <div class="col span_6 first">
                                    <a class="btn disabled" disabled="disabled" href="" id="overview-download-today-previous"><?php _e('Previous', 'ct-listing-analytics'); ?></a>
                                </div>
                                <div class="col span_6 rightalign">
                                    <a class="btn" href="" id="overview-download-today-next"><?php _e('Next', 'ct-listing-analytics'); ?></a>
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
                        <div id="tab-yesterday-attachments">
                            <table class="marB0">
                                <thead>
                                    <tr>
                                        <th><?php _e('Download', 'ct-listing-analytics'); ?></th>
                                        <th><i class="fa fa-download"></i></th>
                                    </tr>
                                </thead>

                                <tbody id="overview-download-yesterday-table">

                                <?php
                           

                                $totalCount = $this->getDataCount( $userId, $userRole, $listingIds, $startDateString, $endDateString );
                                $totalRowCount = $this->getDataRowCount( $userId, $userRole, $listingIds, $startDateString, $endDateString );
                                
                
                                wp_localize_script( 'ct_get_download_yesterday_ajax_script', 'download_yesterday_ajax_object',
                                    array(
                                        'ajax_url' => admin_url('admin-ajax.php'),
                                        'userId' => $userId,
                                        'userRole' => $userRole,
                                        'paged' => 1,
                                        'visitorId' => 0,
                                        'startDate' => $startDateString,
                                        'endDate' => $endDateString,
                                        'linkStartDate' => $startDate->format("Y-m-d 00:00:00"),
                                        'linkEndDate' => $endDate->format("Y-m-d 00:00:00"),
                                        'totalCount' => $totalCount,
                                        'totalRowCount' => $totalRowCount
                                    )
                                );

    
                                $data = $this->getData( $userId, $userRole, $listingIds, $startDateString, $endDateString, "", 0, 1, $perPage );
    
                                $total = 0;
                                foreach ( $data as $item ) {
                                    $total = $total + $item["count"];
                                ?>
                                    <tr>
                                        <td><a href="?listing-id=<?php print $item["listingId"]; ?>&download-name=<?php print $item["downloadName"]; ?>&startDate=<?php print $startDate->format("Y-m-d 00:00:00"); ?>&endDate=<?php print $endDate->format("Y-m-d 00:00:00"); ?>"><?php print $item["downloadName"]; ?> [<?php print $item["title"]; ?>]</td>
                                        <td><a href="?listing-id=<?php print $item["listingId"]; ?>&download-name=<?php print $item["downloadName"]; ?>&startDate=<?php print $startDate->format("Y-m-d 00:00:00"); ?>&endDate=<?php print $endDate->format("Y-m-d 00:00:00"); ?>"><?php print $item["count"]; ?></a></td>
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
                                    <th><?php _e('Total Downloads', 'ct-listing-analytics'); ?></th>
                                    <th><?php _e($totalCount, 'ct-listing-analytics'); ?></th>
                                </tr>
                                </tfoot>

                            </table>


                        <?php
                        if ( $totalRowCount > $perPage ) {
                        ?>   
                        
                            <div class="col span_12 first marT20">
                                <div class="col span_6 first">
                                    <a class="btn disabled" disabled="disabled" href="" id="overview-download-yesterday-previous"><?php _e('Previous', 'ct-listing-analytics'); ?></a>
                                </div>
                                <div class="col span_6 rightalign">
                                    <a class="btn" href="" id="overview-download-yesterday-next"><?php _e('Next', 'ct-listing-analytics'); ?></a>
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
        <!-- //Top Downloads -->
        <?php

        $o = ob_get_contents();
        ob_end_clean();
        
        $this->ct_la_Cache->setCache( $keyParts, $o, 900 );
        print $o;

    }
}