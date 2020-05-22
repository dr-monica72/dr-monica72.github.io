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
define('DB_NAME', 'wordpress_8d0');

/** MySQL database username */
define('DB_USER', 'wordpress_f89');

/** MySQL database password */
define('DB_PASSWORD', '5l2Ds$u7WO');

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
define('AUTH_KEY',         'vttM%el*nvTNFVC1KIcuaUd5x7qN4bgAKi7fHn0GzWyF7@t@tePqJVvynoNSlODO');
define('SECURE_AUTH_KEY',  'wNIW4%JGp#qZE8zTXADz5sW5Uz16UshhK4smdIhLPVa*5JD6atTQY0EMMVuqbsi*');
define('LOGGED_IN_KEY',    '#xag0y4DaSr0tv3l(Aj9!Oba*l&0ElhRdMTV5APa#!ocsHD*16E1#zTaddhw5u*O');
define('NONCE_KEY',        'ciacuxYGkIjwdn8rn&aECtkQsVoFy3B60gl4Ug&CkMZQ*ke6^hS4q7s4Rrnq#Dt#');
define('AUTH_SALT',        'yqL^Dc2oMW8NtxFTgSMarQVWG&I!xoVm1(M@Sh6O3hPncsh^t1GZsioAWKepP(qf');
define('SECURE_AUTH_SALT', 'kKT&V8c8Q22cww80xoShnNSMefI8DdrBHJQFpnu*)Ncu*N@x6wOZP%EVw#LjC12T');
define('LOGGED_IN_SALT',   'xIopDjp*97)SWownk61BARxj@YFqpX8*lFv4*HlKrNo76sOLXt*bqofSRMDSvLNe');
define('NONCE_SALT',       'pW&1&BhoP*8l#Y4TWUd@e9S75hHS&Sn3!ZSXI627ZyzRVwi#Cm3hAf1rmdX(@Qhn');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'G32W0vga_';

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
