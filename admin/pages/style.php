<?php
$blankImage = '<img src="' . TH_PRODUCT_URL . '/assets/img/blank.png">';
$th_headingText = isset($th_compare_option['compare-heading-text']) ? sanitize_text_field($th_compare_option['compare-heading-text']) : __('Compare Product');
function th_apply_color($title, $prop, $color_id = false)
{
    if ($title && $prop && $color_id) {
        echo '<div class="th-color-picker">
                    <label class="th-color-title">' . $title . '</label>
					<div>
						<label class="color-output" data-th-color="' . $color_id . '" output-type="' . $prop . '"></label>
					</div>
				</div>';
    }
}

?>
<div class="style_">
    <div class="dummy-and-style">
        <div class="style-setting_">
            <span class="th-tab-heading"><?php _e('Compare Preview', 'th-product-compare'); ?></span>
            <div class="th-color-output">
                <div class="th-color-picker th-input input-block">
                    <label class="th-color-title"><?php _e('Popup Heading', 'th-product-compare') ?></label>
                    <input data-th-save='compare-heading-text' type="text" value="<?php echo $th_headingText; ?>">
                </div>
                <?php
                echo th_apply_color(__('Fore Ground Color / Overlay Color', 'th-product-compare'), 'background-color', 'fore-ground-bg');
                echo th_apply_color(__('Row Even Background Color', 'th-product-compare'), 'background-color', 'row-even-bg');
                echo th_apply_color(__('Row Odd Background Color', 'th-product-compare'), 'background-color', 'row-odd-bg');
                echo th_apply_color(__('Border Color', 'th-product-compare'), 'border-color', 'dummy-border-color');

                echo th_apply_color(__('Heading Color', 'th-product-compare'), 'color', 'heading-style');
                echo th_apply_color(__('Heading Background Color', 'th-product-compare'), 'background-color', 'heading-style');
                echo th_apply_color(__('Close Button Color', 'th-product-compare'), 'color', 'close-btn-style');
                echo th_apply_color(__('Close Button Background Color', 'th-product-compare'), 'background-color', 'close-btn-style');
                echo th_apply_color(__('Rating Color', 'th-product-compare'), 'color', 'rating-color');
                echo th_apply_color(__('Remove Button Color', 'th-product-compare'), 'color', 'remove-btn-color');
                ?>
            </div>

        </div>
        <div class="th-compare-popup-dummy" data-th-output="fore-ground-bg" data-th-save='style' data-th='background-color'>
            <div class="inner-wrap_" data-th-output="dummy-border-color" data-th-save='style' data-th='border-color'>
                <span data-th-output="heading-style" class="heading" data-th-save='style' data-th='background-color|color'><?php echo $th_headingText; ?></span>
                <i data-th-output="close-btn-style" data-th-save='style' data-th='background-color|color' class="close-btn_ dashicons dashicons-no-alt"></i>
                <div class="table_">
                    <table>
                        <tr data-th-output="row-odd-bg" data-th-save='style' data-th='background-color'>
                            <td class="left-title"><?php _e('Image', 'th-product-compare') ?></td>
                            <td>
                                <div class="image-product">
                                    <?php echo $blankImage ?>
                                    <span class="p-title"><?php _e('Product Title', 'th-product-compare') ?></span>
                                    <button class="add-to-cart"><?php _e('Add To Cart', 'th-product-compare') ?></button>
                                </div>
                            </td>
                            <td>
                                <div class="image-product">
                                    <?php echo $blankImage ?>
                                    <span class="p-title"><?php _e('Product Title','th-product-compare')?></span>
                                    <button class="add-to-cart"><?php _e('Add To Cart','th-product-compare')?></button>
                                </div>
                            </td>
                        </tr>
                        <tr data-th-output="row-even-bg" data-th-save='style' data-th='background-color'>
                            <td class="left-title"><?php _e('SKU','th-product-compare')?></td>
                            <td>woo-vneck-tee</td>
                            <td>woo-vneck-tee</td>
                        </tr>
                        <tr data-th-output="row-odd-bg">
                            <td class="left-title"><?php _e('Rating','th-product-compare')?></td>
                            <td class="rating_" data-th-output="rating-color" data-th-save='style' data-th='color'>
                                <div class="star-rating" role="img" aria-label="Rated 3.00 out of 5"><span style="width:60%">Rated <strong class="rating">3.00</strong> out of 5</span></div>
                            </td>
                            <td class="rating_" data-th-output="rating-color">
                                <div class="star-rating" role="img" aria-label="Rated 3.00 out of 5"><span style="width:60%">Rated <strong class="rating">3.00</strong> out of 5</span></div>
                            </td>
                        </tr>
                        <tr data-th-output="row-even-bg">
                            <td class="left-title"><?php _e('Remove','th-product-compare')?></td>
                            <td><button data-th-output="remove-btn-color" class="rm-product" data-th-save='style' data-th='color'><i class="dashicons dashicons-dismiss"></i><?php _e('Remove','th-product-compare')?></button></td>
                            <td><button data-th-output="remove-btn-color" class="rm-product"><i class="dashicons dashicons-dismiss"></i><?php _e('Remove','th-product-compare')?></button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>




<!-- $wp_builder_obj->color(__('Background Color','wppb'),'background-color','data-lead-form','lf-form-color'); -->