<?php /* Template Name: Profile Page Template */

$seller_id = get_query_var('seller_id');

if (empty($seller_id)) {
    $seller_id = get_current_user_id();
}

$seller = ss_get_seller_info($seller_id, true);

if ($seller === null) {
    ss_return_home();
}

global $ss_theme_option;
$reviews_amount = $ss_theme_option['seller-page-pagination-amount'];
$reviews_show = 0;
$current_user = ss_get_user();
$additional_fields = get_fields('user_' . $seller->id);
$active_products = ss_get_active_seller_products($seller->id);

get_header();
?>

    <div class="seller page">

        <div class="seller__board">
            <div class="seller__board__content container">
                <div class="seller__board__photo"><img src="<?= $additional_fields['photo'] ?>" alt=""></div>
                <div class="seller__board__info">
                    <div class="seller__board__title"><?= $seller->name ?></div>
                    <div class="seller__board__city"><?= get_the_title($additional_fields['city']) . ', '. $additional_fields['country'] ?></div>
                </div>
                <div class="seller__board__rating-block">
                    <div class="seller__board__rating"><?= $seller->rating ?>/<span class="seller__board__rating_mute">5</span></div>
                    <div class="seller__board__votes"><?= $seller->reviews_count ?> <?= __('votes') ?></div>
                </div>
            </div>
        </div>

        <div class="container">
            <section class="seller__contacts">
                <h2 class="seller__contacts__title"><?= __('Contact details') ?>:</h2>

                <div class="row seller__contacts__content">
                    <div class="col-md-3 col-xs-6">
                        <div class="seller__contacts__subtitle"><?= __('Phone') ?>:</div>
                        <div class="seller__contacts__text"><?= $additional_fields['phone'] ?></div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="seller__contacts__subtitle"><?= __('E-mail') ?>:</div>
                        <div class="seller__contacts__text"><?= $seller->user->user_email ?></div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="seller__contacts__subtitle"><?= __('Website') ?>:</div>
                        <div class="seller__contacts__text"><a href="<?= $seller->user->user_url ?>" class="link link_bold"><?= $seller->user->user_url ?></a></div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="seller__contacts__subtitle"><?= __('Address') ?>:</div>
                        <div class="seller__contacts__text"><?= $additional_fields['address'] ?> <br> <a href="#!" class="link link_bold">Get Directions</a></div>
                    </div>
                    <div class="col-md-12">
                        <div class="seller__contacts__subtitle"><?= __('About') ?>:</div>
                        <div class="seller__contacts__text"><?= $additional_fields['about'] ?></div>
                    </div>
                </div>

            </section>

            <section class="seller__coupons">
                <h2 class="seller__coupons__title"><?= __('Active coupon') ?></h2>
                <div class="seller__coupons__content">
                    <?php foreach ($active_products as $product) : ?>
                        <div class="seller__coupon">
                            <div class="seller__coupon__photo"><?= $product->get_image('full') ?></div>
                            <div class="seller__coupon__content">
                                <a href="<?= $product->get_permalink() ?>" class="order__title"><?= $product->get_name() ?></a>
                                <div class="order__subtitle_mute"><?= $product->get_short_description() ?></div>
                                <div class="seller__coupon__price"><?= ss_get_min_price_product($product) ?><?= get_woocommerce_currency_symbol() ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="seller__reviews">
                <h2 class="seller__reviews__title"><?= __('Reviews') ?></h2>

                <?php if (!empty($current_user) && $current_user->is_customer == true) : ?>
                    <form <?= SS_FORM_POST ?>>
                        <input type="hidden" name="action" value="review_add_form"/>
                        <?php wp_nonce_field('ss_review_add_form'); ?>
                        <input type="hidden" name="review_add_id" value="<?= $seller->id ?>"/>
                        <div class="seller__reviews__rating">
                            <p><?= __('Your rating') ?>:</p>

                            <div class="rating__inputs">

                                <div class="rating__star__item">
                                    <input class="rating__star" type="radio" name="star" id="star1" value="1" checked
                                           aria-label="<?= __('Terribly') ?>">
                                    <label for="star1" class="rating__star__label"></label>
                                </div>


                                <div class="rating__star__item">
                                    <input class="rating__star" type="radio" name="star" id="star2" value="2"
                                           aria-label="<?= __('Passable') ?>">
                                    <label for="star2" class="rating__star__label"></label>
                                </div>


                                <div class="rating__star__item">
                                    <input class="rating__star" type="radio" name="star" id="star3" value="3"
                                           aria-label="<?= __('Normally') ?>">
                                    <label for="star3" class="rating__star__label"></label>
                                </div>


                                <div class="rating__star__item">
                                    <input class="rating__star" type="radio" name="star" id="star4" value="4"
                                           aria-label="<?= __('Good') ?>">
                                    <label for="star4" class="rating__star__label"></label>
                                </div>


                                <div class="rating__star__item">
                                    <input class="rating__star" type="radio" name="star" id="star5" value="5"
                                           aria-label="<?= __('Fine') ?>">
                                    <label for="star5" class="rating__star__label"></label>
                                </div>

                            </div>
                        </div>
                        <textarea name="comment" placeholder="<?= __('Comment') ?>" rows="10" class="input seller__comment"></textarea>
                        <button class="button button-1 button-1_180"><?= __('Submit Review') ?></button>
                    </form>
                <?php endif; ?>

                <div class="seller__reviews__content">
                    <?php foreach ($seller->reviews as $review) : ?>
                        <?php $reviews_show++ ?>
                        <div class="seller__review moreBox" <?= ($reviews_amount > 0 && $reviews_show > $reviews_amount) ? 'style="display: none"' : '' ?>>
                            <div class="seller__review__photo">
                                <?= get_avatar($review->customer->ID) ?>
                            </div>
                            <div class="seller__review__content">
                                <div class="seller__review__title">
                                    <h5 class="seller__review__name"><?= $review->customer->name ?></h5>
                                    <p class="seller__review__date"><?= $review->human_time_diff ?></p>
                                </div>
                                <div class="rating">
                                    <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($i < $review->rating) {
                                                echo '<div class="star star_full"></div>';
                                            } else {
                                                echo '<div class="star star_empty"></div>';
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="seller__review__text"><?= $review->post_content ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($reviews_amount > 0 && $reviews_show > $reviews_amount) : ?>
                        <a id="loadMore" href="javascript:void(0);" class="button button-1 button-1_180"><?= __('Load more reviews') ?></a>
                    <?php endif; ?>
                </div>

            </section>
        </div>

    </div>

<?php if ($reviews_amount > 0 && $reviews_show > $reviews_amount) : ?>
    <script>
        $(function() {
            $("#loadMore").on('click', function (e) {
                e.preventDefault();
                $(".moreBox:hidden").slice(0, <?= $reviews_amount ?>).slideDown();
                if ($(".moreBox:hidden").length == 0) {
                    $("#loadMore").fadeOut('slow');
                }
            });
        });
    </script>
<?php endif; ?>
<?php get_footer(); ?>