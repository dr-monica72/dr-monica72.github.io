<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_d1a');

/** MySQL database username */
define('DB_USER', 'wordpress_d70');

/** MySQL database password */
define('DB_PASSWORD', 'V1_ZJb0r4g');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'OUX^*ZY!W2OjIcpmIHSAij!Gmkzb^nWErY4Of(P^8CFSHYneLpIE*uAYFPHxb3@L');
define('SECURE_AUTH_KEY',  'cxc9myzJ*!gIpn806#AOkHiwPpj)Jh1QkEM6bD!dmBJub*@1bTbuo(aOw9R6CRp6');
define('LOGGED_IN_KEY',    'pYIF#i#HYDrvYL*gfL(%pB2Dc@p6RPzqdiSllTt4QsKx0WN1kSD37w!V5@460Hd)');
define('NONCE_KEY',        'HQJr95#KR7bG*B&3)p#W&1!Jq3VcN60wqYGXcTZYN59l#)tOA30&eXAX#5oW6S71');
define('AUTH_SALT',        'u9stYu^@4*xsRG%Fg58^J!r2e&6ilsOTcQzgFF1pEvkeXWe8oYB@29VKgWq5GBl4');
define('SECURE_AUTH_SALT', '7Y*uL)SsOTW!2BYAaFH7ld2wM48&HgA1n!d2K^*#(&H7x&Zycj@UTS5xRIv2&^L%');
define('LOGGED_IN_SALT',   '6o7n(tTdOsoo)r&g3iH%R!JsD!1GZWvGMNAxy!Dvh5@IvJ*xyfFAlWN*jrvfyF&f');
define('NONCE_SALT',       'Z7W8XP5Ydll*aBLk%T7&u8)B@KnvR#cBg7h1knaj7%fm2BB!jVUdOCeN@4GF3Nkn');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'egmLSE9_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'en_US');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');

//--- disable auto upgrade
define( 'AUTOMATIC_UPDATER_DISABLED', true );
?>
