<?php
/**
 * Custom Field Hook Section.
 *
 * @package TH_Product_Compare_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="setting_ th-compare-add-shortcode custom-hook">
    <div class="field-to-show">
        <div class="th-tab-heading">
            <span class="heading_">
                <?php esc_html_e( 'Custom Field Hook', 'th-product-compare' ); ?>
            </span>
        </div>

        <div class="add-product-wrap">
            <i class="heading_2">
                <?php
                echo esc_html__(
                    'Create shortcode with the desired products. You can use this shortcode anywhere in pages and posts.',
                    'th-product-compare'
                );
                ?>
            </i>

            <div class="add-product-wrap-hook">
                <span class="bold-heading">
                    <?php esc_html_e( 'Custom Field Hook Filter', 'th-product-compare' ); ?>
                </span>

                <p class="th-alt-title">
                    <?php esc_html_e( 'Add custom fields to the Product Compare field map.', 'th-product-compare' ); ?>
                    <br />
                    <?php esc_html_e( 'Filter:', 'th-product-compare' ); ?>
                    <code><?php echo esc_html( 'th-product-compare-field' ); ?></code>
                    <br />
                    <?php esc_html_e( 'Expected shape:', 'th-product-compare' ); ?>
                </p>

                <div class="add-product-hook">
                    <div class="th_product_compare_hook">
                        <pre class="bg-slate-50 text-slate-800 p-5 rounded-lg text-sm font-mono overflow-x-auto border border-slate-200 leading-relaxed custom-scrollbar">
<code><?php echo esc_html(
"function my_callback() {
    return array(
        'key1' => array(
            'title'     => 'Title 1',
            'field_key' => 'key1',
        ),
        'key2' => array(
            'title'     => 'Title 2',
            'field_key' => 'key2',
        ),
    );
}
add_filter( 'th-product-compare-field', 'my_callback' );

return array(
    'key1' => array( // WordPress post meta key (custom field key).
        'title'     => 'Label',   // Shown in the compare table header/UI.
        'field_key' => 'meta_key' // Post meta key to fetch from the product.
    ),
);"
); ?></code>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
