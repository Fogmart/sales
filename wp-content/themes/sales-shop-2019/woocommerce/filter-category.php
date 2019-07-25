<div class="filter__block">
    <h4 class="filter__title"><?= __('Filter by Category') ?></h4>
    <?php

    $taxonomy     = 'product_cat';
    $orderby      = 'name';
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no  
    $title        = '';
    $empty        = 0;

    $args_cat = array(
        'taxonomy'     => $taxonomy,
        'orderby'      => $orderby,
        'show_count'   => $show_count,
        'pad_counts'   => $pad_counts,
        'hierarchical' => $hierarchical,
        'title_li'     => $title,
        'hide_empty'   => $empty
    );
    $all_categories = get_categories($args_cat);
    foreach ($all_categories as $cat) {
        if ($cat->category_parent == 0) {
            $category_id = $cat->term_id;

            //subcategories
            $args_subcat = array(
                'taxonomy'     => $taxonomy,
                'child_of'     => 0,
                'parent'       => $category_id,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
            );
            $sub_cats = get_categories($args_subcat);
            ?>
            <div class="filter__item accordeon">
                <div class="filter__item__title">
                    <input type="checkbox" id="cat<?= $cat->ID ?>" value="<?= $cat->ID ?>">
                    <label class="checkbox-label" for="cat2"><?= $cat->name ?></label>
                    <?php if (!empty($sub_cats)) : ?>
                        <button class="accordeon__button"><img src="<?= ss_asset('img/icons/angle-down-black.svg') ?>" alt=""></button>
                    <?php endif; ?>
                </div>
                <?php if (!empty($sub_cats)) : ?>
                    <div class="accordeon__content">
                        <?php foreach ($sub_cats as $sub_category) : ?>
                            <div class="filter__subcat">
                                <input type="checkbox" id="subcat5">
                                <label class="checkbox-label" for="subcat5"><?= $sub_category->name ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php
        }
    }
    ?>
</div>