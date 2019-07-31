<?php /* Template Name: Сheckout Page Template */

$user = wp_get_current_user();
if (!$user->exists()) {
    ss_return_login();
}

$items = WC()->cart->get_cart();
if (empty($items)) {
    ss_return_home();
}

$additional_fields = get_fields('user_' . $user->ID);

get_header();
?>

<div class="checkout page">

    <div class="container">
        <h1 class="checkout__title"><?= __('We need some information') ?></h1>
        <h2 class="checkout__subtitle"><?= __('Please fill out your billing information before finalizing your order') ?></h2>

        <div class="row">
            <div class="col-md-9">
                <div class="checkout__block">
                    <h3 class="checkout__block__title"><?= __('Nice picks! Here are your items') ?></h3>
                    <div class="checkout__block__content orders">
                        <?php
                        foreach ($items as $cart_item_key => $cart_item) :
                            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
                                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                ?>
                                <div class="order">
                                    <div class="order__remove" onclick="window.location.href='<?= esc_url(wc_get_cart_remove_url($cart_item_key)) ?>'">
                                        <img src="<?= ss_asset('img/icons/remove.svg') ?>" alt="">
                                    </div>
                                    <div class="order__photo">
                                        <?= $_product->get_image('full') ?>
                                    </div>
                                    <div class="order__content">
                                        <?php
                                        if (!$product_permalink) {
                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                        } else {
                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" class="order__title">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                        }
                                        ?>
                                        <div class="order__subtitle"><span class="order__subtitle_mute"><?= __('Options') ?>:</span> <?= get_the_title($_product->get_id()) ?></div>

                                        <div class="order__details">
                                            <div class="order__details__block">
                                                <div class="order__block__title"><?= __('quantity') ?>:</div>
                                                <div class="order__block__text"><?= $cart_item['quantity'] ?></div>
                                            </div>
                                            <div class="order__details__block">
                                                <div class="order__block__title"><?= __('price') ?>:</div>
                                                <div class="order__block__text"><?= $_product->get_price() ?><?= get_woocommerce_currency_symbol() ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>

                <h3 class="checkout__subtitle"><?= __('How would you like to pay') ?>?</h3>

                <!-- payments -->
                <?php $payment_gateways = WC()->payment_gateways->payment_gateways(); ?>
                <?php foreach ($payment_gateways as $key => $one) : ?>
                    <div class="checkout__block">
                        <h3 class="checkout__block__title">
                            <input type="radio" name="payment" id="p_<?= $key ?>">
                            <label for="p_<?= $key ?>" class="radio-label"><?= __($one->title) ?></label>
                        </h3>
                    </div>
                <?php endforeach; ?>

                <div class="checkout__block">
                    <h3 class="checkout__block__title">
                        <input type="radio" name="payment" id="credit-card">
                        <label for="credit-card" class="radio-label"><?= __('Credit Card') ?></label>
                    </h3>

                    <div class="checkout__block__content">
                        <form class="checkout__form_card">

                            <h5 class="checkout__form__label"><?= __('Card number') ?>*</h5>
                            <div class="row aic">
                                <div class="col-md-9">
                                    <div class="input-card"><input type="text" class="input" placeholder="<?= __('Card number') ?>" name=""></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkout__form_card__payments">
                                        <img src="<?= ss_asset('img/icons/visa.svg') ?>" alt="">
                                        <img src="<?= ss_asset('img/icons/mastercard.svg') ?>" alt="">
                                        <img src="<?= ss_asset('img/icons/amex.svg') ?>" alt="">
                                    </div>
                                </div>

                                <div class="col-md-9">

                                    <div class="checkout__form_card__row">
                                        <div class="input-block">
                                            <h5 class="checkout__form__label"><?= __('Name of card') ?>*</h5>
                                            <input class="input" type="text" placeholder="Name of card"></input>
                                        </div>
                                        <div class="input-block">
                                            <h5 class="checkout__form__label">MM/YY*</h5>
                                            <input class="input" type="text" pattern="[0-9]{2}/[0-9]{2}" placeholder="MM/YY"></input>
                                        </div>
                                        <div class="input-block small">
                                            <h5 class="checkout__form__label">CVV*</h5>
                                            <input class="input" type="password" pattern="[0-9]{3}" placeholder="CVV"></input>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>

                </div>

                <!-- end payments -->

                

                <div class="checkout__block">
                    <h3 class="checkout__block__title"><?= __('Give as a Gift') ?></h3>

                    <div class="checkout__block__content">
                        <input type="checkbox" id="gift-checkbox">
                        <label for="gift-checkbox" class="checkbox-label"><?= __('Add Gift message') ?></label>
                    </div>
                </div>

                <div class="checkout__block">
                    <h3 class="checkout__block__title"><?= __('Give as a Gift') ?> <a href="#gift" class="magnific link link_bold"><?= __('Edit cart') ?></a></h3>

                    <div class="checkout__block__content">
                        <div class="checkout__gift__item">
                            <span class="left"><?= __('To') ?>: </span>
                            <span class="right"><?= $user->first_name . ' ' . $user->last_name ?></span>
                        </div>
                        <div class="checkout__gift__item">
                            <span class="left"><?= __('Recipient’s Email') ?>:</span>
                            <span class="right"><?= $user->user_email ?: 'Email not specified' ?></span>
                        </div>
                        <div class="checkout__gift__item">
                            <span class="left"><?= __('Recipient’s Mobile') ?>:</span>
                            <span class="right"><?= !empty($additional_fields['phone']) ? $additional_fields['phone'] : 'Phone not specified' ?></span>
                        </div>
                        <div class="checkout__gift__item">
                            <span class="left"><?= __('Yоur message') ?>: </span>
                            <span class="right"><?= __('Hope you enjoy the gift') ?>!</span>
                        </div>
                        <div class="checkout__gift__item">
                            <span class="left"><?= __('From') ?>:</span>
                            <span class="right"><?= $user->first_name . ' ' . $user->last_name ?></span>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="cart__sidebar">
                    <div class="cart__sidebar__title"><?= __('Summary') ?> (<?= WC()->cart->get_cart_contents_count() ?> <?= __('items') ?>)</div>
                    <div class="cart__sidebar__subtotal">
                        <div class="left"><?= __('Subtotal') ?></div>
                        <div class="right"><?= WC()->cart->get_subtotal() ?><?= get_woocommerce_currency_symbol() ?></div>
                    </div>
                    <div class="cart__sidebar__discount">
                        <h5><?= __('Gift card or discount code') ?></h5>
                        <form class="cart__sidebar__discount__form" <?= SS_FORM_POST ?>>
                            <?php wp_nonce_field('ss_discount'); ?>
                            <input type="hidden" name="action" value="apply_discount">
                            <input type="text" class="input" name="code" placeholder="<?= __('Enter code') ?>">
                            <button type="submit" class="button button-1 button_grey"><?= __('Apply') ?></button>
                        </form>
                    </div>
                    <div class="cart__sidebar__total">
                        <div class="left"><?= __('Total') ?></div>
                        <div class="right"><?= WC()->cart->total ?><?= get_woocommerce_currency_symbol() ?></div>
                    </div>
                    <div class="cart__sidebar__checkout">
                        <div class="cart__sidebar__privacy"><?= __('By clicking below I accept the current') ?> <a href="<?= get_field('terms_of_use_page') ?>" class="link link_bold"><?= __('Terms of Use') ?></a>
                            <?= __('and') ?> <a href="<?= get_field('privacy_policy_page') ?>" class="link link_bold"><?= __('Privacy Policy') ?>.</a></div>
                        <button class="button button-1"><?= __('Place Order') ?></button>
                        <?php
                        //     $checkout = WC()->checkout();
                        //     $order_id = $checkout->create_order();
                        //     $order = wc_get_order( $order_id );
                        // exit(var_dump($order));
                        // $order_id = $checkout->create_order();
                        ?>
                    </div>
                </div>

                <div class="cart__sidebar__secure"><img src="<?= ss_asset('img/icons/lock.svg') ?>" alt=""> <?= __('Payment 100% secure') ?></div>
            </div>
        </div>
    </div>

</div>

<div class="hidden">
    <div class="modal gift" id="gift">
        <div class="row">
            <div class="col-sm-6">
                <div class="gift__photo">
                    <img src="<?= ss_asset('img/card.jpg') ?>" alt="">
                </div>

                <a href="#!" class="order__title">Product Title Goes Here and here</a>
                <div class="order__subtitle"><span class="order__subtitle_mute">Options:</span> Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>

                <div class="card__location">Kiev, Ukraine</div>

            </div>

            <div class="col-sm-6">
                <h2 class="gift__title"><?= __('Customise your email card') ?></h2>
                <form>
                    <input type="text" class="input" placeholder="<?= __('To') ?>">
                    <textarea rows="6" class="input" placeholder="<?= __('Add your message') ?> (196 <?= __('out of') ?> 220 <?= __('characters left') ?>)"></textarea>
                    <input type="text" class="input" placeholder="<?= __('From') ?>">

                    <h4 class="gift__subtitle"><?= __('How do You want to send a gift-card') ?></h4>

                    <div class="gift__radio">
                        <input type="radio" id="g1" name="options" checked>
                        <label for="g1" class="radio-label radio-label_yellow">
                            <img src="<?= ss_asset('img/icons/email-yellow.svg') ?>" alt="">
                            <span><?= __('By Mail') ?></span>
                        </label>
                        <input type="radio" id="g2" name="options" checked>
                        <label for="g2" class="radio-label radio-label_yellow">
                            <img src="<?= ss_asset('img/icons/phone-yellow.svg') ?>" alt="">
                            <span><?= __('By SMS') ?></span>
                        </label>
                    </div>

                    <h5><?= __("Recipient's Mobile") ?>: </h5>

                    <div class="input-phone">
                        <label for="input-phone">+224</label>
                        <input type="tel" class="input input-phone__input" id="input-phone">
                    </div>

                    <button class="button button-1"><?= __('Continue to Checkout') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>