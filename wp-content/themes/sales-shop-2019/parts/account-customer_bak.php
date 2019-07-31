<?php
get_header();
$user = wp_get_current_user();
$additional_fields = get_fields('user_' . $user->ID);
global $ss_theme_option;
$my_coupons_pagination_amount = $ss_theme_option['buyer-tab-my-coupons-pagination-amount'];
$historical_coupons_pagination_amount = $ss_theme_option['buyer-tab-historical-coupons-pagination-amount'];
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
// $historical_coupons = ss_get_user_orders($paged, $historical_coupons_pagination_amount);
// var_dump($historical_coupons);
?>

<div class="account page">

    <div class="container">

        <h1 class="account__title"><?= __('Account details') ?></h1>

        <div class="account__section">
            <div class="row">
                <div class="col-md-2">
                    <div class="orders__sidebar">
                        <h5 class="orders__sidebar__title"><?= __('Hello') ?> <?= $user->first_name . ' ' . $user->last_name ?></h5>
                        <a href="<?= wp_logout_url(SS_LOGIN_PAGE) ?>"><button class="button button-1"><?= __('logout') ?></button></a>
                        <ul>
                            <li><a href="#edit" data-id="edit_account" class="link link_bold"><?= __('Edit Account') ?></a></li>
                            <li><a href="#coupons" data-id="my_coupons" class="link link_grey"><?= __('My Coupons') ?></a></li>
                            <li><a href="#historical" data-id="historical_coupons" class="link link_grey"><?= __('Historical coupons') ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-10" id="edit_account">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="account__block">
                                <form <?= SS_FORM_POST ?>>
                                    <input type="hidden" name="action" value="account_details_form"/>
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
                                                <div class="input-calendar">
                                                    <input type="text" name="date_of_birth" class="input" placeholder="<?= __('Date of Birth') ?> (<?= __('optional') ?>)" value="<?= $additional_fields['date_of_birth'] ?>">
                                                </div>
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
                                                <input type="text" name="city" class="input" placeholder="<?= __('City') ?>" value="<?= get_the_title($additional_fields['city']) ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="neighborhood" class="input" placeholder="<?= __('Neighborhood') ?>" value="<?= $additional_fields['neighborhood'] ?>">
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
                        <div class="col-md-4">
                            <div class="account__sidebar account__block">
                                <h2 class="account__sidebar__title">h2. Heading</h2>
                                <p class="account__sidebar__text">lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-10 orders" id="my_coupons" style="display: none">
                    <div class="orders__main">

                        <h2 class="orders__subtitle"><?= __('My Coupons') ?></h2>

                        <div class="order">
                            <div class="order__photo"><img src="<?= ss_asset('img/card.jpg') ?>" alt=""></div>
                            <div class="order__content">
                                <a href="#!" class="order__title">Product Title Goes Here and here and here and here and here and here and here Product Title Goes Here and here and </a>
                                <div class="order__subtitle_mute">Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>
                                <div class="order__block__price">20 000 000$</div>

                                <div class="order__details">
                                    <div class="order__details__block">
                                        <div class="order__block__title">Purchase Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                    <div class="order__details__block">
                                        <div class="order__block__title">Expiration Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order">
                            <div class="order__photo"><img src="<?= ss_asset('img/card.jpg') ?>" alt=""></div>
                            <div class="order__content">
                                <a href="#!" class="order__title">Product Title Goes Here and here and here and here and here and here and here Product Title Goes Here and here and </a>
                                <div class="order__subtitle_mute">Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>
                                <div class="order__block__price">20 000 000$</div>

                                <div class="order__details">
                                    <div class="order__details__block">
                                        <div class="order__block__title">Purchase Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                    <div class="order__details__block">
                                        <div class="order__block__title">Expiration Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order">
                            <div class="order__photo"><img src="<?= ss_asset('img/card.jpg') ?>" alt=""></div>
                            <div class="order__content">
                                <a href="#!" class="order__title">Product Title Goes Here and here and here and here and here and here and here Product Title Goes Here and here and </a>
                                <div class="order__subtitle_mute">Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>
                                <div class="order__block__price">20 000 000$</div>

                                <div class="order__details">
                                    <div class="order__details__block">
                                        <div class="order__block__title">Purchase Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                    <div class="order__details__block">
                                        <div class="order__block__title">Expiration Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="orders__control">
                            <div class="orders__control__text">Showing 1 to 10 of 11 entries</div>
                            <div class="orders__control__buttons">
                                <button class="button button-1 button-1_120">Previous</button>
                                <button class="button button-1 button-1_120">next</button>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-10 orders history" id="historical_coupons" style="display: none">
                    <div class="orders__main">

                        <h2 class="orders__subtitle">My Historical Coupons</h2>

                        <div class="order">
                            <div class="order__photo"><img src="<?= ss_asset('img/card.jpg') ?>" alt=""></div>
                            <div class="order__content">
                                <a href="#!" class="order__title">Product Title Goes Here and here and here and here and here and here and here Product Title Goes Here and here and </a>
                                <div class="order__subtitle_mute">Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>
                                <div class="order__block__price">20 000 000$</div>

                                <div class="order__details">
                                    <div class="order__details__block">
                                        <div class="order__block__title">Purchase Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                    <div class="order__details__block">
                                        <div class="order__block__title">Expiration Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                    <div class="order__details__block status">
                                        <div class="order__block__title">Status:</div>
                                        <div class="order__block__status canceled">Canceled</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order">
                            <div class="order__photo"><img src="<?= ss_asset('img/card.jpg') ?>" alt=""></div>
                            <div class="order__content">
                                <a href="#!" class="order__title">Product Title Goes Here and here and here and here and here and here and here Product Title Goes Here and here and </a>
                                <div class="order__subtitle_mute">Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>
                                <div class="order__block__price">20 000 000$</div>

                                <div class="order__details">
                                    <div class="order__details__block">
                                        <div class="order__block__title">Purchase Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                    <div class="order__details__block">
                                        <div class="order__block__title">Expiration Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                    <div class="order__details__block status">
                                        <div class="order__block__title">Status:</div>
                                        <div class="order__block__status used">Used</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order">
                            <div class="order__photo"><img src="<?= ss_asset('img/card.jpg') ?>" alt=""></div>
                            <div class="order__content">
                                <a href="#!" class="order__title">Product Title Goes Here and here and here and here and here and here and here Product Title Goes Here and here and </a>
                                <div class="order__subtitle_mute">Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>
                                <div class="order__block__price">20 000 000$</div>

                                <div class="order__details">
                                    <div class="order__details__block">
                                        <div class="order__block__title">Purchase Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                    <div class="order__details__block">
                                        <div class="order__block__title">Expiration Date: </div>
                                        <div class="order__block__text">September 24, 2018</div>
                                    </div>
                                    <div class="order__details__block status">
                                        <div class="order__block__title">Status:</div>
                                        <div class="order__block__status awaiting">Awaiting</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="orders__control">
                            <div class="orders__control__text">Showing 1 to 10 of 11 entries</div>
                            <div class="orders__control__buttons">
                                <button class="button button-1 button-1_120">Previous</button>
                                <button class="button button-1 button-1_120">next</button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    $(function() {
        $('.orders__sidebar a.link').click(function () {
            var data_id;
            data_id = $('.orders__sidebar a.link.link_bold').removeClass('link_bold').addClass('link_grey').attr('data-id');
            $('#' + data_id).hide();
            data_id = $(this).removeClass('link_grey').addClass('link_bold').attr('data-id');
            $('#' + data_id).show();
        });
    });
</script>

<?php get_footer(); ?>
