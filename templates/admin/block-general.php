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
?>

<h3><?= __('General Settings', 'host-everything-local'); ?></h3>
<p>
    <?= __('Global settings for this plugin.', 'host-everything-local'); ?>
</p>
<table class="form-table">
    <tr valign="top">
        <th scope="row">
            <label for="<?= HELL_Admin_Settings::WP_HELL_SETTING_GENERAL_OPTIMIZE_ADMIN_USERS; ?>">
                <?php _e('Optimize for logged in administrators/editors?', 'host-webfonts-local'); ?>
            </label>
        </th>
        <td>
            <input class="<?= HELL_Admin_Settings::WP_HELL_SETTING_GENERAL_OPTIMIZE_ADMIN_USERS; ?>" id="<?= HELL_Admin_Settings::WP_HELL_SETTING_GENERAL_OPTIMIZE_ADMIN_USERS; ?>" type="checkbox" name="<?= HELL_Admin_Settings::WP_HELL_SETTING_GENERAL_OPTIMIZE_ADMIN_USERS; ?>" <?= WP_HELL_GENERAL_OPTIMIZE_ADMIN_USERS == 'on' ? 'checked = "checked"' : ''; ?> />
            <p class="description">
                <?= __('Useful for debugging purposes. Leave this option disabled e.g. when using a page builder.'); ?>
            </p>
        </td>
    </tr>
</table>
