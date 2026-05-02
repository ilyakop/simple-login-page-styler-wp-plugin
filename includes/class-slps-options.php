<?php
declare(strict_types=1);

namespace SLPS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Options {

	const OPTION_KEY = 'slps_options';

	const DEFAULTS = [
		'logo_url'            => '',
		'logo_width'          => 200,
		'logo_height'         => 200,
		'logo_link_url'       => '',
		'bg_color'            => '',
		'bg_image_url'        => '',
		'bg_size'             => 'cover',
		'bg_repeat'           => 'no-repeat',
		'label_color'         => '',
		'panel_bg_color'      => '',
		'panel_border_radius' => 4,
		'panel_border'        => 1,
		'panel_box_shadow'    => 1,
		'btn_bg_color'        => '',
		'btn_text_color'      => '',
		'btn_border_radius'   => 3,
		'login_title'         => '',
		'hide_back_link'      => 0,
		'hide_lost_password'  => 0,
		'footer_text'         => '',
		'footer_text_color'   => '',
	];

	// WordPress built-in defaults — skip CSS injection when value matches these.
	const WP_DEFAULTS = [
		'bg_color'            => '#f0f0f1',
		'panel_bg_color'      => '#ffffff',
		'panel_border_radius' => 4,
		'panel_box_shadow'    => 1,
		'btn_bg_color'        => '#2271b1',
		'btn_text_color'      => '#ffffff',
		'btn_border_radius'   => 3,
		'logo_width'          => 200,
		'logo_height'         => 200,
	];

	public static function get(): array {
		return wp_parse_args( get_option( self::OPTION_KEY, [] ), self::DEFAULTS );
	}

	public static function sanitize( array $input ): array {
		$clean = self::DEFAULTS;

		$clean['logo_url']            = isset( $input['logo_url'] ) ? esc_url_raw( $input['logo_url'] ) : '';
		$clean['logo_width']          = isset( $input['logo_width'] ) ? max( 60, min( 400, (int) $input['logo_width'] ) ) : 200;
		$clean['logo_height']         = isset( $input['logo_height'] ) ? max( 20, min( 400, (int) $input['logo_height'] ) ) : 200;
		$clean['logo_link_url']       = isset( $input['logo_link_url'] ) ? esc_url_raw( $input['logo_link_url'] ) : '';
		$clean['bg_color']            = isset( $input['bg_color'] ) ? ( sanitize_hex_color( $input['bg_color'] ) ?? '' ) : '';
		$clean['bg_image_url']        = isset( $input['bg_image_url'] ) ? esc_url_raw( $input['bg_image_url'] ) : '';
		$clean['bg_size']             = in_array( $input['bg_size'] ?? '', [ 'cover', 'contain', 'auto' ], true ) ? $input['bg_size'] : 'cover';
		$clean['bg_repeat']           = in_array( $input['bg_repeat'] ?? '', [ 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' ], true ) ? $input['bg_repeat'] : 'no-repeat';
		$clean['panel_bg_color']      = isset( $input['panel_bg_color'] ) ? ( sanitize_hex_color( $input['panel_bg_color'] ) ?? '' ) : '';
		$clean['panel_border_radius'] = isset( $input['panel_border_radius'] ) ? max( 0, min( 20, (int) $input['panel_border_radius'] ) ) : 4;
		$clean['label_color']         = isset( $input['label_color'] ) ? ( sanitize_hex_color( $input['label_color'] ) ?? '' ) : '';
		$clean['panel_border']        = empty( $input['panel_border'] ) ? 0 : 1;
		$clean['panel_box_shadow']    = empty( $input['panel_box_shadow'] ) ? 0 : 1;
		$clean['btn_bg_color']        = isset( $input['btn_bg_color'] ) ? ( sanitize_hex_color( $input['btn_bg_color'] ) ?? '' ) : '';
		$clean['btn_text_color']      = isset( $input['btn_text_color'] ) ? ( sanitize_hex_color( $input['btn_text_color'] ) ?? '' ) : '';
		$clean['btn_border_radius']   = isset( $input['btn_border_radius'] ) ? max( 0, min( 20, (int) $input['btn_border_radius'] ) ) : 3;
		$clean['login_title']         = isset( $input['login_title'] ) ? sanitize_text_field( $input['login_title'] ) : '';
		$clean['hide_back_link']      = empty( $input['hide_back_link'] ) ? 0 : 1;
		$clean['hide_lost_password']  = empty( $input['hide_lost_password'] ) ? 0 : 1;
		$clean['footer_text']         = isset( $input['footer_text'] ) ? wp_kses_post( $input['footer_text'] ) : '';
		$clean['footer_text_color']   = isset( $input['footer_text_color'] ) ? ( sanitize_hex_color( $input['footer_text_color'] ) ?? '' ) : '';

		return $clean;
	}
}
