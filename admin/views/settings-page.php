<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}
?>
<div class="wrap slps-admin-page">

	<?php if ( isset( $_GET['slps-reset'] ) && '1' === $_GET['slps-reset'] ) : ?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Settings have been reset to defaults.', 'simple-login-page-styler' ); ?></p>
		</div>
	<?php endif; ?>

	<h1>
		<?php esc_html_e( 'Simple Login Styler', 'simple-login-page-styler' ); ?>
		<a href="<?php echo esc_url( wp_login_url() ); ?>" target="_blank" class="page-title-action">
			<?php esc_html_e( 'Preview login page &rarr;', 'simple-login-page-styler' ); ?>
		</a>
	</h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'slps_option_group' ); ?>

		<!-- Logo -->
		<div class="slps-settings-section slps-settings-section--logo">
			<h2 class="slps-section-title">
				<span class="dashicons dashicons-format-image" aria-hidden="true"></span>
				<span><?php esc_html_e( 'Logo', 'simple-login-page-styler' ); ?></span>
			</h2>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="slps-logo-url"><?php esc_html_e( 'Custom Logo', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<input type="text" id="slps-logo-url" name="slps_options[logo_url]" value="<?php echo esc_attr( $opts['logo_url'] ); ?>" class="regular-text" />
						<button type="button" id="slps-logo-upload-btn" class="button"><?php esc_html_e( 'Select Image', 'simple-login-page-styler' ); ?></button>
						<a href="#" id="slps-logo-remove" class="slps-remove-link"<?php echo empty( $opts['logo_url'] ) ? ' style="display:none"' : ''; ?>><?php esc_html_e( 'Remove', 'simple-login-page-styler' ); ?></a>
						<br><img id="slps-logo-preview" src="<?php echo esc_url( $opts['logo_url'] ); ?>" alt="" class="slps-image-preview"<?php echo empty( $opts['logo_url'] ) ? ' style="display:none"' : ''; ?> />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-logo-width"><?php esc_html_e( 'Logo Width (px)', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<input type="number" id="slps-logo-width" name="slps_options[logo_width]" value="<?php echo esc_attr( (string) $opts['logo_width'] ); ?>" min="60" max="400" class="small-text" />
						<p class="description"><?php esc_html_e( 'Range: 60-400px. Default: 200.', 'simple-login-page-styler' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-logo-height"><?php esc_html_e( 'Logo Height (px)', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<input type="number" id="slps-logo-height" name="slps_options[logo_height]" value="<?php echo esc_attr( (string) $opts['logo_height'] ); ?>" min="20" max="400" class="small-text" />
						<p class="description"><?php esc_html_e( 'Range: 20-400px. Default: 200.', 'simple-login-page-styler' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-logo-link-url"><?php esc_html_e( 'Logo Link URL', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<input type="url" id="slps-logo-link-url" name="slps_options[logo_link_url]" value="<?php echo esc_attr( $opts['logo_link_url'] ); ?>" class="regular-text" placeholder="<?php echo esc_attr( home_url( '/' ) ); ?>" />
						<p class="description"><?php esc_html_e( 'Leave blank to use the site home URL.', 'simple-login-page-styler' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Background -->
		<div class="slps-settings-section slps-settings-section--background">
			<h2 class="slps-section-title">
				<span class="dashicons dashicons-art" aria-hidden="true"></span>
				<span><?php esc_html_e( 'Background', 'simple-login-page-styler' ); ?></span>
			</h2>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="slps-bg-color"><?php esc_html_e( 'Background Color', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<input type="text" id="slps-bg-color" name="slps_options[bg_color]" value="<?php echo esc_attr( $opts['bg_color'] ); ?>" class="slps-color-picker" data-default-color="#f0f0f1" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-bg-image-url"><?php esc_html_e( 'Background Image', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<input type="text" id="slps-bg-image-url" name="slps_options[bg_image_url]" value="<?php echo esc_attr( $opts['bg_image_url'] ); ?>" class="regular-text" />
						<button type="button" id="slps-bg-image-upload-btn" class="button"><?php esc_html_e( 'Select Image', 'simple-login-page-styler' ); ?></button>
						<a href="#" id="slps-bg-image-remove" class="slps-remove-link"<?php echo empty( $opts['bg_image_url'] ) ? ' style="display:none"' : ''; ?>><?php esc_html_e( 'Remove', 'simple-login-page-styler' ); ?></a>
						<br><img id="slps-bg-image-preview" src="<?php echo esc_url( $opts['bg_image_url'] ); ?>" alt="" class="slps-image-preview"<?php echo empty( $opts['bg_image_url'] ) ? ' style="display:none"' : ''; ?> />
					</td>
				</tr>
				<tr id="slps-bg-size-row"<?php echo empty( $opts['bg_image_url'] ) ? ' style="display:none"' : ''; ?>>
					<th scope="row"><label for="slps-bg-size"><?php esc_html_e( 'Background Size', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<select id="slps-bg-size" name="slps_options[bg_size]">
							<?php foreach ( array( 'cover' => __( 'Cover', 'simple-login-page-styler' ), 'contain' => __( 'Contain', 'simple-login-page-styler' ), 'auto' => __( 'Auto', 'simple-login-page-styler' ) ) as $val => $label ) : ?>
								<option value="<?php echo esc_attr( $val ); ?>"<?php selected( $opts['bg_size'], $val ); ?>><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr id="slps-bg-repeat-row"<?php echo empty( $opts['bg_image_url'] ) ? ' style="display:none"' : ''; ?>>
					<th scope="row"><label for="slps-bg-repeat"><?php esc_html_e( 'Background Repeat', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<select id="slps-bg-repeat" name="slps_options[bg_repeat]">
							<?php foreach ( array( 'no-repeat' => __( 'No Repeat', 'simple-login-page-styler' ), 'repeat' => __( 'Repeat', 'simple-login-page-styler' ), 'repeat-x' => __( 'Repeat Horizontally', 'simple-login-page-styler' ), 'repeat-y' => __( 'Repeat Vertically', 'simple-login-page-styler' ) ) as $val => $label ) : ?>
								<option value="<?php echo esc_attr( $val ); ?>"<?php selected( $opts['bg_repeat'], $val ); ?>><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
			</table>
		</div>

		<!-- Login Form -->
		<div class="slps-settings-section slps-settings-section--form">
			<h2 class="slps-section-title">
				<span class="dashicons dashicons-admin-appearance" aria-hidden="true"></span>
				<span><?php esc_html_e( 'Login Form', 'simple-login-page-styler' ); ?></span>
			</h2>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="slps-label-color"><?php esc_html_e( 'Label Color', 'simple-login-page-styler' ); ?></label></th>
					<td><input type="text" id="slps-label-color" name="slps_options[label_color]" value="<?php echo esc_attr( $opts['label_color'] ); ?>" class="slps-color-picker" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-panel-bg-color"><?php esc_html_e( 'Panel Background Color', 'simple-login-page-styler' ); ?></label></th>
					<td><input type="text" id="slps-panel-bg-color" name="slps_options[panel_bg_color]" value="<?php echo esc_attr( $opts['panel_bg_color'] ); ?>" class="slps-color-picker" data-default-color="#ffffff" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-panel-border-radius"><?php esc_html_e( 'Border Radius (px)', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<input type="number" id="slps-panel-border-radius" name="slps_options[panel_border_radius]" value="<?php echo esc_attr( (string) $opts['panel_border_radius'] ); ?>" min="0" max="20" class="small-text" />
						<p class="description"><?php esc_html_e( 'Range: 0-20px. Default: 4.', 'simple-login-page-styler' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Border', 'simple-login-page-styler' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="slps_options[panel_border]" value="1"<?php checked( $opts['panel_border'], 1 ); ?> />
							<?php esc_html_e( 'Show border around the form', 'simple-login-page-styler' ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Box Shadow', 'simple-login-page-styler' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="slps_options[panel_box_shadow]" value="1"<?php checked( $opts['panel_box_shadow'], 1 ); ?> />
							<?php esc_html_e( 'Show box shadow (matches WordPress default)', 'simple-login-page-styler' ); ?>
						</label>
					</td>
				</tr>
			</table>
		</div>

		<!-- Buttons -->
		<div class="slps-settings-section slps-settings-section--buttons">
			<h2 class="slps-section-title">
				<span class="dashicons dashicons-admin-customizer" aria-hidden="true"></span>
				<span><?php esc_html_e( 'Buttons', 'simple-login-page-styler' ); ?></span>
			</h2>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="slps-btn-bg-color"><?php esc_html_e( 'Button Background Color', 'simple-login-page-styler' ); ?></label></th>
					<td><input type="text" id="slps-btn-bg-color" name="slps_options[btn_bg_color]" value="<?php echo esc_attr( $opts['btn_bg_color'] ); ?>" class="slps-color-picker" data-default-color="#2271b1" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-btn-text-color"><?php esc_html_e( 'Button Text Color', 'simple-login-page-styler' ); ?></label></th>
					<td><input type="text" id="slps-btn-text-color" name="slps_options[btn_text_color]" value="<?php echo esc_attr( $opts['btn_text_color'] ); ?>" class="slps-color-picker" data-default-color="#ffffff" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-btn-border-radius"><?php esc_html_e( 'Button Border Radius (px)', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<input type="number" id="slps-btn-border-radius" name="slps_options[btn_border_radius]" value="<?php echo esc_attr( (string) $opts['btn_border_radius'] ); ?>" min="0" max="20" class="small-text" />
						<p class="description"><?php esc_html_e( 'Range: 0-20px. Default: 3.', 'simple-login-page-styler' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<!-- Text & Links -->
		<div class="slps-settings-section slps-settings-section--text">
			<h2 class="slps-section-title">
				<span class="dashicons dashicons-editor-textcolor" aria-hidden="true"></span>
				<span><?php esc_html_e( 'Text &amp; Links', 'simple-login-page-styler' ); ?></span>
			</h2>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="slps-login-title"><?php esc_html_e( 'Custom Page Title', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<input type="text" id="slps-login-title" name="slps_options[login_title]" value="<?php echo esc_attr( $opts['login_title'] ); ?>" class="regular-text" placeholder="Log In &lsaquo; Site Name &#8212; WordPress" />
						<p class="description"><?php esc_html_e( 'Leave blank to keep the WordPress default title.', 'simple-login-page-styler' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( '"Back to Site" Link', 'simple-login-page-styler' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="slps_options[hide_back_link]" value="1"<?php checked( $opts['hide_back_link'], 1 ); ?> />
							<?php esc_html_e( 'Hide the "Back to [Site Name]" link', 'simple-login-page-styler' ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( '"Lost your password?" Link', 'simple-login-page-styler' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="slps_options[hide_lost_password]" value="1"<?php checked( $opts['hide_lost_password'], 1 ); ?> />
							<?php esc_html_e( 'Hide the "Lost your password?" link', 'simple-login-page-styler' ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-footer-text"><?php esc_html_e( 'Footer Text', 'simple-login-page-styler' ); ?></label></th>
					<td>
						<textarea id="slps-footer-text" name="slps_options[footer_text]" rows="3" class="large-text"><?php echo wp_kses_post( $opts['footer_text'] ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Displayed below the login form. Leave blank to show nothing.', 'simple-login-page-styler' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="slps-footer-text-color"><?php esc_html_e( 'Footer Text Color', 'simple-login-page-styler' ); ?></label></th>
					<td><input type="text" id="slps-footer-text-color" name="slps_options[footer_text_color]" value="<?php echo esc_attr( $opts['footer_text_color'] ); ?>" class="slps-color-picker" data-default-color="#50575e" /></td>
				</tr>
			</table>
		</div>

		<?php submit_button(); ?>
	</form>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="slps-reset-form">
		<input type="hidden" name="action" value="slps_reset_defaults">
		<?php wp_nonce_field( 'slps_reset_defaults' ); ?>
		<?php submit_button( __( 'Reset to Defaults', 'simple-login-page-styler' ), 'secondary', 'slps-reset-btn', false ); ?>
	</form>

	<!-- Also From the Same Team -->
	<h2><?php esc_html_e( 'Also From the Same Team', 'simple-login-page-styler' ); ?></h2>
	<?php if ( is_plugin_active( 'unclutterwp/unclutterwp.php' ) ) : ?>
		<p>
			&#10003; <?php esc_html_e( 'UnclutterWP is active.', 'simple-login-page-styler' ); ?>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=unclt-settings-page' ) ); ?>">
				<?php esc_html_e( 'Go to UnclutterWP Settings', 'simple-login-page-styler' ); ?> &rarr;
			</a>
		</p>
	<?php else : ?>
		<div class="slps-promo-card">
			<p><?php echo wp_kses_post( __( '<b>WordPress ships with 11 things most sites don\'t need.</b> Emoji scripts. XML-RPC. REST API links. Shortlink tags. oEmbed discovery. RSD links. Windows Live Writer support. Feed links. Adjacent posts. Self-pings. The generator tag. <b>UnclutterWP</b> removes them with a single toggle each. No code, no child theme, no guesswork.', 'simple-login-page-styler' ) ); ?></p>
			<a href="https://wordpress.org/plugins/unclutterwp/" target="_blank" rel="noopener" class="button button-secondary">
				<?php esc_html_e( 'Clean it up &#8212; free', 'simple-login-page-styler' ); ?>
			</a>
		</div>
	<?php endif; ?>

</div>
