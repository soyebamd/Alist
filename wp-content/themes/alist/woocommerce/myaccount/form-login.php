<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<?php wc_print_notices(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>

    <div class="u-columns col2-set" id="customer_login">

        <div class="u-column1 col-1">

        <?php endif; ?>

        <h4><?php _e('Login', 'woocommerce'); ?></h4>
        <div class="clearfix"></div>
        <form method="post" class="login">

            <?php do_action('woocommerce_login_form_start'); ?>

            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                <label for="username"><?php _e('Username or email address', 'woocommerce'); ?> <span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if (!empty($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
            </p>
            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                <label for="password"><?php _e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
            </p>

            <?php do_action('woocommerce_login_form'); ?>

            <p class="form-row">
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e('Login', 'woocommerce'); ?>" />
                <label for="rememberme" class="inline">
                    <input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e('Remember me', 'woocommerce'); ?>
                </label>
            </p>
            <p class="woocommerce-LostPassword lost_password">
                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('Lost your password?', 'woocommerce'); ?></a>
            </p>

            <?php do_action('woocommerce_login_form_end'); ?>

        </form>

        <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>

        </div>

        <div class="u-column2 col-2">

            <h4><?php _e('Register', 'woocommerce'); ?></h4>
            <div class="clearfix"></div>

            <form method="post" class="register">

                <?php do_action('woocommerce_register_form_start'); ?>

                <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>






                    <div class="form-group col-lg-12 form-row">
                        <label for="reg_username"><?php _e('Username', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if (!empty($_POST['username'])) echo esc_attr($_POST['username']); ?>" required="" />
                    </div><!--form-group-->

                <?php endif; ?>
                <div class="form-group col-lg-12 form-row">
                    <label for="reg_fname"><?php _e('First Name', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="fname" id="reg_fname" value="<?php if (!empty($_POST['fname'])) echo esc_attr($_POST['fname']); ?>" required="" />
                </div><!--form-group--> 
                <div class="form-group col-lg-12 form-row">
                    <label for="reg_lname"><?php _e('Last Name', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="lname" id="reg_fname" value="<?php if (!empty($_POST['lname'])) echo esc_attr($_POST['lname']); ?>" required=""/>
                </div><!--form-group-->

                <div class="form-group col-lg-12 form-row">
                    <label for="reg_email"><?php _e('Email address', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if (!empty($_POST['email'])) echo esc_attr($_POST['email']); ?>" required=""/>
                </div><!--form-group-->

                <div class="form-group col-lg-12 form-row">
                    <label for="reg_phone"><?php _e('Phone', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="phone" id="reg_phone" value="<?php if (!empty($_POST['phone'])) echo esc_attr($_POST['phone']); ?>" required=""/>
                </div><!--form-group-->

                <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                    <div class="form-group col-lg-12 form-row">
                        <label for="reg_password"><?php _e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" required=""/>
                    </div><!--form-group-->

                <?php endif; ?>
                <div class="form-group col-lg-12 form-row">
                    <label for="">Are you looking for Tutoring or Admission Services:  </label>
                </div><!--form-group-->
                <div class="form-group col-lg-12 form-row radio">
                    <input type="radio" class="woocommerce-Input woocommerce-Input--text input-text" name="services" id="tutoring" value="tutoring" />
                    <label for="reg_tutoring"><?php _e('Tutoring', 'woocommerce'); ?> </label>


                </div><!--form-group-->
                <div class="form-group col-lg-12 form-row radio">
                    <input type="radio" class="woocommerce-Input woocommerce-Input--text input-text" name="services" id="reg_fname" value="admission" />
                    <label for="reg_admission"><?php _e('Admission', 'woocommerce'); ?></label>

                </div><!--form-group-->

                <!-- Spam Trap -->
                <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e('Anti-spam', 'woocommerce'); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

                <?php do_action('woocommerce_register_form'); ?>
                <?php do_action('register_form'); ?>

                <div class="form-group col-lg-12 form-row">
                    <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                    <input type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>" />
                </div><!--form-group-->

                <?php do_action('woocommerce_register_form_end'); ?>

            </form>

        </div>

    </div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>
