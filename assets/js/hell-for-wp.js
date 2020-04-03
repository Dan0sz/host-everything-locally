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

jQuery(document).ready(function ($) {
    /**
     * Add row
     */
    $('.hell-plus').on('click', function(e) {
        row = $('.row');
        last = row.last();
        count = row.length + 1;

        row.eq(0).clone(true).insertAfter(last)
        .find("select, input").each(function() {
            this.name = this.name.replace(/\d+/, count);
        });

        $('.row').last().children('label').text('#' + count);
    });

    /**
     * Remove row
     */
    $('.hell-minus').on('click', function(e) {
        $(this).parent('.row').remove();
    });

    /**
     * Auto Detect
     */
    $('.hell-detect').on('click', function(e) {
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'hell_ajax_auto_detect',
            },
            dataType: 'json',
            beforeSend: function() {
                $('.hell-detect').text('Enabling...');
            },
            complete: function (response) {
                console.log(response.status + ': ' + response.responseJSON.data);
                location.reload();
            }
        });
    });

    /**
     * Download
     */
    $('.hell-download').on('click', function() {
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'hell_ajax_download',
                items: $('input[name^="wp_hell_download"]').serialize()
            },
            dataType: 'json',
            beforeSend: function () {
                $('.hell-download').text('Downloading...');
            },
            complete: function (response) {
                console.log(response.status + ': ' + response.responseJSON.data);
                location.reload();
            }
        });
    });
});