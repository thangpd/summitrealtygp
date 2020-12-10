<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ct_la_Chart
{

    var $o_ct_la_Utils = null;
    var $ct_la_Cache = null;
    var $ct_la_CSV = null;

    /**
     * Constructor
     *
     * @return null
     */
    public function __construct( )
    {
        $this->o_ct_la_Utils = new ct_la_Utils();
        $this->ct_la_Cache = new ct_la_Cache();
        $this->ct_la_CSV = new ct_la_CSV();
    }


    private function fillCountArray( $listingIds, $downloadName='', $startDate, $endDate, &$dateArray, $visitorId )
    {

        $keyParts = array(
            "ct_la_Chart",
            "fillCountArray",
            $listingIds,
            $downloadName,
            $startDate,
            $endDate,
            $visitorId
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            $dateArray = $cache;
            return;
        }

        global $wpdb;

        if ( !is_array( $listingIds ) || empty( $listingIds ) ) {
            return;
        }


        $listingIdFilter = " listing_id IN (".implode( ",", $listingIds ).") AND ";

        $visitorFilter = "";
        if ( $visitorId > 0 ) {
            $visitorFilter = " user_id = ".$visitorId." AND ";
            $listingIdFilter = "";

            if ( $downloadName != "" ) {
                $downloadName = "all";
            }
        }

        if ( $downloadName == "" ) {
            $table_name = $wpdb->prefix . 'ct_listing_analytics_views';
            $sql = "SELECT SUBSTR(time, 1, 10) AS day, COUNT(SUBSTR(time, 1, 10)) AS count FROM ".$table_name." WHERE ".$visitorFilter." ".$listingIdFilter." time BETWEEN '".$startDate." 00:00:00' AND '".$endDate." 23:59:59' GROUP BY day;";
        } else {

            $table_name = $wpdb->prefix . 'ct_listing_analytics_downloads';

            $downloadNameFilter = "";
            if ( $downloadName != "all" ) {
                $downloadNameFilter = " AND download_name = '".$downloadName."' ";
            }
             
            $sql = "SELECT SUBSTR(time, 1, 10) AS day, COUNT(SUBSTR(time, 1, 10)) AS count FROM ".$table_name." WHERE ".$visitorFilter." ".$listingIdFilter." time BETWEEN '".$startDate." 00:00:00' AND '".$endDate." 23:59:59' ".$downloadNameFilter."  GROUP BY day;";
    
        }
        
        $results = $wpdb->get_results( $sql, ARRAY_A );
        
        if ( is_array( $results ) && count( $results ) > 0 ) {
            foreach ( $results as $result ) {
                $dateArray[$result["day"]] = $result["count"];
            }
        }

        
        $this->ct_la_Cache->setCache( $keyParts, $dateArray, 900 );
        
        
    }


    function getChart( $userId, $userRole, $listingIds, $downloadName='', $dateInputArray, $visitorId, $skipHeader, $template )
    {

        $keyParts = array(
            "ct_la_Chart",
            "getChart",
            $userId, 
            $userRole,
            $listingIds, 
            $downloadName,
            $dateInputArray, 
            $visitorId,
            $skipHeader
        );

        $cache = $this->ct_la_Cache->getCache( $keyParts );

        if ( $cache !== false ) {
            print $cache;
            return;
        }

        $startDate = $dateInputArray["startDate"];
        $endDate = $dateInputArray["endDate"];

        $days  = $endDate->diff($startDate)->format('%a') + 1;

        $dateArray = array();
        $labelString = "";
        $valueString = "";
        $valueString2 = "";

        $loopDate = clone $startDate;

        for( $x = 0; $x < $days; $x++ ) {

            $dateArray[$loopDate->format('Y-m-d')] = 0;

            $labelString = $labelString."'".$loopDate->format("m/d")."',";
            $loopDate->modify('+1 day');
        }

        if ( strlen( $labelString ) > 0 ) {
            $labelString = substr( $labelString, 0, strlen( $labelString ) - 1 );
        }

        
        // get the listings data
        $this->fillCountArray( $listingIds, $downloadName, $startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $dateArray, $visitorId );

        foreach( $dateArray as $day ) {
            $valueString = $valueString."'".$day."',";
        }

        if ( strlen( $valueString ) > 0 ) {
            $valueString = substr( $valueString, 0, strlen( $valueString ) - 1 );
        }
        
        if ( $skipHeader == false ) {
            // on the overview page we want both graphs
            // get the downloads data

            $dateArray = array();
            $loopDate = clone $startDate;
            for( $x = 0; $x < $days; $x++ ) {

                $dateArray[$loopDate->format('Y-m-d')] = 0;
                $loopDate->modify('+1 day');
            }

            
            $this->fillCountArray( $listingIds, "all", $startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $dateArray, $visitorId );

            foreach( $dateArray as $day ) {
                $valueString2 = $valueString2."'".$day."',";
            }

            if ( strlen( $valueString ) > 0 ) {
                $valueString2 = substr( $valueString2, 0, strlen( $valueString2 ) - 1 );
            }
        }

        ob_start();

        
        if ( $skipHeader === false ) {
        ?>

            <div class="col span_12 first border-bottom marB30 padB20" id="listing-analytics">
                <div class="col span_8 first">
                    <h3 class="marB5"><?php _e('Traffic Overview', 'ct-listing-analytics'); ?></h3>
                </div>
                <div class="col span_4">
                
               
                    <div id="analytics-detail-date-select" class="right">
                        <textarea id="analytics-detail-date"><?php print $startDate->format("n/j/y"); ?> - <?php print $endDate->format("n/j/y"); ?></textarea>
                        <i class="fa fa-angle-down right"></i>
                    </div>

                    <?php

                    $listingsLink = $this->ct_la_CSV->makeCSV("overview", $startDate->format("Y-m-d 00:00:00"), $endDate->format("Y-m-d 23:59:59"),  $listingIds, $userId, $userRole, $visitorId );


                    $downloadsLink = $this->ct_la_CSV->makeCSV("overview-downloads", $startDate->format("Y-m-d 00:00:00"), $endDate->format("Y-m-d 23:59:59"),  $listingIds, $userId, $userRole, $visitorId );

                    ?>

                    <div id="analytics-detail-csv" class="right">
                        <?php _e('Download CSV', 'ct-listing-analytics'); ?>: <a href="<?php print $listingsLink; ?>" target="_new">Views</a> | <a href="<?php print $downloadsLink; ?>" target="_new">Downloads</a>
                    </div>

                    <script language="javascript">

                
                    var picker = new Lightpick({ 
                        field: document.getElementById('analytics-detail-date'), 
                        parentEl: document.getElementById('listing-analytics'),
                        singleDate: false,
                        format: "M/D/YY",
                        onClose: function(  ) {
                        
                            dateRange = document.getElementById("analytics-detail-date").value;
                
                            start = dateRange.substr( 0, dateRange.indexOf(" ") );
                            end = dateRange.substr( dateRange.indexOf(" - ") + 3 );

                            window.location.href = "./?startDate=" + start + "&endDate=" + end;

                        } 
                    });
                    </script>
                    
                </div>
            </div>

        <?php
        }
        ?>

        &nbsp;<br />

        <div class="content">
            <div class="wrapper">
                <canvas id="listing-chart"></canvas>
            </div>
        </div>

        <script>
            var data = {
                labels: [<?php print $labelString; ?>],
                datasets: [{
                    backgroundColor:  'rgba(0, 0, 0, 0.1)',
                    borderColor: '<?php print (($downloadName=="")?"rgba(3, 181, 195, 1)":"rgba(33, 67, 44, 1)"); ?>',
                    data:  [<?php print $valueString; ?>],
                    label: '<?php print (($downloadName=="")?"Visits":"Downloads"); ?>',
                    fill: 'origin'
                }
                <?php
                if ( $valueString2 != "" ) {
                ?>
                    ,{
                    backgroundColor:  'rgba(0, 0, 0, 0.1)',
                    borderColor: 'rgba(33, 67, 44, 1)',
                    data:  [<?php print $valueString2; ?>],
                    label: 'Downloads',
                    fill: 'origin'
                    }

                <?php
                }
                ?>
            ]
            };

            var options = {
                maintainAspectRatio: false,
                spanGaps: false,
                elements: {
                    line: {
                        tension: 0.1
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {if (value % 1 === 0) {return value;}}
                        }
                    }]
                }
            };

            var chart = new Chart('listing-chart', {
                type: 'line',
                data: data,
                options: options
            });

        </script>    

        <?php

        $o = ob_get_contents();
        ob_end_clean();

        $this->ct_la_Cache->setCache( $keyParts, $o, 900 );
        print $o;

    }
}