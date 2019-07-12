<?php /* Template Name: Main Page Template */ ?>
<?php get_header(); ?>
<?php global $ss_theme_option; ?>
<div class="main page">
	<?php ss_banner_full(get_field('banner_top')); ?>
	<?php echo do_shortcode('[model_price_table]')?>
	<div class="popular-block">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="popular-categories">
						<div class="popular-categories__title"><?= __('Popular') ?></div>
						<div class="popular-categories__content">
							<?php foreach (get_field('popular_categories') as $one) : ?>
								<a href="#!" class="popular-categories__item">
									<div class="item__icon">
										<?php if ($thumbnail_id = get_woocommerce_term_meta($one->term_id, 'thumbnail_id', true)) : ?>
											<img src="<?= wp_get_attachment_url($thumbnail_id) ?>" alt="">
										<?php endif; ?>
									</div>
									<div class="item__title"><?= $one->name ?></div>
									<div class="item__quantity"><?= $one->count ?></div>
								</a>
							<?php endforeach; ?>
						</div>
						<a href="<?= get_field('view_all_categories_link') ?>" class="popular-categories__all"><?= __('View all categories') ?> <img src="<?= ss_asset('img/angle-right-grey.svg') ?>" alt=""></a>
					</div>
				</div>
				<div class="col-md-9">
					<?php ss_render_product_big($ss_theme_option['promoted-product-id']) ?>
				</div>
			</div>
		</div>
	</div>

	<div class="cards__block">
		<div class="container">
			<h2 class="cards__block__title"><?= __('Trending Deals') ?>
				<?php if ($tranding_view_category = get_field('tranding_view_category')) : ?>
					<a href="<?= get_term_link($tranding_view_category) ?>" class="cards__block__link"><?= __('View all') ?></a>
				</h2>
			<?php endif; ?>
			<div class="cards">
				<div class="row">
					<?php foreach (get_field('tranding_products') as $one) : ?>
						<div class="col-md-3 col-sm-4 col-6">
							<?php ss_render_product_card($one) ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="banners">
		<div class="container">
			<div class="row">
				<?php ss_banner_two(get_field('banner_middle_left')); ?>
				<?php ss_banner_one(get_field('banner_middle_right')); ?>
			</div>
		</div>
	</div>

	<?php foreach (get_field('deals_from_categories') as $one) : ?>
		<div class="cards__block">
			<div class="container">
				<h2 class="cards__block__title">
					<?= __('Deals from') ?> <?= $one['category']->name ?>
					<a href="<?= get_term_link($one['category']) ?>" class="cards__block__link">
						<?= __('View all') ?>
					</a>
				</h2>
				<div class="cards">
					<div class="row">
						<?php foreach($one['items'] as $item): ?>
							<div class="col-md-3 col-sm-4 col-6">
								<?php ss_render_product_card($item) ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<?php ss_banner_full(get_field('banner_bottom')); ?>

</div>
<?php get_footer(); ?>