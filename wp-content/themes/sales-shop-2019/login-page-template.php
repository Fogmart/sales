<?php /* Template Name: Login Page Template */ ?>
<?php get_header(); ?>
<?php global $ss_theme_option; ?>
<div class="login page">

    <div class="container">

        <h1 class="center login__title">Login</h1>

        <h5 class="login__subtitle center">Don't have an account yet? <a href="#!" class="link link_bold">Click here</a> to sign up</h5>

        <div class="login__content">
            <div class="row">
                <div class="col-md-5 login__socials">
                    <a href="#!" class="login__social fb button button-2 button-2_1">
                        <span class="button-2__icon"><img src="img/icons/fb.svg" alt=""></span>
                        <span class="button-2__text">Sign in with Facebook</span>
                    </a>
                    <a href="#!" class="login__social google button button-2 button-2_1">
                        <span class="button-2__icon"><img src="img/icons/google.svg" alt=""></span>
                        <span class="button-2__text">Sign in with Google</span>
                    </a>

                </div>
                <div class="login_or col-md-1"><span>or</span></div>
                <div class="col-md-4 offset-md-1">
                    <div class="login__enter">
                        <form class="login__form">
                            <div class="login__item">
                                <h5 class="login__form__title">Your E-mail*</h5>
                                <input type="email" class="input" placeholder="Enter E-mail" required>
                                <div class="requirements">
                                    Must be a valid email address.
                                </div>
                            </div>
                            <div class="login__item">
                                <h5 class="login__form__title">Your Password*</h5>
                                <input type="password" class="input" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required>
                                <div class="requirements">
                                    Please enter a 'Password'.
                                </div>
                            </div>
                            <input type="checkbox" id="pass">
                            <label class="checkbox-label" for="pass">Keep me signed in on this computer</label>
                            <a href="#!" class="link link_bold login__forgot">Forgot Your Password?</a>
                            <button class="button button-1">Sign in to Proceed to Checkout</button>
                        </form>
                        <h5 class="login__subtitle">Don't have an account yet? <a href="#!" class="link link_bold">Click here to sign up</a></h5>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<?php get_footer(); ?>