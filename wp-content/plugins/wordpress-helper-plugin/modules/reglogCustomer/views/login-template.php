<?php

/**
 * Date: 12/1/20
 * Time: 5:36 PM
 */

//get_header();
wp_head();
?>
<div class="container register-page">
    <div class="header-regis col-12 p-20">
        <div class="logo-wrap col span_2 first">
            <?php if ($ct_options['ct_text_logo'] == "yes") { ?>

                <div id="logo" class="left">
                    <h2><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h2>
                </div>

            <?php } else { ?>

                <?php if ($ct_trans_header == 'yes' && is_front_page() && strpos($url, 'search-listings=true') != true) { ?>

                    <a href="<?php echo home_url(); ?>">
                        <?php if (!empty($ct_options['ct_logo']['url'])) { ?>
                            <img class="logo left" src="<?php echo esc_url($ct_options['ct_logo_trans']['url']); ?>" <?php if (!empty($ct_logo_highres_trans)) { ?>srcset="<?php echo esc_url($ct_logo_highres_trans); ?> 2x" <?php } ?> alt="<?php bloginfo('name'); ?>" />
                        <?php } else { ?>
                            <img class="logo left" src="<?php echo get_template_directory_uri(); ?>/images/re7-logo-blue-white.png" srcset="<?php echo get_template_directory_uri(); ?>/images/re7-logo-blue-white@2x.png 2x" alt="WP Pro Real Estate 7, a WordPress theme by Contempo" />
                        <?php } ?>
                    </a>

                <?php } else { ?>

                    <?php if (!empty($ct_options['ct_logo']['url'])) { ?>
                        <a href="<?php echo home_url(); ?>"><img class="logo left" src="<?php echo esc_url($ct_options['ct_logo']['url']); ?>" <?php if (!empty($ct_logo_highres)) { ?>srcset="<?php echo esc_url($ct_logo_highres); ?> 2x" <?php } ?> alt="<?php bloginfo('name'); ?>" /></a>
                    <?php } else { ?>
                        <a href="<?php echo home_url(); ?>">
                            <?php if ($ct_options['ct_skin'] == 'minimal') { ?>
                                <img class="logo left" src="<?php echo get_template_directory_uri(); ?>/images/re7-logo-blue.png" srcset="<?php echo get_template_directory_uri(); ?>/images/re7-logo-blue@2x.png 2x" alt="WP Pro Real Estate 7, a WordPress theme by Contempo" />
                            <?php } else { ?>
                                <img class="logo left" src="<?php echo get_template_directory_uri(); ?>/images/re7-logo.png" srcset="<?php echo get_template_directory_uri(); ?>/images/re7-logo@2x.png 2x" alt="WP Pro Real Estate 7, a WordPress theme by Contempo" />
                            <?php } ?>
                        </a>
                    <?php } ?>

                <?php } ?>

            <?php } ?>
        </div>
    </div>
    <div class="body-regis col-12">
        <div class="regis-container">
            <h1 class="regis-title">Welcome back</h1>
            <div class="main-agileinfo">
                <div class="agileits-top">
                    <form id="summit-login-form" class="regis-form" action="#" method="post">
                        <?php wp_nonce_field('login_form_action', 'login_form_field'); ?>
                        <input class="text" type="text" name="Username" placeholder="Username" required="">
                        <input class="text" type="password" name="password" placeholder="Password" required="">
                        <p style="color: red; font-size: 14px;" id="login-error-msg"></p>
                        <input type="submit" value="Login">
                    </form>
                    <p>Don't have an Account? <br> <a href="<?php echo site_url() . '/summit-register' ?>"> Sign Up
                            Now!</a></p>
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
            <!-- //main -->
        </div>
    </div>
</div>
<?php
wp_footer();
//get_footer();