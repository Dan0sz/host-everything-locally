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

<h3><?= __('Download Styles/Scripts', 'host-everything-local'); ?></h3>
<p>
    <?= __('Auto Detect any external scripts or stylesheets and download them. Downloaded items automatically replace external resources in WordPress\' <code>head</code>.', 'host-everything-local'); ?>
</p>
<?php
$download = WP_HELL_DOWNLOAD;
$i        = 0;

if ($download):
    $i++;
    foreach ($download as $handle => $row): ?>
        <div class="row">
            <label>#<?= $i; ?></label>
            <input readonly type="text" name="wp_hell_download[<?= $handle; ?>][type]" value="<?= $row['type']; ?>" />
            <input readonly type="text" name="wp_hell_download[<?= $handle; ?>][handle]" value="<?= $row['handle']; ?>" />
            <input readonly type="text" name="wp_hell_download[<?= $handle; ?>][file]" value="<?= $row['file']; ?>"/>
            <input readonly type="text" name="wp_hell_download[<?= $handle; ?>][local_src]" placeholder="Not downloaded yet." value="<?= !empty($row['local_src']) ? $row['local_src'] : ''; ?>" />
            <input type="hidden" name="wp_hell_download[<?= $handle; ?>][src]" value="<?= $row['src']; ?>" />

            <span class="hell-minus notice-dismiss download">&nbsp;</span>
        </div>
    <?php endforeach;
else: ?>
    <p class="description">
        <?= __('No files detected or downloaded yet. Click Auto Detect to begin.', 'host-everything-local'); ?>
    </p>
<?php endif; ?>
