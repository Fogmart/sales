<?php
//Add new submenu page to woocomerce
add_action('admin_menu', 'mp_register_my_custom_submenu_page');

//register submenu page
function mp_register_my_custom_submenu_page()
{
	add_menu_page(
		__('Model Price Table'),
		__('Model Price Table'),
		'manage_options',
		'model_price_table',
		'mp_render_page',
		'dashicons-editor-paste-text'
	);
}

//page render handler
function mp_render_page()
{	
	include(MP_PARTS . '/admin.php');
}


//styles and scripts
function mp_admin_page()
{
	$screen_data = get_current_screen();
	if ($screen_data->base == 'toplevel_page_model_price_table') {
		wp_register_script('MP_admin', MP_SCRIPTS . '/admin-page.js', false);
		wp_localize_script( 'MP_admin', 'mpData', array( 
			'mp_cs' => wp_create_nonce("mp_cs"), 
		) );

		wp_enqueue_style('MP_cloned', MP_STYLES . '/cloned-styles.min.css', array(), false, 'all');
		wp_enqueue_style('MP_bootstrap', MP_STYLES . '/bootstrap.min.css', array(), false, 'all');
		wp_enqueue_style('MP_alertify', MP_STYLES . '/alertify.min.css', array(), false, 'all');
		wp_enqueue_style('MP_alertify_theme', MP_STYLES . '/alertify-theme.min.css', array(), false, 'all');

		wp_enqueue_script('MP_bootstrap', MP_SCRIPTS . '/bootstrap.min.js', false);
		wp_enqueue_script('MP_jquery', MP_SCRIPTS . '/jquery.min.js', false);
		wp_enqueue_script('MP_popper', MP_SCRIPTS . '/popper.min.js', false);
		wp_enqueue_script('MP_admin');
		wp_enqueue_script('MP_alertify', MP_SCRIPTS . '/alertify.min.js', false);
		// wp_enqueue_script('MP_cloned_js', MP_SCRIPTS . '/cloned.js', false);
	}
}
add_action('admin_enqueue_scripts', 'mp_admin_page');
