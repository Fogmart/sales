<?php /* Template Name: Reset Page Template */ ?>
<?php get_header(); ?>
<?php global $ss_theme_option; ?>

<div class="reset page reset-step" data-step="check">
    <div class="container">
        <h1 class="center login__title"><?= __('Reset your password') ?></h1>
        <h5 class="login__subtitle center"><?= __('Please enter the email address associated with your account below') ?></h5>

        <div class="reset__content">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-xs-10 offset-xs-1">
                    <form class="check">
                        <?= wp_nonce_field() ?>
                        <input type="hidden" name="action" value="account_exist">
                        <h5 class="login__form__title"><?= __('Your E-mail') ?></h5>
                        <input type="email" name="email" class="input" placeholder="Enter E-mail" required>
                        <button class="button button-1 reset-next"><?= __('Send') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- page 2 -->
<div class="reset page reset-step" data-step="reset" style="display: none;">
    <div class="container">
        <h1 class="center login__title"><?= __('Reset your password') ?></h1>
        <h5 class="login__subtitle center"><?= __('Please enter and confirm you new password below:') ?></h5>

        <div class="reset__content">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-xs-10 offset-xs-1">
                    <form>
                        <?= wp_nonce_field() ?>
                        <input type="hidden" name="reset_key">
                        <input type="hidden" name="user_login">
                        <input type="hidden" name="action" value="reset">
                        <h5 class="login__form__title"><?= __('New Password') ?></h5>
                        <input type="password" name="password" class="input" placeholder="Password" required>
                        <h5 class="login__form__title"><?= __('Confirm Password') ?></h5>
                        <input type="password" name="password_confirm" class="input" placeholder="Password" required>
                        <button class="button button-1 reset-next"><?= __('reset password') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- page 3 -->
<div class="reset page reset-step" data-step="ok" style="display: none;">
    <div class="container">
        <h1 class="center login__title"><?= __('Success!') ?></h1>

        <div class="reset__content reset_3">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-xs-10 offset-xs-1">
                    <img src="<?= ss_asset('img/icons/success.svg') ?>" alt="">
                    <h5><?= __('An email with instruction to reset your password has been emailed to you') ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>