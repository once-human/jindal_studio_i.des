<?php
define( 'WP_CACHE', true );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u242865308_5RVrh' );

/** Database username */
define( 'DB_USER', 'u242865308_QB5Ca' );

/** Database password */
define( 'DB_PASSWORD', 'sSfqtKmdS7' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '(BYO*_idV/HdgD{70Kc<8-*YD1d.:`2P0}8W|d.oL.1{B0qh=g-Dxe@g8It%&=5?' );
define( 'SECURE_AUTH_KEY',   'Qrx3w~NQ9x-6#Ma<IU%Qk_w-`7`kY!$L~8hGcr*A=_Q>0p;Eg. chK6PTb=!*WMa' );
define( 'LOGGED_IN_KEY',     '`%7AV;OzwRL%)? /o!a7x/Gg,(NoZposK&:(xjphm#J)Qum0JZ)Z R@=huSkXkw)' );
define( 'NONCE_KEY',         'KUcv:E+r}#q6.*8E~)gb{F+Ie5=X>&J8:0`m65>epycuw;@R_rjIhy)ZBLZ|boeZ' );
define( 'AUTH_SALT',         'B,9+coSF)(UQ9R^<PQv9zOi~:a4wc8&UM]2AD}1KO]=0^R-?%|(-*HG_02om(v5g' );
define( 'SECURE_AUTH_SALT',  'X;iphh~7l]4YNM1~b@dhk?/H*:I:GMN3eWJIxA>0bvs:v&qsA^U[LZ~P6H!6X!vS' );
define( 'LOGGED_IN_SALT',    'CU?m+:zYAjCScTUSC(G|XcA(JG6_vBv|WHOQ,YJ^x8$Z,jpgJ/*[/LLcS,(5iE/z' );
define( 'NONCE_SALT',        '$06BKi4AjMX8PRY@wvVv8y@X(@!T]<Sidm?kmCq|Oi>Z7VnC91Km=U}%Z5SP3;T=' );
define( 'WP_CACHE_KEY_SALT', 'Ysbt,dE;eeAggi=(vH P8qOn6!2|IWn;.z<E KFM58^jrYo3Bw19x0j$-n;&MZit' );


/**#@-*/

/**
 * WordPress database table prefix.
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
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
