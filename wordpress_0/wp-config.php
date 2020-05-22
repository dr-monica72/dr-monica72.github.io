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
define('DB_NAME', 'wordpress_0d');

/** MySQL database username */
define('DB_USER', 'wordpress_a6d');

/** MySQL database password */
define('DB_PASSWORD', 'L58dbKg_O0');

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
define('AUTH_KEY',         '1Lhk^k0xEyeMmyo@)pE8DS&UUHktF33t)r)htvSafaEK0y7P&TuNTz4iC9sSiHE6');
define('SECURE_AUTH_KEY',  '1n3wt2kBzqIBxyhRSdP0HfQ3RznDzsuDVhj1Mj502)NEivCDv@nYLbFsSF7zAuW7');
define('LOGGED_IN_KEY',    'LipH#MF21XZSqYkQ9U6&n2GGjA)c1t!GvaPvjmqhAWm2&sO2RH5aEmdFnmDYDI%u');
define('NONCE_KEY',        'Y&ZXJnyVQg^iyZ20)RqzphyMQKNd7mC#FXz#R0(weq!393Tgsi3l)WaqdUATIz1@');
define('AUTH_SALT',        'gYT0ZgDkQUKe*#wbsc6&hIZylfKm2w8e4wb4hmP1)hn^n4wH2tH&VizZD9Iq)iCu');
define('SECURE_AUTH_SALT', 'kAQuldaMV%BEbH%TE#4qCkFLX&5cp@8Hvxf(l0e79#CmRM@cCnSYkxh3GxBTXzlx');
define('LOGGED_IN_SALT',   '9kYXYopcerGvcR8^y0*JACrJc0%5J)!(z*@A)U5t)(@I3y32IZf3tzys*Tt@6HyV');
define('NONCE_SALT',       'S&d^vgz*zgC)ad@dLg^!FZtatieV4S&nQ^JhnDzmYwtmENtOH*263ZY#05HD62q%');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'X2JSxf_';

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
