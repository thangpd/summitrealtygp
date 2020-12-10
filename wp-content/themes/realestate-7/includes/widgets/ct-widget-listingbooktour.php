<?php
/**
 * Listing Book Tour
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_ListingBookShowing')) {
	class ct_ListingBookShowing extends WP_Widget {

		function __construct() {
			$widget_ops = array('description' => 'Display a week calendar with time from/to for users to book a tour/showing of a listing.' );
			parent::__construct(false, __('CT Listing Book Showing', 'contempo'),$widget_ops);      
		}

		function widget($args, $instance) {  
			extract( $args );
		?>
			<?php echo $before_widget; ?>

				<script type="text/javascript">

					(function ($){
						"use strict";	
						var rep_month = new Array();
						var weekend= '', vacancy = '';
						var reinitOwl=true;
						var awaty_month = ("0" + (new Date().getMonth()+1)).slice(-2);
						var awaty_day = ("0" + new Date().getDate()).slice(-2);
						var awaty_year =  new Date().getFullYear();

						var number_of_days = 100;
						
						// Ready function to create slider uppond to options that user entered
						$.fn.calendar = function( options ) {		
						
						var defaults = $.extend({ 
							// These are the defaults.
							startDate: 'today',
							endDate: "",
							minDaysPerSlide: 5,
							weekend:"",	
						}, options );
						
						// start date value
						var startDate= defaults.startDate == 'today' ? awaty_month +'/'+ awaty_day +'/'+ awaty_year : defaults.startDate ;
						
						// end date value
						var endDate= defaults.endDate == '' ? ("0" + parseInt(new Date(new Date(startDate).getTime() + (number_of_days * 24 * 60 * 60 * 1000)).getMonth()+1, 10)).slice(-2) +'/'+ ("0" + new Date(new Date(startDate).getTime() + (number_of_days * 24 * 60 * 60 * 1000)).getDate()).slice(-2) +'/'+ new Date(new Date(startDate).getTime() + (number_of_days * 24 * 60 * 60 * 1000)).getFullYear() : defaults.endDate;

						// difference between end date and start date
						var diffDays=new Date( new Date(endDate) - new Date(startDate) );
						diffDays++;
						diffDays=diffDays/1000/60/60/24;
				        //console.log(diffDays);
						
						// minimum days per slider to show on screen
						var minDaysPerSlide= defaults.minDaysPerSlide;		
						
						// weekend days
						defaults.weekend != '' ? weekend = defaults.weekend.toLowerCase().split(',') : weekend=[];		
						
						// display index of weekend days
						var wkend=[];
						for(var x=0; x<weekend.length; x++){
							wkend[x]= ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"].indexOf(weekend[x]);
						}
						
						// execute this code just for the first time
						if(reinitOwl == true){
							
							// owl determination
							var o1 = $(".calendar-slider.owl-carousel");
				            
							o1.owlCarousel({
								animateOut: 'fadeOut',
								nav: false,
								startPosition: 1,
								autoplay: false,
								center: true,
								loop: false,
								nav: false,
								dots: false,
								dots:false,
								responsive:{
									0:{
										items:3,
									},
									530:{
										items:3,
									},
									768:{
										items:2,
									},
									1025:{
										items: 3,
									}
								}
							});
							jQuery('#scheduleNext').click(function() {
							    o1.trigger('next.owl.carousel');

							    var itemDate = jQuery('.owl-item.active.center').first().children('.schedule-date').data('date');
								jQuery('#selectedDate').val(itemDate);
							});
							jQuery('#schedulePrev').click(function() {
							    o1.trigger('prev.owl.carousel');

							    var itemDate = jQuery('.owl-item.active.center').first().children('.schedule-date').data('date');
								jQuery('#selectedDate').val(itemDate);
							});
						}		
						
						// loop to append items to array
						var day=0;
						var tw_flag=false;
						for(var x=1; x<=Math.ceil(diffDays/minDaysPerSlide) ; x++){
							for(var x2=1; x2<=minDaysPerSlide; x2++){
								if(day <= diffDays){					
									var num_of_days = 1000 * 60 * 60 * 24 * day;
				            		num_of_days = new Date(new Date(startDate).getTime() + num_of_days);					

									$('.calendar-slider.owl-carousel').owlCarousel().trigger('add.owl.carousel',[jQuery('<a href="#!" class="schedule-date" data-date="'+["<?php _e('Sunday', 'contempo'); ?>","<?php _e('Monday', 'contempo'); ?>","<?php _e('Tuesday', 'contempo'); ?>","<?php _e('Wednesday', 'contempo'); ?>","<?php _e('Thursday', 'contempo'); ?>","<?php _e('Friday', 'contempo'); ?>","<?php _e('Saturday', 'contempo'); ?>"][(num_of_days).getDay()]+', '+("0" + (num_of_days.getMonth()+1)).slice(-2)+'/'+("0" + num_of_days.getDate()).slice(-2)+'/'+num_of_days.getFullYear()+'"><div class="schedule-daytext">'+["<?php _e('SUN', 'contempo'); ?>","<?php _e('MON', 'contempo'); ?>","<?php _e('TUES', 'contempo'); ?>","<?php _e('WED', 'contempo'); ?>","<?php _e('THUR', 'contempo'); ?>","<?php _e('FRI', 'contempo'); ?>","<?php _e('SAT', 'contempo'); ?>"][(num_of_days).getDay()]+'</div><div class="schedule-day">'+("0" + num_of_days.getDate()).slice(-2)+'</div><div class="schedule-month">'+["<?php _e('JAN', 'contempo'); ?>","<?php _e('FEB', 'contempo'); ?>","<?php _e('MAR', 'contempo'); ?>","<?php _e('APR', 'contempo'); ?>","<?php _e('MAY', 'contempo'); ?>","<?php _e('JUNE', 'contempo'); ?>","<?php _e('JULY', 'contempo'); ?>","<?php _e('AUG', 'contempo'); ?>","<?php _e('SEPT', 'contempo'); ?>","<?php _e('OCT', 'contempo'); ?>","<?php _e('NOV', 'contempo'); ?>","<?php _e('DEC', 'contempo'); ?>"][(num_of_days).getMonth()]+'</div></a>')]).trigger('refresh.owl.carousel');
					
								}
								day++;
							}
						}

						$(".calendar-slider.owl-carousel").fadeIn(100);
						reinitOwl = false;
					}
					
					})(jQuery);

					jQuery(function(){
						// calling function
						jQuery( ".calendar-slider" ).calendar({
							minDaysPerSlide: 1,
							weekend:"Sunday"
						});	
					});

					jQuery(window).load(function() {
						// Set Date On Load
						var selectedDate = jQuery('.owl-item.active.center .schedule-date').data('date');
						jQuery('#selectedDate').val(selectedDate);
					});

					jQuery(document).ready(function() {
						jQuery("#book-showing").validationEngine({
							ajaxSubmit: true,
							<?php
							global $ct_options;
							$ct_enable_zapier_webhooks = isset( $ct_options['ct_enable_zapier_webhooks'] ) ? $ct_options['ct_enable_zapier_webhooks'] : '';
							$ct_zapier_webhook_url = isset( $ct_options['ct_zapier_webhook_url'] ) ? $ct_options['ct_zapier_webhook_url'] : '';
							$ct_zapier_webhook_listing_single_book_showing_form = isset( $ct_options['ct_zapier_webhook_listing_single_book_showing_form'] ) ? $ct_options['ct_zapier_webhook_listing_single_book_showing_form'] : '';

							if($ct_enable_zapier_webhooks == 'yes' && $ct_zapier_webhook_url != '' && $ct_zapier_webhook_listing_single_book_showing_form == true) { ?>
								ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-book-listing-showing-zapier.php",
							<?php } else { ?>
								ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-book-listing-showing.php",
							<?php } ?>
							ajaxSubmitMessage: "<?php _e('Thanks for booking a showing, we\'ll get back to confirm with you shortly.', 'contempo'); ?>",
							success :  false,
							failure : function() {}
						});
					});
				</script>

				<h4 class="marB20"><?php _e('Request a Showing', 'contempo'); ?></h4>

				<div class="schedule-calendar">
					<div id="schedulePrev"><i class="fa fa-angle-left"></i></div>
					<div class="calendar-slider owl-carousel">
					</div>
					<div id="scheduleNext"><i class="fa fa-angle-right"></i></div>
				</div>

				<form id="book-showing" class="formular" method="post">
					<p><em><?php _e('Select Your Time and Day', 'contempo'); ?></em></p>

					<div class="col span_5 first">
						<select name="showing_start">
							<option value="9:00 <?php _e('am', 'contempo'); ?>">9:00 <?php _e('am', 'contempo'); ?></option>
							<option value="9:30 <?php _e('am', 'contempo'); ?>">9:30 <?php _e('am', 'contempo'); ?></option>
							<option value="10:00 <?php _e('am', 'contempo'); ?>">10:00 <?php _e('am', 'contempo'); ?></option>
							<option value="10:30 <?php _e('am', 'contempo'); ?>">10:30 <?php _e('am', 'contempo'); ?></option>
							<option value="11:00 <?php _e('am', 'contempo'); ?>">11:00 <?php _e('am', 'contempo'); ?></option>
							<option value="11:30 <?php _e('am', 'contempo'); ?>">11:30 <?php _e('am', 'contempo'); ?></option>
							<option value="12:00 <?php _e('pm', 'contempo'); ?>">12:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="12:30 <?php _e('pm', 'contempo'); ?>">12:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="1:00 <?php _e('pm', 'contempo'); ?>">1:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="1:30 <?php _e('pm', 'contempo'); ?>">1:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="2:00 <?php _e('pm', 'contempo'); ?>">2:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="2:30 <?php _e('pm', 'contempo'); ?>">2:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="3:00 <?php _e('pm', 'contempo'); ?>">3:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="3:30 <?php _e('pm', 'contempo'); ?>">3:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="4:00 <?php _e('pm', 'contempo'); ?>">4:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="4:30 <?php _e('pm', 'contempo'); ?>">4:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="5:00 <?php _e('pm', 'contempo'); ?>">5:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="5:30 <?php _e('pm', 'contempo'); ?>">5:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="6:00 <?php _e('pm', 'contempo'); ?>">6:00 <?php _e('pm', 'contempo'); ?></option>
						</select>
					</div>

					<div class="col span_2 muted">
						<?php _e('to', 'contempo'); ?>
					</div>

					<div class="col span_5">
						<select name="showing_end">
							<option value="10:00 <?php _e('am', 'contempo'); ?>">10:00 <?php _e('am', 'contempo'); ?></option>
							<option value="10:30 <?php _e('am', 'contempo'); ?>">10:30 <?php _e('am', 'contempo'); ?></option>
							<option value="11:00 <?php _e('am', 'contempo'); ?>">11:00 <?php _e('am', 'contempo'); ?></option>
							<option value="11:30 <?php _e('am', 'contempo'); ?>">11:30 <?php _e('am', 'contempo'); ?></option>
							<option value="12:00 <?php _e('pm', 'contempo'); ?>">12:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="12:30 <?php _e('pm', 'contempo'); ?>">12:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="1:00 <?php _e('pm', 'contempo'); ?>">1:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="1:30 <?php _e('pm', 'contempo'); ?>">1:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="2:00 <?php _e('pm', 'contempo'); ?>">2:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="2:30 <?php _e('pm', 'contempo'); ?>">2:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="3:00 <?php _e('pm', 'contempo'); ?>">3:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="3:30 <?php _e('pm', 'contempo'); ?>">3:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="4:00 <?php _e('pm', 'contempo'); ?>">4:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="4:30 <?php _e('pm', 'contempo'); ?>">4:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="5:00 <?php _e('pm', 'contempo'); ?>">5:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="5:30 <?php _e('pm', 'contempo'); ?>">5:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="6:00 <?php _e('pm', 'contempo'); ?>">6:00 <?php _e('pm', 'contempo'); ?></option>
							<option value="6:30 <?php _e('pm', 'contempo'); ?>">6:30 <?php _e('pm', 'contempo'); ?></option>
							<option value="7:00 <?php _e('pm', 'contempo'); ?>">7:00 <?php _e('pm', 'contempo'); ?></option>
						</select>
					</div>

					<?php 
						$current_user = wp_get_current_user();
					?>

					<input type="hidden" id="selectedDate" name="selectedDate" value="" />
					<input type="hidden" id="name" name="name" value="<?php echo esc_html($current_user->user_firstname); ?> <?php echo esc_html($current_user->user_lastname); ?>" />
					<input type="hidden" id="email" name="email" value="<?php echo esc_html($current_user->user_email); ?>" />
					<input type="hidden" id="ctphone" name="ctphone" value="<?php echo esc_html($current_user->mobile); ?>" />
					<input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php the_author_meta('user_email'); ?>" />
					<input type="hidden" id="ctsubject" name="ctsubject" value="<?php _e('Showing Request for ', 'contempo'); ?> <?php ct_listing_title(); ?>" />
					<input type="hidden" id="ctproperty" name="ctproperty" value="<?php ct_listing_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
					<input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />

					<?php
					$first_name = get_the_author_meta('first_name');
					$last_name = get_the_author_meta('last_name');
					$email = get_the_author_meta('email');
					if($ct_enable_zapier_webhooks == 'yes' && $ct_zapier_webhook_url != '' && $ct_zapier_webhook_listing_single_book_showing_form == true) {
                        echo '<input type="hidden" id="ctagentname" name="ctagentname" value="' . $first_name . ' ' . $last_name . '" />';
                        echo '<input type="hidden" id="ctagentemail" name="ctagentemail" value="' . $email . '" />';
                        echo '<input type="hidden" id="ct_zapier_webhook_url" name="ct_zapier_webhook_url" value="' . $ct_zapier_webhook_url . '" />';
                    } ?>

					<div class="col span_12 first">
						<?php if(!is_user_logged_in()) { ?>
							<a class="btn login-register" href="#"><?php _e('Schedule Tour', 'contempo'); ?></a>
						<?php } else { ?>
							<input type="submit" name="Submit" value="<?php esc_html_e('Schedule Tour', 'contempo'); ?>" id="submit" class="btn" /> 
						<?php } ?>
					</div>

				</form>
			
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {
			?>
			<p>
			   <?php _e('No options required for this widget.', 'contempo'); ?>
			</p>
			<?php
		}
	} 
}

register_widget('ct_ListingBookShowing');
?>