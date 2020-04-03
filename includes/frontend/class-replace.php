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

class HELL_Frontend_Replace
{
    /** @var array $items */
    private $items = [];

    /**
     * HELL_Frontend_ScriptLoader constructor.
     */
    public function __construct()
    {
        $this->items = WP_HELL_DOWNLOAD;

        $this->replace_scripts($this->items);
    }

    /**
     * @param $items
     */
    private function replace_scripts($items)
    {
        foreach($items as $item) {
            $this->dequeue($item['type'], $item['handle']);
            $this->enqueue($item['type'], $item['handle'], $item['local_src']);
        }
    }

    /**
     * @param $type
     * @param $handle
     * @param $src
     */
    private function enqueue($type, $handle, $src)
    {
        $register_action = 'wp_register_' . $type;
        $enqueue_action  = 'wp_enqueue_' . $type;

        $register_action($handle . '-local', $src);
        $enqueue_action($handle . '-local', $src);
    }

    /**
     * @param $type
     * @param $handle
     */
    private function dequeue($type, $handle)
    {
        $deregister_action = 'wp_deregister_' . $type;
        $dequeue_action    = 'wp_dequeue_' . $type;

        $deregister_action($handle);
        $dequeue_action($handle);
    }
}
