<?php
$th_product_compare_btn_txt = isset($th_compare_option['compare-btn-text']) ? sanitize_text_field($th_compare_option['compare-btn-text']) : __('Compare', 'th-product-compare');
$th_product_limit = isset($th_compare_option['compare-product-limit']) ? sanitize_text_field($th_compare_option['compare-product-limit']) : 8;

?>
<div class="th-general">
    <div class="th-option_">
        <span class="th-tab-heading"><?php _e('Compare Button And Shortcode', 'th-product-compare'); ?></span>
        <table>
            <tr class="table_heading">
                <td><?php _e('Button Appearance', 'th-product-compare'); ?></td>
            </tr>
            <tr>
                <td><span class="title_"> Link or Button</span></td>
                <td>
                    <select data-th-save='compare-btn-type'>
                        <option value="button">Button</option>
                        <option value="link">Link</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="title_">Text / Button Text</span></td>
                <td>
                    <input data-th-save='compare-btn-text' type="text" placeholder="Compare" value="<?php echo $th_product_compare_btn_txt; ?>">
                </td>
            </tr>
            <tr>
                <td><span class="title_">Number Of Product</span></td>
                <td>
                    <input data-th-save='compare-product-limit' type="number" placeholder="8" value="<?php echo $th_product_limit; ?>">
                </td>
            </tr>
            <tr class="table_heading">
                <td><?php _e('Show Compare Button By Shortcode ', 'th-product-compare'); ?></td>
            </tr>
            <tr>
                <td class="shortcode-appear">
                    echo do_shortcode('[th_product_compare product_id='10']')
                </td>
            </tr>
            <tr class="table_heading">
                <td><?php _e('Show Compare Button By Html Element', 'th-product-compare'); ?></td>
            </tr>
            <tr>
                <td class="shortcode-appear html-tag_">
                    &lt;span class='th-product-compare-btn' data-th-product-id='10'&gt;button&lt;/span&gt;
                </td>
            </tr>
            <tr class="table_heading">
                <td><?php _e('Show Compare Button By Function ', 'th-product-compare'); ?></td>
            </tr>
            <tr>
                <td class="shortcode-appear">
                    echo th_product_compare_button($productid=10)
                </td>
            </tr>
        </table>
    </div>
    <!-- sidebar -->
    <section class="th-right-sidebar">

    </section>
</div>