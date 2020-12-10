<?php

namespace Alike\App;

class Ra_Alike_Widget extends \WP_Widget
{
  /**
   * Register widget with WordPress.
   */
  function __construct()
  {
    parent::__construct(
      'alike_widget', // Base ID
      __('CT Compare', 'alike'), // Name
      array('description' => __('A simple sidebar widget for displaying the added comparable listings.', 'alike'),) // Args
    );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget($args, $instance)
  {
    echo $args['before_widget'];
    if (!empty($instance['title'])) {
      echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
    }
    echo do_shortcode('[alike_widget page_id="' . esc_attr($instance['page_id']) . '"]');
    echo $args['after_widget'];
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form($instance)
  {
    $title = !empty($instance['title']) ? $instance['title'] : __('Compare', 'alike');

    $pages = get_posts(array('post_type' => 'page', 'posts_per_page' => -1,));

    $page_id = !empty($instance['page_id']) ? $instance['page_id'] : '';
?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page ID:'); ?></label>

      <select class="widefat" id="<?php echo $this->get_field_id('page_id'); ?>" name="<?php echo $this->get_field_name('page_id'); ?>">
        <?php foreach ($pages as $page) : ?>
          <option value="<?php echo esc_attr($page->ID) ?>" <?php echo ($page->ID == $page_id) ? 'selected' : ''; ?>><?php echo esc_attr($page->post_title) ?></option>
        <?php endforeach ?>
      </select>
    </p>
<?php
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    $instance['page_id'] = (!empty($new_instance['page_id'])) ? strip_tags($new_instance['page_id']) : '';

    return $instance;
  }
}
