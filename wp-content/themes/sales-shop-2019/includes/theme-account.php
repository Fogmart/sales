<?php

function ss_render_account_customer_loop($coupons, $show_status, $pagination_var_name = null, $pagination_per_page = null)
{
    $page_num = null;
    if (isset($pagination_var_name)) {
        $page_num = filter_input(INPUT_GET, $pagination_var_name, FILTER_VALIDATE_INT);
    }
    $coupons_total = count($coupons);
    $coupons_from = 0;
    $coupons_to = $coupons_total;

    if (!is_null($page_num) && $page_num !== false) {
        $coupons_from = max($page_num * $pagination_per_page, 0);
        if ($coupons_from >= $coupons_total) {
            $coupons_from = max($coupons_total - $pagination_per_page, 0);
        }
    }

    $coupons_to_temp = $coupons_from + $pagination_per_page;
    $coupons_to = $coupons_to_temp > $coupons_total ? $coupons_total : $coupons_to_temp;

    for ($i = $coupons_from; $i < $coupons_to; $i++) {
        $order_item = $coupons[$i];
        echo ss_render_account_customer_coupon($order_item, $show_status);
    }

    $next_last = $coupons_total - $coupons_to;
    $has_prev = $coupons_from !== 0;
    ?>

    <div class="orders__control">
        <form method="GET">
            <?php $coupons_from = $coupons_total > 0 ? $coupons_from + 1 : $coupons_from; ?>
            <div class="orders__control__text"><?= __("Showing $coupons_from to $coupons_to of $coupons_total entries") ?></div>
            <div class="orders__control__buttons">
                <?php if ($has_prev) : ?>
                    <button class="button button-1 button-1_120" type="submit" name="<?= $pagination_var_name ?>" value="<?= ($page_num - 1) ?>"><?= __('Previous') ?></button>
                <?php endif; ?>
                <?php if ($next_last !== 0) : ?>
                    <button class="button button-1 button-1_120" type="submit" name="<?= $pagination_var_name ?>" value="<?= ($page_num + 1) ?>"><?= __('Next') ?></button>
                <?php endif; ?>
            </div>
        </form>
    </div>
<?php

}
