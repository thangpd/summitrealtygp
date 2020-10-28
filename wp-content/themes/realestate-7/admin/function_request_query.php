<?php
/**
 * Date: 10/28/20
 * Time: 11:10 PM
 */

/*-----------------------------------------------------------------------------------*/
/* Get Search Args */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'getSearchArgs' ) ) {
	function getSearchArgs( $skipLocationData = false ) {

		//file_put_contents(dirname(__FILE__)."/log.theme-functions", "Hit on getSearchArgs\r\n", FILE_APPEND);

		global $ct_options;
		global $paged;
		global $wp_query;
		global $wpdb;

		$ct_exclude_sold_listing_search    = isset( $ct_options['ct_exclude_sold_listing_search'] ) ? $ct_options['ct_exclude_sold_listing_search'] : '';
		$ct_listing_search_exclude_mls_ids = isset( $ct_options['ct_listing_search_exclude_mls_ids'] ) ? $ct_options['ct_listing_search_exclude_mls_ids'] : '';

		/*-----------------------------------------------------------------------------------*/
		/* Query multiple taxonomies */
		/*-----------------------------------------------------------------------------------*/

		$taxonomies_to_search = array(
			'beds'      => 'Bedrooms',
			'baths'     => 'Bathrooms',
			'ct_status' => 'Status',
		);

		if ( $skipLocationData == false ) {
			$taxonomies_to_search['state']     = 'State';
			$taxonomies_to_search['zipcode']   = 'Zipcode';
			$taxonomies_to_search['city']      = 'City';
			$taxonomies_to_search['country']   = 'Country';
			$taxonomies_to_search['county']    = 'county';
			$taxonomies_to_search['community'] = 'Community';
		}

		$search_values = array();
		$tax_query     = array();
		$meta_query    = array();

		foreach ( $taxonomies_to_search as $t => $l ) {
			$var_name = 'ct_' . $t;

			if ( ! empty( $_GET[ $var_name ] ) && $_GET[ $var_name ] != '<img' ) {
				$search_values[ $t ] = $_GET[ $var_name ];
			}
		}

		$search_values['post_type'] = 'listings';
		$search_values['order']     = 'DESC';
		$search_values['orderby']   = 'date';
		$search_values['paged']     = ct_currentPage();
		$search_num                 = $ct_options['ct_listing_search_num'];
		$search_values['showposts'] = $search_num;

		$search_values['tax_query'] = array();

		/*-----------------------------------------------------------------------------------*/
		/* Property Types Search */
		/*-----------------------------------------------------------------------------------*/

		if ( isset( $_GET['ct_property_type'] ) && ! empty( $_GET['ct_property_type'] ) ) {
			if ( is_array( $_GET['ct_property_type'] ) ) {
				$property_types = $_GET['ct_property_type'];

				foreach ( $property_types as $type ) {
					$t          = get_term_by( 'slug', $type, 'property_type' );
					$type_ids[] = $t->term_id;
				}

				$search_values['tax_query'] = array( 'relation' => 'AND' );

				array_push( $search_values['tax_query'],
					array(
						'taxonomy' => 'property_type',
						'field'    => 'term_id',
						'terms'    => $type_ids,
						'operator' => 'IN'
					)
				);

			} else {

				$property_type = $_GET['ct_property_type'];

				$search_values['tax_query'] = array( 'relation' => 'AND' );

				array_push( $search_values['tax_query'],
					array(
						'taxonomy' => 'property_type',
						'field'    => 'slug',
						'terms'    => $property_type,
						'operator' => 'IN'
					)
				);
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/* Status Search */
		/*-----------------------------------------------------------------------------------*/

		if ( isset( $_GET['ct_ct_status_multi'] ) && ! empty( $_GET['ct_ct_status_multi'] ) ) {
			if ( is_array( $_GET['ct_ct_status_multi'] ) ) {
				$statuses = $_GET['ct_ct_status_multi'];

				foreach ( $statuses as $status ) {
					$s            = get_term_by( 'slug', $status, 'ct_status' );
					$status_ids[] = $s->term_id;
				}

				array_push( $search_values['tax_query'],
					array(
						'taxonomy' => 'ct_status',
						'field'    => 'term_id',
						'terms'    => $status_ids,
						'operator' => 'IN'
					)
				);

			}
		}

		/*-----------------------------------------------------------------------------------*/
		/* Additional Features Search */
		/*-----------------------------------------------------------------------------------*/

		if ( isset( $_GET['ct_additional_features'] ) && ! empty( $_GET['ct_additional_features'] ) ) {
			if ( is_array( $_GET['ct_additional_features'] ) ) {
				$additional_features = $_GET['ct_additional_features'];

				foreach ( $additional_features as $feature ) {
					$f             = get_term_by( 'slug', $feature, 'additional_features' );
					$feature_ids[] = $f->term_id;
				}

				array_push( $search_values['tax_query'],
					array(
						'taxonomy' => 'additional_features',
						'field'    => 'term_id',
						'terms'    => $feature_ids,
						'operator' => 'IN'
					)
				);

			}
		}

		/*-----------------------------------------------------------------------------------*/
		/* Beds+ */
		/*-----------------------------------------------------------------------------------*/

		if ( isset( $_GET['ct_beds_plus'] ) && ! empty( $_GET['ct_beds_plus'] ) ) {
			$ct_beds_start = $_GET['ct_beds_plus'];
			$ct_beds_end   = 20;
			array_push( $search_values['tax_query'],
				array(
					'taxonomy' => 'beds',
					'field'    => 'name',
					'terms'    => range( $ct_beds_start, $ct_beds_end ),
					'operator' => 'IN'
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Baths+ */
		/*-----------------------------------------------------------------------------------*/

		if ( isset( $_GET['ct_baths_plus'] ) && ! empty( $_GET['ct_baths_plus'] ) ) {
			$ct_baths_start = $_GET['ct_baths_plus'];
			$ct_beds_end    = 20;
			array_push( $search_values['tax_query'],
				array(
					'taxonomy' => 'baths',
					'field'    => 'name',
					'terms'    => range( $ct_baths_start, $ct_beds_end ),
					'operator' => 'IN'
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Exclude Sold Status */
		/*-----------------------------------------------------------------------------------*/

		if ( $ct_exclude_sold_listing_search == 'yes' ) {
			array_push( $search_values['tax_query'],
				array(
					'taxonomy' => 'ct_status',
					'field'    => 'slug',
					'terms'    => 'sold',
					'operator' => 'NOT IN'
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Exclude Ghost Status */
		/*-----------------------------------------------------------------------------------*/

		array_push( $search_values['tax_query'],
			array(
				'taxonomy' => 'ct_status',
				'field'    => 'slug',
				'terms'    => 'ghost',
				'operator' => 'NOT IN'
			)
		);

		/*-----------------------------------------------------------------------------------*/
		/* Keyword Search on Title and Content */
		/*-----------------------------------------------------------------------------------*/

		add_action( 'pre_get_posts', function ( $q ) {
			if ( $title = $q->get( '_meta_or_title' ) ) {
				add_filter( 'get_meta_sql', function ( $sql ) use ( $title ) {
					global $wpdb;

					// Only run once:
					static $nr = 0;
					if ( 0 != $nr ++ ) {
						return $sql;
					}

					// Modify WHERE part:
					$sql['where'] = sprintf(
						" AND ( %s OR %s ) ",
						$wpdb->prepare( "{$wpdb->posts}.post_title like '%%%s%%'", $title ),
						$wpdb->prepare( "{$wpdb->posts}.post_content like '%%%s%%'", $title ),
						mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
					);

					return $sql;
				} );
			}
		} );

		/* $post= new WP_Query( array(
	  'ep_integrate'   => true,
	  'post_type'      => 'listings',
	  'posts_per_page' => -1,
	  'q'=>'t',
  ) );*/

		if ( $skipLocationData == false && ! empty( $_GET['ct_keyword'] ) || $skipLocationData == false && ! empty( $_GET['ct_mobile_keyword'] ) ) {

			$ct_filters = array(
				'"'         => '"',
				'='         => '=',
				'>'         => '>',
				'<'         => '<',
				'\\'        => '\\',
				'/'         => '/',
				'('         => '(',
				')'         => ')',
				'autofocus' => 'autofocus',
				'onfocus'   => 'onfocus',
				'alert'     => 'alert',
				'XSS'       => 'XSS'
			);

			if ( ! empty( $_GET['ct_mobile_keyword'] ) ) {
				$ct_keyword = $_GET['ct_mobile_keyword'];
				$ct_keyword = strip_tags( $ct_keyword );
				$ct_keyword = str_replace( $ct_filters, '', $ct_keyword );
			} else {
				$ct_keyword = $_GET['ct_keyword'];
				$ct_keyword = strip_tags( $ct_keyword );
				$ct_keyword = str_replace( $ct_filters, '', $ct_keyword );
			}

			$search_values['_meta_or_title'] = $ct_keyword;

			if ( ! empty( $_GET['ct_mobile_keyword'] ) ) {
				$post_keyword = $_REQUEST['ct_mobile_keyword'];
				$post_keyword = strip_tags( $post_keyword );
				$post_keyword = str_replace( $ct_filters, '', $post_keyword );
			} else {
				$post_keyword = $_REQUEST['ct_keyword'];
				$post_keyword = strip_tags( $post_keyword );
				$post_keyword = str_replace( $ct_filters, '', $post_keyword );
			}

			global $wpdb;

			/*$posts_data = $wpdb->get_results( "SELECT count(ID) FROM " . $wpdb->prefix . "posts WHERE
			post_type= 'listings' AND
			post_status= 'publish' AND
			(post_content like '%" . $post_keyword . "%' OR post_title like '%" . $post_keyword . "%')
			ORDER BY post_title" );*/
//			echo '<pre>';
//			print_r( $posts_data );
//			echo '</pre>';
			/*$id_array_post = $posts_data;
			foreach($posts_data as $post_terms_id) {
				array_push($id_array_post,$post_terms_id->ID);
			};*/

			$id_array_post = ( new WP_Query( array(
				'ep_integrate'   => true,
				'post_type'      => 'listings',
				'post_status'    => 'publish',
				's'              => $post_keyword,
				'orderby'        => 'title',
				'posts_per_page' => - 1,
				'fields'         => 'ids'
			) ) );
			$id_array_post = $id_array_post->posts;
//			echo '<pre>';
//			print_r($id_array_post);
//			echo '</pre>';die;


			/*$post_meta_data = $wpdb->get_results( "
            SELECT ID FROM " . $wpdb->prefix . "posts
			WHERE " . $wpdb->prefix . "posts.post_status ='publish'
			AND " . $wpdb->prefix . "posts.post_type= 'listings' AND " . $wpdb->prefix . "posts.ID in (
			SELECT " . $wpdb->prefix . "postmeta.post_id  FROM " . $wpdb->prefix . "postmeta
			WHERE " . $wpdb->prefix . "postmeta.meta_key = '_ct_listing_alt_title' 
			AND " . $wpdb->prefix . "postmeta.meta_value LIKE '%" . $post_keyword . "%'
			OR " . $wpdb->prefix . "postmeta.meta_key = '_ct_rental_title' 
			AND " . $wpdb->prefix . "postmeta.meta_value LIKE '%" . $post_keyword . "%' )" );*/
			/*echo '<pre>';
			print_r($post_meta_data);
			echo '</pre>';*/
			/* SELECT ID FROM wp_posts
			WHERE wp_posts.post_status ='publish'
			AND wp_posts.post_type= 'listings' AND wp_posts.ID = (
			SELECT wp_postmeta.post_id  FROM wp_postmeta
			WHERE wp_postmeta.meta_key = '_ct_listing_alt_title' AND wp_postmeta.meta_value LIKE '%t%'
			OR wp_postmeta.meta_key = '_ct_rental_title' AND wp_postmeta.meta_value LIKE '%t%' limit 1 )*/
			/*$id_array_post_meta = array();
			foreach($post_meta_data as $post_terms_id) {
				array_push($id_array_post_meta,$post_terms_id->ID);
			};*/
			/*echo '<pre>';
			print_r($id_array_post_meta);
			echo '</pre>';*/
//			echo '<pre>';
//			print_r( $post_meta_data );
//			echo '</pre>';
			$id_array_post_meta = ( new WP_Query( [
				'ep_integrate' => true,
				'post_type'    => 'listings',
				'fields'       => 'ids',
				'meta_query'   => array(
					'relation' => 'OR',
					[
						'key'     => '_ct_listing_alt_title',
						'value'   => $post_keyword,
						'compare' => 'LIKE'
					],
					[
						'key'     => '_ct_rental_title',
						'value'   => $post_keyword,
						'compare' => 'LIKE',
					],
				),
			] ) );
			$id_array_post_meta = $id_array_post_meta->posts;
			$id_array           = ( new WP_Query( array(
					'ep_integrate'   => true,
					'posts_per_page' => - 1,
					'post_type'      => 'listings',
					'post_status'    => 'publish',
					'fields'         => 'ids',
					'tax_query'      => array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'community',
							'field'    => 'name',
							'compare'  => 'LIKE',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'city',
							'field'    => 'name',
							'compare'  => 'LIKE',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'zipcode',
							'field'    => 'name',
							'compare'  => 'LIKE',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'country',
							'field'    => 'name',
							'compare'  => 'LIKE',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'state',
							'field'    => 'name',
							'compare'  => 'LIKE',
							'terms'    => array( $post_keyword )
						),
					)
				)
			) )->posts;


			$ids = array_unique( array_merge( $id_array_post, $id_array_post_meta, $id_array ) );
			if ( empty( $ids ) ) {
				$ids = array( 1 ); // set it to 1 to get no posts in results rather than all posts
			}
			$search_values['post_type'] = array( 'listings' );
			$search_values['post__in']  = $ids;

		}

		/*-----------------------------------------------------------------------------------*/
		/* Order by Price */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_orderby_price'] ) ) {

			$order = utf8_encode( $_GET['ct_orderby_price'] );

			$search_values['orderby']   = 'meta_value';
			$search_values['meta_key']  = '_ct_price';
			$search_values['meta_type'] = 'numeric';
			$search_values['order']     = $order;

		}

		/*-----------------------------------------------------------------------------------*/
		/* Order by (Title, Price or upload date) */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_orderby'] ) ) {
			$orderBy = $_GET['ct_orderby'];

			if ( $orderBy == 'priceASC' ) {
				$search_values['orderby']   = 'meta_value';
				$search_values['meta_key']  = '_ct_price';
				$search_values['meta_type'] = 'numeric';
				$search_values['order']     = 'ASC';
			} elseif ( $orderBy == 'priceDESC' ) {
				$search_values['orderby']   = 'meta_value';
				$search_values['meta_key']  = '_ct_price';
				$search_values['meta_type'] = 'numeric';
				$search_values['order']     = 'DESC';
			} elseif ( $orderBy == 'dateDESC' ) {
				$search_values['orderby'] = 'date';
				$search_values['order']   = 'DESC';
			} elseif ( $orderBy == 'dateASC' ) {
				$search_values['orderby'] = 'date';
				$search_values['order']   = 'ASC';
			} else { //	titleASC
				$search_values['orderby'] = 'title';
				$search_values['order']   = 'ASC';
			}
		}

		$mode = 'search';

		$search_values['meta_query'] = array();

		/*-----------------------------------------------------------------------------------*/
		/* Check Price From/To */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_price_from'] ) && ! empty( $_GET['ct_price_to'] ) ) {

			$ct_currency = "$";
			if ( $ct_options['ct_currency'] ) {
				$ct_currency = esc_html( $ct_options['ct_currency'] );
			}
			$ct_price_from = str_replace( ',', '', $_GET['ct_price_from'] );
			$ct_price_to   = str_replace( ',', '', $_GET['ct_price_to'] );
			$ct_price_from = str_replace( $ct_currency, '', $ct_price_from );
			$ct_price_to   = str_replace( $ct_currency, '', $ct_price_to );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_price',
					'value'   => array( $ct_price_from, $ct_price_to ),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN'
				)
			);
		} else if ( ! empty( $_GET['ct_price_from'] ) ) {
			$ct_price_from = str_replace( ',', '', $_GET['ct_price_from'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_price',
					'value'   => $ct_price_from,
					'type'    => 'NUMERIC',
					'compare' => '>='
				)
			);
		} else if ( ! empty( $_GET['ct_price_to'] ) ) {
			$ct_price_to = str_replace( ',', '', $_GET['ct_price_to'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_price',
					'value'   => $_GET['ct_price_to'],
					'type'    => 'NUMERIC',
					'compare' => '<='
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Check Dwelling Size From/To */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_sqft_from'] ) && ! empty( $_GET['ct_sqft_to'] ) ) {
			$ct_sqft_from = str_replace( ',', '', $_GET['ct_sqft_from'] );
			$ct_sqft_to   = str_replace( ',', '', $_GET['ct_sqft_to'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_sqft',
					'value'   => array( $ct_sqft_from, $ct_sqft_to ),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN'
				)
			);
		} else if ( ! empty( $_GET['ct_sqft_from'] ) ) {
			$ct_sqft_from = str_replace( ',', '', $_GET['ct_sqft_from'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_sqft',
					'value'   => $ct_sqft_from,
					'type'    => 'NUMERIC',
					'compare' => '>='
				)
			);
		} else if ( ! empty( $_GET['ct_sqft_to'] ) ) {
			$ct_sqft_to = str_replace( ',', '', $_GET['ct_sqft_to'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_sqft',
					'value'   => $ct_sqft_to,
					'type'    => 'NUMERIC',
					'compare' => '<='
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Check Lot Size From/To */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_lotsize_from'] ) && ! empty( $_GET['ct_lotsize_to'] ) ) {
			$ct_lotsize_from = str_replace( ',', '', $_GET['ct_lotsize_from'] );
			$ct_lotsize_to   = str_replace( ',', '', $_GET['ct_lotsize_to'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_lotsize',
					'value'   => array( $ct_lotsize_from, $ct_lotsize_to ),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN'
				)
			);
		} else if ( ! empty( $_GET['ct_lotsize_from'] ) ) {
			$ct_lotsize_from = str_replace( ',', '', $_GET['ct_lotsize_from'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_lotsize',
					'value'   => $ct_lotsize_from,
					'type'    => 'NUMERIC',
					'compare' => '>='
				)
			);
		} else if ( ! empty( $_GET['ct_lotsize_to'] ) ) {
			$ct_lotsize_to = str_replace( ',', '', $_GET['ct_lotsize_to'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_lotsize',
					'value'   => $ct_lotsize_to,
					'type'    => 'NUMERIC',
					'compare' => '<='
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Check Year From/To */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_year_from'] ) && ! empty( $_GET['ct_year_to'] ) ) {
			$ct_year_from = str_replace( ',', '', $_GET['ct_year_from'] );
			$ct_year_to   = str_replace( ',', '', $_GET['ct_year_to'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_idx_overview_year_built',
					'value'   => array( $ct_year_from, $ct_year_to ),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN'
				)
			);
		} else if ( ! empty( $_GET['ct_year_from'] ) ) {
			$ct_year_from = str_replace( ',', '', $_GET['ct_year_from'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_idx_overview_year_built',
					'value'   => $ct_year_from,
					'type'    => 'NUMERIC',
					'compare' => '>='
				)
			);
		} else if ( ! empty( $_GET['ct_year_to'] ) ) {
			$ct_year_to = str_replace( ',', '', $_GET['ct_year_to'] );
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_idx_overview_year_built',
					'value'   => $ct_year_to,
					'type'    => 'NUMERIC',
					'compare' => '<='
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Check if pet friendly */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['pet_friendly'] ) ) {
			$pet_friendly = $_GET['pet_friendly'];
			array_push( $search_values['meta_query'],
				array(
					'key'     => 'pet_friendly',
					'value'   => $pet_friendly,
					'type'    => 'char',
					'compare' => '='
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Check to see if reference number matches */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_mls'] ) ) {
			$ct_mls = $_GET['ct_mls'];
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_mls',
					'value'   => $ct_mls,
					'type'    => 'char',
					'compare' => '='
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Check if agent name matches */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_idx_agent'] ) ) {
			$ct_idx_agent = $_GET['ct_idx_agent'];
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_agent_name',
					'value'   => $ct_idx_agent,
					'type'    => 'char',
					'compare' => '='
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Check if brokerage ID matches */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_brokerage'] ) ) {
			$ct_brokerage = $_GET['ct_brokerage'];
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_brokerage',
					'value'   => $ct_brokerage,
					'type'    => 'NUMERIC',
					'compare' => '='
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Check to see if number of guests matches */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $_GET['ct_rental_guests'] ) ) {
			$ct_rental_guests = $_GET['ct_rental_guests'];
			array_push( $search_values['meta_query'],
				array(
					'key'     => '_ct_rental_guests',
					'value'   => $ct_rental_guests,
					'type'    => 'NUMERIC',
					'compare' => '<='
				)
			);
		}

		// display IDX results if plugin is active and license valid,
		// else display only regular listings
		$displayIDX = "!=";

		if ( class_exists( "IDX_Query" ) ) {
			// get only idx rows when this plugin is active
			$oIDXQuery = new IDX_Query();
			if ( $oIDXQuery->validateEddKey() === true ) {
				$displayIDX = "=";
			}

		}

		if ( ! isset( $search_values["meta_query"] ) ) {
			$search_values['meta_query'] = array();
		}

		if ( $displayIDX == "=" ) {
			array_push( $search_values['meta_query'], array(
					// Commented out so when CT IDX Pro is active it searches on ALL Listings including Manually Entered
					/*"relation" => "AND",
					array(
						'key' => 'source',
						'value' => 'idx-api',
						'type' => 'char',
						'compare' => $displayIDX
					)*/
				)
			);
		} else {
			array_push( $search_values['meta_query'], array(
					"relation" => "AND",
					array(
						'key'     => 'source',
						'value'   => 'idx-api',
						'compare' => 'NOT EXISTS'
					)
				)
			);
		}

		/*-----------------------------------------------------------------------------------*/
		/* Exclude MLS ID's From Search */
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty( $ct_listing_search_exclude_mls_ids ) ) {
			$mls_ids = explode( ',', $ct_listing_search_exclude_mls_ids );

			foreach ( $mls_ids as $mls_id ) {
				array_push( $search_values['meta_query'], array(
						'relation' => 'AND',
						array(
							'key'     => '_ct_mls',
							'value'   => $mls_id,
							'compare' => 'NOT IN'
						)
					)
				);
			}

		}

		//file_put_contents(dirname(__FILE__)."/log.theme-functions", "done in getSearchArgs\r\n", FILE_APPEND);

		/*echo '<pre>';
		print_r($search_values);
		echo '</pre>';*/

		return $search_values;
	}
}


/*-----------------------------------------------------------------------------------*/
/* Ajax Listing Suggest Search with Keyword */
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_ajax_street_keyword_search', 'ct_street_keyword_search_callback' );
add_action( 'wp_ajax_nopriv_street_keyword_search', 'ct_street_keyword_search_callback' );

if ( ! function_exists( 'ct_street_keyword_search_callback' ) ) {
	function ct_street_keyword_search_callback() {
		global $wpdb;
		global $ct_options;

		$ct_exclude_sold_listing_search = isset( $ct_options['ct_exclude_sold_listing_search'] ) ? $ct_options['ct_exclude_sold_listing_search'] : '';

		$post_keyword = $_POST['keyword_value'];

		if ( ! empty( $post_keyword ) ) {

			/*$posts_data         = $wpdb->get_results( "
			SELECT count(*) FROM " . $wpdb->prefix . "posts 
			WHERE post_type= 'listings' AND post_status= 'publish' 
			AND (post_content like '%" . $post_keyword . "%' OR
			 post_title like '%" . $post_keyword . "%') 
			 ORDER BY post_title" );*/
//			echo '<pre>';
//			print_r($posts_data);
//			echo '</pre>';
			/*SELECT * FROM wp_posts
            WHERE post_type= 'listings' AND post_status= 'publish'
            AND (post_content like '%Tets%' OR
             post_title like '%Tets%')
             ORDER BY post_title
			*/
			/*echo '<pre>';
			print_r($posts_data);
			echo '</pre>';*/

			$posts_data = ( new WP_Query( array(
				'ep_integrate'   => true,
				'post_type'      => 'listings',
				'post_status'    => 'publish',
				's'              => $post_keyword,
				'orderby'        => 'title',
				'posts_per_page' => - 1,
			) ) )->posts;
//			echo '<pre>';
//			print_r($posts_data);
//			echo '</pre>';die;
			/*$post_meta_data = $wpdb->get_results( "SELECT count(*) FROM " . $wpdb->prefix . "posts
			WHERE " . $wpdb->prefix . "posts.post_status ='publish' AND
			 " . $wpdb->prefix . "posts.post_type= 'listings' AND " . $wpdb->prefix . "posts.ID in (
			 SELECT " . $wpdb->prefix . "postmeta.post_id  FROM " . $wpdb->prefix . "postmeta 
			  WHERE " . $wpdb->prefix . "postmeta.meta_key = '_ct_listing_alt_title' 
			   AND " . $wpdb->prefix . "postmeta.meta_value LIKE '%" . $post_keyword . "%' 
			   OR " . $wpdb->prefix . "postmeta.meta_key = '_ct_rental_title'  AND " . $wpdb->prefix . "postmeta.meta_value 
			   LIKE '%" . $post_keyword . "%' )" );*/
//			echo '<pre>';
//			print_r( $post_meta_data );
//			echo '</pre>';
			$post_meta_data = ( new WP_Query( [
				'ep_integrate' => true,
				'post_type'    => 'listings',
				'fields'       => 'ids',
				'meta_query'   => array(
					'relation' => 'OR',
					[
						'key'     => '_ct_listing_alt_title',
						'value'   => $post_keyword,
						'compare' => 'LIKE'
					],
					[
						'key'     => '_ct_rental_title',
						'value'   => $post_keyword,
						'compare' => 'LIKE',
					],
				),
			] ) );
			$post_meta_data = $post_meta_data->posts;
			/*echo '<pre>';
			print_r( $post_meta_data );
			echo '</pre>';
			die;*/
//            echo '<pre>';
//            print_r($post_metadata_subquery);
//            echo '</pre>';

			if ( $ct_exclude_sold_listing_search == 'yes' ) {
				$post_terms = (new WP_Query( array(
					'posts_per_page' => - 1,
					'post_type'      => 'listings',
					'post_status'    => 'publish',
					'tax_query'      => array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'city',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'zipcode',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'country',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'state',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'community',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'ct_status',
							'field'    => 'slug',
							'terms'    => 'sold',
							'operator' => 'NOT IN'
						)
					),

				) ));
			} else {
				$post_terms = (new WP_Query( array(
					'posts_per_page'   => - 1,
					'post_type'   => 'listings',
					'post_status' => 'publish',
					'tax_query'   => array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'city',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'zipcode',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'country',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'state',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
						array(
							'taxonomy' => 'community',
							'field'    => 'name',
							'terms'    => array( $post_keyword )
						),
					)
				) ));
			}
			$html = '';
			if ( ! empty( $posts_data ) ) {
				$html .= '<ul class="listing-records">';
				foreach ( $posts_data as $records ) {
					$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $records->ID ), 'thumbnail_size' );

					$out    = "";
					$source = get_post_meta( $records->ID, "source", true );

					if ( $source == "idx-api" ) {

						$photos = get_post_meta( $records->ID, "_ct_slider", true );

						if ( ! empty( $photos ) ) {

							foreach ( $photos as $attachment_id => $attachment_url ) {
								$out = '<img src="' . esc_url( $attachment_url ) . '" width="50" />';
								break;
							}
						}
					}

					if ( $out == "" ) {
						$thumb_id            = get_post_thumbnail_id( $records->ID );
						$thumb_url           = wp_get_attachment_image_src( get_post_thumbnail_id( $records->ID ), 'medium', true );
						$theme_directory_url = get_template_directory_uri();
						if ( ! empty( $thumb_id ) ) {
							$out = '<img src="' . $thumb_url[0] . '" width="50" />';
						} else {
							$out = '<img src="' . $theme_directory_url . '/images/no-image.png" srcset="' . $theme_directory_url . '/images/no-image@2x.png 2x" width="50" />';
						}
					}

					$beds = strip_tags( get_the_term_list( $records->ID, 'beds', '', ', ', '' ) );
					if ( ! empty( $beds ) ) {
						$list_beds = $beds;
					} else {
						$list_beds = 'N/A';
					}

					$baths = strip_tags( get_the_term_list( $records->ID, 'baths', '', ', ', '' ) );
					if ( ! empty( $baths ) ) {
						$list_baths = $baths;
					} else {
						$list_baths = 'N/A';
					}

					$sqft = get_post_meta( $records->ID, "_ct_sqft", true );
					if ( ! empty( $sqft ) ) {
						$list_sqft = $sqft;
					} else {
						$list_sqft = 'N/A';
					}

					$html .= '<li class="listing_media" att_id ="' . $records->post_title . '">
                            <div class="media-left">
                                <a class="media-object" href="' . get_permalink( $records->ID ) . '">' . $out . '</a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="' . get_permalink( $records->ID ) . '">' . $records->post_title . '</a></h4> 
								<ul class="amenities"> 
									<li><strong>' . __( 'Beds: ', 'contempo' ) . '</strong>' . $list_beds . '</li>
									<li><strong>' . __( 'Baths: ', 'contempo' ) . '</strong>' . $list_baths . '</li>
									<li><strong>' . __( 'Sq Ft: ', 'contempo' ) . '</strong>' . $list_sqft . '</li>
								</ul>								
                            </div>
                        </li>';

				}
				$html .= '</ul>';
				$html .= '<div class="search-listingfooter">';
				if ( count( $posts_data ) == 1 ) {
					$html .= '<span class="search-listingcount">' . __( '1 Listing found', 'contempo' ) . '</span>';
				} else {
					$html .= '<span class="search-listingcount">' . count( $posts_data ) . __( ' Listings found', 'contempo' ) . '</span>';
				}
				$html .= '</div>';
			} elseif ( ! empty( $post_meta_data ) ) {
				$html .= '<ul>';
				foreach ( $post_meta_data as $metarecords ) {

					$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $metarecords->ID ), 'thumbnail_size' );

					$out    = "";
					$source = get_post_meta( $metarecords->ID, "source", true );

					if ( $source == "idx-api" ) {

						$photos = get_post_meta( $metarecords->ID, "_ct_slider", true );

						if ( ! empty( $photos ) ) {

							foreach ( $photos as $attachment_id => $attachment_url ) {
								$out = '<img src="' . esc_url( $attachment_url ) . '" width="50" />';
								break;
							}
						}
					}

					if ( $out == "" ) {
						$thumb_id            = get_post_thumbnail_id( $metarecords->ID );
						$thumb_url           = wp_get_attachment_image_src( get_post_thumbnail_id( $metarecords->ID ), 'medium', true );
						$theme_directory_url = get_template_directory_uri();
						if ( ! empty( $thumb_id ) ) {
							$out = '<img src="' . $thumb_url[0] . '" width="50" />';
						} else {
							$out = '<img src="' . $theme_directory_url . '/images/no-image.png" srcset="' . $theme_directory_url . '/images/no-image@2x.png 2x" width="50" />';
						}
					}

					$beds = strip_tags( get_the_term_list( $metarecords->ID, 'beds', '', ', ', '' ) );
					if ( ! empty( $beds ) ) {
						$list_beds = $beds;
					} else {
						$list_beds = 'N/A';
					}

					$baths = strip_tags( get_the_term_list( $metarecords->ID, 'baths', '', ', ', '' ) );
					if ( ! empty( $baths ) ) {
						$list_baths = $baths;
					} else {
						$list_baths = 'N/A';
					}

					$sqft = get_post_meta( $metarecords->ID, "_ct_sqft", true );
					if ( ! empty( $sqft ) ) {
						$list_sqft = $sqft;
					} else {
						$list_sqft = 'N/A';
					}

					$html .= '<li class="listing_media" att_id ="' . get_the_title( $metarecords->ID ) . '">
                            <div class="media-left">
                                <a class="media-object" href="' . get_permalink( $metarecords->ID ) . '">' . $out . '</a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="' . get_permalink( $metarecords->ID ) . '">' . get_post_meta( $metarecords->ID, '_ct_listing_alt_title', true ) . '</a></h4> 
								<ul class="amenities"> 
									<li><strong>' . __( 'Beds: ', 'contempo' ) . '</strong>' . $list_beds . '</li>
									<li><strong>' . __( 'Baths: ', 'contempo' ) . '</strong>' . $list_baths . '</li>
									<li><strong>' . __( 'Sq Ft: ', 'contempo' ) . '</strong>' . $list_sqft . '</li>
								</ul>								
                            </div>
                        </li>';

				}
				$html .= '</ul>';
				$html .= '<div class="search-listingfooter">';
				if ( count( $post_meta_data ) == 1 ) {
					$html .= '<span class="search-listingcount">' . __( '1 Listing found', 'contempo' ) . '</span>';
				} else {
					$html .= '<span class="search-listingcount">' . count( $post_meta_data ) . __( ' Listings found', 'contempo' ) . '</span>';
				}
				$html .= '</div>';
			} elseif ( ! empty( $post_terms ) ) {
				$html .= '<ul class="listing-records">';
				foreach ( $post_terms as $terms_records ) {
					$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $terms_records->ID ), 'thumbnail_size' );

					$out    = "";
					$source = get_post_meta( $terms_records->ID, "source", true );

					if ( $source == "idx-api" ) {

						$photos = get_post_meta( $terms_records->ID, "_ct_slider", true );

						if ( ! empty( $photos ) ) {

							foreach ( $photos as $attachment_id => $attachment_url ) {
								$out = '<img src="' . esc_url( $attachment_url ) . '" width="50" />';
								break;
							}
						}
					}

					if ( $out == "" ) {
						$thumb_id            = get_post_thumbnail_id( $terms_records->ID );
						$thumb_url           = wp_get_attachment_image_src( get_post_thumbnail_id( $terms_records->ID ), 'medium', true );
						$theme_directory_url = get_template_directory_uri();
						if ( ! empty( $thumb_id ) ) {
							$out = '<img src="' . $thumb_url[0] . '" width="50" />';
						} else {
							$out = '<img src="' . $theme_directory_url . '/images/no-image.png" srcset="' . $theme_directory_url . '/images/no-image@2x.png 2x" width="50"/>';
						}
					}

					$beds = strip_tags( get_the_term_list( $terms_records->ID, 'beds', '', ', ', '' ) );
					if ( ! empty( $beds ) ) {
						$list_beds = $beds;
					} else {
						$list_beds = 'N/A';
					}

					$baths = strip_tags( get_the_term_list( $terms_records->ID, 'baths', '', ', ', '' ) );
					if ( ! empty( $baths ) ) {
						$list_baths = $baths;
					} else {
						$list_baths = 'N/A';
					}

					$sqft = get_post_meta( $terms_records->ID, "_ct_sqft", true );
					if ( ! empty( $sqft ) ) {
						$list_sqft = $sqft;
					} else {
						$list_sqft = 'N/A';
					}

					$html .= '<li class="listing_media" att_id ="' . $terms_records->post_title . '">
                            <div class="media-left">
                                <a class="media-object" href="' . get_permalink( $terms_records->ID ) . '">' . $out . '</a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="' . get_permalink( $terms_records->ID ) . '">' . $terms_records->post_title . '</a></h4> 
								<ul class="amenities"> 
									<li><strong>' . __( 'Beds: ', 'contempo' ) . '</strong>' . $list_beds . '</li>
									<li><strong>' . __( 'Baths: ', 'contempo' ) . '</strong>' . $list_baths . '</li>
									<li><strong>' . __( 'Sq Ft: ', 'contempo' ) . '</strong>' . $list_sqft . '</li>
								</ul>								
                            </div>
                        </li>';
				}
				$html .= '</ul>';
				$html .= '<div class="search-listingfooter">';
				if ( count( $post_terms ) == 1 ) {
					$html .= '<span class="search-listingcount">' . __( '1 Listing found', 'contempo' ) . '</span>';
				} else {
					$html .= '<span class="search-listingcount">' . count( $post_terms ) . __( ' Listings found', 'contempo' ) . '</span>';
				}
				$html .= '</div>';

			} else {
				$html = '';
				$html .= '<ul><li id="no-listings-found">' . __( 'No Listings Found', 'contempo' ) . '</li></ul>';
			}
		}
		echo $html;
		die;
	}
}
