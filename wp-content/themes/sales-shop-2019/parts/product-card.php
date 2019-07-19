<?php if ($product = get_query_var('ss_product')) : ?>
    <a href="<?= $product->get_permalink() ?>" class="card">
        <div class="card__photo">
            <?= $product->get_image('full') ?>
            <?php if ($product->is_on_sale()) : ?>
                <div class="card__discount">-<?= $product->sale_percentage ?>%</div>
            <?php endif; ?>
        </div>
        <div class="card__content">
            <div class="card__title"><?= $product->get_name() ?></div>
            <div class="card__name"><?= $product->seller->name ?></div>
            <div class="card__location">
                <?= $product->city->country ?>, <?= $product->city->name ?>
            </div>
            <div class="card__old-price">
                <?= $product->get_regular_price() ?><?= get_woocommerce_currency_symbol() ?>
            </div>
            <?php if ($product->is_on_sale()) : ?>
                <div class="card__new-price">
                    <?= $product->get_sale_price() ?><?= get_woocommerce_currency_symbol() ?>
                </div>
            <?php endif; ?>
        </div>
    </a>
<?php endif; ?>