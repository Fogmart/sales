<?php 
$keywords = filter_input(INPUT_GET, 'q');
?>
<div class="filter__block">
    <h4 class="filter__title"><?= __('Filter by Keyword') ?></h4>
    <form class="search">
        <input type="text" data-filter="q" class="filter__var filter__single" value="<?= $keywords ?>" placeholder="<?= __('Keywords') ?>">
        <button class="button button-3"><img src="<?= ss_asset('img/icons/search.svg') ?>" alt=""></button>
    </form>
</div>