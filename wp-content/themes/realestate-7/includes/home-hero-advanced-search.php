<?php
/**
 * Header Advanced Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

?>

<!-- Header Search -->
<div id="hero-search-wrap">
	<div class="container">
        <form id="advanced_search" class="col span_12 first header-search" name="search-listings" action="<?php echo home_url(); ?>">
	        <div id="hero-search-inner">
	            <div id="suggested-search" class="col span_6">
	            	<div id="keyword-wrap">					
	            		<i class="fa fa-search"></i>
		                <label for="ct_keyword"><?php _e('Keyword', 'contempo'); ?></label>
		                <input type="text" id="ct_keyword" class="number hero_keyword_search" name="ct_keyword" size="8" placeholder="<?php esc_html_e('Street, City, State, Zip or keyword', 'contempo'); ?>" />
	                </div>
					<div class="listing-search" style="display: none"><i class="fa fa-spinner fa-spin fa-fw"></i><?php _e('Searching...', 'contempo'); ?></div>
					<div id="hero-suggestion-box" style="display: none;"></div>
	            </div>

	            <div id="city_code" class="col span_2">
					<?php ct_search_form_select('city'); ?>
				</div>

				<div id="state_code" class="col span_2">
					<?php ct_search_form_select('state'); ?>
	            </div>

	            <input type="hidden" name="search-listings" value="true" />

	            <div class="col span_2">
		            <input id="submit" class="btn left" type="submit" value="<?php esc_html_e('Search', 'contempo'); ?>" />
	            </div>

		            <div class="clear"></div>
            </div>
        </form>
	        <div class="clear"></div>
    </div>
</div>
<!-- //Header Search -->

<script>
jQuery(".hero_keyword_search").keyup(function($){
	var keyword_value = jQuery(this).val();
	
	var data = {
		action: 'street_keyword_search',
		keyword_value: keyword_value
	};

	jQuery(".listing-search").show();

	jQuery.ajax({
		type: "POST",
		url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",		
		data: data,	
		success: function(data){
			console.log(data);
			jQuery(".listing-search").hide();
			jQuery("#hero-suggestion-box").show();
			jQuery("#hero-suggestion-box").html(data);
		}
	}); 
});

jQuery(document).on("click",'.listing_media',function(){	
	var list_title = jQuery(this).attr('att_id');
	jQuery(".hero_keyword_search").val(list_title);
	jQuery("#hero-suggestion-box").hide();	
});
</script>