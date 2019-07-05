<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="col-sm-4 col-6" <?php wc_product_class( '', $product ); ?>>
    <?php $product_id = $product->get_id(); ?>
    <a href="<?php echo get_permalink($product_id); ?>" class="card">
            <div class="card__photo">
                    <?php woocommerce_template_loop_product_thumbnail(); ?>
                    <?php get_template_part( 'woocommerce/single-product/percentage' ); ?>
            </div>
            <div class="card__content">
                    <div class="card__title"><?php woocommerce_template_loop_product_title(); ?></div>
                    <?php 
                        $relacion = get_field('product_seller', $product_id);
                        $seller = $relacion[0];
                    ?>
                    <div class="card__name"><?php echo $seller->post_title; ?></div>
                    <div class="card__location">
                        <?php 
                            $seller_id = $seller->ID;
                            $city_id = get_field('city', $seller_id);
                            echo get_the_title($city_id).", ". get_field('country', $seller_id);
                        ?>
                        <!--Kiev, Ukraine-->
                    </div>
                    <?php if($product->get_sale_price($product_id)) { ?>
                        <div class="card__old-price"><?php echo $product->get_regular_price($product_id) ." ". get_woocommerce_currency_symbol(); ?></div>
                        <div class="card__new-price"><?php echo $product->get_sale_price($product_id) ." ". get_woocommerce_currency_symbol(); ?></div>
                    <?php } else { ?>
                        <div class="card__new-price"><?php echo $product->get_regular_price($product_id) ." ". get_woocommerce_currency_symbol(); ?></div>
                    <?php } ?>
                    
            </div>
    </a>
</div>
