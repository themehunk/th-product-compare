<?php
if (!defined('ABSPATH')) exit;
$th_product_compare_btn_txt = isset($th_compare_option['compare-btn-text']) ? $th_compare_option['compare-btn-text'] : esc_html__('Compare', 'th-product-compare-pro');


$th_product_limit = isset($th_compare_option['compare-product-limit']) ? $th_compare_option['compare-product-limit'] : 8;
$th_compare_limit_tooltip = isset($th_compare_option['compare-limit-tooltip']) ? $th_compare_option['compare-limit-tooltip'] : '';
$th_product_btn_type = isset($th_compare_option['compare-btn-type']) ? $th_compare_option['compare-btn-type'] : 'icon';
$th_product_appear_type = isset($th_compare_option['compare-appear-type']) ? $th_compare_option['compare-appear-type'] : '';
$th_popup_appear_ = isset($th_compare_option['popup-appear-type']) ? $th_compare_option['popup-appear-type'] : 'bar';
$th_product_shop_hook = isset($th_compare_option['compare-at-shop-hook']) ? sanitize_text_field($th_compare_option['compare-at-shop-hook']) : 'after';
$th_close_popup_on_addtocart = isset($th_compare_option['close-popup-on-addtocart']) ? sanitize_text_field($th_compare_option['close-popup-on-addtocart']) : '0';


$checkChecked = [
    'field-product-page' => 'checked=checked',
    'field-product-single-page' => 'checked=checked',
];

if (is_array($th_compare_option)) {
    foreach ($checkChecked as $key => $value) {
        if (isset($th_compare_option[$key])) {
            if ($th_compare_option[$key] == '1') {
                $checkChecked[$key] = 'checked=checked';
            } else {
                $checkChecked[$key] = '';
            }
        }
    }
}
?>
<div class="th-general">
    <div class="th-option_">
       
            <span class="th-tab-heading"><?php esc_html_e('Appearance', 'th-product-compare-pro'); ?></span>
       
        <table>
            <tbody>
                <tr>
                    <td>
                        <span class="bold-heading"><?php esc_html_e('Comapre Button Type and Text', 'th-product-compare-pro'); ?></span>
                    <span class="th-alt-title"><?php esc_html_e('Choose how the trigger is displayed to users.', 'th-product-compare-pro'); ?></span>
                    </td>
                    <td>
                        <div class="th-compare-select-wrapper">
                           <div> 
                                <select data-th-save='compare-btn-type'>
                                    <option value="icon" <?php echo $th_product_btn_type == 'icon' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Icon', 'th-product-compare-pro'); ?></option>
                                    <option value="checkbox" <?php echo $th_product_btn_type == 'checkbox' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Checkbox', 'th-product-compare-pro'); ?></option>
                                </select>
                                <i class="description"><?php esc_html_e('How you want to display compare trigger.', 'th-product-compare'); ?></i>
                            </div>

                    <div>
                        <input data-th-save='compare-btn-text' type="text" placeholder="Compare" value="<?php echo esc_attr($th_product_compare_btn_txt); ?>">
                         <i class="description"><?php esc_html_e('This value define maximum number of products you want to add in the compare table.', 'th-product-compare-pro'); ?></i>
                    </div>
                        
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="bold-heading"><?php esc_html_e('Product Compare Button Redirection', 'th-product-compare-pro'); ?></span>
                         <span class="th-alt-title"><?php esc_html_e('Select Where you want to redirect the Compare Button'); ?></span>
                    </td>
                    <td>
                        <select data-change-showhide="pricing-table-appear" data-th-save='compare-appear-type'>
                            <option value="popup" <?php echo $th_product_appear_type == 'popup' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Popup', 'th-product-compare-pro'); ?></option>
                            <option value="page" <?php echo $th_product_appear_type == 'page' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Page', 'th-product-compare-pro'); ?></option>
                        </select>
                        <i class='description'><?php esc_html_e('How you want to display a compare trigger (Like a Link or a Button).', 'th-product-compare-pro'); ?></i>

                    </td>
                </tr>
                <tr data-change-showhide-tab="pricing-table-appear" data-show="popup" class="<?php echo $th_product_appear_type !== 'popup' ? esc_attr("show_none") : ''; ?>">
                    <td>
                        <span class="bold-heading"><?php esc_html_e('Pricing Table Effect', 'th-product-compare-pro'); ?></span>
                        <span class="th-alt-title"><?php esc_html_e('Select how you want to display the pricing', 'th-product-compare'); ?></span>
                    </td>
                    <td>
                        <select data-th-save='popup-appear-type'>
                            <option value="bar" <?php echo $th_popup_appear_ == 'bar' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Slide Bar', 'th-product-compare-pro'); ?></option>
                            <option value="without-bar" <?php echo $th_popup_appear_ == 'without-bar' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Popup', 'th-product-compare-pro'); ?></option>
                        </select>
                        <i class='description'><?php esc_html_e('How you want to display a Popup trigger (Like a With Bar or Without Bar).', 'th-product-compare-pro'); ?></i>
                    </td>
                </tr>
                <!-- popup position  -->
               
                <tr>
                    <td>
                        <span class="bold-heading"><?php esc_html_e('Comparison Limit', 'th-product-compare-pro'); ?></span>
                        <span class="th-alt-title"><?php esc_html_e('Max products allowed in the compare table.', 'th-product-compare'); ?></span>
                    </td>
                    <td>
                        <input data-th-save='compare-product-limit' type="number" placeholder="8" value="<?php echo esc_attr($th_product_limit); ?>">
                       <i class="description"><?php esc_html_e('This value define maximum number of products you want to add in the compare table.', 'th-product-compare-pro'); ?></i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="bold-heading"><?php esc_html_e('Comparison Limit Tooltip', 'th-product-compare-pro'); ?></span>
                        <span class="th-alt-title"><?php esc_html_e('Tooltip text when limit is reached.', 'th-product-compare-pro'); ?></span>
                    </td>
                    <td>
                        <input data-th-save='compare-limit-tooltip' type="text" placeholder="<?php esc_attr_e('You can add up to {limit} products to compare.', 'th-product-compare-pro'); ?>" value="<?php echo esc_attr($th_compare_limit_tooltip); ?>">
                       <i class="description"><?php esc_html_e('Use {limit} to display the max product number. Leave empty for default.', 'th-product-compare-pro'); ?></i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="bold-heading"><?php esc_html_e('Visibility', 'th-product-compare-pro'); ?></span>
                        <span class="th-alt-title"><?php esc_html_e('Where should the compare button appear?', 'th-product-compare'); ?></span>
                    </td>
                    <td>
                        <div class="th-compare-radio">
                            <!--title-->
                            <input type="checkbox" data-th-save='compare-field' id="field-show-product-page" <?php echo esc_attr($checkChecked['field-product-single-page']); ?> value="product-single-page">
                            <label class="bold-heading" for="field-show-product-page"><?php esc_html_e('Product Single Page.', 'th-product-compare-pro'); ?></label>
                        </div>

                        <div class="th-compare-radio shop-archive">
                            <!--title-->
                            <input type="checkbox" data-th-save='compare-field' id="compare-fields-product-list" <?php echo esc_attr($checkChecked['field-product-page']); ?> value="product-page">
                            <label class="bold-heading" for="compare-fields-product-list"><?php esc_html_e('Shop and Archive Pages.', 'th-product-compare-pro'); ?></label>
                        </div>

                    </td>
                </tr>

                 <tr>
                <td>
                    <span class="bold-heading"><?php esc_html_e('Button Placement', 'th-product-compare-pro'); ?></span>
                    <span class="th-alt-title"><?php esc_html_e('Position relative to the Add to Cart button.', 'th-product-compare'); ?></span>
                </td>
                <td>
                    <select data-th-save='compare-at-shop-hook'>
                        <option value="before" <?php echo esc_html($th_product_shop_hook == 'before' ? "selected" : ''); ?>><?php esc_html_e('Before Cart', 'th-product-compare'); ?></option>
                        <option value="after" <?php echo esc_html($th_product_shop_hook == 'after' ? "selected" : ''); ?>><?php esc_html_e('After Cart', 'th-product-compare-pro'); ?></option>
                        <option value="onimageleft" <?php echo esc_html($th_product_shop_hook == 'onimageleft' ? "selected" : ''); ?>><?php esc_html_e('On Image Left', 'th-product-compare-pro'); ?></option>
                        <option value="onimageright" <?php echo esc_html($th_product_shop_hook == 'onimageright' ? "selected" : ''); ?>><?php esc_html_e('On Image Right', 'th-product-compare-pro'); ?></option>
                        <option value="oncart" <?php echo esc_html($th_product_shop_hook == 'oncart' ? "selected" : ''); ?>><?php esc_html_e('On Cart', 'th-product-compare-pro'); ?></option>
                    </select>
                    
                </td>
            </tr>


                <tr>
                    <td>
                        <span class="bold-heading"><?php esc_html_e('Close Popup After Add to Cart', 'th-product-compare-pro'); ?></span>
                        <span class="th-alt-title"><?php esc_html_e('Automatically close the compare popup when a product is added to cart.', 'th-product-compare-pro'); ?></span>
                    </td>
                    <td>
                        <select data-th-save="close-popup-on-addtocart">
                            <option value="0" <?php echo $th_close_popup_on_addtocart != '1' ? esc_attr('selected') : ''; ?>><?php esc_html_e('Disable', 'th-product-compare-pro'); ?></option>
                            <option value="1" <?php echo $th_close_popup_on_addtocart == '1' ? esc_attr('selected') : ''; ?>><?php esc_html_e('Enable', 'th-product-compare-pro'); ?></option>
                        </select>
                        <i class="description"><?php esc_html_e('When enabled, the compare popup will close automatically after a product is successfully added to the cart.', 'th-product-compare-pro'); ?></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>