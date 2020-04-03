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

class HELL_Frontend_AutoDetect
{
    /** @var array $collection */
    private $collection = [];

    /** @var array $styles */
    private $styles;

    /** @var array $scripts */
    private $scripts;

    /**
     * HELL_Frontend_AutoDetect constructor.
     */
    public function __construct()
    {
        global $wp_styles, $wp_scripts;
        $this->styles  = $this->filter($wp_styles->registered, 'style');
        $this->scripts = $this->filter($wp_scripts->registered, 'script');

        $this->collection = (array) $this->styles + (array) $this->scripts;

        if (!empty($this->collection)) {
            $preserved = get_option(HELL_Admin_Settings::WP_HELL_SETTING_DOWNLOAD) ?: [];

            update_option(HELL_Admin_Settings::WP_HELL_SETTING_DOWNLOAD, $this->collection + $preserved);
        }

        HELL_Admin_Notice::set_notice(__('Auto-detection completed. Tailor the list to suit your needs and click \'download\'.'), 'info');

        update_option(HELL_Admin_Settings::WP_HELL_SETTING_DOWNLOAD_AUTO_DETECT_ENABLED, false);
    }

    /**
     * Filters out anything that is already hosted locally, WordPress-core, empty values and
     * Google Fonts, because for that you need OMGF.
     *
     * @param $items
     *
     * @return array
     */
    private function filter($items, $type)
    {
        $items = array_filter(
            $items,
            function($properties) {
                return strpos($properties->src, '/wp-admin') === false
                    && strpos($properties->src, '/wp-includes') === false
                    && strpos($properties->src, $_SERVER['HTTP_HOST']) === false
                    && strpos($properties->src, 'scriptaculous') === false
                    && strpos($properties->src, 'prototype') === false
                    && strpos($properties->src, 'fonts.googleapis.com') === false
                    && strpos($properties->src, 'fonts.gstatic.com') === false
                    && $properties->src !== false
                    && $properties->src !== true;
            }
        );

        foreach ($items as &$item) {
            $item = (array) $item;
            $item['file'] = basename($item['src']);
            $item['type'] = $type;
        }

        return $items;
    }
}
