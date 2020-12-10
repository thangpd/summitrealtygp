<?php

global $post;

$source = get_post_meta($post->ID, "source", true);

if ($source == "idx-api") {
  $image = get_template_directory_uri() . '/images/no-image.png';

  $images = get_post_meta($post->ID, "_ct_slider");
  if (!empty($images[0]) && is_array($images[0])) {
    foreach ($images[0] as $key => $value) {
      $image = $value;
      break;
    }
  }
} else {
  $post_image_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail', false);

  $image = $post_image_src[0];
}
?>
<a href="#" class="alike-button alike-button-style" data-post-id="<?php echo esc_attr(get_the_ID()) ?>" data-post-title="<?php echo esc_attr(get_the_title()) ?>" data-post-thumb="<?php echo esc_url($image) ?>" data-post-link="<?php echo esc_url(get_the_permalink()) ?>" title="<?php echo esc_attr($value) ?>"><?php echo ($show_icon) ? '<i class="' . $icon_class . '"></i>' : esc_attr($value); ?></a>
