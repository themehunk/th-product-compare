<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$icon_bg_color    = isset( $th_compare_option['icon-bg-color'] )    && $th_compare_option['icon-bg-color']    ? esc_attr( $th_compare_option['icon-bg-color'] )    : '#111827';
$icon_badge_color = isset( $th_compare_option['icon-badge-color'] ) && $th_compare_option['icon-badge-color'] ? esc_attr( $th_compare_option['icon-badge-color'] ) : '#ef4444';
$icon_svg_color   = isset( $th_compare_option['icon-svg-color'] )   && $th_compare_option['icon-svg-color']   ? esc_attr( $th_compare_option['icon-svg-color'] )   : '#ffffff';
$icon_position    = isset( $th_compare_option['icon-float-position'] ) ? $th_compare_option['icon-float-position'] : 'bottom-right';
$icon_in_menu     = isset( $th_compare_option['field-menu-icon-in-menu'] ) && $th_compare_option['field-menu-icon-in-menu'] === '1' ? 'checked="checked"' : '';

$th_footer_bar    = isset( $th_compare_option['footer-bar'] ) ? $th_compare_option['footer-bar'] : true;
$th_footer_on     = ( $th_footer_bar === '1' || $th_footer_bar === 1 || $th_footer_bar === true )  ? esc_attr('selected') : '';
$th_footer_off    = ( $th_footer_bar !== '1' && $th_footer_bar !== 1 && $th_footer_bar !== true )  ? esc_attr('selected') : '';

$th_float_icon    = isset( $th_compare_option['field-menu-icon'] ) ? $th_compare_option['field-menu-icon'] : '1';
$th_float_on      = ( $th_float_icon === '1' || $th_float_icon === 1 ) ? esc_attr('selected') : '';
$th_float_off     = ( $th_float_icon !== '1' && $th_float_icon !== 1 ) ? esc_attr('selected') : '';

$th_menu_tab      = isset( $th_compare_option['compare-menu-tab'] ) ? $th_compare_option['compare-menu-tab'] : '0';
$th_menu_tab_pos  = isset( $th_compare_option['compare-menu-tab-position'] ) ? $th_compare_option['compare-menu-tab-position'] : 'left';
$th_menu_tab_text = isset( $th_compare_option['compare-menu-tab-text'] ) ? $th_compare_option['compare-menu-tab-text'] : esc_html__( 'Compare', 'th-product-compare-pro' );
$th_tab_hidden    = $th_menu_tab !== '1' ? 'show_none' : '';

$tab_bg_color   = isset( $th_compare_option['tab-bg-color'] )   && $th_compare_option['tab-bg-color']   ? esc_attr( $th_compare_option['tab-bg-color'] )   : '#111827';
$tab_text_color = isset( $th_compare_option['tab-text-color'] ) && $th_compare_option['tab-text-color'] ? esc_attr( $th_compare_option['tab-text-color'] ) : '#ffffff';

$preview_footer_visible = ( $th_footer_bar === '1' || $th_footer_bar === 1 || $th_footer_bar === true );
$preview_float_visible  = ( $th_float_icon === '1' || $th_float_icon === 1 );
$preview_tab_visible    = ( $th_menu_tab === '1' );
?>

<div class="dummy-and-style th-ci-layout">

    <!-- ── LEFT: Settings ────────────────────── -->
    <div class="style-setting_ th-ci-settings-col">

        <div class="nav_">
            <a data-group-tabs="ci-tabs" data-tab="ci-general" href="#" class="active">
                <?php esc_html_e( 'General', 'th-product-compare-pro' ); ?>
            </a>
            <a data-group-tabs="ci-tabs" data-tab="ci-style" href="#">
                <?php esc_html_e( 'Icon Style', 'th-product-compare-pro' ); ?>
            </a>
        </div>

        <div class="container_">

            <!-- General tab -->
            <div data-group-tabs="ci-tabs" data-tab-container="ci-general" class="active">
                <table class="th-ci-table">

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Compare Footer Bar', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Show selected-products bar at the bottom of the screen.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <select data-th-save="footer-bar" id="ci-footer-bar-sel">
                                <option value="1" <?php echo $th_footer_on; ?>><?php esc_html_e( 'Enable', 'th-product-compare-pro' ); ?></option>
                                <option value="0" <?php echo $th_footer_off; ?>><?php esc_html_e( 'Disable', 'th-product-compare-pro' ); ?></option>
                            </select>
                            <i class="description"><?php esc_html_e( 'When enabled, shows the compare footer bar with selected products.', 'th-product-compare-pro' ); ?></i>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Compare Floating Icon', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Show the floating compare icon at a screen corner.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <select data-th-save="field-menu-icon" id="ci-float-icon-sel">
                                <option value="1"    <?php echo $th_float_on;  ?>><?php esc_html_e( 'Enable',  'th-product-compare-pro' ); ?></option>
                                <option value="hide" <?php echo $th_float_off; ?>><?php esc_html_e( 'Disable', 'th-product-compare-pro' ); ?></option>
                            </select>
                            <i class="description"><?php esc_html_e( 'When enabled, shows a floating icon button to open the compare popup.', 'th-product-compare-pro' ); ?></i>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Floating Icon Position', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Choose which corner the floating icon appears in.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <select data-th-save="icon-float-position" id="ci-float-pos-sel">
                                <option value="bottom-right" <?php echo $icon_position === 'bottom-right' ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Bottom Right', 'th-product-compare-pro' ); ?></option>
                                <option value="bottom-left"  <?php echo $icon_position === 'bottom-left'  ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Bottom Left',  'th-product-compare-pro' ); ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Compare Menu Sidebar Tab (Pro)', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Show a fixed sidebar tab button to open the compare popup.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <select data-change-showhide="ci-menu-tab-group" data-th-save="compare-menu-tab" id="ci-sidebar-tab-sel">
                                <option value="0" <?php echo $th_menu_tab !== '1' ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Disable', 'th-product-compare-pro' ); ?></option>
                                <option value="1" <?php echo $th_menu_tab === '1' ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Enable',  'th-product-compare-pro' ); ?></option>
                            </select>
                            <i class="description"><?php esc_html_e( 'A floating tab appears on the side of the screen to open the compare popup.', 'th-product-compare-pro' ); ?></i>
                        </td>
                    </tr>

                    <tr data-change-showhide-tab="ci-menu-tab-group" data-show="1" class="<?php echo esc_attr( $th_tab_hidden ); ?>">
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Sidebar Tab Position (Pro)', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Which side of the screen the tab should appear on.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <select data-th-save="compare-menu-tab-position" id="ci-tab-pos-sel">
                                <option value="left"  <?php echo $th_menu_tab_pos === 'left'  ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Left',  'th-product-compare-pro' ); ?></option>
                                <option value="right" <?php echo $th_menu_tab_pos === 'right' ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Right', 'th-product-compare-pro' ); ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr data-change-showhide-tab="ci-menu-tab-group" data-show="1" class="<?php echo esc_attr( $th_tab_hidden ); ?>">
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Sidebar Tab Label (Pro)', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Text displayed on the sidebar tab.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <input data-th-save="compare-menu-tab-text" type="text" id="ci-tab-label-inp"
                                   placeholder="<?php esc_attr_e( 'Compare', 'th-product-compare-pro' ); ?>"
                                   value="<?php echo esc_attr( $th_menu_tab_text ); ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Show Compare Icon in Menu', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Append the compare icon to the primary navigation menu.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <div class="th-compare-radio">
                                <input type="checkbox"
                                       data-th-save="compare-field"
                                       id="compare-menu-icon-in-menu"
                                       <?php echo esc_html( $icon_in_menu ); ?>
                                       value="menu-icon-in-menu">
                                <label class="th-color-title" for="compare-menu-icon-in-menu">
                                    <?php esc_html_e( 'Show in navigation menu', 'th-product-compare-pro' ); ?>
                                </label>
                            </div>
                            <i class="description"><?php esc_html_e( 'When enabled, the compare icon is added to the primary WordPress navigation menu.', 'th-product-compare-pro' ); ?></i>
                        </td>
                    </tr>

                </table>
            </div><!-- /ci-general -->

            <!-- Icon Style tab -->
            <div data-group-tabs="ci-tabs" data-tab-container="ci-style">
                <table class="th-ci-table">

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Icon Background Color', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Background color of the circular icon button.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <div class="th-color-picker-wrap">
                                <input type="color"
                                       data-th-save="icon-bg-color"
                                       data-ci-target="ci-prev-icon"
                                       data-ci-prop="background"
                                       value="<?php echo esc_attr( $icon_bg_color ); ?>"
                                       class="th-color-input th-ci-cp">
                                <span class="th-color-hex"><?php echo esc_html( $icon_bg_color ); ?></span>
                                <button type="button" class="th-color-reset th-ci-reset"
                                        data-default="#111827"
                                        data-ci-target="ci-prev-icon"
                                        data-ci-prop="background"
                                        data-save="icon-bg-color">&#8635;</button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Icon Color', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Color of the compare icon SVG stroke.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <div class="th-color-picker-wrap">
                                <input type="color"
                                       data-th-save="icon-svg-color"
                                       data-ci-target="ci-prev-icon"
                                       data-ci-prop="color"
                                       value="<?php echo esc_attr( $icon_svg_color ); ?>"
                                       class="th-color-input th-ci-cp">
                                <span class="th-color-hex"><?php echo esc_html( $icon_svg_color ); ?></span>
                                <button type="button" class="th-color-reset th-ci-reset"
                                        data-default="#ffffff"
                                        data-ci-target="ci-prev-icon"
                                        data-ci-prop="color"
                                        data-save="icon-svg-color">&#8635;</button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Badge Color', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Background color of the count badge.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <div class="th-color-picker-wrap">
                                <input type="color"
                                       data-th-save="icon-badge-color"
                                       data-ci-target="ci-prev-badge"
                                       data-ci-prop="background"
                                       value="<?php echo esc_attr( $icon_badge_color ); ?>"
                                       class="th-color-input th-ci-cp">
                                <span class="th-color-hex"><?php echo esc_html( $icon_badge_color ); ?></span>
                                <button type="button" class="th-color-reset th-ci-reset"
                                        data-default="#ef4444"
                                        data-ci-target="ci-prev-badge"
                                        data-ci-prop="background"
                                        data-save="icon-badge-color">&#8635;</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Sidebar Tab Background Color -->
                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Sidebar Tab Background', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Background color of the sidebar tab button.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <div class="th-color-picker-wrap">
                                <input type="color"
                                       data-th-save="tab-bg-color"
                                       data-ci-target="ci-prev-sidebar-tab"
                                       data-ci-prop="background"
                                       value="<?php echo esc_attr( $tab_bg_color ); ?>"
                                       class="th-color-input th-ci-cp">
                                <span class="th-color-hex"><?php echo esc_html( $tab_bg_color ); ?></span>
                                <button type="button" class="th-color-reset th-ci-reset"
                                        data-default="#111827"
                                        data-ci-target="ci-prev-sidebar-tab"
                                        data-ci-prop="background"
                                        data-save="tab-bg-color">&#8635;</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Sidebar Tab Text Color -->
                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Sidebar Tab Text Color', 'th-product-compare-pro' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Text color of the sidebar tab label.', 'th-product-compare-pro' ); ?></span>
                        </td>
                        <td>
                            <div class="th-color-picker-wrap">
                                <input type="color"
                                       data-th-save="tab-text-color"
                                       data-ci-target="ci-prev-sidebar-tab"
                                       data-ci-prop="color"
                                       value="<?php echo esc_attr( $tab_text_color ); ?>"
                                       class="th-color-input th-ci-cp">
                                <span class="th-color-hex"><?php echo esc_html( $tab_text_color ); ?></span>
                                <button type="button" class="th-color-reset th-ci-reset"
                                        data-default="#ffffff"
                                        data-ci-target="ci-prev-sidebar-tab"
                                        data-ci-prop="color"
                                        data-save="tab-text-color">&#8635;</button>
                            </div>
                        </td>
                    </tr>

                </table>
            </div><!-- /ci-style -->

        </div><!-- /.container_ -->
    </div><!-- /.th-ci-settings-col -->


    <!-- ── RIGHT: Desktop Preview ────────────── -->
    <div class="th-compare-popup-dummy th-ci-preview-col">

        <div class="thpreviewbox th-ci-previewbox">

            <div class="th-ci-browser-frame">

                <!-- Browser chrome -->
                <div class="preview-top-header th-ci-browser-bar">
                    <span></span><span></span><span></span>
                    <div class="th-ci-browser-url">
                        <span class="th-ci-url-dot"></span>
                        <span class="th-ci-url-text">yoursite.com/shop</span>
                    </div>
                </div>

                <!-- Viewport -->
                <div class="th-ci-viewport">

                    <!-- Sidebar tab -->
                    <div id="ci-prev-sidebar-tab"
                         class="th-ci-sidebar-tab th-ci-tab-<?php echo esc_attr( $th_menu_tab_pos ); ?><?php echo $preview_tab_visible ? '' : ' th-ci-hidden'; ?>"
                         style="background:<?php echo esc_attr( $tab_bg_color ); ?>; color:<?php echo esc_attr( $tab_text_color ); ?>;">
                        <span id="ci-prev-tab-text"><?php echo esc_html( $th_menu_tab_text ); ?></span>
                    </div>

                    <!-- Mock page content -->
                    <div class="th-ci-page-mock">
                        <div class="th-ci-mock-nav">
                            <span class="th-ci-mock-logo"></span>
                            <div class="th-ci-mock-nav-links">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                        <div class="th-ci-mock-grid">
                            <div class="th-ci-mock-card">
                                <div class="th-ci-mock-img"></div>
                                <div class="th-ci-mock-title"></div>
                                <div class="th-ci-mock-price"></div>
                                <div class="th-ci-mock-btn"></div>
                            </div>
                            <div class="th-ci-mock-card">
                                <div class="th-ci-mock-img"></div>
                                <div class="th-ci-mock-title"></div>
                                <div class="th-ci-mock-price"></div>
                                <div class="th-ci-mock-btn"></div>
                            </div>
                            <div class="th-ci-mock-card">
                                <div class="th-ci-mock-img"></div>
                                <div class="th-ci-mock-title"></div>
                                <div class="th-ci-mock-price"></div>
                                <div class="th-ci-mock-btn"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating icon -->
                    <div id="ci-prev-float-wrap"
                         class="th-ci-float-wrap th-ci-float-<?php echo esc_attr( $icon_position ); ?><?php echo $preview_float_visible ? '' : ' th-ci-hidden'; ?>">
                        <div id="ci-prev-icon" class="th-ci-float-icon"
                             style="background:<?php echo esc_attr( $icon_bg_color ); ?>; color:<?php echo esc_attr( $icon_svg_color ); ?>;">
                            <span id="ci-prev-badge" class="th-ci-badge"
                                  style="background:<?php echo esc_attr( $icon_badge_color ); ?>;">2</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path>
                                <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>
                                <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Footer bar -->
                    <div id="ci-prev-footer"
                         class="th-ci-footer-bar<?php echo $preview_footer_visible ? '' : ' th-ci-hidden'; ?>">
                        <div class="th-ci-footer-left">
                            <div class="th-ci-footer-imgs">
                                <span class="th-ci-footer-img"></span>
                                <span class="th-ci-footer-img"></span>
                            </div>
                            <span class="th-ci-footer-sep">2/8</span>
                        </div>
                        <div class="th-ci-footer-right">
                            <a href="#" class="th-ci-footer-cta">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path>
                                    <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>
                                    <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>
                                </svg>
                                <?php esc_html_e( 'Compare', 'th-product-compare-pro' ); ?>
                            </a>
                        </div>
                    </div>

                </div><!-- /.th-ci-viewport -->
            </div><!-- /.th-ci-browser-frame -->

            <p class="th-compare-icon-preview-label"><?php esc_html_e( 'Live Preview', 'th-product-compare-pro' ); ?></p>

        </div><!-- /.thpreviewbox -->

        <!-- Shortcode box -->
        <div class="th-shortcode-box">
            <div class="th-shortcode-header">
                <span class="th-shortcode-icon">&#9663;</span>
                <strong><?php esc_html_e( 'Place Icon via Shortcode', 'th-product-compare-pro' ); ?></strong>
            </div>
            <p class="th-shortcode-text">
                <?php esc_html_e( 'Use this shortcode to place the compare icon anywhere — pages, widgets, Gutenberg blocks, or Elementor text areas:', 'th-product-compare-pro' ); ?>
            </p>
            <div class="th-shortcode-code">
                <code id="th-copy-icon-shortcode">[th_compare_icon]</code>
                <button type="button" class="th-copy-btn" data-copy-target="th-copy-icon-shortcode">
                    <?php esc_html_e( 'Copy', 'th-product-compare-pro' ); ?>
                </button>
            </div>
        </div>

        <!-- PHP template tag box -->
        <div class="th-shortcode-box">
            <div class="th-shortcode-header">
                <span class="th-shortcode-icon">&#60;&#47;&#62;</span>
                <strong><?php esc_html_e( 'Place Icon in Theme PHP Files', 'th-product-compare-pro' ); ?></strong>
            </div>
            <p class="th-shortcode-text">
                <?php esc_html_e( 'Add the compare icon directly inside any theme template file (header.php, child theme, etc.):', 'th-product-compare-pro' ); ?>
            </p>
            <div class="th-shortcode-code">
                <code id="th-copy-icon-php">&lt;?php th_compare_menu_icon(); ?&gt;</code>
                <button type="button" class="th-copy-btn" data-copy-target="th-copy-icon-php">
                    <?php esc_html_e( 'Copy', 'th-product-compare-pro' ); ?>
                </button>
            </div>
            <p class="th-shortcode-note">
                <?php esc_html_e( '* To capture as a string: $icon = th_compare_menu_icon( false );', 'th-product-compare-pro' ); ?>
            </p>
        </div>

    </div><!-- /.th-ci-preview-col -->

</div><!-- /.dummy-and-style -->


<style>
/* ── Layout ──────────────────────────────────────── */
.th-ci-layout.dummy-and-style { align-items: flex-start; gap: 18px; }
.th-ci-layout .th-ci-settings-col { width: 38%; min-width: 280px; }
.th-ci-layout .th-ci-preview-col  { width: 60%; }

/* table inside settings */
.th-ci-table { width: 100%; border-collapse: collapse; }
.th-ci-table tr {
    display: flex;
    padding: 18px 0;
    border-bottom: 1px solid #f1f5f9;
    gap: 12px;
}
.th-ci-table tr:last-child { border-bottom: none; }
.th-ci-table td { flex: 1; line-height: 1.4; }
.th-ci-table td:first-child {
    flex: 0 0 150px;
    font-size: 0.8rem;
    color: #444;
}

/* Color picker row */
.th-color-picker-wrap { display: flex; align-items: center; gap: 8px; }
.th-color-input {
    width: 38px; height: 30px; padding: 2px 3px;
    border: 1px solid #cbd5e1; border-radius: 6px;
    cursor: pointer; background: #fff;
}
.th-color-hex { font-size: 12px; color: #475569; font-family: monospace; min-width: 56px; }
.th-color-reset {
    background: none; border: 1px solid #cbd5e1; border-radius: 5px;
    padding: 3px 7px; cursor: pointer; font-size: 14px; color: #64748b; line-height: 1;
}
.th-color-reset:hover { background: #f1f5f9; }

/* ── Browser preview box ─────────────────────────── */
.th-ci-previewbox {
    padding: 0 !important;
    background: #e8edf3;
    border-radius: 12px;
    border: 2px solid #cbd5e1;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
}
.th-ci-browser-frame {
    display: flex;
    flex-direction: column;
    overflow: hidden;        /* clip everything inside the frame */
    border-radius: 10px;
}
.th-ci-browser-bar {
    display: flex !important;
    align-items: center;
    background: #dde3ec;
    padding: 9px 14px;
    gap: 6px;
    flex-shrink: 0;
    border-bottom: 1px solid #c8d0dc;
}
.th-ci-browser-bar > span {
    width: 10px; height: 10px; border-radius: 50%; display: inline-block;
}
.th-ci-browser-bar > span:nth-child(1) { background: #f87171; }
.th-ci-browser-bar > span:nth-child(2) { background: #fb923c; }
.th-ci-browser-bar > span:nth-child(3) { background: #4ade80; }
.th-ci-browser-url {
    flex: 1; background: #fff; border-radius: 20px; padding: 4px 12px;
    display: flex; align-items: center; gap: 6px; margin-left: 8px;
    font-size: 11px; color: #94a3b8; overflow: hidden;
}
.th-ci-url-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #4ade80; flex-shrink: 0;
}
.th-ci-url-text { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* ── Viewport — THIS is the clipping box ─────────── */
.th-ci-viewport {
    position: relative !important;  /* anchor for all absolute children */
    height: 300px;
    background: #fff;
    overflow: hidden !important;    /* hard-clip everything that overflows */
}

/* ── Mock page ───────────────────────────────────── */
.th-ci-mock-nav {
    display: flex; align-items: center; justify-content: space-between;
    background: #fff; padding: 10px 16px;
    border-bottom: 1px solid #f1f5f9;
}
.th-ci-mock-logo { width: 54px; height: 12px; background: #e2e8f0; border-radius: 4px; }
.th-ci-mock-nav-links { display: flex; gap: 10px; }
.th-ci-mock-nav-links span { width: 28px; height: 9px; background: #e2e8f0; border-radius: 3px; }
.th-ci-mock-grid { display: flex; gap: 10px; padding: 14px; }
.th-ci-mock-card {
    flex: 1; background: #f8fafc; border-radius: 8px;
    border: 1px solid #e2e8f0; padding: 10px;
    display: flex; flex-direction: column; gap: 7px;
}
.th-ci-mock-img   { height: 60px; background: #e2e8f0; border-radius: 5px; }
.th-ci-mock-title { height: 9px;  background: #cbd5e1; border-radius: 3px; width: 70%; }
.th-ci-mock-price { height: 9px;  background: #cbd5e1; border-radius: 3px; width: 40%; }
.th-ci-mock-btn   { height: 20px; background: #4f46e5; border-radius: 4px; margin-top: 4px; }

/* ── Floating icon ───────────────────────────────── */
.th-ci-float-wrap {
    position: absolute;
    z-index: 10;
}
/* 52px clears the 46px footer bar + 6px gap */
.th-ci-float-bottom-right { bottom: 52px; right: 10px; }
.th-ci-float-bottom-left  { bottom: 52px; left:  10px; }
.th-ci-float-icon {
    position: relative;
    width: 38px; height: 38px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 3px 10px rgba(0,0,0,.28);
    transition: background .15s, color .15s;
    cursor: pointer;
}
.th-ci-badge {
    position: absolute; top: -4px; right: -4px;
    color: #fff; border-radius: 50%; min-width: 15px; height: 15px;
    font-size: 8px; font-weight: 700; display: flex; align-items: center;
    justify-content: center; padding: 1px 3px; border: 2px solid #fff;
    box-sizing: border-box; transition: background .15s;
}

/* ── Sidebar tab  (writing-mode avoids rotation overflow) ── */
.th-ci-sidebar-tab {
    position: absolute;
    top: 50%;
    z-index: 10;
    background: #111827;
    color: #fff;
    font-size: 9px;
    font-weight: 600;
    padding: 10px 6px;
    cursor: pointer;
    letter-spacing: 0.5px;
    writing-mode: vertical-lr;  /* vertical text, no rotation transform needed */
    transform: translateY(-50%);
    line-height: 1;
}
/* Left: text reads bottom-to-top; tab sits flush on the left edge.
   rotate(180deg) swaps corners visually, so physical TL/BL must carry
   the radius so the visual right (page-facing) side ends up rounded. */
.th-ci-tab-left {
    left: 0;
    border-radius: 4px 0 0 4px;
    transform: translateY(-50%) rotate(180deg);
}
/* Right: text reads top-to-bottom; tab sits flush on the right edge */
.th-ci-tab-right {
    right: 0;
    border-radius: 4px 0 0 4px;
    transform: translateY(-50%);
}

/* ── Footer bar ──────────────────────────────────── */
.th-ci-footer-bar {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: #1e293b; color: #fff;
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 6px 12px; height: 44px;
    z-index: 5;
}
.th-ci-footer-left  { display: flex; align-items: center; gap: 8px; }
.th-ci-footer-imgs  { display: flex; gap: 4px; }
.th-ci-footer-img {
    width: 26px; height: 26px; background: #334155;
    border-radius: 4px; border: 1px solid #475569; display: block;
}
.th-ci-footer-sep { font-size: 10px; color: #94a3b8; }
.th-ci-footer-cta {
    display: flex; align-items: center; gap: 5px;
    background: #4f46e5; color: #fff; text-decoration: none;
    padding: 4px 9px; border-radius: 5px; font-size: 9px; font-weight: 600;
}

/* ── Hidden state ────────────────────────────────── */
.th-ci-hidden { display: none !important; }

/* ── Preview label ───────────────────────────────── */
.th-compare-icon-preview-label {
    text-align: center; font-size: 12px; color: #64748b;
    margin: 8px 0 4px; padding-bottom: 4px;
}
</style>

<script>
(function () {
    /* ── Color pickers ────────────────────────── */
    document.querySelectorAll('.th-ci-cp').forEach(function (inp) {
        var hexLabel  = inp.parentNode.querySelector('.th-color-hex');
        var targetEl  = document.getElementById(inp.dataset.ciTarget);
        var prop      = inp.dataset.ciProp;
        inp.addEventListener('input', function () {
            if (targetEl) targetEl.style[prop] = this.value;
            if (hexLabel)  hexLabel.textContent  = this.value;
        });
    });

    document.querySelectorAll('.th-ci-reset').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var def      = this.dataset.default;
            var targetEl = document.getElementById(this.dataset.ciTarget);
            var prop     = this.dataset.ciProp;
            var saveKey  = this.dataset.save;
            if (targetEl) targetEl.style[prop] = def;
            var inp = document.querySelector('[data-th-save="' + saveKey + '"].th-ci-cp');
            if (inp) {
                inp.value = def;
                var hex = inp.parentNode.querySelector('.th-color-hex');
                if (hex) hex.textContent = def;
            }
        });
    });

    /* ── Footer bar toggle ────────────────────── */
    var footerSel = document.getElementById('ci-footer-bar-sel');
    var footerPrev = document.getElementById('ci-prev-footer');
    if (footerSel && footerPrev) {
        footerSel.addEventListener('change', function () {
            footerPrev.classList.toggle('th-ci-hidden', this.value !== '1');
        });
    }

    /* ── Floating icon toggle ─────────────────── */
    var floatSel  = document.getElementById('ci-float-icon-sel');
    var floatWrap = document.getElementById('ci-prev-float-wrap');
    if (floatSel && floatWrap) {
        floatSel.addEventListener('change', function () {
            floatWrap.classList.toggle('th-ci-hidden', this.value !== '1');
        });
    }

    /* ── Floating icon position ───────────────── */
    var floatPosSel = document.getElementById('ci-float-pos-sel');
    if (floatPosSel && floatWrap) {
        floatPosSel.addEventListener('change', function () {
            floatWrap.classList.remove('th-ci-float-bottom-right', 'th-ci-float-bottom-left');
            floatWrap.classList.add('th-ci-float-' + this.value);
        });
    }

    /* ── Sidebar tab toggle ───────────────────── */
    var tabSel  = document.getElementById('ci-sidebar-tab-sel');
    var tabPrev = document.getElementById('ci-prev-sidebar-tab');
    if (tabSel && tabPrev) {
        tabSel.addEventListener('change', function () {
            tabPrev.classList.toggle('th-ci-hidden', this.value !== '1');
        });
    }

    /* ── Sidebar tab position ─────────────────── */
    var tabPosSel = document.getElementById('ci-tab-pos-sel');
    if (tabPosSel && tabPrev) {
        tabPosSel.addEventListener('change', function () {
            tabPrev.classList.remove('th-ci-tab-left', 'th-ci-tab-right');
            tabPrev.classList.add('th-ci-tab-' + this.value);
        });
    }

    /* ── Sidebar tab label ────────────────────── */
    var tabLabelInp  = document.getElementById('ci-tab-label-inp');
    var tabLabelPrev = document.getElementById('ci-prev-tab-text');
    if (tabLabelInp && tabLabelPrev) {
        tabLabelInp.addEventListener('input', function () {
            tabLabelPrev.textContent = this.value || 'Compare';
        });
    }
})();
</script>
