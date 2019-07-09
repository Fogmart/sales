<?php
global $kdn_theme_options; 
defined( 'ABSPATH' ) || exit;
get_header();
do_action( 'woocommerce_before_main_content' );

?>

<?php if ( woocommerce_product_loop() ) { ?>

<div class="category page">

		<div class="container">
			<a href="#!" class="popular">
				<img src="img/popular/pink.png" alt="">
				<div class="row no-gutters">
					<div class="col-md-7 col-xs-8 col-9">
						<div class="popular__text">
							<h1 class="popular__title">Browse Popular Categories</h1>
							<div class="popular__subtitle">Kingscliff: From $349 for a 3-Night Romantic Stay with Bottle of Wine…</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		
    
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="filter__accordeon">
						<div class="filter__toggler">
							filter
							<img src="img/icons/angle-down.svg" alt="">
						</div>
						<div class="filter">
							<div class="filter__block">
								<h4 class="filter__title">Select by cities</h4>
								<div class="filter__item">
									<input type="checkbox" id="c1">
									<label class="checkbox-label" for="c1">Name city</label>
								</div>
								<div class="filter__item">
									<input type="checkbox" id="c2">
									<label class="checkbox-label" for="c2">Name city</label>
								</div>
								<div class="filter__item">
									<input type="checkbox" id="c3">
									<label class="checkbox-label" for="c3">Name city</label>
								</div>
								<div class="filter__item">
									<input type="checkbox" id="c4">
									<label class="checkbox-label" for="c4">Name city</label>
								</div>
							</div>
							<div class="filter__block">
								<h4 class="filter__title">Filter by neighborhoods</h4>
								<div class="filter__item">
									<input type="checkbox" id="n1">
									<label class="checkbox-label" for="n1">Name neighborhoods</label>
								</div>
								<div class="filter__item">
									<input type="checkbox" id="n2">
									<label class="checkbox-label" for="n2">Name neighborhoods</label>
								</div>
								<div class="filter__item">
									<input type="checkbox" id="n3">
									<label class="checkbox-label" for="n3">Name neighborhoods</label>
								</div>
								<div class="filter__item">
									<input type="checkbox" id="n4">
									<label class="checkbox-label" for="n4">Name neighborhoods</label>
								</div>
							</div>
							<div class="filter__block">
								<h4 class="filter__title">Filter by Keyword</h4>
								<form class="search">
									<input type="text" placeholder="Keyword">
									<button class="button button-3"><img src="img/icons/search.svg" alt=""></button>
								</form>
							</div>
							<div class="filter__block">
								<h4 class="filter__title">Filter by Price</h4>
								<div id="price-range"></div>
								<div class="price-range__block">

									<div class="price-range__item">
										<input type="text" class="input price-min" id="price-min">
									</div>

									<span>to</span>

									<div class="price-range__item">
										<input type="text" class="input price-max" id="price-max">
									</div>

								</div>

							</div>
							<div class="filter__block">
								<h4 class="filter__title">Filter by Category</h4>

								<div class="filter__item accordeon">
									<div class="filter__item__title">
										<input type="checkbox" id="cat1">
										<label class="checkbox-label" for="cat1">Category 1#</label>
										<button class="accordeon__button"><img src="img/icons/angle-down-black.svg" alt=""></button>
									</div>
									<div class="accordeon__content">
										<div class="filter__subcat">
											<input type="checkbox" id="subcat1">
											<label class="checkbox-label" for="subcat1">Sub Category 1#</label>
										</div>
										<div class="filter__subcat">
											<input type="checkbox" id="subcat2">
											<label class="checkbox-label" for="subcat2">Sub Category 1#</label>
										</div>
										<div class="filter__subcat">
											<input type="checkbox" id="subcat3">
											<label class="checkbox-label" for="subcat3">Sub Category 1#</label>
										</div>
										<div class="filter__subcat">
											<input type="checkbox" id="subcat4">
											<label class="checkbox-label" for="subcat4">Sub Category 1#</label>
										</div>
									</div>
								</div>
								<div class="filter__item accordeon">
									<div class="filter__item__title">
										<input type="checkbox" id="cat2">
										<label class="checkbox-label" for="cat2">Category 1#</label>
										<button class="accordeon__button"><img src="img/icons/angle-down-black.svg" alt=""></button>
									</div>
									<div class="accordeon__content">
										<div class="filter__subcat">
											<input type="checkbox" id="subcat5">
											<label class="checkbox-label" for="subcat5">Sub Category 1#</label>
										</div>
										<div class="filter__subcat">
											<input type="checkbox" id="subcat6">
											<label class="checkbox-label" for="subcat6">Sub Category 1#</label>
										</div>
										<div class="filter__subcat">
											<input type="checkbox" id="subcat7">
											<label class="checkbox-label" for="subcat7">Sub Category 1#</label>
										</div>
										<div class="filter__subcat">
											<input type="checkbox" id="subcat8">
											<label class="checkbox-label" for="subcat8">Sub Category 1#</label>
										</div>
									</div>
								</div>

							</div>

						</div>
					</div>
					
				</div>

				<div class="col-md-9">
                                    
                                        <?php echo do_shortcode('[dbc_breadcrumbs]'); ?>

					<div class="category__options">
						<div class="category__options__text"><?php woocommerce_result_count(); ?></div>
						<div class="category__filter">
							<div class="category__options__text">Sort by</div>
                                                        <?php woocommerce_catalog_ordering() ?>
						</div>
					</div>
                                    
                                        <?php 
                                        if ( wc_get_loop_prop( 'total' ) ) { ?>
                                            <div class="category__content cards">
						<div class="row js_appendTo">
                                                <?php while ( have_posts() ) {
                                                        the_post();

                                                        /**
                                                         * Hook: woocommerce_shop_loop.
                                                         *
                                                         * @hooked WC_Structured_Data::generate_product_data() - 10
                                                         */
                                                        do_action( 'woocommerce_shop_loop' );

                                                        wc_get_template_part( 'content', 'product' );
                                                }?>
                                                </div>
                                                
                                                <?php
                                                    if($kdn_theme_options["category-pagination"] === "1"){?>
                                                        <?php if (wc_get_loop_prop( 'total' ) > $kdn_theme_options["category-pagination-amount"]){?>
                                                            <button class="button button-1 button-1_160 js_load_more_products">load more</button>
                                                        <?php } ?>
                                                    <?php } else {
                                                       woocommerce_pagination();
                                                    }
                                                ?>
                                                     
                                            </div>    
                                        <?php }
                                        woocommerce_product_loop_end();
                                        ?>      
				</div>
			</div>
		</div>

	</div>

<?php } else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}
do_action( 'woocommerce_after_main_content' );

?>
<?php get_footer(); ?>
