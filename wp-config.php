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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'test' );

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
define( 'AUTH_KEY',         '=3pF.HX=O+wE:{>M:i-)l>KdDBlO?x2_/IgDxp1)_}|<f/rM$AJwWmjI/Q@kM({f' );
define( 'SECURE_AUTH_KEY',  'ed!>z ,w#F4c}Y#KOMA.4R*~HuGHj{4Cbhf+`3zs/iq5[iJdHU)s^Ui/k;L$*e|-' );
define( 'LOGGED_IN_KEY',    '{yaFUt<CXTQ$th/hwQ5@-B>-2LzF&6S3EoQ/ 2zxq!1!g=eKi3=V`v^@46pR+90y' );
define( 'NONCE_KEY',        'Q_/%+@m2Oc3}Rk=uN/D$346>!0+j*<SN4c.&cJt0SuRn(uV&^Ih# UmquZ;F5Cff' );
define( 'AUTH_SALT',        'npluC@y-f6c,_.f(bw>8Cc3y_C,./^A:#s?agT zF,OHr@Tj|hOwUo=E)pP,+Z t' );
define( 'SECURE_AUTH_SALT', '=SM;[ExbHKM3^V0i(|euQ4(#Ca2Z?{.^<VCdy/jZEVfG+bK}G3yKf[xR?z%o4,cj' );
define( 'LOGGED_IN_SALT',   '?xN]&gxTEx!~T&p[+Z1Adqwh2BSClW7H2/Gr2~~d%,OtHL]>o|U 6u}s13z ~jKa' );
define( 'NONCE_SALT',       'BP5]CVzADkW^.B5gJ O/T3= n&w huCx6Z9~LmNSE{Gw/Y zO~kS/;tx{fHH2rO5' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
