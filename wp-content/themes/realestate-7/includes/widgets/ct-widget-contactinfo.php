<?php
/**
 * Contact Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_ContactInfo')) {
	class ct_ContactInfo extends WP_Widget {

	   function __construct() {
		   $widget_ops = array('description' => 'Use this widget to display your contact information.' );
		   parent::__construct(false, __('CT Contact Info', 'contempo'),$widget_ops);      
	   }

	   function widget($args, $instance) {  
		extract( $args );
		global $ct_options;
		$title = $instance['title'];
		$logo = $instance['logo'];
		$icon_color = isset( $instance['icon_color'] ) ? esc_html( $instance['icon_color'] ) : '';
		$ct_logo = isset( $ct_options['ct_logo']['url'] ) ? esc_html( $ct_options['ct_logo']['url'] ) : '';
		$ct_logo_highres = isset( $ct_options['ct_logo_highres']['url'] ) ? esc_html( $ct_options['ct_logo_highres']['url'] ) : '';
		$blurb = $instance['blurb'];
		$company = $instance['company'];
		$agent_lic = isset( $instance['agent_lic'] ) ? esc_html( $instance['agent_lic'] ) : '';
		$broker_lic = isset( $instance['broker_lic'] ) ? esc_html( $instance['broker_lic'] ) : '';
		$street = $instance['street'];
		$city = $instance['city'];
		$state = $instance['state'];
		$postal = $instance['postal'];
		$country = $instance['country'];
		$phone = $instance['phone'];
		$email = $instance['email'];
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$linkedin = $instance['linkedin'];
		$instagram = $instance['instagram'];
		$pinterest = $instance['pinterest'];

		global $ct_options;
		?>

			<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; }
			echo '<div class="widget-inner">';
				if($logo == "Yes") { ?>
					<?php if(!empty($ct_options['ct_logo']['url'])) { ?>
						<a href="<?php echo home_url(); ?>"><img class="widget-logo marB30" src="<?php echo esc_url($ct_logo); ?>" <?php if(!empty($ct_logo_highres)) { ?>srcset="<?php echo esc_url($ct_logo_highres); ?> 2x"<?php } ?> alt="<?php bloginfo('name'); ?>" /></a>
					<?php } else { ?>
						<?php if($ct_options['ct_skin'] == 'minimal') { ?>
	                        <img class="widget-logo marB30" src="<?php echo get_stylesheet_directory_uri(); ?>/images/re7-logo-blue.png" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/re7-logo-blue@2x.png 2x" alt="WP Pro Real Estate 7, a WordPress theme by Contempo" />
	                    <?php } else { ?>
	                    	<img class="widget-logo marB30" src="<?php echo get_stylesheet_directory_uri(); ?>/images/re7-logo.png" srcset="<?php echo get_stylesheet_directory_uri(); ?>/images/re7-logo@2x.png 2x" alt="WP Pro Real Estate 7, a WordPress theme by Contempo" />
	                    <?php } ?>
					<?php } ?>
				<?php } ?>
				<?php
				$ct_allowed_html = array(
		                'a' => array(
		                    'href' => array(),
		                    'title' => array()
		                ),
		                'img' => array(
		                    'src' => array(),
		                    'alt' => array()
		                ),
		                'em' => array(),
		                'strong' => array(),
		            );
	            ?>
		        <?php if($blurb) { ?><p class="marB15"><?php echo wp_kses(stripslashes($blurb), $ct_allowed_html); ?></p><?php } ?>

		        <ul class="contact-info">
		            <?php if(!empty($street)) { ?>
		            	<li class="company-address"><?php if($icon_color == "light") { ct_office_svg_white(); } else { ct_office_svg(); } ?> <?php echo esc_html($street); ?><br />
		            
			            <?php if(!empty($city) || !empty($city) || !empty($city) || !empty($city) || !empty($city)) { ?>
				            <?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($postal); ?><br /><?php echo esc_html($country); ?>
				        <?php } ?>

				        </li>
				    <?php } ?>
		            <?php if($phone) { ?><li class="company-phone"><?php if($icon_color == "light") { ct_phone_svg_white(); } else { ct_phone_svg(); } ?> <?php echo esc_html($phone); ?></li><?php } ?>
		            <?php if($email) { ?><li class="company-email"><?php if($icon_color == "light") { ct_envelope_svg_white(); } else { ct_envelope_svg(); } ?> <a href="mailto:<?php echo antispambot($email); ?>"><?php echo antispambot($email); ?></a></li><?php } ?>
	            	<?php if($agent_lic) { ?><li class="agent-license"><?php _e('Agent #:', 'contempo'); ?> <?php echo esc_html($agent_lic); ?></li><?php } ?>
	            	<?php if($broker_lic) { ?><li class="agent-license"><?php _e('Broker #:', 'contempo'); ?> <?php echo esc_html($broker_lic); ?></li><?php } ?>
		        </ul>

		        <ul class="contact-social">
					<?php if($facebook != '') { ?>
		                <li class="facebook"><a href="<?php echo esc_url($facebook); ?>"><i class="fa fa-facebook"></i></a></li>
		            <?php } ?>
		            <?php if($twitter != '') { ?>
		                <li class="twitter"><a href="<?php echo esc_url($twitter); ?>"><i class="fa fa-twitter"></i></a></li>
		            <?php } ?>
		            <?php if($linkedin != '') { ?>
		                <li class="linkedin"><a href="<?php echo esc_url($linkedin); ?>"><i class="fa fa-linkedin"></i></a></li>
		            <?php } ?>
		            <?php if($pinterest != '') { ?>
		                <li class="pinterest"><a href="<?php echo esc_url($pinterest); ?>"><i class="fa fa-pinterest"></i></a></li>
		            <?php } ?>
		            <?php if($instagram != '') { ?>
		                <li class="instagram"><a href="<?php echo esc_url($instagram); ?>"><i class="fa fa-instagram"></i></a></li>
		            <?php } ?>
		        </ul>
		    </div>
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) {    
	   
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';    
			$blurb = isset( $instance['blurb'] ) ? esc_attr( $instance['blurb'] ) : '';
			$company = isset( $instance['company'] ) ? esc_attr( $instance['company'] ) : '';
			$agent_lic = isset( $instance['agent_lic'] ) ? esc_attr( $instance['agent_lic'] ) : '';
			$broker_lic = isset( $instance['broker_lic'] ) ? esc_attr( $instance['broker_lic'] ) : '';
			$street = isset( $instance['street'] ) ? esc_attr( $instance['street'] ) : '';
			$city = isset( $instance['city'] ) ? esc_attr( $instance['city'] ) : '';
			$state = isset( $instance['state'] ) ? esc_attr( $instance['state'] ) : '';
			$postal = isset( $instance['postal'] ) ? esc_attr( $instance['postal'] ) : '';
			$country = isset( $instance['country'] ) ? esc_attr( $instance['country'] ) : '';
			$phone = isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';
			$email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
			$facebook = isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : '';
			$twitter = isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : '';
			$linkedin = isset( $instance['linkedin'] ) ? esc_attr( $instance['linkedin'] ) : '';
			$instagram = isset( $instance['instagram'] ) ? esc_attr( $instance['instagram'] ) : '';
			$pinterest = isset( $instance['pinterest'] ) ? esc_attr( $instance['pinterest'] ) : '';

			$logo = isset( $instance['logo'] ) ? esc_attr( $instance['logo'] ) : '';
			$icon_color = isset( $instance['icon_color'] ) ? esc_attr( $instance['icon_color'] ) : '';

			?>
			<p>
	            <label for="<?php echo esc_attr($this->get_field_id('logo')); ?>"><?php esc_html_e('Show Logo','contempo'); ?></label>
	            <select name="<?php echo esc_attr($this->get_field_name('logo')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('logo')); ?>">
	                <option value="Yes" <?php if($logo == 'Yes'){ echo "selected='selected'";} ?>><?php esc_html_e('Yes', 'contempo'); ?></option>
	                <option value="No" <?php if($logo == 'No'){ echo "selected='selected'";} ?>><?php esc_html_e('No', 'contempo'); ?></option>
	            </select>
	        </p>
	        <p>
	            <label for="<?php echo esc_attr($this->get_field_id('icon_color')); ?>"><?php esc_html_e('Icon Color','contempo'); ?></label>
	            <select name="<?php echo esc_attr($this->get_field_name('icon_color')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('icon_color')); ?>">
	                <option value="light" <?php if($icon_color == 'light'){ echo "selected='selected'";} ?>><?php esc_html_e('Light', 'contempo'); ?></option>
	                <option value="dark" <?php if($icon_color == 'dark'){ echo "selected='selected'";} ?>><?php esc_html_e('Dark', 'contempo'); ?></option>
	            </select>
	        </p>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('blurb')); ?>"><?php esc_html_e('Blurb:','contempo'); ?></label>
				<textarea name="<?php echo esc_attr($this->get_field_name('blurb')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('blurb')); ?>"><?php echo esc_html($blurb); ?></textarea>
			</p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('company')); ?>"><?php esc_html_e('Company Name:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('company')); ?>"  value="<?php echo esc_attr($company); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('company')); ?>" />
			</p>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('agent_lic')); ?>"><?php esc_html_e('Agent License #:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('agent_lic')); ?>" value="<?php echo esc_attr($agent_lic); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('agent_lic')); ?>" />
			</p>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('broker_lic')); ?>"><?php esc_html_e('Broker License #:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('broker_lic')); ?>"  value="<?php echo esc_attr($broker_lic); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('broker_lic')); ?>" />
			</p>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('street')); ?>"><?php esc_html_e('Street Address:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('street')); ?>" value="<?php echo esc_attr($street); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('street')); ?>" />
			</p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('city')); ?>"><?php esc_html_e('City:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('city')); ?>" value="<?php echo esc_attr($city); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('city')); ?>" />
			</p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('state')); ?>"><?php esc_html_e('State:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('state')); ?>"  value="<?php echo esc_attr($state); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('state')); ?>" />
			</p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('postal')); ?>"><?php esc_html_e('Postal:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('postal')); ?>"  value="<?php echo esc_attr($postal); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('postal')); ?>" />
			</p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('country')); ?>"><?php esc_html_e('Country:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('country')); ?>"  value="<?php echo esc_attr($country); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('country')); ?>" />
			</p>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php esc_html_e('Phone:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('phone')); ?>"  value="<?php echo esc_attr($phone); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" />
			</p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('Email:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('email')); ?>"  value="<?php echo esc_attr($email); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" />
			</p>
	        <p>
			   <label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php esc_html_e('Facebook:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>"  value="<?php echo esc_attr($facebook); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" />
			</p>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php esc_html_e('Twitter:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>"  value="<?php echo esc_attr($twitter); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" />
			</p>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php esc_html_e('LinkedIn:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>"  value="<?php echo esc_attr($linkedin); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" />
			</p>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"><?php esc_html_e('Pinterest:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>"  value="<?php echo esc_attr($pinterest); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" />
			</p>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>"><?php esc_html_e('Instagram:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>"  value="<?php echo esc_attr($instagram); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" />
			</p>
			<?php
		}
	} 
}

register_widget('ct_ContactInfo');
?>