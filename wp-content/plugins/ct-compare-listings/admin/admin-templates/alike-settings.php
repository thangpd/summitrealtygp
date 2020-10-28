<?php

// if this fails, check_admin_referer() will automatically print a "failed" page and die.
if ( ! empty( $_POST ) && check_admin_referer( 'nonce_alike_settings', 'alike_settings' ) ) {
  $posted = $_POST;
  unset($posted['submit']);
  unset($posted['alike_settings']);
  unset($posted['_wp_http_referer']);

  update_option('alike_settings', $posted);
}


$alike_settings = get_option('alike_settings', true);

?>
<div class="wrap">
  <h1><?php esc_html_e('Alike Settings', 'alike') ?></h1>
  <form action="<?php echo esc_url( admin_url( 'admin.php?page=alike_settings' ) ) ?>" method="post">
    <h2 class="title"><?php esc_html_e('Preview skin chooser', 'alike') ?></h2>
    <table class="form-table alike-admin-settings-from">
      <tbody>
        <tr>
          <th scope="row"><?php esc_html_e('Select a skin', 'alike') ?></th>
          <td>
            <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Theme Select', 'alike') ?></span></legend>
              <label title="alike_theme_select_one">
                <input type="radio" name="alike_theme_select" value="one" <?php echo ( $alike_settings['alike_theme_select'] == 'one' ) ? 'checked="checked"' : ''; ?> />
                <img src="<?php print RA_IMG ?>skin-one.png" width="100%" />
              </label><br>
              <label title="alike_theme_select_two">
                <input type="radio" name="alike_theme_select" value="two" <?php echo ( $alike_settings['alike_theme_select'] == 'two' ) ? 'checked="checked"' : ''; ?> />
                <img src="<?php print RA_IMG ?>skin-two.png" width="100%" />
              </label><br>
            </fieldset>
          </td>
        </tr>
      </tbody>
    </table>

    <h2 class="title"><?php esc_html_e('Image Crop', 'alike') ?></h2>
    <p><?php esc_html_e('The sizes listed below determine the maximum dimensions in pixels to use when showing an image to the Compare Page.', 'alike') ?></p>
    <?php wp_nonce_field( 'nonce_alike_settings', 'alike_settings' ); ?>
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row"><?php esc_html_e('Thumbnail image size', 'alike') ?></th>
          <td>
            <label for="thumbnail_size_w"><?php esc_html_e('Width', 'alike') ?></label>
            <input name="thumbnail_size_w" type="number" step="1" min="0" id="thumbnail_size_w" value="<?php echo $alike_settings['thumbnail_size_w'] ?>" class="small-text">
            
            <label for="thumbnail_size_h"><?php esc_html_e('Height', 'alike') ?></label>
            <input name="thumbnail_size_h" type="number" step="1" min="0" id="thumbnail_size_h" value="<?php echo $alike_settings['thumbnail_size_h'] ?>" class="small-text"><br>
            <input name="thumbnail_crop" type="checkbox" id="thumbnail_crop" value="1" <?php echo ( isset( $alike_settings['thumbnail_crop'] ) && $alike_settings['thumbnail_crop'] == '1' ) ? 'checked="checked"' : '' ?> >
            <label for="thumbnail_crop"><?php esc_html_e('Crop thumbnail to exact dimensions (normally thumbnails are proportional)', 'alike') ?></label>
          </td>
        </tr>
      </tbody>
    </table>

    <table class="form-table">
      <tbody>
        <tr>
          <th><?php esc_html_e('Maximum posts to compare', 'alike') ?></th>
          <td><input type="number" name="max_compare" value="<?php echo esc_attr( ( isset ( $alike_settings['max_compare'] ) ? $alike_settings['max_compare'] : '4' ) )?>" /></td>
        </tr>
      </tbody>
    </table>
    
    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
  </form>
</div>

<style type="text/css">
  input[type="radio"] {
    display: none;
  }
  input[type="radio"] + img {
    border: 2px solid transparent;
  }
  input[type="radio"]:checked + img {
    border: 2px solid #E74C3C;
  }
</style>