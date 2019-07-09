<?php if ($banner_id = get_query_var('ss_banner_id')) : ?>
    <div class="container">
        <a href="<?= get_field('button_link', $banner_id) ?>" class="popular">
            <?php $banner_image_id = get_field('backgroung_image', $banner_id); ?>
            <?= wp_get_attachment_image($banner_image_id, 'full') ?>
            <div class="row no-gutters">
                <div class="col-md-7 col-xs-8 col-9">
                    <div class="popular__text">
                        <h1 class="popular__title"><?= get_field('title', $banner_id) ?></h1>
                        <div class="popular__subtitle"><?= get_field('subtitle', $banner_id) ?></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php endif; ?>