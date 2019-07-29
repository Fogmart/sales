<?php
if (!defined('ABSPATH')) {
    exit;
}
the_post();
get_header('product');
$product = ss_get_product(get_the_ID());
?>
<div class="product page">

    <div class="container">

        <?php echo do_shortcode('[dbc_breadcrumbs]'); ?>

        <h1 class="main-title"><?php the_title() ?></h1>

        <div class="row">
            <div class="col-md-9">
                <div class="product__main product__block">
                    <div class="product__main__top">
                        <div class="card__name"><?= $product->seller->name ?></div>
                        <div class="card__location"><?= $product->city->name ?>, <?= $product->city->country ?></div>
                    </div>

                    <?php $gallery = $product->get_gallery_image_ids() ?>
                    <div class="product__main__slider_for">
                        <?php foreach ($gallery as $one) : ?>
                            <div class="product__main__photo">
                                <?php if ($video_link = ss_get_video_image_link($one)) : ?>
                                    <iframe height="" src="<?= $video_link ?>" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                                <?php else : ?>
                                    <?= wp_get_attachment_image($one, 'full') ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="product__main__slider_nav">
                        <?php foreach ($gallery as $one) : ?>
                            <div class="product__main__slider_nav__photo">
                                <?= wp_get_attachment_image($one, 'thumbnail') ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="product__sidebar_mobile"></div>

                <div class="product__details product__block">
                    <div class="product__details__tabs">
                        <button class="product__details__tab active"><?= __('Product Details') ?></button>
                        <button class="product__details__tab"><?= __('The Fine Print') ?></button>
                    </div>

                    <div class="product__details__content">
                        <div class="product__details__block">
                            <?= get_field('description') ?>
                        </div>
                        <div class="product__details__block">
                            <?= get_field('fine_print') ?>
                        </div>
                    </div>
                </div>

                <div class="product__supplier product__block">
                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="product__supplier__title"><?= __('Supplier Information') ?></h4>
                            <div class="card__name"><?= $product->seller->name ?></div>
                            <div class="card__location"><?= $product->city->name ?>, <?= $product->city->country ?></div>
                            <div class="product__supplier__rating">
                                <div class="rating">
                                    <?php for ($i = 0; $i < 5; $i++) : ?>
                                        <?php if ($i < $product->seller->rating) : ?>
                                            <div class="star star_full"></div>
                                        <?php else : ?>
                                            <div class="star star_empty"></div>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="product__text"><?= $product->seller->reviews_count ?> <?= __('Reviews') ?></div>
                            </div>
                            <p class="product__text"><?= get_field('about', 'user_' . $product->seller->id) ?></p>
                            <a href="<?= ss_get_seller_profile_link($product->seller->id) ?>" class="button button-1 button-1_140"><?= __('view') ?></a>
                        </div>
                        <div class="col-md-7">
                            <div class="product__supplier__map">
                                <?php
                                $location = get_field('geo_location', 'user_' . $product->seller->id);
                                if (!empty($location)) :
                                    ?>
                                    <div class="acf-map">
                                        <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <style type="text/css">
                        .acf-map {
                            width: 100%;
                            height: 200px;
                            border: #ccc solid 1px;
                            margin: 20px 0;
                        }

                        /* fixes potential theme css conflict */
                        .acf-map img {
                            max-width: inherit !important;
                        }
                    </style>
                    <script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_API_KEY ?>"></script>
                    <script type="text/javascript">
                        (function($) {

                            /*
                             *  new_map
                             *
                             *  This function will render a Google Map onto the selected jQuery element
                             *
                             *  @type	function
                             *  @date	8/11/2013
                             *  @since	4.3.0
                             *
                             *  @param	$el (jQuery element)
                             *  @return	n/a
                             */

                            function new_map($el) {

                                // var
                                var $markers = $el.find('.marker');


                                // vars
                                var args = {
                                    zoom: 16,
                                    center: new google.maps.LatLng(0, 0),
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };


                                // create map	        	
                                var map = new google.maps.Map($el[0], args);


                                // add a markers reference
                                map.markers = [];


                                // add markers
                                $markers.each(function() {

                                    add_marker($(this), map);

                                });


                                // center map
                                center_map(map);


                                // return
                                return map;

                            }

                            /*
                             *  add_marker
                             *
                             *  This function will add a marker to the selected Google Map
                             *
                             *  @type	function
                             *  @date	8/11/2013
                             *  @since	4.3.0
                             *
                             *  @param	$marker (jQuery element)
                             *  @param	map (Google Map object)
                             *  @return	n/a
                             */

                            function add_marker($marker, map) {

                                // var
                                var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));

                                // create marker
                                var marker = new google.maps.Marker({
                                    position: latlng,
                                    map: map
                                });

                                // add to array
                                map.markers.push(marker);

                                // if marker contains HTML, add it to an infoWindow
                                if ($marker.html()) {
                                    // create info window
                                    var infowindow = new google.maps.InfoWindow({
                                        content: $marker.html()
                                    });

                                    // show info window when marker is clicked
                                    google.maps.event.addListener(marker, 'click', function() {

                                        infowindow.open(map, marker);

                                    });
                                }

                            }

                            /*
                             *  center_map
                             *
                             *  This function will center the map, showing all markers attached to this map
                             *
                             *  @type	function
                             *  @date	8/11/2013
                             *  @since	4.3.0
                             *
                             *  @param	map (Google Map object)
                             *  @return	n/a
                             */

                            function center_map(map) {

                                // vars
                                var bounds = new google.maps.LatLngBounds();

                                // loop through all markers and create bounds
                                $.each(map.markers, function(i, marker) {

                                    var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());

                                    bounds.extend(latlng);

                                });

                                // only 1 marker?
                                if (map.markers.length == 1) {
                                    // set center of map
                                    map.setCenter(bounds.getCenter());
                                    map.setZoom(16);
                                } else {
                                    // fit to bounds
                                    map.fitBounds(bounds);
                                }

                            }

                            /*
                             *  document ready
                             *
                             *  This function will render each map when the document is ready (page has loaded)
                             *
                             *  @type	function
                             *  @date	8/11/2013
                             *  @since	5.0.0
                             *
                             *  @param	n/a
                             *  @return	n/a
                             */
                            // global var
                            var map = null;

                            $(document).ready(function() {

                                $('.acf-map').each(function() {

                                    // create map
                                    map = new_map($(this));

                                });

                            });

                        })(jQuery);
                    </script>

                </div>

            </div>
            <div class="col-md-3">

                <div class="product__sidebar_desktop">
                    <div class="product__sidebar">
                        <div class="product__sidebar__top">
                            <div class="limited">
                                <?php $limited = (object) get_field('limited'); ?>
                                <?= wp_get_attachment_image($limited->icon) ?>
                                <?= $limited->text ?>
                            </div>
                            <?php $buyings = (object) get_field('buyings'); ?>
                            <?php if ($buyings->behavior != 'hidden') : ?>
                                <?php $count = ($buyings->behavior == 'fake' ? $buyings->fake : $product->buyings_count); ?>
                                <div class="byuings">
                                    <?= wp_get_attachment_image($buyings->icon) ?>
                                    <?= __('Over') . " $count " . __('bought') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($product->has_child()) : ?>
                            <div class="product__sidebar__main">
                                <h4 class="product__sidebar__title"><?= __('Select From Options:') ?></h4>
                                <div class="product__sidebar__options">
                                    <?php foreach ($product->get_children() as $key => $child_id) : ?>
                                        <?php $v_product = ss_get_product($child_id) ?>
                                        <div class="product__sidebar__option">
                                            <input type="radio" id="r<?= $key ?>" name="options" value="<?= $child_id ?>">
                                            <label for="r<?= $key ?>" class="radio-label radio-label_yellow">
                                                <span class="option__title"><?= $v_product->get_name() ?></span>
                                                <?php if ($v_product->is_on_sale()) : ?>
                                                    <span class="card__old-price"><?= $v_product->get_regular_price() ?><?= get_woocommerce_currency_symbol() ?></span>
                                                    <span class="card__new-price"><?= $v_product->get_sale_price() ?><?= get_woocommerce_currency_symbol() ?></span>
                                                <?php else : ?>
                                                    <span class="card__new-price"><?= $v_product->get_regular_price() ?><?= get_woocommerce_currency_symbol() ?></span>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="product__sidebar__buttons">
                            <button class="button button-1 var-add-btn"><?= __('Add to cart') ?></button>
                            <button class="button button-4"><?= __('Buy for a Friend') ?></button>
                        </div>

                        <div class="product__sidebar__bottom">
                            <?php if ($text_block = (object) get_field('text_block')) : ?>
                                <h4 class="product__sidebar__title"><?= $text_block->title ?></h4>
                                <?= $text_block->text ?>
                            <?php endif; ?>
                            <h4 class="product__sidebar__title"><?= __('Share this deal') ?></h4>

                            <div class="socials">
                                <?= do_shortcode('[TheChamp-Sharing]') ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cards__block">
            <h2 class="cards__block__title"><?= __('You might also like these!')?></h2>
            <div class="cards">
                <div class="row">
                    <?php
                    $related_products = array();
                    $related_show_type = get_field('related_products_type');
                    if ($related_show_type == 'custom') {
                        $related_products = (array)get_field('custom_related_products');
                        $related_products = array_column($related_products, 'product');
                    } elseif ($related_show_type == 'auto') {
                        $show_limit = 4;
                        $related_products = wc_get_related_products($product->get_id(),  $show_limit);
                    }
                    ?>
                    <?php foreach ($related_products as $product_id) : ?>
                        <div class="col-md-3 col-sm-4 col-6">
                            <?= ss_render_product_card($product_id) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php get_footer('product'); ?>