<?php
declare(strict_types=1);

namespace SLPS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {

	private static ?Plugin $instance = null;

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		new Login();
		if ( is_admin() ) {
			new Admin();
		}
	}
}
