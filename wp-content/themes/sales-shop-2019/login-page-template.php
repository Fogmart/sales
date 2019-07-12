<?php /* Template Name: Login Page Template */ ?>
<?php get_header(); ?>
<?php global $ss_theme_option; ?>
<div class="login page">

    <div class="container">

        <h1 class="center login__title"><?= __('Login') ?></h1>

        <h5 class="login__subtitle center"><?= __("Don't have an account yet? ")?><a href="<?= SS_REG_PAGE ?>" class="link link_bold"><?= __('Click here')?></a> <?= __('to sign up')?></h5>

        <div class="login__content">
            <div class="row">
                <div class="col-md-5 login__socials">
                    <?php get_template_part('parts/auth', 'socials') ?>
                </div>
                <div class="login_or col-md-1"><span><?= __('or')?></span></div>
                <div class="col-md-4 offset-md-1">
                    <div class="login__enter">
                        <form class="login__form" <?= SS_FORM_POST ?>>
                            <input type="hidden" name="action" value="login_form"/>
                            <?php wp_nonce_field('ss_login_form'); ?>
                            <div class="login__item">
                                <h5 class="login__form__title"><?= __('Your E-mail*') ?></h5>
                                <input type="email" name="login" class="input" placeholder="Enter E-mail" required>
                                <div class="requirements">
                                    <?= __('Must be a valid email address.')?>
                                </div>
                            </div>
                            <div class="login__item">
                                <h5 class="login__form__title"><?= __('Your Password*')?></h5>
                                <input type="password" name="password" class="input" placeholder="Enter Password" required>
                                <div class="requirements">
                                    <?= __("Please enter a 'Password'.")?>
                                </div>
                            </div>
                            <input type="checkbox" name="remember" id="pass">
                            <label class="checkbox-label" for="pass"><?= __('Keep me signed in on this computer')?></label>
                            <a href="<?= SS_RESET_PAGE ?>" class="link link_bold login__forgot"><?= __('Forgot Your Password?') ?></a>
                            <button class="button button-1"><?= __('Sign in to Proceed to Checkout')?></button>
                        </form>
                        <h5 class="login__subtitle"><?= __("Don't have an account yet?")?> <a href="<?= SS_REG_PAGE ?>" class="link link_bold"><?= __('Click here to sign up')?></a></h5>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<?php get_footer(); ?>