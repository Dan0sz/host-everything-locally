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

class HELL_Frontend_Preconnect
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

        // If settings differ from default values, intialize.
        $diff = strcmp(json_encode($this->items), json_encode(HELL::WP_HELL_DEFAULT_PRECONNECT));
        if ($diff) {
            $this->init();
        }
    }

    /**
     * Initialize Preconnect and Prefetch
     */
    private function init()
    {
        echo "<!-- HELL: Preconnect & Prefetch -->\n";

        foreach ($this->items as $key => $item) {
            $crossorigin = isset($item['crossorigin']) ? 'crossorigin' : '';
            $url         = $item['url'];

            $this->add($item['type'], $item['url'], $crossorigin);
        }
    }

    /**
     * Add lines to <head>.
     *
     * @param        $type
     * @param        $url
     * @param string $crossorigin
     */
    private function add($type, $url, $crossorigin = '')
    {
        echo "<link rel='$type' href='$url' $crossorigin />\n";
    }
}
