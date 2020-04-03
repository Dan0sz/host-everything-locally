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

class HELL_AJAX
{
    /**
     * HELL_AJAX constructor.
     */
    public function __construct()
    {
        // @formatter:off
        add_action('wp_ajax_hell_ajax_auto_detect', array($this, 'auto_detect'));
        add_action('wp_ajax_hell_ajax_download', array($this, 'download'));
        // @formatter:on
    }

    /**
     * @return HELL_AJAX_AutoDetect
     */
    public function auto_detect()
    {
        return new HELL_AJAX_AutoDetect();
    }

    /**
     * @return HELL_AJAX_Download
     */
    public function download()
    {
        return new HELL_AJAX_Download();
    }
}
