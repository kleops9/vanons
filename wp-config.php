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
define('DB_NAME', 'klearchos_wp');

/** MySQL database username */
define('DB_USER', 'klearchos_wp');

/** MySQL database password */
define('DB_PASSWORD', '12345');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '(S$Y38):u=6C3_)hkb/I92$f3y2LWwnfJGX*=@JIKu_!q-}VB]Gmi^&JO_@>s:!b');
define('SECURE_AUTH_KEY',  '%{trOb#55v<QcK&sFDJ[BewLlFJ/s].!M:+p$iRBGUfk`)y z?+yt$^a~}M(PLd(');
define('LOGGED_IN_KEY',    'm&  VH7*cvA.Do6#D}_6ihHQu4V[)mp0narhD.FFGuh}A=kP8tuhH-(HPD*ylfF}');
define('NONCE_KEY',        '1G}F3k =T;p%4x;;]gcMF]9mEM|%=)6x Vx]Er$@IJ2^1`MT%[M?MQ0[BmeEZU-[');
define('AUTH_SALT',        'kfqU&}UxnU(pl`FqW:baU7moU#/AAy<As^1rq`jEnumFVo-0-?|?M@pL amJj81p');
define('SECURE_AUTH_SALT', 'FRp*NN!%vfcb64$[dAPOQ< ex=YEV@,UG<md9!}lQpVohHM3e;8I{<9=z2(K<1xu');
define('LOGGED_IN_SALT',   'zFk w50??k-[%96G8#9k6XM(~BpGjlq/{vQPC%<eN7&uxOk|)a5g.W_$W1C(kvy~');
define('NONCE_SALT',       'q!cc)lR k|7BUSquKajWc#Nu>[B7a4s`;t[<]*l )&:2`^uNWa#TAL(:0L+Yklz>');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hc_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
