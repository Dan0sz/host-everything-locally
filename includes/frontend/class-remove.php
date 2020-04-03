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

class HELL_Frontend_Remove
{
    /** @var array $remove_styles */
    private $remove_styles = [];

    /** @var array $remove_scripts */
    private $remove_scripts = [];

    /**
     * HELL_Frontend_Functions constructor.
     */
    public function __construct()
    {
        $this->remove_styles  = $this->collect('style');
        $this->remove_scripts = $this->collect('script');

        // If Styles Removals differs from default values, continue.
        $diff = strcmp(json_encode($this->remove_styles), json_encode(HELL::WP_HELL_DEFAULT_REMOVE));
        if ($diff) {
            add_action('wp_print_styles', array($this, 'remove_styles'), 1000);
        }

        if ($this->remove_scripts) {
            add_action('wp_print_scripts', array($this, 'remove_scripts'), 1000);
        }
    }

    /**
     * @param string $type
     */
    private function collect($type = 'style')
    {
        $removals = WP_HELL_REMOVE;

        return array_filter(
            $removals,
            function ($properties) use ($type) {
                return $properties['type'] == $type;
            }
        );
    }

    /**
     * Remove styles
     */
    public function remove_styles()
    {
        global $wp_styles;

        $styles = $wp_styles->registered;

        $this->remove('style', $styles);
    }

    /**
     * Remove scripts
     */
    public function remove_scripts()
    {
        global $wp_scripts;

        $scripts = $wp_scripts->registered;

        $this->remove('script', $scripts);
    }

    /**
     * Remove items based on type.
     *
     * @param $type
     * @param $registered
     */
    private function remove($type, $registered)
    {
        $remove     = 'remove_' . $type . 's';
        $deregister = 'wp_deregister_' . $type;
        $dequeue    = 'wp_dequeue_' . $type;

        foreach ($this->$remove as $key => $removal) {
            if ($removal['attribute'] == 'handle') {
                $deregister($removal['handle']);
                $dequeue($removal['handle']);

                continue;
            }

            $found = $this->filter($registered, $removal);
        }

        if (empty($found)) {
            return;
        }

        foreach ($found as $item) {
            $deregister($item->handle);
            $dequeue($item->handle);
        }
    }

    /**
     * @param $registered
     * @param $removal
     *
     * @return array
     */
    private function filter($registered, $removal)
    {
        return array_filter(
            $registered,
            function ($properties) use ($removal) {
                return strpos($properties->src, $removal['handle']) !== false;
            }
        );
    }
}
