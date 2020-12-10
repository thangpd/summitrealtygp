<?php

namespace Alike\App;

/**
 *
 */
class Ra_Shortcodes extends Ra_Template
{

  public function __construct()
  {
    $shortcodes = array(
      'alike_link' => 'alike_link',
      'alike_widget' => 'alike_widget',
      'alike_preview' => 'alike_preview',
    );

    foreach ($shortcodes as $shortcode => $function) {
      add_shortcode($shortcode, array($this, $function));
    }
  }

  public function alike_link($atts)
  {
    extract(shortcode_atts(
      array(
        'value' => __('Add To Compare', 'alike'),
        'show_icon' => false,
        'icon_class' => 'ion-arrow-swap',
      ),
      $atts
    ));
    ob_start();
    $template = $this->locate_template('shortcodes/alike-link.php');
    include($template);
    return ob_get_clean();
  }

  public function alike_widget($atts)
  {
    extract(shortcode_atts(
      array(
        'page_id' => '',
      ),
      $atts
    ));
    ob_start();
    $template = $this->locate_template('shortcodes/alike-widget.php');
    include($template);
    return ob_get_clean();
  }

  public function alike_preview($atts)
  {
    extract(shortcode_atts(
      array(),
      $atts
    ));
    ob_start();
    $template = $this->locate_template('shortcodes/alike-preview.php');
    include($template);
    return ob_get_clean();
  }
}
