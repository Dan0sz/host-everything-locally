<?php
/**
 * @formatter:off
 * Plugin Name: HELL
 * Plugin URI: https://daan.dev/wordpress-plugins/hell/
 * Description: Speed up WordPress so much it hurts.
 * Version: 1.4.4
 * Author: Daan van den Bergh
 * Author URI: https://daan.dev
 * License: GPL2v2 or later
 * Text Domain: host-everything-local
 * @formatter:on
 */

defined('ABSPATH') || exit;

/**
 * Define Constants
 */
define('WP_HELL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_HELL_PLUGIN_FILE', __FILE__);
define('WP_HELL_PLUGIN_VERSION', '1.4.3');

/**
 * Takes care of loading classes on demand.
 *
 * @param $class
 *
 * @return mixed|void
 */
function wp_hell_autoload($class)
{
    $path = explode('_', $class);

    if ($path[0] != 'HELL') {
        return;
    }

    if (!class_exists('Woosh_Autoloader')) {
        require_once(WP_HELL_PLUGIN_DIR . 'woosh-autoload.php');
    }

    $autoload = new Woosh_Autoloader($class);

    return include WP_HELL_PLUGIN_DIR . 'includes/' . $autoload->load();
}

spl_autoload_register('wp_hell_autoload');

/**
* @return HELL
 */
function wp_hell_init()
{
    static $hell = null;

    if ($hell === null) {
        $hell = new HELL();
    }

    return $hell;
}

add_action('plugins_loaded', 'wp_hell_init');
