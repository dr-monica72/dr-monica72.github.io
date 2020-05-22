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
define('DB_NAME', 'wordpress_9e1');

/** MySQL database username */
define('DB_USER', 'wordpress_d0');

/** MySQL database password */
define('DB_PASSWORD', 'kMyS#K82p5');

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
define('AUTH_KEY',         '1241km6ifj8yNMp)EkXNEgZTJ@NT*z^%vKlB@haiKNkKxlU0NQCy8L9j0aV#zTL@');
define('SECURE_AUTH_KEY',  'TY2Y^uA)emJZk)FBr4rvh#8t3c0t%mGLr7jTMhBTx5tPchxot7wufB6QitorXDM3');
define('LOGGED_IN_KEY',    '4B^suOV0Cl&FT*%7ncz6zQ4%&yWSiUg3oVrH0usP#oL3OY(4PfDwUFCm*s6SyDrT');
define('NONCE_KEY',        '6QZ6tOmL^Xhc!%qFNy06UCjxMOY1db@2s9PqjEye0LJ#Sf&Tp@yvU*FWTB!B0)TL');
define('AUTH_SALT',        'R02jRaeTATqT7gr2ta0Y1fKljTJmoY64IL@I9jt)XXP&P&0r@XP%S!79QbG&I%0v');
define('SECURE_AUTH_SALT', 'QbFChN4eVSZMVHOT2F)d5BZOn27yVz2eOVOP1h8x3HCif)#Z^GAHhVu#w%FIk&QO');
define('LOGGED_IN_SALT',   '81&ogTP12y4IFc@e(Ctk@D@9E&SZ@kQxDtLUrJ#AZ6s*HTkOr@Kfbcn2k2eWrCvD');
define('NONCE_SALT',       '2*dTc5Pnkd4IM0^&M488p1l7z0Qf)ji)R4NQj@Uo58(dx6XuuZut84UuZ!07kYq#');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'Iq835_';

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
