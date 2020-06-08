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

class HELL_AJAX_Download
{
    /** @var array $item */
    private $items = [];

    /** @var string $cache_path */
    private $cache_path = '';

    /** @var WP_Filesystem_Base $filesystem */
    private $filesystem;

    /**
     * HELL_AJAX_Download constructor.
     */
    public function __construct()
    {
        parse_str(urldecode($_POST['items']), $items);
        $this->items = $items['wp_hell_download'];

        if (empty($this->items)) {
            HELL_Admin_Notice::set_notice(__('No items in queue.'. 'host-everything-local'), 'error');
            wp_send_json_error(__('No items in queue.', 'host-everything-local'), 500);
        }

        $this->cache_path = WP_CONTENT_DIR . '/' . WP_HELL_CACHE_DIR;
        $this->filesystem = $this->filesystem();

        $this->download($this->items);
    }

    /**
     * @param $items
     */
    private function download(&$items)
    {
        $files_downloaded = [];
        $files_failed     = [];

        foreach ($items as &$item) {
            $type_path = $this->cache_path . $item['type'];

            if (!file_exists($type_path)) {
                wp_mkdir_p($type_path);
            }

            $local_file = $type_path . '/' . $item['file'];

            if (substr($item['src'], 0, 2) == '//') {
                $item['src'] = preg_replace('/\/\//', 'https://', $item['src'], 1);
            }

            $file = wp_remote_get($item['src'], ['filename' => $item['file']]);

            if (is_wp_error($file)) {
                HELL_Admin_Notice::set_notice($file->get_error_code() . ': ' . $file->get_error_message(), 'error');
                wp_send_json_error($file->get_error_code());
            }

            $this->filesystem->put_contents($local_file, $file['body']);

            if (file_exists($local_file)) {
                $item['local_src'] = content_url(WP_HELL_CACHE_DIR . $item['type'] . '/' . $item['file']);
                $files_downloaded[] = $item['file'];
            } else {
                $files_failed[] = $item['file'];
            }
        }

        if ($files_downloaded) {
            $message = implode(', ', $files_downloaded);
            $message .= ' downloaded successfully. ';
        }

        if ($files_failed) {
            $message .= implode(',', $files_failed);
            $message .= ' failed.';

            HELL_Admin_Notice::set_notice($message, 'error');
            wp_send_json_error($message, 500);
        }

        update_option(HELL_Admin_Settings::WP_HELL_SETTING_DOWNLOAD, $this->items);

        HELL_Admin_Notice::set_notice($message);
        wp_send_json_success($message, 200);
    }

    /**
     * Helper to return WordPress filesystem subclass.
     *
     * @return WP_Filesystem_Base $wp_filesystem
     */
    private function filesystem()
    {
        global $wp_filesystem;

        if ( is_null( $wp_filesystem ) ) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        return $wp_filesystem;
    }
}
