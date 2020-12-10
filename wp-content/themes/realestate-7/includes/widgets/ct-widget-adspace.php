<?php
/**
 * Adspace
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_AdWidget')) {
	class ct_AdWidget extends WP_Widget {

		function __construct() {
			$widget_ops = array('description' => 'Use this widget to add any type of Ad as a widget.' );
			parent::__construct(false, __('CT Adspace Widget', 'contempo'),$widget_ops);      
		}

		function widget($args, $instance) { 
			extract( $args ); 
			$title = $instance['title'];
			$adcode = $instance['adcode'];
			$image = $instance['image'];
			$href = $instance['href'];
			$alt = $instance['alt'];

	        echo $before_widget;

			if($title != '')
				echo $before_title .$title. $after_title;

			echo '<div class="widget-inner">';
			
				if(!empty($adcode)){
					print($adcode);
				} else {				
					echo '<a href="' . esc_url($href) . '"><img src="' .  esc_url($image) . '" alt="' . esc_html($alt) . '" /></a>';
				}

			echo '</div>';
			
			echo $after_widget;

		}

		function update($new_instance, $old_instance) {                
			return $new_instance;
		}

		function form($instance) {  
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$adcode = isset( $instance['adcode'] ) ? esc_attr( $instance['adcode'] ) : '';
			$image = isset( $instance['image'] ) ? esc_attr( $instance['image'] ) : '';
			$href = isset( $instance['href'] ) ? esc_attr( $instance['href'] ) : '';
			$alt = isset( $instance['alt'] ) ? esc_attr( $instance['alt'] ) : '';
			?>
	        <p>
	            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title (optional):','contempo'); ?></label>
	            <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
	        </p>
			<p>
	            <label for="<?php echo esc_attr($this->get_field_id('adcode')); ?>"><?php esc_html_e('Ad Code:','contempo'); ?></label>
	            <textarea name="<?php echo esc_attr($this->get_field_name('adcode')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('adcode')); ?>"><?php echo esc_attr($adcode); ?></textarea>
	        </p>
	        <p><strong>or</strong></p>
	        <p>
	            <label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_html_e('Image Url:','contempo'); ?></label>
	            <input type="text" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="<?php echo esc_attr($image); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('image')); ?>" />
	        </p>
	        <p>
	            <label for="<?php echo esc_attr($this->get_field_id('href')); ?>"><?php esc_html_e('Link URL:','contempo'); ?></label>
	            <input type="text" name="<?php echo esc_attr($this->get_field_name('href')); ?>" value="<?php echo esc_attr($href); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('href')); ?>" />
	        </p>
	        <p>
	            <label for="<?php echo esc_attr($this->get_field_id('alt')); ?>"><?php esc_html_e('Alt text:','contempo'); ?></label>
	            <input type="text" name="<?php echo esc_attr($this->get_field_name('alt')); ?>" value="<?php echo esc_attr($alt); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('alt')); ?>" />
	        </p>
	        <?php
		}
	} 
}

register_widget('ct_AdWidget');
?>