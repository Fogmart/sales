<?php if ($banner_id = get_query_var('ss_banner_id')) : ?>
    <div class="col-md-4">
        <a href="<?= get_field('button_link', $banner_id) ?>" class="banner">
            <?php $banner_image_id = get_field('backgroung_image', $banner_id); ?>
            <?= wp_get_attachment_image($banner_image_id, 'full') ?>
            <h2 class="banner__title"><?= get_field('title', $banner_id) ?></h2>
        </a>
    </div>
<?php endif; ?>