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

<h3><?= __('Preload', 'host-everything-local'); ?></h3>

<p>
    <?= __('Load resources early in the page\'s lifecycle.', 'host-everything-local'); ?>
    <?= __('Specify resources by type, source URL and MIME type. Check the box to enable the <code>crossorigin</code> attribute.', 'host-everything-local'); ?> <a target="_blank" href="https://daan.dev/wordpress-plugins/hell/#what-is-mime-type"><?= __('What\'s a MIME Type?', 'host-everything-local'); ?></a>
</p>

<?php
$remove = WP_HELL_PRELOAD;
$as_options = [
    'font'   => __('Font', 'host-everything-local'),
    'image'  => __('Image', 'host-everything-local'),
    'script' => __('JavaScript', 'host-everything-local'),
    'style'  => __('CSS Stylesheet', 'host-everything-local')
]
?>

<?php foreach ($remove as $i => $row): ?>
    <div class="row">
        <label>#<?= $i; ?></label>
        <select name="wp_hell_preload[<?= $i; ?>][as]">
            <?php foreach ($as_options as $value => $label): ?>
                <option value="<?= $value; ?>" <?= $row['as'] == $value ? 'selected' : ''; ?>><?= $label; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" placeholder="e.g. https://yoursite.com/file.woff2" name="wp_hell_preload[<?= $i; ?>][href]" value="<?= $row['href']; ?>" />
        <input type="text" placeholder="e.g. font/woff2" name="wp_hell_preload[<?= $i; ?>][type]" value="<?= $row['type'] ?? ''; ?>" />
        <input type="checkbox" name="wp_hell_preload[<?= $i; ?>][crossorigin]" <?= isset($row['crossorigin']) ? 'checked' : ''; ?> />

        <span class="hell-minus notice-dismiss preload">&nbsp;</span>
    </div>
<?php endforeach; ?>
