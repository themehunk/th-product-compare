<?php
if (!defined('ABSPATH')) exit;
?>
<div class="th-general">
    <div class="th-option_">
        <span class="th-tab-heading"><?php _e('Custom Integration', 'th-product-compare'); ?></span>
        <table>
            <tr>
                <td class="bold-heading"><?php _e('Show Compare Button By Shortcode ', 'th-product-compare'); ?></td>
            </tr>
            <tr>
                <td class="shortcode-appear">
                    echo do_shortcode('[th_compare pid='10']')
                </td>
            </tr>
            <tr>
                <td class="bold-heading"><?php _e('Show Compare Button By Html Element', 'th-product-compare'); ?></td>
            </tr>
            <tr>
                <td class="shortcode-appear html-tag_">
                    &lt;span class='th-product-compare-btn' data-th-product-id='10'&gt;<?php _e('button', 'th-product-compare') ?>&lt;/span&gt;
                </td>
            </tr>
        </table>
    </div>
</div>