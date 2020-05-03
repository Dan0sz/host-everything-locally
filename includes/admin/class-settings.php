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

class HELL_Admin_Settings
{
    // Sections
    const WP_HELL_ADMIN_SECTION_GENERAL    = 'hell-general';
    const WP_HELL_ADMIN_SECTION_REMOVE     = 'hell-remove';
    const WP_HELL_ADMIN_SECTION_DOWNLOAD   = 'hell-download';
    const WP_HELL_ADMIN_SECTION_PRECONNECT = 'hell-preconnect';
    const WP_HELL_ADMIN_SECTION_PRELOAD    = 'hell-preload';

    // Settings
    const WP_HELL_SETTING_GENERAL_OPTIMIZE_ADMIN_USERS = 'wp_hell_general_optimize_admin_users';
    const WP_HELL_SETTING_REMOVE                       = 'wp_hell_remove';
    const WP_HELL_SETTING_DOWNLOAD_AUTO_DETECT_ENABLED = 'wp_hell_auto_detect_enabled';
    const WP_HELL_SETTING_DOWNLOAD                     = 'wp_hell_download';
    const WP_HELL_SETTING_PRECONNECT                   = 'wp_hell_preconnect';
    const WP_HELL_SETTING_PRELOAD                      = 'wp_hell_preload';

    /** @var string $active_tab */
    private $active_tab;

    /** @var string $page */
    private $page;

    /**
     * HELL_Admin_Settings constructor.
     */
    public function __construct()
    {
        $this->active_tab = isset($_GET['tab']) ? $_GET['tab'] : self::WP_HELL_ADMIN_SECTION_GENERAL;
        $this->page       = isset($_GET['page']) ? $_GET['page'] : '';

        // @formatter:off
        add_action('admin_menu', [$this, 'create_menu']);
        add_filter('plugin_action_links_' . plugin_basename(WP_HELL_PLUGIN_FILE), [$this, 'settings_link']);

        if ($this->page !== 'hell_for_wp') {
            return;
        }

        // Scripts
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin']);

        // Tabs
        add_action('hell_settings_tab', [$this, 'do_general_tab']);
        add_action('hell_settings_tab', [$this, 'do_remove_tab']);
        add_action('hell_settings_tab', [$this, 'do_download_tab']);
        add_action('hell_settings_tab', [$this, 'do_preconnect_tab']);
        add_action('hell_settings_tab', [$this, 'do_preload_tab']);

        // Content
        add_action('hell_settings_content', [$this, 'do_content']);
        // @formatter:on
    }

    /**
     * Create Menu
     */
    public function create_menu()
    {
        // @formatter:off
        add_options_page(
            'Host Everything LocaL (HELL) for WordPress',
            'Optimize WP Head',
            'manage_options',
            'hell_for_wp',
            [$this, 'settings_page']
        );

        add_action('admin_init', [$this, 'register_settings']);
        // @formatter:on
    }

    /**
     * Create settings page
     */
    public function settings_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__("You're not cool enough to access this page.", 'host-everything-local'));
        }
        ?>

        <div class="wrap">
            <h1><?php _e('Host Everything LocaL (HELL) for WordPress', 'host-everything-local'); ?></h1>

            <p>
                <?= get_plugin_data(WP_HELL_PLUGIN_FILE)['Description']; ?>
            </p>

            <div class="hell-settings-column settings-<?= $this->active_tab; ?>">
                <h2 class="hell-nav nav-tab-wrapper">
                    <?php do_action('hell_settings_tab'); ?>
                </h2>

                <form method="post" action="options.php?tab=<?= $this->active_tab; ?>">
                    <?php
                    settings_fields($this->active_tab);
                    do_settings_sections($this->active_tab);
                    ?>

                    <?php do_action('hell_settings_content'); ?>

                    <?php
                    $current_section = str_replace('-', '_', $this->active_tab);
                    do_action( "after_$current_section");
                    ?>

                    <?php do_action('hell_for_wp_after_form_settings'); ?>

                    <?php $this->do_buttons(); ?>
                </form>
            </div>

            <div class="hell-settings-column right">
                <?php $this->get_template('disclaimer'); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Register all settings.
     *
     * @throws ReflectionException
     */
    public function register_settings()
    {
        if ($this->active_tab !== self::WP_HELL_ADMIN_SECTION_REMOVE
            && $this->active_tab !== self::WP_HELL_ADMIN_SECTION_DOWNLOAD
            && $this->active_tab !== self::WP_HELL_ADMIN_SECTION_PRECONNECT
            && $this->active_tab !== self::WP_HELL_ADMIN_SECTION_PRELOAD) {
            $this->active_tab = self::WP_HELL_ADMIN_SECTION_GENERAL;
        }

        foreach ($this->get_settings() as $constant => $value) {
            register_setting(
                $this->active_tab,
                $value
            );
        }
    }

    /**
     * Get all settings using the constants in this class.
     *
     * @return array
     * @throws ReflectionException
     */
    public function get_settings()
    {
        $reflection = new ReflectionClass($this);
        $constants  = $reflection->getConstants();
        $needle     = 'WP_HELL_SETTING_' . strtoupper(str_replace('hell-', '', $this->active_tab));

        return array_filter(
            $constants,
            function ($key) use ($needle) {
                return strpos($key, $needle) !== false;
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * General Settings
     */
    public function do_general_tab()
    {
        $this->generate_tab(self::WP_HELL_ADMIN_SECTION_GENERAL, 'dashicons-admin-tools', __('General Settings', 'host-everything-local'));
    }

    /**
     * Add Remove Tab
     */
    public function do_remove_tab()
    {
        $this->generate_tab(self::WP_HELL_ADMIN_SECTION_REMOVE, 'dashicons-editor-unlink', __('Remove Styles/Scripts', 'host-everything-local'));
    }

    /**
     * Add Replace Tab
     */
    public function do_download_tab()
    {
        $this->generate_tab(self::WP_HELL_ADMIN_SECTION_DOWNLOAD, 'dashicons-download', __('Download Styles/Scripts', 'host-everything-local'));
    }

    /**
     * Add Preconnect Tab
     */
    public function do_preconnect_tab()
    {
        $this->generate_tab(self::WP_HELL_ADMIN_SECTION_PRECONNECT, 'dashicons-backup', __('DNS Prefetch/Preconnect', 'host-everything-local'));
    }

    /**
     * Add Preload Tab
     */
    public function do_preload_tab()
    {
        $this->generate_tab(self::WP_HELL_ADMIN_SECTION_PRELOAD, 'dashicons-backup', __('Preload', 'host-everything-local'));
    }

    /**
     * @param      $id
     * @param null $icon
     * @param null $label
     */
    private function generate_tab($id, $icon = null, $label = null)
    {
        ?>
        <a class="nav-tab dashicons-before <?= $icon; ?> <?= $this->active_tab == $id ? 'nav-tab-active' : ''; ?>" href="<?= $this->generate_tab_link($id);?>">
            <?= $label; ?>
        </a>
        <?php
    }

    /**
     * @param $tab
     *
     * @return string
     */
    private function generate_tab_link($tab)
    {
        return admin_url("options-general.php?page=hell_for_wp&tab=$tab");
    }

    /**
     * Render active content.
     */
    public function do_content()
    {
        $tab = str_replace('hell-', '', $this->active_tab);

        $this->get_template($tab);
    }

    /**
     * Add appropriate buttons.
     */
    private function do_buttons()
    {
        if ($this->active_tab == self::WP_HELL_ADMIN_SECTION_DOWNLOAD): ?>
            <?php
            $auto_detect             = get_option(self::WP_HELL_SETTING_DOWNLOAD_AUTO_DETECT_ENABLED);
            $anything_detected       = get_option(self::WP_HELL_SETTING_DOWNLOAD) ?: [];
            $anything_not_downloaded = array_filter(
                $anything_detected, function ($properties) {
                    return !isset($properties['local_src']);
                }
            );
            $detect_class            = $anything_not_downloaded ? 'button-secondary' : 'button-primary';
            $download_class          = $anything_not_downloaded ? 'button-primary' : 'button=secondary';
            ?>
            <p>
                <span class="button <?= $detect_class; ?> hell-detect"><?= $auto_detect ? __('Auto Detect Enabled', 'host-everything-local') : __('Auto Detect', 'host-everything-local'); ?></span>
                <span class="button <?= $download_class; ?> hell-download"><?= __('Download', 'host-everything-local'); ?></span>
                <?php submit_button(__('Apply Changes', 'host-everything-local'), 'secondary', 'submit', false); ?>
            </p>
        <?php elseif ($this->active_tab == self::WP_HELL_ADMIN_SECTION_GENERAL): ?>
            <p>
                <?php submit_button(null, 'primary', 'submit', false); ?>
            </p>
        <?php else: ?>
            <p>
                <span class="button button-secondary hell-plus"><?= __('Add Row', 'host-everything-local'); ?></span>
                <?php submit_button(null, 'primary', 'submit', false); ?>
            </p>
        <?php endif;
    }

    /**
     * Add settings link to plugin overview
     *
     * @param $links
     *
     * @return mixed
     */
    public function settings_link($links)
    {
        $adminUrl     = admin_url() . 'options-general.php?page=hell_for_wp';
        $settingsLink = "<a href='$adminUrl'>" . __('Settings', 'host-everything-local') . "</a>";
        array_push($links, $settingsLink);

        return $links;
    }

    /**
     * Enqueue JS scripts for Administrator Area.
     *
     * @param $hook
     */
    public function enqueue_admin($hook)
    {
        if ($hook == 'settings_page_hell_for_wp') {
            wp_enqueue_script('hell_for_wp_admin_script', plugins_url('assets/js/hell-for-wp.js', WP_HELL_PLUGIN_FILE), ['jquery'], WP_HELL_PLUGIN_VERSION, true);
            wp_enqueue_style('hell_for_wp_admin_style', plugins_url('assets/css/hell-for-wp.css', WP_HELL_PLUGIN_FILE), [], WP_HELL_PLUGIN_VERSION);
        }
    }

    /**
     * @param $file
     *
     * @return mixed
     */
    private function get_template($file)
    {
        return include WP_HELL_PLUGIN_DIR . 'templates/admin/block-' . $file . '.php';
    }
}
