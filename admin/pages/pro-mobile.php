<?php
if (!defined('ABSPATH')) exit;
$blankImgUrl = TH_PRODUCT_URL . '/assets/img/blank.png';
$blankImage = '<img data-th-output="mobile-table-bg-color" data-th-save="style" data-th="background-color" src="' . esc_attr($blankImgUrl) . '">';
$tablestyle_in_mobile = isset($th_compare_option['tablestyle-in-mobile']) ? sanitize_text_field($th_compare_option['tablestyle-in-mobile']) : 'mobile-flex';
$th_headingText = isset($th_compare_option['compare-heading-text']) ? $th_compare_option['compare-heading-text'] : esc_html__('Compare Product', 'th-product-compare-pro');
$fieldMobileRemoveIcon = (!isset($th_compare_option['field-mobile-remove-icon']) || $th_compare_option['field-mobile-remove-icon'] == '1') ? 'checked=checked' : '';
?>
<div class="mobile_">
    <div class="dummy-and-style">
        <div class="style-setting_">
            <div class="container_">
                <div class="th-mobile-settings">
                    <div class="th-color-output">
                        <span class="bold-heading"><?php esc_html_e('Mobile Settings', 'th-product-compare-pro'); ?></span>

                        <div class="th-color-picker th-input input-block">
                            <label class="th-color-title"><?php esc_html_e('Table Style in Mobile', 'th-product-compare-pro'); ?></label>
                            <select data-th-save='tablestyle-in-mobile'>
                                <option value="mobile-flex" <?php selected($tablestyle_in_mobile, 'mobile-flex'); ?>>
                                    <?php esc_html_e('Mobile Responsive', 'th-product-compare-pro'); ?>
                                </option>
                                <option value="desktop" <?php selected($tablestyle_in_mobile, 'desktop'); ?>>
                                    <?php esc_html_e('Desktop Style', 'th-product-compare-pro'); ?>
                                </option>
                            </select>
                        </div>

                        <span class="bold-heading"><?php esc_html_e('Product Remove Icon', 'th-product-compare-pro'); ?></span>
                        <div class="th-compare-radio">
                            <input type="checkbox" data-th-save='compare-field' id="compare-fields-mobile-remove-icon" <?php echo esc_attr($fieldMobileRemoveIcon); ?> value="mobile-remove-icon">
                            <label class="th-color-title" for="compare-fields-mobile-remove-icon"><?php esc_html_e('Enable Remove Icon on Mobile', 'th-product-compare-pro'); ?></label>
                            <i class="description"><?php esc_html_e('Check to show the remove product icon on mobile view.', 'th-product-compare-pro'); ?></i>
                        </div>

                        <span class="bold-heading"><?php esc_html_e('Mobile Colors', 'th-product-compare-pro'); ?></span>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Preview -->
        <div class="th-mobile-preview-wrap">
            <div class="preview-top-header"><span></span><span></span><span></span></div>
            <div class="th-mobile-preview-inner" data-th-output="mobile-table-bg-color" data-th-save="style" data-th="background-color">
                <div class="th-mobile-accent-bar" data-th-output="mobile-accent-color" data-th-save="style" data-th="background-color"></div>
                <div class="th-mobile-content" data-th-output="mobile-content-color" data-th-save="style" data-th="color">

                    <!-- Header -->
                    <div class="th-mobile-header">
                        <div class="th-mobile-header-left">
                            <img src="<?php echo esc_url(TH_PRODUCT_URL . 'assets/img/th-logo.png'); ?>" class="th-mobile-logo">
                            <span class="th-mobile-header-title"><?php esc_html_e('ComparePro', 'th-product-compare-pro'); ?></span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                    </div>

                    <!-- Product Cards Row -->
                    <div class="th-mobile-row th-mobile-products-row">
                        <!-- Product 1 -->
                        <div class="th-mobile-cell">
                            <div class="th-mobile-product-card">
                                <div class="th-mobile-img-box" style="position:relative;">
                                    <button class="th-img-remove-btn th-mobile-preview-remove-btn" style="position:absolute;top:4px;right:4px;"><i class="dashicons dashicons-no-alt"></i></button>
                                    <?php echo $blankImage; ?>
                                </div>
                                <a href="#" class="th-mobile-product-name"><?php esc_html_e('Product Title One', 'th-product-compare-pro'); ?></a>
                                <div class="th-mobile-rating-inline" data-th-output="mobile-rating-color" data-th-save="style" data-th="color">
                                    <span class="th-mobile-star">&#9733;</span> <span class="th-mobile-rate-num">4.9</span>
                                </div>
                                <div class="th-mobile-reviews">(13)</div>
                                <div class="th-mobile-price"><?php esc_html_e('$90.00', 'th-product-compare-pro'); ?></div>
                                <div class="th-mobile-buy-btn" data-th-output="mobile-add-to-cart" data-th-save="style" data-th="background-color|color">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                                    <?php esc_html_e('Buy', 'th-product-compare-pro'); ?>
                                </div>
                            </div>
                        </div>
                        <!-- Product 2 -->
                        <div class="th-mobile-cell">
                            <div class="th-mobile-product-card">
                                <div class="th-mobile-img-box" style="position:relative;">
                                    <button class="th-img-remove-btn th-mobile-preview-remove-btn" style="position:absolute;top:4px;right:4px;"><i class="dashicons dashicons-no-alt"></i></button>
                                    <?php echo $blankImage; ?>
                                </div>
                                <a href="#" class="th-mobile-product-name"><?php esc_html_e('Product Title Two', 'th-product-compare-pro'); ?></a>
                                <div class="th-mobile-rating-inline" data-th-output="mobile-rating-color" data-th-save="style" data-th="color">
                                    <span class="th-mobile-star">&#9733;</span> <span class="th-mobile-rate-num">4.8</span>
                                </div>
                                <div class="th-mobile-reviews">(22)</div>
                                <div class="th-mobile-price"><?php esc_html_e('$75.00', 'th-product-compare-pro'); ?></div>
                                <div class="th-mobile-buy-btn" data-th-output="mobile-add-to-cart" data-th-save="style" data-th="background-color|color">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                                    <?php esc_html_e('Buy', 'th-product-compare-pro'); ?>
                                </div>
                            </div>
                        </div>
                        <!-- Product 3 -->
                        <div class="th-mobile-cell">
                            <div class="th-mobile-product-card">
                                <div class="th-mobile-img-box" style="position:relative;">
                                    <button class="th-img-remove-btn th-mobile-preview-remove-btn" style="position:absolute;top:4px;right:4px;"><i class="dashicons dashicons-no-alt"></i></button>
                                    <?php echo $blankImage; ?>
                                </div>
                                <a href="#" class="th-mobile-product-name"><?php esc_html_e('Product Title Three', 'th-product-compare-pro'); ?></a>
                                <div class="th-mobile-rating-inline" data-th-output="mobile-rating-color" data-th-save="style" data-th="color">
                                    <span class="th-mobile-star">&#9733;</span> <span class="th-mobile-rate-num">4.9</span>
                                </div>
                                <div class="th-mobile-reviews">(9)</div>
                                <div class="th-mobile-price"><?php esc_html_e('$60.00', 'th-product-compare-pro'); ?></div>
                                <div class="th-mobile-buy-btn" data-th-output="mobile-add-to-cart" data-th-save="style" data-th="background-color|color">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                                    <?php esc_html_e('Buy', 'th-product-compare-pro'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Description -->
                    <div class="th-mobile-section-heading" data-th-output="mobile-heading-color" data-th-save="style" data-th="color">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                        <?php esc_html_e('DESCRIPTION', 'th-product-compare-pro'); ?>
                    </div>
                    <div class="th-mobile-row th-mobile-attr-row" data-th-output="mobile-border-color" data-th-save="style" data-th="border-color">
                        <div class="th-mobile-cell">
                            <div class="th-mobile-attr-label"><?php esc_html_e('DESCRIPTION', 'th-product-compare-pro'); ?></div>
                            <div class="th-mobile-attr-value"><?php esc_html_e('This is a simple product.', 'th-product-compare-pro'); ?></div>
                        </div>
                        <div class="th-mobile-cell">
                            <div class="th-mobile-attr-label"><?php esc_html_e('DESCRIPTION', 'th-product-compare-pro'); ?></div>
                            <div class="th-mobile-attr-value"><?php esc_html_e('This is a simple product.', 'th-product-compare-pro'); ?></div>
                        </div>
                        <div class="th-mobile-cell">
                            <div class="th-mobile-attr-label"><?php esc_html_e('DESCRIPTION', 'th-product-compare-pro'); ?></div>
                            <div class="th-mobile-attr-value"><?php esc_html_e('This is a simple product.', 'th-product-compare-pro'); ?></div>
                        </div>
                    </div>

                    <!-- Section: Availability -->
                    <div class="th-mobile-section-heading" data-th-output="mobile-heading-color" data-th-save="style" data-th="color">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                        <?php esc_html_e('AVAILABILITY', 'th-product-compare-pro'); ?>
                    </div>
                    <div class="th-mobile-row th-mobile-attr-row" data-th-output="mobile-border-color" data-th-save="style" data-th="border-color">
                        <div class="th-mobile-cell">
                            <div class="th-mobile-attr-label"><?php esc_html_e('AVAILABILITY', 'th-product-compare-pro'); ?></div>
                            <div class="th-mobile-attr-value th-mobile-in-stock"><?php esc_html_e('In Stock', 'th-product-compare-pro'); ?></div>
                        </div>
                        <div class="th-mobile-cell">
                            <div class="th-mobile-attr-label"><?php esc_html_e('AVAILABILITY', 'th-product-compare-pro'); ?></div>
                            <div class="th-mobile-attr-value th-mobile-in-stock"><?php esc_html_e('In Stock', 'th-product-compare-pro'); ?></div>
                        </div>
                        <div class="th-mobile-cell">
                            <div class="th-mobile-attr-label"><?php esc_html_e('AVAILABILITY', 'th-product-compare-pro'); ?></div>
                            <div class="th-mobile-attr-value th-mobile-in-stock"><?php esc_html_e('In Stock', 'th-product-compare-pro'); ?></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
