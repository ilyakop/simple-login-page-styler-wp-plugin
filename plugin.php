<?php

/**
 * Plugin Name: Simple Login Page Styler
 * Plugin URI: http://plugins.topdevs.net/simple-like-page-plugin
 * Description: Customize the login page of your WordPress site with logo, background color, and rounded form option.
 * Version: 1.0
 * Author: Illia Kopturov
 * Author URI: http://illia.online
 * License: GPLv2 or later
 */

namespace Simple_Login_Page_Styler;

if (!defined('ABSPATH')) {
    exit;
}

class SLPS_Main
{
    const DEFAULT_OPTIONS = array(
        'logo_upload'   => '',
        'bg_color'      => '',
        'rounded_form'  => false,
    );

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        add_action('login_enqueue_scripts', array($this, 'customize_login_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    public function add_plugin_page()
    {
        add_options_page(
            esc_html(__('Simple Login Page Styler', 'simple-login-page-styler')),
            esc_html(__('Login Page Styler', 'simple-login-page-styler')),
            'manage_options',
            'slps-settings',
            array($this, 'create_admin_page')
        );
    }

    public function create_admin_page()
    {
?>
        <div class="wrap">
            <h2><?php esc_html_e('Simple Login Page Styler Settings', 'simple-login-page-styler'); ?></h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('slps_option_group');
                do_settings_sections('slps-settings');
                submit_button();
                ?>
            </form>
        </div>
    <?php
    }

    public function page_init()
    {
        register_setting(
            'slps_option_group',
            'slps_options',
            array($this, 'sanitize')
        );

        add_settings_section(
            'slps_setting_section',
            esc_html(__('Customize Login Page', 'simple-login-page-styler')),
            array($this, 'print_section_info'),
            'slps-settings'
        );

        add_settings_field(
            'logo_upload',
            esc_html(__('Upload Logo', 'simple-login-page-styler')),
            array($this, 'logo_upload_callback'),
            'slps-settings',
            'slps_setting_section'
        );

        add_settings_field(
            'bg_color',
            esc_html(__('Background Color', 'simple-login-page-styler')),
            array($this, 'bg_color_callback'),
            'slps-settings',
            'slps_setting_section'
        );

        add_settings_field(
            'rounded_form',
            esc_html(__('Rounded Form', 'simple-login-page-styler')),
            array($this, 'rounded_form_callback'),
            'slps-settings',
            'slps_setting_section'
        );
    }

    public function sanitize($input)
    {
        $sanitized_input = wp_parse_args($input, self::DEFAULT_OPTIONS);

        // Sanitize individual fields if needed
        $sanitized_input['logo_upload'] = sanitize_text_field($sanitized_input['logo_upload']);
        $sanitized_input['bg_color']    = sanitize_hex_color($sanitized_input['bg_color']);
        $sanitized_input['rounded_form'] = (bool) $sanitized_input['rounded_form'];

        return $sanitized_input;
    }

    public function print_section_info()
    {
        esc_html_e('Enter your customization preferences below:', 'simple-login-page-styler');
    }

    public function logo_upload_callback()
    {
        $options = get_option('slps_options', self::DEFAULT_OPTIONS);
    ?>
        <input type="text" name="slps_options[logo_upload]" id="logo_upload" value="<?php echo esc_attr($options['logo_upload']); ?>" />
        <input type="button" class="button button-secondary" id="upload_logo_button" value="<?php esc_html_e('Upload Logo', 'simple-login-page-styler'); ?>" />
        <p class="description"><?php esc_html_e('Upload your logo for the login page.', 'simple-login-page-styler'); ?></p>
        <script>
            jQuery(document).ready(function($) {
                $('#upload_logo_button').click(function() {
                    var mediaUploader;
                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }
                    mediaUploader = wp.media.frames.file_frame = wp.media({
                        title: '<?php esc_html_e('Choose Logo', 'simple-login-page-styler'); ?>',
                        button: {
                            text: '<?php esc_html_e('Choose Logo', 'simple-login-page-styler'); ?>'
                        },
                        multiple: false
                    });
                    mediaUploader.on('select', function() {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();
                        $('#logo_upload').val(attachment.url);
                    });
                    mediaUploader.open();
                });
            });
        </script>
    <?php
    }

    public function bg_color_callback()
    {
        $options = get_option('slps_options', self::DEFAULT_OPTIONS);
    ?>
        <input type="text" name="slps_options[bg_color]" id="bg_color" value="<?php echo esc_attr($options['bg_color']); ?>" class="color-picker" />
        <p class="description"><?php esc_html_e('Choose the background color for the login page.', 'simple-login-page-styler'); ?></p>
        <script>
            jQuery(document).ready(function($) {
                $('.color-picker').wpColorPicker();
            });
        </script>
    <?php
    }

    public function rounded_form_callback()
    {
        $options = get_option('slps_options', self::DEFAULT_OPTIONS);
    ?>
        <label for="rounded_form">
            <input type="checkbox" id="rounded_form" name="slps_options[rounded_form]" <?php checked($options['rounded_form']); ?> />
            <?php esc_html_e('Enable Rounded Form', 'simple-login-page-styler'); ?>
        </label>
        <p class="description"><?php esc_html_e('Check this box to enable a 1em border radius for the form and remove border width.', 'simple-login-page-styler'); ?></p>
<?php
    }

    public function customize_login_page()
    {
        $options = get_option('slps_options', self::DEFAULT_OPTIONS);

        // Customize login page with user preferences
        if (!empty($options['logo_upload'])) {
            echo '<style type="text/css">';
            echo 'body.login h1 a { background-image: url("' . esc_url($options['logo_upload']) . '") !important; }';
            echo '</style>';
        }

        if (!empty($options['bg_color'])) {
            echo '<style type="text/css">';
            echo 'body.login { background-color: ' . sanitize_hex_color($options['bg_color']) . ' !important; }';
            echo '</style>';
        }

        if ($options['rounded_form']) {
            echo '<style type="text/css">';
            echo 'body.login form { border-radius: 1em; border-width: 0 !important; }';
            echo '</style>';
        }
    }

    public function enqueue_admin_scripts()
    {
        wp_enqueue_media();
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }
}

// Instantiate the class
$slps_main_instance = new SLPS_Main();
