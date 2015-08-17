
<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //




if($_SERVER["HTTP_HOST"]=="127.0.0.1" || $_SERVER["HTTP_HOST"]=="localhost")
{
define('DB_NAME', 'db_test_wp');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix  = 'web__';
define('WPLANG', 'en_US');
}
else if($_SERVER["HTTP_HOST"]=="test01.tmp0230.ml"|| $_SERVER["HTTP_HOST"]=="test01.vlan")
{
define('DB_NAME', 'db_test_wp');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix  = 'test_wp01_';
define('WPLANG', "zh_CN");
}
else if($_SERVER["HTTP_HOST"]=="test02.tmp0230.ml" || $_SERVER["HTTP_HOST"]=="test02.vlan" )
{
define('DB_NAME', 'db_test_wp2');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix  = 'test_wp02_';
define('WPLANG', "en_US");
}
else if($_SERVER["HTTP_HOST"]=="test03.tmp0230.ml" ||  $_SERVER["HTTP_HOST"]=="test03.vlan" )
{
define('DB_NAME', 'db_test_wp3');
//define('DB_NAME', 'db_test_wp3_0806');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix  = 'test_wp03_';
define('WPLANG', "zh_CN");

define('PATCHPATH', dirname(__FILE__) . '/extra2.1/patch4mall/');
}
else if($_SERVER["HTTP_HOST"]=="test04.tmp0230.ml" ||  $_SERVER["HTTP_HOST"]=="test04.vlan"  )
{
define('DB_NAME', 'db_test_wp4');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix  = 'test_wp04_';
define('WPLANG', "zh_CN");

define('PATCHPATH', dirname(__FILE__) . '/extra2.1/patch4mall-2/');
}
else if($_SERVER["HTTP_HOST"]=="test05.tmp0230.ml")
{
define('DB_NAME', 'db_test_wp');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix  = 'test_wp05_';
define('WPLANG', "zh_CN");
}
else if($_SERVER["HTTP_HOST"]=="try.com")
{
define('DB_NAME', 'www2');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix  = 'try_';
define('WPLANG', "en_US");
}
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */


define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

/*

define('AUTH_KEY',         '-KaFs9BP(9OQ@N<RBNzL;DIGNQ_e9K{dY00`]YcNB^}$0biUz,BM/SepZAZd9}D;');
define('SECURE_AUTH_KEY',  'Lfy#3r+gAi3p.3 D#B|H$5L/{xP.)1}+[@ZNd+o#M*]y6Q2#DHHpVa9wJ_nj2S2W');
define('LOGGED_IN_KEY',    '5$I/:PW~1#.O;U-8D7;0?}QJ:c|^:F%K/70v%!4<NS*`~-B!(}DVP}rAIjx;Ef:h');
define('NONCE_KEY',        'a.B/N;ESEg3q;dN8LLb^:k&55Kt{D$*CUJbSH}uw*]C&bL}7g,(/vs8B2ZmbI:4z');
define('AUTH_SALT',        'Vt{%&t~}^ghWc; ^od2fcF^tbd+XQ{qtAzs}-KL>c845N*c(t0lHz!Tl_AJviL0S');
define('SECURE_AUTH_SALT', 'BHx.A.s+dfW}v6r[Can`|p##gTT{rIH~FxLLN+ Q<&E:3k%m`?.e%FU!wQUnVv:E');
define('LOGGED_IN_SALT',   '1 pjKpHue5dFP![EY>kG%#91VNjRCB%pk9b3iQr<+!6?r[9G6!p&oNLJ!V?Av?X7');
define('NONCE_SALT',       '8OW|m }WY$Zc?dZ1Cg`JjcoVA+]kameLI+L_}Ty:xarX^mhkYrc:.tq@^E=l1S*P');



*/




/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */

//$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
//define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
define('SAVEQUERIES', true);
//var_dump($wpdb->queries);
//var_dump("hello test");
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

// add for auto install plugin with ftp account problem  20150713
define("FS_METHOD", "direct");  
define("FS_CHMOD_DIR", 0777);  
define("FS_CHMOD_FILE", 0777);



