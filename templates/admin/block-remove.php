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

<h3><?= __('Remove Styles/Scripts', 'host-everything-local'); ?></h3>

<p>
    <?= __('Remove local and/or external sources from WordPress\' <code>head</code>. Specify a script/stylesheet by either source (filename) or handle.', 'host-everything-local'); ?>  <a target="_blank" href="https://daan.dev/wordpress-plugins/hell/#what-is-handle"><?= __('What\'s a handle?' , 'host-everything-local'); ?></a>
</p>

<?php
$remove = WP_HELL_REMOVE;
?>

<?php foreach ($remove as $i => $row): ?>
    <div class="row">
        <label>#<?= $i; ?></label>
        <select name="wp_hell_remove[<?= $i; ?>][type]">
            <option value="style" <?= $row['type'] == 'style' ? 'selected' : ''; ?>><?= __('Style', 'host-everything-local'); ?></option>
            <option value="script" <?= $row['type'] == 'script' ? 'selected' : ''; ?>><?= __('Script', 'host-everything-local'); ?></option>
        </select>
        <select name="wp_hell_remove[<?= $i; ?>][attribute]">
            <option value="src" <?= $row['attribute'] == 'src' ? 'selected' : ''; ?>><?= __('Source', 'host-everything-local'); ?></option>
            <option value="handle" <?= $row['attribute'] == 'handle' ? 'selected' : ''; ?>><?= __('Handle', 'host-everything-local'); ?></option>
        </select>
        <input type="text" placeholder="Handle or filename..." name="wp_hell_remove[<?= $i; ?>][handle]" value="<?= $row['handle']; ?>" />

        <span class="hell-minus notice-dismiss remove">&nbsp;</span>
    </div>
<?php endforeach; ?>
