<?php /* Template Name: Сart Page Template */

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

<div class="cart page">

    <div class="container">
        <h1 class="cart__title"><?= __('My Cart') ?></h1>

        <div class="cart__content">
            <div class="row">
                <div class="col-md-9">
                    <div class="cart__main">

                        <?php
                        foreach ($items as $cart_item_key => $cart_item) :
                            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
                                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
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
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                        } else {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="order__title">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                        }
                                        ?>
                                        <div class="order__subtitle"><span class="order__subtitle_mute"><?= __('Options') ?>:</span> <?= get_the_title($_product->get_id()) ?></div>

                                        <div class="order__details">
                                            <div class="order__details__block">
                                                <div class="order__block__title"><?= __('Price') ?>:</div>
                                                <div class="order__block__price"><?= $_product->get_price() ?><?= get_woocommerce_currency_symbol() ?></div>
                                            </div>
                                            <div class="order__details__block quantity">
                                                <div class="order__block__title"><?= __('quantinty') ?></div>
                                                <div class="order__block__stepper">
                                                    <div class="input-stepper">
                                                        <input type="number" class="quantity_field" data-key="<?= $cart_item_key ?>" name="quantity" value="<?= $cart_item['quantity'] ?>" disabled />
                                                        <div class="input-stepper__buttons">
                                                            <button class="plus"><img src="<?= ss_asset('img/icons/angle-up-white.svg') ?>" alt=""></button>
                                                            <button class="minus"><img src="<?= ss_asset('img/icons/angle-down-white.svg') ?>" alt=""></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order__details__block">
                                                <div class="order__block__title"><?= __('total') ?>:</div>
                                                <div class="order__block__total"><?= WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ) ?></div>
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
                <div class="col-md-3">
                    <div class="cart__sidebar">
                        <div class="cart__sidebar__title"><?= __('Summary') ?> (<?= WC()->cart->get_cart_contents_count() ?> <?= __('items') ?>)</div>
                        <div class="cart__sidebar__subtotal">
                            <div class="left"><?= __('Subtotal') ?></div>
                            <div class="right"><?= WC()->cart->get_subtotal() ?><?= get_woocommerce_currency_symbol() ?></div>
                        </div>
                        <div class="cart__sidebar__total">
                            <div class="left"><?= __('Total') ?></div>
                            <div class="right"><?= WC()->cart->total ?><?= get_woocommerce_currency_symbol() ?></div>
                        </div>
                        <div class="cart__sidebar__checkout">
                            <a href="<?= wc_get_checkout_url() ?>">
                                <button class="button button-1"><?= __('checkout') ?></button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .cart .order__photo img {height: 100%}
</style>
<script>
    $(function () {
        $('.input-stepper .plus, .input-stepper .minus').click(function () {
            let stepperInput = $(this).closest('.input-stepper').find('.quantity_field');
            let send_data = {
                'action': 'quantity_order_form',
                '_wpnonce': '<?= wp_create_nonce('ss_quantity_order_form') ?>',
                'key': stepperInput.attr('data-key'),
                'quantity': stepperInput.val()
            };

            $.post('<?= esc_url(admin_url('admin-ajax.php')) ?>', send_data, function (data) {
                if (data == 'ok') {
                    window.location.reload();
                }
            });
        })
    });
</script>

<?php get_footer(); ?>