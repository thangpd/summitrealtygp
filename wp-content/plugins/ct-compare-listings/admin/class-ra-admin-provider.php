<?php

namespace Alike\Admin;

/**
*
*/
class Ra_Admin_Provider {

  public function __construct() {

  }

  public function get_post_data( $allData ) {

      $all_posts = array();
      foreach ($allData as $data) {
        $post_type = $data['post_type'];
        $all_posts[] = array(
          'post_type' => $post_type,
          'selectedData' => isset($data['selectedData'] ) ? $data['selectedData'] : array(),
          'taxonomy_keys' => $this->get_all_taxonomies($post_type),
          'term_keys' => $this->get_terms_on_taxonomies($this->get_all_taxonomies($post_type)),
          'meta_keys' => $this->get_meta_keys($post_type),
          'post_keys' => array(
            'ID',
            'post_name',
            'post_title',
            'post_author',
            'post_content',
            'post_excerpt',
            'comment_count',
            'post_date',
            'post_modified',
          )
          // meta_keys , post_keys [ 'id']
        );
      }

      return $all_posts;
  } // end of posts


public function get_shortcode_content($post_id)
  {
    $content_post = get_post($post_id);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return do_shortcode($content);
  }

  public function get_post_image($post_id)
  {
    if (has_post_thumbnail( $post_id ) ){
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );

      return $image[0];
    }
  }
  public function get_post_link($post_id)
  {
    return get_the_permalink( $post_id );
  }

  public function get_post_metadata($post_id)
  {
    $fields = get_post_custom($post_id);
    $temp = array();
    foreach ($fields as $metakey => $metavalues) {
      if(!empty($metavalues)){
        if( $metavalues[0] != null )
          $temp[$metakey] = $metavalues[0];
      }
    }
    return $temp;
  }


  public function get_post_terms( $post_id, $taxonomies )
  {
    $temp = array();
    foreach ($taxonomies as $taxonomy) {
      $terms = wp_get_post_terms( $post_id, $taxonomy );
      $temp[$taxonomy] = array();
      foreach ($terms as $term) {
        $temp[$taxonomy][] = $term->slug;
      }
    }
    return $temp;
  }

  /**
   *
   * @param string [comma seperated]
   *
   */
  public function get_all_taxonomies( $post_types='post' )
  {
    $all_post_types = explode(",",$post_types);
    $taxonomies = array();
    foreach ($all_post_types as $type ) {
      $taxonomies = array_merge( $taxonomies, get_object_taxonomies( $type) ) ;
    }
    return $taxonomies;
  }


  /**
   *
   * @param array [ taxonomies ]
   *
   * @return array()
   */
  public function get_terms_on_taxonomies( $taxonomies )
  {
    if( !empty($taxonomies) ){
      $all_data = array();
      foreach ($taxonomies as $taxonomy) {

        $categories = get_terms( $taxonomy , array('hide_empty' => false));
        $categoryHierarchy = array();
        $linar_order = array();
        $this->sort_terms_hierarchicaly($categories, $categoryHierarchy);
        $this->grab_in_linear( $categoryHierarchy, $taxonomy , $linar_order );

        $all_data[$taxonomy] = array(
          'linear' => $linar_order,
          'complex' => $categoryHierarchy
        );
      }

      return $all_data;
    }
  }

  function grab_in_linear( $cats , $taxonomy, &$result  ){
    if( is_array($cats) && count($cats) > 0 ){
      foreach ($cats as $cat) {
        $flag = false;
        foreach ($result as $term) {
          if($term['key'] == $cat->term_id){
            $flag = true;
          }
        }
        if( $flag == false  ){
          $level = count(get_ancestors( $cat->term_id, $taxonomy ) );
          $dash = "";
          for($i = 0; $i < $level; $i++  )
            $dash .= "  ";
          $result[] = array(
            'key'  => $cat->term_id,
            'value' => $dash.$cat->name,
            'slug' => $cat->slug,
            'count' => $cat->count,
            'parent' => $cat->parent,
            'term_meta' => $this->get_all_term_meta($cat->term_id),
          );
        }
        if( is_array( $cat->children ) && count($cat->children) > 0 ){
          $this->grab_in_linear($cat->children, $taxonomy , $result  );
        }
      }
    }
  }

  public function get_all_term_meta($term_id) {
    $result = array();
    $term_meta = array();
    // $thumbnail_id = get_woocommerce_term_meta( $term_id, 'thumbnail_id', true );
    // if($thumbnail_id){
    //   $image_full_url = wp_get_attachment_image_src( $thumbnail_id);
    //   $image_big_url = wp_get_attachment_image_src( $thumbnail_id, array(600, 400));
    //   $image_medium_url = wp_get_attachment_image_src( $thumbnail_id, array(300, 152));
    //   $image_small_url = wp_get_attachment_image_src( $thumbnail_id, array(64, 64));
    //   if($image_full_url[0]){
    //     $term_meta[] = array(
    //       'thumbnail_image' => array(
    //         'image_full_url' => $image_full_url[0],
    //         'image_big_url' => $image_big_url[0],
    //         'image_medium_url' => $image_medium_url[0],
    //         'image_small_url' => $image_small_url[0]),
    //     );
    //   }
    // return $term_meta;
    // }
    $result = get_term_meta($term_id);
    foreach ($result as $key => $value) {
        if($value[0]){
          $image_full_url = wp_get_attachment_image_src($value[0]);
          $image_big_url = wp_get_attachment_image_src($value[0], array(600, 400));
          $image_medium_url = wp_get_attachment_image_src($value[0], array(300, 152));
          $image_small_url = wp_get_attachment_image_src($value[0], array(64, 64));
        }
      if($image_full_url[0]){
        $term_meta[] = array(
          $key => array(
            'image_full_url' => $image_full_url[0],
            'image_big_url' => $image_big_url[0],
            'image_medium_url' => $image_medium_url[0],
            'image_small_url' => $image_small_url[0]),
        );
      }
      else{
        $term_meta[] = array(
          $key => array($value[0]),
        );
      }
    }
  return $term_meta;
}

  public function sort_terms_hierarchicaly(Array &$cats, Array &$into, $parentId = 0) {
      foreach ($cats as $i => $cat) {
          if ($cat->parent == $parentId) {
              $into[] = $cat;
              unset($cats[$i]);
          }
      }
      foreach ($into as $topCat) {
          $topCat->children = array();
          $this->sort_terms_hierarchicaly($cats, $topCat->children, $topCat->term_id);
      }
  }


  /**
   * @param string [comma seperated]
   *
   */
  public function get_meta_keys( $post_types='post' ) {

    global $wpdb;
    $all_post_types = explode(",",$post_types);
    $generate = '';
    $all_keys = array();

    foreach ($all_post_types as $type ) {
      $query = $wpdb->prepare("SELECT DISTINCT pm.meta_key FROM {$wpdb->posts} post INNER JOIN
        {$wpdb->postmeta} pm ON post.ID = pm.post_id WHERE post.post_type='%s'",$type);
      $result = $wpdb->get_results($query , 'ARRAY_A');

      if( !empty($result) ){
        foreach ($result as $res) {
          //&& strpos( $res['meta_key'] ,'_') != 0
          if(!in_array($res['meta_key'], $all_keys) ){
            $all_keys[] = $res['meta_key'];
          }
        }
      }
    }

    return $all_keys;
  }






} // end of class