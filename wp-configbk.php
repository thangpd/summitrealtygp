<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'summitrealtygp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'gNA)V2RHiO)*gXHLMAt <8{4x|Ta[xT{F`dv>A5B%S.j/pd[/qA+E>rbXv$[5.={' );
define( 'SECURE_AUTH_KEY',  ' Y=ZwB~N}(71gejN7C=+]QH/R1Ez;@mtV[]f,-AEK{SK_@7__ 9>?2_Be9Nu#5MX' );
define( 'LOGGED_IN_KEY',    '</?CzBaq+GHEy?@q+|&9n$)Hhm :E?Q2pfUh9XiGLv.p]c9*~ZWR2iT4-kUsE9qk' );
define( 'NONCE_KEY',        'V/4]pL/D*{J|M+|]lZbo.e /lhRI/kWoLyg!Gha})[~f8!x]=ZvAWu@N35iOQwfL' );
define( 'AUTH_SALT',        'AUeBa9(D+rhd0[4}DO>^^xC093u<$/K<XsdU1mzlt1mr<Q<?8([Sq4i|Ag?7V2Q{' );
define( 'SECURE_AUTH_SALT', '1t]x/s.VrR/^`2&epw/|h=ksJAv@;g0a^u`Lu_T,LGXB2=Nsq}]ukQ&}3=c GI6%' );
define( 'LOGGED_IN_SALT',   '?J&&%dH^JZ8mR6@1r0/K<^z^bTP&t8kEAEpwj{Ui)BJ<1}Sk`7Gwioc,xnOK4h<{' );
define( 'NONCE_SALT',       '2HE(8|KTa`,|d,/N%m&[Z/:[$8BHAvs;vu95CrH&lN.J8pJNfh}9CA48?AvG|.y8' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define('FS_METHOD','direct');
define( 'WP_DEBUG_LOG', true );
define( 'EP_HOST', 'http://localhost:9200' );
ini_set("memory_limit","1024M");
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

