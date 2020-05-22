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
define('DB_NAME', 'wordpress_83c');

/** MySQL database username */
define('DB_USER', 'wordpress_89');

/** MySQL database password */
define('DB_PASSWORD', '0X_35gNvdV');

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
define('AUTH_KEY',         'e2966dM*iR^4ZR7wV8m%)V1pqgGmy2qqbAOvx7inA1AxQpIHYNj2BgMQNby^uLGa');
define('SECURE_AUTH_KEY',  'U#FmQz*lr)Iuyp7wZIQ9x*)moMsJZYatp1PX7pvmUoMDSAyghzTs5pHnvAuPqKAR');
define('LOGGED_IN_KEY',    'fSnJFyxPE*1@uzA!px^rmm9!1&D2C92kk#ns3fvH8nr&eE2)#9mCsfj4AD6t2qG5');
define('NONCE_KEY',        'cP6QjCL*WTVq8pcGUdDq9SbFl*X6&Ptz!d^4@PTn^jNoL#0XUn#lOyDqzR*dqO#A');
define('AUTH_SALT',        'Ig0gjVbJ1ZTO8dZGruox2%TIF5TXf#Q2X77%TVzGymmCSrSxTr8ESE1dEV!CLaTd');
define('SECURE_AUTH_SALT', 'Lu0as9hSkK97u^L6jOhLb4jPOfTYFhGw&AcGsF*pcG2mVGiz4Pmrg#953*#%gkx(');
define('LOGGED_IN_SALT',   'H^i9!7J7!m2qL^O00ISpqZ7BsYTnfWW^P#tBxhLUeHuC7Q@6Y8%5tS@s6mWd(FNn');
define('NONCE_SALT',       'MNIH5WK9ckDTkPLMswAH)1vsvpflArSnlLYkw3GVZuZ0V(*#M%3n)GrhQYcpfyLs');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'j59Qfw_';

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
