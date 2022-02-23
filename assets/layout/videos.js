jQuery(function () {
    'use strict';

    (() => {
        let $videoPerPageInput = jQuery('#video-per-page-input');

        if ($videoPerPageInput.length === 0) {
            return;
        }

        $videoPerPageInput.on('change', function (e) {
            $videoPerPageInput.closest('form').trigger('submit');
        });
    })();
});
