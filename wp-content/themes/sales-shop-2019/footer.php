<div class="subscribe">
        <div class="container">
                <div class="row">
                        <div class="col-md-8 subscribe__col">
                                <h4 class="subscribe__title">Contact Us</h4>
                                <div class="subscribe__text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque </div>
                                <div class="subscribe__items">
                                        <div class="subscribe__item">
                                                <img src="img/icons/contacts/mail-black.svg" alt="">
                                                Sed ut perspiciatis
                                        </div>
                                        <div class="subscribe__item">
                                                <img src="img/icons/contacts/phone-black.svg" alt="">
                                                +7 45 654-454-45
                                        </div>
                                        <div class="subscribe__item">
                                                <img src="img/icons/contacts/help-black.svg" alt="">
                                                Sed ut perspiciatis
                                        </div>
                                        <div class="subscribe__item">
                                                <img src="img/icons/contacts/shop-black.svg" alt="">
                                                Sell on Anadi
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4 subscribe__col">
                                <h4 class="subscribe__title">Subscribe</h4>
                                <form class="subscribe__form">
                                        <input type="text" placeholder="Enter E-mail">
                                        <button class="button button-3"><img src="img/icons/plane.svg" alt=""></button>
                                </form>
                        </div>
                </div>
        </div>
</div>
<footer class="footer">

	<div class="container">
		<div class="row">
			<div class="col-md-3 col-xs-6 order-xs-2">
				<div class="footer__block">
					<h4 class="footer__item__title">Name of chapter</h4>
					<ul class="footer__menu">
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3 col-xs-6 order-xs-3">
				<div class="footer__block">
					<h4 class="footer__item__title">Name of chapter</h4>
					<ul class="footer__menu">
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3 col-xs-6 order-xs-4">
				<div class="footer__block">
					<h4 class="footer__item__title">Name of chapter</h4>
					<ul class="footer__menu">
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
						<li class="footer__item"><a href="#!" class="footer__link">link for page</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3 col-xs-6 order-xs-1">
				<div class="footer__block footer__main">
					<div class="footer__logo"><img src="img/logo-2.svg" alt=""></div>
					<h4 class="footer__title">Follow Us</h4>
					<div class="socials">
						<a href="#!" class="social fb"><img src="img/icons/fb.svg" alt=""></a>
						<a href="#!" class="social wa"><img src="img/icons/whatsapp.svg" alt=""></a>
						<a href="#!" class="social in"><img src="img/icons/LinkedIn.svg" alt=""></a>
					</div>
				</div>
			</div>
		</div>

		<div class="copyright">
			<div class="copyright__text">© 2019 Anadi Guinee. All Rights Reserved.</div>
			<div class="copyright__payments">
				<img alt="" src="img/payments/visa.png">
				<img alt="" src="img/payments/mastercard.png">
				<img alt="" src="img/payments/amex.png">
				<img alt="" src="img/payments/paypal.png">
				<img alt="" src="img/payments/orange_money.png">
			</div>
		</div>
	</div>

</footer>

<div class="modal-action_wrap" id="modal-action">
	<div class="modal-action">
		<div class="modal-action__photo"><img src="img/card.jpg" alt=""></div>
		<div class="modal-action__content">
			<h1 class="modal-action__title">Call to action text</h1>
			<h5 class="modal-action__subtitle">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </h5>

			<div class="modal-action__socials">
				<a href="#!" class="button button-2 button-2_1">
					<span class="button-2__icon"><img src="img/icons/fb-color.svg" alt=""></span>
					<span class="button-2__text">Sign in with Facebook</span>
				</a>
				<a href="#!" class="button button-2 button-2_1">
					<span class="button-2__icon"><img src="img/icons/google-color.svg" alt=""></span>
					<span class="button-2__text">Sign in with Google</span>
				</a>
				<a href="#!" class="button button-2 button-2_1">
					<span class="button-2__icon"><img src="img/icons/email-color.svg" alt=""></span>
					<span class="button-2__text">Sign in with Email</span>
				</a>

			</div>

			<h5 class="modal-action__login">Already a member? <a href="#!" class="link link_bold">Sign in</a></h5>
		</div>
	</div>
</div>

<script src="js/scripts.min.js?v=2"></script>

<script>
	$(document).ready(function() {
		/* popup sign in */
		setTimeout(function() {
			$('.modal-action_wrap').show()
			$.magnificPopup.open({
				items: {
					src: '#modal-action'
				},
				type: 'inline'
			});
		}, 1000);
	})
</script>
<?php wp_footer(); ?>
</body>
</html>