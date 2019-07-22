<?php /* Template Name: Content Page Template */ ?>
<?php global $ss_theme_option; ?>

<?php get_header() ?>
<div class="content page">

    <?php ss_banner_full(get_field('banner')) ?>

    <div class="container">

        <?= do_shortcode('[dbc_breadcrumbs]'); ?>

        <h1 class="main-title"><?php the_title() ?></h1>

        <div class="content__content">
            <div class="content__block">
                <div class="row">

                    <div class="col-md-4 content__block__photo order-md-2">
                        <img src="img/card-big.jpg" alt="">
                    </div>

                    <div class="col-md-8 content__block__text order-md-1">
                        <p class="text">Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum </p>
                        <p class="text">Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur</p>
                        <p class="text">Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum </p>

                        <h2 class="content__subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum</h2>

                        <p class="text">Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur</p>
                        <p class="text">Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum </p>

                    </div>

                </div>

            </div>

            <div class="content__block">
                <div class="row">

                    <div class="col-md-4 content__block__photo"><img src="img/card-big.jpg" alt=""></div>

                    <div class="col-md-8 content__block__text">
                        <p class="text">Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum </p>
                        <p class="text">Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur</p>
                        <p class="text">Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum dolor sit amet Lorem ipsum dolor sit amet, consectetur
                            adipisicing lorem ipsum dolor sit amet, consectetur
                            adipisicing ipsum dolor sit amet, tetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur
                            adipisicing Lorem ipsum dolor sit amet, consectetur adipisicing lorem ipsum </p>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
<?php get_footer() ?>