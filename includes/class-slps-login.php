<?php
declare(strict_types=1);

namespace SLPS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Login {

	public function __construct() {
		add_action( 'login_enqueue_scripts', [ $this, 'inject_styles' ] );
		add_filter( 'login_headerurl',       [ $this, 'logo_url' ] );
		add_filter( 'login_headertext',      [ $this, 'logo_title' ] );
		add_filter( 'login_title',           [ $this, 'login_title' ] );
		add_action( 'login_footer',          [ $this, 'footer_mods' ] );
	}

	public function inject_styles(): void {
		$opts = Options::get();
		$css  = $this->build_css( $opts );
		if ( '' === $css ) {
			return;
		}
		wp_register_style( 'slps-login', false, [], SLPS_VERSION );
		wp_enqueue_style( 'slps-login' );
		wp_add_inline_style( 'slps-login', $css );
	}

	private function build_css( array $opts ): string {
		$rules = [];

		// Background.
		$body = [];
		if ( ! empty( $opts['bg_color'] ) && $opts['bg_color'] !== Options::WP_DEFAULTS['bg_color'] ) {
			$body[] = 'background-color:' . sanitize_hex_color( $opts['bg_color'] ) . ';';
		}
		if ( ! empty( $opts['bg_image_url'] ) ) {
			$body[] = 'background-image:url("' . esc_url( $opts['bg_image_url'] ) . '");';
			$body[] = 'background-size:' . esc_attr( $opts['bg_size'] ) . ';';
			$body[] = 'background-repeat:' . esc_attr( $opts['bg_repeat'] ) . ';';
			$body[] = 'background-position:center center;';
		}
		if ( ! empty( $body ) ) {
			$rules[] = 'body.login{' . implode( '', $body ) . '}';
		}

		// Logo image and width.
		$logo = [];
		if ( ! empty( $opts['logo_url'] ) ) {
			$w      = (int) $opts['logo_width'];
			$logo[] = 'background-image:url("' . esc_url( $opts['logo_url'] ) . '");';
			$logo[] = 'background-size:contain;';
			$logo[] = 'background-repeat:no-repeat;';
			$logo[] = 'background-position:center bottom;';
			$logo[] = 'width:' . $w . 'px;';
			$logo[] = 'height:' . (int) $opts['logo_height'] . 'px;';
		} elseif ( (int) $opts['logo_width'] !== Options::WP_DEFAULTS['logo_width'] || (int) $opts['logo_height'] !== Options::WP_DEFAULTS['logo_height'] ) {
			$w      = (int) $opts['logo_width'];
			$logo[] = 'width:' . $w . 'px;';
			$logo[] = 'height:' . (int) $opts['logo_height'] . 'px;';
		}
		if ( ! empty( $logo ) ) {
			$rules[] = 'body.login h1 a{' . implode( '', $logo ) . '}';
		}

		// Labels.
		if ( ! empty( $opts['label_color'] ) ) {
			$rules[] = 'body.login label{color:' . sanitize_hex_color( $opts['label_color'] ) . ';}';
		}

		// Login form panel.
		$form     = [];
		$form_has = false;
		if ( ! empty( $opts['panel_bg_color'] ) && $opts['panel_bg_color'] !== Options::WP_DEFAULTS['panel_bg_color'] ) {
			$form[]   = 'background:' . sanitize_hex_color( $opts['panel_bg_color'] ) . ';';
			$form_has = true;
		}
		if ( (int) $opts['panel_border_radius'] !== Options::WP_DEFAULTS['panel_border_radius'] ) {
			$form[]   = 'border-radius:' . (int) $opts['panel_border_radius'] . 'px;';
			$form_has = true;
		}
		if ( empty( $opts['panel_border'] ) ) {
			$form[]   = 'border:none;';
			$form_has = true;
		}
		if ( empty( $opts['panel_box_shadow'] ) ) {
			$form[]   = 'box-shadow:none;';
			$form_has = true;
		}
		if ( $form_has ) {
			$decl    = implode( '', $form );
			$rules[] = 'body.login #loginform,' . "\n" . 'body.login #lostpasswordform{' . $decl . '}';
		}

		// Buttons.
		$btn     = [];
		$btn_has = false;
		if ( ! empty( $opts['btn_bg_color'] ) && $opts['btn_bg_color'] !== Options::WP_DEFAULTS['btn_bg_color'] ) {
			$btn[]   = 'background:' . sanitize_hex_color( $opts['btn_bg_color'] ) . ';';
			$btn[]   = 'border-color:' . sanitize_hex_color( $opts['btn_bg_color'] ) . ';';
			$btn_has = true;
		}
		if ( ! empty( $opts['btn_text_color'] ) && $opts['btn_text_color'] !== Options::WP_DEFAULTS['btn_text_color'] ) {
			$btn[]   = 'color:' . sanitize_hex_color( $opts['btn_text_color'] ) . ';';
			$btn_has = true;
		}
		if ( (int) $opts['btn_border_radius'] !== Options::WP_DEFAULTS['btn_border_radius'] ) {
			$btn[]   = 'border-radius:' . (int) $opts['btn_border_radius'] . 'px;';
			$btn_has = true;
		}
		if ( $btn_has ) {
			$decl     = implode( '', $btn );
			$selector = 'body.login .button-primary';
			$rules[]  = $selector . '{' . $decl . '}';
			$rules[]  = $selector . ':hover,' . "\n" . $selector . ':focus,' . "\n" . $selector . ':active{' . $decl . '}';
		}

		// Hide links.
		if ( ! empty( $opts['hide_back_link'] ) ) {
			$rules[] = 'body.login #backtoblog{display:none;}';
		}
		if ( ! empty( $opts['hide_lost_password'] ) ) {
			$rules[] = 'body.login #nav{display:none;}';
		}

		return implode( "\n", $rules );
	}

	public function logo_url( string $url ): string {
		$opts = Options::get();
		if ( ! empty( $opts['logo_link_url'] ) ) {
			return esc_url( $opts['logo_link_url'] );
		}
		return home_url( '/' );
	}

	public function logo_title( string $title ): string {
		return esc_attr( get_bloginfo( 'name' ) );
	}

	public function login_title( string $title ): string {
		$opts = Options::get();
		if ( ! empty( $opts['login_title'] ) ) {
			return sanitize_text_field( $opts['login_title'] );
		}
		return $title;
	}

	public function footer_mods(): void {
		$opts  = Options::get();
		if ( ! empty( $opts['footer_text'] ) ) {
			$color = ! empty( $opts['footer_text_color'] )
				? sanitize_hex_color( $opts['footer_text_color'] )
				: '#50575e';
			echo '<p class="slps-footer-text" style="text-align:center;color:' . esc_attr( $color ) . ';margin-top:1em;">'
				. wp_kses_post( $opts['footer_text'] )
				. '</p>';
		}
	}
}
