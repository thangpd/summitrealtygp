<?php
/**
 * Template Name: Edit Profile
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options, $current_user, $wp_roles;

$ct_enable_front_end_account_delete = isset( $ct_options['ct_enable_front_end_account_delete'] ) ? esc_attr( $ct_options['ct_enable_front_end_account_delete'] ) : '';

$inside_page_title = get_post_meta( $post->ID, "_ct_inner_page_title", true );

get_header();

if ( ! function_exists( 'wp_handle_upload' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

while ( have_posts() ) : the_post();

	if ( $inside_page_title == "Yes" ) {
		// Custom Page Header Background Image
		if ( get_post_meta( $post->ID, '_ct_page_header_bg_image', true ) != '' ) {
			echo '<style type="text/css">';
			echo '#single-header { background: url(';
			echo get_post_meta( $post->ID, '_ct_page_header_bg_image', true );
			echo ') no-repeat center center; background-size: cover;}';
			echo '</style>';
		} ?>

        <!-- Single Header -->
        <div id="single-header">
            <div class="dark-overlay">
                <div class="container">
                    <h1 class="marT0 marB0"><?php the_title(); ?></h1>
					<?php if ( get_post_meta( $post->ID, '_ct_page_sub_title', true ) != '' ) { ?>
                        <h2 class="marT0 marB0"><?php echo get_post_meta( $post->ID, "_ct_page_sub_title", true ); ?></h2>
					<?php } ?>
                </div>
            </div>
        </div>
        <!-- //Single Header -->
	<?php } ?>

	<?php echo '<div id="page-content" class="container">'; ?>

	<?php if ( is_user_logged_in() ) {
		get_template_part( '/includes/user-sidebar' );
	} ?>

    <article class="col <?php if ( is_user_logged_in() ) {
		echo 'span_9';
	} else {
		echo 'span_12 first';
	} ?> marB60">

    <div class="inner-content">

	<?php if ( ! is_user_logged_in() ) {
		echo '<div class="must-be-logged-in">';
		echo '<h4 class="center marB20">' . __( 'You must be logged in to view this page.', 'contempo' ) . '</h4>';
		echo '<p class="center login-register-btn marB0"><a class="btn login-register" href="#">Login/Register</a></p>';
		echo '</div>';
	} else { ?>

		<?php the_content(); ?>

		<?php

		//do_action('personal_options', $current_user);
		//do_action('profile_personal_options', $current_user);

		$error = array();

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

			/* Update user password */
			if ( ! empty( $_POST['password1'] ) && ! empty( $_POST['password2'] ) ) {
				if ( $_POST['password1'] == $_POST['password2'] ) {
					wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['password1'] ) ) );
					$error[] = __( 'Your password was updated.', 'contempo' );
				} else {
					$error[] = __( 'The passwords you entered do not match. Your password was not updated.', 'contempo' );
				}
			}

			/* Update user email */
			$user_id = email_exists( esc_attr( $_POST['email'] ) );
			if ( ! empty( $_POST['email'] ) ) {
				if ( ! is_email( esc_attr( $_POST['email'] ) ) ) {
					$error[] = __( 'The Email you entered is not valid. Please try again.', 'contempo' );
				} elseif ( $user_id && ( $user_id != $current_user->ID ) ) {
					$error[] = __( 'This email is already used by another user. Try a different one.', 'contempo' );
				} else {
					wp_update_user( array( 'ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] ) ) );
				}
			}

			/* User Fields */
			$userdata = array(
				'ID'            => $current_user->ID,
				'first_name'    => esc_attr( $_POST['first_name'] ),
				'last_name'     => esc_attr( $_POST['last_name'] ),
				'nickname'      => esc_attr( $_POST['nickname'] ),
				'display_name'  => esc_attr( $_POST['display_name'] ),
				//'skype'			=> esc_attr($_POST['skype']),
				//'twitter'		=> esc_attr($_POST['twitter']),
				//'yahoo'			=> esc_attr($_POST['yahoo']),
				//'aim'			=> esc_attr($_POST['aim']),
				'user_url'      => esc_attr( $_POST['user_url'] ),
				'twitterhandle' => esc_attr( $_POST['twitterhandle'] ),
				'facebookurl'   => esc_attr( $_POST['facebookurl'] ),
				'linkedinurl'   => esc_attr( $_POST['linkedinurl'] ),
				'gplus'         => esc_attr( $_POST['gplus'] ),
				'description'   => esc_attr( $_POST['description'] ),
			);
			wp_update_user( $userdata );

			/* Redirect so the page will show updated info.*/
			if ( count( $error ) == 0 ) {
				//action hook for plugins and extra fields saving
				do_action( 'edit_user_profile_update', $current_user->ID );
				wp_redirect( get_permalink() );
				exit;
			}
		} ?>

		<?php if ( count( $error ) > 0 ) {
			echo '<p class="fep-message-error">' . implode( "<br />", $error ) . '</p>';
		} ?>


        <div class="fep">
            <form method="post" id="your-profile" action="<?php the_permalink(); ?>" enctype="multipart/form-data"
                  method="post">
                <h3><?php _e( 'Name', 'contempo' ); ?></h3>

                <table class="form-table">
                    <tr>
                        <th><label for="user_login"><?php _e( 'Username', 'contempo' ); ?></label></th>
                        <td><input type="text" name="user_login" id="user_login"
                                   value="<?php echo esc_attr( $current_user->user_login ); ?>" disabled="disabled"
                                   class="regular-text"/><em><span
                                        class="description"><?php _e( 'Usernames cannot be changed.', 'contempo' ); ?></span></em>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="first_name"><?php _e( 'First Name', 'contempo' ); ?></label></th>
                        <td><input class="text-input" name="first_name" type="text" id="first_name"
                                   value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>"/></td>
                    </tr>
                    <tr>
                        <th><label for="last_name"><?php _e( 'Last Name', 'contempo' ); ?></label></th>
                        <td><input class="text-input" name="last_name" type="text" id="last_name"
                                   value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>"/></td>
                    </tr>
                    <tr>
                        <th><label for="nickname"><?php _e( 'Nickname', 'contempo' ); ?> <span
                                        class="description"><?php _e( '(required)', 'contempo' ); ?></span></label></th>
                        <td><input type="text" name="nickname" id="nickname"
                                   value="<?php echo esc_attr( $current_user->nickname ) ?>" class="regular-text"/></td>
                    </tr>
                    <tr>
                        <th><label for="display_name"><?php _e( 'Display to Public as', 'contempo' ); ?></label></th>
                        <td>
                            <select name="display_name" id="display_name">
								<?php
								$public_display                     = array();
								$public_display['display_username'] = $current_user->user_login;
								$public_display['display_nickname'] = $current_user->nickname;

								if ( ! empty( $current_user->first_name ) ) {
									$public_display['display_firstname'] = $current_user->first_name;
								}

								if ( ! empty( $current_user->last_name ) ) {
									$public_display['display_lastname'] = $current_user->last_name;
								}

								if ( ! empty( $current_user->first_name ) && ! empty( $current_user->last_name ) ) {
									$public_display['display_firstlast'] = $current_user->first_name . ' ' . $current_user->last_name;
									$public_display['display_lastfirst'] = $current_user->last_name . ' ' . $current_user->first_name;
								}

								if ( ! in_array( $current_user->display_name, $public_display ) ) {
									$public_display = array( 'display_displayname' => $current_user->display_name ) + $public_display;
									$public_display = array_map( 'trim', $public_display );
									$public_display = array_unique( $public_display );
								}

								foreach ( $public_display as $id => $item ) {
									?>
                                    <option id="<?php echo esc_html( $id ); ?>"
                                            value="<?php echo esc_attr( $item ); ?>"<?php selected( $current_user->display_name, $item ); ?>><?php echo esc_html( $item ); ?></option>
									<?php
								}
								?>
                            </select>
                        </td>
                    </tr>
                </table>

                <h3><?php _e( 'Contact Info', 'contempo' ); ?></h3>

                <table class="form-table">
                    <tr>
                        <th><label for="email"><?php _e( 'E-mail *', 'contempo' ); ?></label></th>
                        <td><input class="text-input" name="email" type="text" id="email"
                                   value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>"/></td>
                    </tr>
                    <tr>
                        <th><label for="user_url"><?php _e( 'Website', 'contempo' ); ?></label></th>
                        <td><input class="text-input" name="user_url" type="text" id="user_url"
                                   value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>"/></td>
                    </tr>
					<?php
					$contact_methods = array();

					$contact_methods = apply_filters( "fep_contact_methods", $contact_methods );
					if ( ! ( is_array( $contact_methods ) ) ) {
						$contact_methods = array();
					}
					foreach ( _wp_get_user_contactmethods() as $name => $desc ) {

						if ( in_array( $name, $contact_methods ) ) {
							continue;
						}
						?>
                        <tr>
                            <th>
                                <label for="<?php echo esc_html( $name ); ?>"><?php echo apply_filters( 'user_' . $name . '_label', $desc ); ?></label>
                            </th>
                            <td><input type="text" name="<?php echo esc_html( $name ); ?>"
                                       id="<?php echo esc_html( $name ); ?>"
                                       value="<?php echo esc_attr( $current_user->$name ) ?>" class="regular-text"/>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>

                <h3><?php _e( 'About Yourself', 'contempo' ); ?></h3>

                <table class="form-table">
                    <tr>
                        <th><label for="description"><?php _e( 'Biographical Information', 'contempo' ) ?></label><span
                                    class="description"><?php _e( 'Share a little biographical information to fill out your profile. This may be shown publicly.', 'contempo' ); ?></span>
                        </th>
                        <td><textarea name="description" id="description" rows="5"
                                      cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <th><label for="password1"><?php _e( 'New Password', 'contempo' ); ?></label><span
                                    class="description"><?php _e( 'If you would like to change the password type a new one. Otherwise leave this blank.', 'contempo' ); ?></span>
                        </th>
                        <td>
                            <input type="password" name="password1" id="password1" size="16" value="" autocomplete="off"/>
                            <input type="password" name="password2" id="password2" size="16" value="" autocomplete="off"/>
                            <em><span class="description"><?php _e( 'Type your new password again.', 'contempo' ); ?></span></em>

                            <div id="pass-strength"><?php _e( 'Strength indicator', 'contempo' ); ?></div>
                        </td>
                    </tr>

                </table>


				<?php
				//action hook for plugin and extra fields
				do_action( 'edit_user_profile', $current_user );
				?>

                <div class="clear"></div>
                <div class="submit">
                    <input name="updateuser" type="submit" id="updateuser"
                           class="btn <?php if ( $ct_enable_front_end_account_delete == 'yes' ) {
						       echo 'left';
					       } ?>" value="<?php _e( 'Update Profile', 'contempo' ); ?>"/>
					<?php wp_nonce_field( 'update-user' ) ?>
                    <input name="action" type="hidden" id="action" value="update-user"/>
					<?php
					$userID = get_current_user_id();
					if ( $ct_enable_front_end_account_delete == 'yes' && $current_user->ID == $userID ) {
						echo '<a class="right btn btn-delete" href="' . home_url() . '/?action=ct_delete_user&amp;user_id=' . $current_user->ID . '">' . __( 'Delete Account', 'contempo' ) . '</a>';
					}
					?>
                    <div class="clear"></div>
                </div><!-- .form-submit -->
            </form><!-- #adduser -->
        </div>

	<?php } ?>

	<?php //wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>

<?php endwhile; ?>

    <div class="clear"></div>

<?php do_action( 'after_edit_profile_info' ); ?>

    </div>

    </article>

<?php
echo '<div class="clear"></div>';
echo '</div>';

get_footer(); ?>