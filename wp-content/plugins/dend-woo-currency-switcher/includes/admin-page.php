<?php
//Add new submenu page to woocomerce
add_action('admin_menu', 'register_my_custom_submenu_page');

//register submenu page
function register_my_custom_submenu_page()
{
	add_submenu_page(
		'woocommerce',
		__('Currency Switcher Settings'),
		__('Currency Switcher'),
		'manage_options',
		'currency-switcher',
		'wcs_render_page'
	);
}

//page render handler
function wcs_render_page()
{
	$settingsCore = WCS_Settings::getInstance();
	
	$currencies = get_woocommerce_currencies();
	$mainTemplate = $settingsCore->getMainTemplate();
	$oneTemplate = $settingsCore->getOneTemplate();
	$activeTemplate = $settingsCore->getActiveTemplate();

	set_query_var('wcs_admin', compact(
		'currencies',
		'mainTemplate',
		'oneTemplate',
		'activeTemplate'
	));
	include(WCS_PARTS . '/admin.php');
}


//styles and scripts
function wcs_admin_page()
{
	$screen_data = get_current_screen();
	if ($screen_data->base == 'woocommerce_page_currency-switcher') {
		wp_register_script('wcs_admin', WCS_SCRIPTS . '/admin-page.js', false);
		wp_localize_script( 'wcs_admin', 'wcsData', array( 
			'wcs_cs' => wp_create_nonce("wcs_cs"), 
		) );

		wp_enqueue_style('wcs_bootstrap', WCS_STYLES . '/bootstrap.min.css', array(), false, 'all');
		wp_enqueue_style('wcs_alertify', WCS_STYLES . '/alertify.min.css', array(), false, 'all');
		wp_enqueue_style('wcs_alertify_theme', WCS_STYLES . '/alertify-theme.min.css', array(), false, 'all');

		wp_enqueue_script('wcs_bootstrap', WCS_SCRIPTS . '/bootstrap.min.js', false);
		wp_enqueue_script('wcs_jquery', WCS_SCRIPTS . '/jquery.min.js', false);
		wp_enqueue_script('wcs_popper', WCS_SCRIPTS . '/popper.min.js', false);
		wp_enqueue_script('wcs_admin');
		wp_enqueue_script('wcs_alertify', WCS_SCRIPTS . '/alertify.min.js', false);
	}
}
add_action('admin_enqueue_scripts', 'wcs_admin_page');
