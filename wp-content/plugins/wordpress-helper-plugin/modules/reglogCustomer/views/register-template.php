<?php
/**
 * Date: 12/1/20
 * Time: 5:36 PM
 */

//get_header();
wp_head();
?>
    <div class="container register-page">
        <div class="header-regis">
            <div class="logo-wrap col span_2 first">
				<?php if ( $ct_options['ct_text_logo'] == "yes" ) { ?>

                    <div id="logo" class="left">
                        <h2><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h2>
                    </div>

				<?php } else { ?>

					<?php if (  is_front_page() && strpos( $url, 'search-listings=true' ) != true ) { ?>

                        <a href="<?php echo home_url(); ?>">
							<?php if ( ! empty( $ct_options['ct_logo']['url'] ) ) { ?>
                                <img class="logo left"
                                     src="<?php echo esc_url( $ct_options['ct_logo_trans']['url'] ); ?>"
								     <?php if ( ! empty( $ct_logo_highres_trans ) ) { ?>srcset="<?php echo esc_url( $ct_logo_highres_trans ); ?> 2x"<?php } ?>
                                     alt="<?php bloginfo( 'name' ); ?>"/>
							<?php } else { ?>
                                <img class="logo left"
                                     src="<?php echo get_template_directory_uri(); ?>/images/re7-logo-blue-white.png"
                                     srcset="<?php echo get_template_directory_uri(); ?>/images/re7-logo-blue-white@2x.png 2x"
                                     alt="WP Pro Real Estate 7, a WordPress theme by Contempo"/>
							<?php } ?>
                        </a>

					<?php } else { ?>

						<?php if ( ! empty( $ct_options['ct_logo']['url'] ) ) { ?>
                            <a href="<?php echo home_url(); ?>"><img class="logo left"
                                                                     src="<?php echo esc_url( $ct_options['ct_logo']['url'] ); ?>"
							                                         <?php if ( ! empty( $ct_logo_highres ) ) { ?>srcset="<?php echo esc_url( $ct_logo_highres ); ?> 2x"<?php } ?>
                                                                     alt="<?php bloginfo( 'name' ); ?>"/></a>
						<?php } else { ?>
                            <a href="<?php echo home_url(); ?>">
								<?php if ( $ct_options['ct_skin'] == 'minimal' ) { ?>
                                    <img class="logo left"
                                         src="<?php echo get_template_directory_uri(); ?>/images/re7-logo-blue.png"
                                         srcset="<?php echo get_template_directory_uri(); ?>/images/re7-logo-blue@2x.png 2x"
                                         alt="WP Pro Real Estate 7, a WordPress theme by Contempo"/>
								<?php } else { ?>
                                    <img class="logo left"
                                         src="<?php echo get_template_directory_uri(); ?>/images/re7-logo.png"
                                         srcset="<?php echo get_template_directory_uri(); ?>/images/re7-logo@2x.png 2x"
                                         alt="WP Pro Real Estate 7, a WordPress theme by Contempo"/>
								<?php } ?>
                            </a>
						<?php } ?>

					<?php } ?>

				<?php } ?>
            </div>
            <div class="step-regis">
                <div class="w-full mx-auto px-4 md:px-0 verification__wrapper">
                    <div class="verification__circle-wrapper current ">
                        <div class="verification__circle-icon"><span>1</span></div>
                        <div class="verification__circle-label">Account</div>
                    </div>
                    <div class="verification__borderline"></div>
                    <div class="verification__circle-wrapper  ">
                        <div class="verification__circle-icon"><span>2</span></div>
                        <div class="verification__circle-label">Detail</div>
                    </div>
                    <div class="verification__borderline"></div>
                    <div class="verification__circle-wrapper  ">
                        <div class="verification__circle-icon"><span>3</span></div>
                        <div class="verification__circle-label last">Success</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-regis">
            <div class="regis-container">
                <div class="main-w3layouts wrapper">
                    <h1 class="regis-title">Summit SignUp Form</h1>
                    <div class="main-agileinfo">
                        <div class="agileits-top">
                            <form class="regis-form" action="#" method="post">
                                <input class="text" type="text" name="Username" placeholder="Username" required="">
                                <input class="text email" type="email" name="email" placeholder="Email" required="">
                                <input class="text" type="password" name="password" placeholder="Password" required="">
                                <div class="wthree-text">
                                    <label class="anim">
                                        <input type="checkbox" class="checkbox" required="">
                                        <span>I Agree To The Terms & Conditions</span>
                                    </label>
                                    <div class="clear"></div>
                                </div>
                                <input type="submit" value="SIGNUP">
                            </form>
                            <p>Already have an account? <a href="<?php echo site_url() . '/summit-login' ?>"> Log
                                    in.</a></p>
                        </div>
                    </div>
                    <!-- copyright -->
                    <div class="colorlibcopy-agile">
                        <p></p>
                    </div>
                    <!-- //copyright -->
                    <ul class="colorlib-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                <!-- //main -->
            </div>
        </div>
    </div>
<?php
wp_footer();
//get_footer();