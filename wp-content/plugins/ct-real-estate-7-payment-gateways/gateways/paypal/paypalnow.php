<?php
class PayPal_Listings {
	
	public function __construct(){
		$ct_options = get_option('ct_options');

		
	}

	public static function ct_paypal() {
		global $ct_options, $post;
		$post_id = $post->ID;
		ob_start();
		$ct_currency_code = isset( $ct_options['ct_currency_code'] ) ? esc_attr( $ct_options['ct_currency_code'] ) : 'USD';
        $ct_submission_currency = isset( $ct_options['ct_submission_currency'] ) ? esc_attr( $ct_options['ct_submission_currency'] ) : '$';

        if('sandbox' == $ct_options['ct_paypal_mode']){
            $ct_paypal_mode = 'sandbox';
        } else {
            $ct_paypal_mode = 'production';
        }

		$name = 'Listing ID-' . $post_id;
	
		?>
        <input type='submit' class='btn' name='submit' value='Pay with PayPal' alt='PayPal - The safer, easier way to pay online'>
			<div class='payment-drop'>
			<?php $uri = plugins_url('PayPal/process.php?paypal=checkout', __FILE__);?>
                <?php $form_id = "paypalnow-$post_id" ?>
				<form action="<?php echo $uri; ?>" METHOD='POST' class='paypalbutton marB0 left paypal-button-form' id='<?php echo $form_id; ?>' data-paypal-env="<?php echo $ct_paypal_mode; ?>">
					<div class='submission-fee'>
						<?php echo _e('Cost:', 'contempo'); ?>
						<span class='cost right'>
                            <?php echo $ct_submission_currency; ?>
                            <?php echo $ct_options['ct_price']; ?>
                        </span>
					</div>
					<div class='featured-fee'>
						<input type='checkbox' name='featured' id='featured-<?php echo $post_id; ?>'/>
						<?php echo _e('Featured?', 'contempo'); ?>
						<span class='cost right'>
                            <?php echo $ct_submission_currency; ?>
                            <?php echo $ct_options['ct_price_featured']; ?>
                        </span>
					</div>
					<div class='total'>
						<input type='hidden' name='itemprice' value='<?php echo $ct_options['ct_price']; ?>' id='itemprice'/>
						<?php echo _e('Total:', 'contempo'); ?>
						<span class='cost right total'>
                            <?php echo $ct_submission_currency; ?>
                            <?php echo $ct_options['ct_price']; ?>
                        </span>
					</div>
					<input type='hidden' name='business' value='<?php echo esc_attr($ct_options['ct_paypal_addy']); ?>' />
					<input type='hidden' value='<?php echo $name; ?>' name='itemname' />
					<input type='hidden' value='<?php echo $name; ?>' name='itemdesc' />
					<input type='hidden' value='<?php echo $post_id; ?>' name="itemnumber" />
					<input type='hidden' value='1' name='itemQty' />
					<input type='hidden' value='<?php echo $ct_currency_code; ?>' name='currency_code' />
					<input type='hidden' value='checkout' name='pp-action' />
					<?php wp_nonce_field( 'ct_pp_html', 'ct_pp_nonce' ); ?>
                    <div class="my-listing-paypal-button">Loading...</div>
				</form>
				<script>
				jQuery(document).ready(function () {
					jQuery('#featured-<?php echo $post_id; ?>').change(function() {
						jQuery("#itemprice").val((jQuery(this).is(':checked')) ? "<?php echo $ct_options['ct_price'] + $ct_options['ct_price_featured']; ?>" : "<?php echo $ct_options['ct_price'];?>");
						jQuery('.cost.total').text((jQuery(this).is(':checked')) ? "<?php echo $ct_submission_currency.' '; echo $ct_options['ct_price'] + $ct_options['ct_price_featured']; ?>" : "<?php echo $ct_submission_currency.' '; echo $ct_options['ct_price'];?>");
					});
				});
                </script>
			</div>
		<?php 
        return ob_get_clean();
        // src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' border='0' align='top'
    }

 	public static function get_the_posts(){
		$userID = get_current_user_id();
		$args = array(
                	'post_type' => 'listings',
                	'author' => $userID,
                	'posts_per_page' => -1,
                	'post_status' => array('pending')
				);
		$all_posts = get_posts($args);
		foreach ($all_posts as $postID => $the_post ){
			$all_post_ids[] = "'paypalnow-" . $the_post->ID . "'";
		}
		$allPostIDs = '['. implode(', ',$all_post_ids) . ']';
		return $allPostIDs;
		
	}

	
}
$PayPal_Listings = new PayPal_Listings();