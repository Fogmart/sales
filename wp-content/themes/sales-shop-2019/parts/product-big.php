<?php if ($product = get_query_var('ss_product')) : ?>
    <div class="card__big">
        <div class="row no-gutters">
            <div class="col-sm-8 card__photo">
                <?= $product->get_image('full') ?>
                <div class="card__discount">-51%</div>
            </div>
            <div class="col-sm-4 card__content">
                <div class="card__title"><?= $product->name ?></div>
                <div class="card__name"><?= $product->seller->name ?></div>
                <div class="card__location">
                    <span class="city"><?= $product->city->name ?></span>,
                    <span class="neighborhood"><?= $product->neighborhood ?></span>
                </div>
                <div class="card__old-price">45 200 000$</div>
                <div class="card__new-price">24 200 000$</div>
                <div class="card__big__button">
                    <a href="<?= $product->get_permalink() ?>">
                        <button class="button button-1">
                            <?= __('View now') ?>
                        </button>
                    </a>
                </div>
                <div class="limited"><img src="<?= ss_asset('img/icons/chronometer.svg')?>" alt=""><?= __('Limited only') ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>