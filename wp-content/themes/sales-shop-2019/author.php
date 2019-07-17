<?php get_header();?>
<?php global $ss_theme_option; ?>

<div class="seller page">
    <?php if (is_author()){
        $author = get_queried_object();
        $author_id = $author->ID;
        $autor_roles = $author->roles;
        $autor_obj = ss_get_seller_info($author_id);
        
        if( in_array( 'seller', $autor_roles ) ) { ?>
            <div class="seller__board">
                    <div class="seller__board__content container">
                            <div class="seller__board__photo"><img src="img/card.jpg" alt=""></div>
                            <div class="seller__board__info">
                                    <div class="seller__board__title">Name of compain </div>
                                    <div class="seller__board__city">Kiev, Ukraine</div>
                            </div>
                            <div class="seller__board__rating-block">
                                    <div class="seller__board__rating"><?php echo $autor_obj->rating; ?>/<span class="seller__board__rating_mute">5</span></div>
                                    <div class="seller__board__votes"><?php echo $autor_obj->reviews_count; ?> votes</div>
                            </div>
                    </div>
            </div>

            <div class="container">
                    <section class="seller__contacts">
                            <h2 class="seller__contacts__title">Contact details:</h2>

                            <div class="row seller__contacts__content">
                                    <div class="col-md-3 col-xs-6">
                                            <div class="seller__contacts__subtitle">Phone:</div>
                                            <div class="seller__contacts__text">+7 59 789-44-78</div>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                            <div class="seller__contacts__subtitle">E-mail:</div>
                                            <div class="seller__contacts__text">anadi@gmail.com</div>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                            <div class="seller__contacts__subtitle">Website:</div>
                                            <div class="seller__contacts__text"><a href="#!" class="link link_bold">www.namewebsite.com</a></div>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                            <div class="seller__contacts__subtitle">Address:</div>
                                            <div class="seller__contacts__text">Nova gvinea, street trata ta home 45 <br> <a href="#!" class="link link_bold">Get Directions</a></div>
                                    </div>
                                    <div class="col-md-12">
                                            <div class="seller__contacts__subtitle">About:</div>
                                            <div class="seller__contacts__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                    </div>
                            </div>

                    </section>

                    <section class="seller__coupons">
                            <h2 class="seller__coupons__title">Active coupon</h2>
                            <div class="seller__coupons__content">
                                    <div class="seller__coupon">
                                            <div class="seller__coupon__photo"><img src="img/card.jpg" alt=""></div>
                                            <div class="seller__coupon__content">
                                                    <a href="#!" class="order__title">Product Title Goes Here and here and here and here and here and here and here Product Title Goes Here and here and </a>
                                                    <div class="order__subtitle_mute">Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>
                                                    <div class="seller__coupon__price">20 000 000$</div>
                                            </div>
                                    </div>
                                    <div class="seller__coupon">
                                            <div class="seller__coupon__photo"><img src="img/card.jpg" alt=""></div>
                                            <div class="seller__coupon__content">
                                                    <a href="#!" class="order__title">Product Title Goes Here and here and here and here and here and here and here Product Title Goes Here and here and here and here and here Product Title Goes Here and here and </a>
                                                    <div class="order__subtitle_mute">Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>
                                                    <div class="seller__coupon__price">20 000 000$</div>
                                            </div>
                                    </div>
                                    <div class="seller__coupon">
                                            <div class="seller__coupon__photo"><img src="img/card.jpg" alt=""></div>
                                            <div class="seller__coupon__content">
                                                    <a href="#!" class="order__title">Product Title Goes Here and here and here and here and here and here and here Product Title Goes Here and here and </a>
                                                    <div class="order__subtitle_mute">Fine-Dining Date Night: 3-Course Meal with Wine for 2 at Priva Lounge</div>
                                                    <div class="seller__coupon__price">20 000 000$</div>
                                            </div>
                                    </div>

                            </div>
                    </section>

                    <section class="seller__reviews">
                            <h2 class="seller__reviews__title">Reviews</h2>

                            <div class="seller__reviews__rating">
                                    <p>Your rating:</p>

                                    <div class="rating__inputs">

                                            <div class="rating__star__item">
                                                    <input class="rating__star" type="radio" name="star" id="star1" value="1"
                                                    aria-label="Ужасно">
                                                    <label for="star1" class="rating__star__label"></label>
                                            </div>


                                            <div class="rating__star__item">
                                                    <input class="rating__star" type="radio" name="star" id="star2" value="2"
                                                    aria-label="Сносно">
                                                    <label for="star2" class="rating__star__label"></label>
                                            </div>


                                            <div class="rating__star__item">
                                                    <input class="rating__star" type="radio" name="star" id="star3" value="3"
                                                    aria-label="Нормально">
                                                    <label for="star3" class="rating__star__label"></label>
                                            </div>


                                            <div class="rating__star__item">
                                                    <input class="rating__star" type="radio" name="star" id="star4" value="4"
                                                    aria-label="Хорошо">
                                                    <label for="star4" class="rating__star__label"></label>
                                            </div>


                                            <div class="rating__star__item">
                                                    <input class="rating__star" type="radio" name="star" id="star5" value="5"
                                                    aria-label="Отлично">
                                                    <label for="star5" class="rating__star__label"></label>
                                            </div>

                                    </div>
                            </div>

                            <form>
                                    <textarea placeholder="Comment" rows="10" class="input seller__comment"></textarea>
                                    <button class="button button-1 button-1_180">Submit Review</button>
                            </form>

                            <div class="seller__reviews__content">
                                    <div class="seller__review">
                                            <div class="seller__review__photo"><img src="img/card.jpg" alt=""></div>
                                            <div class="seller__review__content">
                                                    <div class="seller__review__title">
                                                            <h5 class="seller__review__name">Zandile Makhosi</h5>
                                                            <p class="seller__review__date">6 months ago</p>
                                                    </div>
                                                    <div class="rating">
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_empty"></div>
                                                    </div>
                                                    <div class="seller__review__text">It was amazing, staff is friendly and manager gave every table constant attention. Hubby enjoyed his birthday.</div>
                                            </div>
                                    </div>
                                    <div class="seller__review">
                                            <div class="seller__review__photo"><img src="img/card.jpg" alt=""></div>
                                            <div class="seller__review__content">
                                                    <div class="seller__review__title">
                                                            <h5 class="seller__review__name">Zandile Makhosi</h5>
                                                            <p class="seller__review__date">6 months ago</p>
                                                    </div>
                                                    <div class="rating">
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_empty"></div>
                                                    </div>
                                                    <div class="seller__review__text">It was amazing, staff is friendly and manager gave every table constant attention. Hubby enjoyed his birthday.</div>
                                            </div>
                                    </div>
                                    <div class="seller__review">
                                            <div class="seller__review__photo"><img src="img/card.jpg" alt=""></div>
                                            <div class="seller__review__content">
                                                    <div class="seller__review__title">
                                                            <h5 class="seller__review__name">Zandile Makhosi</h5>
                                                            <p class="seller__review__date">6 months ago</p>
                                                    </div>
                                                    <div class="rating">
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_empty"></div>
                                                    </div>
                                                    <div class="seller__review__text">It was amazing, staff is friendly and manager gave every table constant attention. Hubby enjoyed his birthday.</div>
                                            </div>
                                    </div>
                                    <div class="seller__review">
                                            <div class="seller__review__photo"><img src="img/card.jpg" alt=""></div>
                                            <div class="seller__review__content">
                                                    <div class="seller__review__title">
                                                            <h5 class="seller__review__name">Zandile Makhosi</h5>
                                                            <p class="seller__review__date">6 months ago</p>
                                                    </div>
                                                    <div class="rating">
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_full"></div>
                                                            <div class="star star_empty"></div>
                                                    </div>
                                                    <div class="seller__review__text">It was amazing, staff is friendly and manager gave every table constant attention. Hubby enjoyed his birthday.</div>
                                            </div>
                                    </div>

                                    <a href="#!" class="button button-1 button-1_180">Load more reviews</a>

                            </div>

                    </section>
            </div>
        <?php }
        else{
            echo 'That author is not known.';
        }
    }
    ?>
</div>
<?php get_footer(); ?>