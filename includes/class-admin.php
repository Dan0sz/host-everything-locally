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

class HELL_Admin
{
    /**
     * HELL_Admin constructor.
     */
    public function __construct()
    {
        $this->do_ajax();
        $this->do_settings();

        add_action('admin_notices', array($this, 'add_notice'));
    }

    /**
     * @return HELL_AJAX
     */
    private function do_ajax()
    {
        return new HELL_AJAX();
    }

    /**
     * @return HELL_Admin_Settings
     */
    private function do_settings()
    {
        return new HELL_Admin_Settings();
    }

    public function add_notice()
    {
        HELL_Admin_Notice::print_notice();
    }
}
