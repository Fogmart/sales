<div class="filter__accordeon">
    <div class="filter__toggler">
        <?= __('filter') ?>
        <img src="<?= ss_asset('img/icons/angle-down.svg') ?>" alt="">
    </div>
    <div class="filter">

        <?php wc_get_template_part('filter', 'city') ?>

        <?php wc_get_template_part('filter', 'neighborhood') ?>

        <?php wc_get_template_part('filter', 'keywords') ?>

        <?php wc_get_template_part('filter', 'price') ?>

        <?php wc_get_template_part('filter', 'category') ?>

    </div>
</div>