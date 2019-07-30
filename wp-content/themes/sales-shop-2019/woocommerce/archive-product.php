<?php
global $ss_theme_option;
defined('ABSPATH') || exit;
get_header();
do_action('woocommerce_before_main_content');
$term = get_queried_object();
?>

<?php if (woocommerce_product_loop()) { ?>

	<div class="category page">

		<?= ss_banner_full(get_field('banner', $term)) ?>

		<div class="container">
			<div class="row">
				<div class="col-md-3 filters-update">
					<?= wc_get_template_part('filters', 'archive') ?>
				</div>

				<div class="col-md-9">

					<?php echo do_shortcode('[dbc_breadcrumbs]'); ?>

					<div class="category__options">
						<div class="category__options__text"><?php woocommerce_result_count(); ?></div>
						<div class="category__filter">
							<div class="category__options__text"><?= __('Sort by') ?></div>
							<?php woocommerce_catalog_ordering() ?>
						</div>
					</div>

					<?php
					if (have_posts()) {
						woocommerce_product_loop_start();
						if (wc_get_loop_prop('total')) { ?>
							<div class="category__content cards">
								<div class="row js_appendTo">
									<?php
									while (have_posts()) {
										the_post();
										wc_get_template_part('content', 'product');
									} ?>
								</div>

								<?php
								if ($ss_theme_option["category-pagination"] === "1") {
									if (wc_get_loop_prop('total') > $ss_theme_option["category-pagination-amount"]) {
										?>
										<button class="button button-1 button-1_160 js_load_more_products"><?= __('load more') ?></button>
									<?php
									}
								} else {
									woocommerce_pagination();
								}
								?>
							</div>
						<?php }
						woocommerce_product_loop_end();
					}
					?>
				</div>
			</div>
		</div>

	</div>

<?php } else {
	do_action('woocommerce_no_products_found');
}
do_action('woocommerce_after_main_content');

?>
<?php get_footer(); ?>