/**
 * Contempo Mapping
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

/*****************************************************
 *
 * Start Airbnb style map scrolling
 *
 ******************************************************/

var marker_list = [];
var mapPin      = '';
var map         = null;
var poly        = null;

var storedLongitude = "";
var storedLatitude = "";

var open_info_window = null;

var mapCenterLat = "";
var mapCenterLng = "";

var mapNorthEast = "";
var mapNorthWest = "";
var mapSouthEast = "";
var mapSouthWest = "";

var boundsChanged = false;

var hitCount = 0;

var watchDog = 0;

var x_info_offset = -0; // x,y offset in px when map pans to marker -- to accomodate infoBubble
var y_info_offset = -180;
var debounceTime = 250;
var drawingMode  = false;
var drawListener;
var markerCluster;
var drawMarkers;
var drawBounds;
var oldZoom;
var oldBounds;

google.maps.LatLng.prototype.distanceFrom = function(latlng) {
	var lat = [this.lat(), latlng.lat()]
	var lng = [this.lng(), latlng.lng()]
	var R = 6378137;
	var dLat = (lat[1]-lat[0]) * Math.PI / 180;
	var dLng = (lng[1]-lng[0]) * Math.PI / 180;
	var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
		Math.cos(lat[0] * Math.PI / 180 ) * Math.cos(lat[1] * Math.PI / 180 ) *
		Math.sin(dLng/2) * Math.sin(dLng/2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
	var d = R * c;
	return Math.round(d);
}

jQuery(document).on("click", ".cancelDrawButton", function (e) {
	cancelDrawing();
	disableDrawMode();
	google.maps.event.removeListener( drawListener );
	jQuery('.draw-mode').find('span').html( 'Draw' );
});

jQuery(document).on("click", ".pagination a", function (e) {

	var value = jQuery(this).attr("href");
	if ( value.indexOf( "?" ) < 0 ) {
		return;
	}

	value = value.substring( value.indexOf( "?" ) + 1 );

	if ( getUrlParameter( "action", value) == "map_listing_update" ) {
		jQuery( "#number-listings-progress" ).css( "display", "block" );
		e.preventDefault();

		ne = getUrlParameter( "ne", value );
		ne = jQuery( "<div />" ).html( ne ).text(); // unescape it
		ne = ne.replace( "+", " " );

		sw = getUrlParameter( "sw", value) ;
		sw = jQuery("<div />").html( sw ).text(); // unescape it
		sw = sw.replace( "+", " " );

		paged = getUrlParameter( "paged", value );

		doAjax( ne, sw, paged );

		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
	}

	if ( poly != null ) {
		jQuery( "#number-listings-progress" ).css( "display", "block" );
		e.preventDefault();
		paged = parseInt( jQuery(this).html() );
		doAjax( '', '', paged );
		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
	}

});

jQuery(document).on( "mouseenter", ".side-results .listing", function (e) {


	var listingID = jQuery(this).attr('data-listing-id');

	if ( open_info_window ) {
		open_info_window.close();
		jQuery('img[src="' + open_info_window.closeBoxURL_ + '"]').click();
	}

	if ( undefined != listingID ) {
		for ( var i = 0; i < marker_list.length; i++ ) {

			if (parseInt(marker_list[i].listingID, 10) === parseInt(listingID, 10)) {
				extraClass = '';
				tempMarker = jQuery("img[src='" + marker_list[i].iconURL + "']").parent();
				if( marker_list[i].priceDisplay == 'false' ) {
					extraClass = 'no-price-display';
				}
				if ( tempMarker.find('.markerClass').length  > 0 ) {
					tempMarker.find('.markerClass').first().addClass('ct-active-marker');
				} else {
					tempMarker.append('<div class="markerClass ct-active-marker ' + marker_list[i].ctStatus + ' ' + extraClass + '"></div>');
				}

				if ( marker_list[i].infobox ) {

					var northWest  = new google.maps.LatLng( map.getBounds().getNorthEast().lat() , map.getBounds().getSouthWest().lng()  );
					var southEast  = new google.maps.LatLng( map.getBounds().getSouthWest().lat() , map.getBounds().getNorthEast().lng()  );
					var SWdistance = map.getBounds().getSouthWest().distanceFrom(marker_list[i].getPosition());
					var NEdistance = map.getBounds().getNorthEast().distanceFrom(marker_list[i].getPosition());
					var NWdistance = northWest.distanceFrom(marker_list[i].getPosition());
					var SEdistance = southEast.distanceFrom(marker_list[i].getPosition());

					var minDistance = Math.min( SWdistance, NEdistance, NWdistance, SEdistance );

					switch (minDistance) {
						case SEdistance:
							ibOffset = new google.maps.Size( -300, 150 );
							//console.log('SE');
							break;
						case NEdistance:
							ibOffset = new google.maps.Size( -300, 250 );
							//console.log('NE');
							break;
						case NWdistance:
							ibOffset = new google.maps.Size( 50,300 );
							//console.log('NW');
							break;
						case SWdistance:
							ibOffset = new google.maps.Size( 50, 100 );
							//console.log('SW');
							break;
					}

					marker_list[i].infobox.setOptions({'pixelOffset': ibOffset});
					marker_list[i].infobox.open(map, marker_list[i]);
					open_info_window = marker_list[i].infobox;
				}

			}
		}

	}

});

jQuery(document).on( "mouseleave", ".side-results .listing, .listing-search-results .listing", function (e) {

	var listingID = jQuery(this).attr('data-listing-id');

	if ( undefined != listingID ) {
		for ( var i = 0; i < marker_list.length; i++ ) {

			if (parseInt(marker_list[i].listingID, 10) === parseInt(listingID, 10)) {

				jQuery('.ct-active-marker').removeClass('ct-active-marker');

				if ( open_info_window ) {
					open_info_window.close();
					jQuery('img[src="' + open_info_window.closeBoxURL_ + '"]').click();
				} else {
					if ( marker_list[i].infobox ) {
						marker_list[i].infobox.close(map);
					}
				}

				break;

			}
		}

	}

});

function getUrlParameterObject( sPageURL="" )
{
	if( sPageURL == "" ) {
		sPageURL = window.location.search.substring(1);
	}

	var sURLVariables = sPageURL.split('&'), sParameterName, i;

	returnObject = {};

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		key = sParameterName[0];
		value = sParameterName[1] === undefined ? "" : decodeURIComponent(sParameterName[1]);

		if ( value != "" ) {

			returnObject = Object.assign({[key]: value}, returnObject)

		}

	}

	return returnObject;
}

function getUrlParameter( sParam, sPageURL )
{
	if( sPageURL == "" ) {
		sPageURL = window.location.search.substring(1);
	}

	var sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? false : decodeURIComponent(sParameterName[1]);
		}
	}

	return false;
}

//function getUsersLocation()
//{
	// This function only works over https and only if user consents.
//	if ( navigator.geolocation ) {

//		navigator.geolocation.getCurrentPosition(
			// Success function
//			getCoords
//		);
//	}
//}

//function getCoords( position )
//{
//	jQuery( "#search-by-user-location-2" ).show();
	//jQuery( "#advanced_search.header-search #submit" ).width(jQuery("#advanced_search.header-search #submit" ).width( ) - 35);

//	storedLongitude = position.coords.longitude;
//	storedLatitude = position.coords.latitude;
//}

jQuery( "#search-by-user-location a").click( function() {
	jQuery( "#search-latitude" ).val( storedLatitude );
	jQuery( "#search-longitude" ).val( storedLongitude );
	jQuery( "#submit" ).trigger( "click" );
});

jQuery( "#search-by-user-location-2").click( function() {
	jQuery( "#search-latitude" ).val( storedLatitude );
	jQuery( "#search-longitude" ).val( storedLongitude );
	jQuery( "#submit" ).trigger( "click" );
});

jQuery(document).on("click", ".sale-lease-links a", function (e) {

	if ( storedLatitude == "" || storedLongitude == "" ) {
		return;
	}

	e.preventDefault();

	IsplaceChange = true;
	window.location.href = this.href + "&lat=" + storedLatitude + "&lng=" + storedLongitude;

});

function debounce(fn, time)
{
	let theTimeout;
	return function()
	{
		const args = arguments;
		const functionCall = () => fn.apply(this, args);
		clearTimeout(theTimeout);
		theTimeout = setTimeout(functionCall, time);
	}
}

/***
 * returns -1 if not exists or the index if it does exist
 */
function markerExistsByLatLng( lat, lng, currentIndex=-1 )
{

	l = new google.maps.LatLng( lat, lng );

	for( y = 0; y < marker_list.length; y++ ) {
		test = marker_list[y];

		if ( l.equals( test.getPosition() ) ) {
			return y;
		}
	}

	return -1;

}

/***
 * returns -1 if not exists or the index if it does exist
 */
function markerExistsByMarker( marker, currentIndex=-1 )
{

	if ( currentIndex == -1 ) {
		currentIndex = 0;
	} else {
		currentIndex++;
	}

	for( x = currentIndex; x < marker_list.length; x++ ) {
		test = marker_list[x];
		if ( marker.getPosition().equals(
			test.getPosition()
		) ) {
			return x;
		}
	}

	return -1;
}

function removeDuplicateMarkers()
{
	indexesToRemove = new Array();
	markerLength = marker_list.length;

	for( gf = 0; gf < markerLength; gf++ ) {
		m = marker_list[gf];

		if ( markerExistsByMarker( m, gf ) > -1 ) {
			m.setMap(null);
			indexesToRemove.push(gf);
		}
	}

	for( gf = 0; gf < indexesToRemove.length; gf++ ) {
		marker_list.splice( indexesToRemove[gf], 1 );
	}

}


function doAjax(ne, sw, paged=1 )
{
	var data = {};
	data = getUrlParameterObject(  ) ;

	data = Object.assign({action: 'map_listing_update'}, data);
	data = Object.assign({ne: ne.toString()}, data);
	data = Object.assign({sw: sw.toString()}, data);
	data = Object.assign({paged: paged}, data);

	// Listing status multi.
	data = Object.assign({ct_ct_status_multi: re7_localized_multiple_filters.filters.ct_ct_status_multi }, data );

	// Listing additional features.
	data = Object.assign({ct_additional_features: re7_localized_multiple_filters.filters.ct_additional_features }, data );

	// Listing property type.
	data = Object.assign({ct_property_type: re7_localized_multiple_filters.filters.ct_property_type }, data );

	// IF the drawing mode is enabled
	if ( drawMarkers != null && drawMarkers.length > 0 ) {
		data = Object.assign({drawMode: true}, data);
		data = Object.assign({drawMarkers: JSON.stringify(drawMarkers)}, data);
		//drawBounds = new google.maps.LatLngBounds();
	}

	url = mapping_ajax_object.ajax_url;

	//console.log("url: ");
	//console.log(url);
	jQuery.get( url, data, function( response ) {

		if( response != "" ) {


			//dataArray = JSON.parse( response );
			dataArray = response;
			//console.log("args: ");
			//console.log(dataArray.args);
			//console.log("wp_query: ");
			//console.log(dataArray.wp_query);
			//console.log("paged: " + dataArray.paged);
			//console.log("coords: " + dataArray.coords);
			//console.log("post__in: " + dataArray.post__in);


			document.getElementById("search-listing-mapper").innerHTML = dataArray.listings;
			document.getElementById("number-listings-found").innerHTML = dataArray.count;


			siteURL = dataArray.siteURL;

			if ( dataArray.map != "" ) {

				latlngs = dataArray.latlngs;
				var imagesURL;

				while( marker_list.length ) {
					marker_list.pop().setMap(null);
				}
				marker_list = [];
				// Clear all clusters.
				markerCluster.clearMarkers();

				for( x = 0; x < latlngs.length; x++ ) {

					if( markerExistsByLatLng( latlngs[x].lat, latlngs[x].lng ) == -1 ) {

						imagesURL = latlngs[x].property.siteURL;

						var mapPin        = getMapPin( latlngs[x].property );
						enableMarkerPrice = mapping_ajax_object.ct_enable_marker_price;
						priceZoomLevel    = parseInt( mapping_ajax_object.search_marker_price_zoom_level );
						priceLabel        = '';

						//if ( priceZoomLevel <= map.getZoom() && enableMarkerPrice == 'yes' && mapping_ajax_object.listing_marker_type == 'svg' ) {
						if ( showMarkerWithPrice( latlngs[x].property ) ) {
							priceLabel = {
								text: latlngs[x].property.markerPrice,
								color: '#222',
								fontSize: '11px',
								fontWeight: 'normal'
							};
						}

						var marker = new google.maps.Marker({
							animation: null,
							draggable: false,
							flat: true,
							fullScreenControl: true,
							fullscreenControlOptions: {
								position: google.maps.ControlPosition.BOTTOM_LEFT
							},
							icon: mapPin,
							position: {lat: parseFloat( latlngs[x].lat ), lng: parseFloat( latlngs[x].lng )},
							listingID: latlngs[x].property.listingID,
							iconURL: mapPin.url,
							label: priceLabel,
							ctStatus: latlngs[x].property.ctStatus,
							priceDisplay: latlngs[x].property.priceDisplay,
						});

						marker_list.push( marker );

						currentMarker = marker_list.length - 1;


						var imagesURL = latlngs[x].property.siteURL;

						var contentString = getInfoBoxContentString( latlngs[x].property );

						if ( mapping_ajax_object.listing_marker_type == 'svg' ) {
							if ( priceZoomLevel <= map.getZoom() && enableMarkerPrice == 'yes' ) {
								pixOff = new google.maps.Size( -125, (mapping_ajax_object.ct_listing_marker_svg_size * -1) - 50 );
							} else {
								pixOff = new google.maps.Size( -125, (mapping_ajax_object.ct_listing_marker_svg_size * -1)-30 );
							}
						} else {
							pixOff = new google.maps.Size( -125, -64 );
						}

						marker_list[currentMarker].infobox = new InfoBox({
							content: contentString,
							disableAutoPan: true,
							maxWidth: 0,
							alignBottom: true,
							pixelOffset: pixOff,
							zIndex: null,
							closeBoxMargin: "8px 0 -20px -20px",
							closeBoxURL: imagesURL+'/images/infobox-close.png',
							infoBoxClearance: new google.maps.Size(1, 1),
							isHidden: false,
							pane: "floatPane",
							enableEventPropagation: false
						});
						//latlng = new google.maps.LatLng( latlngs[x].lat , latlngs[x].lng  );
						//drawBounds.extend(latlng);


						google.maps.event.addListener(marker, 'click', (function(marker, currentMarker) {

							return function() {
								marker_list[currentMarker].infobox.open(map, this);
								map.panTo( convert_offset( marker_list[currentMarker].position, x_info_offset, y_info_offset ) );
								//map.setCenter(marker_list[currentMarker].position);

								if(open_info_window) {
									open_info_window.close();
								}

								open_info_window = marker_list[currentMarker].infobox;

							}

						})(marker, currentMarker));


					}
				}


				removeDuplicateMarkers();

				var markerClustererOptions = {
					ignoreHidden: true,
					maxZoom: mapping_ajax_object.search_cluster_zoom_level,
					styles: [{
						textColor: '#ffffff',
						url: siteURL+'/images/cluster-icon.png?ver=1.0.1',
						height: 48,
						width: 48
					}]
				};

				markerCluster = new MarkerClusterer(map, marker_list, markerClustererOptions);

			}

			if ( drawMarkers != null && drawMarkers.length > 0 ) {
				disableDrawMode();

				if ( drawBounds != null ) {

					map.fitBounds(drawBounds);
				}
			}

		}

		document.getElementById("number-listings-progress").style.display = "none";
		manageFeaturedTags();

	}, "json");
}

function getMapBounds( map )
{
	//console.log("in getMapBounds");
	if ( poly == null ) {
		progressDiv = document.getElementById("number-listings-progress");

		if ( ! progressDiv ) {
			// not on the map page
			return;
		}

		var bounds =  map.getBounds();
		var ne = bounds.getNorthEast();
		var sw = bounds.getSouthWest();

		// already in an event..
		if ( boundsChanged == true ) {
			return;
		}

		progressDiv.style.display = "inherit";

		if ( mapNorthEast != ne ) {
			boundsChanged = true;
		}


		if ( mapSouthWest != sw ) {
			boundsChanged = true;
		}

		if ( boundsChanged == true ) {

			//console.log("doing it... hitCount: " + hitCount);

			if(open_info_window) {
				open_info_window.close();
			}

			if ( hitCount == 0 ) {
				hitCount++;
				// we ignore the initial event on page load
				setTimeout( function(){ boundsChanged = false; }, 250);

				document.getElementById("number-listings-progress").style.display = "none";

				return;
			}


			doAjax(ne, sw);

			setTimeout( function(){ boundsChanged = false; }, 250);

			jQuery(".pagination").hide();


		}
	}
}

function getInfoBoxContentString( property )
{

	//console.log("property Image: " + property.thumb);
	var svgPriceClass='';

	if ( showMarkerWithPrice( property ) ) {
		svgPriceClass = 'ct-marker-svg-price';
	}

	if(property['contactpage'] == 'contactpage') {

		if(property['thumb'] != '') {

			return '<div class="infobox '+ svgPriceClass + '">'+
				'<div class="info-image"'+
				'<figure>'+
				'<img src="'+property.thumb+'" height="250" width="250" />'+
				'</figure>'+
				'</div>'+
				'<div class="listing-details">'+
				'<header>'+
				'<h4 class="marT0">'+property.street+'</h4>'+
				'</header>'+
				'<p class="price marB0"><strong><a href="//maps.google.com/maps?daddr='+property.street+'" target="_blank">Driving Directions</a></strong></p>'+
				'</div>';

		} else {

			return '<div class="infobox '+ svgPriceClass + '">'+
				'<div class="listing-details">'+
				'<header>'+
				'<h4 class="marT0">'+property.title+'</h4>'+
				'</header>'+
				'<p class="price marB0"><strong><a href="//maps.google.com/maps?daddr='+property.street+'" target="_blank">Driving Directions</a></strong></p>'+
				'</div>';

		}

	} else {

		if(property['commercial'] == 'commercial' || property['industrial'] == 'industrial' || property['retail'] == 'retail') {

			return '<div class="infobox '+ svgPriceClass + '">'+
				'<div class="info-image"'+
				'<figure>'+
				'<a href="'+property.permalink+'">'+
				property.thumb+
				'</a>'+
				'</figure>'+
				'</div>'+
				'<div class="listing-details">'+
				'<header>'+
				'<h4 class="marT5 marB5"><a href="'+property.permalink+'">'+property.title+'</a></h4>'+
				'<p class="location muted marB10">'+property.city+', '+property.state+'&nbsp;'+property.zip+'</p>'+
				'<p class="listing-icons muted marB0"><svg id="ico-size-commercial" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 20 20"> <path d="M17.5 3h-8.5v-0.5c0-0.827-0.673-1.5-1.5-1.5h-2c-0.827 0-1.5 0.673-1.5 1.5v0.5h-2.5c-0.827 0-1.5 0.673-1.5 1.5v2c0 0.827 0.673 1.5 1.5 1.5h2.5v10.5c0 0.827 0.673 1.5 1.5 1.5h2c0.827 0 1.5-0.673 1.5-1.5v-10.5h8.5c0.827 0 1.5-0.673 1.5-1.5v-2c0-0.827-0.673-1.5-1.5-1.5zM5 2.5c0-0.276 0.224-0.5 0.5-0.5h2c0.276 0 0.5 0.224 0.5 0.5v0.5h-3v-0.5zM8 10h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v2h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v2h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1.5c0 0.276-0.224 0.5-0.5 0.5h-2c-0.276 0-0.5-0.224-0.5-0.5v-10.5h3v2zM18 6.5c0 0.276-0.224 0.5-0.5 0.5h-1.5v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-2v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-2v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-2v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-2v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-1.5c-0.276 0-0.5-0.224-0.5-0.5v-2c0-0.276 0.224-0.5 0.5-0.5h16c0.276 0 0.5 0.224 0.5 0.5v2z" fill="#878c92"></path> </svg> <span>'+property.size+'</span>'+
				'<p class="price marB0"><strong>'+property.fullPrice+'</strong></p>'+
				'</header>'+
				'</div>';

		} else if(property['land'] == 'land') {

			return '<div class="infobox '+ svgPriceClass + '">'+
				'<div class="info-image"'+
				'<figure>'+
				'<a href="'+property.permalink+'">'+
				property.thumb+
				'</a>'+
				'</figure>'+
				'</div>'+
				'<div class="listing-details">'+
				'<header>'+
				'<h4 class="marT5 marB5"><a href="'+property.permalink+'">'+property.title+'</a></h4>'+
				'<p class="location muted marB10">'+property.city+', '+property.state+'&nbsp;'+property.zip+'</p>'+
				'<p class="price marB0"><strong>'+property.fullPrice+'</strong></p>'+
				'</header>'+
				'</div>';

		} else {

			return '<div class="infobox '+ svgPriceClass + '">'+
				'<div class="info-image"'+
				'<figure>'+
				'<a href="'+property.permalink+'">'+
				property.thumb+
				'</a>'+
				'</figure>'+
				'</div>'+
				'<div class="listing-details">'+
				'<header>'+
				'<h4 class="marT5 marB5"><a href="'+property.permalink+'">'+property.title+'</a></h4>'+
				'<p class="location muted marB10">'+property.city+', '+property.state+'&nbsp;'+property.zip+'</p>'+
				'<p class="listing-icons muted marB0">'+'<svg id="ico-bed" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 20 20"> <path d="M17.5 18h-1c-0.276 0-0.5-0.224-0.5-0.5s0.224-0.5 0.5-0.5h1c0.276 0 0.5 0.224 0.5 0.5s-0.224 0.5-0.5 0.5z" fill="#878c92"></path> <path d="M2.5 18h-1c-0.276 0-0.5-0.224-0.5-0.5s0.224-0.5 0.5-0.5h1c0.276 0 0.5 0.224 0.5 0.5s-0.224 0.5-0.5 0.5z" fill="#878c92"></path> <path d="M18.658 11.393l-2.368-7.103c-0.199-0.596-0.768-1.086-1.388-1.24-0.022-0.095-0.046-0.186-0.074-0.27-0.227-0.68-0.616-0.781-0.828-0.781h-4c-0.127 0-0.318 0.037-0.5 0.213-0.182-0.176-0.373-0.213-0.5-0.213h-4c-0.212 0-0.601 0.102-0.828 0.781-0.028 0.084-0.053 0.174-0.074 0.27-0.621 0.154-1.19 0.643-1.388 1.24l-2.368 7.103c-0.192 0.575-0.342 1.501-0.342 2.107v2c0 0.827 0.673 1.5 1.5 1.5h16c0.827 0 1.5-0.673 1.5-1.5v-2c0-0.606-0.15-1.532-0.342-2.107zM10.157 3h3.686c0.070 0.157 0.157 0.514 0.157 1s-0.087 0.843-0.157 1h-3.686c-0.070-0.157-0.157-0.514-0.157-1s0.087-0.843 0.157-1zM5.157 3h3.686c0.070 0.157 0.157 0.514 0.157 1s-0.087 0.843-0.157 1h-3.686c-0.070-0.157-0.157-0.514-0.157-1s0.087-0.843 0.157-1zM3.658 4.607c0.054-0.162 0.185-0.317 0.345-0.429 0.014 0.388 0.072 0.752 0.169 1.041 0.227 0.68 0.616 0.781 0.828 0.781h4c0.127 0 0.318-0.037 0.5-0.213 0.182 0.176 0.373 0.213 0.5 0.213h4c0.212 0 0.601-0.102 0.828-0.781 0.096-0.289 0.155-0.654 0.169-1.041 0.16 0.113 0.291 0.267 0.345 0.429l0.798 2.393h-13.279l0.798-2.393zM2.527 8h13.946l1.236 3.709c0.032 0.095 0.062 0.204 0.091 0.321-0.097-0.020-0.197-0.030-0.3-0.030h-16c-0.103 0-0.203 0.010-0.3 0.030 0.029-0.117 0.059-0.226 0.091-0.321l1.237-3.709zM18 15.5c0 0.276-0.224 0.5-0.5 0.5h-16c-0.276 0-0.5-0.224-0.5-0.5v-2c0-0.276 0.224-0.5 0.5-0.5h16c0.276 0 0.5 0.224 0.5 0.5v2z" fill="#878c92"></path> </svg> <span>'+property.bed+'</span>'+
				'<svg id="ico-bath" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 20 20"> <path d="M16.5 20h-1c-0.276 0-0.5-0.224-0.5-0.5s0.224-0.5 0.5-0.5h1c0.276 0 0.5 0.224 0.5 0.5s-0.224 0.5-0.5 0.5z" fill="#878c92"></path> <path d="M4.5 20h-1c-0.276 0-0.5-0.224-0.5-0.5s0.224-0.5 0.5-0.5h1c0.276 0 0.5 0.224 0.5 0.5s-0.224 0.5-0.5 0.5z" fill="#878c92"></path> <path d="M20 12.5c0-0.827-0.673-1.5-1.5-1.5h-15.5v-9.5c0-0.276 0.224-0.5 0.5-0.5h1.5c0.142 0 0.399 0.106 0.5 0.207l0.126 0.126c-0.929 1.27-0.821 3.068 0.326 4.215 0.094 0.094 0.221 0.146 0.354 0.146s0.26-0.053 0.354-0.146l3.889-3.889c0.195-0.195 0.195-0.512 0-0.707-0.614-0.614-1.43-0.952-2.298-0.952-0.699 0-1.364 0.219-1.918 0.625l-0.125-0.125c-0.29-0.29-0.797-0.5-1.207-0.5h-1.5c-0.827 0-1.5 0.673-1.5 1.5v9.5h-0.5c-0.827 0-1.5 0.673-1.5 1.5 0 0.652 0.418 1.208 1 1.414v2.586c0 1.378 1.122 2.5 2.5 2.5h13c1.378 0 2.5-1.122 2.5-2.5v-2.586c0.582-0.206 1-0.762 1-1.414zM9.448 1.345l-3.103 3.103c-0.546-0.869-0.442-2.033 0.314-2.789 0.425-0.425 0.99-0.659 1.591-0.659 0.431 0 0.843 0.12 1.198 0.345zM16.5 18h-13c-0.827 0-1.5-0.673-1.5-1.5v-2.5h16v2.5c0 0.827-0.673 1.5-1.5 1.5zM18.5 13h-17c-0.276 0-0.5-0.224-0.5-0.5s0.224-0.5 0.5-0.5h17c0.276 0 0.5 0.224 0.5 0.5s-0.224 0.5-0.5 0.5z" fill="#878c92"></path> <path d="M10 6.5c0 0.276-0.224 0.5-0.5 0.5s-0.5-0.224-0.5-0.5c0-0.276 0.224-0.5 0.5-0.5s0.5 0.224 0.5 0.5z" fill="#878c92"></path> <path d="M10 4.5c0 0.276-0.224 0.5-0.5 0.5s-0.5-0.224-0.5-0.5c0-0.276 0.224-0.5 0.5-0.5s0.5 0.224 0.5 0.5z" fill="#878c92"></path> <path d="M12 4.5c0 0.276-0.224 0.5-0.5 0.5s-0.5-0.224-0.5-0.5c0-0.276 0.224-0.5 0.5-0.5s0.5 0.224 0.5 0.5z" fill="#878c92"></path> <path d="M12 6.5c0 0.276-0.224 0.5-0.5 0.5s-0.5-0.224-0.5-0.5c0-0.276 0.224-0.5 0.5-0.5s0.5 0.224 0.5 0.5z" fill="#878c92"></path> <path d="M14 4.5c0 0.276-0.224 0.5-0.5 0.5s-0.5-0.224-0.5-0.5c0-0.276 0.224-0.5 0.5-0.5s0.5 0.224 0.5 0.5z" fill="#878c92"></path> <path d="M10 8.5c0 0.276-0.224 0.5-0.5 0.5s-0.5-0.224-0.5-0.5c0-0.276 0.224-0.5 0.5-0.5s0.5 0.224 0.5 0.5z" fill="#878c92"></path> <path d="M14 6.5c0 0.276-0.224 0.5-0.5 0.5s-0.5-0.224-0.5-0.5c0-0.276 0.224-0.5 0.5-0.5s0.5 0.224 0.5 0.5z" fill="#878c92"></path> <path d="M12 8.5c0 0.276-0.224 0.5-0.5 0.5s-0.5-0.224-0.5-0.5c0-0.276 0.224-0.5 0.5-0.5s0.5 0.224 0.5 0.5z" fill="#878c92"></path> </svg><span>'+property.bath+'</span>'+
				'<svg id="ico-size" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 20 20"> <path d="M17.5 3h-8.5v-0.5c0-0.827-0.673-1.5-1.5-1.5h-2c-0.827 0-1.5 0.673-1.5 1.5v0.5h-2.5c-0.827 0-1.5 0.673-1.5 1.5v2c0 0.827 0.673 1.5 1.5 1.5h2.5v10.5c0 0.827 0.673 1.5 1.5 1.5h2c0.827 0 1.5-0.673 1.5-1.5v-10.5h8.5c0.827 0 1.5-0.673 1.5-1.5v-2c0-0.827-0.673-1.5-1.5-1.5zM5 2.5c0-0.276 0.224-0.5 0.5-0.5h2c0.276 0 0.5 0.224 0.5 0.5v0.5h-3v-0.5zM8 10h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v2h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v2h-0.5c-0.276 0-0.5 0.224-0.5 0.5s0.224 0.5 0.5 0.5h0.5v1.5c0 0.276-0.224 0.5-0.5 0.5h-2c-0.276 0-0.5-0.224-0.5-0.5v-10.5h3v2zM18 6.5c0 0.276-0.224 0.5-0.5 0.5h-1.5v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-2v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-2v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-2v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-2v-0.5c0-0.276-0.224-0.5-0.5-0.5s-0.5 0.224-0.5 0.5v0.5h-1.5c-0.276 0-0.5-0.224-0.5-0.5v-2c0-0.276 0.224-0.5 0.5-0.5h16c0.276 0 0.5 0.224 0.5 0.5v2z" fill="#878c92"></path> </svg> <span>'+property.size+'</span></p>'+
				'<p class="price marB0"><strong>'+property.fullPrice+'</strong></p>'+
				'</header>'+
				'</div>';

		}

	}

}

function init_canvas_projection(map) {
	function CanvasProjectionOverlay() {}
	CanvasProjectionOverlay.prototype = new google.maps.OverlayView();
	CanvasProjectionOverlay.prototype.constructor = CanvasProjectionOverlay;
	CanvasProjectionOverlay.prototype.onAdd = function(){};
	CanvasProjectionOverlay.prototype.draw = function(){};
	CanvasProjectionOverlay.prototype.onRemove = function(){};

	canvasProjectionOverlay = new CanvasProjectionOverlay();
	canvasProjectionOverlay.setMap(map);
}

function convert_offset(latlng, x_offset, y_offset) {
	var proj = canvasProjectionOverlay.getProjection();
	var point = proj.fromLatLngToContainerPixel(latlng);
	point.x = point.x + x_offset;
	point.y = point.y + y_offset;
	return proj.fromContainerPixelToLatLng(point);
}

function getMapPin( property ) {

	property.ctStatus = property.ctStatus.trim();

	if ( mapping_ajax_object.listing_marker_type == 'svg' ) {
		svgSize           = mapping_ajax_object.ct_listing_marker_svg_size;
		svgWidth          = svgSize*2;
		svgHeight         = svgSize*2;
		enableMarkerPrice = mapping_ajax_object.ct_enable_marker_price;
		priceZoomLevel    = parseInt( mapping_ajax_object.search_marker_price_zoom_level );
		svgVersion        = '?ver=1.0.7';

		if ( property.mapZoom == undefined ) {
			property.mapZoom = map.getZoom();
		}

		if ( showMarkerWithPrice( property ) ) {
			svgWidth              = 40;
			svgHeight             = 60;
			labelOriginY          = 22;
			property.priceDisplay = 'true';

			//default SVG icon with price holder
			svgURL  = property["siteURL"]+'/images/svgs/map-marker-price.svg';

			// For Sale SVG icon with price holder.
			if ( property.ctStatus == 'for-sale' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-for-sale.svg';
			}

			// Active SVG icon with price holder
			if ( property.ctStatus == 'active' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-for-sale.svg';
			}

			// For Rent SVG icon with price holder
			if ( property.ctStatus == 'for-rent' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-for-rent-rental.svg';
			}

			// Rental SVG icon with price holder
			if ( property.ctStatus == 'rental' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-for-rent-rental.svg';
			}

			// REO Bank Owned SVG icon with price holder
			if ( property.ctStatus == 'reo-bank-owned' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-reo-bank-owned.svg';
			}

			// Short Sale SVG icon with price holder
			if ( property.ctStatus == 'short-sale' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-reduced-short-sale.svg';
			}

			// Leased SVG icon with price holder
			if ( property.ctStatus == 'leased' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-leased-rented.svg';
			}

			// Rented SVG icon with price holder
			if ( property.ctStatus == 'rented' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-leased-rented.svg';
			}

			// Reduced SVG icon with price holder
			if ( property.ctStatus == 'reduced' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-reduced-short-sale.svg';
			}

			// Sold SVG icon with price holder
			if ( property.ctStatus == 'sold' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-sold.svg';
			}

			// Pending SVG icon with price holder
			if ( property.ctStatus == 'pending' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-pending.svg';
			}

			// Open House SVG icon with price holder
			if ( property.ctStatus == 'open-house' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-open-house.svg';
			}

			// Available SVG icon with price holder
			if ( property.ctStatus == 'available' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-available.svg';
			}

			// New Addition SVG icon with price holder
			if ( property.ctStatus == 'new-addition' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-new-addition.svg';
			}

			// New Listing SVG icon with price holder
			if ( property.ctStatus == 'new-listing' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-new-addition.svg';
			}

			// Special Offer SVG icon with price holder
			if ( property.ctStatus == 'special-offer' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-price-for-sale.svg';
			}

		} else {

			labelOriginY          = 10;
			property.priceDisplay = 'false';
			svgWidth          = svgSize*3;
			svgHeight         = svgSize*3;

			//default SVG icon.
			svgURL  = property["siteURL"]+'/images/svgs/map-marker.svg';
			// For Sale SVG icon.
			if ( property.ctStatus == 'for-sale' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-for-sale.svg';
			}

			// Active SVG icon
			if ( property.ctStatus == 'active' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-for-sale.svg';
			}

			// For Rent SVG icon
			if ( property.ctStatus == 'for-rent' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-for-rent-rental.svg';
			}

			// Rental SVG icon
			if ( property.ctStatus == 'rental' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-for-rent-rental.svg';
			}

			// REO Bank Owned SVG icon
			if ( property.ctStatus == 'reo-bank-owned' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-reo-bank-owned.svg';
			}

			// Short Sale SVG icon
			if ( property.ctStatus == 'short-sale' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-reduced-short-sale.svg';
			}

			// Leased SVG icon
			if ( property.ctStatus == 'leased' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-leased-rented.svg';
			}

			// Rented SVG icon with price holder.
			if ( property.ctStatus == 'rented' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-leased-rented.svg';
			}

			// Reduced SVG icon
			if ( property.ctStatus == 'reduced' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-reduced-short-sale.svg';
			}

			// Sold SVG icon
			if ( property.ctStatus == 'sold' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-sold.svg';
			}

			// Pending SVG icon
			if ( property.ctStatus == 'pending' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-pending.svg';
			}

			// Open House SVG icon
			if ( property.ctStatus == 'open-house' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-open-house.svg';
			}

			// Available SVG icon
			if ( property.ctStatus == 'available' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-available.svg';
			}

			// New Addition SVG icon
			if ( property.ctStatus == 'new-addition' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-new-addition.svg';
			}

			// New Listing SVG icon
			if ( property.ctStatus == 'new-listing' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-new-addition.svg';
			}

			// Special Offer SVG icon
			if ( property.ctStatus == 'special-offer' ) {
				svgURL  = property["siteURL"]+'/images/svgs/map-marker-for-sale.svg';
			}

		}

		svgURL = svgURL + '#' +property.listingID  + svgVersion;

		return {
			url: svgURL,
			size: new google.maps.Size(svgWidth, svgHeight ),
			scaledSize: new google.maps.Size(svgWidth, svgHeight),
			labelOrigin: new google.maps.Point(20, labelOriginY ),
		}

	} else {

		if(property['commercial'] == 'commercial') {
			return {
				url: property["siteURL"]+'/images/map-pin-com.png'+ '#' +property.listingID,
				size: new google.maps.Size(40, 46),
				scaledSize: new google.maps.Size(40, 46)
			};
		} else if(property['land'] == 'land' || property['land'] == 'lot') {
			return {
				url: property["siteURL"]+'/images/map-pin-land.png'+ '#' +property.listingID,
				size: new google.maps.Size(40, 46),
				scaledSize: new google.maps.Size(40, 46)
			};
		}

		return {
			url: property["siteURL"]+'/images/map-pin-res.png'+ '#' +property.listingID,
			size: new google.maps.Size(40, 46),
			scaledSize: new google.maps.Size(40, 46)
		}
	}


}
/*****************************************************
 *
 * Cancel Drawing  FreeHand Area in the Map
 *
 ******************************************************/
function cancelDrawing(){

	jQuery( '#map-wrap .drawInstructionBar' ).remove();
	jQuery( '#ct-map-navigation, #compare-panel' ).show();
	jQuery( '#map .gm-style > div > div > div > div > img' ).show();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(1) > div:nth-child(4)' ).show();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(3)' ).css('opacity','1');
	drawBounds = null;

}

/*****************************************************
 *
 * Draw FreeHand Area in the Map
 *
 ******************************************************/
function drawFreeHand(){

	poly = new google.maps.Polyline( { map:map,clickable:false } );
	var move = google.maps.event.addListener( map,'mousemove',function(e){
		poly.getPath().push( e.latLng );
	});

	// Mouse Up Listener
	var map_mouse_up_listener = google.maps.event.addListenerOnce(map,'mouseup',function(e){

		google.maps.event.removeListener( move );
		google.maps.event.removeListener( map_mouse_up_listener );
		var path = poly.getPath();
		poly.setMap(null);
		poly = new google.maps.Polygon({
			map:map,
			path:path,
			strokeOpacity: 0.3,
			fillOpacity: 0.3,
			strokeColor: '#8e9092',
			strokeWeight: 1,
		});

		google.maps.event.clearListeners( map.getDiv(), 'mousedown' );
		getMarkersInsideDraw(e, poly);

		if ( drawMarkers.length > 0 ) {
			oldZoom   = map.getZoom();
			oldBounds = map.getBounds();
			jQuery( "#number-listings-progress" ).css( "display", "block" );
			jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(3)' ).css('opacity','0');
			doAjax('','', 1 );
			jQuery( '#map-wrap .drawInstructionBar' ).remove();
			jQuery( '#ct-map-navigation, #compare-panel' ).show();
		} else {
			cancelDrawing();
			disableDrawMode();
		}

	});
}



/*****************************************************
 *
 * Enable Draw Mode
 *
 ******************************************************/

function disableDrawMode(){

	map.setOptions({
		draggable: true,
		draggableCursor : 'grab',
		zoomControl: true,
		scrollwheel: true,
		disableDoubleClickZoom: true
	});

	jQuery( '#map .gm-style > div > div > div > div > img' ).show();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(1) > div:nth-child(4)' ).show();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(3)' ).css('opacity','1');

	drawingMode = false;
}

/*****************************************************
 *
 * Disable Draw Mode
 *
 ******************************************************/

function enableDrawMode(){

	jQuery( '#map .gm-style > div > div > div > div > img' ).hide();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(1) > div:nth-child(4)' ).hide();
	jQuery( '#map > div > div > div:nth-child(1) > div:nth-child(3)' ).css('opacity','0');

	drawingMode = true;

	map.setOptions({
		draggable: false,
		//draggableCursor : "url(http://s3.amazonaws.com/besport.com_images/status-pin.png), auto",
		draggableCursor:'crosshair',
		zoomControl: false,
		scrollwheel: false,
		disableDoubleClickZoom: false,
		clickableIcons: false,
	});
}

/*****************************************************
 *
 * Get list of Markers inside the Draw Area
 *
 ******************************************************/
function getMarkersInsideDraw(e, polygon ) {
	drawMarkers = [];
	drawBounds = new google.maps.LatLngBounds();

	for ( var i=0; i < marker_list.length; i++ ) {
		if ( google.maps.geometry.poly.containsLocation(marker_list[i].position, polygon ) ) {
			if( marker_list[i].listingID != undefined ) {
				drawMarkers.push( Number(marker_list[i].listingID));
				drawBounds.extend(marker_list[i].position);
			}
		}
	}

}

function showMarkerWithPrice( property ){

	markerType        = mapping_ajax_object.listing_marker_type;
	enableMarkerPrice = mapping_ajax_object.ct_enable_marker_price;
	priceZoomLevel    = parseInt( mapping_ajax_object.search_marker_price_zoom_level );

	if ( property.mapZoom == undefined ) {
		property.mapZoom = map.getZoom();
	}

	if ( priceZoomLevel <= property.mapZoom && enableMarkerPrice == 'yes' && mapping_ajax_object.listing_marker_type == 'svg' ) {
		return true;
	}
}

/*****************************************************
 *
 * End Airbnb style map scrolling
 *
 ******************************************************/

var estateMapping = (function () {
	var self = {},
		current_marker = 0,
		x_center_offset = 0, // x,y offset in px when map gets built with marker bounds
		y_center_offset = 0;


	function build_marker(latlng, property, skipBounds=false) {

		var mapPin = getMapPin( property );
		//priceZoomLevel    = parseInt( mapping_ajax_object.search_marker_price_zoom_level );
		//enableMarkerPrice = mapping_ajax_object.ct_enable_marker_price;

		if ( property.mapZoom == undefined ) {
			property.mapZoom = map.getZoom();
		}

		priceLabel   = '';

		if ( mapping_ajax_object.listing_marker_type == 'svg' ) {
			mapAnimation = null;
		} else {
			mapAnimation = google.maps.Animation.DROP;
		}

		//if ( priceZoomLevel <= map.getZoom() && enableMarkerPrice == 'yes' && mapping_ajax_object.listing_marker_type == 'svg' ) {
		if ( showMarkerWithPrice( property ) ) {
			priceLabel = {
				text: property.markerPrice,
				color: '#222',
				fontSize: '11px',
				fontWeight: 'normal'
			};
		}

		var marker = new google.maps.Marker({
			map: self.map,
			animation: mapAnimation,
			draggable: false,
			flat: true,
			fullScreenControl: true,
			fullscreenControlOptions: {
				position: google.maps.ControlPosition.BOTTOM_LEFT
			},
			icon: mapPin,
			position: latlng,
			listingID: property.listingID,
			label:priceLabel,
			iconURL: mapPin.url,
			ctStatus: property.ctStatus,
			priceDisplay: property.priceDisplay,
		});

		/*
		.map-property-pin.jsx-453445860:not(.sm-pin) {
    background: #fff;
    color: #333333;
    padding: 3px 6px 3px;
    border: 1px solid #dcdcdc;
    white-space: nowrap;
    font-weight: 400;
    border-radius: 6px;
    font-size: 12px;
    text-transform: uppercase;
    -webkit-transform: translate(-50%,-100%);
    -webkit-transform: translate(-50%,-100%);
    -ms-transform: translate(-50%,-100%);
    transform: translate(-50%,-100%);
}
		*/

		var residentialString = '';
		if(property['commercial'] != 'commercial') {
			var residentialString=''+property.bed+' | '+property.bath+' | ';
		}

		var contentString = getInfoBoxContentString( property );

		var imagesURL = property.siteURL;

		if ( mapping_ajax_object.listing_marker_type == 'svg' ) {
			if ( priceZoomLevel <= map.getZoom() && enableMarkerPrice == 'yes' ) {
				pixOff = new google.maps.Size( -125, (mapping_ajax_object.ct_listing_marker_svg_size * -1) - 50 );
			} else {
				pixOff = new google.maps.Size( -125, (mapping_ajax_object.ct_listing_marker_svg_size * -1)-30 );
			}

		} else {
			pixOff = new google.maps.Size( -125, -64 );
		}

		var infobox = new InfoBox({
			content: contentString,
			disableAutoPan: true,
			maxWidth: 0,
			alignBottom: true,
			pixelOffset: pixOff,
			zIndex: null,
			closeBoxMargin: "8px 0 -20px -20px",
			closeBoxURL: imagesURL+'/images/infobox-close.png',
			infoBoxClearance: new google.maps.Size(1, 1),
			isHidden: false,
			pane: "floatPane",
			enableEventPropagation: false
		});

		marker.infobox = infobox;
		google.maps.event.addListener(marker, 'click', function() {

			if(open_info_window) open_info_window.close();

			infobox.open(self.map, marker);
			self.map.panTo(convert_offset(this.position, x_info_offset, y_info_offset));
			open_info_window = infobox;

		});

		marker_list.push( marker );

		if ( skipBounds == false ) {
			self.bounds.extend(latlng);
			self.map.fitBounds(self.bounds);
		}

		// REMOVE is the below call needed?
		//self.map.setCenter(convert_offset(self.bounds.getCenter(), x_center_offset, y_center_offset));



	}

	// Next/Previous Marker Navigation

	var ct_map_next = function() {
		current_marker++;
		if (current_marker > marker_list.length){
			current_marker = 1;
		}
		while(marker_list[current_marker-1].visible === false) {
			current_marker++;
			if(current_marker > marker_list.length) {
				current_marker = 1;
			}
		}
		google.maps.event.trigger(marker_list[current_marker-1], 'click');
	}

	var ct_map_prev = function() {
		current_marker--;
		if (current_marker < 1) {
			current_marker = marker_list.length;
		}
		while(marker_list[current_marker-1].visible === false) {
			current_marker--;
			if(current_marker > marker_list.length) {
				current_marker = 1;
			}
		}
		google.maps.event.trigger(marker_list[current_marker-1], 'click');
	}

	window.onload = function() {
		var ctGmapNext  = document.getElementById('ct-gmap-next');
		var ctGmapPrev  = document.getElementById('ct-gmap-prev');
		var ctGmapDraw  = document.getElementById('ct-gmap-draw');

		if(ctGmapDraw != null) {
			document.getElementById('ct-gmap-draw').addEventListener('click',function () {

				if ( poly != null ) {
					poly.setMap(null);
					poly = null;
					self.map.fitBounds(oldBounds);
					self.map.setZoom(oldZoom);
					google.maps.event.trigger(self.map, 'zoom_changed' );
					//getMapBounds(map);
					cancelDrawing();
					disableDrawMode();
					jQuery('.draw-mode').find('span').html( '' );
					jQuery('.draw-mode').removeClass( 'draw-mode' );
					drawMarkers = [];

					return false;

				} else {

					jQuery( '#ct-map-navigation, #compare-panel' ).hide();
					jQuery( '#map-wrap' ).append( '<div class="drawInstructionBar"><div class="instructions">Click and drag to draw your search.<a href="#" class="btn btn-sm cancelDrawButton" data-rf-test-id="cancelDrawButton">Cancel</a></div></div>' );
					jQuery(this).addClass( 'draw-mode' );
					jQuery(this).find('span').html( 'Clear' );
					enableDrawMode();
				}

				drawListener = google.maps.event.addDomListener(map.getDiv(),'mousedown',function(e){
					if ( drawingMode ) {
						drawFreeHand();
					} else {
						disableDrawMode();
					}
				});
				return false;
			});
		}

		if(ctGmapNext != null) {
			document.getElementById('ct-gmap-next').addEventListener('click',function () {
				ct_map_next();
			});
		}

		if(ctGmapPrev != null) {
			document.getElementById('ct-gmap-prev').addEventListener('click',function () {
				ct_map_prev();
			});
		}
	}

	function geocode_and_place_marker(property, skipBounds=false) {

		var geocoder = new google.maps.Geocoder();
		var address = property.street+', '+property.city+' '+property.state+', '+property.zip;


		//If latlong exists build the marker, otherwise geocode then build the marker
		if (property['latlong'] && property['latlong'].length>1) {

			var lat = parseFloat(property['latlong'].split(',')[0]),
				lng = parseFloat(property['latlong'].split(',')[1]);
			var latlng = new google.maps.LatLng(lat,lng);

			if ( markerExistsByLatLng( lat, lng ) == -1 ) {
				build_marker(latlng, property, skipBounds);
			}

		} else {

			geocoder.geocode({ address : address }, function( results, status ) {
				if(status == google.maps.GeocoderStatus.OK) {
					var latlng = results[0].geometry.location;

					if ( markerExistsByLatLng( latlng.lat(), latlng.lng() ) == -1 ) {
						build_marker(latlng, property,skipBounds);
					}
				}
			});
		}
	}

	self.init_property_map = function (properties, defaultmapcenter, siteURL) {

		var ctMapType = ctMapGlobal['mapType'];
		var ctMapStyle = ctMapGlobal['mapStyle'];
		var ctMapCustomStyles = ctMapGlobal['mapCustomStyles'];

		if(ctMapStyle == 'custom') {

			if ( defaultmapcenter != null && defaultmapcenter.mapcenter != '' ) {

				var options = {
					zoom: 10,
					center: new google.maps.LatLng(defaultmapcenter.mapcenter),
					mapTypeId: google.maps.MapTypeId[ctMapType],
					disableDefaultUI: false,
					scrollwheel: false,
					streetViewControl: false,
					styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
				};
			} else {

				var options = {
					mapTypeId: google.maps.MapTypeId[ctMapType],
					disableDefaultUI: false,
					scrollwheel: false,
					streetViewControl: false,
					styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
				};
			}

		} else {

			var options = {
				zoom: 10,
				center: new google.maps.LatLng(defaultmapcenter.mapcenter),
				mapTypeId: google.maps.MapTypeId[ctMapType],
				disableDefaultUI: false,
				scrollwheel: false,
				streetViewControl: true
			};
		}

		// get user's location
		lat = getUrlParameter( "lat", "" );
		lng = getUrlParameter( "lng", "" );
		skipBounds = false;

		if ( lat && lng ) {
			//console.log("In lat and lng portion");
			options.center = { lat: parseFloat( lat ), lng: parseFloat( lng ) };
			skipBounds = true;
		}

		/* Marker Clusters */
		var markerClustererOptions = {
			ignoreHidden: true,
			maxZoom: mapping_ajax_object.search_cluster_zoom_level,
			styles: [{
				textColor: '#ffffff',
				url: siteURL+'/images/cluster-icon.png',
				height: 48,
				width: 48
			}]
		};

		self.map = new google.maps.Map( document.getElementById( 'map' ), options );


		map = self.map;

		self.bounds = new google.maps.LatLngBounds();

		init_canvas_projection( self.map );

		//wait for idle to give time to grab the projection (for calculating offset)
		if ( defaultmapcenter != null ) {

			var idle_listener = google.maps.event.addListener(self.map, 'idle', function() {


				// check for no results...
				//console.log("properties.length: " + properties.length);
				//console.log("properties: ");
				//console.log(properties);

				if ( properties && properties.length ) {
					mapZoom = 1;
					for (i=0;i<properties.length;i++) {
						properties[i].mapZoom = mapZoom;
						properties[i].ctStatus = properties[i].ctStatus.trim();
						geocode_and_place_marker(properties[i], skipBounds);
					}

				} else { // no results

					var geocoder = new google.maps.Geocoder();
					var latlng;
					var zoomLevel = 14;

					address = getUrlParameter("ct_keyword", "");

					geocoder.geocode({ address : address }, function( results, status ) {
						if(status == google.maps.GeocoderStatus.OK) {
							latlng = results[0].geometry.location;

						} else {
							// keyword was not a recognised location
							// try the users lat lng otherwise default to usa

							if ( lat == "" ) {
								lat = storedLatitude;
								lng = storedLongitude;
							}

							if ( lat != "" && lng != "" ) {

								latlng = new google.maps.LatLng( lat, lng );
								zoomLevel = 8;
							} else {
								latlng = new google.maps.LatLng( 40.338354, -97.524664 );
								zoomLevel = 4;
							}

						}

						self.map.setCenter(latlng);
						self.map.setZoom(zoomLevel);
						//self.bounds.extend(latlng);
						//self.map.fitBounds(self.bounds);

					});


				}

				markerCluster = new MarkerClusterer(self.map, marker_list, markerClustererOptions);


				google.maps.event.removeListener(idle_listener);
				jQuery( "#number-listings-progress" ).css( "display", "none" );

				google.maps.event.addListener( self.map, 'dragend', debounce( ( ) => {
					skipBounds = false;
					//console.log("dragend");
					getMapBounds( self.map );

				}, debounceTime ) );


				google.maps.event.addListener( self.map, 'zoom_changed', debounce( ( ) => {
					skipBounds = false;
					//console.log("zoom_changed");
					getMapBounds( self.map );

				}, debounceTime ) );


			});

			google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
				//google.maps.event.trigger(map, 'resize');
			});
		}

		/*****************************************************
		 *
		 * Start Airbnb style map scrolling
		 *
		 ******************************************************/
		/*
                google.maps.event.addListener( self.map, 'dragend', debounce( ( ) => {
                    skipBounds = false;
                    //console.log("dragend");
                    getMapBounds( self.map );

                }, debounceTime ) );


                google.maps.event.addListener( self.map, 'zoom_changed', debounce( ( ) => {
                    skipBounds = false;
                    //console.log("zoom_changed");
                    getMapBounds( self.map );

                }, debounceTime ) );

        /*
                if ( skipBounds == true ) {
                    hitCount++;
                    google.maps.event.addListenerOnce( self.map, 'idle', debounce( ( ) => {

                        //console.log("idle");
                        getMapBounds( self.map );

                    }, debounceTime ) );
                }
        */
		/*****************************************************
		 *
		 * End Airbnb style map scrolling
		 *
		 ******************************************************/

	}

	return self;
}());
