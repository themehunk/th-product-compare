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
$th_menu_tab_text = isset( $th_compare_option['compare-menu-tab-text'] ) ? $th_compare_option['compare-menu-tab-text'] : esc_html__( 'Compare', 'th-product-compare' );
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
                <?php esc_html_e( 'General', 'th-product-compare' ); ?>
            </a>
            <a data-group-tabs="ci-tabs" data-tab="ci-style" href="#">
                <?php esc_html_e( 'Icon Style', 'th-product-compare' ); ?>
            </a>
        </div>

        <div class="container_">

            <!-- General tab -->
            <div data-group-tabs="ci-tabs" data-tab-container="ci-general" class="active">
                <table class="th-ci-table">

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Compare Footer Bar', 'th-product-compare' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Show selected-products bar at the bottom of the screen.', 'th-product-compare' ); ?></span>
                        </td>
                        <td>
                            <select data-th-save="footer-bar" id="ci-footer-bar-sel">
                                <option value="1" <?php echo $th_footer_on; ?>><?php esc_html_e( 'Enable', 'th-product-compare' ); ?></option>
                                <option value="0" <?php echo $th_footer_off; ?>><?php esc_html_e( 'Disable', 'th-product-compare' ); ?></option>
                            </select>
                            <i class="description"><?php esc_html_e( 'When enabled, shows the compare footer bar with selected products.', 'th-product-compare' ); ?></i>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Compare Floating Icon', 'th-product-compare' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Show the floating compare icon at a screen corner.', 'th-product-compare' ); ?></span>
                        </td>
                        <td>
                            <select data-th-save="field-menu-icon" id="ci-float-icon-sel">
                                <option value="1"    <?php echo $th_float_on;  ?>><?php esc_html_e( 'Enable',  'th-product-compare' ); ?></option>
                                <option value="hide" <?php echo $th_float_off; ?>><?php esc_html_e( 'Disable', 'th-product-compare' ); ?></option>
                            </select>
                            <i class="description"><?php esc_html_e( 'When enabled, shows a floating icon button to open the compare popup.', 'th-product-compare' ); ?></i>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Floating Icon Position', 'th-product-compare' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Choose which corner the floating icon appears in.', 'th-product-compare' ); ?></span>
                        </td>
                        <td>
                            <select data-th-save="icon-float-position" id="ci-float-pos-sel">
                                <option value="bottom-right" <?php echo $icon_position === 'bottom-right' ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Bottom Right', 'th-product-compare' ); ?></option>
                                <option value="bottom-left"  <?php echo $icon_position === 'bottom-left'  ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Bottom Left',  'th-product-compare' ); ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Compare Menu Sidebar Tab (Pro)', 'th-product-compare' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Show a fixed sidebar tab button to open the compare popup.', 'th-product-compare' ); ?></span>
                        </td>
                        <td>
                            <select data-change-showhide="ci-menu-tab-group" data-th-save="compare-menu-tab" id="ci-sidebar-tab-sel">
                                <option value="0" <?php echo $th_menu_tab !== '1' ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Disable', 'th-product-compare' ); ?></option>
                                <option value="1" <?php echo $th_menu_tab === '1' ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Enable',  'th-product-compare' ); ?></option>
                            </select>
                            <i class="description"><?php esc_html_e( 'A floating tab appears on the side of the screen to open the compare popup.', 'th-product-compare' ); ?></i>
                        </td>
                    </tr>

                    <tr data-change-showhide-tab="ci-menu-tab-group" data-show="1" class="<?php echo esc_attr( $th_tab_hidden ); ?>">
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Sidebar Tab Position (Pro)', 'th-product-compare' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Which side of the screen the tab should appear on.', 'th-product-compare' ); ?></span>
                        </td>
                        <td>
                            <select data-th-save="compare-menu-tab-position" id="ci-tab-pos-sel">
                                <option value="left"  <?php echo $th_menu_tab_pos === 'left'  ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Left',  'th-product-compare' ); ?></option>
                                <option value="right" <?php echo $th_menu_tab_pos === 'right' ? esc_attr('selected') : ''; ?>><?php esc_html_e( 'Right', 'th-product-compare' ); ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr data-change-showhide-tab="ci-menu-tab-group" data-show="1" class="<?php echo esc_attr( $th_tab_hidden ); ?>">
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Sidebar Tab Label (Pro)', 'th-product-compare' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Text displayed on the sidebar tab.', 'th-product-compare' ); ?></span>
                        </td>
                        <td>
                            <input data-th-save="compare-menu-tab-text" type="text" id="ci-tab-label-inp"
                                   placeholder="<?php esc_attr_e( 'Compare', 'th-product-compare' ); ?>"
                                   value="<?php echo esc_attr( $th_menu_tab_text ); ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="th-color-title"><?php esc_html_e( 'Show Compare Icon in Menu', 'th-product-compare' ); ?></span>
                            <span class="th-alt-title"><?php esc_html_e( 'Append the compare icon to the primary navigation menu.', 'th-product-compare' ); ?></span>
                        </td>
                        <td>
                            <div class="th-compare-radio">
                                <input type="checkbox"
                                       data-th-save="compare-field"
                                       id="compare-menu-icon-in-menu"
                                       <?php echo esc_html( $icon_in_menu ); ?>
                                       value="menu-icon-in-menu">
                                <label class="th-color-title" for="compare-menu-icon-in-menu">
                                    <?php esc_html_e( 'Show in navigation menu', 'th-product-compare' ); ?>
                                </label>
                            </div>
                            <i class="description"><?php esc_html_e( 'When enabled, the compare icon is added to the primary WordPress navigation menu.', 'th-product-compare' ); ?></i>
                        </td>
                    </tr>

                </table>
            </div><!-- /ci-general -->

            <!-- Icon Style tab -->
            <div data-group-tabs="ci-tabs" data-tab-container="ci-style">
                <table class="th-ci-table">

                    <tr>
                        
                        <td>
                            <?php
                            th_apply_color('Icon Color', 'color', 'floating-ci-color');
                            th_apply_color('Icon Background Color', 'background-color', 'floating-ci-color');
                            th_apply_color('Badge Color', 'color', 'floating-ci-badge-color');
                            th_apply_color('Badge Background', 'background-color', 'floating-ci-badge-color');
                        ?>
                           
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
                        <div id="ci-prev-icon" class="th-ci-float-icon" data-th-output="floating-ci-color" data-th-save="style" data-th="background-color|color"
                        >
                            <span id="ci-prev-badge" class="th-ci-badge" data-th-output="floating-ci-badge-color" data-th-save="style" data-th="background-color|color"
                                 >2</span>
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
                                <?php esc_html_e( 'Compare', 'th-product-compare' ); ?>
                            </a>
                        </div>
                    </div>

                </div><!-- /.th-ci-viewport -->
            </div><!-- /.th-ci-browser-frame -->

            <p class="th-compare-icon-preview-label"><?php esc_html_e( 'Live Preview', 'th-product-compare' ); ?></p>

        </div><!-- /.thpreviewbox -->

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

    </div><!-- /.th-ci-preview-col -->

</div><!-- /.dummy-and-style -->
