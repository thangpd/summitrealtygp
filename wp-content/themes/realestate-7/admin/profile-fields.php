<?php
/**
 * Profile Fields
 *
 * @package WP Pro Real Estate 7
 * @subpackage Admin
 */

global $ct_options;

if(!function_exists('ct_add_multipart')) {                
    function ct_add_multipart() {
    	echo 'enctype="multipart/form-data"';
    }
}                      
add_action('user_edit_form_tag', 'ct_add_multipart');

/*-----------------------------------------------------------------------------------*/
/* Add Extra Profile Fields */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_extra_user_profile_fields')) {
    function ct_extra_user_profile_fields($user) {

        global $ct_options;

        $current_user = wp_get_current_user();

        $ct_agents_assign = isset( $ct_options['ct_agents_assign'] ) ? esc_attr( $ct_options['ct_agents_assign'] ) : '';

        $ct_social_profile_info = isset( $ct_options['ct_social_profile_info'] ) ? esc_attr( $ct_options['ct_social_profile_info'] ) : '';
        $ct_extra_profile_info = isset( $ct_options['ct_extra_profile_info'] ) ? esc_attr( $ct_options['ct_extra_profile_info'] ) : '';
        $ct_agent_testimonials = isset( $ct_options['ct_agent_testimonials'] ) ? esc_attr( $ct_options['ct_agent_testimonials'] ) : '';
        $ct_office_information = isset( $ct_options['ct_office_information'] ) ? esc_attr( $ct_options['ct_office_information'] ) : '';
        $ct_profile_state_select = isset( $ct_options['ct_profile_state_select'] ) ? esc_attr( $ct_options['ct_profile_state_select'] ) : '';

        $ct_user_state = get_the_author_meta('state', $user->ID);

        $states = array( 'AL'=>'AL', 'AK'=>'AK', 'AZ'=>'AZ', 'AR'=>'AR', 'CA'=>'CA', 'CO'=>'CO', 'CT'=>'CT', 'DE'=>'DE', 'DC'=>'DC', 'FL'=>'FL', 'GA'=>'GA', 'HI'=>'HI', 'ID'=>'ID', 'IL'=>'IL', 'IN'=>'IN', 'IA'=>'IA', 'KS'=>'KS', 'KY'=>'KY', 'LA'=>'LA', 'ME'=>'ME', 'MD'=>'MD', 'MA'=>'MA', 'MI'=>'MI', 'MN'=>'MN', 'MS'=>'MS', 'MO'=>'MO', 'MT'=>'MT', 'NE'=>'NE', 'NV'=>'NV', 'NH'=>'NH', 'NJ'=>'NJ', 'NM'=>'NM', 'NY'=>'NY', 'NC'=>'NC', 'ND'=>'ND', 'OH'=>'OH', 'OK'=>'OK', 'OR'=>'OR', 'PA'=>'PA', 'RI'=>'RI', 'SC'=>'SC', 'SD'=>'SD', 'TN'=>'TN', 'TX'=>'TX', 'UT'=>'UT', 'VT'=>'VT', 'VA'=>'VA', 'WA'=>'WA', 'WV'=>'WV', 'WI'=>'WI', 'WY'=>'WY', );

        ?>

        <?php if($ct_social_profile_info != 'no') { ?>
            <h3><?php esc_html_e("Social profile information", "contempo"); ?></h3>

            <table class="form-table">
                <tr>
                    <th><label for="twitterhandle"><?php esc_html_e('Twitter Username', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="twitterhandle" id="twitterhandle" value="<?php echo esc_attr( get_the_author_meta( 'twitterhandle', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
                <tr>
                    <th><label for="facebookurl"><?php esc_html_e('Facebook URL', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="facebookurl" id="facebookurl" value="<?php echo esc_attr( get_the_author_meta( 'facebookurl', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
                <tr>
                    <th><label for="instagramurl"><?php esc_html_e('Instagram URL', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="instagramurl" id="instagramurl" value="<?php echo esc_attr( get_the_author_meta( 'instagramurl', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
                <tr>
                    <th><label for="linkedinurl"><?php esc_html_e('LinkedIn URL', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="linkedinurl" id="linkedinurl" value="<?php echo esc_attr( get_the_author_meta( 'linkedinurl', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
                <tr>
                    <th><label for="youtubeurl"><?php esc_html_e('YouTube URL', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="youtubeurl" id="youtubeurl" value="<?php echo esc_attr( get_the_author_meta( 'youtubeurl', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
            </table>
        <?php } ?>

        <?php if($ct_extra_profile_info != 'no') { ?>
            <h3><?php esc_html_e("Extra profile information", "contempo"); ?></h3>
             
            <table class="form-table">
                <?php if(in_array('administrator', (array) $current_user->roles) || in_array('editor', (array) $current_user->roles) || in_array('author', (array) $current_user->roles) || in_array('contributor', (array) $current_user->roles) || in_array('seller', (array) $current_user->roles) || in_array('agent', (array) $current_user->roles) || in_array('broker', (array) $current_user->roles)) { ?>
                    <?php if($ct_agents_assign == 'yes' && current_user_can('manage_options') || $ct_agents_assign == 'no' || $ct_agents_assign == '') { ?>
                        <tr>
                            <th><label for="isagent"><?php esc_html_e('Agent', 'contempo'); ?></label></th>
                            <td>
                                <input type="checkbox" name="isagent" id=" isagent " value="yes" <?php if (esc_attr( get_the_author_meta( "isagent", $user->ID )) == "yes") echo "checked"; ?> />  Show on Agents Page
                            </td>
                        </tr>
                        <tr id="agent-order">
                            <th><label for="agentorder"><?php esc_html_e('Agent Order', 'contempo'); ?></label></th>
                            <td>
                                <input type="text" name="agentorder" id="agentorder" value="<?php echo esc_attr( get_the_author_meta( 'agentorder', $user->ID ) ); ?>" class="regular-text" /><br />
                                <p class="agentorder description"><?php _e('If user is an agent select the order you would like them displayed on the agents page, e.g. 1, 2, 3, etc&hellip; NOTE: You must also set Real Estate 7 Options > Agents > Manually Order Agents? > to Yes, otherwise the ordering won\'t be applied.', 'contempo'); ?></p>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th><label for="ct_profile_img"><?php esc_html_e('Profile Image', 'contempo'); ?></label></th>
                        <td>
                            <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
                            <?php $profile_img = get_the_author_meta('ct_profile_url', $user->ID ); ?>
                            <?php if($profile_img != "") { ?>
                                <img class="user-profile-img" style="border: 1px solid #dfdfdf; margin: 0 0 5px 0; padding: 5px; background: #fff;" src="<?php echo esc_url($profile_img); ?>" width="100" />
                            <?php } ?>
                            <br />
                            <div class="clear"></div>
                            <input name="ct_profile_img" id="ct_profile_img" type="file" /><br />
                            <span class="description"><?php esc_html_e('Please upload a profile picture here, if none is chosen a default image will be used.', 'contempo'); ?></span>
                        </td>
                    </tr>
                <?php } ?>
                    <tr>
                        <th><label for="mobile"><?php esc_html_e('Mobile #', 'contempo'); ?></label></th>
                        <td>
                            <input type="text" name="mobile" id="mobile" value="<?php echo esc_attr( get_the_author_meta( 'mobile', $user->ID ) ); ?>" class="regular-text" /><br />
                        </td>
                    </tr>
                <?php if(in_array('administrator', (array) $current_user->roles) || in_array('editor', (array) $current_user->roles) || in_array('author', (array) $current_user->roles) || in_array('contributor', (array) $current_user->roles) || in_array('seller', (array) $current_user->roles) || in_array('agent', (array) $current_user->roles) || in_array('broker', (array) $current_user->roles)) { ?>
                    <tr>
                        <th><label for="fax"><?php esc_html_e('Fax #', 'contempo'); ?></label></th>
                        <td>
                            <input type="text" name="fax" id="fax" value="<?php echo esc_attr( get_the_author_meta( 'fax', $user->ID ) ); ?>" class="regular-text" /><br />
                    
                        </td>
                    </tr>
                    <tr>
                        <th><label for="title"><?php esc_html_e('Title', 'contempo'); ?></label></th>
                        <td>
                            <input type="text" name="title" id="title" value="<?php echo esc_attr( get_the_author_meta( 'title', $user->ID ) ); ?>" class="regular-text" /><br />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="tagline"><?php esc_html_e('Tagline', 'contempo'); ?></label></th>
                        <td>
                            <input type="text" name="tagline" id="tagline" value="<?php echo esc_attr( get_the_author_meta( 'tagline', $user->ID ) ); ?>" class="regular-text" /><br />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="agentlicense"><?php esc_html_e('Agent License #', 'contempo'); ?></label></th>
                        <td>
                            <input type="text" name="agentlicense" id="agentlicense" value="<?php echo esc_attr( get_the_author_meta( 'agentlicense', $user->ID ) ); ?>" class="regular-text" /><br />
                            <span class="description"><?php esc_html_e('Add the agents license number here.', 'contempo'); ?></span>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>

        <?php if($ct_agent_testimonials != 'no' && in_array('administrator', (array) $current_user->roles) || in_array('editor', (array) $current_user->roles) || in_array('author', (array) $current_user->roles) || in_array('contributor', (array) $current_user->roles) || in_array('agent', (array) $current_user->roles) || in_array('broker', (array) $current_user->roles)) { ?>
            <h3><?php esc_html_e('Agent Testimonials', 'contempo'); ?></h3>

            <table class="form-table">
                <tr>
                    <th><label for="ct_user_testimonials"><?php esc_html_e('If this user is marked as an agent ("Show on agents page" option above) use this area to add client testimonials.', 'contempo'); ?></label></th>
                    <td>
                        <?php                       
                            $content = get_the_author_meta( 'userTestimonial', $user->ID );
                            $editor_id = 'userTestimonial';

                            wp_editor( $content, $editor_id, $settings = array('textarea_rows' => '12') );
                        ?>
                    </td>
                </tr>
            </table>
        <?php } ?>
        
        <?php if($ct_office_information != 'no' && in_array('administrator', (array) $current_user->roles) || in_array('editor', (array) $current_user->roles) || in_array('author', (array) $current_user->roles) || in_array('contributor', (array) $current_user->roles) || in_array('agent', (array) $current_user->roles) || in_array('broker', (array) $current_user->roles)) { ?>
            <h3><?php esc_html_e('Office Information', 'contempo'); ?></h3>
                
            <table class="form-table">
                <tr>
                    <th><label for="ct_broker_logo"><?php esc_html_e('Personal Logo', 'contempo'); ?></label></th>
                    <td>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
                        <?php $ct_broker_logo = get_the_author_meta('ct_broker_logo', $user->ID ); ?>
                        <?php if($ct_broker_logo != "") { ?>
                            <img class="user-profile-img" style="border: 1px solid #dfdfdf; margin: 0 0 5px 0; padding: 5px; background: #fff;" src="<?php echo esc_url($ct_broker_logo); ?>" width="100" />
                        <?php } ?>
                        <br />
                        <div class="clear"></div>
                        <input name="ct_broker_logo" id="ct_broker_logo" type="file" /><br />
                        <span class="description"><?php esc_html_e('Upload your personal logo here, or if you choose to associate a Brokerage below that logo will be used instead.', 'contempo'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="brokerage_cpt"><?php esc_html_e('Brokerage', 'contempo'); ?></label></th>
                    <td id="brokerage-select">
                        <?php
                            $posts = get_posts(array('post_type'=> 'brokerage', 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));
                            $ct_brokerage_id = get_the_author_meta('brokeragename', $user->ID);
                            echo '<select name="brokeragename" id="brokeragename">';
                            echo '<option value="">' . __('Select a Brokerage', 'contempo') . '</option>';
                                foreach ($posts as $post) {
                                    echo '<option value="' . $post->ID . '"';
                                        if($ct_brokerage_id == $post->ID) { echo 'selected="selected" '; } else { $selected = ''; }
                                    echo '>' . $post->post_title . '</option>';
                                }
                            echo '</select>';
                        ?><br />
                        <span class="description"><?php esc_html_e('Assign a brokerage here, these are pulled from the Brokerage custom post type.', 'contempo'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="brokeragelicense"><?php esc_html_e('Brokerage License #', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="brokeragelicense" id="brokeragelicense" value="<?php echo esc_attr( get_the_author_meta( 'brokeragelicense', $user->ID ) ); ?>" class="regular-text" /><br />
                        <span class="description"><?php esc_html_e('Add the brokerage license number here.', 'contempo'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="office"><?php esc_html_e('Office #', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="office" id="office" value="<?php echo esc_attr( get_the_author_meta( 'office', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
                <tr>
                    <th><label for="address"><?php esc_html_e('Address', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
                <tr>
                    <th><label for="city"><?php esc_html_e('City', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
                <tr>   
                    <th><label for="state">
                    <?php if($ct_profile_state_select == 'yes') { ?>
                        <?php esc_html_e('State', 'contempo'); ?>
                    <?php } else { ?>
                        <?php esc_html_e('State or Province', 'contempo'); ?>
                    <?php } ?>
                    </label></th>
                    <td>  
                        <?php if($ct_profile_state_select == 'yes') { ?>
                            <select name="state" id="state">
                                <?php foreach($states as $key => $value) { ?>
                                    <option value="<?php echo esc_html($key); ?>" title="<?php echo htmlspecialchars($value); ?>" <?php if($ct_user_state == $key) { echo 'selected'; } ?>><?php echo htmlspecialchars($value); ?></option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <input type="text" name="state" id="state" value="<?php echo esc_attr( get_the_author_meta( 'state', $user->ID ) ); ?>" class="regular-text" />
                        <?php } ?>
                        <br />
                    </td>
                </tr>
                <tr>
                    <th><label for="postalcode"><?php esc_html_e('Postal Code', 'contempo'); ?></label></th>
                    <td>
                        <input type="text" name="postalcode" id="postalcode" value="<?php echo esc_attr( get_the_author_meta( 'postalcode', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
            </table>
        <?php } ?>
    <?php }
}
add_action( 'show_user_profile', 'ct_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'ct_extra_user_profile_fields' );

/*-----------------------------------------------------------------------------------*/
/* Save Extra Profile Fields */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_save_extra_user_profile_fields')) {
    function ct_save_extra_user_profile_fields($user_id) {

        global $ct_options;
        
        $ct_agents_assign = isset( $ct_options['ct_agents_assign'] ) ? esc_attr( $ct_options['ct_agents_assign'] ) : '';
     
    	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
    	
    	// Upload Profile Image   
    	if ( !empty($_FILES['ct_profile_img']['name']) ) {
    		$filename = $_FILES['ct_profile_img'];				
    		$override['test_form'] = false;
    		$override['action'] = 'wp_handle_upload';
    		$uploaded = wp_handle_upload($filename,$override);
    		update_user_meta( $user_id, "ct_profile_url" , $uploaded['url'] );
    		
    		if( !empty($uploaded['error']) ) {
    				die( 'Could not upload image: ' . $uploaded['error'] ); 
    		}        
    	}

        // Upload Custom Logo    
        if ( !empty($_FILES['ct_broker_logo']['name']) ) {
            $filename = $_FILES['ct_broker_logo'];              
            $override['test_form'] = false;
            $override['action'] = 'wp_handle_upload';
            $uploaded = wp_handle_upload($filename,$override);
            update_user_meta( $user_id, "ct_broker_logo" , $uploaded['url'] );
            
            if( !empty($uploaded['error']) ) {
                    die( 'Could not upload image: ' . $uploaded['error'] ); 
            }        
        }
    	
        if($ct_agents_assign == 'yes' && current_user_can('manage_options') || $ct_agents_assign == 'no') {
        	update_user_meta( $user_id, 'isagent', $_POST['isagent'] );
        }
        
        update_user_meta( $user_id, 'twitterhandle', $_POST['twitterhandle'] );
        update_user_meta( $user_id, 'facebookurl', $_POST['facebookurl'] );
        update_user_meta( $user_id, 'instagramurl', $_POST['instagramurl'] );
        update_user_meta( $user_id, 'linkedinurl', $_POST['linkedinurl'] );
        update_user_meta( $user_id, 'youtubeurl', $_POST['youtubeurl'] );

        update_user_meta( $user_id, 'userTestimonial', $_POST['userTestimonial'] );
        update_user_meta( $user_id, 'agentlicense', $_POST['agentlicense'] );
        update_user_meta( $user_id, 'brokeragename', $_POST['brokeragename'] );
        update_user_meta( $user_id, 'brokeragelicense', $_POST['brokeragelicense'] );
        update_user_meta( $user_id, 'agentorder', $_POST['agentorder'] );
    	update_user_meta( $user_id, 'mobile', $_POST['mobile'] );
    	update_user_meta( $user_id, 'office', $_POST['office'] );
        update_user_meta( $user_id, 'brokerage', $_POST['brokerage'] );
    	update_user_meta( $user_id, 'fax', $_POST['fax'] );
    	update_user_meta( $user_id, 'title', $_POST['title'] );
    	update_user_meta( $user_id, 'tagline', $_POST['tagline'] ); 
    	update_user_meta( $user_id, 'address', $_POST['address'] );
    	update_user_meta( $user_id, 'city', $_POST['city'] );
    	update_user_meta( $user_id, 'state', $_POST['state'] );
    	update_user_meta( $user_id, 'postalcode', $_POST['postalcode'] );
    }
}
add_action( 'personal_options_update', 'ct_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'ct_save_extra_user_profile_fields' );

?>