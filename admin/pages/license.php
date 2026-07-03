<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Pre-load saved key to render correct initial state without a JS flash
$_license_obj  = Th_Product_Compare_Pro_License::instance();
$_key_data     = $_license_obj->get_option_key();
$_saved_key    = isset( $_key_data['key'] )         ? $_key_data['key']         : '';
$_expire_date  = isset( $_key_data['expire_date'] ) ? $_key_data['expire_date'] : '';
$_has_key      = ! empty( $_saved_key );
$_is_expired   = Th_Product_Compare_Pro_License::is_expired();
$_is_active    = Th_Product_Compare_Pro_License::is_active();
$_masked_key   = $_has_key
    ? ( substr( $_saved_key, 0, 5 ) . str_repeat( '*', max( 0, strlen( $_saved_key ) - 10 ) ) . substr( $_saved_key, -5 ) )
    : '';
?>

<div class="th-license-wrap">

    <!-- Notice area -->
    <div id="th-tpcp-license-notice" style="display:none;"></div>

    <!-- Active / Expired state (key exists) -->
    <div id="th-tpcp-license-active" <?php echo $_has_key ? '' : 'style="display:none;"'; ?>>
        <div class="blocks">
            <div class="th-license-status-box">
                <span class="bold-heading"><?php esc_html_e( 'License Status', 'th-product-compare-pro' ); ?></span>
                <div class="th-license-info">
                    <div class="th-license-row">
                        <span class="th-license-label"><?php esc_html_e( 'Your License Key :', 'th-product-compare-pro' ); ?></span>
                        <span class="th-license-value">
                            <code id="th-tpcp-masked-key"><?php echo esc_html( $_masked_key ); ?></code>
                            <button id="th-tpcp-reset-btn" class="th-license-reset-btn">
                                <?php esc_html_e( 'RESET', 'th-product-compare-pro' ); ?>
                            </button>
                            <span id="th-tpcp-reset-spinner" class="spinner" style="float:none;visibility:hidden;"></span>
                        </span>
                    </div>
                    <div class="th-license-row">
                        <span class="th-license-label"><?php esc_html_e( 'License Status :', 'th-product-compare-pro' ); ?></span>
                        <span class="th-license-value">
                            <?php if ( $_is_expired ) : ?>
                                <span class="th-badge th-badge-expired"><?php esc_html_e( 'EXPIRED', 'th-product-compare-pro' ); ?></span>
                            <?php else : ?>
                                <span class="th-badge th-badge-active"><?php esc_html_e( 'ACTIVE', 'th-product-compare-pro' ); ?></span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="th-license-row">
                        <span class="th-license-label"><?php esc_html_e( 'Domain Name :', 'th-product-compare-pro' ); ?></span>
                        <span class="th-license-value"><?php echo esc_html( home_url() ); ?></span>
                    </div>
                    <?php if ( $_expire_date ) : ?>
                    <div class="th-license-row">
                        <span class="th-license-label"><?php esc_html_e( 'Valid Till :', 'th-product-compare-pro' ); ?></span>
                        <span class="th-license-value <?php echo $_is_expired ? 'th-expired-date' : ''; ?>" id="th-tpcp-expire-date">
                            <?php echo esc_html( $_expire_date ); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ( $_is_expired ) : ?>
                    <p class="th-license-expired-msg">
                        <?php esc_html_e( 'Your license has expired. Please renew to re-enable all features.', 'th-product-compare-pro' ); ?>
                        <a href="<?php echo esc_url( 'https://themehunk.com/th-product-compare-plugin/' ); ?>" target="_blank" rel="noopener noreferrer">
                            <?php esc_html_e( 'Renew License', 'th-product-compare-pro' ); ?>
                        </a>
                    </p>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Inactive state (no key at all) -->
    <div id="th-tpcp-license-inactive" <?php echo $_has_key ? 'style="display:none;"' : ''; ?>>
        <div class="blocks">
            <div class="th-license-activate-box">
                <span class="bold-heading"><?php esc_html_e( 'Activate License', 'th-product-compare-pro' ); ?></span>
                <p class="th-color-title"><?php esc_html_e( 'Enter your license key to unlock all Pro features of TH Product Compare Pro.', 'th-product-compare-pro' ); ?></p>
                <div class="th-license-input-row">
                    <input type="text"
                           id="th-tpcp-license-key-input"
                           class="regular-text"
                           placeholder="<?php esc_attr_e( 'Enter your license key', 'th-product-compare-pro' ); ?>" />
                    <button id="th-tpcp-activate-btn" class="button button-primary link_">
                        <?php esc_html_e( 'Activate', 'th-product-compare-pro' ); ?>
                    </button>
                    <span id="th-tpcp-activate-spinner" class="spinner" style="float:none;visibility:hidden;"></span>
                </div>
                <a href="<?php echo esc_url( 'https://themehunk.com/license' ); ?>" class="link_" target="_blank" rel="noopener noreferrer">
                    <?php esc_html_e( 'Find Your License Key', 'th-product-compare-pro' ); ?>
                </a>
            </div>

            <div>
                <span class="bold-heading"><?php esc_html_e( 'Get a License Key', 'th-product-compare-pro' ); ?></span>
                <p class="th-color-title"><?php esc_html_e( 'Purchase a license to get your key and activate all Pro features.', 'th-product-compare-pro' ); ?></p>
                <a href="<?php echo esc_url( 'https://themehunk.com/th-product-compare-plugin/' ); ?>" class="link_" target="_blank" rel="noopener noreferrer">
                    <?php esc_html_e( 'Buy License', 'th-product-compare-pro' ); ?>
                </a>
            </div>
        </div>
    </div>

</div><!-- .th-license-wrap -->

<style>
.th-license-wrap .th-license-info           { margin:14px 0; }
.th-license-wrap .th-license-row            { display:flex; gap:16px; margin-bottom:12px; align-items:center; }
.th-license-wrap .th-license-label          { font-weight:700; min-width:140px; color:#23282d; }
.th-license-wrap .th-license-input-row      { display:flex; gap:10px; align-items:center; margin:12px 0; }
.th-license-wrap .th-license-input-row input{ flex:1; max-width:380px; }
.th-license-wrap .th-license-notice-box     { padding:10px 15px; border-radius:4px; margin-bottom:16px; }
.th-license-wrap .th-notice-success         { background:#edfaef; border-left:4px solid #46b450; }
.th-license-wrap .th-notice-error           { background:#fdf0f0; border-left:4px solid #dc3232; }
/* Badges */
.th-badge                                   { display:inline-block; padding:4px 14px; border-radius:4px; font-weight:700; font-size:12px; letter-spacing:.5px; }
.th-badge-active                            { background:#d4edda; color:#2e7d32; border:1px solid #46b450; }
.th-badge-expired                           { background:#fdecea; color:#c62828; border:1px solid #dc3232; }
/* Reset button — matches screenshot red style */
.th-license-reset-btn                       { background:#e53935; color:#fff; border:none; border-radius:3px; padding:4px 12px; font-size:12px; font-weight:700; cursor:pointer; margin-left:10px; letter-spacing:.5px; }
.th-license-reset-btn:hover                 { background:#c62828; color:#fff; }
/* Expired date */
.th-expired-date                            { color:#c62828; font-weight:600; }
/* Expired message */
.th-license-expired-msg                     { margin-top:12px; color:#c62828; font-size:13px; }
.th-license-expired-msg a                   { margin-left:6px; font-weight:600; }
</style>

