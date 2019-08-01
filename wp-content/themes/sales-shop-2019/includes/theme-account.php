<?php

function ss_render_account_customer_loop($coupons, $show_status, $pagination_var_name = null)
{
    $coupons_total = count($coupons);
    $coupons_from = 0;
    $coupons_to = $coupons_total;

    for ($i = $coupons_from; $i < $coupons_to; $i++) {
        $order_item = $coupons[$i];
        echo ss_render_account_customer_coupon($order_item, $show_status);
    }
    ?>

    <div class="orders__control">
        <?php $coupons_from = $coupons_total > 0 ? $coupons_from + 1 : $coupons_from; ?>
        <div class="orders__control__text"><?= __("Showing $coupons_from to $coupons_to of $coupons_total entries") ?></div>
        <div class="orders__control__buttons">
            <button class="button button-1 button-1_120"><?= __('Previous') ?></button>
            <button class="button button-1 button-1_120"><?= __('Next') ?></button>
        </div>
    </div>
<?php

}
