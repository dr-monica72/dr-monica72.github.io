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
define('DB_NAME', 'wordpress_60');

/** MySQL database username */
define('DB_USER', 'wordpress_1d9');

/** MySQL database password */
define('DB_PASSWORD', 'Mw_E327bBf');

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
define('AUTH_KEY',         'StOGJ3hHNrDaISIUNqPXBcZ&dYaM1AxAcz3PT43gZw6HQF#jIM!Qr79rWXcBK!6x');
define('SECURE_AUTH_KEY',  '6i4JagDySo%ry7j8x9BeVr&ReGeVHomsmd0wNl*bxz2kViyfi&ZEqBGonMa9cNSW');
define('LOGGED_IN_KEY',    '7nfL&mZaw9fFKnbw9KUxANVtZV0u1KIU2MJczG3jCmEcjrfpcgu%VA*8db^IWPLi');
define('NONCE_KEY',        'fOU7e7NP30O(jkqiu1Ds1u6s*U6otEbOoV6c10XWQXu8gs5cfqqr%AVf)opz63)0');
define('AUTH_SALT',        '6#@@lH%Bq!PQnIVSzXrZERZBLGNnz*ePEg#noKID%9)rvVnl4iMQ5f4Lgx)(@e4Q');
define('SECURE_AUTH_SALT', 'G*RpJjkoHBsX6%0%oMzz@GgmX%8lh&p%!0ZtMfA1TF%E*sWqQBYFb2uugp)0PHoW');
define('LOGGED_IN_SALT',   'txRKRcgOCc0sQ7L*pf^UUmd#tRLC8CC@CRrHoll(h%SU@ftSzjsoid^OPdmx7oOY');
define('NONCE_SALT',       '(Ah2RfE)%^!cGzr^9n0(*hq#yoMKZxRIj4PrLaCMG6CSGd@CS6lx6HYJm!P%6SYe');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'Zk205eiB3_';

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
