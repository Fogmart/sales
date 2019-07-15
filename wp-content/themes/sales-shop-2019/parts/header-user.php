<span class="control__icon"><img src="<?= ss_asset('img/icons/user.svg') ?>" alt=""></span>
<?php if (is_user_logged_in()) : ?>
    <!-- <span class="control__link"></span> -->

    <div class="control__cabinet control__popup">
        <ul class="control__cabinet__menu">
            <li>
                <a href="<?= SS_PROFILE_PAGE ?>" class="control__cabinet__item">
                    <span><img src="<?= ss_asset('img/icons/settings.svg') ?>" alt=""></span>
                    <?= __('My Account') ?>
                </a>
            </li>
            <li>
                <a href="<?= SS_PROFILE_PAGE ?>" class="control__cabinet__item">
                    <span><img src="<?= ss_asset('img/icons/profile.svg') ?>" alt=""></span>
                    <?= __('Profile') ?>
                </a>
            </li>
            <li>
                <a href="<?= SS_ORDERS_PAGE ?>" class="control__cabinet__item">
                    <span><img src="<?= ss_asset('img/icons/orders.svg') ?>" alt=""></span>
                    <?= __('Orders') ?>
                </a>
            </li>
            <li>
                <a href="<?= SS_VOUCHERS_PAGE ?>" class="control__cabinet__item">
                    <span><img src="<?= ss_asset('img/icons/vouchers.svg') ?>" alt=""></span>
                    <?= __('Vouchers') ?>
                </a>
            </li>
        </ul>
        <div class="control__cabinet__button">
            <a href="<?= wp_logout_url(SS_LOGIN_PAGE) ?>">
                <button class="button button-1"><?= __('logout') ?></button>
            </a>
        </div>
    </div>
<?php else : ?>
    <span class="control__link"><?= __('Sign in') ?></span>
    <div class="control__login control__popup">
        <div class="control__login__title"><?= __('If you are a new user') ?></div>
        <a href="<?= SS_REG_PAGE ?>" class="control__login__register"><?= __('register') ?></a>
        <a href="<?= SS_LOGIN_PAGE ?>">
            <button class="button button-1"><?= __('login') ?></button>
        </a>
    </div>
<?php endif; ?>