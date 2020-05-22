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
define('DB_NAME', 'wordpress_00b');

/** MySQL database username */
define('DB_USER', 'wordpress_d7f');

/** MySQL database password */
define('DB_PASSWORD', 'eRkW_74H1v');

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
define('AUTH_KEY',         'qPxTGDJRMaedAZsl%GuyRy1WKWMFO)KJU6lDSwuuuZI0xtjGqC)jdC0i2B2MdhBd');
define('SECURE_AUTH_KEY',  '%DeyUFStK%0oq!6sD*EfehPzbGDmF2bEpLL8Pb)ma!GaS1(Dvl2lqD5PAuZ4P4Cm');
define('LOGGED_IN_KEY',    'IDbPpYX9Fbf&@jfgBk(btWOtWjr3)l2FAo&cPV9kDnI4hwPugEmpe*Dvf(PCeAG#');
define('NONCE_KEY',        '^6VXxc#sWJ^YfY9j(ACF%tuo*1482JxL0y#b4RMBvhiWP@NjwSV&U6qQoCTA#W!w');
define('AUTH_SALT',        'iZ%YD0Jpp2kWGhm3xcvgFw@%NQsM&w19c#2PFKYLzHUIai#w1()J6bUFoziF94eZ');
define('SECURE_AUTH_SALT', 'ESHzxK37C(K!2F50v^4LAY)k7SAX3VAJIZ5d4(B^vkvGwY#rJNF%lJzNbqeMWVd&');
define('LOGGED_IN_SALT',   '4Oxf6dlgFGi*hrw(@mUIExrVMjm4JHBY%&*AZbnd5^Q6P2j0#^jZG#%kXRqt6)R8');
define('NONCE_SALT',       '@b*Ms61ItF6GFx^QDSxCd(#1e4&^WJE1&QJWHAfJeAB!a5M1MJF0fn@W#e2w3vEa');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'GRh3wGo8_';

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
