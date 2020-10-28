<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once dirname(__FILE__)."/class.Listings.php";

class ct_la_CSV
{

    var $ct_la_Listings = null;
    var $ct_la_ListingDownloads = null;
    
    /**
     * Constructor
     *
     * @return null
     */
    public function __construct( )
    {
        $this->ct_la_Listings = new ct_la_Listings();
        $this->ct_la_ListingDownloads = new ct_la_ListingDownloads();
    }

    function deleteOldCSVFiles( $timeInSeconds=86400)
    {
		if( file_exists( WP_CONTENT_DIR."/ct-la/csv" ) ) {
			$dh = opendir( WP_CONTENT_DIR."/ct-la/csv" );
	
	        	while (($file = readdir($dh)) !== false) {
				    if($file != '.' && $file != '..') {

                        if( (time() - filemtime( WP_CONTENT_DIR."/ct-la/csv/".$file )) > ( $timeInSeconds ) ) {
                                unlink( WP_CONTENT_DIR."/ct-la/csv/".$file );
                        }
                        
                    }
	        	}
            
                
			closedir($dh);
		}
    }



    function makeCSV($type, $startDate, $endDate, $listingIds=null, $userId, $userRole, $visitorId, $downloadName="")
    {

        $this->deleteOldCSVFiles();

                
        $fileName = date("YmdHis");
        $fileName = $type."_".date("Y-m-d", strtotime($startDate))."_".date("Y-m-d", strtotime($endDate));
        
        if ( !file_exists( WP_CONTENT_DIR."/ct-la/csv" ) ) {
            mkdir( WP_CONTENT_DIR."/ct-la/csv", 0755, true );
        }


        if ( file_exists( WP_CONTENT_DIR."/ct-la/csv/".$fileName.".csv" ) ) {
            if( (time() - filemtime( WP_CONTENT_DIR."/ct-la/csv/".$fileName.".csv" )) > (10 * 60) ) {
                unlink( WP_CONTENT_DIR."/ct-la/csv/".$fileName.".csv" );
            } else {
                return WP_CONTENT_URL."/ct-la/csv/".$fileName.".csv";
            }
        }


        $csvData = "";

        if ( $type == "overview" ) {
            /*
            $data = $this->ct_la_Listings->getData( $userId, $userRole, $listingIds, $startDate, $endDate, $visitorId, 0, 0 );
                        
            $csvData = "\"Listing Id\",\"Listing Name\",\"Views\"\r\n";

            if ( !empty($data) ) {
                foreach( $data as $line ) {
                    $csvData = $csvData."\"".$line["listingId"]."\",\"".$line["title"]."\",\"".$line["count"]."\"\r\n";
                }
            }
            */

            $data = $this->ct_la_Listings->getDataDetailAll( $userId, $userRole, $startDate, $endDate );
            
            $csvData = "\"Listing Id\",\"Listing Name\",\"Date\",\"UserId\",\"First Name\",\"Last Name\",\"Email\",\"Mobile\"\r\n";

            if ( !empty($data) ) {
                foreach( $data as $line ) {
                    $csvData = $csvData."\"".$line["listingId"]."\",\"".$line["listingTitle"]."\",\"".$line["viewTime"]."\",\"".$line["userId"]."\",\"".$line["firstName"]."\",\"".$line["lastName"]."\",\"".$line["email"]."\",\"".$line["mobile"]."\"\r\n";
                }
            }

        
        } else if ( $type == "overview-downloads" ) {

            /*
            $data = $this->ct_la_ListingDownloads->getData( $userId, $userRole, $listingIds, $startDate, $endDate, "", $visitorId, 0, 0 );      

            $csvData = "\"Listing Id\",\"Listing Name\",\"Document Name\",\"Downloads\"\r\n";

            if ( !empty($data) ) {
                foreach( $data as $line ) {
                    $csvData = $csvData."\"".$line["listingId"]."\",\"".$line["title"]."\",\"".$line["downloadName"]."\",\"".$line["count"]."\"\r\n";
                }
            }
            */


            $sql = "";

            $data = $this->ct_la_ListingDownloads->getDataDetailAll( $userId, $userRole, $startDate, $endDate );
            
            $csvData = "\"Listing Id\",\"Listing Name\",\"Document Name\",\"Date\",\"UserId\",\"First Name\",\"Last Name\",\"Email\",\"Mobile\"\r\n";

            if ( !empty($data) ) {
                foreach( $data as $line ) {
                    $csvData = $csvData."\"".$line["listingId"]."\",\"".$line["listingTitle"]."\",\"".$line["downloadName"]."\",\"".$line["viewTime"]."\",\"".$line["userId"]."\",\"".$line["firstName"]."\",\"".$line["lastName"]."\",\"".$line["email"]."\",\"".$line["mobile"]."\"\r\n";
                }
            }

        } else if ( $type == "detail" ) {

            $data = $this->ct_la_Listings->getDataDetail( $userId, $userRole, $listingIds, $startDate, $endDate, $visitorId, 0, 0 );

            $csvData = "\"Listing Id\",\"Listing Name\",\"UserId\",\"Name\",\"Email\",\"Mobile\"\r\n";

            if ( !empty($data) ) {
                foreach( $data as $line ) {
                    $csvData = $csvData."\"".$line["listingId"]."\",\"".$line["listingTitle"]."\",\"".$line["userId"]."\",\"".$line["firstName"]." ".$line["lastName"]."\",\"".$line["email"]."\",\"".$line["mobile"]."\"\r\n";
                }
            }


        } else if ( $type == "download" ) {

       
            $sql = "";

            $data = $this->ct_la_ListingDownloads->getDataDetail( $userId, $userRole, $listingIds, $startDate, $endDate, $downloadName, $visitorId, 0, 0 );
            
            $csvData = "\"Listing Id\",\"Listing Name\",\"Document Name\",\"UserId\",\"Name\",\"Email\",\"Mobile\"\r\n";

            if ( !empty($data) ) {
                foreach( $data as $line ) {
                    $csvData = $csvData."\"".$line["listingId"]."\",\"".$line["listingTitle"]."\",\"".$line["downloadName"]."\",\"".$line["userId"]."\",\"".$line["firstName"]." ".$line["lastName"]."\",\"".$line["email"]."\",\"".$line["mobile"]."\"\r\n";
                }
            }


        }


        file_put_contents( WP_CONTENT_DIR."/ct-la/csv/".$fileName.".csv", $csvData );

        return WP_CONTENT_URL."/ct-la/csv/".$fileName.".csv";
    }
}