=== Simple Login Styler – Custom Branding for Your WordPress Login ===

Contributors: topdevs
Tags: login, custom login, login page, branding, white label
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 1.1
Requires PHP: 7.2
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Replace the default WordPress login page with your own logo, colors, and text. Lightweight, no-bloat login branding for any WordPress site.

== Description ==

WordPress login pages all look the same — the WordPress logo, the default blue, the generic title. If you care about how your site looks, this is the last unbranded page.

Simple Login Styler replaces it. Upload your logo, set your colors, customize the title and links — all through a standard WordPress settings page. No core file editing, no render-blocking scripts, no bloat.

**How it works:** The plugin uses WordPress login page hooks to inject a single, minimal CSS block. Settings are stored in the database and applied at login page load time. Nothing touches `wp-login.php` directly. CSS is only injected for settings that actually differ from the WordPress default, keeping output lean.

= Features =

**Logo**

* Upload a custom logo using the WordPress Media Library
* Control logo width (60–400px)
* Set a custom logo link URL (defaults to the site home URL)

**Background**

* Background color picker
* Background image upload (Media Library)
* Background size control: Cover / Contain / Auto (shown only when a background image is set)

**Login Form Panel**

* Panel background color
* Border radius (0–20px)
* Box shadow: on or off

**Buttons**

* Primary button background color
* Primary button text color
* Button border radius (0–20px)

**Text & Links**

* Custom page `<title>` tag (replaces the default "Log In ‹ Site Name — WordPress")
* Show or hide the "Back to [Site Name]" link
* Show or hide the "Lost your password?" link
* Custom footer text displayed below the login form

All fields are optional. If a field is left blank or at its default, that part of the login page looks exactly like stock WordPress.

= Works Great With =

**UnclutterWP** — Once you've branded your login page, UnclutterWP helps you clean up the rest of the site: remove emoji scripts, disable XML-RPC, clean your WordPress `<head>`, and more — the same "remove what you didn't ask for" philosophy applied to your whole site.

[Get UnclutterWP — free](https://wordpress.org/plugins/unclutterwp/)

Built by the team behind UnclutterWP.

== Installation ==

1. Download the plugin ZIP file.
2. Go to Plugins → Add New → Upload Plugin.
3. Select the ZIP file and click Install Now.
4. Activate the plugin.
5. Go to Settings → Login Page Styler to customize.

== Frequently Asked Questions ==

= Does this edit wp-login.php? =

No. Simple Login Styler uses WordPress login page hooks exclusively (`login_enqueue_scripts`, `login_headerurl`, `login_headertext`, `login_title`, `login_footer`). No core files are touched.

= Will plugin updates reset my customizations? =

No. All settings are stored in the WordPress database under the `slps_options` option key. Plugin updates do not affect your saved settings.

= Does this affect the WordPress admin area? =

No. Changes apply only to `wp-login.php`. The WordPress admin dashboard is not affected.

= Is it compatible with WooCommerce or BuddyPress login pages? =

Simple Login Styler targets the default `wp-login.php` page. WooCommerce, BuddyPress, and other plugins that render their own login pages using custom templates may not be affected.

== Screenshots ==

1. Settings page — Logo, Background, Form, Button, and Text options
2. Customized WordPress login page

== Changelog ==

= 1.1 =
* Rebuilt: Complete rebuild with a full feature set
* Added: Logo upload with width and link URL controls
* Added: Background color and background image upload
* Added: Form panel color, border radius, and box shadow controls
* Added: Button background color, text color, and border radius
* Added: Custom page title, link visibility toggles, and footer text
* Added: UnclutterWP companion plugin integration
* Changed: Proper multi-file structure with includes/admin separation
* Changed: CSS-only approach — no jQuery dependency on the login page

= 1.0 =
* Initial release
