<?php

global $ct_options;

echo '<style type="text/css">';
echo 'body {';
// Background color
echo 'background-color: '      . $ct_options['ct_background']['background-color'] . ';';
 
// Background image.
echo 'background-image: url('      . $ct_options['ct_background']['background-image'] . ');';
 
// Background image options
echo 'background-repeat: '     . $ct_options['ct_background']['background-repeat'] . ';';
echo 'background-position: '   . $ct_options['ct_background']['background-position'] . ';';
echo 'background-size: '       . $ct_options['ct_background']['background-size'] . ';';
echo 'background-attachment: ' . $ct_options['ct_background']['background-attachment'] . ';';
echo '}';

/*-----------------------------------------------------------------------------------*/
/* Top Bar */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_header_bar_color'])) {
	echo "#topbar-wrap { background: " . esc_html($ct_options['ct_header_bar_color']) . " !important; border-bottom-color: " . esc_html($ct_options['ct_header_bar_border_color']) . " !important;}";
}

if(!empty($ct_options['ct_header_bar_text_color'])) {
	echo "#topbar-wrap .container { color: " . esc_html($ct_options['ct_header_bar_text_color']) . " !important;}";
}

if(!empty($ct_options['ct_header_bar_border_color'])) {
	echo "#topbar-wrap .container { border-bottom-color: " . esc_html($ct_options['ct_header_bar_border_color']) . ";}";
	echo "#topbar-wrap .social li:first-child a { border-left-color: " . esc_html($ct_options['ct_header_bar_border_color']) . ";}";
	echo "#topbar-wrap .social a { border-right-color: " . esc_html($ct_options['ct_header_bar_border_color']) . ";}";
}

if(!empty($ct_options['ct_header_bar_user_bg_color'])) {
	echo "#topbar-wrap li.user-logged-in a, #topbar-wrap ul.user-drop { background: " . esc_html($ct_options['ct_header_bar_user_bg_color']) . ";}";
}

if(!empty($ct_options['ct_header_bar_user_link_color'])) {
	echo "#topbar-wrap li.user-logged-in a { color: " . esc_html($ct_options['ct_header_bar_user_link_color']) . ";}";
}

if(!empty($ct_options['ct_header_bar_user_btm_border_color'])) {
	echo "#topbar-wrap li.user-logged-in a, #topbar-wrap ul.user-drop li { border-bottom-color: " . esc_html($ct_options['ct_header_bar_user_btm_border_color']) . ";}";
}

if(!empty($ct_options['ct_header_bar_font_color'])) {
	echo "#topbar-wrap, #topbar-wrap a, #topbar-wrap a:visited { color: " . esc_html($ct_options['ct_header_bar_font_color']) . ";}";
}

/*-----------------------------------------------------------------------------------*/
/* Header */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_secondary_bg_color'])) {
	echo ".advanced-search h4, span.search-params, .featured-listings header.masthead, .listing .listing-imgs-attached, .advanced-search h3, .flex-caption p, a.btn, btn, #reply-title small a, .featured-listings a.view-all, .comment-reply-link, .grid figcaption a, input.btn, .flex-direction-nav a, .partners h5 span, .schedule-calendar .schedule-date .schedule-daytext, li.listing.modern .search-view-listing.btn { background: " . esc_html($ct_options['ct_secondary_bg_color']) . ";}";
	echo "a.view-all { border-color: " . esc_html($ct_options['ct_secondary_bg_color']) . ";}";
}

if(!empty($ct_options['ct_header_nav_font_color'])) {
	echo ".ct-menu > li > a, .user-frontend li.login-register a { color: " . esc_html($ct_options['ct_header_nav_font_color']) . ";}";
}

if(!empty($ct_options['ct_header_nav_current_bg'])) {
	echo ".ct-menu li.current-menu-item a, .ct-menu li.current_page_parent a { border-top-color: " . esc_html($ct_options['ct_header_nav_current_bg']) . " !important;}";
}

if(!empty($ct_options['ct_mobile_btn_icon_color'])) {
	echo ".show-hide { color: " . esc_html($ct_options['ct_mobile_btn_icon_color']) . " !important;}";
}

if(!empty($ct_options['ct_mobile_menu_bg_color'])) {
	echo ".cbp-spmenu { background-color: " . esc_html($ct_options['ct_mobile_menu_bg_color']) . " !important;}";
	echo ".cbp-spmenu a { background-color: " . esc_html($ct_options['ct_mobile_menu_bg_color']) . " !important;}";
}

if(!empty($ct_options['ct_mobile_menu_link_hover_bg_color'])) {
	echo ".cbp-spmenu a:hover { background: " . esc_html($ct_options['ct_mobile_menu_link_hover_bg_color']) . " !important;}";
}

if(!empty($ct_options['ct_header_nav_btn_outline'])) {
	echo "a.btn-outline, .header-style-three .user-frontend.not-logged-in li a.btn-outline { color: " . esc_html($ct_options['ct_header_nav_btn_outline']) . " !important;}";
	echo "a.btn-outline, .header-style-three .user-frontend.not-logged-in li a.btn-outline { border-color: " . esc_html($ct_options['ct_header_nav_btn_outline']) . " !important;}";
}

/*-----------------------------------------------------------------------------------*/
/* Secondary Background */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_secondary_bg_color'])) {
	echo '#modal .close, .advanced-search h4, .featured-listings header.masthead, .listing .listing-imgs-attached, .advanced-search h3, .flex-caption p, a.btn, .btn, .lrg-icon, .listing-info .price, #reply-title small a, .featured-listings a.view-all,	.comment-reply-link, .grid figcaption a, input.btn, input[type="submit"], input[type="reset"], input[type="button"], input[type="btn"],	button,	.flex-direction-nav a, .user-listing-count,	#compare-panel-btn,	span.map-toggle,	span.search-toggle,	.infobox .price, .pagination span.current, #progress-bar li.active:before, #progress-bar li.active:after, #progress-bar li.active:before, #progress-bar li.active:after, .pagination .current a, .package-posts .popular-heading, .partners h5 span, #topbar-wrap li.login-register a, .user-listing-count, .aq-block-aq_widgets_block .widget h5, .home .advanced-search.idx form, #page .featured-map #map, .cta, .searching-on.search-style-two, .search-style-two .search-params, .listing-submit, .placeholder, ul.user-nav li a, .no-registration, thead, .single-listings #listing-sections, .ajaxSubmit, .grid-listing-info .price, .list-listing-info .price, .single-listings article .price, .saved-listings .fav-listing .price { background-color: ' . esc_html($ct_options['ct_secondary_bg_color']) . ';}';
	echo ".packages-container .price, .single-listings #listings-three-header h4.price, .single-listings .fa-check-square, li.listing.modern .price { color: " . esc_html($ct_options['ct_secondary_bg_color']) . ";}";
}

if(!empty($ct_options['ct_secondary_bg_color'])) {
	echo "#progress-bar li.active { border-top-color: " . esc_html($ct_options['ct_secondary_bg_color']) . " !important;}";
}

if(!empty($ct_options['ct_secondary_bg_color'])) {
	echo ".ui-widget-header { background-color: " . esc_html($ct_options['ct_secondary_bg_color']) . " !important;}";
}

/*-----------------------------------------------------------------------------------*/
/* Search Results Map Toggle */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_map_toggle'])) {
	echo "span.map-toggle a, span.search-toggle a, .listing-tools li a.btn { background-color: " . esc_html($ct_options['ct_map_toggle']) . " !important;}";
}

/*-----------------------------------------------------------------------------------*/
/* Home Featured Listings View All */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_featured_view_all'])) {
	echo ".featured-listings a.view-all { background-color: " . esc_html($ct_options['ct_featured_view_all']) . " !important;}";
}

/*-----------------------------------------------------------------------------------*/
/* Listing */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_listing_font_color'])) {
	echo "li.listing, .propinfo .muted, article.listing, .page-template-template-submit-listing article, .page-template-template-edit-listing-php article { color: " . esc_html($ct_options['ct_listing_font_color']) . ";}";
}

if(!empty($ct_options['ct_listing_border_bottom_color'])) {
	echo ".propinfo li.row, .agent-info li.row { border-bottom-color: " . esc_html($ct_options['ct_listing_border_bottom_color']) . ";}";
}

if(!empty($ct_options['ct_listing_background_color'])) {
	echo "li.listing, article.listing, .page-template-template-submit-listing article, .page-template-template-edit-listing-php article { background-color: " . esc_html($ct_options['ct_listing_background_color']) . ";}";
}

/*-----------------------------------------------------------------------------------*/
/* Listing Single */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_listing_heading_font_color'])) {
	echo ".single-listings header.listing-location h2 { color: " . esc_html($ct_options['ct_listing_heading_font_color']) . ";}";
}

if(!empty($ct_options['ct_listing_more_info_font_color'])) {
	echo ".main-agent h5, .main-agent a, .main-agent i { color: " . esc_html($ct_options['ct_listing_more_info_font_color']) . ";}";
}

/*-----------------------------------------------------------------------------------*/
/* Price */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_price_bg'])) {
	echo ".flex-caption p.price, .grid-listing-info .price, .list-listing-info .price, .single-listings article .price, .infobox .price { background: " . esc_html($ct_options['ct_price_bg']) . ";}";
}

/*-----------------------------------------------------------------------------------*/
/* Widgets */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_widget_header_bg_color'])) {
	echo ".widget h5, .aq-block-aq_widgets_block .widget h2, .aq-block-aq_widgets_block .widget h5 { background-color: " . esc_html($ct_options['ct_widget_header_bg_color']) . " !important;}";
}

/*-----------------------------------------------------------------------------------*/
/* Links */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_link_color'])) {
	echo " a, .more, .pagination .current, .flex-direction-nav a i {color: " . esc_html($ct_options['ct_link_color']) . ";}";
}

if(!empty($ct_options['ct_visited_color'])) {
	echo " a:visited {color: " . esc_html($ct_options['ct_visited_color']) . ";}";
}

if(!empty($ct_options['ct_hover_color'])) {
	echo " a:hover, .more:hover, .pagination a:hover {color: " . esc_html($ct_options['ct_hover_color']) . ";}";
}

if(!empty($ct_options['ct_active_color'])) {
	echo " a:active, .more:active, .pagination a:active {color: " . esc_html($ct_options['ct_active_color']) . ";}";
}

/*-----------------------------------------------------------------------------------*/
/* Footer */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_footer_widget_background'])) {
	echo " #footer-widgets {background: " . esc_html($ct_options['ct_footer_widget_background']) . " !important;}";
}

if(!empty($ct_options['ct_footer_widget_heading_color'])) {
	echo " #footer-widgetsh5  { color: " . esc_html($ct_options['ct_footer_widget_heading_color']) . " !important}";
}

if(!empty($ct_options['ct_footer_widget_font_color'])) {
	echo " #footer-widgets .widget, #footer-widgets .widget a, #footer-widgets .widget a:visited, #footer-widgets .widget li  { color: " . esc_html($ct_options['ct_footer_widget_font_color']) . " !important; border-bottom-color: " . esc_html($ct_options['ct_footer_widget_font_color']) . " !important;}";
	echo "#footer-widgets .contact-social li a, #footer-widgets .widget_ct_mortgagecalculator p.muted { border-color: " . esc_html($ct_options['ct_footer_widget_font_color']) . " !important;}";
}

if(!empty($ct_options['ct_footer_link_color'])) {
	echo "footer, footer nav ul li a, footer nav ul li a:visited, footer a, footer a:visited { color: " . esc_html($ct_options['ct_footer_link_color']) . " !important;}";
}

if(!empty($ct_options['ct_footer_background'])) {
	echo " footer {background: " . esc_html($ct_options['ct_footer_background']) . " !important;}";
}

/*-----------------------------------------------------------------------------------*/
/* Custom CSS */
/*-----------------------------------------------------------------------------------*/

if(!empty($ct_options['ct_custom_css'])) {
	echo $ct_options['ct_custom_css']; 
} ?>

</style>