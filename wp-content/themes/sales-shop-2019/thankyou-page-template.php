<?php /* Template Name:  Thankyou Page Template */
if (null === WC()->session) {
    $session_class = apply_filters('woocommerce_session_handler', 'WC_Session_Handler');
    WC()->session = new $session_class();
    WC()->session->init();
}

$order_id = WC()->session->get('order_id');

if (empty($order_id)) {
    ss_return_home();
}

global $ss_theme_option;
$user = ss_get_user();
$order = wc_get_order($order_id);

get_header();
?>

<div class="checkout-success page">

    <div class="container">

        <div class="checkout__top-line">
            <div class="left">
                <div class="checkout__success__icon"><img src="<?= ss_asset('img/icons/success-grey.svg') ?>" alt=""></div>
            </div>
            <div class="right">
                <h1 class="checkout__title"><?= __('Thank you') ?>, <?= $user->first_name ?>!</h1>
                <h2 class="checkout__subtitle"><?= __('Order') ?> #<?= $order_id ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="checkout-success__block">
                    <p class="checkout-success__text"><?= __('Your order is confirmed') ?>. <br>
                        <?= __("We've accepted your order and we're getting it ready") ?>.</p>
                </div>

                <h2 class="checkout-success__block__title"><?= __('Order details') ?></h2>
                <div class="checkout-success__block">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="order-page__item">
                                <div class="order-page__item__title"><?= __('Order Number') ?>:</div>
                                <div class="order-page__item__value">#<?= $order_id ?></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="order-page__item">
                                <div class="order-page__item__title"><?= __('Purchase Date') ?>:</div>
                                <div class="order-page__item__value"><?= $order->get_date_created()->date_i18n('F j, Y') ?></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="order-page__item">
                                <div class="order-page__item__title"><?= __('Payment Method') ?>:</div>
                                <div class="order-page__item__value"><?= __($order->get_payment_method_title()) ?></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="order-page__item">
                                <div class="order-page__item__title"><?= __('Total') ?>:</div>
                                <div class="order-page__item__value"><?= $order->get_formatted_order_total() ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-success__billing">
                        <div class="order-page__item">
                            <span class="order-page__item__title"><?= __('Billing Details') ?>:</span>
                            <span class="order-page__item__value"><?= $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() ?></span>
                            <span class="order-page__item__value"><?= $order->get_billing_email() ?></span>
                            <span class="order-page__item__value"><?= $order->get_billing_phone() ?></span>
                        </div>
                    </div>
                </div>

                <?php foreach ($order->get_items() as $key => $coupon) : ?>
                    <?php
                    $coupon_data = $coupon->get_data();

                    $seller = get_field('seller', $coupon_data['product_id']);
                    $coupon_validity = get_field('coupon_validity', $$coupon_data['product_id']);
                    $coupon_validity = !empty($coupon_validity) && $coupon_validity > 0 ? $coupon_validity : $ss_theme_option['coupon-validity'];
                    $order_date = clone ($order->get_date_completed() ?? $order->get_date_created());
                    $expiration_date = $order_date->add(new DateInterval('P' . $coupon_validity . 'D'))->date_i18n('F j, Y');
                    ?>
                    <div class="checkout-success__block">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="order-page__item">
                                    <div class="order-page__item__title"><?= __('Products') ?>:</div>
                                    <div class="order-page__item__value">
                                        <ul>
                                            <li>
                                                <a href="<?= get_permalink($coupon->get_product_id()) ?>" class="link link_bold"><?= $coupon->get_name() ?></a>
                                                <span class="order-page__item__quantity">X<?= $coupon->get_quantity() ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="order-page__item">
                                    <div class="order-page__item__title"><?= __('Supplier') ?>:</div>
                                    <div class="order-page__item__value"><?= $seller->display_name ?> </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="order-page__item">
                                    <div class="order-page__item__title"><?= __('Expiration date') ?>:</div>
                                    <div class="order-page__item__value"><?= $expiration_date ?></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="order-page__item">
                                    <div class="order-page__item__title"><?= __('Subotal') ?>:</div>
                                    <div class="order-page__item__value"><?= $coupon_data['total'] ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-success__receive">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="checkout-success__receive__title"><?= __('Want to receive the coupon in SMS?') ?></div>
                                    <div class="checkout-success__receive__input">
                                        <div class="input-phone">
                                            <label for="input-phone-<?= $key ?>">+224</label>
                                            <input type="tel" class="input input-phone__input" id="input-phone-<?= $key ?>">
                                        </div>
                                    </div>
                                    <button data-id="input-phone-<?= $key ?>" data-coupon="<?= $coupon_data['coupon_number'] ?>" data-type="phone" class="ss_send_button checkout-success__receive__button button button-1">
                                        <span class="msg"><?= __('Send me the coupon as SMS') ?></span>
                                    </button>
                                </div>
                                <div class="col-xs-6">
                                    <div class="checkout-success__receive__title"><?= __('Want to receive the coupon in E-MAIL?') ?></div>
                                    <div class="checkout-success__receive__input">
                                        <input type="email" id="input-email-<?= $key ?>" class="input" placeholder="<?= __('Your e-mail') ?>">
                                    </div>
                                    <button data-id="input-email-<?= $key ?>" data-coupon="<?= $coupon_data['coupon_number'] ?>" data-type="email" class="ss_send_button checkout-success__receive__button button button-1">
                                        <span class="msg"><?= __('Send me the coupon as Email') ?></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="col-md-4">
                <div class="product__details product__block">
                    <div class="product__details__tabs">
                        <button class="product__details__tab active"><?= __('The Fine Print') ?></button>
                        <button class="product__details__tab"><?= __('Supplier Information') ?></button>
                    </div>

                    <div class="product__details__content">
                        <div class="product__details__block">
                            <p class="product__text">Lorem ipsum dolor sit amet, consectetur
                                adipisicing lorem ipsum dolor sit amet, consectetur
                                adipisicing ipsum dolor sit amet, tetur
                                adipisicing Lorem ipsum dolor sit amet, consectetur</p>
                            <p class="product__text">Lorem ipsum dolor sit amet, consectetur
                                adipisicing lorem ipsum dolor sit amet, consectetur
                                adipisicing ipsum dolor sit amet, tetur</p>
                            <p class="product__text">Lorem ipsum dolor sit amet, consectetur
                                adipisicing lorem ipsum dolor sit amet, consectetur
                                adipisicing ipsum dolor sit amet, tetur
                                adipisicing Lorem ipsum dolor sit amet, consectetur
                                adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing </p>
                        </div>
                        <div class="product__details__block">
                            <p class="product__text">123</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    $(function() {
        $('.ss_send_button').click(function() {
            var button_send = $(this);

            let send_data = {
                'action': 'send_coupon_form',
                '_wpnonce': '<?= wp_create_nonce('ss_send_coupon_form') ?>',
                'type': $(this).attr('data-type'),
                'coupon': $(this).attr('data-coupon'),
                'to': $('#' + $(this).attr('data-id')).val()
            };

            if (send_data['to'].length > 0) {
                $.post('<?= esc_url(admin_url('admin-ajax.php')) ?>', send_data)
                    .done(function(response) {
                        var data = response.data;

                        button_send.addClass('send');
                        button_send.find('.msg').html(data.message);
                        button_send.attr('disabled', 'disabled');
                    });
            }
        })
    });
</script>

<?php get_footer(); ?>