<?php
global $kdn_theme_options; 
$logo = $kdn_theme_options['logo-upload'];
?>
<!DOCTYPE html>
<html lang="<?= bloginfo('language') ?>">
<head>
	<meta charset="<?= bloginfo('charset') ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<title><?php bloginfo('name') ?></title>
</head>

<body>

	<header class="header fixed-header">
		
		<div class="header__top">
			<div class="container">
				<div class="header__top__content">
					<div class="header__top__text"><?= $kdn_theme_options['slogan'] ?></div>
					<?= do_shortcode('[wcs_switcher]') ?>
				</div>
			</div>
		</div>
	
		<div class="header__main">
			<div class="container">
				<div class="header__main__content">
	
					<div class="header__left">
						<button class="menu-button" onclick="this.classList.toggle('active')">
							<svg viewBox="0 0 100 100">
								<path class="line top" d="m 70,33 h -40 c 0,0 -8.5,-0.149796 -8.5,8.5 0,8.649796 8.5,8.5 8.5,8.5 h 20 v -20" />
								<path class="line middle" d="m 70,50 h -40" />
								<path class="line bottom" d="m 30,67 h 40 c 0,0 8.5,0.149796 8.5,-8.5 0,-8.649796 -8.5,-8.5 -8.5,-8.5 h -20 v 20" />
							</svg>
						</button>
						<div class="logo"><a href="/"><img src="<?= $logo['url'] ?>" alt="<?= $logo['alt'] ?>"></a></div>
					</div>
	
					<form class="search header__search">
						<input type="text" placeholder="<?= __('Search')?>">
						<button class="button button-3"><img src="<?= ss_asset('img/icons/search.svg') ?>" alt=""></button>
					</form>
	
					<div class="control">
	
						<div class="control__item search__mobile-btn">
							<span class="control__icon"><img src="<?= ss_asset('img/icons/search.svg') ?>" alt=""></span>
						</div>
	
						<div class="control__item">
							<span class="control__icon"><img src="<?= ss_asset('img/icons/user.svg') ?>" alt=""></span>
							<span class="control__link"><?= __('Sign in') ?></span>
	
							<div class="control__login control__popup">
								<div class="control__login__title"><?= __('If you are a new user') ?></div>
								<a href="#!" class="control__login__register"><?= __('register') ?></a>
								<button class="button button-1"><?= __('login') ?></button>
							</div>
						</div>
	
						<div class="control__item my-anadi">
							<span class="control__icon">
								<img src="<?= ss_asset('img/icons/label.svg') ?>" alt="">
								<span class="control__counter">21</span>
							</span>
							<span class="control__link"><?= __('My Anadi') ?></span>
						</div>
	
						<div class="control__item">
							<span class="control__icon">
								<img src="<?= ss_asset('img/icons/cart.svg') ?>" alt="">
								<span class="control__counter">3</span>
							</span>
							<span class="control__link"><?= __('Cart') ?></span>
	
							<?php get_template_part('parts/header', 'cart') ?>
	
						</div>
	
					</div>
	
				</div>
			</div>
		</div>
	
		<?php echo ss_menu_header(); ?>
	
		<div class="search_mobile">
			<form class="search_mobile__content">
				<input type="text" placeholder="<?= __('Search')?>">
				<button class="button button-3"><img src="<?= ss_asset('img/icons/search-yellow.svg')?>" alt=""></button>
			</form>
		</div>
	<?php wp_head(); ?>
	</header>