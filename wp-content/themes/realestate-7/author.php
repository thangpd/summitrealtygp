<?php
/**
 * Author/Agent Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options;

$ct_agent_single_listings = isset( $ct_options['ct_agent_single_listings'] ) ? esc_attr( $ct_options['ct_agent_single_listings'] ) : '';
$ct_agent_single_layout = isset( $ct_options['ct_agent_single_layout'] ) ? esc_attr( $ct_options['ct_agent_single_layout'] ) : '';
$ct_agent_single_listings_hide_solds = isset( $ct_options['ct_agent_single_listings_hide_solds'] ) ? $ct_options['ct_agent_single_listings_hide_solds'] : '';
$ct_agents_listings_per_page = isset( $ct_options['ct_agents_listings_per_page'] ) ? esc_attr( $ct_options['ct_agents_listings_per_page'] ) : '';

$ct_enable_zapier_webhooks = isset( $ct_options['ct_enable_zapier_webhooks'] ) ? $ct_options['ct_enable_zapier_webhooks'] : '';
$ct_zapier_webhook_url = isset( $ct_options['ct_zapier_webhook_url'] ) ? $ct_options['ct_zapier_webhook_url'] : '';
$ct_zapier_webhook_agent_contact_form = isset( $ct_options['ct_zapier_webhook_agent_contact_form'] ) ? $ct_options['ct_zapier_webhook_agent_contact_form'] : '';

if(isset($_GET['author_name'])) :
	$curauth = get_user_by('slug', $author_name);
else :
	$curauth = get_userdata(intval($author));
endif;

$author_page_url = $curauth->user_url;
$profile_img = $curauth->ct_profile_url;
$brokerage_id = $curauth->brokeragename;

get_header();

do_action('before_agent_header');

echo '<!-- Page Header -->';
echo '<header id="title-header">';
	echo '<div class="container">';
		echo '<div class="left">';
			echo '<h5 class="marT0 marB0">';
				esc_html_e('Agent', 'contempo');
			echo '</h5>';
		echo '</div>';
		echo ct_breadcrumbs();
		echo '<div class="clear"></div>';
	echo '</div>';
echo '</header>';
echo '<!-- //Page Header -->';

?>

<?php do_action('before_agent_content'); ?>

	<div id="page-content" class="agent-single container marT30 padB60">

		<?php if($curauth->user_email) {
			$email = $curauth->user_email; ?>

			<script>    
                jQuery(document).ready(function() {
                    jQuery("#listingscontact").validationEngine({
                        ajaxSubmit: true,
                        <?php if($ct_enable_zapier_webhooks == 'yes' && $ct_zapier_webhook_url != '' && $ct_zapier_webhook_agent_contact_form == true) { ?>
                            ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-agent-zapier.php",
                        <?php } else { ?>
	                        ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-agent.php",
	                    <?php } ?>
                        ajaxSubmitMessage: "<?php $contact_success = str_replace(array("\r\n", "\r", "\n"), " ", $ct_options['ct_contact_success']); echo esc_html($contact_success); ?>",
                        success :  false,
                        failure : function() {}
                    });
                });
            </script>

			<!-- Agent Contact Modal -->
	        <div id="overlay" class="contact-modal">
			    <div id="modal">
			    	<div id="modal-inner">
				        <a href="#" class="close"><i class="fa fa-close"></i></a>
			            <form id="listingscontact" class="formular" method="post">
	    					<fieldset class="col span_12">
	    						<select id="ctsubject" name="ctsubject">
	    							<option><?php esc_html_e('Tell me more about a property', 'contempo'); ?></option>
	    							<option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
	    							<option><?php esc_html_e('General Questions', 'contempo'); ?></option>
	    						</select>
	    							<div class="clear"></div>
	    						<input type="text" name="name" id="name" class="validate[required] text-input" placeholder="<?php esc_html_e('Name', 'contempo'); ?>" />

	    						<input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" placeholder="<?php esc_html_e('Email', 'contempo'); ?>" />

	    						<input type="text" name="ctphone" id="ctphone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" />

	    						<textarea class="validate[required,length[2,1000]] text-input" name="message" id="message" rows="6" cols="10"></textarea>

	    						<?php if($ct_enable_zapier_webhooks == 'yes' && $ct_zapier_webhook_url != '' && $ct_zapier_webhook_agent_contact_form == true) {
                                    echo '<input type="hidden" id="ctagentname" name="ctagentname" value="' . esc_html($curauth->display_name) . '" />';
                                    echo '<input type="hidden" id="ctagentemail" name="ctagentemail" value="' . esc_html($curauth->user_email) . '" />';
                                    echo '<input type="hidden" id="ct_zapier_webhook_url" name="ct_zapier_webhook_url" value="' . $ct_zapier_webhook_url . '" />';
                                } ?>

	    						<input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
	    					</fieldset>
	    						<div class="clear"></div>
	    				</form>
			        </div>
			    </div>
			</div>
	        <!-- //Agent Contact Modal -->
	    <?php } ?>

		<div class="col span_12 first">

			<?php if($ct_agent_single_layout == 'agent-sidebar') { ?>

				<!-- Agent Sidebar -->
				<div id="agent-sidebar" class="agent col span_3 first">

					<figure>
	                	<?php if($curauth->ct_profile_url) { ?>
		                    <img class="author-img" src="<?php echo esc_html($curauth->ct_profile_url); ?>" />
	                    <?php } else { ?>
		                    <img class="author-img" src="<?php echo get_template_directory_uri() . '/images/user-default.png'; ?>" />
	                    <?php } ?>
	                </figure>

	                <div id="agent-sidebar-inner" class="agent-info">
		                
		                <h1><?php echo esc_html($curauth->display_name); ?></h1>
		                <?php if ($curauth->title) { ?><h5 class="muted position marB20"><?php echo esc_html($curauth->title); ?> <?php if ($curauth->brokeragename) { ?> &mdash; <?php ct_brokerage_name($brokerage_id); ?><?php } ?></h5><?php } ?>

	                	<p><?php if($curauth->tagline) { ?><strong class="tagline"><?php echo esc_html($curauth->tagline); ?></strong> <?php } ?><?php $bio = $curauth->description; echo nl2br($bio); ?></p>

	                	<ul class="col">
			                <?php if($curauth->mobile) { ?><li id="mobile" class="row"><span class="muted left"><?php ct_phone_svg(); ?></span> <span class="right"><a href="tel:<?php echo esc_html($curauth->mobile); ?>"><?php echo esc_html($curauth->mobile); ?></a></span></li><?php } ?>
			                <?php if($curauth->office) { ?><li id="office" class="row"><span class="muted left"><?php ct_office_svg(); ?></span> <span class="right"><a href="tel:<?php echo esc_html($curauth->office); ?>"><?php echo esc_html($curauth->office); ?></a></span></li><?php } ?>
			                <?php if($curauth->fax) { ?><li id="fax" class="row"><span class="muted left"><?php ct_printer_svg(); ?></span> <span class="right"><a href="tel:<?php echo esc_html($curauth->fax); ?>"><?php echo esc_html($curauth->fax); ?></a></span></li><?php } ?>
			                <?php if($curauth->user_email) { $email = $curauth->user_email; ?><li id="email" class="row"><span class="muted left"><?php ct_envelope_svg(); ?></span> <span class="right"><a class="agent-contact" href="#"><?php esc_html_e('Email', 'contempo'); ?></a
			                ></span></li><?php } ?>
			                <?php if($curauth->user_url) {
			                	$ct_user_url = $curauth->user_url;
			                	$ct_user_url = trim($ct_user_url, '/');
			                	// If scheme not included, prepend it
								if (!preg_match('#^http(s)?://#', $ct_user_url)) {
								    $ct_user_url = 'http://' . $ct_user_url;
								}

								$ct_urlParts = parse_url($ct_user_url);

								// remove www
								$ct_domain = preg_replace('/^www\./', '', $ct_urlParts['host']);
			                } ?>
			                <?php if(!empty($ct_domain)) { ?>
			                	<li id="website" class="row"><span class="muted left"><?php ct_globe_svg(); ?></span> <span class="right"><a href="<?php echo esc_html($curauth->user_url); ?>"><?php echo esc_html($ct_domain); ?></a></span></li>
		                	<?php } ?>
		                	<?php if($curauth->agentlicense) { ?><li class="row"><span class="muted left">Agent #</span> <span class="right"><?php echo esc_html($curauth->agentlicense); ?></span></li><?php } ?>
		                	<?php if($curauth->brokeragelicense) { ?><li class="row"><span class="muted left">Brokerage #</span> <span class="right"><?php echo esc_html($curauth->brokeragelicense); ?></span></li><?php } ?>
		            	</ul>

						<?php if($curauth->address) { ?>
		            	<h6 class="muted"><?php _e('Address', 'contempo'); ?></h6>
	            		<p>
	            			<?php echo esc_html($curauth->address); ?><br />
	            			<?php echo esc_html($curauth->city); ?>, <?php echo esc_html($curauth->state); ?> <?php echo esc_html($curauth->postalcode); ?>
	            		</p>
		            	<?php } ?>

		            	<?php if($curauth->twitterhandle || $curauth->facebookurl || $curauth->instagramurl || $curauth->linkedinurl || $curauth->gplus || $curauth->youtubeurl) { ?>
		            	<h6 class="muted marT20"><?php _e('Social', 'contempo'); ?></h6>
	                	<ul class="social marT20 marL0">
                            <?php if ($curauth->twitterhandle) { ?><li class="twitter"><a href="https://twitter.com/#!/<?php echo esc_html($curauth->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                            <?php if ($curauth->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($curauth->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                            <?php if ($curauth->instagramurl) { ?><li class="instagram"><a href="<?php echo esc_url($curauth->instagramurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
                            <?php if ($curauth->linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($curauth->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                            <?php if ($curauth->youtubeurl) { ?><li class="youtube"><a href="<?php echo esc_url($curauth->youtubeurl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
                        </ul>
                        <?php } ?>

	                </div>

				</div>
				<!-- //Agent Sidebar -->

				<!-- Agent Listings -->
				<div class="col span_9">

					<?php do_action('before_agent_listings'); ?>

					<!-- Listings -->
					<?php
						if($ct_agent_single_listings != 'yes') {
			                $ID = $curauth->ID;
			                $ct_agent_name = $curauth->display_name;

			                $current_page = get_query_var('paged') ? (int) get_query_var('paged') : 1;

			                if(class_exists('IDX')) {
			                	if($ct_agent_single_listings_hide_solds == 'yes') {
			                		$args = array(
					                    'post_type' => 'listings',
										'posts_per_page' => $ct_agents_listings_per_page,
										'paged' => $current_page,
										'meta_query' => array(
											array(
										        'key' => '_ct_agent_name',
										        'value' => $ct_agent_name,
										    	'type' => 'char',
												'compare' => 'LIKE'
										    ),
										),
										'tax_query' => array(
											'relation' => 'AND',
											array(
											    'taxonomy'  => 'ct_status',
											    'field'     => 'slug',
											    'terms'     => 'sold',
											    'operator'  => 'NOT IN'
										    ),
										    array(
											    'taxonomy'  => 'ct_status',
											    'field'     => 'slug',
											    'terms'     => 'ghost',
											    'operator'  => 'NOT IN'
										    ),
									    ),
					                    //'author' => $ID
					                );
			                	} else {
			                		$args = array(
					                    'post_type' => 'listings',
										'posts_per_page' => $ct_agents_listings_per_page,
										'paged' => $current_page,
										'meta_query' => array(
											array(
										        'key' => '_ct_agent_name',
										        'value' => $ct_agent_name,
										    	'type' => 'char',
												'compare' => 'LIKE'
										    ),
										),
										'tax_query' => array(
											array(
											    'taxonomy'  => 'ct_status',
											    'field'     => 'slug',
											    'terms'     => 'ghost',
											    'operator'  => 'NOT IN'
										    ),
									    ),
					                    //'author' => $ID
					                );
			                	}
				                
				            } else {
				            	if($ct_agent_single_listings_hide_solds == 'yes') {
				            		$args = array(
					                    'post_type' => 'listings',
										'posts_per_page' => $ct_agents_listings_per_page,
										'paged' => $current_page,
										'tax_query' => array(
											'relation' => 'AND',
											array(
											    'taxonomy'  => 'ct_status',
											    'field'     => 'slug',
											    'terms'     => 'sold',
											    'operator'  => 'NOT IN'
										    ),
										    array(
											    'taxonomy'  => 'ct_status',
											    'field'     => 'slug',
											    'terms'     => 'ghost',
											    'operator'  => 'NOT IN'
										    ),
									    ),
					                    'author' => $ID
					                );
				            	} else {
				            		$args = array(
					                    'post_type' => 'listings',
										'posts_per_page' => $ct_agents_listings_per_page,
										'paged' => $current_page,
										'tax_query' => array(
											array(
											    'taxonomy'  => 'ct_status',
											    'field'     => 'slug',
											    'terms'     => 'ghost',
											    'operator'  => 'NOT IN'
										    ),
									    ),
					                    'author' => $ID
					                );
				            	}
				            	
				            }
							query_posts($args); 
							?>

							<?php if ( $wp_query->max_num_pages <= 1 ) { ?>
							<form id="agent-listing-live-search" action="" method="post">
					            <fieldset>
					                <input type="text" class="text-input" id="agent-listing-filter" value="" placeholder="<?php _e('Type a listing address or keyword to filter the list.', 'contempo'); ?>" />
					            </fieldset>
					        </form>
					        <?php } ?>

					        <script>
					            jQuery(document).ready(function($){
					                $("#agent-listing-filter").keyup(function(){

					                    var filter = $(this).val(), count = 0;

					                    $(".agent-listings li.listing").each(function(){
					                        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
					                            $(this).fadeOut();
					                        } else {
					                            $(this).show();
					                            count++;
					                        }
					                    });
					                    $(".agent-listings div.clear" ).remove();
					                    $(".agent-listings li.listing" ).removeClass("first");
					                    $(".agent-listings li.listing:nth-child(3)").addClass("first");
					                    //$(".agent-listings li.listing:nth-child(3)").after("<div class='clear'></div>");
					                    var numberItems = count;
					                });
					            });
					        </script>

							<?php

							echo '<ul class="agent-listings marB0">';

								get_template_part( 'layouts/grid');

							echo '</ul>';
						}
		            ?>
		            <!-- //Listings -->

		            <?php do_action('after_agent_listings'); ?>

				</div>
				<!-- //Agent Listings -->

			<?php } else { ?>

				<!-- Agent -->
				<div class="agent marT20 marB40">

	                <figure class="col span_3 first">
	                	<?php if($curauth->ct_profile_url) { ?>
		                    <img class="author-img" src="<?php echo esc_html($curauth->ct_profile_url); ?>" />
	                    <?php } else { ?>
		                    <img class="author-img" src="<?php echo get_template_directory_uri() . '/images/user-default.png'; ?>" />
	                    <?php } ?>
	                </figure>

		             <div class="agent-info col span_9">
		                <h3><?php echo esc_html($curauth->display_name); ?></h3>
		                <?php if ($curauth->title) { ?><h5 class="muted position"><?php echo esc_html($curauth->title); ?></h5><?php } ?>

		                <div class="agent-bio col span_8 first">
		                	<p><?php if($curauth->tagline) { ?><strong class="tagline"><?php echo esc_html($curauth->tagline); ?></strong> <?php } ?><?php $bio = $curauth->description; echo nl2br($bio); ?></p>
		                	<ul class="social marT20 marL0">
	                            <?php if ($curauth->twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_html($curauth->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
	                            <?php if ($curauth->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($curauth->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
	                            <?php if ($curauth->instagramurl) { ?><li class="instagram"><a href="<?php echo esc_url($curauth->instagramurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
	                            <?php if ($curauth->linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($curauth->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
	                            <?php if ($curauth->youtubeurl) { ?><li class="youtube"><a href="<?php echo esc_url($curauth->youtubeurl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
	                        </ul>
		                </div>

		                <?php if($brokerage_id != '') { ?>
		                	<figure class="col span_4 first broker-logo">
				                <?php ct_brokerage_logo($brokerage_id); ?>
			                </figure>
		                <?php } elseif($curauth->ct_broker_logo) { ?>
							<figure class="col span_4 first broker-logo">
							    <img src="<?php echo esc_html($curauth->ct_broker_logo); ?>" />
							</figure>
						<?php } elseif($curauth->brokerage) { ?>
							<div class="col span_4 first broker-logo">
							    <h6><?php echo esc_html($curauth->brokerage); ?></h6>
							</div>
						<?php } ?>

		                 <ul class="col span_4">
			                <?php if($curauth->mobile) { ?><li id="mobile" class="row"><span class="muted left"><?php ct_phone_svg(); ?></span> <span class="right"><a href="tel:<?php echo esc_html($curauth->mobile); ?>"><?php echo esc_html($curauth->mobile); ?></a></span></li><?php } ?>
			                <?php if($curauth->office) { ?><li id="office" class="row"><span class="muted left"><?php ct_office_svg(); ?></span> <span class="right"><a href="tel:<?php echo esc_html($curauth->office); ?>"><?php echo esc_html($curauth->office); ?></a></span></li><?php } ?>
			                <?php if($curauth->fax) { ?><li id="fax" class="row"><span class="muted left"><?php ct_printer_svg(); ?></span> <span class="right"><a href="tel:<?php echo esc_html($curauth->fax); ?>"><?php echo esc_html($curauth->fax); ?></a></span></li><?php } ?>
			                <?php if($curauth->user_email) { $email = $curauth->user_email; ?><li id="email" class="row"><span class="muted left"><?php ct_envelope_svg(); ?></span> <span class="right"><a class="agent-contact" href="#"><?php esc_html_e('Email', 'contempo'); ?></a
			                ></span></li><?php } ?>
			                <?php if($curauth->user_url) {
			                	$ct_user_url = $curauth->user_url;
			                	$ct_user_url = trim($ct_user_url, '/');
			                	// If scheme not included, prepend it
								if (!preg_match('#^http(s)?://#', $ct_user_url)) {
								    $ct_user_url = 'http://' . $ct_user_url;
								}

								$ct_urlParts = parse_url($ct_user_url);

								// remove www
								$ct_domain = preg_replace('/^www\./', '', $ct_urlParts['host']);
			                ?>
			                	<li id="website" class="row"><span class="muted left"><?php ct_globe_svg(); ?></span> <span class="right"><a href="<?php echo esc_html($curauth->user_url); ?>"><?php echo esc_html($ct_domain); ?></a></span></li>
			                	<?php if($curauth->agentlicense) { ?><li class="row"><span class="muted left">Agent #</span> <span class="right"><?php echo esc_html($curauth->agentlicense); ?></span></li><?php } ?>
			                	<?php if($curauth->brokeragelicense) { ?><li class="row"><span class="muted left">Brokerage #</span> <span class="right"><?php echo esc_html($curauth->brokeragelicense); ?></span></li><?php } ?>
			                <?php } ?>
		            	</ul>
		            </div>
		        </div>
		        <!-- //Agent -->
	            
			        <div class="clear"></div>
			        
			    <?php
			    if($curauth->userTestimonial != '') {
			    	echo '<div id="agent-testimonials" class="marB20">';
			    		echo '<div class="inner-content">';
		                	echo stripslashes($curauth->userTestimonial);
		                echo '</div>';
			    	echo '</div>';
			    } ?>

		        <?php do_action('before_agent_listings'); ?>

				<!-- Listings -->
				<?php
					if($ct_agent_single_listings != 'yes') {
		                $ID = $curauth->ID;
		                $ct_agent_name = $curauth->display_name;
		                
		                if(class_exists('IDX')) {
		                	if($ct_agent_single_listings_hide_solds == 'yes') {
		                		$args = array(
				                    'post_type' => 'listings',
									'posts_per_page' => $ct_agents_listings_per_page,
									'paged' => $current_page,
									'meta_query' => array(
										array(
									        'key' => '_ct_agent_name',
									        'value' => $ct_agent_name,
									    	'type' => 'char',
											'compare' => 'LIKE'
									    ),
									),
									'tax_query' => array(
										'relation' => 'AND',
										array(
										    'taxonomy'  => 'ct_status',
										    'field'     => 'slug',
										    'terms'     => 'sold',
										    'operator'  => 'NOT IN'
									    ),
									    array(
										    'taxonomy'  => 'ct_status',
										    'field'     => 'slug',
										    'terms'     => 'ghost',
										    'operator'  => 'NOT IN'
									    ),
								    ),
				                    //'author' => $ID
				                );
		                	} else {
		                		$args = array(
				                    'post_type' => 'listings',
									'posts_per_page' => $ct_agents_listings_per_page,
									'paged' => $current_page,
									'meta_query' => array(
										array(
									        'key' => '_ct_agent_name',
									        'value' => $ct_agent_name,
									    	'type' => 'char',
											'compare' => 'LIKE'
									    ),
									),
									'tax_query' => array(
										array(
										    'taxonomy'  => 'ct_status',
										    'field'     => 'slug',
										    'terms'     => 'ghost',
										    'operator'  => 'NOT IN'
									    ),
								    ),
				                    //'author' => $ID
				                );
		                	}
			                
			            } else {
			            	if($ct_agent_single_listings_hide_solds == 'yes') {
			            		$args = array(
				                    'post_type' => 'listings',
									'posts_per_page' => $ct_agents_listings_per_page,
									'paged' => $current_page,
									'tax_query' => array(
										'relation' => 'AND',
										array(
										    'taxonomy'  => 'ct_status',
										    'field'     => 'slug',
										    'terms'     => 'sold',
										    'operator'  => 'NOT IN'
									    ),
									    array(
										    'taxonomy'  => 'ct_status',
										    'field'     => 'slug',
										    'terms'     => 'ghost',
										    'operator'  => 'NOT IN'
									    ),
								    ),
				                    'author' => $ID
				                );
			            	} else {
			            		$args = array(
				                    'post_type' => 'listings',
									'posts_per_page' => $ct_agents_listings_per_page,
									'paged' => $current_page,
									'tax_query' => array(
										array(
										    'taxonomy'  => 'ct_status',
										    'field'     => 'slug',
										    'terms'     => 'ghost',
										    'operator'  => 'NOT IN'
									    ),
								    ),
				                    'author' => $ID
				                );
			            	}
			            	
			            }
						query_posts($args); ?>

						<form id="agent-listing-live-search" action="" method="post">
				            <fieldset>
				                <input type="text" class="text-input" id="agent-listing-filter" value="" placeholder="<?php _e('Type a listing address or keyword to filter the list.', 'contempo'); ?>" />
				            </fieldset>
				        </form>

				        <script>
				            jQuery(document).ready(function($){
				                $("#agent-listing-filter").keyup(function(){

				                    var filter = $(this).val(), count = 0;

				                    $(".agent-listings li.listing").each(function(){
				                        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
				                            $(this).fadeOut();
				                        } else {
				                            $(this).show();
				                            count++;
				                        }
				                    });
				                    $(".agent-listings div.clear" ).remove();
				                    $(".agent-listings li.listing" ).removeClass("first");
				                    $(".agent-listings li.listing:nth-child(3)").addClass("first");
				                    //$(".agent-listings li.listing:nth-child(3)").after("<div class='clear'></div>");
				                    var numberItems = count;
				                });
				            });
				        </script>

						<?php

						echo '<ul class="agent-listings marB0">';

							get_template_part( 'layouts/grid');

						echo '</ul>';
					}
	            ?>
	            <!-- //Listings -->

	            <?php do_action('after_agent_listings'); ?>

			</div>
			
			<div class="clear"></div>

		<?php } ?>
        
</div>

<?php get_footer(); ?>