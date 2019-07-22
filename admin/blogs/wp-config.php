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

define( 'DB_NAME', 'herinh4u_texraja' );


/** MySQL database username */

define( 'DB_USER', 'herinh4u_webdev' );


/** MySQL database password */

define( 'DB_PASSWORD', "webdev123*" );


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

define( 'AUTH_KEY',         'RbKtRuoE}k](_Uw28cXR8xf2V~7K;dQoMp}iW|>|*zhiVGzFnbm?,+#ID8C&$7:{' );

define( 'SECURE_AUTH_KEY',  '`~VJO;#)9gW<4L|bKAT`dl__,=L78K?3o)(vUF>A4+/aM=s~vmn?)r#yB;{?k7C`' );

define( 'LOGGED_IN_KEY',    'KVoqXJ9MEf9T1fxC0CSI1=lqR3QPFRfQW.(e{[u+vGRW%tip_+h<5>ABvIRA6+3]' );

define( 'NONCE_KEY',        ',5xwVT|Z^_Z<0]MXfj$3m<?jy+Yb1>|Zz8p7<6U~~TJ1p7>}aU&P]LQIDd$?o7.O' );

define( 'AUTH_SALT',        'R[/91T/U>K<#~Z}I2%JM=I&bX1MEln>91WA57mu /g>!n%x9Cw@EG!I<bO 40u)m' );

define( 'SECURE_AUTH_SALT', '}+J<[eac,-8e$h>-{(y mYfu~+_C/TX3t5@Nu!;$DU,M(.0jh@;SI2Q^[{rdVHIM' );

define( 'LOGGED_IN_SALT',   'F*S>j4c}zb`DQI(D{FVgzWZqCY6#9_(uU;bK%M#6zhySO*f7eVf%T,)=GzLRYGMa' );

define( 'NONCE_SALT',       'K%sB/|NT>6,^YZZkG:|?>CF7rYp8Sg{3&GVYp;i=/z:b2svG&u##< m h[wUfJGw' );


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

