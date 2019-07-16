<?php /* Template Name: Registration Page Template */ ?>
<?php get_header(); ?>
<?php global $ss_theme_option; ?>
<div class="register page">
    <div class="container">
        <h1 class="center login__title"><?= __('Create an account!')?></h1>
        <h5 class="login__subtitle center"><?= __('Already have an account?')?> <a href="<?= SS_LOGIN_PAGE ?>" class="link link_bold"><?= __('Click here')?></a> <?= __('to login')?></h5>

        <div class="row">
            <div class="col-md-6 offset-md-3 col-sm-10 offset-sm-1">
                <div class="register__content">
                    <?php get_template_part('parts/auth', 'socials') ?>
                    <div class="register_or"><span><?= __('or')?></span></div>
                    <form class="register__form" <?= SS_FORM_POST ?>>
                        <input type="hidden" name="action" value="register_form"/>
                        <?php wp_nonce_field('ss_register_form'); ?>
                        <div class="register__item">
                            <h5 class="login__form__title"><?= __('Full Name')?></h5>
                            <input type="text" name="full_name" class="input" placeholder="Enter Full Name" required>
                        </div>
                        <div class="register__item">
                            <h5 class="login__form__title"><?= __('Your E-mail')?></h5>
                            <input type="email" name="email" class="input" placeholder="Enter E-mail" required>
                        </div>
                        <div class="register__item">
                            <h5 class="login__form__title"><?= __('Your Password')?></h5>
                            <div class="password-input">
                                <input type="password" name="password" class="input" placeholder="Enter Password" required>
                                <div class="password-show"></div>
                            </div>
                        </div>
                        <input type="checkbox" id="terms" name="terms">
                        <label class="checkbox-label" for="terms"><?= __('By clicking the button you agree to the')?> <a href="<?= get_field('terms_page') ?>" class="link"><?= __('terms and conditions')?></a></label>
                        <input type="checkbox" id="newsseller" name="newsletter">
                        <label class="checkbox-label" for="newsseller"><?= __('By clicking the button you agree to subscribe Newsletter')?></label>
                        <button class="button button-1"><?= __('Sign up')?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?php get_footer(); ?>