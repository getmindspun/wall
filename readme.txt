=== Wall ===
Plugin URI: https://www.mindspun.com
Contributors: mindspun, mattlaue
Donate link: https://www.mindspun.com.com/donate/
Tags: private, login, visibility
Requires at least: 5.7
Tested up to: 6.0.1
Requires PHP: 5.6
Stable Tag: 0.1.0
License: GNU Version 2 or Any Later Version
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Keep your site private.

== Description ==

Lightweight, easy-to-use plugin that allows your site to be visible only to logged-in users.
Great for when your site is still under construction.

= Features =
* Lightweight and easy-to-use with a single settings page.
* Fully-functional, no upsell for additional features.
* Themeable landing page or redirect to the login page.
* Use a custom X-Secret HTTP header to access your site contents programmatically.
* Professionally supported by [Mindspun](https://www.mindspun.com).

== Getting Started ==
All settings are on a single page named 'Wall' under the Settings menu of the WordPress dashboard.
Select the **Enabled** checkbox and click the 'Save Changes' button then a default landing page will be shown to
your users on any non-login page.

== Theming your landing page ==
The landing page will use your theme styles by default, but you can easily customize the page to anything you wish.

In your theme:
* Create a directory in your theme named **spn_templates**.
* Copy **wall-landing-page.php** from the 'templates' directory of this plugin (or create your own) into the 'spn_templates' directory of you theme.

The template gives you full control over all the contents of that page.

== Frequently Asked Questions ==

= What above support? =
We provide support both through the WordPress forum and the [github repository](https://github.com/getmindspun/wall).

= Why another private site plugin?
No other lightweight plugins allow programmatic access via a custom header.

= Does this plugin require paid add-ons that gate the real functionality like other plugins do?
No, this plugin is completely free with no paid add-ons.

== Screenshots ==
1. Settings page
2. Default template (using the Twenty-Twenty theme)

== Changelog ==

= 0.1.0 =
* Initial release.

== Upgrade Notice ==

= 0.1.0 =
* Initial release.
