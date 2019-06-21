<?php 

 //Создание страницы и пункта меню плагина
 //регестрируем обработчик на создание страницы
 add_action( 'admin_menu', 'wcs_register_settings_page' );

 //обработчик создания страницы
 function wcs_register_settings_page(){
    add_submenu_page(
		null,  //or 'options.php'
		'Произвольная страница подменю',
		'Произвольная страница подменю',
		'manage_options',
		'my-custom-submenu-page',
		'wcs_render_page'
	);
 }

 // Добавим подменю в меню админ-панели "Инструменты" (tools):
add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
	add_submenu_page( 'edit.php?post_type=shop_order', 'Дополнительная страница инструментов', '@', 'manage_options', 'my-custom-submenu-page', 'my_custom_submenu_page_callback' ); 
}

function my_custom_submenu_page_callback() {
	// контент страницы
	echo '<div class="wrap">';
		echo '<h2>'. get_admin_page_title() .'</h2>';
	echo '</div>';

}
 
 //функция с возвратом кода страницы настроек
 function wcs_render_page(){
     include(SLD_PLUGIN.'/parts/admin.php');
 }