<?php
/*
 * Plugin Name: Contempo Mortgage Calculator Widget
 * Plugin URI: http://contemporealestatethemes.com
 * Description: A simple mortgage calculator widget with sale price, interest rate, term & down payment.
 * Version: 3.1.1
 * Author: Contempo
 * Author URI: http://contemporealestatethemes.com
 * Text Domain: ct-mortgage-calculator
 * Domain Path: /languages
*/

add_action( 'plugins_loaded', 'ct_mort_plugin_load_textdomain' );

function ct_mort_plugin_load_textdomain() {
  load_plugin_textdomain( 'ct-mortgage-calculator', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}

function ct_remove_repo_connection( $r, $url ) {
    if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
        return $r; // Not a plugin update request. Bail immediately.
  
    $plugins = unserialize( $r['body']['plugins'] );
    unset( $plugins->plugins[ plugin_basename( __FILE__ ) ] );
    unset( $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ] );
    $r['body']['plugins'] = serialize( $plugins );
    return $r;
}
 
add_filter( 'http_request_args', 'ct_remove_repo_connection', 5, 2 );

/*-----------------------------------------------------------------------------------*/
/* Add meta links in Plugins table */
/*-----------------------------------------------------------------------------------*/
 
add_filter( 'plugin_row_meta', 'ct_mort_plugin_meta_links', 10, 2 );
function ct_mort_plugin_meta_links( $links, $file ) {

	$plugin = plugin_basename(__FILE__);
	
	// Create Link
	if ( $file == $plugin ) {
		return array_merge(
			$links,
			array( '<a href="http://twitter.com/contempoinc">Follow on Twitter</a>' )
		);
	}
	return $links;
}

/*-----------------------------------------------------------------------------------*/
/* Include CSS */
/*-----------------------------------------------------------------------------------*/
 
function ct_mortgage_calc_css() {		
	wp_enqueue_style( 'ct_mortgage_calc', plugins_url( 'assets/style.css', __FILE__ ), false, '1.0' );
}
add_action( 'wp_print_styles', 'ct_mortgage_calc_css' );

/*-----------------------------------------------------------------------------------*/
/* Include JS */
/*-----------------------------------------------------------------------------------*/

function ct_mortgage_calc_scripts() {
	wp_enqueue_script( 'calc', plugins_url( 'assets/calc.js', __FILE__ ), array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'ct_mortgage_calc_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Register Widget */
/*-----------------------------------------------------------------------------------*/

class ct_MortgageCalculator extends WP_Widget {

	function __construct() {
	   $widget_ops = array('description' => 'Display a mortgage calculator.' );
	   parent::__construct(false, __('CT Mortgage Calculator', 'ct-mortgage-calculator'),$widget_ops);      
	}

	function widget($args, $instance) {  
		
		extract( $args );
		
		$title = $instance['title'];
		$currency = $instance['currency'];
		
	?>
		<?php echo $before_widget; ?>
		<?php if ($title) { echo $before_title . $title . $after_title; }
			global $post,$ct_options;

			$price_meta = get_post_meta(get_the_ID(), '_ct_price', true);
			$text_or_icons = isset( $instance['text_or_icons'] ) ? esc_attr( $instance['text_or_icons'] ) : 'icon';

			?>

			<?php echo '<div class="widget-inner">'; ?>

				<style>
					.mcInputWrap { position: relative;}
					.mc-icon { position: absolute; font-size: 12px; z-index: 1; top: 9px; left: 9px; padding-left: 1px; background: #efefef; border-radius: 3px; height: 24px; width: 24px; line-height: 24px; text-align: center; border: 1px solid #d5d9dd;}
						.mc-icon.ct-mort-calc-label-type-text { width: 60px;}
					.mcInputWrap input { padding-left: 46px;}
						.mcInputWrap input.ct-mort-calc-label-type-text { padding-left: 80px;}
				</style>

	            <form id="loanCalc">
	                <fieldset>
	                		<div class="mcInputWrap">
								<span class="mc-icon <?php echo 'ct-mort-calc-label-type-' . $text_or_icons; ?>">
									<?php if($text_or_icons == 'text') { ?>
										<?php _e('Price', 'ct-mortgage-calculator'); ?>
									<?php } else { ?>
										<?php if(!empty($currency)) { echo $currency; } else { ct_currency(); } ?>
									<?php } ?>
								</span>
								<?php if(has_term('for-rent', 'ct_status') || has_term('rental', 'ct_status') || has_term('leased', 'ct_status') || has_term('lease', 'ct_status') || has_term('let', 'ct_status') || has_term('sold', 'ct_status')) { ?>
									<input type="text" name="mcPrice" id="mcPrice" class="text-input <?php echo 'ct-mort-calc-label-type-' . $text_or_icons; ?>" placeholder="<?php _e('Sale price (no separators)', 'ct-mortgage-calculator'); ?>" />
								<?php } else { ?>
									<input type="text" name="mcPrice" id="mcPrice" class="text-input <?php echo 'ct-mort-calc-label-type-' . $text_or_icons; ?>" placeholder="<?php _e('Sale price (no separators)', 'ct-mortgage-calculator'); ?>" <?php if(!empty($price_meta)) { echo 'value="' . $price_meta . '"'; } ?> />
								<?php } ?>
							</div>
							<div class="mcInputWrap">
								<span class="mc-icon <?php echo 'ct-mort-calc-label-type-' . $text_or_icons; ?>">
									<?php if($text_or_icons == 'text') { ?>
										<?php _e('Rate', 'ct-mortgage-calculator'); ?>
									<?php } else { ?>
										<?php echo '%'; ?>
									<?php } ?>
								</span>
								<input type="text" name="mcRate" id="mcRate" class="text-input <?php echo 'ct-mort-calc-label-type-' . $text_or_icons; ?>" placeholder="<?php _e('Interest Rate', 'ct-mortgage-calculator'); ?>" />
							</div>
							<div class="col span_12 first">
								<select name="mcTerm" id="mcTerm">
									<option value="15"><?php _e('15 Years', 'ct-mortgage-calculator'); ?></option>
									<option value="25"><?php _e('25 Years', 'ct-mortgage-calculator'); ?></option>
									<option value="30"><?php _e('30 Years', 'ct-mortgage-calculator'); ?></option>
								</select>
							</div>
							<div class="clear"></div>
							<div class="mcInputWrap">
								<span class="mc-icon <?php echo 'ct-mort-calc-label-type-' . $text_or_icons; ?>">
									<?php if($text_or_icons == 'text') { ?>
										<?php _e('Down', 'ct-mortgage-calculator'); ?>
									<?php } else { ?>
										<?php if(!empty($currency)) { echo $currency; } else { ct_currency(); } ?>
									<?php } ?>
								</span>
								<input type="text" name="mcDown" id="mcDown" class="text-input <?php echo 'ct-mort-calc-label-type-' . $text_or_icons; ?>" placeholder="<?php _e('Down payment (no separators)', 'ct-mortgage-calculator'); ?>" />
							</div>

						<input class="btn marB10" type="submit" id="mortgageCalc" value="<?php _e('Calculate', 'ct-mortgage-calculator'); ?>" onclick="return false">
						<p class="muted monthly-payment"><?php _e('Monthly Payment:', 'ct-mortgage-calculator'); ?> <strong><?php echo $currency; ?><span id="mcPayment"></span></strong></p>
	                </fieldset>
	            </form>

            <?php echo '</div>'; ?>
		
		<?php echo $after_widget; ?>   
    <?php
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {
   
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$currency = isset( $instance['currency'] ) ? esc_attr( $instance['currency'] ) : '';
			$text_or_icons = isset( $instance['text_or_icons'] ) ? esc_attr( $instance['text_or_icons'] ) : 'icon';

		?>
		<p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','ct-mortgage-calculator'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('currency'); ?>"><?php _e('Currency:','ct-mortgage-calculator'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('currency'); ?>"  value="<?php echo $currency; ?>" class="widefat" id="<?php echo $this->get_field_id('currency'); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('text_or_icons')); ?>"><?php esc_html_e('Field Label Type','contempo'); ?></label>
	        <select name="<?php echo esc_attr($this->get_field_name('text_or_icons')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('text_or_icons')); ?>">
            	<option value="text" <?php if($text_or_icons == 'text'){ echo "selected='selected'";} ?>><?php echo _e('Text', 'ct-mortgage-calculator') ?></option>
            	<option value="icon" <?php if($text_or_icons == 'icon'){ echo "selected='selected'";} ?>><?php echo _e('Icon', 'ct-mortgage-calculator') ?></option>
	        </select>
	    </p>
		<?php
	}
} 

function ct_register_mortgage_calc_widget() {
	register_widget("ct_MortgageCalculator");
}

add_action( 'widgets_init', 'ct_register_mortgage_calc_widget' );

/*-----------------------------------------------------------------------------------*/
/* Register Shortcode */
/*-----------------------------------------------------------------------------------*/

function ct_mortgage_calc_shortcode($atts) { ?>
        <div class="clear"></div>
	<form id="loanCalc">
		<fieldset>
		  <input type="text" name="mcPrice" id="mcPrice" class="text-input" value="<?php _e('Sale price (<?php echo $currency; ?>)', 'ct-mortgage-calculator'); ?>" onfocus="if(this.value=='<?php _e('Sale price (<?php echo $currency; ?>)', 'ct-mortgage-calculator'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php _e('Sale price ($)', 'ct-mortgage-calculator'); ?>';" />
		  <input type="text" name="mcRate" id="mcRate" class="text-input" value="<?php _e('Interest Rate (%)', 'ct-mortgage-calculator'); ?>" onfocus="if(this.value=='<?php _e('Interest Rate (%)', 'ct-mortgage-calculator'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php _e('Interest Rate (%)', 'ct-mortgage-calculator'); ?>';" />
		  <input type="text" name="mcTerm" id="mcTerm" class="text-input" value="<?php _e('Term (years)', 'ct-mortgage-calculator'); ?>" onfocus="if(this.value=='<?php _e('Term (years)', 'ct-mortgage-calculator'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php _e('Term (years)', 'ct-mortgage-calculator'); ?>';" />
		  <input type="text" name="mcDown" id="mcDown" class="text-input" value="<?php _e('Down payment (<?php echo $currency; ?>)', 'ct-mortgage-calculator'); ?>" onfocus="if(this.value=='<?php _e('Down payment (<?php echo $currency; ?>)', 'ct-mortgage-calculator'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php _e('Down payment (<?php echo $currency; ?>)', 'ct-mortgage-calculator'); ?>';" />
		  
		  <input class="btn marB10" type="submit" id="mortgageCalc" value="<?php _e('Calculate', 'ct-mortgage-calculator'); ?>" onclick="return false">
		  <input class="btn reset" type="button" value="Reset" onClick="this.form.reset()" />
		  <input type="text" name="mcPayment" id="mcPayment" class="text-input" value="<?php _e('Your Monthly Payment', 'ct-mortgage-calculator'); ?>" />
		</fieldset>
	</form>
        <div class="clear"></div>
<?php }
add_shortcode('mortgage_calc', 'ct_mortgage_calc_shortcode');

?>