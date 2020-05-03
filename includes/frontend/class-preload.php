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

class HELL_Frontend_Preload
{
    /** @var $items array */
    private $items;

    /**
     * HELL_Frontend_Preconnect constructor.
     */
    public function __construct(
        $items
    ) {
        $this->items = $items;

        $diff = strcmp(json_encode($this->items), json_encode(HELL::WP_HELL_DEFAULT_PRELOAD));

        if ($diff) {
            $this->init();
        }
    }

    /**
     * Initialize Preload
     */
    private function init()
    {
        echo "<!-- HELL: Preload -->\n";

        foreach ($this->items as $key => $item) {
            $url         = $item['href'];
            $as          = $item['as'];
            $type        = $item['type'];
            $crossorigin = isset($item['crossorigin']) ? 'crossorigin="anonymous"' : '';

            $this->preload($url, $as, $type, $crossorigin);
        }
    }

    /**
     * Add line to <head>.
     *
     * @param        $url
     * @param        $as
     * @param string $type
     * @param string $crossorigin
     */
    private function preload($url, $as, $type = '', $crossorigin = '')
    {
        $type = $type ? "type='$type'" : '';

        echo "<link rel='preload' href='$url' as='$as' $type $crossorigin/>\n";
    }
}
