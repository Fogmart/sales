<?php
global $ss_theme_option;
?>

<div class="subscribe">
	<div class="container">
		<div class="row">
			<div class="col-md-8 subscribe__col">
				<?php echo do_shortcode($ss_theme_option['footer-contact-us-form']) ?>
			</div>
			<div class="col-md-8 subscribe__col">
				<h4 class="subscribe__title"><?= __($ss_theme_option['footer-contact-us-title'])?></h4>
				<div class="subscribe__text"><?= __($ss_theme_option['footer-contact-us-text'])?></div>
				<div class="subscribe__items">
					<div class="subscribe__item">
						<img src="<?= ss_asset('img/icons/contacts/mail-black.svg')?>" alt="">
						<?= __($ss_theme_option['footer-contact-us-mail'])?>
					</div>
					<div class="subscribe__item">
						<img src="<?= ss_asset('img/icons/contacts/phone-black.svg')?>" alt="">
						<?= __($ss_theme_option['footer-contact-us-phone'])?>
					</div>
					<div class="subscribe__item">
						<img src="<?= ss_asset('img/icons/contacts/help-black.svg')?>" alt="">
						<?= __($ss_theme_option['footer-contact-us-help'])?>
					</div>
					<div class="subscribe__item">
						<img src="<?= ss_asset('img/icons/contacts/shop-black.svg')?>" alt="">
						<?= __($ss_theme_option['footer-contact-us-shop'])?>
					</div>
				</div>
			</div>

			<div class="col-md-4 subscribe__col">
				<h4 class="subscribe__title">Subscribe</h4>
				<?php echo do_shortcode($ss_theme_option['footer-subscribe-form']) ?>
			</div>
		</div>
	</div>
</div>
<footer class="footer">

	<div class="container">
		<div class="row">
			<div class="col-md-3 col-xs-6 order-xs-2">
				<?= ss_menu_footer_first() ?>
			</div>
			<div class="col-md-3 col-xs-6 order-xs-3">
				<?= ss_menu_footer_second() ?>
			</div>
			<div class="col-md-3 col-xs-6 order-xs-4">
				<?= ss_menu_footer_third() ?>
			</div>
			<div class="col-md-3 col-xs-6 order-xs-1">
				<div class="footer__block footer__main">
					<div class="footer__logo"><img src="<?= $ss_theme_option['footer-logo']['url'] ?>" alt="<?= $ss_theme_option['footer-logo']['alt'] ?>"></div>
					<h4 class="footer__title"><?= __('Follow Us') ?></h4>
					</h4>
					<div class="socials">
						<a href="<?= $ss_theme_option['footer-facebook-url'] ?>" class="social fb"><img src="<?= ss_asset('img/icons/fb.svg') ?>" alt=""></a>
						<a href="<?= $ss_theme_option['footer-whatsup-url'] ?>" class="social wa"><img src="<?= ss_asset('img/icons/whatsapp.svg') ?>" alt=""></a>
						<a href="<?= $ss_theme_option['footer-linkedin-url'] ?>" class="social in"><img src="<?= ss_asset('img/icons/LinkedIn.svg') ?>" alt=""></a>
					</div>
				</div>
			</div>
		</div>

		<div class="copyright">
			<div class="copyright__text"><?= __($ss_theme_option['footer-copyright-text']) ?></div>
			<div class="copyright__payments">
				<img alt="" src="<?= ss_asset('img/payments/visa.png') ?>">
				<img alt="" src="<?= ss_asset('img/payments/mastercard.png') ?>">
				<img alt="" src="<?= ss_asset('img/payments/amex.png') ?>">
				<img alt="" src="<?= ss_asset('img/payments/paypal.png') ?>">
				<img alt="" src="<?= ss_asset('img/payments/orange_money.png') ?>">
			</div>
		</div>
	</div>

</footer>

<div class="modal-action_wrap" id="modal-action">
	<div class="modal-action">
		<div class="modal-action__photo"><img src="<?= ss_asset('img/card.jpg') ?>" alt=""></div>
		<div class="modal-action__content">
			<h1 class="modal-action__title">Call to action text</h1>
			<h5 class="modal-action__subtitle">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </h5>

			<div class="modal-action__socials">
				<a href="#!" class="button button-2 button-2_1">
					<span class="button-2__icon"><img src="<?= ss_asset('img/icons/fb-color.svg') ?>" alt=""></span>
					<span class="button-2__text">Sign in with Facebook</span>
				</a>
				<a href="#!" class="button button-2 button-2_1">
					<span class="button-2__icon"><img src="<?= ss_asset('img/icons/google-color.svg') ?>" alt=""></span>
					<span class="button-2__text">Sign in with Google</span>
				</a>
				<a href="#!" class="button button-2 button-2_1">
					<span class="button-2__icon"><img src="<?= ss_asset('img/icons/email-color.svg') ?>" alt=""></span>
					<span class="button-2__text">Sign in with Email</span>
				</a>

			</div>

			<h5 class="modal-action__login">Already a member? <a href="#!" class="link link_bold">Sign in</a></h5>
		</div>
	</div>
</div>

<script>
	// $(document).ready(function() {
	// 	/* popup sign in */
	// 	setTimeout(function() {
	// 		$('.modal-action_wrap').show()
	// 		$.magnificPopup.open({
	// 			items: {
	// 				src: '#modal-action'
	// 			},
	// 			type: 'inline'
	// 		});
	// 	}, 1000);
	// })
</script>
<?php wp_footer(); ?>
</body>

</html>