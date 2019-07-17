<?php
//Add new submenu page to woocomerce
add_action('admin_menu', 'mp_register_my_custom_submenu_page');

//register submenu page
function mp_register_my_custom_submenu_page()
{
	add_menu_page(
		__('Прайс услуга - модель'),
		__('Прайс таблицы'),
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

/*
<div class="source">
                            <?php if ($code = ModelPriceTable::getCode()) : ?>
                                <?= $code ?>
                            <?php else : ?>
                                <div class="mp-table-container">
                                    <div class="table">
                                        <div class="table__col">
                                            <div class="table__row">
                                                <div class="table__cell">Ceramic Pro 9H</div>
                                            </div>
                                            <div class="table__row js_height_cell">
                                                <div class="table__cell">
                                                    Ceramic Pro Light </div>
                                            </div>
                                            <div class="table__row js_height_cell">
                                                <div class="table__cell">
                                                    О Ceramic Pro 9h (каждый слой) </div>
                                            </div>
                                            <div class="table__row js_height_cell">
                                                <div class="table__cell">
                                                    Ceramic Pro 9h 1 слой + Ceramic Pro Light </div>
                                            </div>
                                            <div class="table__row js_height_cell">
                                                <div class="table__cell">
                                                    (2+) Ceramic Pro 9h 2 слоя + Ceramic Pro Light </div>
                                            </div>
                                            <div class="table__row js_height_cell">
                                                <div class="table__cell">
                                                    (4+) Ceramic Pro 9h 4 слоя + Ceramic Pro Light </div>
                                            </div>
                                            <div class="table__row js_height_cell">
                                                <div class="table__cell">
                                                    (6+) Ceramic Pro 9h 6 слоев + Ceramic Pro Light </div>
                                            </div>
                                            <div class="table__row js_height_cell">
                                                <div class="table__cell">
                                                    Подготовка ЛКП к керамической полировке </div>
                                            </div>
                                        </div>
                                        <div class="table__col">
                                            <div class="slider-table-cols">
                                                <div class="table__group-col">
                                                    <div class="table__group-col-inside">
                                                        <div class="table__row">
                                                            <div class="table__cell">
                                                                <div class="table-icon">
                                                                    <i class="icn icn_bycicle"></i>
                                                                </div>
                                                                Мотоциклы
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        6 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Ceramic Pro Light_Мотоциклы">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        8 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="О Ceramic Pro 9h (каждый слой)_Мотоциклы">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        14 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" Ceramic Pro 9h 1 слой + Ceramic Pro Light_Мотоциклы">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        22 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (2+) Ceramic Pro 9h 2 слоя + Ceramic Pro Light_Мотоциклы">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        38 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (4+) Ceramic Pro 9h 4 слоя + Ceramic Pro Light_Мотоциклы">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        51 300 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (6+) Ceramic Pro 9h 6 слоев + Ceramic Pro Light_Мотоциклы">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        7 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Подготовка ЛКП к керамической полировке_Мотоциклы">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table__group-col">
                                                    <div class="table__group-col-inside">
                                                        <div class="table__row">
                                                            <div class="table__cell">
                                                                <div class="table-icon">
                                                                    <i class="icn icn_car-xs"></i>
                                                                </div>
                                                                Класс 1
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        8 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Ceramic Pro Light_Класс 1">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        11 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="О Ceramic Pro 9h (каждый слой)_Класс 1">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="old-price">19 000 <i class="fa fa-rub"></i></span>
                                                                    <span class="new-price">Акция - 17100 <i class="fa fa-rub"></i></span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" Ceramic Pro 9h 1 слой + Ceramic Pro Light_Класс 1">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        30 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (2+) Ceramic Pro 9h 2 слоя + Ceramic Pro Light_Класс 1">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        52 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (4+) Ceramic Pro 9h 4 слоя + Ceramic Pro Light_Класс 1">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        70 300 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (6+) Ceramic Pro 9h 6 слоев + Ceramic Pro Light_Класс 1">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        10 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Подготовка ЛКП к керамической полировке_Класс 1">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table__group-col">
                                                    <div class="table__group-col-inside">
                                                        <div class="table__row">
                                                            <div class="table__cell">
                                                                <div class="table-icon">
                                                                    <i class="icn icn_car-s"></i>
                                                                </div>
                                                                Класс 2
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        9 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Ceramic Pro Light_Класс 2">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        13 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="О Ceramic Pro 9h (каждый слой)_Класс 2">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="old-price">22 000 <i class="fa fa-rub"></i></span>
                                                                    <span class="new-price">Акция - 20900 <i class="fa fa-rub"></i></span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" Ceramic Pro 9h 1 слой + Ceramic Pro Light_Класс 2">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        35 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (2+) Ceramic Pro 9h 2 слоя + Ceramic Pro Light_Класс 2">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        61 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (4+) Ceramic Pro 9h 4 слоя + Ceramic Pro Light_Класс 2">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        82 650 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (6+) Ceramic Pro 9h 6 слоев + Ceramic Pro Light_Класс 2">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        12 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Подготовка ЛКП к керамической полировке_Класс 2">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table__group-col">
                                                    <div class="table__group-col-inside">
                                                        <div class="table__row">
                                                            <div class="table__cell">
                                                                <div class="table-icon">
                                                                    <i class="icn icn_car-sm"></i>
                                                                </div>
                                                                Класс 3
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        10 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Ceramic Pro Light_Класс 3">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        14 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="О Ceramic Pro 9h (каждый слой)_Класс 3">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="old-price">24 000 <i class="fa fa-rub"></i></span>
                                                                    <span class="new-price">Акция - 22800 <i class="fa fa-rub"></i></span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" Ceramic Pro 9h 1 слой + Ceramic Pro Light_Класс 3">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        38 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (2+) Ceramic Pro 9h 2 слоя + Ceramic Pro Light_Класс 3">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        66 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (4+) Ceramic Pro 9h 4 слоя + Ceramic Pro Light_Класс 3">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        89 300 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (6+) Ceramic Pro 9h 6 слоев + Ceramic Pro Light_Класс 3">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        14 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Подготовка ЛКП к керамической полировке_Класс 3">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table__group-col">
                                                    <div class="table__group-col-inside">
                                                        <div class="table__row">
                                                            <div class="table__cell">
                                                                <div class="table-icon">
                                                                    <i class="icn icn_car-md"></i>
                                                                </div>
                                                                Класс 4
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        11 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Ceramic Pro Light_Класс 4">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        15 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="О Ceramic Pro 9h (каждый слой)_Класс 4">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="old-price">26 000 <i class="fa fa-rub"></i></span>
                                                                    <span class="new-price">Акция - 24700 <i class="fa fa-rub"></i></span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" Ceramic Pro 9h 1 слой + Ceramic Pro Light_Класс 4">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        41 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (2+) Ceramic Pro 9h 2 слоя + Ceramic Pro Light_Класс 4">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        71 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (4+) Ceramic Pro 9h 4 слоя + Ceramic Pro Light_Класс 4">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        95 950 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (6+) Ceramic Pro 9h 6 слоев + Ceramic Pro Light_Класс 4">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        16 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Подготовка ЛКП к керамической полировке_Класс 4">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table__group-col">
                                                    <div class="table__group-col-inside">
                                                        <div class="table__row">
                                                            <div class="table__cell">
                                                                <div class="table-icon">
                                                                    <i class="icn icn_car-lg"></i>
                                                                </div>
                                                                Класс 5
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        14 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Ceramic Pro Light_Класс 5">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        16 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="О Ceramic Pro 9h (каждый слой)_Класс 5">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="old-price">30 000 <i class="fa fa-rub"></i></span>
                                                                    <span class="new-price">Акция - 28500 <i class="fa fa-rub"></i></span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" Ceramic Pro 9h 1 слой + Ceramic Pro Light_Класс 5">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        46 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (2+) Ceramic Pro 9h 2 слоя + Ceramic Pro Light_Класс 5">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        78 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (4+) Ceramic Pro 9h 4 слоя + Ceramic Pro Light_Класс 5">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        104 500 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name=" (6+) Ceramic Pro 9h 6 слоев + Ceramic Pro Light_Класс 5">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                        <div class="table__row">
                                                            <div class="table__cell with-order-btn">
                                                                <div class="b-price">
                                                                    <span class="current-price">
                                                                        18 000 <i class="fa fa-rub"></i> </span>
                                                                </div>
                                                                <span class="btn-order"><a href="#modalSubmitApp" data-service_name="Подготовка ЛКП к керамической полировке_Класс 5">Записаться</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
*/