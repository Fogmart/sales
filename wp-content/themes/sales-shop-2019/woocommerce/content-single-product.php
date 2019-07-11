<?php
defined('ABSPATH') || exit;

global $product;
$product_obj = ss_get_product(get_the_ID());

do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div class="product page" id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
	<div class="container">

		<?php echo do_shortcode('[dbc_breadcrumbs]'); ?>
		<?php woocommerce_template_single_title(); ?>

		<div class="row">
			<div class="col-md-9">
				<div class="product__main product__block">
					<div class="product__main__top">
						<div class="card__name">
							<?php echo $product_obj->seller->name; ?>
						</div>
						<div class="card__location">
							<?php echo $product_obj->city->country . ", " . $product_obj->city->name; ?>
						</div>
					</div>

					<div class="product__main__slider_for">
						<div class="product__main__photo"><img src="img/card-big.jpg" alt=""></div>
						<div class="product__main__photo"><img src="img/card.jpg" alt=""></div>
						<div class="product__main__photo"><img src="img/card-big.jpg" alt=""></div>
						<div class="product__main__photo"><img src="img/card.jpg" alt=""></div>
						<div class="product__main__photo"><img src="img/card-big.jpg" alt=""></div>
						<div class="product__main__photo"><img src="img/card.jpg" alt=""></div>
						<div class="product__main__photo"><img src="img/card-big.jpg" alt=""></div>
						<div class="product__main__photo"><img src="img/card.jpg" alt=""></div>
					</div>
					<div class="product__main__slider_nav">
						<div class="product__main__slider_nav__photo"><img src="img/card-big.jpg" alt=""></div>
						<div class="product__main__slider_nav__photo"><img src="img/card.jpg" alt=""></div>
						<div class="product__main__slider_nav__photo"><img src="img/card-big.jpg" alt=""></div>
						<div class="product__main__slider_nav__photo"><img src="img/card.jpg" alt=""></div>
						<div class="product__main__slider_nav__photo"><img src="img/card-big.jpg" alt=""></div>
						<div class="product__main__slider_nav__photo"><img src="img/card.jpg" alt=""></div>
						<div class="product__main__slider_nav__photo"><img src="img/card-big.jpg" alt=""></div>
						<div class="product__main__slider_nav__photo"><img src="img/card.jpg" alt=""></div>
					</div>
				</div>

				<div class="product__sidebar_mobile"></div>

				<div class="product__details product__block">
					<div class="product__details__tabs">
						<button class="product__details__tab active">Product Details</button>
						<button class="product__details__tab">The Fine Print</button>
					</div>

					<div class="product__details__content">
						<div class="product__details__block">
							<p class="product__text">Lorem ipsum dolor sit amet, consectetur
								adipisicing lorem ipsum dolor sit amet, consectetur
								adipisicing ipsum dolor sit amet, tetur
								adipisicing Lorem ipsum dolor sit amet, consectetur
								adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur
								adipisicing lorem ipsum dolor sit amet, consectetur
								adipisicing ipsum dolor sit amet, tetur
								adipisicing Lorem ipsum dolor sit amet, consectetur
								adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet</p>
							<p class="product__text">Lorem ipsum dolor sit amet, consectetur
								adipisicing lorem ipsum dolor sit amet, consectetur
								adipisicing ipsum dolor sit amet, tetur
								adipisicing Lorem ipsum dolor sit amet, consectetur
								adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet</p>
							<p class="product__text">Lorem ipsum dolor sit amet, consectetur
								adipisicing lorem ipsum dolor sit amet, consectetur
								adipisicing ipsum dolor sit amet, tetur
								adipisicing Lorem ipsum dolor sit amet, consectetur
								adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit ametLorem ipsum dolor sit amet, consectetur
								adipisicing lorem ipsum dolor sit amet, consectetur
								adipisicing ipsum dolor sit amet, tetur
								adipisicing Lorem ipsum dolor sit amet, consectetur
								adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet</p>
						</div>
						<div class="product__details__block">
							<p class="product__text">123</p>
						</div>
					</div>
				</div>

				<div class="product__supplier product__block">
					<div class="row">
						<div class="col-md-5">
							<h4 class="product__supplier__title">Supplier Information</h4>
							<div class="card__name">Charlotte Johnson</div>
							<div class="card__location">Kiev, Ukraine</div>
							<div class="product__supplier__rating">
								<div class="rating">
									<div class="star star_full"></div>
									<div class="star star_full"></div>
									<div class="star star_full"></div>
									<div class="star star_full"></div>
									<div class="star star_empty"></div>
								</div>
								<div class="product__text">23 Reviews</div>
							</div>
							<p class="product__text">Lorem ipsum dolor sit amet, consectetur adipisi cing lorem ipsum dolor sit amet, consectetur
								adipisicing ipsum dolor sit amet, tetur
								adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing Lorem ipsum dolor sit amet, consecte tur adipisicing lorem ipsum dolor sit amet </p>
							<a href="#!" class="button button-1 button-1_140">view</a>
						</div>
						<div class="col-md-7">
							<div class="product__supplier__map"><img src="img/map.jpg" alt=""></div>
						</div>
					</div>

				</div>

			</div>
			<div class="col-md-3">

				<div class="product__sidebar_desktop">
					<div class="product__sidebar">
						<div class="product__sidebar__top">
							<div class="limited"><img src="img/icons/chronometer.svg" alt="">Limited time only</div>
							<div class="byuings"><img src="img/icons/smile.svg" alt="">Over 10,000 bought</div>
						</div>

						<div class="product__sidebar__main">
							<h4 class="product__sidebar__title">Select From Options:</h4>

							<div class="product__sidebar__options">
								<div class="product__sidebar__option">
									<input type="radio" id="r1" name="options" checked>
									<label for="r1" class="radio-label option__title">
										<span class="option__title">First option</span>
										<span class="card__old-price">45 200 000$</span>
										<span class="card__new-price">24 200 000$</span>
									</label>

								</div>
								<div class="product__sidebar__option">
									<input type="radio" id="r2" name="options">
									<label for="r2" class="radio-label">
										<span class="option__title">Second option</span>
										<span class="card__old-price">45 200 000$</span>
										<span class="card__new-price">24 200 000$</span>
									</label>
								</div>

							</div>
						</div>

						<div class="product__sidebar__buttons">
							<button class="button button-1">Add cart</button>
							<button class="button button-4">Buy for a Friend</button>
						</div>

						<div class="product__sidebar__bottom">
							<h4 class="product__sidebar__title">In summary</h4>
							<p class="product__text">Lorem ipsum dolor sit amet, consectetur
								adipisicing lorem ipsum dolor sit amet, consectetur
								adipisicing ipsum dolor sit amet, tetur
								adipisicing Lorem ipsum dolor sit amet, consectetur
								adipisicing</p>
							<p class="product__text">Lorem ipsum dolor sit amet, consectetur
								adipisicing lorem ipsum dolor sit amet</p>

							<h4 class="product__sidebar__title">Share this deal</h4>

							<div class="socials">
								<a href="#!" class="social fb"><img src="img/icons/fb.svg" alt=""></a>
								<a href="#!" class="social mail"><img src="img/icons/mail.svg" alt=""></a>
								<a href="#!" class="social twitter"><img src="img/icons/twitter.svg" alt=""></a>
								<a href="#!" class="social wa"><img src="img/icons/whatsapp.svg" alt=""></a>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>










		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		//	do_action( 'woocommerce_before_single_product_summary' );
		?>
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		//		do_action( 'woocommerce_single_product_summary' );
		?>
		<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		//	do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
</div>

<?php do_action('woocommerce_after_single_product'); ?>