<?php /* Template Name: Contact Page Template */ ?>
<?php get_header(); ?>
<?php global $ss_theme_option; ?>
<div class="contact page">
	<?php ss_banner_full(get_field('banner_top')); ?>
	
        <div class="container">

                <?php echo do_shortcode('[dbc_breadcrumbs]'); ?>

                <h1 class="main-title"><?php echo get_the_title(); ?></h1>

                <div class="contact__content">

                        <div class="row">
                                <div class="col-md-7">
                                        <div class="contact__block">
                                            
                                                <h2 class="contact__block__title"><?php echo get_field('form_title'); ?></h2>

                                                <div class="contact__form">
                                                        <?php 
                                                            $form_sc = get_field('form_shortcode');
                                                            echo do_shortcode($form_sc);
                                                        ?>
                                                </div>
                                        </div>
                                </div>
                                <div class="col-md-5">
                                        <div class="contact__block">
                                                <h2 class="contact__block__title"><?php echo get_field('contact_details_title'); ?></h2>

                                                <div class="contact__block__item">
                                                        <img class="contact__block__item__icon" src="<?= ss_asset('img/icons/contact-email-yellow.svg')?>" alt="">
                                                        <p class="text"><?php echo get_field('contact_details_email'); ?></p>
                                                </div>
                                                <div class="contact__block__item">
                                                        <img class="contact__block__item__icon" src="<?= ss_asset('img/icons/phone-yellow.svg')?>" alt="">
                                                        <p class="text"><?php echo get_field('contact_details_phone'); ?></p>
                                                </div>
                                                <div class="contact__block__item">
                                                        <img src="<?= ss_asset('img/icons/clock-yellow.svg')?>" alt="" class="contact__block__item__icon">
                                                        <p class="text"><?php echo get_field('contact_details_time'); ?></p>
                                                </div>
                                        </div>
                                </div>
                        </div>

                </div>

        </div>
</div>
<?php get_footer(); ?>