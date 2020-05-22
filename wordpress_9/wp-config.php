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
define('DB_NAME', 'wordpress_ee2');

/** MySQL database username */
define('DB_USER', 'wordpress_47');

/** MySQL database password */
define('DB_PASSWORD', '6HNpv5_Yw9');

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
define('AUTH_KEY',         'llb#p!IH2cI6Q^i5KYKU8&a6sjqCIOS%hsUj#nY8aTFHei)nZj4KfbK)WhSLCj@s');
define('SECURE_AUTH_KEY',  '^tnPl&YPT!UmvoGIQW25Dy^xNshEh0FMs5borUhPiNgl)FyBOmuKLpoT*5%oCL%d');
define('LOGGED_IN_KEY',    'iHwo0dRx*4^UVXB8FkVhppr(^NZOQUIpvk8vzUmfKRDZcARZsG3H4bD4i&dEHJOg');
define('NONCE_KEY',        '@G2Nrr*azm5I2R&w!&CzmXsQ3BdQ76wi#cnJ7SbwnDP!PU)!c*5Ubx(E*0Qhk4@u');
define('AUTH_SALT',        'HSwxhnG#oL3kIbey&Q(VKX2l^!GZbEPv3((sed6#JNrho7HRdPz2WN4YBWycp!9T');
define('SECURE_AUTH_SALT', 'E)MyCL&dOP7wtDbM7Jd3lOnrW%(j@NVMW#gug2MmvXH(&@ixK%@kHdgyF^W@hMcg');
define('LOGGED_IN_SALT',   'A@Wosih2M(XZIXp0!Y^DIfQyXNzBtEedQwuXNn(KR2Nf05L0DUGwGWETu*g%ha^3');
define('NONCE_SALT',       '(9y506AW)&sj410brEiwVicR)K3MwzKjHwBEWM8!y4pmQQHr2k0m1SnD#fCbe!Tf');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'bIeYNe77y_';

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
