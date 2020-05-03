<?php
/* * * * * * * * * * * * * * * * * * *
 *
 *     ██░ ██ ▓█████  ██▓     ██▓
 *    ▓██░ ██▒▓█   ▀ ▓██▒    ▓██▒
 *    ▒██▀▀██░▒███   ▒██░    ▒██░
 *    ░▓█ ░██ ▒▓█  ▄ ▒██░    ▒██░
 *    ░▓█▒░██▓░▒████▒░██████▒░██████▒
 *     ▒ ░░▒░▒░░ ▒░ ░░ ▒░▓  ░░ ▒░▓  ░
 *     ▒ ░▒░ ░ ░ ░  ░░ ░ ▒  ░░ ░ ▒  ░
 *     ░  ░░ ░   ░     ░ ░     ░ ░
 *     ░  ░  ░   ░  ░    ░  ░    ░  ░
 *
 * * * * * * * * * * * * * * * * * * */

defined('ABSPATH') || exit;

class HELL_Frontend
{
    /**
     * HELL_Frontend constructor.
     */
    public function __construct()
    {
        if (!WP_HELL_GENERAL_OPTIMIZE_ADMIN_USERS && current_user_can('edit_pages')) {
            return;
        }

        if (get_option(HELL_Admin_Settings::WP_HELL_SETTING_REMOVE)) {
            $this->do_remove();
        }

        add_action('wp_print_styles', array($this, 'maybe_preconnect'), 1);
        add_action('wp_print_styles', array($this, 'maybe_preload'), 2);
        add_action('wp_print_styles', array($this, 'is_auto_detect_enabled'), 111);
        add_action('wp_print_styles', array($this, 'maybe_load_local_scripts'), 222);
    }

    /**
     * Check if Preconnect is set.
     */
    public function maybe_preconnect()
    {
        if ($items = get_option(HELL_Admin_Settings::WP_HELL_SETTING_PRECONNECT)) {
            $this->do_preconnect($items);
        }
    }

    /**
     * Check if Preload is set.
     */
    public function maybe_preload()
    {
        if ($items = get_option(HELL_Admin_Settings::WP_HELL_SETTING_PRELOAD)) {
            $this->do_preload($items);
        }
    }

    /**
     * Check if Auto Detect is enabled. If so, do Auto Detect.
     */
    public function is_auto_detect_enabled()
    {
        if (WP_HELL_AUTO_DETECT_ENABLED) {
            add_action('wp_print_styles', array($this, 'do_auto_detect'), 333);
        }
    }

    /**
     * Maybe load local scripts.
     */
    public function maybe_load_local_scripts()
    {
        if (WP_HELL_DOWNLOAD) {
            add_action('wp_print_styles', array($this, 'do_replace'), 666);
        }
    }

    /**
     * @return HELL_Frontend_AutoDetect
     */
    public function do_auto_detect()
    {
        return new HELL_Frontend_AutoDetect();
    }

    /**
     * @return HELL_Frontend_Remove
     */
    public function do_remove()
    {
        return new HELL_Frontend_Remove();
    }

    /**
     * @return HELL_Frontend_Preconnect
     */
    public function do_preconnect($items)
    {
        return new HELL_Frontend_Preconnect($items);
    }

    /**
     * @param $items
     *
     * @return HELL_Frontend_Preload
     */
    public function do_preload($items)
    {
        return new HELL_Frontend_Preload($items);
    }

    /**
     * @return HELL_Frontend_Replace
     */
    public function do_replace()
    {
        return new HELL_Frontend_Replace();
    }
}
