<?php
$th_product_compare_btn_txt = isset($th_compare_option['compare-btn-text']) ? sanitize_text_field($th_compare_option['compare-btn-text']) : __('Compare', 'th-product-compare');
$th_product_limit = isset($th_compare_option['compare-product-limit']) ? sanitize_text_field($th_compare_option['compare-product-limit']) : 8;

?>
<div class="th-general">
    <div class="th-option_">
        <span class="th-tab-heading"><?php _e('Compare Button And Shortcode', 'th-product-compare'); ?></span>
        <table>
            <tr>
                <td class="bold-heading"><?php _e('Button Appearance', 'th-product-compare'); ?></td>
            </tr>
            <tr>
                <td><span class="th-color-title"><?php _e('Link or Button', 'th-product-compare') ?></span></td>
                <td>
                    <select data-th-save='compare-btn-type'>
                        <option value="button"><?php _e('Button', 'th-product-compare') ?></option>
                        <option value="link"><?php _e('Link', 'th-product-compare') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="th-color-title"><?php _e('Text / Button Text','th-product-compare')?></span></td>
                <td>
                    <input data-th-save='compare-btn-text' type="text" placeholder="Compare" value="<?php echo $th_product_compare_btn_txt; ?>">
                </td>
            </tr>
            <tr>
                <td><span class="th-color-title"><?php _e('Number Of Product','th-product-compare')?></span></td>
                <td>
                    <input data-th-save='compare-product-limit' type="number" placeholder="8" value="<?php echo $th_product_limit; ?>">
                </td>
            </tr>
            <tr>
                <td class="bold-heading"><?php _e('Show Compare Button By Shortcode ', 'th-product-compare'); ?></td>
            </tr>
            <tr>
                <td class="shortcode-appear">
                    echo do_shortcode('[th_product_compare product_id='10']')
                </td>
            </tr>
            <tr>
                <td class="bold-heading"><?php _e('Show Compare Button By Html Element', 'th-product-compare'); ?></td>
            </tr>
            <tr>
                <td class="shortcode-appear html-tag_">
                    &lt;span class='th-product-compare-btn' data-th-product-id='10'&gt;<?php _e('button','th-product-compare')?>&lt;/span&gt;
                </td>
            </tr>
        </table>
    </div>
    <!-- sidebar -->
    <?php include 'right-sidebar.php'; ?>
</div>