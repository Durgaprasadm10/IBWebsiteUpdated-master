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
define('DB_NAME', 'ideabytes_hrm');

/** MySQL database username */
define('DB_USER', 'ideabytes_wp');

/** MySQL database password */
define('DB_PASSWORD', '&(wp_ideabytes)&');

/** MySQL hostname */
define('DB_HOST', 'ideabytesdb.c6hujshgwzfd.us-east-1.rds.amazonaws.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'LHWf2vC)+Xe.y+r8rOEv&<~+oR8bxq/c/lg<kQg44j/#J`-uMqx`V#$bCgGC?o-M');
define('SECURE_AUTH_KEY',  'l-z(-m4PojTehqPK+1|.d@* gdpWt`u*VUM+ynp&JN!!h8r-;$+#GVT|]Vd[SJ**');
define('LOGGED_IN_KEY',    'SVu;19SeCl^k9^Aqcjr)eTpN8CD,5u(#|f}>KMyQ89/Yd!m|u5n7JiU|Ibs]prF!');
define('NONCE_KEY',        '~1BG2OOw/?7fd,|o(oQPnv$dvV*bo41^+b,HxB(e9D[bWb+Sg?q4v|#A}5WiTC[t');
define('AUTH_SALT',        'Eqk8x}c(wL.1I(PBv{ylu>g[0={&uc:yT-dAJc))Cp]<x=7[v6>2TKIXV{m!S%~;');
define('SECURE_AUTH_SALT', 'w15<qHY]+(w{~k{n;pVc|K0GbHZ{SKFVe9#DP1,W1V3/e{JQg~Chd>KN=Tx+Nt1n');
define('LOGGED_IN_SALT',   '|9L#s,zFEU-IaS36=)|-4Y988Jd]2#{`)&p(MHd;+}rK;H-B=!7f!b;`I#h.t1s8');
define('NONCE_SALT',       '62Cx$]Hdmn/B0 /}&Y%x-T/aJ9BP*5-rp-; 5[L3x.k?-ZdRp<C$CBGD<=5BEi_T');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
