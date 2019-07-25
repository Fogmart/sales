<div class="filter__block">
    <h4 class="filter__title"><?= __('Filter by neighborhoods') ?></h4>
    <?php foreach (ss_get_neighborhoods() as $key => $one) : ?>
        <div class="filter__item">
            <input type="checkbox" id="n_<?= $key ?>" value="<?= json_encode($one) ?>">
            <label class="checkbox-label" for="n_<?= $key ?>"><?= $one->name ?><?= $one->name ?></label>
        </div>
    <?php endforeach; ?>
</div>