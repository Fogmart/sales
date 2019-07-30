<?php if ($product = get_query_var('ss_product')) : ?>
    <div class="product__added">
        <div class="container">
            <div class="product__added__block">
                <div class="product__added__photo">
                    <?= get_the_post_thumbnail($product->id, 'thumbnail') ?>
                </div>
                <h4 class="product__added__title">
                    <?= $product->name ?>
                    
                </h4>
            </div>
            <div class="product__added__block">
                <div class="product__added__buttons">
                    <button class="button button-1 button-1_160 button_light" onClick="window.location.href='<?= wc_get_cart_url() ?>'"><?= __('View Cart')?></button>
                    <button class="button button-1 button-1_160" onClick="window.location.href='<?= wc_get_checkout_url() ?>'"><?= __('checkout')?></button>
                </div>
                <button class="product__added__remove" onClick="removeAddBar()">
                    <img src="<?= ss_asset('img/icons/remove.svg') ?>" alt="">
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>