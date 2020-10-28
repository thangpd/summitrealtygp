<?php
/**
 * Template Name: Agents
 *
 * @package WP Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$ct_agent_layout = isset( $ct_options['ct_agent_layout'] ) ? $ct_options['ct_agent_layout'] : '';
$ct_agents_search = isset( $ct_options['ct_agents_search'] ) ? $ct_options['ct_agents_search'] : '';
$ct_agents_per_page = isset( $ct_options['ct_agents_per_page'] ) ? $ct_options['ct_agents_per_page'] : '-1';

$ct_enable_zapier_webhooks = isset( $ct_options['ct_enable_zapier_webhooks'] ) ? $ct_options['ct_enable_zapier_webhooks'] : '';
$ct_zapier_webhook_url = isset( $ct_options['ct_zapier_webhook_url'] ) ? $ct_options['ct_zapier_webhook_url'] : '';
$ct_zapier_webhook_agent_contact_form = isset( $ct_options['ct_zapier_webhook_agent_contact_form'] ) ? $ct_options['ct_zapier_webhook_agent_contact_form'] : '';

$count = 1;
$no = '';
$offset = '';

$states = array( 'AL'=>'Alabama', 'AK'=>'Alaska', 'AZ'=>'Arizona', 'AR'=>'Arkansas', 'CA'=>'California', 'CO'=>'Colorado', 'CT'=>'Connecticut', 'DE'=>'Delaware', 'DC'=>'District of Columbia', 'FL'=>'Florida', 'GA'=>'Georgia', 'HI'=>'Hawaii', 'ID'=>'Idaho', 'IL'=>'Illinois', 'IN'=>'Indiana', 'IA'=>'Iowa', 'KS'=>'Kansas', 'KY'=>'Kentucky', 'LA'=>'Louisiana', 'ME'=>'Maine', 'MD'=>'Maryland', 'MA'=>'Massachusetts', 'MI'=>'Michigan', 'MN'=>'Minnesota', 'MS'=>'Mississippi', 'MO'=>'Missouri', 'MT'=>'Montana', 'NE'=>'Nebraska', 'NV'=>'Nevada', 'NH'=>'New Hampshire', 'NJ'=>'New Jersey', 'NM'=>'New Mexico', 'NY'=>'New York', 'NC'=>'North Carolina', 'ND'=>'North Dakota', 'OH'=>'Ohio', 'OK'=>'Oklahoma', 'OR'=>'Oregon', 'PA'=>'Pennsylvania', 'RI'=>'Rhode Island', 'SC'=>'South Carolina', 'SD'=>'South Dakota', 'TN'=>'Tennessee', 'TX'=>'Texas', 'UT'=>'Utah', 'VT'=>'Vermont', 'VA'=>'Virginia', 'WA'=>'Washington', 'WV'=>'West Virginia', 'WI'=>'Wisconsin', 'WY'=>'Wyoming', );

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

if($inside_page_title == "Yes") { 
    // Custom Page Header Background Image
    if(get_post_meta($post->ID, '_ct_page_header_bg_image', true) != '') {
        echo'<style type="text/css">';
        echo '#single-header { background: url(';
        echo get_post_meta($post->ID, '_ct_page_header_bg_image', true);
        echo ') no-repeat center center; background-size: cover;}';
        echo '</style>';
    } ?>

    <!-- Single Header -->
    <div id="single-header">
        <div class="dark-overlay">
            <div class="container">
                <h1 class="marT0 marB0"><?php the_title(); ?></h1>
                <?php if(get_post_meta($post->ID, '_ct_page_sub_title', true) != '') { ?>
                    <h2 class="marT0 marB0"><?php echo get_post_meta($post->ID, "_ct_page_sub_title", true); ?></h2>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- //Single Header -->
<?php } ?>

<div id="page-content" class="container marT60 padB60">

    <article class="col span_12">
        
        <?php the_content(); ?>

        <?php if($ct_agents_search == 'yes') { 

            $ct_agents_search_fields = isset( $ct_options['ct_agents_search_fields']['enabled'] ) ? $ct_options['ct_agents_search_fields']['enabled'] : '';
            $ct_city = ( isset($_GET["city"]) ) ? sanitize_text_field($_GET["city"]) : false;
            $ct_state = ( isset($_GET["state"]) ) ? sanitize_text_field($_GET["state"]) : false;
            $ct_zipcode = ( isset($_GET["zipcode"]) ) ? sanitize_text_field($_GET["zipcode"]) : false;
            //$ct_keyword = ( isset($_GET["keyword"]) ) ? sanitize_text_field($_GET["keyword"]) : false ;
            $ct_brokers_search = ( isset($_GET["ct-brokers-search"]) ) ? sanitize_text_field($_GET["ct-brokers-search"]) : false ;

        ?>

            <form id="agent-search" method="get" action="<?php the_permalink() ?>">
                <?php
    
                if ($ct_agents_search_fields) :
                
                    foreach ($ct_agents_search_fields as $field=>$value) {
                    
                        switch($field) {
                            
                            // State            
                            case 'state' : ?>
                                <div id="state" class="col <?php ct_agents_search_fields_span(); ?> <?php ct_agents_search_fields_first(); ?>">
                                    <select name="state">
                                        <option value=""><?php _e('Select a State', 'contempo'); ?></option>
                                        <?php foreach($states as $key => $value) { ?>
                                            <option value="<?php echo esc_html($key); ?>" title="<?php echo htmlspecialchars($value); ?>" <?php if($ct_state == $key) { echo 'selected'; } ?>><?php echo htmlspecialchars($value); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php
                            break;

                            // City            
                            case 'city' : ?>
                                <div class="col <?php ct_agents_search_fields_span(); ?> <?php ct_agents_search_fields_first(); ?>">
                                    <input type="text" name="city" id="city" placeholder="<?php _e('City', 'contempo'); ?>" <?php if($ct_city != '') { echo 'value="' . $ct_city . '"'; } ?> />
                                </div>
                            <?php
                            break;

                            // Zipcode      
                            case 'zipcode' : ?>
                                <div class="col <?php ct_agents_search_fields_span(); ?> <?php ct_agents_search_fields_first(); ?>">
                                    <input type="text" name="zipcode" placeholder="<?php _e('Zipcode', 'contempo'); ?>" <?php if($ct_zipcode != '') { echo 'value="' . $ct_zipcode . '"'; } ?> />
                                </div>
                            <?php
                            break;

                            /* Keyword            
                            case 'keyword' : ?>
                                <div class="col <?php ct_agents_search_fields_span(); ?> <?php ct_agents_search_fields_first(); ?>">
                                    <input type="text" name="keyword" placeholder="<?php _e('Keyword (optional)', 'contempo'); ?>" <?php if($ct_keyword != '') { echo 'value="' . $ct_keyword . '"'; } ?> />
                                </div>
                            <?php
                            break;*/

                        }
    
                    }

                endif; ?>
               
                <input type="hidden" name="ct-brokers-search" value="true" />
                <div class="col <?php ct_agents_search_button_span(); ?>">
                    <input type="submit" name="submit" value="<?php _e('Search Agents', 'contempo'); ?>" />
                </div>
                    <div class="clear"></div>
            </form>

        <?php } ?>

        <?php if(!empty($ct_brokers_search)) { ?>
            <form id="agent-live-search" action="" method="post">
                <fieldset>
                    <input type="text" class="text-input" id="agent-filter" value="" placeholder="<?php _e('Type an agents name, title, business, phone or lic # here to filter the list.', 'contempo'); ?>" />
                </fieldset>
            </form>

            <script>
                jQuery(document).ready(function($){
                    $("#agent-filter").keyup(function(){

                        var filter = $(this).val(), count = 0;

                        $(".agents-list li.agent").each(function(){
                            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                                $(this).fadeOut();
                            } else {
                                $(this).show();
                                count++;
                            }
                        });
                        var numberItems = count;
                    });
                });
            </script>
        <?php } elseif($ct_agents_search == 'no') { ?>
            <form id="agent-live-search" action="" method="post">
                <fieldset>
                    <input type="text" class="text-input" id="agent-filter" value="" placeholder="<?php _e('Type an agents name, title, business, phone or lic # here to filter the list.', 'contempo'); ?>" />
                </fieldset>
            </form>

            <script>
                jQuery(document).ready(function($){
                    $("#agent-filter").keyup(function(){

                        var filter = $(this).val(), count = 0;

                        $(".agents-list li.agent").each(function(){
                            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                                $(this).fadeOut();
                            } else {
                                $(this).show();
                                count++;
                            }
                        });
                        var numberItems = count;
                    });
                });
            </script>
        <?php } ?>

        <ul class="agents-list">
            <?php

            $current_page = get_query_var('paged') ? (int) get_query_var('paged') : 1;
            $ct_agents_search_roles = isset( $ct_options['ct_agents_search_roles'] ) ? $ct_options['ct_agents_search_roles'] : 'agent';

            if(!empty($ct_brokers_search)) {
                $args = array();

                $args['role__in'] = $ct_agents_search_roles;
                $args['order'] = 'ASC';
                $args['orderby'] = 'display_name';

                $args['meta_query'] = array('relation' => 'AND');

                if(!empty($_GET['city'])) {  
                    array_push( $args['meta_query'], array(
                        array(
                            'key'      => 'city',
                            'value'    => $ct_city,
                            'compare'  => '=' 
                        )
                    ));
                } 

                if(!empty($_GET['state'])) {  
                    array_push( $args['meta_query'], array(
                        array(
                            'key'      => 'state',
                            'value'    => $ct_state,
                            'compare'  => '='
                        )
                    ));
                } 

                if(!empty($_GET['zipcode'])) {  
                    array_push( $args['meta_query'], array(
                        array(
                            'key'      => 'postalcode',
                            'value'    => $ct_zipcode,
                            'compare'  => '='
                        )
                    ));
                } 
            } else {
                if($ct_options['ct_agents_ordering'] == 'yes') {
                    $args = array(
                        'orderby'   => 'meta_value_num',
                        'meta_key'  => 'agentorder',
                        'order'     => 'ASC',
                        'number' => $no,
                        'offset' => $offset
                    );
                } else {
                    $args = array(
                        'meta_key'      => 'isagent',
                        'meta_value'    => 'yes',
                        'role__in'      => array('agent', 'broker', 'administrator', 'editor', 'author', 'contributor'),
                        'orderby'       => 'post_count',
                        'order'         => 'DESC',
                        'number'        => $ct_agents_per_page,
                        'paged'         => $current_page
                    );
                }
            }

            //echo '<pre>';
            //print_r($args);
            //echo '</pre>';

            $agent_query = new WP_User_Query($args);

            $total_agents = $agent_query->get_total();
            $num_pages = ceil($total_agents / $ct_agents_per_page);

            if (!empty($agent_query->results)) { ?>

                <?php

                foreach ($agent_query->results as $agent) :

                    $curauth = get_userdata($agent->ID);
                    $author_id = get_the_author_meta('ID');
                    $user_link = get_author_posts_url($curauth->ID);
                    $email = $curauth->user_email;
            
                    if($curauth->user_level >= 0) : ?>   

                        <?php if($curauth->user_email) { ?>

                            <script>    
                                jQuery(document).ready(function() {
                                    jQuery(".contact-form-<?php echo esc_html(strtolower($curauth->last_name)); ?>").validationEngine({
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
                            <div id="overlay" class="contact-modal-<?php echo esc_html($curauth->ID); ?> agent-modal">
                                <div id="modal">
                                    <div id="modal-inner">
                                        <a href="#" class="close"><i class="fa fa-close"></i></a>
                                        <form id="listingscontact" class="contact-form-<?php echo esc_html(strtolower($curauth->last_name)); ?> formular" method="post">
                                            <fieldset class="col span_12">
                                                <select id="ctsubject" name="ctsubject">
                                                    <option><?php esc_html_e('Tell me more about a property', 'contempo'); ?></option>
                                                    <option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
                                                    <option><?php esc_html_e('General Questions', 'contempo'); ?></option>
                                                </select>
                                                    <div class="clear"></div>
                                                <input type="text" name="name" id="name" class="validate[required] text-input" placeholder="<?php esc_html_e('Name', 'contempo'); ?>" <?php if(is_user_logged_in()) { echo 'value="' . $current_user->user_firstname . ' ' . $current_user->user_lastname . '"'; } ?> />

                                                <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" placeholder="<?php esc_html_e('Email', 'contempo'); ?>" <?php if(is_user_logged_in()) { echo 'value="' . $current_user->user_email . '"'; } ?> />

                                                <input type="text" name="ctphone" id="ctphone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" <?php if(is_user_logged_in()) { echo 'value="' . $current_user->mobile . '"'; } ?> />

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

                        <!-- Agent -->
                        <li id="<?php echo esc_html(strtolower($curauth->first_name)) . '-' . esc_html(strtolower($curauth->last_name)); ?>" class="agent <?php echo esc_html($ct_agent_layout); ?> <?php if($ct_agent_layout == 'agent-grid') { echo 'col span_3'; } ?>">
                            <figure class="col <?php if($ct_agent_layout == 'agent-grid') { echo 'span_12'; } else { echo 'span_3'; } ?> first">
                                <a href="<?php echo get_author_posts_url($curauth->ID); ?>" title="<?php echo esc_html($curauth->display_name); ?>">
                                    <?php if($curauth->ct_profile_url) { ?>
                                        <img class="author-img" src="<?php echo esc_html($curauth->ct_profile_url); ?>" />
                                    <?php } else { ?>
                                        <img class="author-img" src="<?php echo get_template_directory_uri() . '/images/user-default.png'; ?>" />
                                    <?php } ?>
                                </a>
                            </figure>
                            <div class="agent-info col <?php if($ct_agent_layout == 'agent-grid') { echo 'span_12'; } else { echo 'span_9'; } ?>">
                                <header>
                                    <?php if($ct_agent_layout == 'agent-grid') { echo '<h4>'; } else { echo '<h3>'; } ?><a href="<?php echo get_author_posts_url($curauth->ID); ?>" title="<?php echo esc_html($curauth->display_name); ?>"><?php echo esc_html($curauth->display_name); ?></a><?php if($ct_agent_layout == 'agent-grid') { echo '</h4>'; } else { echo '</h3>'; } ?>
                                    <?php if($curauth->city) { ?><h5 class="muted position marT5 marB5">Serving the <?php echo esc_html($curauth->city); ?> Area</h5><?php } ?>
                                    <?php if($curauth->company_name) { ?><p class="company-name"><strong><?php echo esc_html($curauth->company_name); ?></strong></p><?php } ?>
                                </header>

                                <?php if($ct_agent_layout != 'agent-grid') { ?>
                                <div class="agent-bio col span_8 first">
                                    <p class="marT20"><?php if($curauth->tagline) { ?><strong class="tagline"><?php echo esc_html($curauth->tagline); ?></strong> <?php } ?><?php $bio = $curauth->description; echo nl2br($bio); ?></p>
                                    <div class="col span_6 first">
                                        <?php if($curauth->brokeragelicense) { ?><p class="marT10 marB0"><span class="muted left"><?php _e('Broker#', 'contempo'); ?></span> <span class="right"><?php echo esc_html($curauth->brokeragelicense); ?></span></p><?php } ?>
                                        <?php if($curauth->agentlicense) { ?><p class="marT10 marB0"><span class="muted left"><?php _e('License#', 'contempo'); ?></span> <span class="right"><?php echo esc_html($curauth->agentlicense); ?></span></p><?php } ?>
                                    </div>
                                        <div class="clear"></div>
                                    <ul class="social marT20 marL0">
                                        <?php if ($curauth->twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_html($curauth->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                        <?php if ($curauth->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_html($curauth->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                        <?php if ($curauth->instagramurl) { ?><li class="instagram"><a href="<?php echo esc_url($curauth->instagramurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
                                        <?php if ($curauth->linkedinurl) { ?><li class="linkedin"><a href="<?php echo esc_html($curauth->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                        <?php if ($curauth->gplus) { ?><li class="google"><a href="<?php echo esc_html($curauth->gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                                        <?php if ($curauth->youtubeurl) { ?><li class="youtube"><a href="<?php echo esc_url($curauth->youtubeurl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
                                    </ul>
                                </div>
                                <?php } ?>

                                <script>
                                jQuery(document).ready(function() {
                                    jQuery(".agent-contact-<?php echo esc_html($curauth->ID); ?>").click(function() {
                                        jQuery("#overlay.contact-modal-<?php echo esc_html($curauth->ID); ?>").addClass('open');
                                    });

                                    jQuery(".close").click(function() {
                                        jQuery("#overlay.contact-modal-<?php echo esc_html($curauth->ID); ?>").removeClass('open');
                                        jQuery(".formError").hide();
                                    });
                                });
                                </script>

                                <ul class="agent-info col <?php if($ct_agent_layout == 'agent-grid') { echo 'span_12'; } else { echo 'span_4'; } ?>">
                                    <?php if($curauth->mobile) { ?><li class="row"><span class="muted left"><?php ct_phone_svg(); ?></span> <span class="right"><a href="tel:<?php echo esc_html($curauth->mobile); ?>"><?php echo esc_html($curauth->mobile); ?></a></span></li><?php } ?>
                                    <?php if($curauth->office) { ?><li class="row"><span class="muted left"><?php ct_office_svg(); ?></span> <span class="right"><a href="tel:<?php echo esc_html($curauth->office); ?>"><?php echo esc_html($curauth->office); ?></a></span></li><?php } ?>
                                    <?php if($curauth->fax) { ?><li class="row"><span class="muted left"><?php ct_printer_svg(); ?></span> <span class="right"><a href="tel:<?php echo esc_html($curauth->fax); ?>"><?php echo esc_html($curauth->fax); ?></a></span></li><?php } ?>
                                    <?php if($curauth->user_email) { $email = $curauth->user_email; ?><li id="email-agent" class="row"><span class="muted left"><?php ct_envelope_svg(); ?></span> <span class="right"><a class="agent-contact-<?php echo esc_html($curauth->ID); ?>" href="#"><?php echo esc_html($email); ?></a></span></li><?php } ?>
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
                                        <li class="row"><span class="muted left"><?php ct_globe_svg(); ?></span> <span class="right"><a href="<?php echo esc_html($curauth->user_url); ?>"><?php echo esc_html($ct_domain); ?></a></span></li>
                                    <?php } ?>
                                    <?php if($curauth->brokername) { ?><p class="marB3"><strong><?php echo esc_html($curauth->brokername); ?></strong></p><?php } ?>
                                    <?php if($curauth->brokernum) { ?><p class="marB3"><?php echo esc_html($curauth->brokernum); ?></p><?php } ?>
                                    
                                </ul>
                                    <div class="clear"></div>

                                <?php if($ct_agent_layout == 'agent-grid') { ?>
                                <div class="agent-bio col span_12 first">
                                    <ul class="social marT20 marL0">
                                        <?php if ($curauth->twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_html($curauth->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                        <?php if ($curauth->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_html($curauth->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                        <?php if ($curauth->instagramurl) { ?><li class="instagram"><a href="<?php echo esc_url($curauth->instagramurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
                                        <?php if ($curauth->linkedinurl) { ?><li class="linkedin"><a href="<?php echo esc_html($curauth->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                        <?php if ($curauth->gplus) { ?><li class="google"><a href="<?php echo esc_html($curauth->gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                                        <?php if ($curauth->youtubeurl) { ?><li class="youtube"><a href="<?php echo esc_url($curauth->youtubeurl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
                                    </ul>
                                </div>
                                <?php } ?>

                                <?php if($ct_agent_layout != 'agent-grid') { ?>
                                <div class="view-listings">
                                    <a class="btn btn-secondary" href="<?php echo get_author_posts_url($curauth->ID); ?>"><?php esc_html_e('View Profile', 'contempo'); ?></a>
                                </div>
                                <?php } ?>
                            </div>
                                <div class="clear"></div>
                        </li>
                        <!-- //Agent --> 

                        <?php if($ct_agent_layout == 'agent-grid' && $count % 4 == 0) {
                            echo '<div class="clear"></div>';
                        } ?>
                    
                    <?php $count++; endif; ?>

                <?php endforeach; ?>

                <?php if($num_pages > 1) { ?>
                        <div class="clear"></div>

                    <p id="brokers-pagination">
                        <?php
                            if($current_page > 1) {
                                echo '<a class="btn left" href="'. add_query_arg(array('paged' => $current_page-1)) .'">' . __('Previous Page', 'contempo') . '</a>';
                            }

                            if($current_page < $num_pages) {
                                echo '<a class="btn right" href="'. add_query_arg(array('paged' => $current_page+1)) .'">' . __('Next Page', 'contempo') . '</a>';
                            }
                        ?>
                    </p>
                <?php } ?>

            <?php } else { ?>

                <p class="nomatches"><?php _e('No Agents Found.', 'contempo'); ?></p>
            
            <?php } ?>
        </ul>
        
        <?php endwhile; ?>

    <?php endif; ?>
        
            <div class="clear"></div>

    </article>

        <div class="clear"></div>

</div>

<?php get_footer(); ?>