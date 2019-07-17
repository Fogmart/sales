<?php
get_header();
$user = wp_get_current_user();
$additional_fields = get_fields('user_' . $user->ID);
?>

<div class="account page">

    <div class="container">

        <h1 class="account__title"><?= __('Account details') ?></h1>

        <div class="account__section">
            <div class="row">
                <div class="col-md-2">
                    <div class="orders__sidebar">
                        <h5 class="orders__sidebar__title"><?= __('Hello') ?> <?= $user->display_name ?></h5>
                        <a href="<?= wp_logout_url(SS_LOGIN_PAGE) ?>"><button class="button button-1"><?= __('logout') ?></button></a>
                        <ul>
                            <li><a href="#!" class="link link_bold"><?= __('Edit Account') ?></a></li>
                            <li><a href="#!" class="link link_grey"><?= __('My Coupons') ?></a></li>
                            <li><a href="#!" class="link link_grey"><?= __('Historical coupons') ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
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
                <div class="col-md-3">
                    <div class="account__sidebar account__block">
                        <h2 class="account__sidebar__title">h2. Heading</h2>
                        <p class="account__sidebar__text">lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?php get_footer(); ?>
