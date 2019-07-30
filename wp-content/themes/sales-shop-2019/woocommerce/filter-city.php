<?php 
$city_id = filter_input(INPUT_GET, 'city_id');
?>
<div class="filter__block">
    <h4 class="filter__title"><?= __('Select by cities') ?></h4>
    <?php foreach (ss_get_cities() as $key => $one) : ?>
        <div class="filter__item">
            <input data-filter="city_id" class="filter__var" type="checkbox" id="c_<?= $key ?>" value="<?= $one->ID ?>" <?= $city_id == $one->ID ? 'checked' : '' ?>>
            <label class="checkbox-label" for="c_<?= $key ?>"><?= $one->post_title ?></label>
        </div>
    <?php endforeach; ?>
</div>