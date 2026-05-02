<?php
/**
 * Plugin Name: Simple Login Styler
 * Plugin URI: https://wordpress.org/plugins/simple-login-page-styler/
 * Description: Replace the default WordPress login page with your own logo, colors, and text. Lightweight, no-bloat login branding for any WordPress site.
 * Version: 1.1
 * Requires at least: 6.0
 * Requires PHP: 7.2
 * Author: topdevs.net
 * Author URI: https://topdevs.net
 * License: GPL-2.0-or-later
 * Text Domain: simple-login-page-styler
 */

declare(strict_types=1);

namespace SLPS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SLPS_VERSION', '1.1' );
define( 'SLPS_FILE', __FILE__ );
define( 'SLPS_DIR', plugin_dir_path( __FILE__ ) );
define( 'SLPS_URL', plugin_dir_url( __FILE__ ) );

spl_autoload_register( function ( string $class ): void {
	$map = [
		'SLPS\\Plugin'  => SLPS_DIR . 'includes/class-slps-plugin.php',
		'SLPS\\Options' => SLPS_DIR . 'includes/class-slps-options.php',
		'SLPS\\Login'   => SLPS_DIR . 'includes/class-slps-login.php',
		'SLPS\\Admin'   => SLPS_DIR . 'admin/class-slps-admin.php',
	];
	if ( isset( $map[ $class ] ) ) {
		require_once $map[ $class ];
	}
} );

Plugin::instance();
