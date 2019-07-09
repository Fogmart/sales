<?php if ($banner_id = get_query_var('ss_banner_id')) : ?>
    <div class="col-md-8">
        <div class="banner">
            <?php $banner_image_id = get_field('backgroung_image', $banner_id); ?>
            <?= wp_get_attachment_image($banner_image_id, 'full') ?>
            <div class="banner__content">
                <h2 class="banner__title"><?= get_field('title', $banner_id) ?></h2>
                <div class="banner__text"><?= get_field('subtitle', $banner_id) ?></div>
                <?php if ($button_text = get_field('button_text', $banner_id)) : ?>
                    <button class="button button-2 button-2_1">
                        <?php if ($button_image_id = get_field('button_icon', $banner_id)) : ?>
                            <span class="button-2__icon">
                                <?= wp_get_attachment_image($button_image_id, 'full') ?>
                            <?php endif; ?>
                        </span>
                        <span class="button-2__text"><?= $button_text ?></span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>