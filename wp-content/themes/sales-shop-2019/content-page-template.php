<?php /* Template Name: Content Page Template */
global $ss_theme_option;
get_header() ?>
<div class="content page">

    <?php ss_banner_full(get_field('banner')) ?>

    <div class="container">
        <?= do_shortcode('[dbc_breadcrumbs]'); ?>
        <h1 class="main-title"><?php the_title() ?></h1>
        <div class="content__content">
            <?php foreach (get_field('blocks') as $one) : $image = $one['image'] ?>
                <div class="content__block">
                    <div class="row">
                        <div class="col-md-4 content__block__photo <?= $image['position'] == 'right' ? 'order-md-2' : '' ?>">
                            <?= wp_get_attachment_image($image['file']) ?>
                        </div>
                        <div class="col-md-8 content__block__text <?= $image['position'] == 'right' ? 'order-md-1' : '' ?>">
                            <?php foreach ($one['text_blocks'] as $one_block) : ?>
                                <?php if ($one_block['acf_fc_layout'] == 'text') : ?>
                                    <p class="text"><?= $one_block['text'] ?></p>
                                <?php elseif ($one_block['acf_fc_layout'] == 'subtitle') : ?>
                                    <h2 class="content__subtitle"><?= $one_block['text'] ?></h2>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php get_footer() ?>