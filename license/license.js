(function ($) {

    var ajaxUrl   = thTcpLicense.ajaxUrl;
    var nonce     = thTcpLicense.nonce;
    var siteURL   = thTcpLicense.siteURL;
    var i18n      = thTcpLicense.i18n;
    var userAgent = navigator.userAgent;
    var ipAddress = '';

    // Fetch IP once on load
    fetch('https://api.ipify.org?format=json')
        .then(function (r) { return r.json(); })
        .then(function (d) { ipAddress = d.ip; })
        .catch(function () {});

    function showNotice(msg, type) {
        var cls = type === 'success' ? 'th-notice-success' : 'th-notice-error';
        $('#th-tpcp-license-notice')
            .removeClass('th-notice-success th-notice-error')
            .addClass('th-license-notice-box ' + cls)
            .html('<p>' + msg + '</p>')
            .show();
    }

    function errorCheck(code) {
        var msg = i18n[code] || i18n.generic;
        showNotice(msg, 'error');
    }

    // Save key + expire_date locally via WP AJAX
    function saveKeyLocally(keyData, onSuccess) {
        $.post(ajaxUrl, {
            action  : 'th_tpcp_pro_site_key',
            security: nonce,
            data    : JSON.stringify({ data: keyData })
        }).done(function (res) {
            if (res && res.success) {
                onSuccess();
            } else {
                showNotice(i18n.save_failed, 'error');
            }
        }).fail(function () {
            showNotice(i18n.ajax_failed, 'error');
        });
    }

    // Reset key locally via WP AJAX
    function doReset(onSuccess) {
        $.post(ajaxUrl, {
            action  : 'th_tpcp_pro_site_key',
            security: nonce,
            data    : JSON.stringify({ data: 'reset' })
        }).done(function (res) {
            if (res && res.success) { onSuccess(); }
        }).fail(function () {
            showNotice(i18n.ajax_failed, 'error');
        });
    }

    // Activate — verify on ThemeHunk server, then save locally
    $('#th-tpcp-activate-btn').on('click', function () {
        var key = $.trim($('#th-tpcp-license-key-input').val());
        if (!key) {
            showNotice(i18n.empty_key, 'error');
            return;
        }

        var $btn     = $(this);
        var $spinner = $('#th-tpcp-activate-spinner');
        $spinner.css('visibility', 'visible');
        $btn.prop('disabled', true);

        // Step 1 — verify against ThemeHunk server
        $.get('https://themehunk.com/wp-json/ai/v1/apikey/ai-site-builder', {
            apikey   : key,
            ipAddress: ipAddress,
            siteURL  : siteURL,
            userAgent: userAgent,
            slug     : 'th-product-compare-pro'
        }).done(function (response) {

            if (response && response.status === false) {
                errorCheck(response.code);
                $spinner.css('visibility', 'hidden');
                $btn.prop('disabled', false);
                return;
            }

            // Step 2 — server OK → save key + expire_date locally
            var expireDate = response.expire_date || '';
            saveKeyLocally({ key: key, expire_date: expireDate }, function () {
                var masked = key.substring(0, 5)
                    + key.substring(5, key.length - 5).replace(/./g, '*')
                    + key.slice(-5);
                $('#th-tpcp-masked-key').text(masked);
                $('#th-tpcp-expire-date').text(expireDate || '-');
                $('#th-tpcp-license-inactive').hide();
                $('#th-tpcp-license-active').show();
                showNotice(i18n.activated, 'success');
                $spinner.css('visibility', 'hidden');
                $btn.prop('disabled', false);
                // Unlock all locked tabs immediately
                $(document).trigger('th.license.activated');
            });

        }).fail(function () {
            showNotice(i18n.server_unreachable, 'error');
            $spinner.css('visibility', 'hidden');
            $btn.prop('disabled', false);
        });
    });

    // Reset
    $('#th-tpcp-reset-btn').on('click', function () {
        if (!confirm(i18n.reset_confirm)) { return; }

        var $btn     = $(this);
        var $spinner = $('#th-tpcp-reset-spinner');
        $spinner.css('visibility', 'visible');
        $btn.prop('disabled', true);

        doReset(function () {
            $('#th-tpcp-license-active').hide();
            $('#th-tpcp-license-inactive').show();
            $('#th-tpcp-license-key-input').val('');
            showNotice(i18n.reset_success, 'success');
            $spinner.css('visibility', 'hidden');
            $btn.prop('disabled', false);
        });
    });

    /* ------------------------------------------------------------------ */
    /* License Gate — lock tabs when license is not active                 */
    /* ------------------------------------------------------------------ */

    var lockedTabs  = ['setting', 'single-page-product', 'style', 'mobile'];
    var isActive    = parseInt( thTcpLicense.isActive,  10 ) === 1;
    var isExpired   = parseInt( thTcpLicense.isExpired, 10 ) === 1;
    var shouldLock  = ! isActive; // covers both: no license AND expired

    var lockTitle = isExpired ? i18n.expired_title : i18n.lock_title;
    var lockDesc  = isExpired ? i18n.expired_desc  : i18n.lock_desc;
    var lockBtn   = isExpired ? i18n.expired_btn   : i18n.lock_btn;

    var lockOverlayHTML =
        '<div class="th-lock-overlay">' +
            '<div class="th-lock-box">' +
                '<span class="dashicons dashicons-lock th-lock-icon"></span>' +
                '<h3>' + lockTitle + '</h3>' +
                '<p>'  + lockDesc  + '</p>' +
                '<a href="#" class="button button-primary th-go-to-license">' + lockBtn + '</a>' +
            '</div>' +
        '</div>';

    var lockCSS =
        '.th-tab-locked { opacity:.5; pointer-events:none; position:relative; }' +
        '.th-tab-locked::after { content:"\\f160"; font-family:dashicons; font-size:13px; margin-left:5px; vertical-align:middle; }' +
        '.th-content-locked { position:relative; min-height:200px; }' +
        '.th-lock-overlay { position:absolute; inset:0; background:rgba(255,255,255,.82); z-index:99; display:flex; align-items:center; justify-content:center; border-radius:6px; }' +
        '.th-lock-box { text-align:center; padding:32px 40px; background:#fff; border:1px solid #e0e0e0; border-radius:8px; box-shadow:0 2px 12px rgba(0,0,0,.08); max-width:360px; }' +
        '.th-lock-icon { font-size:40px !important; width:40px !important; height:40px !important; color:#b0b0b0; display:block; margin:0 auto 12px; }' +
        '.th-lock-box h3 { margin:0 0 8px; font-size:16px; }' +
        '.th-lock-box p  { color:#666; margin:0 0 16px; font-size:13px; }';

    // Inject CSS
    $('<style>').text( lockCSS ).appendTo( 'head' );

    if ( shouldLock ) {

        lockedTabs.forEach( function ( tab ) {

            // Gray out nav link (keep clickable so overlay message shows)
            var $nav = $( '[data-group-tabs="main"][data-tab="' + tab + '"]' );
            $nav.addClass( 'th-tab-locked' ).css( 'pointer-events', 'auto' );

            // Wrap content and add overlay
            var $content = $( '[data-group-tabs="main"][data-tab-container="' + tab + '"]' );
            $content.css( 'position', 'relative' ).prepend( lockOverlayHTML );

            // Disable all form inputs inside locked tabs
            $content.find( 'input, select, textarea, button' ).prop( 'disabled', true );
        } );

        // Navigate to license tab when "Activate License" is clicked
        $( document ).on( 'click', '.th-go-to-license', function ( e ) {
            e.preventDefault();
            $( '[data-group-tabs="main"][data-tab="license"]' ).trigger( 'click' );
        } );

        // Hide Save/Reset buttons when a locked tab is active
        $( document ).on( 'click', '[data-group-tabs="main"][data-tab]', function () {
            var tab       = $( this ).data( 'tab' );
            var isLocked  = lockedTabs.indexOf( tab ) !== -1;
            $( '.th-save-btn' ).toggle( ! isLocked );
        } );

    } else {

        // License active — enable everything (in case page cached locked state)
        lockedTabs.forEach( function ( tab ) {
            var $content = $( '[data-group-tabs="main"][data-tab-container="' + tab + '"]' );
            $content.find( 'input, select, textarea, button' ).prop( 'disabled', false );
        } );

    }

    // After successful activation — remove locks without page reload
    $( document ).on( 'th.license.activated', function () {
        lockedTabs.forEach( function ( tab ) {
            $( '[data-group-tabs="main"][data-tab="' + tab + '"]' ).removeClass( 'th-tab-locked' ).css( 'pointer-events', '' );
            var $content = $( '[data-group-tabs="main"][data-tab-container="' + tab + '"]' );
            $content.find( '.th-lock-overlay' ).remove();
            $content.find( 'input, select, textarea, button' ).prop( 'disabled', false );
        } );
        $( '.th-save-btn' ).show();
    } );

}(jQuery));
