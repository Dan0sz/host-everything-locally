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

class HELL
{
    const WP_HELL_DEFAULT_REMOVE     = [
        1 => [
            'type'      => 'style',
            'attribute' => 'src',
            'handle'    => ''
        ]
    ];
    const WP_HELL_DEFAULT_PRECONNECT = [
        1 => [
            'type' => 'dns-prefetch',
            'url' => ''
        ]
    ];
    const WP_HELL_DEFAULT_PRELOAD    = [
        1 => [
            'as'   => 'font',
            'href' => '',
            'type' => ''
        ]
    ];

    /**
     * HELL constructor.
     */
    public function __construct()
    {
        $this->define_constants();

        if(is_admin()) {
            $this->do_admin();
        }

        if(!is_admin()) {
            $this->do_frontend();
        }
    }

    /**
     * Define constants for use later on.
     */
    private function define_constants()
    {
        $remove     = get_option(HELL_Admin_Settings::WP_HELL_SETTING_REMOVE);
        $preconnect = get_option(HELL_Admin_Settings::WP_HELL_SETTING_PRECONNECT);
        $preload    = get_option(HELL_Admin_Settings::WP_HELL_SETTING_PRELOAD);

        define('WP_HELL_SITE_URL', 'https://daan.dev/');
        define('WP_HELL_GENERAL_OPTIMIZE_ADMIN_USERS', get_option(HELL_Admin_Settings::WP_HELL_SETTING_GENERAL_OPTIMIZE_ADMIN_USERS));
        define('WP_HELL_REMOVE', is_array($remove) ? $remove : self::WP_HELL_DEFAULT_REMOVE);
        define('WP_HELL_DOWNLOAD', get_option(HELL_Admin_Settings::WP_HELL_SETTING_DOWNLOAD));
        define('WP_HELL_AUTO_DETECT_ENABLED', get_option(HELL_Admin_Settings::WP_HELL_SETTING_DOWNLOAD_AUTO_DETECT_ENABLED));
        define('WP_HELL_PRECONNECT', is_array($preconnect) ? $preconnect : self::WP_HELL_DEFAULT_PRECONNECT);
        define('WP_HELL_PRELOAD', is_array($preload) ? $preload : self::WP_HELL_DEFAULT_PRELOAD);
        define('WP_HELL_CACHE_DIR', 'cache/local/');
    }

    /**
     * @return HELL_Admin
     */
    private function do_admin()
    {
        return new HELL_Admin();
    }

    /**
     * @return HELL_Frontend
     */
    private function do_frontend()
    {
        return new HELL_Frontend();
    }
}
