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

$utmTags = '?utm_source=hell&utm_medium=plugin&utm_campaign=support_tab';
?>
<div id="hell-welcome-panel" class="welcome-panel">
    <div class="welcome-panel-content">
        <p class="about-description">
            <span class="icon"></span> <?= __('Speed up WordPress so much it hurts.', 'host-everything-local'); ?>
        </p>
        <div class="welcome-panel-column-container">
            <h3><?= __('Disclaimer', 'host-everything-local'); ?></h3>
            <p>
                <?= __('HELL for WP can seriously injure your theme, plugins and mental health and should only be used by developers suffering from a sustainable amount of mental damage.'); ?>
            </p>
            <p class="align-center">
                <a href="https://woosh.dev/wordpress-services/hell-expert-configuration" target="_blank" class="button button-primary button-hero"><span class="dashicons dashicons-thumbs-up"></span> <?= __('Hire Me', 'host-everything-local'); ?></a><br />
                <span><em>(<?= __('Expert configuration: € 149,-', 'host-everything-local'); ?>)</em></span>
            </p>
            <p>
                <?= __('or, leave its configuration to your webdeveloper.', 'host-everything-local'); ?>
            </p>
            <h3><?= __('Need More Speed?', 'host-everything-local'); ?></h3>
            <ul>
                <li><a class="welcome-icon dashicons-before dashicons-dashboard" href="https://woosh.dev/wordpress-services/speed-optimization<?= $utmTags; ?>" target="_blank"><?= __('Pro WordPress Speed Optimization', 'host-everything-local'); ?></a></li>
                <li><a class="welcome-icon dashicons-before dashicons-analytics" href="https://woosh.dev/wordpress-services/caos-expert-configuration<?= $utmTags; ?>" target="_blank"><?= __('CAOS Expert Configuration', 'host-everything-local'); ?></a></li>
                <li><a class="welcome-icon dashicons-before dashicons-art" href="https://woosh.dev/wordpress-services/omgf-expert-configuration<?= $utmTags; ?>" target="_blank"><?= __('OMGF Expert Configuration', 'host-everything-local'); ?></a></li>
            </ul>
            <h3><?= __('Need Help?', 'host-everything-local'); ?></h3>
            <p>
                <?= __('For a detailed explanation of what Hell entails, refer to the Holy Bible or', 'host-everything-local'); ?>, <?= sprintf(__('read %sthis%s for an introduction about the functions of this plugin.'), '<a href="' . WP_HELL_SITE_URL . 'wordpress/hell-for-wordpress' . $utmTags . '" target="_blank">', '</a>'); ?>
            </p>
            <p>
                <?= sprintf(__('For configuration questions, contact your web developer or hire me. To report a bug, visit the %sSupport Forum%s.', 'host-everything-local'),'<a href="https://wordpress.org/support/plugin/host-everything-local">', '</a>'); ?>
            </p>
        </div>
    </div>
</div>
