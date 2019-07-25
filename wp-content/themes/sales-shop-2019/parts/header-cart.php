<?php
$items = WC()->cart->get_cart();
?>
<span class="control__icon">
    <img src="<?= ss_asset('img/icons/cart.svg') ?>" alt="">
    <span class="control__counter"><?= WC()->cart->get_cart_contents_count() ?></span>
</span>
<span class="control__link"><?= __('Cart') ?></span>
<div class="control__cart control__popup">
    <div class="control__cart__content">
        <?php foreach ($items as $key => $one) : ?>
            <?php $product = ss_get_product($one['product_id']) ?>
            <div class="control__cart__item">
                <div class="photo">
                    <?= $product->get_image('full') ?>
                </div>
                <div class="info">
                    <div class="title" onclick="window.location.href='<?= $product->get_permalink() ?>'">
                        <?= $product->get_name() ?>
                    </div>

                    <div class="quantity"><?= $one['quantity'] ?> <?= __('item') ?></div>
                </div>
                <div class="price"><?= $product->get_price() ?><?= get_woocommerce_currency_symbol() ?></div>
                <button class="remove" onclick="window.location.href='<?= wc_get_cart_remove_url($key) ?>'">
                    <img src="<?= ss_asset('img/icons/remove.svg') ?>" alt="">
                </button>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($items) === 0) : ?>
        <div><?= __('Your cart is empty') ?></div>
    <?php endif; ?>
    <?php if (count($items) > 0) : ?>
        <div class="control__cart__total">
            <div class="text"><?= __('Total') ?></div>
            <div class="sum"><?= WC()->cart->total ?><?= get_woocommerce_currency_symbol() ?></div>
        </div>
        <div class="control__cart__buttons">
            <a href="<?= wc_get_cart_url() ?>">
                <button class="button button-1 button-1_120 button_light"><?= __('View cart') ?></button>
            </a>
            <a href="<?= wc_get_checkout_url() ?>">
                <button class="button button-1 button-1_120"><?= __('Checkout') ?></button>
            </a>
        </div>
    <?php endif; ?>
</div>