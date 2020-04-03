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

<h3><?= __('DNS Prefetch & Preconnect', 'host-everything-local'); ?></h3>

<p>
    <?= __('Initiate an early connection, before the resource is needed. Select either <strong>DNS Prefetch</strong> or <strong>Preconnect</strong> and specify the URL. Check the box to enable the <code>crossorigin</code> attribute.', 'host-everything-local'); ?> <a href="https://daan.dev/wordpress-plugins/hell/#difference-prefetch-preconnect" target="_blank"><?= __('What\'s the difference?', 'host-everything-local'); ?></a>
</p>

<?php
$remove = WP_HELL_PRECONNECT;
?>

<?php foreach ($remove as $i => $row): ?>
    <div class="row">
        <label>#<?= $i; ?></label>
        <select name="wp_hell_preconnect[<?= $i; ?>][type]">
            <option value="dns-prefetch" <?= $row['type'] == 'dns-prefetch' ? 'selected' : ''; ?>><?= __('DNS Prefetch', 'host-everything-local'); ?></option>
            <option value="preconnect" <?= $row['type'] == 'preconnect' ? 'selected' : ''; ?>><?= __('Preconnect', 'host-everything-local'); ?></option>
        </select>
        <input type="text" placeholder="E.g. https://www.google-analytics.com" name="wp_hell_preconnect[<?= $i; ?>][url]" value="<?= $row['url']; ?>" />
        <input type="checkbox" name="wp_hell_preconnect[<?= $i; ?>][crossorigin]" <?= isset($row['crossorigin']) ? 'checked' : ''; ?> />

        <span class="hell-minus notice-dismiss preconnect">&nbsp;</span>
    </div>
<?php endforeach; ?>
