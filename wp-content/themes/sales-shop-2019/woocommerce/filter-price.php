<?php 
$prices = ss_get_loop_prices();
$curr_min_price = filter_input(INPUT_GET, 'min_price') ?: $prices->min_price ?? 11;
$curr_max_price = filter_input(INPUT_GET, 'max_price') ?: $prices->max_price ?? 2000;
?>
<input type="hidden" id="loop_min_price" value="0">
<input type="hidden" id="loop_max_price" value="<?= $prices->max_price ?? 20000 ?>">
<input type="hidden" id="loop_curr_min_price" value="<?= $curr_min_price ?>">
<input type="hidden" id="loop_curr_max_price" value="<?= $curr_max_price ?>">

<?php do_action('ss_price_filter_params') ?>
<div class="filter__block">
    <h4 class="filter__title"><?= __('Filter by Price') ?></h4>
    <div id="price-range"></div>
    <div class="price-range__block">

        <div class="price-range__item">
            <input type="text" class="input price-min" data-filter="price" id="price-min">
        </div>

        <span><?= __('to') ?></span>

        <div class="price-range__item">
            <input type="text" class="input price-max" data-filter="price" id="price-max">
        </div>

    </div>
</div>