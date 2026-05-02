<?php
declare(strict_types=1);

namespace SLPS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin {

	const PAGE_SLUG = 'simple-login-page-styler';

	public function __construct() {
		add_action( 'admin_menu',                        [ $this, 'add_page' ] );
		add_action( 'admin_init',                        [ $this, 'register_settings' ] );
		add_action( 'admin_enqueue_scripts',             [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_post_slps_reset_defaults',    [ $this, 'handle_reset' ] );
		add_filter( 'plugin_row_meta', [ $this, 'row_meta' ], 10, 2 );
	}

	public function add_page(): void {
		add_options_page(
			__( 'Simple Login Styler', 'simple-login-page-styler' ),
			__( 'Simple Login Styler', 'simple-login-page-styler' ),
			'manage_options',
			self::PAGE_SLUG,
			[ $this, 'render_page' ]
		);
	}

	public function register_settings(): void {
		register_setting(
			'slps_option_group',
			Options::OPTION_KEY,
			[
				'type'              => 'array',
				'sanitize_callback' => [ Options::class, 'sanitize' ],
				'default'           => Options::DEFAULTS,
				'capability'        => 'manage_options',
			]
		);
	}

	public function enqueue_scripts( string $hook ): void {
		if ( 'settings_page_' . self::PAGE_SLUG !== $hook ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style(
			'slps-admin',
			SLPS_URL . 'assets/css/admin.css',
			[ 'wp-color-picker' ],
			SLPS_VERSION
		);
		wp_enqueue_script(
			'slps-admin',
			SLPS_URL . 'assets/js/admin.js',
			[ 'jquery', 'wp-color-picker' ],
			SLPS_VERSION,
			true
		);
	}

	public function render_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$opts = Options::get();
		include SLPS_DIR . 'admin/views/settings-page.php';
	}

	public function row_meta( array $links, string $file ): array {
		if ( plugin_basename( SLPS_FILE ) !== $file ) {
			return $links;
		}
		$links[] = '<a href="' . esc_url( admin_url( 'options-general.php?page=' . self::PAGE_SLUG ) ) . '">'
			. esc_html__( 'Settings', 'simple-login-page-styler' )
			. '</a>';
		return $links;
	}

	public function handle_reset(): void {
		check_admin_referer( 'slps_reset_defaults' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'simple-login-page-styler' ) );
		}
		delete_option( Options::OPTION_KEY );
		wp_safe_redirect(
			add_query_arg(
				[ 'page' => self::PAGE_SLUG, 'slps-reset' => '1' ],
				admin_url( 'options-general.php' )
			)
		);
		exit;
	}
}
