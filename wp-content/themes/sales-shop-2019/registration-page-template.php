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
                        <input type="hidden" name="action" value="register">
                        <div class="register__item">
                            <h5 class="login__form__title">Full Name</h5>
                            <input type="text" class="input" placeholder="Enter Full Name" required>
                        </div>
                        <div class="register__item">
                            <h5 class="login__form__title">Your E-mail</h5>
                            <input type="email" class="input" placeholder="Enter E-mail" required>
                        </div>
                        <div class="register__item">
                            <h5 class="login__form__title">Your Password</h5>
                            <div class="password-input">
                                <input type="password" class="input" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required>
                                <div class="password-show"></div>
                            </div>
                        </div>
                        <input type="checkbox" id="terms">
                        <label class="checkbox-label" for="terms">By clicking the button you agree to the <a href="#!" class="link">terms and conditions</a></label>
                        <input type="checkbox" id="newsseller">
                        <label class="checkbox-label" for="newsseller">By clicking the button you agree to subscribe Newsletter</label>

                        <button class="button button-1">Sign up</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
<?php get_footer(); ?>