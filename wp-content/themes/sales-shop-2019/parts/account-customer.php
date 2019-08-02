<?php
get_header();
$user = wp_get_current_user();
$additional_fields = get_fields('user_' . $user->ID);
$post_additional_fields = get_fields();
$cities = ss_get_cities();
global $ss_theme_option;
$my_coupons_pagination_amount = $ss_theme_option['buyer-tab-my-coupons-pagination-amount'];
$historical_coupons_pagination_amount = $ss_theme_option['buyer-tab-historical-coupons-pagination-amount'];

$orders = ss_get_user_orders();
?>

<div class="account page">

    <div class="container">

        <div class="filter__section">

            <h1 class="account__title">
                <div class="filter__item account-section"><?= __('Account details') ?></div>
                <div class="filter__item orders-section"><?= __('My Coupons') ?></div>
                <div class="filter__item history-section"><?= __('My Historical Coupons') ?></div>
            </h1>

            <div class="account__section orders history">
                <div class="row">
                    <div class="col-md-2">
                        <div class="orders__sidebar">
                            <h5 class="orders__sidebar__title"><?= __('Hello') ?> <?= $user->first_name . ' ' . $user->last_name ?></h5>
                            <a href="<?= wp_logout_url(SS_LOGIN_PAGE) ?>"><button class="button button-1"><?= __('logout') ?></button></a>
                            <ul>
                                <li><a href="#account" class="link link_grey active filter__button" data-filter="account-section"><?= __('Edit Account') ?></a></li>
                                <li><a href="#coupons" class="link link_grey filter__button" data-filter="orders-section"><?= __('My Coupons') ?></a></li>
                                <li><a href="#history" class="link link_grey filter__button" data-filter="history-section"><?= __('Historical coupons') ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-10">

                        <div class="filter__item account-section">
                            <?php if ($post_additional_fields['enable_sidebar'] == 1) : ?>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="account__block">
                                            <form <?= SS_FORM_POST ?>>
                                                <input type="hidden" name="action" value="account_details_form" />
                                                <?php wp_nonce_field('ss_account_details_form'); ?>
                                                <div class="account__block__section">
                                                    <h2 class="account__block__title"><?= __('Account Information') ?></h2>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <input type="text" name="first_name" class="input" placeholder="<?= __('Name') ?>" value="<?= $user->first_name ?>">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="last_name" class="input" placeholder="<?= __('Surname') ?>" value="<?= $user->last_name ?>">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="email" name="user_email" class="input" placeholder="<?= __('Email') ?>" value="<?= $user->user_email ?>">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="tel" name="mobile" class="input" placeholder="<?= __('Mobile') ?> (<?= __('optional') ?>)" value="<?= $additional_fields['mobile'] ?>">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="date_of_birth" class="datepicker-here input" placeholder="<?= __('Date of Birth') ?> (<?= __('optional') ?>)" value="<?= $additional_fields['date_of_birth'] ?>" data-language='en'>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="gender">
                                                                <option value="0"><?= __('Gender') ?> (<?= __('optional') ?>)</option>
                                                                <option value="male" <?= $additional_fields['gender'] === 'male' ? 'selected' : '' ?>><?= __('Male') ?></option>
                                                                <option value="female" <?= $additional_fields['gender'] === 'female' ? 'selected' : '' ?>><?= __('Female') ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="account__block__section">
                                                    <h2 class="account__block__title"><?= __('Address details') ?></h2>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <input type="text" name="address" class="input" placeholder="<?= __('Address') ?>" value="<?= $additional_fields['address'] ?>">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="city" id="acf-field_5d1334a256be3">
                                                                <?php foreach ($cities as $city) : ?>
                                                                    <option value="<?= $city->ID ?>" <?= $additional_fields['city'] == $city->ID ? 'selected' : '' ?>><?= $city->post_title ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="neighborhood" id="acf-field_5d1334b756be4">
                                                                <option>Neighborhood</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="account__block__section">
                                                    <h2 class="account__block__title"><?= __('Password change') ?></h2>

                                                    <input type="password" name="current_pass" class="input" placeholder="<?= __('Current password') ?> (<?= __('leave blank to leave unchanged') ?>)">
                                                    <input type="password" name="user_pass" class="input" placeholder="<?= __('New password') ?> (<?= __('leave blank to leave unchanged') ?>)">
                                                    <input type="password" name="confirm_pass" class="input" placeholder="<?= __('Confirm new password') ?>">
                                                </div>

                                                <div class="account__block__section">
                                                    <h2 class="account__block__title"><?= __('Password change') ?></h2>

                                                    <input type="checkbox" id="password">
                                                    <label class="checkbox-label" for="password"><?= __('I want to get newsletters and promotional offers') ?></label>

                                                    <button class="button button-1 button-1_160 save-button"><?= __('Save changes') ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="account__sidebar account__block">
                                            <h2 class="account__sidebar__title"><?= $post_additional_fields['headline_sidebar'] ?></h2>
                                            <p class="account__sidebar__text">
                                                <?= trim($post_additional_fields['body_sidebar']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="account__block">
                                    <form <?= SS_FORM_POST ?>>
                                        <input type="hidden" name="action" value="account_details_form" />
                                        <?php wp_nonce_field('ss_account_details_form'); ?>
                                        <div class="account__block__section">
                                            <h2 class="account__block__title"><?= __('Account Information') ?></h2>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="text" name="first_name" class="input" placeholder="<?= __('Name') ?>" value="<?= $user->first_name ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="last_name" class="input" placeholder="<?= __('Surname') ?>" value="<?= $user->last_name ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="email" name="user_email" class="input" placeholder="<?= __('Email') ?>" value="<?= $user->user_email ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="tel" name="mobile" class="input" placeholder="<?= __('Mobile') ?> (<?= __('optional') ?>)" value="<?= $additional_fields['mobile'] ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="date_of_birth" class="datepicker-here input" placeholder="<?= __('Date of Birth') ?> (<?= __('optional') ?>)" value="<?= $additional_fields['date_of_birth'] ?>" data-language='en'>
                                                </div>
                                                <div class="col-sm-6">
                                                    <select name="gender">
                                                        <option value="0"><?= __('Gender') ?> (<?= __('optional') ?>)</option>
                                                        <option value="male" <?= $additional_fields['gender'] === 'male' ? 'selected' : '' ?>><?= __('Male') ?></option>
                                                        <option value="female" <?= $additional_fields['gender'] === 'female' ? 'selected' : '' ?>><?= __('Female') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="account__block__section">
                                            <h2 class="account__block__title"><?= __('Address details') ?></h2>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="text" name="address" class="input" placeholder="<?= __('Address') ?>" value="<?= $additional_fields['address'] ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <select name="city" id="acf-field_5d1334a256be3">
                                                        <?php foreach ($cities as $city) : ?>
                                                            <option value="<?= $city->ID ?>" <?= $additional_fields['city'] == $city->ID ? 'selected' : '' ?>><?= $city->post_title ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <select name="neighborhood" id="acf-field_5d1334b756be4">
                                                        <option><?= __('Neighborhood')?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="account__block__section">
                                            <h2 class="account__block__title"><?= __('Password change') ?></h2>

                                            <input type="password" name="current_pass" class="input" placeholder="<?= __('Current password') ?> (<?= __('leave blank to leave unchanged') ?>)">
                                            <input type="password" name="user_pass" class="input" placeholder="<?= __('New password') ?> (<?= __('leave blank to leave unchanged') ?>)">
                                            <input type="password" name="confirm_pass" class="input" placeholder="<?= __('Confirm new password') ?>">
                                        </div>

                                        <div class="account__block__section">
                                            <h2 class="account__block__title"><?= __('Password change') ?></h2>

                                            <input type="checkbox" id="password">
                                            <label class="checkbox-label" for="password"><?= __('I want to get newsletters and promotional offers') ?></label>

                                            <button class="button button-1 button-1_160 save-button"><?= __('Save changes') ?></button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="orders__main filter__item orders-section">

                            <h2 class="orders__subtitle"><?= __('My Coupons') ?></h2>

                            <?php
                            $coupons = ss_get_coupons($orders, SS_FREE_COUPON_STATUSES);
                            ss_render_account_customer_loop($coupons, false, 'cpage', $my_coupons_pagination_amount);
                            ?>

                        </div>

                        <div class="orders__main filter__item history-section">

                            <h2 class="orders__subtitle"><?= __('My Historical Coupons') ?></h2>

                            <?php
                            $coupons = ss_get_coupons($orders);;
                            ss_render_account_customer_loop($coupons, true, 'hpage', $historical_coupons_pagination_amount);
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>