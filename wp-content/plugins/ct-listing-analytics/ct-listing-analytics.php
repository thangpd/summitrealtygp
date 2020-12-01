<?php

/**
 *
 * Plugin Name:       Contempo Listing Analytics
 * Description:       This plugin allows for tracking of listing views and number of times documents are downloaded per listing.
 * Version:           1.1.9
 * Author:            Contempo
 * Author URI:        http://contempographicdesign.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

require_once dirname( __FILE__ ) . "/classes/class.Database.php";
require_once dirname( __FILE__ ) . "/classes/class.Views.php";
require_once dirname( __FILE__ ) . "/classes/class.Downloads.php";
require_once dirname( __FILE__ ) . "/classes/class.Chart.php";
require_once dirname( __FILE__ ) . "/classes/class.CSV.php";
require_once dirname( __FILE__ ) . "/classes/class.Listings.php";
require_once dirname( __FILE__ ) . "/classes/class.ListingDownloads.php";
require_once dirname( __FILE__ ) . "/classes/class.Utils.php";
require_once dirname( __FILE__ ) . "/classes/class.Cache.php";

class ctListingAnalytics {

	var $o_ct_la_Database = null;
	var $o_ct_la_Views = null;
	var $o_ct_la_Downloads = null;
	var $o_ct_la_Chart = null;
	var $o_ct_la_CSV = null;
	var $o_ct_la_Listings = null;
	var $o_ct_la_ListingDownloads = null;
	var $o_ct_la_Utils = null;
	var $ct_la_Cache = null;

	/**
	 * Constructor
	 *
	 * @return null
	 */
	public function __construct() {

		// Plugin Details
		$this->plugin              = new stdClass;
		$this->plugin->name        = 'ct-listing-analytics'; // Plugin Folder
		$this->plugin->displayName = 'Contempo Listing Analytics'; // Plugin Name
		$this->plugin->version     = '1.1.1';
		$this->plugin->folder      = plugin_dir_path( __FILE__ );
		$this->plugin->url         = plugin_dir_url( __FILE__ );

		$this->o_ct_la_Database         = new ct_la_Database();
		$this->o_ct_la_Views            = new ct_la_Views();
		$this->o_ct_la_Downloads        = new ct_la_Downloads();
		$this->o_ct_la_Chart            = new ct_la_Chart();
		$this->o_ct_la_CSV              = new ct_la_CSV();
		$this->o_ct_la_Listings         = new ct_la_Listings();
		$this->o_ct_la_ListingDownloads = new ct_la_ListingDownloads();
		$this->o_ct_la_Utils            = new ct_la_Utils();
		$this->ct_la_Cache              = new ct_la_Cache();

		// Short code
		add_shortcode( 'ct_listing_analytics', array( &$this, 'ct_listing_analytics' ) );
		add_shortcode( 'ct_listing_analytics_single_page_views', array(
			&$this,
			'ct_listing_analytics_single_page_views'
		) );
		add_shortcode( 'ct_listing_analytics_dashboard_downloads', array(
			&$this,
			'ct_listing_analytics_dashboard_downloads'
		) );
		add_shortcode( 'ct_listing_analytics_dashboard_views', array(
			&$this,
			'ct_listing_analytics_dashboard_views'
		) );

		// Hooks and filters
		register_activation_hook( __FILE__, array( &$this, 'ct_la_plugin_activate' ) );

		add_action( 'plugins_loaded', array( &$this, 'ct_listing_analytics_load_textdomain' ) );
		add_action( 'wp', array( &$this, 'ct_la_trackView' ) );
		/**
		 * Add 'ct_la_trackView' method to modal's action to enable tracking in single listing loaded via ajax.
		 */
		add_action( 're7_load_single_listing_before_template_require', array( &$this, 'ct_la_trackView' ) );
		add_action( 'wp_ajax_nopriv_ct_la_trackDownload', array( &$this, 'ct_la_trackDownload' ) );
		add_action( 'wp_ajax_ct_la_trackDownload', array( &$this, 'ct_la_trackDownload' ) );

		add_action( 'wp_ajax_ct_getListingAjax', array( &$this, 'ct_getListingAjax' ) );
		add_action( 'wp_ajax_ct_getDownloadAjax', array( &$this, 'ct_getDownloadAjax' ) );

		add_action( 'wp_ajax_ct_getListingDetailAjax', array( &$this, 'ct_getListingDetailAjax' ) );
		add_action( 'wp_ajax_ct_getDownloadsDetailAjax', array( &$this, 'ct_getDownloadsDetailAjax' ) );

		add_action( 'wp_enqueue_scripts', array( &$this, 'ct_enqueue_chart_script' ) );
	}

	/*-----------------------------------------------------------------------------------*/
	/* Load Plugin Textdomain */
	/*-----------------------------------------------------------------------------------*/

	function ct_listing_analytics_load_textdomain() {
		load_plugin_textdomain( 'ct-listing-analytics', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	function ct_enqueue_chart_script() {
		global $post;
		if ( isset( $post->ID ) ) {
			$pageTemplate = get_page_template_slug( $post->ID );
		} else {
			$pageTemplate = '';
		}
		if ( $pageTemplate != "template-user-stats.php" && $pageTemplate != "template-user-stats-detail.php" ) {
			//return;
		}

		wp_enqueue_style( 'ct_listing_analytics', plugins_url( 'css/ct-listing-analytics.min.css', __FILE__ ), false );

		wp_enqueue_style( 'ct_la_chart_style', plugins_url( 'css/Chart.min.css', __FILE__ ), false );
		wp_enqueue_script( 'ct_la_chart', plugins_url( 'js/Chart.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', false );

		wp_enqueue_style( 'ct_la_daterangepicker_style', plugins_url( 'css/lightpick.css', __FILE__ ), false );
		wp_enqueue_script( 'ct_la_moment', plugins_url( 'js/moment.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'ct_la_daterangepicker', plugins_url( 'js/lightpick.js', __FILE__ ), array( 'jquery' ), '1.0.0', false );
	}

	/*-----------------------------------------------------------------------------------*/
	/* Create Shortcode */
	/*-----------------------------------------------------------------------------------*/

	function ct_listing_analytics_single_page_views() {
		global $post;

		if ( ! isset( $post ) ) {
			return false;
		}

		if ( $post->post_type != "listings" ) {
			return false;
		}

		$listingIds = array( $post->ID );

		$todayViewCount = $this->o_ct_la_Listings->getDataCount( $listingIds, date( "Y-m-d 00:00:00" ), date( "Y-m-d 23:59:59" ) );

		print "<p class=\"ct-listing-analytics-page-views\">";
		print _e( "Viewed " . $todayViewCount . " time" . ( ( $todayViewCount == 1 ) ? "" : "s" ) . " today" );
		print "</p>";

	}

	function ct_listing_analytics_dashboard_downloads() {
		global $ct_options;

		if ( ! is_user_logged_in() ) {
			return;
		}

		$user     = wp_get_current_user();
		$userId   = $user->data->ID;
		$userRole = "";

		foreach ( $user->caps as $cap => $bin ) {
			if ( $userRole != "administrator" ) {
				$userRole = $cap;
			}
		}

		// get the array of listings for this user
		$listingIds = array();
		$listingIds = $this->o_ct_la_Utils->getUsersListingIds( $userId, $userRole );


		$todayViewCount = $this->o_ct_la_ListingDownloads->getDataCount( $userId, $userRole, $listingIds, date( "Y-m-d 00:00:00" ), date( "Y-m-d 23:59:59" ) );

		$yesterday = new DateTime( current_time( "Y-m-d" ) );
		$yesterday->modify( '-1 day' );

		$yesterdayViewCount = $this->o_ct_la_ListingDownloads->getDataCount( $userId, $userRole, $listingIds, $yesterday->format( "Y-m-d 00:00:00" ), $yesterday->format( "Y-m-d 23:59:59" ) );

		$percentage = ( ( $todayViewCount - $yesterdayViewCount ) / ( ( $yesterdayViewCount == 0 ) ? 1 : $yesterdayViewCount ) ) * 100;

		global $ct_options;
		$ct_listing_analytics = isset( $ct_options['ct_listing_analytics'] ) ? esc_html( $ct_options['ct_listing_analytics'] ) : '';

		echo '<a class="card-link" href="' . get_page_link( $ct_listing_analytics ) . '">';
		echo '<div class="card col span_6 card-listing-attachment-downloads">';
		echo '<div class="card-inner">';
		echo '<div class="lrg-icon">';
		if ( function_exists( 'ct_downloads_svg' ) ) {
			ct_downloads_svg();
		} else {
			echo '<i class="fa fa-download"></i>';
		}
		echo '</div>';
		echo '<h1>';
		echo $todayViewCount;
		echo '</h1>';
		echo '<p class="muted">' . __( 'Document Downloads Today', 'ct-listing-analytics' ) . '</p>';
		echo '<p class="analytics-difference analytics-' . ( ( $percentage > 0 ) ? 'up' : 'down' ) . '"><i class="fa fa-arrow-' . ( ( $percentage > 0 ) ? 'up' : 'down' ) . '"></i>' . '<span id="analytics-percentage">' . round( $percentage, 2 ) . '%</span> ' . __( 'from yesterday', 'ct-listing-analytics' ) . '</p>';
		echo '</div>';
		echo '</div>';
		echo '</a>';

	}

	function ct_listing_analytics_dashboard_views() {
		global $ct_options;

		$keyParts = array(
			"ct-listing-analytics",
			"current_version"
		);
		$cache    = $this->ct_la_Cache->getCache( $keyParts );

		if ( $cache != $this->plugin->version ) {
			$this->ct_la_Cache->clear();
			$this->o_ct_la_Database->createTables();
			$this->ct_la_Cache->setCache( $keyParts, $this->plugin->version, 3600 * 24 * 365 );
		}

		if ( ! is_user_logged_in() ) {
			return;
		}

		$user     = wp_get_current_user();
		$userId   = $user->data->ID;
		$userRole = "";

		foreach ( $user->caps as $cap => $bin ) {
			if ( $userRole != "administrator" ) {
				$userRole = $cap;
			}
		}

		// get the array of listings for this user
		$listingIds = array();
		$listingIds = $this->o_ct_la_Utils->getUsersListingIds( $userId, $userRole );


		$todayViewCount = $this->o_ct_la_Listings->getDataCount( $listingIds, date( "Y-m-d 00:00:00" ), date( "Y-m-d 23:59:59" ) );

		$yesterday = new DateTime( current_time( "Y-m-d" ) );
		$yesterday->modify( '-1 day' );

		$yesterdayViewCount = $this->o_ct_la_Listings->getDataCount( $listingIds, $yesterday->format( "Y-m-d 00:00:00" ), $yesterday->format( "Y-m-d 23:59:59" ) );

		$percentage = ( ( $todayViewCount - $yesterdayViewCount ) / ( ( $yesterdayViewCount == 0 ) ? 1 : $yesterdayViewCount ) ) * 100;

		$ct_listing_analytics = isset( $ct_options['ct_listing_analytics'] ) ? esc_html( $ct_options['ct_listing_analytics'] ) : '';

		echo '<a class="card-link" href="' . get_page_link( $ct_listing_analytics ) . '">';
		echo '<div class="card col span_6 first card-listing-views">';
		echo '<div class="card-inner">';
		echo '<div class="lrg-icon">';
		if ( function_exists( 'ct_views_svg' ) ) {
			ct_views_svg();
		} else {
			echo '<i class="fa fa-eye"></i>';
		}
		echo '</div>';
		echo '<h1>';
		echo $todayViewCount;
		echo '</h1>';
		echo '<p class="muted">' . __( 'Listing Views Today', 'ct-listing-analytics' ) . '</p>';
		echo '<p class="analytics-difference analytics-' . ( ( $percentage > 0 ) ? 'up' : 'down' ) . '"><i class="fa fa-arrow-' . ( ( $percentage > 0 ) ? 'up' : 'down' ) . '"></i>' . '<span id="analytics-percentage">' . round( $percentage, 2 ) . '%</span> ' . __( 'from yesterday', 'ct-listing-analytics' ) . '</p>';
		echo '</div>';
		echo '</div>';
		echo '</a>';

	}


	function ct_listing_analytics() {

		if ( ! is_user_logged_in() ) {
			return;
		}

		$user     = wp_get_current_user();
		$userId   = $user->data->ID;
		$userRole = "";

		foreach ( $user->caps as $cap => $bin ) {
			if ( $userRole != "administrator" ) {
				$userRole = $cap;
			}
		}

		$listingId    = 0;
		$downloadName = "";

		$template = "overview";
		if ( isset( $_GET["listing-id"] ) ) {
			$template  = "detail";
			$listingId = intVal( $_GET["listing-id"] );

			if ( isset( $_GET["download-name"] ) ) {
				$template     = "download";
				$downloadName = filter_var( $_GET["download-name"], FILTER_SANITIZE_STRING );
			}
		}

		$visitorId = 0;
		if ( isset( $_GET["visitorId"] ) ) {
			$visitorId = intVal( $_GET["visitorId"] );
			$listingId = 0; // unset individual listing id if we're querying a user
		}

		if ( isset( $_GET["cache"] ) ) {
			$this->o_ct_la_CSV->deleteOldCSVFiles( 1 );
			$this->ct_la_Cache->clear();
		}


		// get the array of listings for this user
		$listingIds = array();
		$listingIds = $this->o_ct_la_Utils->getUsersListingIds( $userId, $userRole );

		// if the listing id is set, ie, we're
		// checking against a single listing then
		// check if this user is allowed to view this
		// listing and update the array if (s)he is.

		if ( $listingId > 0 && in_array( $listingId, $listingIds ) ) {
			// user is allowed..
			$listingIds = array( $listingId );
		}

		$dateArray = $this->o_ct_la_Utils->getStartEndDate();

		$this->ct_la_openContainer();

		if ( $template == "overview" ) {

			wp_enqueue_script( 'ct_get_listing_today_ajax_script', plugins_url( '/js/overview-listing-today.min.js', __FILE__ ), array( 'jquery' ) );
			wp_enqueue_script( 'ct_get_listing_yesterday_ajax_script', plugins_url( '/js/overview-listing-yesterday.min.js', __FILE__ ), array( 'jquery' ) );

			wp_enqueue_script( 'ct_get_download_today_ajax_script', plugins_url( '/js/overview-download-today.min.js', __FILE__ ), array( 'jquery' ) );
			wp_enqueue_script( 'ct_get_download_yesterday_ajax_script', plugins_url( '/js/overview-download-yesterday.min.js', __FILE__ ), array( 'jquery' ) );


			$this->o_ct_la_Chart->getChart( $userId, $userRole, $listingIds, '', $dateArray, 0, false, $template );
			$this->ct_la_closeContainer();
			$this->o_ct_la_Listings->getListings( $userId, $userRole, $listingIds, $dateArray );
			$this->o_ct_la_ListingDownloads->getDownloads( $userId, $userRole, $listingIds, $dateArray );

			print '<div class="clear"></div><div class="col span_12 first marT30"><a class="btn btn-secondary right" href="./?cache=clear">' . __( 'Clear Cache', 'ct-listing-analytics' ) . '</a></div>';

		} else if ( $template == "detail" ) {

			wp_enqueue_script( 'ct_get_detail_listing_ajax_script', plugins_url( '/js/detail-listing.min.js', __FILE__ ), array( 'jquery' ) );

			$this->o_ct_la_Listings->getSummary( $userId, $userRole, $listingIds, $dateArray, $visitorId, $this->o_ct_la_CSV );
			$this->o_ct_la_Chart->getChart( $userId, $userRole, $listingIds, '', $dateArray, $visitorId, true, $template );
			$this->ct_la_closeContainer();
			$this->o_ct_la_Listings->getDetail( $userId, $userRole, $listingIds, $dateArray, $visitorId, 1, 10 );

		} else if ( $template == "download" ) {

			wp_enqueue_script( 'ct_get_detail_downloads_ajax_script', plugins_url( '/js/detail-downloads.min.js', __FILE__ ), array( 'jquery' ) );

			$this->o_ct_la_ListingDownloads->getSummary( $userId, $userRole, $listingIds, $dateArray, $downloadName, $visitorId, 10, $this->o_ct_la_CSV );
			$this->o_ct_la_Chart->getChart( $userId, $userRole, $listingIds, $downloadName, $dateArray, $visitorId, true, $template );
			$this->ct_la_closeContainer();
			$this->o_ct_la_ListingDownloads->getDetail( $userId, $userRole, $listingIds, $downloadName, $visitorId, 1, 10 );

		}

	}


	function ct_getListingDetailAjax() {

		$startDate = '';
		if ( isset( $_GET['startDate'] ) ) {
			$startDate = filter_var( $_GET['startDate'], FILTER_SANITIZE_STRING );
		}

		$endDate = '';
		if ( isset( $_GET['endDate'] ) ) {
			$endDate = filter_var( $_GET['endDate'], FILTER_SANITIZE_STRING );
		}

		$paged = 1;
		if ( isset( $_GET['paged'] ) ) {
			$paged = intVal( $_GET['paged'] );
		}


		$userId = 0;
		if ( isset( $_GET['userId'] ) ) {
			$userId = intVal( $_GET['userId'] );
		}


		$userRole = "";
		if ( isset( $_GET['userRole'] ) ) {
			$userRole = intVal( $_GET['userRole'] );
		}

		$listingIds = array();
		if ( isset( $_GET['listingId'] ) ) {
			$listingIds = array( intVal( $_GET['listingId'] ) );
		}

		$visitorId = 0;
		if ( isset( $_GET['visitorId'] ) ) {
			$visitorId = intVal( $_GET['visitorId'] );
		}

		$perPage = 10;

		$sql  = "";
		$data = $this->o_ct_la_Listings->getDataDetail( $userId, $userRole, $listingIds, $startDate, $endDate, $visitorId, $paged, $perPage, $sql );

		$list         = array();
		$list["sql"]  = print_r( $data, true );
		$list["item"] = array();
		$total        = 0;

		foreach ( $data as $item ) {
			$total = $total + $item["count"];

			array_push( $list["item"], array(
					"userId"       => $userId,
					"userRole"     => $userRole,
					"user"         => $item["userId"],
					"role"         => $item["userRole"],
					"firstName"    => $item["firstName"],
					"lastName"     => $item["lastName"],
					"email"        => $item["email"],
					"mobile"       => $item["mobile"],
					"count"        => $item["count"],
					"listingId"    => $item["listingId"],
					"listingTitle" => $item["listingTitle"]
				)
			);
		}

		$list["count"] = $total;

		print json_encode( $list );

		wp_die();

	}


	function ct_getDownloadsDetailAjax() {

		$startDate = '';
		if ( isset( $_GET['startDate'] ) ) {
			$startDate = filter_var( $_GET['startDate'], FILTER_SANITIZE_STRING );
		}

		$endDate = '';
		if ( isset( $_GET['endDate'] ) ) {
			$endDate = filter_var( $_GET['endDate'], FILTER_SANITIZE_STRING );
		}

		$paged = 1;
		if ( isset( $_GET['paged'] ) ) {
			$paged = intVal( $_GET['paged'] );
		}


		$userId = 0;
		if ( isset( $_GET['userId'] ) ) {
			$userId = intVal( $_GET['userId'] );
		}


		$userRole = "";
		if ( isset( $_GET['userRole'] ) ) {
			$userRole = filter_var( $_GET['userRole'], FILTER_SANITIZE_STRING );
		}

		$listingId = array();
		if ( isset( $_GET['listingId'] ) ) {
			$listingId = intVal( $_GET['listingId'] );
		}


		$downloadName = array();
		if ( isset( $_GET['downloadName'] ) ) {
			$downloadName = filter_var( $_GET['downloadName'], FILTER_SANITIZE_STRING );
		}


		$visitorId = 0;
		if ( isset( $_GET['visitorId'] ) ) {
			$visitorId = intVal( $_GET['visitorId'] );
		}

		$perPage = 10;

		$sql  = "";
		$data = $this->o_ct_la_ListingDownloads->getDataDetail( $userId, $userRole, array( $listingId ), $startDate, $endDate, $downloadName, $visitorId, $paged, $perPage, $sql );

		$list = array();
		//$list["sql"] = print_r($data, true);
		$list["item"] = array();
		$total        = 0;

		foreach ( $data as $item ) {
			$total = $total + $item["count"];

			array_push( $list["item"], array(
					"userId"       => $userId,
					"userRole"     => $userRole,
					"user"         => $item["userId"],
					"role"         => $item["userRole"],
					"firstName"    => $item["firstName"],
					"lastName"     => $item["lastName"],
					"email"        => $item["email"],
					"mobile"       => ( $item["mobile"] != null ) ? $item["mobile"] : "",
					"count"        => $item["count"],
					"listingId"    => $item["listingId"],
					"listingTitle" => $item["listingTitle"],
					"downloadName" => $item["downloadName"],
				)
			);
		}

		$list["count"] = $total;

		print json_encode( $list );

		wp_die();

	}


	function ct_getListingAjax() {

		$startDate = '';
		if ( isset( $_GET['startDate'] ) ) {
			$startDate = filter_var( $_GET['startDate'], FILTER_SANITIZE_STRING );
		}

		$endDate = '';
		if ( isset( $_GET['endDate'] ) ) {
			$endDate = filter_var( $_GET['endDate'], FILTER_SANITIZE_STRING );
		}

		$paged = 1;
		if ( isset( $_GET['paged'] ) ) {
			$paged = intVal( $_GET['paged'] );
		}


		$userId = 0;
		if ( isset( $_GET['userId'] ) ) {
			$userId = intVal( $_GET['userId'] );
		}


		$userRole = "";
		if ( isset( $_GET['userRole'] ) ) {
			$userRole = intVal( $_GET['userRole'] );
		}

		$visitorId = 0;
		if ( isset( $_GET['visitorId'] ) ) {
			$visitorId = intVal( $_GET['visitorId'] );
		}

		$listingIds = $this->o_ct_la_Utils->getUsersListingIds( $userId, $userRole );

		$perPage = 10;

		$sql  = "";
		$data = $this->o_ct_la_Listings->getData( $userId, $userRole, $listingIds, $startDate, $endDate, $visitorId, $paged, $perPage );


		$list         = array();
		$list["sql"]  = $sql;
		$list["item"] = array();
		$total        = 0;


		foreach ( $data as $item ) {
			$total = $total + $item["count"];

			array_push( $list["item"], array(
					"userId"    => $userId,
					"userRole"  => $userRole,
					"listingId" => $item["listingId"],
					"startDate" => $startDate,
					"endDate"   => $endDate,
					"title"     => $item["listingTitle"],
					"count"     => $item["count"]
				)
			);
		}

		$list["count"] = $total;

		print json_encode( $list );

		wp_die();

	}


	function ct_getDownloadAjax() {

		$startDate = '';
		if ( isset( $_GET['startDate'] ) ) {
			$startDate = filter_var( $_GET['startDate'], FILTER_SANITIZE_STRING );
		}

		$endDate = '';
		if ( isset( $_GET['endDate'] ) ) {
			$endDate = filter_var( $_GET['endDate'], FILTER_SANITIZE_STRING );
		}

		$paged = 1;
		if ( isset( $_GET['paged'] ) ) {
			$paged = intVal( $_GET['paged'] );
		}

		$userId = 0;
		if ( isset( $_GET['userId'] ) ) {
			$userId = intVal( $_GET['userId'] );
		}


		$userRole = "";
		if ( isset( $_GET['userRole'] ) ) {
			$userRole = intVal( $_GET['userRole'] );
		}


		$visitorId = 0;
		if ( isset( $_GET['visitorId'] ) ) {
			$visitorId = intVal( $_GET['visitorId'] );
		}


		$listingIds = $this->o_ct_la_Utils->getUsersListingIds( $userId, $userRole );


		$perPage = 10;

		$data = $this->o_ct_la_ListingDownloads->getData( $userId, $userRole, $listingIds, $startDate, $endDate, "", $visitorId, $paged, $perPage );


		$list         = array();
		$list["item"] = array();
		$total        = 0;


		foreach ( $data as $item ) {
			$total = $total + $item["count"];

			array_push( $list["item"], array(
					"userId"       => $userId,
					"userRole"     => $userRole,
					"listingId"    => $item["listingId"],
					"startDate"    => $startDate,
					"endDate"      => $endDate,
					"downloadName" => $item["downloadName"],
					"title"        => $item["listingTitle"],
					"count"        => $item["count"]
				)
			);
		}

		$list["count"] = $total;

		print json_encode( $list );

		wp_die();

	}


	function ct_la_openContainer() {
		?>
        <div class="col span_12 first marB30">
        <div class="user-stats-inner">
		<?php
	}


	function ct_la_closeContainer() {
		?>
        </div>
        </div>
		<?php
	}


	/*-----------------------------------------------------------------------------------*/
	/* Create Database Tables */
	/*-----------------------------------------------------------------------------------*/
	function ct_la_plugin_activate() {
		$this->o_ct_la_Database->createTables();

		// Create custom page
		// Analytics Page
		$pagetitle = get_page_by_title( 'Listing Analytics' );

		if ( empty( $pagetitle ) ) {

			$listings_analytics_page = array(
				'post_title'    => wp_strip_all_tags( 'Listing Analytics' ),
				'post_name'     => 'listing-analytics',
				'post_content'  => '[ct_listing_analytics]',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
				'page_template' => 'template-listing-analytics.php'
			);

			wp_insert_post( $listings_analytics_page );
		}


	}


	/*-----------------------------------------------------------------------------------*/
	/* Track Views */
	/*-----------------------------------------------------------------------------------*/
	function ct_la_trackView() {
		global $post;

		if ( get_post_type() != "listings" ) {
			return;
		}

		$keyParts = array(
			"ct-listing-analytics",
			"current_version"
		);
		$cache    = $this->ct_la_Cache->getCache( $keyParts );

		if ( $cache != $this->plugin->version ) {
			$this->ct_la_Cache->clear();
			$this->o_ct_la_Database->createTables();
			$this->ct_la_Cache->setCache( $keyParts, $this->plugin->version, 3600 * 24 * 365 );
		}


		$this->ct_la_enqueue_scripts();

		$listingId = $post->ID;

		$userId = 0;
		if ( is_user_logged_in() ) {
			$currentUser = wp_get_current_user();
			$userId      = $currentUser->ID;
		}

		$ip        = $_SERVER["REMOTE_ADDR"];
		$userAgent = $_SERVER["HTTP_USER_AGENT"];

		$referer = "";

		if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
			$referer = $_SERVER["HTTP_REFERER"];
		}

		$date = current_time( "Y-m-d H:i:s" );

		$existingViewId = $this->o_ct_la_Views->ct_la_getViewId( $userId, $ip, $listingId, substr( $date, 0, 10 ) );

		if ( $existingViewId !== false ) {
			$this->o_ct_la_Views->ct_la_updateViewCount( $existingViewId );
		} else {
			$this->o_ct_la_Views->ct_la_addViewCount( $listingId, $userId, $ip, $userAgent, $referer, $date );
		}

	}


	/*-----------------------------------------------------------------------------------*/
	/* Track Downloads */
	/*-----------------------------------------------------------------------------------*/
	function ct_la_trackDownload() {
		global $post;

		$listingId    = intVal( $_POST["listingId"] );
		$userId       = intVal( $_POST["userId"] );
		$ip           = filter_var( $_POST["ip"], FILTER_SANITIZE_STRING );
		$userAgent    = filter_var( $_POST["userAgent"], FILTER_SANITIZE_STRING );
		$referer      = filter_var( $_POST["referer"], FILTER_SANITIZE_STRING );
		$date         = filter_var( $_POST["date"], FILTER_SANITIZE_STRING );
		$downloadName = filter_var( $_POST["downloadName"], FILTER_SANITIZE_STRING );

		$existingDownloadId = $this->o_ct_la_Downloads->ct_la_getDownloadId( $userId, $ip, $listingId, $downloadName, substr( $date, 0, 10 ) );

		if ( $existingDownloadId !== false ) {
			$this->o_ct_la_Downloads->ct_la_updateDownloadCount( $existingDownloadId );
		} else {
			$this->o_ct_la_Downloads->ct_la_addDownloadCount( $listingId, $downloadName, $userId, $ip, $userAgent, $referer, $date );
		}

		wp_die();

	}


	function ct_la_enqueue_scripts() {

		global $post;

		wp_enqueue_script( 'ct_la_downloads', plugins_url( 'js/downloads.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );

		$userId = 0;
		if ( is_user_logged_in() ) {
			$currentUser = wp_get_current_user();
			$userId      = $currentUser->ID;
		}

		$listingId = $post->ID;
		$ip        = $_SERVER["REMOTE_ADDR"];
		$userAgent = $_SERVER["HTTP_USER_AGENT"];
		$referer   = "";
		if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
			$referer = $_SERVER["HTTP_REFERER"];
		}

		$date = current_time( "Y-m-d H:i:s" );


		$listingArray = array(
			'userId'    => $userId,
			'listingId' => $listingId,
			'ip'        => $ip,
			'userAgent' => $userAgent,
			'referer'   => $referer,
			'date'      => $date,
			'ajaxurl'   => admin_url( 'admin-ajax.php' ),
		);

		wp_localize_script( 'ct_la_downloads', 'listingArray', $listingArray );

	}


}

$octListingAnalytics = new ctListingAnalytics();
