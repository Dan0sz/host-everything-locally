=== HELL | Host Everything LocaL ===
Contributors: DaanvandenBergh
Tags: head, scripts, style, host, local
Requires at least: 5.3
Tested up to: 5.4
Requires PHP: 7.0
Stable tag: 1.3.1
License: CC-BY-4.0
License URI: https://creativecommons.org/licenses/by/4.0/

The Swiss Army knife for WordPress' `<head>`. Speed up WordPress so much it hurts!

== Description ==

Put WordPress' `<head>` in a vice and squeeze out every last bit of performance.

Was this visual gruesome enough for you? Because this is exactly what this plugin does to WordPress.

With HELL for WordPress you can **remove** any script and/or style loaded by any theme or plugin from its `<head>` and (optionally) **replace** it with a local copy if it's hosted on another domain. Besides that you can increase performance for all other resources by using `dns-prefetch`, `preconnect` and `preload`.

= Features =

* **Remove** scripts/styles from the `<head>` by either filename or handle,
* Automatically **download** externally hosted scripts/styles and **replace** them with a local copy,
* Add DNS-prefetch or Preconnect headers,
* Add Preload headers for any resource.

= Disclaimer =

HELL for WordPress can break the functioning of your theme and plugins. Handle with care. If you don't
know what you're doing, please contact your webdeveloper or [hire me](https://woosh.dev/wordpress-services/omgf-expert-configuration/).

== Frequently Asked Questions ==

= I don't know what I'm doing. Can you help? =

Due to the complex nature of this plugin, I'm not offering help with configuration for free. Instead I'm offering a [full configuration service](https://woosh.dev/wordpress-services/hell-expert-configuration/). Of course, a bug report or suggestions to improve its usability can be issued in the Support Forum!

== Screenshots ==

1. Auto-detection completed.
2. Download successful.
3. Remove scripts/styles example.

== Changelog ==

= 1.3.1 =
* Tested with WP 5.4

= 1.3.0 =
* Added a tabbed navigation.
* Several code improvements.

= 1.2.1 =
* Fixed bug where empty settings would still render a line in the source code.

= 1.2.0 =
* Added Preconnect/DNS-prefetch feature.
* Added Preload feature.

= 1.1.3 =
* Fix broken link.

= 1.1.2 =
* Minor modifications in Disclaimer.

= 1.1.1 =
* Use `wp_remote_get()` instead of cURL.

= 1.0 =
* First release
