<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'sales' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'root' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'H]`_Pdd[WV<lohWQ)0un~d|lPBUpInX:+tt)$|&MOSvK-|X*/_V@:&(1a,szF|u%');
define('SECURE_AUTH_KEY',  '|Yv:EM+gZ|,g_+6ikMLhu[q:`$r<c`ozzVs{PoA9K qQTA*|=yb$JtMuue-/V$Qy');
define('LOGGED_IN_KEY',    '(?Xc>4_bE_(%j-%*mM@6u[*lsNSe=Y`gC_YV^|jF|ktuk,dYsXT(rcmm{*d-@H2U');
define('NONCE_KEY',        ']7-f,FyX$S^[y8c,`VT~y`w$!hHV/&2o|:VkH9z@>E6AGVp5F[8_F?8i1]XPVO,F');
define('AUTH_SALT',        'l>7Qv+!*!87S(z}?,ar&qp5%av4R%}Jqk(viS8,l=naAo5`!<CaS5uakO|_w8VzL');
define('SECURE_AUTH_SALT', 'O(YIWO&(B>NK2JR}58&pKJh=6rT:KvcY4bj.Q%kOFu[.+e7A!IIkba=E%c@vDLhV');
define('LOGGED_IN_SALT',   'oHr$lan|pgF|=]Iw4oc6a r{yb|+|&1Fo4vpPV|H`/}J.qU.RE,*USMm9Ry:lHkv');
define('NONCE_SALT',       'Bg;-fy).,p :Wyv%OGeuQ4E+x8$1iy- D]cI]grtM1RE|(%]/X9 67-  ef<(O&(');
/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'sales_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );


define('FS_METHOD', 'direct');