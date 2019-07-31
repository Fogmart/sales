<?php
define('WPCF7_AUTOP', false );
define('WP_CACHE', true);

define( 'DB_NAME', 'sales' );

define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'localhost' );

define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define('AUTH_KEY',         'H]`_Pdd[WV<lohWQ)0un~d|lPBUpInX:+tt)$|&MOSvK-|X*/_V@:&(1a,szF|u%');
define('SECURE_AUTH_KEY',  '|Yv:EM+gZ|,g_+6ikMLhu[q:`$r<c`ozzVs{PoA9K qQTA*|=yb$JtMuue-/V$Qy');
define('LOGGED_IN_KEY',    '(?Xc>4_bE_(%j-%*mM@6u[*lsNSe=Y`gC_YV^|jF|ktuk,dYsXT(rcmm{*d-@H2U');
define('NONCE_KEY',        ']7-f,FyX$S^[y8c,`VT~y`w$!hHV/&2o|:VkH9z@>E6AGVp5F[8_F?8i1]XPVO,F');
define('AUTH_SALT',        'l>7Qv+!*!87S(z}?,ar&qp5%av4R%}Jqk(viS8,l=naAo5`!<CaS5uakO|_w8VzL');
define('SECURE_AUTH_SALT', 'O(YIWO&(B>NK2JR}58&pKJh=6rT:KvcY4bj.Q%kOFu[.+e7A!IIkba=E%c@vDLhV');
define('LOGGED_IN_SALT',   'oHr$lan|pgF|=]Iw4oc6a r{yb|+|&1Fo4vpPV|H`/}J.qU.RE,*USMm9Ry:lHkv');
define('NONCE_SALT',       'Bg;-fy).,p :Wyv%OGeuQ4E+x8$1iy- D]cI]grtM1RE|(%]/X9 67-  ef<(O&(');

$table_prefix = 'sales_';

define( 'WP_DEBUG', false );
define( "WP_DEBUG_DISPLAY", false );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
require_once( ABSPATH . 'wp-settings.php' );
define('FS_METHOD', 'direct');