<div class="dashboard__vouchers__table__mobile">
    <?php foreach ($found_reports as $order_id => $coupons) : ?>
        <?php foreach ($coupons as $one) : ?>
            <?php
            $order_item_product = new WC_Order_Item_Product($one->order_item_id);
            $product = $order_item_product->get_product();
            $product_terms = get_the_terms($product->get_id(), 'product_cat');
            $product_term_names = array();
            foreach ($product_term_names as $term) {
                $product_term_names[] = $term->name;
            }
            ?>
            <div class="table-item">
                <div class="row">
                    <div class="col-6">
                        <div class="table-title"><?= __('voucher name') ?></div>
                    </div>
                    <div class="col-6">
                        <div class="table-value"><?= $product->name ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="table-title"><?= __('category') ?></div>
                    </div>
                    <div class="col-6">
                        <div class="table-value"><?= implode(', ', $product_term_names) ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="table-title"><?= __('Transactions') ?></div>
                    </div>
                    <div class="col-6">
                        <div class="table-value"><?= $product->get_total_sales() ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="table-title"><?= __('Total Revenue') ?></div>
                    </div>
                    <div class="col-6">
                        <div class="table-value">25 456 135</div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

