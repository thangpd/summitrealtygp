<?php
/**
 * Date: 12/1/20
 * Time: 5:36 PM
 */

//get_header();
wp_head();
?>
<?php $states = array(
	'AL' => 'AL',
	'AK' => 'AK',
	'AZ' => 'AZ',
	'AR' => 'AR',
	'CA' => 'CA',
	'CO' => 'CO',
	'CT' => 'CT',
	'DE' => 'DE',
	'DC' => 'DC',
	'FL' => 'FL',
	'GA' => 'GA',
	'HI' => 'HI',
	'ID' => 'ID',
	'IL' => 'IL',
	'IN' => 'IN',
	'IA' => 'IA',
	'KS' => 'KS',
	'KY' => 'KY',
	'LA' => 'LA',
	'ME' => 'ME',
	'MD' => 'MD',
	'MA' => 'MA',
	'MI' => 'MI',
	'MN' => 'MN',
	'MS' => 'MS',
	'MO' => 'MO',
	'MT' => 'MT',
	'NE' => 'NE',
	'NV' => 'NV',
	'NH' => 'NH',
	'NJ' => 'NJ',
	'NM' => 'NM',
	'NY' => 'NY',
	'NC' => 'NC',
	'ND' => 'ND',
	'OH' => 'OH',
	'OK' => 'OK',
	'OR' => 'OR',
	'PA' => 'PA',
	'RI' => 'RI',
	'SC' => 'SC',
	'SD' => 'SD',
	'TN' => 'TN',
	'TX' => 'TX',
	'UT' => 'UT',
	'VT' => 'VT',
	'VA' => 'VA',
	'WA' => 'WA',
	'WV' => 'WV',
	'WI' => 'WI',
	'WY' => 'WY',
); ?>
    <div class="container register-page">
        <div class="header-regis">
            <div class="logo-wrap col span_2 first">
				<?php if ( $ct_options['ct_text_logo'] == "yes" ) { ?>

                    <div id="logo" class="left">
                        <h2><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h2>
                    </div>

				<?php } else { ?>

					<?php if ( is_front_page() && strpos( $url, 'search-listings=true' ) != true ) { ?>

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

        </div>
        <div class="body-regis">
            <div class="regis-container">
                <div class="main-w3layouts">
                    <h1 class="regis-title">Sign-up Information Form</h1>
                    <div class="step-regis">
                        <div class="w-full mx-auto px-4 md:px-0 verification__wrapper">
                            <div class="verification__circle-wrapper  ">
                                <div class="verification__circle-icon"><span>1</span></div>
                                <div class="verification__circle-label">Account</div>
                            </div>
                            <div class="verification__borderline"></div>
                            <div class="verification__circle-wrapper  current">
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
                    <div class="main-agileinfo">
                        <div class="agileits-top">
                            <form class="active-form" action="#" method="post">
                                <input class="text" type="text" name="first_name" placeholder="First Name"
                                       required="">
                                <input class="text" type="text" name="last_name" placeholder="Last Name"
                                       required="">
                                <input class="text" type="text" name="address" placeholder="Address" required="">
                                <input class="text" type="text" name="country" placeholder="Country" required="">
                                <input class="text" type="text" name="state" placeholder="State / Province / Region"
                                       required="">
                                <select title="state" name="state" id="state" required >
                                    <option value="">State
                                    </option>
									<?php foreach ( $states as $key => $value ) { ?>
                                        <option value="<?php echo esc_html( $key ); ?>"
                                                title="<?php echo htmlspecialchars( $value ); ?>"><?php echo htmlspecialchars( $value ); ?></option>
									<?php } ?>
                                </select>
                                <input class="text" type="text" name="city" placeholder="City" required="">
                                <input class="text" type="text" name="postalcode" placeholder="Postal code" required="">
                                <!--<input class="text" type="text" name="country" placeholder="Country" required="">-->
                                <input class="text" type="tel" name="mobile" placeholder="Telephone" required="">
                                <input class="text" type="text" name="taxID" placeholder="TaxID">
                                <input type="submit" value="Create Account">
                            </form>
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