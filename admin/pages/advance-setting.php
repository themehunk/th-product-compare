<?php
if (!defined('ABSPATH')) exit;
$defaultAttributes = [
    'image' => ["active" => 1],
    'title' => ["active" => 1],
    'rating' => ["active" => 1],
    'price' => ["active" => 1],
    'add-to-cart' => ["active" => 1],
    'description' => ["active" => 0],
    'availability' => ["active" => 1],
    'sku' => ["active" => 1],
];

if (is_array($th_compare_option)) {
    if (isset($th_compare_option['attributes'])) {
        $defaultAttributes = $th_compare_option['attributes'];
    }
}
$fieldRepeatPrice = isset($th_compare_option['field-repeat-price']) && $th_compare_option['field-repeat-price'] == '1' ? 'checked="checked"' : '';
$fieldrepeatAddToCart = isset($th_compare_option['field-repeat-add-to-cart']) && $th_compare_option['field-repeat-add-to-cart'] == '1' ? 'checked="checked"' : '';
// $wcAttr = wc_get_attribute_taxonomies();
// $wcAttr_ = [];
// $wcAttr_add = [];
// if (!empty($wcAttr)) {
//     foreach ($wcAttr as $key => $value) {
//         if (isset($value->attribute_name)) {
//             $wcAttr_[$value->attribute_name] = true;
//             if (!isset($defaultAttributes[$value->attribute_name])) {
//                 $wcAttr_add[$value->attribute_name] = ["active" => 0, 'custom' => 1, 'label' => $value->attribute_label];
//             }
//         }
//     }
// }
// $defaultAttributes = array_merge($defaultAttributes, $wcAttr_add);
$productsAttributes = '';
foreach ($defaultAttributes as $key => $value) {
    // $checkCustomAttr = isset($value['custom']) ? "data-custom-attr=1" : '';

    // if ($checkCustomAttr) {
    //     // remove custom attributes if not available in woocommerce 
    //     if (!isset($wcAttr_[$key])) {
    //         continue;
    //     }
    // }

    $uniqId = 'compare-attributes-' . $key;
    // $name_ = $checkCustomAttr ? $value['label'] : str_replace("-", " ", $key);
    $name_ = ucfirst(str_replace("-", " ", $key));

    $checkActive = $value['active'] == "1" ? "checked='checked'" : '';
    $productsAttributes .=  '<div class="th-compare-radio">';
    $productsAttributes .=  '<input type="checkbox" data-th-save="compare-attributes"  ' . $checkActive . ' id="' . $uniqId . '" value="' . $key . '">';
    $productsAttributes .=  '<label class="th-color-title" for="' . $uniqId . '">' . __($name_, 'th-product-compare') . '</label>';
    $productsAttributes .=  '</div>';
}

?>
<div class="setting_">
    <div class="field-to-show">
        <span class="th-tab-heading"><?php _e('Advance Setting', 'th-product-compare'); ?></span>
        <div>
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php _e('Field To Show', 'th-product-compare') ?></span>
                </div>
                <div class="th-compare-field-wrap woocommerce-th-attributes">
                    <?php echo $productsAttributes; ?>
                </div>
            </div>
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php _e('Repeat price field', 'th-product-compare') ?></span>
                </div>
                <div>
                    <div class="th-compare-radio">
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-repeat-price" <?php echo $fieldRepeatPrice; ?> value="repeat-price">
                        <label class="th-color-title" for="compare-fields-repeat-price"><?php _e('Repeat the <b> &#160 price &#160 </b> at the end of the table', 'th-product-compare') ?></label>
                    </div>
                </div>
            </div>
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php _e('Repeat add to cart', 'th-product-compare') ?></span>
                </div>
                <div>
                    <div class="th-compare-radio">
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-repeat-add-to-cart" <?php echo $fieldrepeatAddToCart; ?> value="repeat-add-to-cart">
                        <label class="th-color-title" for="compare-fields-repeat-add-to-cart"><?php _e('Repeat  <b>&#160 add to cart &#160</b> at the end of the table', 'th-product-compare') ?></label>
                    </div>
                </div>
            </div>

            <!-- <div class="row_">
                <div>
                    <span class="bold-heading"><?php _e('Image Size "Width X Height"', 'th-product-compare') ?></span>
                </div>
                <div>
                    <div class="th-product-size">
                        <input data-th-save='product-image-width' type="number" value="<?php echo $th_image_width; ?>">
                        <span>X</span>
                        <input data-th-save='product-image-height' type="number" value="<?php echo $th_image_height; ?>">
                        <span>px</span>
                    </div>
                </div>
            </div> -->
            <!-- row  -->
        </div>
    </div>
</div>