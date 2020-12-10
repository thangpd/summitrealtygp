<?php
/**
 * ScrollTo Listing Contact
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

if(!function_exists('ct_ScrollToListingContact')) {
	class ct_ScrollToListingContact extends WP_Widget {

		function __construct() {
			$widget_ops = array('description' => 'Use this widget to add a simple button with smoothscroll to the listing contact form.' );
			parent::__construct(false, __('CT Listing Contact ScrollTo', 'contempo'), $widget_ops);      
		}

		function widget($args, $instance) { 
			extract( $args ); 

			$title = $instance['title'];

			$buttononetext = $instance['buttononetext'];
			$buttontwotext = $instance['buttontwotext'];

	        echo $before_widget;

			if($title != '')

				echo $before_title .$title. $after_title;

			echo '<div class="widget-inner">';
			
				// Button One
				if(!empty($buttononetext)) {
				
					echo '<a class="btn" href="#listing-contact">' . $buttononetext . '</a>';
			
				}

				// Button Two
				if(!empty($buttontwotext)) {
				
					echo '<a class="btn btn-secondary marT20" href="#listing-contact">' . $buttontwotext . '</a>';
			
				}

			echo '</div>';
			
			echo $after_widget;

		}

		function update($new_instance, $old_instance) {                
			return $new_instance;
		}

		function form($instance) {  
				$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
				$buttononetext = $instance['buttononetext'];
				$buttontwotext = $instance['buttontwotext'];
			?>
	        <p>
	            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title (optional):','contempo'); ?></label>
	            <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
	        </p>
			<p>
	            <label for="<?php echo esc_attr($this->get_field_id('buttononetext')); ?>"><?php esc_html_e('Button One Text:','contempo'); ?></label>
	            <input type="text" name="<?php echo esc_attr($this->get_field_name('buttononetext')); ?>" value="<?php echo esc_attr($buttononetext); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('buttononetext')); ?>" />
	        </p>
	        <p>
	            <label for="<?php echo esc_attr($this->get_field_id('buttontwotext')); ?>"><?php esc_html_e('Button Two Text:','contempo'); ?></label>
	            <input type="text" name="<?php echo esc_attr($this->get_field_name('buttontwotext')); ?>" value="<?php echo esc_attr($buttontwotext); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('buttontwotext')); ?>" />
	        </p>
	        <?php
		}
	} 
}

register_widget('ct_ScrollToListingContact');
?>