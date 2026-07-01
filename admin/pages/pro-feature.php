<?php
if (!defined('ABSPATH')) exit;
$defaultAttributes = [
    'image' => ["active" => 1],
    'title' => ["active" => 1],
    'rating' => ["active" => 1],
    'price' => ["active" => 1],
    'add-to-cart' => ["active" => 1],
    'description' => ["active" => 1],
    'availability' => ["active" => 1],
    'SKU' => ["active" => 1],
];

$th_image_width = isset($th_compare_option['product-image-width']) ? $th_compare_option['product-image-width'] : 168;
$th_image_height = isset($th_compare_option['product-image-height']) ? $th_compare_option['product-image-height'] : 168;
if (is_array($th_compare_option)) {
    if (isset($th_compare_option['attributes'])) {
        $defaultAttributes = $th_compare_option['attributes'];
    }
}
$fieldShowByCate = (
    !isset($th_compare_option['field-show-by-category']) 
    || $th_compare_option['field-show-by-category'] == '1'
) ? 'checked=checked' : '';

$fieldShowHighlight = isset($th_compare_option['field-highlight-btn']) && $th_compare_option['field-highlight-btn'] == '1' ? 'checked=checked' : '';

$fieldRepeatPrice = isset($th_compare_option['field-repeat-price']) && $th_compare_option['field-repeat-price'] == '1' ? 'checked=checked' : '';
$fieldrepeatAddToCart = isset($th_compare_option['field-repeat-add-to-cart']) && $th_compare_option['field-repeat-add-to-cart'] == '1' ? 'checked=checked' : '';
$fieldDynamicAttribute = isset($th_compare_option['field-dynamic-attribute']) && $th_compare_option['field-dynamic-attribute'] == '1' ? 'checked=checked' : '';
$wcAttr = function_exists('wc_get_attribute_taxonomies') ? wc_get_attribute_taxonomies() : [];
$wcAttr_ = [];
$wcAttr_add = [];
if (!empty($wcAttr)) {
    foreach ($wcAttr as $key => $value) {
        if (isset($value->attribute_name)) {
            $wcAttr_[$value->attribute_name] = true;
            if (!isset($defaultAttributes[$value->attribute_name])) {
                $wcAttr_add[$value->attribute_name] = ["active" => 0, 'custom' => 1, 'label' => $value->attribute_label];
            }
        }
    }
}

foreach ($wcAttr as $key => $value) {
    $attributeName = $value->attribute_name;
    if (isset($defaultAttributes[$attributeName])) {
        $defaultAttributes[$attributeName]['label'] = $value->attribute_label;
    }
}



$defaultAttributes = array_merge($defaultAttributes, $wcAttr_add);

$productsAttributes = '';

foreach ($defaultAttributes as $key => $value) {
    $checkCustomAttr = isset($value['custom']) ? "data-custom-attr=1" : '';

    if ($checkCustomAttr) {
        // remove custom attributes if not available in woocommerce 
        if (!isset($wcAttr_[$key])) {
            continue;
        }
    }

    $uniqId = 'compare-attributes-' . $key;
    $name_ = $checkCustomAttr ? $value['label'] : str_replace("-", " ", $key);
    $checkActive = $value['active'] == "1" ? "checked=checked" : '';
    $productsAttributes .=  '<div class="th-compare-radio">';
    $productsAttributes .=  sprintf(
        '<input type="checkbox" data-th-save="compare-attributes" %s %s id="%s" value="%s">',
        esc_attr($checkCustomAttr),
        esc_attr($checkActive),
        esc_attr($uniqId),
        esc_attr($key),
    );
    $productsAttributes .=  '<label class="th-color-title" for="' . esc_attr($uniqId) . '">' . esc_html($name_) . '</label>';
    $productsAttributes .=  '</div>';
}
?>
<div class="setting_">
    <div class="field-to-show">
        <div class="th-tab-heading">
            <span class="heading_"><?php esc_html_e('Advanced Settings', 'th-product-compare-pro'); ?></span>
        </div>
        <div>
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Compare Same Category Product', 'th-product-compare-pro'); ?></span>
                     <span class='th-alt-title'><?php esc_html_e(' Enable Category Tab in the Comparison Table.', 'th-product-compare-pro'); ?></span>
                </div>
                <div>
                    <div class="th-compare-radio">

                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-show-by-category" <?php echo esc_attr($fieldShowByCate); ?> value="show-by-category">
                        <label class="th-color-title" for="compare-fields-show-by-category"><?php esc_html_e('Compare By Category', 'th-product-compare-pro'); ?></label>
                        <i class='description'><?php esc_html_e('Check to Enable Category Tab in the Comparison Table.', 'th-product-compare-pro'); ?></i>
                    </div>
                </div>
            </div>
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Similarities & Differences', 'th-product-compare-pro'); ?></span>
                    <span class='th-alt-title'><?php esc_html_e(' Enable to show differences.', 'th-product-compare-pro'); ?></span>
                </div>
                <div>
                    <div class="th-compare-radio">
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-highlight-btn" <?php echo esc_attr($fieldShowHighlight); ?> value="highlight-btn">
                        <label class="th-color-title" for="compare-fields-highlight-btn"><?php esc_html_e('Product Highlight Button', 'th-product-compare-pro'); ?></label>
                        <i class='description'><?php esc_html_e('Check to Enable "Hide Similarities" & "Highlight Differences" Button in the Comparison Table.', 'th-product-compare-pro'); ?></i>
                    </div>
                </div>
            </div>
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Fields to Show in Comparison Table', 'th-product-compare-pro'); ?></span>
                     <span class='th-alt-title'><?php esc_html_e('Check to display fields. Drag to reorder.', 'th-product-compare-pro'); ?></span>
                </div>
                <div class="th-compare-field-wrap woocommerce-th-attributes">
                    <?php
                    echo $productsAttributes;
                    ?>
                </div>
            </div>
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Dynamic Attributes', 'th-product-compare-pro'); ?></span>
                     <span class='th-alt-title'><?php esc_html_e('Enable to show all custom product attributes automatically.', 'th-product-compare-pro'); ?></span>
                </div>
                <div class="dynamic-attribute">
                    <div class="th-compare-radio">
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-dynamic-attribute" <?php echo esc_attr($fieldDynamicAttribute); ?> value="dynamic-attribute">
                        <label class="th-color-title" for="compare-fields-dynamic-attribute"><?php esc_html_e('Check to Enable Product Dynamic Attributes.', 'th-product-compare-pro'); ?></label>
                    </div>
                </div>
            </div>
            <div class="row_ repeat-field">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Repeat Fields', 'th-product-compare-pro'); ?></span>
                    <span class='th-alt-title'><?php esc_html_e('Repeat specific rows at the bottom for easier comparison on long tables.', 'th-product-compare-pro'); ?></span>
                </div>
                <div>
                    <div class="th-compare-radio">
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-repeat-price" <?php echo esc_attr($fieldRepeatPrice); ?> value="repeat-price">
                        <label class="th-color-title" for="compare-fields-repeat-price"><?php esc_html_e('Repeat the "Price" field at the end of the table', 'th-product-compare-pro'); ?></label>
                    </div>

                    <div class="th-compare-radio">
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-repeat-add-to-cart" <?php echo esc_attr($fieldrepeatAddToCart); ?> value="repeat-add-to-cart">
                        <label class="th-color-title" for="compare-fields-repeat-add-to-cart"><?php esc_html_e('Repeat the "Add to cart" field at the end of the table', 'th-product-compare-pro'); ?></label>
                    </div>

                </div>
            </div>

            <div class="row_">
                <div>
                    <span class="bold-heading"><?php esc_html_e('Product Image Size', 'th-product-compare-pro'); ?></span>
                    <span class='th-alt-title'><?php esc_html_e('Dimensions of product images in the comparison table.', 'th-product-compare-pro'); ?></span>
                </div>
                <div>
                    <div class="th-product-size">
                        <input data-th-save='product-image-width' type="number" value="<?php echo intval($th_image_width); ?>">
                        <span>X</span>
                        <input data-th-save='product-image-height' type="number" value="<?php echo intval($th_image_height); ?>">
                        <span>px</span>
                    </div>
                    <i class='description'><?php esc_html_e('Add product image size which you want to display in the Comparison Table. (Width x Height)px.', 'th-product-compare-pro'); ?></i>

                </div>
            </div>
            <!-- row  -->

        </div>
    </div>
    
</div>

 