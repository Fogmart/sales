<?php /* Template Name: Main Page Template */ ?>
<?php get_header(); ?>
<?php global $ss_theme_option; ?>
<div class="main page">
	<?php ss_banner_full(get_field('banner_top')); ?>

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
			<h2 class="cards__block__title">Trending Deals <a href="#!" class="cards__block__link">View all</a></h2>
			<div class="cards">
				<div class="row">
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
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

	<div class="cards__block">
		<div class="container">
			<h2 class="cards__block__title">Deals from Cat #1 <a href="#!" class="cards__block__link">View all</a></h2>
			<div class="cards">
				<div class="row">
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="cards__block">
		<div class="container">
			<h2 class="cards__block__title">Deals from Cat #2 <a href="#!" class="cards__block__link">View all</a></h2>
			<div class="cards">
				<div class="row">
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="cards__block">
		<div class="container">
			<h2 class="cards__block__title">Deals from Cat #3 <a href="#!" class="cards__block__link">View all</a></h2>
			<div class="cards">
				<div class="row">
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="cards__block">
		<div class="container">
			<h2 class="cards__block__title">Deals from Cat #4 <a href="#!" class="cards__block__link">View all</a></h2>
			<div class="cards">
				<div class="row">
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
					<div class="col-md-3 col-sm-4 col-6">
						<a href="#!" class="card">
							<div class="card__photo">
								<img src="img/card.jpg" alt="">
								<div class="card__discount">-51%</div>
							</div>
							<div class="card__content">
								<div class="card__title">Pamper Spa Package for Two Spa Package</div>
								<div class="card__name">Charlotte Johnson</div>
								<div class="card__location">Kiev, Ukraine</div>
								<div class="card__old-price">45 200 000$</div>
								<div class="card__new-price">24 200 000$</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php ss_banner_full(get_field('banner_bottom')); ?>

</div>
<?php get_footer(); ?>