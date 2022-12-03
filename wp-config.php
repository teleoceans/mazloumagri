<?php
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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'aqualin4_mazloum-agri' );

/** Database username */
define( 'DB_USER', 'aqualin4_teleoceans' );

/** Database password */
define( 'DB_PASSWORD', 'teleoceans@123@123@' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '7*WlHh5}cML]T-Ez7476MT#<LCruGUJ4)g/@lkS0`/Svvav2eYE8EDHD8^evS|^E' );
define( 'SECURE_AUTH_KEY',  '7eS1]l]|N8sR]-Qbo+ek|o`^j5m]^#Ub)xYW<mJG.:QRu~[kbX$9L(S5N5vj!1l,' );
define( 'LOGGED_IN_KEY',    ')-&[A~JU,iJ/ >__ni13.w3v??99uha7T%dc+#XG,h]@6@Ik=Qdwk2|>d~Q8AR6U' );
define( 'NONCE_KEY',        'OF+}mYmQtG#~ejbT/aI;y1Vfr^|;fJasHv_KPCQWH4Ub{-U3aywP):5+@In,R~T(' );
define( 'AUTH_SALT',        '* SiKN8]g*3i=~@4DRBQ}E=q>x{<#o7GP0Zc6[fYjMXqLQ/Es9TR#SmueNFWrZ s' );
define( 'SECURE_AUTH_SALT', '>CFH]_e4:]JlVcd7RJcgS6!5l0#{.JH^%MP fyx.ZqVuY$~uB^6:->N#nbtpc2m;' );
define( 'LOGGED_IN_SALT',   '`f-dVJ4.@=IpHx:_W0/(>bFlS?3BmlMW!I&T*V[b3YM$|F[0d;in@fTI63#a/H6o' );
define( 'NONCE_SALT',       'PUGUpvu55vu]Fm/7~Kb tHM89e7G#}BQ7<n,3V$SF5r_7iFST;N.wk0}Zx*p,V-}' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
