<?php
/**
 * Agent Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
if(!function_exists('ct_AgentInfo')) {
	class ct_AgentInfo extends WP_Widget {

	   function __construct() {
		   $widget_ops = array('description' => 'Use this widget to display your listing agent information, can only be used in the Listing Single sidebar as it relies on listing information for content.' );
		   parent::__construct(false, __('CT Agent Info', 'contempo'),$widget_ops);    
	   }

	   function widget($args, $instance) {  
		extract( $args );
		
		$title = $instance['title'];
		
		?>
			<?php
			
	        echo $before_widget;
			
			if ($title) {
				echo $before_title . $title . $after_title;
			}     

			$author_id = get_the_author_meta('ID');

			echo '<div class="widget-inner">';   
	        
				if(get_the_author_meta('ct_profile_url')) {
					echo '<figure class="col span_12 first row">';
						echo '<a href="' . get_author_posts_url($author_id) . '">';
							echo '<img class="authorimg" src="';
								echo the_author_meta('ct_profile_url');
							echo '" />';
						echo '</a>';
					echo '</figure>';
				} else {
					echo '<a href="' . get_author_posts_url($author_id) . '">';
							echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
					echo '</a>';
				}
					$author_id = get_the_author_meta('ID');
					$first_name = get_the_author_meta('first_name');
					$last_name = get_the_author_meta('last_name');
					$tagline = get_the_author_meta('tagline');
					$mobile = get_the_author_meta('mobile');
					$office = get_the_author_meta('office');
					$fax = get_the_author_meta('fax');
					$email = get_the_author_meta('email');
					$twitterhandle = get_the_author_meta('twitterhandle');
		            $facebookurl = get_the_author_meta('facebookurl');
		            $instagramurl = get_the_author_meta('instagramurl');
		            $linkedinurl = get_the_author_meta('linkedinurl');
		            $youtubeurl = get_the_author_meta('youtubeurl');
				?>
			    
			    <div class="details col span_12 first row">
			        <h5 class="author <?php if(empty($tagline)) { echo 'marB10'; } ?>"><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo esc_html($first_name); ?> <?php echo esc_html($last_name); ?></a></h5>
			        <?php if($tagline) { ?>
			            <p class="muted tagline"><i><?php echo esc_html($tagline); ?></i></p>
			        <?php } ?>
			        <ul class="marB0">
			            <?php if($mobile) { ?>
				            <li class="marT3 marB0 row mobile"><span class="muted left"><?php ct_phone_svg(); ?></span><span class="right"><?php echo esc_html($mobile); ?></span></li>
			            <?php } ?>
			            <?php if($office) { ?>
				            <li class="marT3 marB0 row office"><span class="muted left"><?php ct_office_svg(); ?></span><span class="right"><?php echo esc_html($office); ?></span></li>
			            <?php } ?>
			            <?php if($fax) { ?>
				            <li class="marT3 marB0 row fax"><span class="muted left"><?php ct_printer_svg(); ?></span><span class="right"><?php echo esc_html($fax); ?></span></li>
				        <?php } ?>
			        	<?php if($email) { ?>
				        	<li class="marT3 marB0 row email"><span class="muted left"><?php ct_envelope_svg(); ?></span><span class="right"><a href="mailto:<?php echo antispambot($email,1) ?>"><?php esc_html_e('Email', 'contempo'); ?></a></span></li>
					    <?php } ?>
					</ul>

					<ul class="social marT15 marL0">
	                    <?php if ($twitterhandle) { ?><li class="twitter"><a href="https://twitter.com/#!/<?php echo esc_html($twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
	                    <?php if ($facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
	                    <?php if ($instagramurl) { ?><li class="instagram"><a href="<?php echo esc_url($instagramurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
	                    <?php if ($linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
	                    <?php if ($youtubeurl) { ?><li class="youtube"><a href="<?php echo esc_url($youtubeurl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
	                </ul>
			    </div>
				    <div class="clear"></div>
		    </div>
			<?php echo $after_widget; ?>   
	    <?php
	   }

	   function update($new_instance, $old_instance) {                
		   return $new_instance;
	   }

	   function form($instance) { 
			
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			
			?>
			<p>
			   <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
			   <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
		<?php }
	} 
}

register_widget('ct_AgentInfo');
?>