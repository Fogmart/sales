<?php
$city_id = filter_input(INPUT_GET, 'city_id');
$disabled = !isset($city_id);
$neighborhoods_args = filter_input(INPUT_GET, 'neighborhood') ?: array();
if (!empty($neighborhoods_args)) {
    $neighborhoods_args = explode(',', urldecode($neighborhoods_args));
}

$neighborhoods = $disabled ? ss_get_neighborhoods() : ss_get_neighborhoods($city_id);
?>
<div class="filter__block">
    <h4 class="filter__title"><?= __('Filter by neighborhoods') ?></h4>
    <?php foreach ($neighborhoods as $key => $one) : ?>
        <?php
        //if no city selected - break
        if ($disabled && $key > 5) {
            break;
        }
        $checked = in_array($one->name, $neighborhoods_args);
        ?>
        <div class="filter__item">
            <input type="checkbox" class="filter__var" data-filter="neighborhood" id="n_<?= $key ?>" value="<?= $one->name ?>" <?= $checked ? 'checked' : '' ?> <?= $disabled ? 'disabled' : '' ?>>
            <label class="checkbox-label" for="n_<?= $key ?>"><?= $one->name ?></label>
        </div>
    <?php endforeach; ?>
</div>