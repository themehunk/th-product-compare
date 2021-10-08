<?php
if (!defined('ABSPATH')) exit;
$checkChecked = [
    'field-image' => 'checked="checked"',
    'field-title' => 'checked="checked"',
    'field-price' => 'checked="checked"',
    'field-rating' => 'checked="checked"',
    'field-add-to-cart' => 'checked="checked"',
    'field-description' => 'checked="checked"',
    'field-sku' => 'checked="checked"',
    'field-availability' => 'checked="checked"',
    'field-weight' => 'checked="checked"',
    'field-dimension' => 'checked="checked"',
    'field-size' => 'checked="checked"',
    'field-repeat-price' => 'checked="checked"',
    'field-repeat-add-to-cart' => 'checked="checked"',
];

if (is_array($th_compare_option)) {
    foreach ($checkChecked as $key => $value) {
        if (isset($th_compare_option[$key])) {
            if ($th_compare_option[$key] == '1') {
                $checkChecked[$key] = 'checked="checked"';
            } else {
                $checkChecked[$key] = '';
            }
        }
    }
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
                <div class="th-compare-field-wrap">
                    <div class="th-compare-radio">
                        <!--image-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-image" <?php echo $checkChecked['field-image']; ?> value="image">
                        <label class="th-color-title" for="compare-fields-image"><?php _e('Image', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--title-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-title" <?php echo $checkChecked['field-title']; ?> value="title">
                        <label class="th-color-title" for="compare-fields-title"><?php _e('Title', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--price-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-price" <?php echo $checkChecked['field-price']; ?> value="price">
                        <label class="th-color-title" for="compare-fields-price"><?php _e('Price', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--rating-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-rating" <?php echo $checkChecked['field-rating']; ?> value="rating">
                        <label class="th-color-title" for="compare-fields-rating"><?php _e('Price', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--add-to-cart-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-add-to-cart" <?php echo $checkChecked['field-add-to-cart']; ?> value="add-to-cart">
                        <label class="th-color-title" for="compare-fields-add-to-cart"><?php _e('Add To Cart', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--description-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-description" <?php echo $checkChecked['field-description']; ?> value="description">
                        <label class="th-color-title" for="compare-fields-description"><?php _e('Description', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--sku-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-sku" <?php echo $checkChecked['field-sku']; ?> value="sku">
                        <label class="th-color-title" for="compare-fields-sku"><?php _e('SKU', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--availability-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-availability" <?php echo $checkChecked['field-availability']; ?> value="availability">
                        <label class="th-color-title" for="compare-fields-availability"><?php _e('Availability', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--weight-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-weight" <?php echo $checkChecked['field-weight']; ?> value="weight">
                        <label class="th-color-title" for="compare-fields-weight"><?php _e('Weight', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--dimension-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-dimension" <?php echo $checkChecked['field-dimension']; ?> value="dimension">
                        <label class="th-color-title" for="compare-fields-dimension"><?php _e('Dimension', 'th-product-compare') ?></label>
                    </div>
                    <div class="th-compare-radio">
                        <!--size-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-size" <?php echo $checkChecked['field-size']; ?> value="size">
                        <label class="th-color-title" for="compare-fields-size"><?php _e('Size', 'th-product-compare') ?></label>
                    </div>
                </div>
            </div>
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php _e('Repeat "Price" field', 'th-product-compare') ?></span>
                </div>
                <div>
                    <div class="th-compare-radio">
                        <!--image-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-repeat-price" <?php echo $checkChecked['field-repeat-price']; ?> value="repeat-price">
                        <label class="th-color-title" for="compare-fields-repeat-price"><?php _e('Repeat the "Price" field at the end of the table', 'th-product-compare') ?></label>
                    </div>
                </div>
            </div>
            <div class="row_">
                <div>
                    <span class="bold-heading"><?php _e('Repeat "Add to cart" field', 'th-product-compare') ?></span>
                </div>
                <div>
                    <div class="th-compare-radio">
                        <!--image-->
                        <input type="checkbox" data-th-save='compare-field' id="compare-fields-repeat-add-to-cart" <?php echo $checkChecked['field-repeat-add-to-cart']; ?> value="repeat-add-to-cart">
                        <label class="th-color-title" for="compare-fields-repeat-add-to-cart"><?php _e('Repeat the "Add to cart" field at the end of the table', 'th-product-compare') ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'right-sidebar.php'; ?>

</div>