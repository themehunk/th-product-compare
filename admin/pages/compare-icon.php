<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$icon_enabled   = isset( $th_compare_option['field-menu-icon'] )   ? $th_compare_option['field-menu-icon']   : '1';
$icon_checked   = ( $icon_enabled === '1' ) ? 'checked="checked"' : '';

$icon_bg_color    = isset( $th_compare_option['icon-bg-color'] )    && $th_compare_option['icon-bg-color']    ? esc_attr( $th_compare_option['icon-bg-color'] )    : '#111827';
$icon_badge_color = isset( $th_compare_option['icon-badge-color'] ) && $th_compare_option['icon-badge-color'] ? esc_attr( $th_compare_option['icon-badge-color'] ) : '#ef4444';
$icon_svg_color   = isset( $th_compare_option['icon-svg-color'] )   && $th_compare_option['icon-svg-color']   ? esc_attr( $th_compare_option['icon-svg-color'] )   : '#ffffff';
?>

<div class="th-general">
    <div class="th-option_">
        <span class="th-tab-heading"><?php esc_html_e( 'Compare Menu Icon', 'th-product-compare' ); ?></span>

        <!-- Live preview -->
        <div class="th-compare-icon-preview-wrap">
            <div class="th-compare-icon-preview-box">
                <div class="th-compare-icon-demo" id="th-icon-demo-circle"
                     style="background:<?php echo esc_attr( $icon_bg_color ); ?>; color:<?php echo esc_attr( $icon_svg_color ); ?>;">
                    <span class="th-compare-icon-demo-badge" id="th-icon-demo-badge"
                          style="background:<?php echo esc_attr( $icon_badge_color ); ?>;">2</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path>
                        <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>
                        <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>
                    </svg>
                </div>
                <p class="th-compare-icon-preview-label"><?php esc_html_e( 'Live Preview', 'th-product-compare' ); ?></p>
            </div>
        </div>

        <table>

            <!-- Enable toggle for shortcode / template tag -->
            <tr>
                <td>
                    <span class="th-color-title"><?php esc_html_e( 'Enable Compare Icon', 'th-product-compare' ); ?></span>
                    <span class="th-alt-title"><?php esc_html_e( 'Enable the compare icon for the shortcode [th_compare_icon] and the PHP template tag th_compare_menu_icon().', 'th-product-compare' ); ?></span>
                </td>
                <td>
                    <div class="th-compare-radio">
                        <input type="checkbox"
                               data-th-save="compare-field"
                               id="compare-menu-icon-toggle"
                               <?php echo esc_html( $icon_checked ); ?>
                               value="menu-icon">
                        <label class="th-color-title" for="compare-menu-icon-toggle">
                            <?php esc_html_e( 'Show compare icon', 'th-product-compare' ); ?>
                        </label>
                    </div>
                </td>
            </tr>

            <!-- Icon background color -->
            <tr>
                <td>
                    <span class="th-color-title"><?php esc_html_e( 'Icon Background Color', 'th-product-compare' ); ?></span>
                    <span class="th-alt-title"><?php esc_html_e( 'Background color of the circular icon button.', 'th-product-compare' ); ?></span>
                </td>
                <td>
                    <div class="th-color-picker-wrap">
                        <input type="color"
                               data-th-save="icon-bg-color"
                               data-preview="th-icon-demo-circle"
                               data-preview-prop="background"
                               value="<?php echo esc_attr( $icon_bg_color ); ?>"
                               class="th-color-input">
                        <span class="th-color-hex"><?php echo esc_html( $icon_bg_color ); ?></span>
                        <button type="button" class="th-color-reset" data-default="#111827"
                                data-preview="th-icon-demo-circle" data-preview-prop="background"
                                data-save="icon-bg-color">&#8635;</button>
                    </div>
                </td>
            </tr>

            <!-- Icon SVG / stroke color -->
            <tr>
                <td>
                    <span class="th-color-title"><?php esc_html_e( 'Icon Color', 'th-product-compare' ); ?></span>
                    <span class="th-alt-title"><?php esc_html_e( 'Color of the compare icon SVG (stroke color).', 'th-product-compare' ); ?></span>
                </td>
                <td>
                    <div class="th-color-picker-wrap">
                        <input type="color"
                               data-th-save="icon-svg-color"
                               data-preview="th-icon-demo-circle"
                               data-preview-prop="color"
                               value="<?php echo esc_attr( $icon_svg_color ); ?>"
                               class="th-color-input">
                        <span class="th-color-hex"><?php echo esc_html( $icon_svg_color ); ?></span>
                        <button type="button" class="th-color-reset" data-default="#ffffff"
                                data-preview="th-icon-demo-circle" data-preview-prop="color"
                                data-save="icon-svg-color">&#8635;</button>
                    </div>
                </td>
            </tr>

            <!-- Badge color -->
            <tr>
                <td>
                    <span class="th-color-title"><?php esc_html_e( 'Badge Color', 'th-product-compare' ); ?></span>
                    <span class="th-alt-title"><?php esc_html_e( 'Background color of the count badge.', 'th-product-compare' ); ?></span>
                </td>
                <td>
                    <div class="th-color-picker-wrap">
                        <input type="color"
                               data-th-save="icon-badge-color"
                               data-preview="th-icon-demo-badge"
                               data-preview-prop="background"
                               value="<?php echo esc_attr( $icon_badge_color ); ?>"
                               class="th-color-input">
                        <span class="th-color-hex"><?php echo esc_html( $icon_badge_color ); ?></span>
                        <button type="button" class="th-color-reset" data-default="#ef4444"
                                data-preview="th-icon-demo-badge" data-preview-prop="background"
                                data-save="icon-badge-color">&#8635;</button>
                    </div>
                </td>
            </tr>

            <!-- How it works -->
            <tr>
                <td>
                    <span class="th-color-title"><?php esc_html_e( 'How It Works', 'th-product-compare' ); ?></span>
                </td>
                <td>
                    <ul class="th-compare-icon-how-list">
                        <li><?php esc_html_e( '1. Add products to compare using the Compare button.', 'th-product-compare' ); ?></li>
                        <li><?php esc_html_e( '2. The floating icon appears with a count badge.', 'th-product-compare' ); ?></li>
                        <li><?php esc_html_e( '3. Click the icon to open or close the compare popup.', 'th-product-compare' ); ?></li>
                    </ul>
                </td>
            </tr>

        </table>
    </div>
</div><!-- .th-general -->

<!-- Shortcode box -->
<div class="th-shortcode-box">
    <div class="th-shortcode-header">
        <span class="th-shortcode-icon">&#9663;</span>
        <strong><?php esc_html_e( 'Place Icon via Shortcode', 'th-product-compare' ); ?></strong>
    </div>
    <p class="th-shortcode-text">
        <?php esc_html_e( 'Use this shortcode to place the compare icon anywhere — pages, widgets, Gutenberg blocks, or Elementor text areas:', 'th-product-compare' ); ?>
    </p>
    <div class="th-shortcode-code">
        <code id="th-copy-icon-shortcode">[th_compare_icon]</code>
        <button type="button" class="th-copy-btn" data-copy-target="th-copy-icon-shortcode">
            <?php esc_html_e( 'Copy', 'th-product-compare' ); ?>
        </button>
    </div>
</div>

<!-- PHP template tag box -->
<div class="th-shortcode-box">
    <div class="th-shortcode-header">
        <span class="th-shortcode-icon">&#60;&#47;&#62;</span>
        <strong><?php esc_html_e( 'Place Icon in Theme PHP Files', 'th-product-compare' ); ?></strong>
    </div>
    <p class="th-shortcode-text">
        <?php esc_html_e( 'Add the compare icon directly inside any theme template file (header.php, child theme, etc.):', 'th-product-compare' ); ?>
    </p>
    <div class="th-shortcode-code">
        <code id="th-copy-icon-php">&lt;?php th_compare_menu_icon(); ?&gt;</code>
        <button type="button" class="th-copy-btn" data-copy-target="th-copy-icon-php">
            <?php esc_html_e( 'Copy', 'th-product-compare' ); ?>
        </button>
    </div>
    <p class="th-shortcode-note">
        <?php esc_html_e( '* To capture as a string: $icon = th_compare_menu_icon( false );', 'th-product-compare' ); ?>
    </p>
</div>

<style>
/* Preview */
.th-compare-icon-preview-wrap { padding: 20px 0 10px; }
.th-compare-icon-preview-box  { display: inline-flex; flex-direction: column; align-items: center; gap: 8px; }
.th-compare-icon-demo {
    position: relative; width: 52px; height: 52px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.25); transition: background .15s, color .15s;
}
.th-compare-icon-demo-badge {
    position: absolute; top: -5px; right: -5px;
    color: #fff; border-radius: 50%; min-width: 20px; height: 20px;
    font-size: 11px; font-weight: 700; display: flex; align-items: center;
    justify-content: center; padding: 2px 4px; border: 2px solid #fff;
    box-sizing: border-box; transition: background .15s;
}
.th-compare-icon-preview-label { font-size: 12px; color: #64748b; margin: 0; text-align: center; }

/* Color picker row */
.th-color-picker-wrap {
    display: flex; align-items: center; gap: 10px;
}
.th-color-input {
    width: 44px; height: 34px; padding: 2px 3px;
    border: 1px solid #cbd5e1; border-radius: 6px;
    cursor: pointer; background: #fff;
}
.th-color-hex {
    font-size: 13px; color: #475569;
    font-family: monospace; min-width: 62px;
}
.th-color-reset {
    background: none; border: 1px solid #cbd5e1; border-radius: 5px;
    padding: 4px 8px; cursor: pointer; font-size: 15px; color: #64748b;
    line-height: 1;
}
.th-color-reset:hover { background: #f1f5f9; }

/* How-it-works list */
.th-compare-icon-how-list { list-style: none; padding: 0; margin: 0; }
.th-compare-icon-how-list li { font-size: 13px; color: #475569; padding: 4px 0; line-height: 1.5; }
</style>

<script>
(function () {
    document.querySelectorAll('.th-color-input').forEach(function (input) {
        var hexLabel  = input.parentNode.querySelector('.th-color-hex');
        var previewEl = document.getElementById(input.dataset.preview);
        var prop      = input.dataset.previewProp;

        // Live update on every change
        input.addEventListener('input', function () {
            if (previewEl) previewEl.style[prop] = this.value;
            if (hexLabel)  hexLabel.textContent   = this.value;
        });
    });

    document.querySelectorAll('.th-color-reset').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var def       = this.dataset.default;
            var previewEl = document.getElementById(this.dataset.preview);
            var prop      = this.dataset.previewProp;
            var saveKey   = this.dataset.save;

            // Reset preview
            if (previewEl) previewEl.style[prop] = def;

            // Reset input value + hex label
            var input = document.querySelector('[data-th-save="' + saveKey + '"]');
            if (input) {
                input.value = def;
                var hexLabel = input.parentNode.querySelector('.th-color-hex');
                if (hexLabel) hexLabel.textContent = def;
            }
        });
    });
})();
</script>
