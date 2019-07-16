<?php
get_header();
$user = wp_get_current_user();
?>

<div class="dashboard page">

    <div class="container">

        <h1 class="dashboard__title"><?= __('Seller Dashboard') ?></h1>

        <div class="row stretch-cols">

            <div class="col-md-2">
                <div class="orders__sidebar">
                    <div class="orders__sidebar__photo"><img src="<?= get_field('photo', 'user_' . $user->ID) ?>" alt=""></div>
                    <h5 class="orders__sidebar__title"><?= __('Hello') ?> <?=$user->display_name ?></h5>
                    <a href="<?= wp_logout_url(SS_LOGIN_PAGE) ?>"><button class="button button-1"><?= __('logout') ?></button></a>
                    <ul>
                        <li><a href="#!" class="link link_bold"><?= __('Coupons List') ?></a></li>
                        <li><a href="#!" class="link link_grey"><?= __('Reports') ?></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10">
                <div class="dashboard__main">
                    <h2 class="dashboard__main__title"><?= __('Find the right coupon') ?></h2>
                    <div class="dashboard__main__subtitle"><?= __('You can search by order number, customer name, or customer phone') ?></div>

                    <form class="search">
                        <input type="text" placeholder="<?= __('Search') ?>" class="input">
                        <button class="button button-3"><img src="<?= ss_asset('img/icons/search.svg') ?>" alt=""></button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>