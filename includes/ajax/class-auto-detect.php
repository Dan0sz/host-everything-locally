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

class HELL_AJAX_AutoDetect
{
    /** @var bool */
    private $auto_detect;

    /**
     * Check if Auto Detect is already enabled and if not, enable it.
     *
     * HELL_AJAX_AutoDetect constructor.
     */
    public function __construct()
    {
        $this->auto_detect = get_option(HELL_Admin_Settings::WP_HELL_SETTING_DOWNLOAD_AUTO_DETECT_ENABLED);

        if (!$this->auto_detect) {
            $this->enable_auto_detect();
        }

        $url = get_permalink(get_posts()[0]->ID);

        HELL_Admin_Notice::set_notice(sprintf(__('Auto-detect is already enabled. Open %sany page%s, wait for it to load and %srefresh%s this page.', 'host-everything-local'), "<a href='$url' target='_blank'>",'</a>', '<a href="javascript:location.reload();">', '</a>'), 'info');
        wp_send_json_success(__('Auto-detect already enabled.', 'host-everything-local'));
    }

    /**
     * Set the toggle.
     */
    private function enable_auto_detect()
    {
        update_option(HELL_Admin_Settings::WP_HELL_SETTING_DOWNLOAD_AUTO_DETECT_ENABLED, 1);

        $url = get_permalink(get_posts()[0]->ID);

        HELL_Admin_Notice::set_notice(sprintf(__('Auto-detect enabled. Open %sany page%s, wait for it to load and %srefresh%s this page.', 'host-everything-local'), "<a href='$url' target='_blank'>", '</a>', '<a href="javascript:location.reload();">', '</a>'));

        wp_send_json_success(__('Auto-detect enabled.', 'host-everything-local'));
    }
}
