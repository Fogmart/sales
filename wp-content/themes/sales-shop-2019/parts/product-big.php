<?php if ($product = get_query_var('ss_product')) : ?>
    <div class="card__big">
        <div class="row no-gutters">
            <div class="col-sm-8 card__photo">
                <?= $product->get_image('full') ?>
                <div class="card__discount">
                    -<?= $product->sale_percentage ?>%
                </div>
            </div>
            <div class="col-sm-4 card__content">
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
                <div class="card__big__button">
                    <a href="<?= $product->get_permalink() ?>">
                        <button class="button button-1">
                            <?= __('View now') ?>
                        </button>
                    </a>
                </div>
                <div class="limited"><img src="<?= ss_asset('img/icons/chronometer.svg') ?>" alt=""><?= __('Limited only') ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>