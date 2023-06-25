<?php
if(!defined('DISALLOW_FILE_EDIT')){define('DISALLOW_FILE_EDIT', true);}
?><?php
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
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/zoovikie/public_html/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'zoovikie_shop' );

/** MySQL database username */
define( 'DB_USER', 'zoovikie_shop' );

/** MySQL database password */
define( 'DB_PASSWORD', '3=rerNvZC@cS' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY', 'd&AbF#1ozgv@rCdxf(7w/bL?]Z cd+g HTos!&d/$]@6;RJm+V3g5%bL$Zm]^b39');
define('SECURE_AUTH_KEY', '.fXsn,d9&j.KdK[_F uaO5dfgu$o&&c9jc&^dkGJt<`r^200B6dFeOE&Xi(`l5!`');
define('LOGGED_IN_KEY', 'R,$<:`D,: u,o3;p3AS/?5.j~|u/S)%>$UhyPx Su>h%4!%=jQG;-Q.-*Kia 7To');
define('NONCE_KEY', 'cQT;G/m;U5uw4UVNs<zKneDOL;1bjKOFC7&)z8vgV?&T]PY4Q+qFuDIj?#_BGpM#');
define('AUTH_SALT', '78y1L&Bl.A~IU>M!egP,k/hK4r(tehp,@(Fp8O6g kB(=ERrn?e6+OodSmm/ ONc');
define('SECURE_AUTH_SALT', '6@?(N2Xj<6_m0LlRinrNgNB27w,_2RJVWR6|5t`K7jBYE:8(pGc&qm#5^>+f5$((');
define('LOGGED_IN_SALT', 'NI B534*LSCqRd8lkQpfE>/Q&b0+GTvvf4G4[4NUdAL/G7pd]=c^s`W.CnnOs^k,');
define('NONCE_SALT', 'PMZGH#3m|<Lr_was)6UwTbu~=yfyVVV.WleS#YQbjc<$_XZ0El&(w;)hvOYtHSEl');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'Vs8_';

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
