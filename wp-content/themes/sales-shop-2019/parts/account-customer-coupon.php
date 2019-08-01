<?php
global $ss_theme_option;
$order_item = get_query_var('ss_order_item');
$show_status = get_query_var('ss_show_status');

$coupon = $order_item->get_product();
$coupon_order = $order_item->get_order();
$exp_date = strtotime(date("Y-m-d", $coupon_order->order_date) . '+ ' . (int)$ss_theme_option['coupon-validity'] . ' day');
?>
<div class="order">
    <div class="order__photo">
        <?= $coupon->get_image('thumbnail') ?>
    </div>
    <div class="order__content">
        <a href="<?= $coupon->get_permalink() ?>" class="order__title"><?= get_the_title($coupon->get_id()) ?></a>
        <div class="order__subtitle_mute"><?= get_the_title($coupon->get_id()) ?></div>
        <div class="order__block__price"><?= $coupon->get_price() ?> <?= get_woocommerce_currency_symbol() ?></div>

        <div class="order__details">
            <div class="order__details__block">
                <div class="order__block__title"><?= __('Purchase Date:') ?></div>
                <div class="order__block__text"><?= date_i18n('F j, Y', $coupon_order->order_date) ?></div>
            </div>
            <div class="order__details__block">
                <div class="order__block__title"><?= __('Expiration Date:') ?></div>
                <div class="order__block__text"><?= date_i18n('F j, Y', $exp_date) ?></div>
            </div>
            <?php if ($coupon_status = ss_get_coupon_status($coupon->get_id()) && $show_status) : ?>
                <div class="order__details__block status">
                    <div class="order__block__title"><?= __('Status:') ?></div>
                    <div class="order__block__status canceled"><?= $coupon_status ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>