<?php
if (!defined('ABSPATH')) exit;
$blankImgUrl = TH_PRODUCT_URL . '/assets/img/blank.png';
$th_headingText = isset($th_compare_option['compare-heading-text']) ? $th_compare_option['compare-heading-text'] : esc_html__('Compare Product', 'th-product-compare-pro');
$th_countText = isset($th_compare_option['compare-count-text']) ? $th_compare_option['compare-count-text'] : esc_html__('{count} { items shown}', 'th-product-compare-pro');
$th_openerBtnText = isset($th_compare_option['compare-opener-btn-text']) ? $th_compare_option['compare-opener-btn-text'] : esc_html__('Product Compare', 'th-product-compare-pro');
$th_product_position = isset($th_compare_option['compare-popup-position']) ? $th_compare_option['compare-popup-position'] : 'bottom';
$th_product_Animation = isset($th_compare_option['compare-popup-animation']) ? $th_compare_option['compare-popup-animation'] : '';
$th_product_atleast_txt = isset($th_compare_option['compare-atleast-text']) ? sanitize_text_field($th_compare_option['compare-atleast-text']) : __('{Selected} {Products}', 'th-product-compare');
        // regex: {text}
        preg_match_all('/\{([^}]+)\}/', $th_product_atleast_txt, $matches);
        // Default fallback
        $first_text  = $matches[1][0] ?? '';
        $second_text = $matches[1][1] ?? '';

$tablestyle_in_mobile = isset($th_compare_option['tablestyle-in-mobile']) ? sanitize_text_field($th_compare_option['tablestyle-in-mobile']) : 'mobile-flex';

function th_apply_color($title, $prop, $color_id = false)
{
    if ($title && $prop && $color_id) {
?>
        <div class="th-color-picker">
            <label class="th-color-title"><?php echo esc_html($title); ?></label>
            <div>
                <label class="color-output" data-th-color="<?php echo esc_attr($color_id); ?>" output-type="<?php echo esc_attr($prop); ?>"></label>
            </div>
        </div>
<?php
    }
}
$blankImage = '<img data-th-output="product-img-bg-color" data-th-save="style" data-th="background-color"  src="' . esc_attr($blankImgUrl) . '">';
$blankImage2 = '<img src="' . esc_attr($blankImgUrl) . '">';
?>
<div class="style_">
     
    <div class="dummy-and-style">
        <div class="style-setting_">
           
            <div class="nav_">
                <a data-group-tabs="style-nav" data-tab="style" href="#" class="active"><?php esc_html_e('Compare Bar Settings', 'th-product-compare-pro'); ?></a>
                <a data-group-tabs="style-nav" data-tab="setting" href="#"><?php esc_html_e('Popup Settings', 'th-product-compare-pro'); ?></a>
            </div>
            <div class="container_">
                <div data-group-tabs="style-nav" data-tab-container="style" class="active">
                    <div class="th-color-output">
                        <span class="bold-heading"><?php esc_html_e('Comapre Bar', 'th-product-compare-pro'); ?></span>
                         <input data-innerdynamic="1" data-th-save='compare-atleast-text' type="text" placeholder="Compare" value="<?php echo esc_html($th_product_atleast_txt); ?>">
                        <i class="description compareatleast"><?php esc_html_e('Use format Text:', 'th-product-compare-pro'); ?> <code><?php esc_html_e( '{selected} {products}', 'th-product-compare-pro' ); ?></code>
</i>
                       <?php
                        th_apply_color('Background', 'background-color', 'footer-bar-bg-color');
                        th_apply_color('Content Color', 'color', 'footer-content-color');
                        th_apply_color('Button Color', 'color', 'footer-bar-btn-color');
                        th_apply_color('Button Background Color', 'background-color', 'footer-bar-btn-color');
                       
                        // -------------- x --------------
                        ?>

                      
                        
                        
                        
                        
                      
                      
                       
                    </div>
                </div>
                <div data-group-tabs="style-nav" data-tab-container="setting">
                    <div class="th-color-output">
                        <div class="th-color-picker th-input input-block">
                            <span class="bold-heading"><?php esc_html_e('Popup Heading Text', 'th-product-compare-pro'); ?></span>
                            <input data-innerdynamic="1" data-th-save='compare-heading-text' type="text" value="<?php echo esc_attr($th_headingText); ?>">
                             
                            <span class="th-color-title popupcount"><?php esc_html_e('Popup Count Text', 'th-product-compare-pro'); ?></span>
                            <input data-innerdynamic="1" data-th-save='compare-count-text' type="text" value="<?php echo esc_attr($th_countText); ?>">
                            <i class="description compareatleast"><?php esc_html_e( 'Use format. You can change count position:', 'th-product-compare-pro' ); ?> <code><?php esc_html_e( '{count} {Text to be shown.}', 'th-product-compare-pro' ); ?></code></i>
                        </div>

                        <div class="th-color-picker th-input input-block">
                            <label class="th-color-title"><?php esc_html_e('Popup Animation', 'th-product-compare-pro'); ?></label>
                            <select data-innerdynamic="1" data-th-save='compare-popup-animation'>
                                <option value="1" <?php selected( $th_product_Animation, '1' ); ?>>
                                    <?php esc_html_e( 'Top Slide', 'th-product-compare-pro' ); ?>
                                </option>

                                <option value="2" <?php selected( $th_product_Animation, '2' ); ?>>
                                    <?php esc_html_e( 'Left Slide', 'th-product-compare-pro' ); ?>
                                </option>

                                <option value="3" <?php selected( $th_product_Animation, '3' ); ?>>
                                    <?php esc_html_e( 'Right Slide', 'th-product-compare-pro' ); ?>
                                </option>

                                <option value="4" <?php selected( $th_product_Animation, '4' ); ?>>
                                    <?php esc_html_e( 'ZoomIn', 'th-product-compare-pro' ); ?>
                                </option>

                            </select>
                        </div>

                        <div class="th-color-picker th-input input-block popup-position">
                            <label class="th-color-title"><?php esc_html_e('Popup Position', 'th-product-compare-pro'); ?></label>
                            <select data-innerdynamic="1" data-th-save='compare-popup-position'>
                                <option value="bottom" <?php echo $th_product_position == 'bottom' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Bottom', 'th-product-compare-pro'); ?></option>
                                <option value="left" <?php echo $th_product_position == 'left' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Left', 'th-product-compare-pro'); ?></option>
                                <option value="right" <?php echo $th_product_position == 'right' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Right', 'th-product-compare-pro'); ?></option>
                                <option value="top" <?php echo $th_product_position == 'top' ? esc_attr("selected") : ''; ?>><?php esc_html_e('Top', 'th-product-compare-pro'); ?></option>
                            </select>
                        </div>

                         <span class="bold-heading"><?php esc_html_e('Global Colors', 'th-product-compare-pro'); ?></span>
                        <?php
                        th_apply_color('Global Background Color', 'background-color', 'global-background'); ?>
                        <span class="bold-heading"><?php esc_html_e('Header', 'th-product-compare-pro'); ?></span>
                        <?php
                        th_apply_color('Color', 'color', 'heading-style');
                        th_apply_color('Background Color', 'background-color', 'heading-style-bg');
                        // -------------- x --------------
                        ?>
                         <span class="bold-heading"><?php esc_html_e('Table', 'th-product-compare-pro'); ?></span>
                         <?php
                        th_apply_color('Table Content Color', 'color', 'table-content-color');
                        // th_apply_color('Even Row Background Color', 'background-color', 'row-even-bg');
                        // th_apply_color('Odd Row Background Color', 'background-color', 'row-odd-bg');
                        th_apply_color('Table Background Color', 'background-color', 'product-img-bg-color');
                        th_apply_color('Border Color', 'border-color', 'dummy-border-color');
                        th_apply_color('Rating Color', 'color', 'rating-color');
                        th_apply_color('Remove Button Text Color', 'color', 'remove-btn-color');
                        // -------------- x --------------
                        ?>
                        <span class="bold-heading"><?php esc_html_e('Image Remove Icon', 'th-product-compare-pro'); ?></span>
                        <?php
                        th_apply_color('Icon Color', 'color', 'img-remove-icon-color');
                        th_apply_color('Background Color', 'background-color', 'img-remove-icon-color');
                        ?>
                        <div class="th-color-picker th-input input-block">
                            <label class="th-color-title"><?php esc_html_e('Button Size (px)', 'th-product-compare-pro'); ?></label>
                            <input data-th-save='img-remove-btn-size' type="number" min="16" max="48" value="<?php echo isset($th_compare_option['img-remove-btn-size']) ? intval($th_compare_option['img-remove-btn-size']) : 18; ?>">
                        </div>
                        <?php
                        // -------------- x --------------
                        ?>

                        <span class="bold-heading"><?php esc_html_e('Add To Cart', 'th-product-compare-pro'); ?></span>
                        <?php
                        th_apply_color('Color', 'color', 'add-to-cart');
                        th_apply_color('Background Color', 'background-color', 'add-to-cart');
                        // -------------- x --------------
                        ?>

                        <span class="bold-heading"><?php esc_html_e('Close Button', 'th-product-compare-pro'); ?></span>
                        <?php
                        th_apply_color('Color', 'color', 'close-btn-style');
                        th_apply_color('Background Color', 'background-color', 'close-btn-style');
                        // -------------- x --------------
                        ?>
                      
                    </div>

                </div>
            </div>
        </div>
        <div class="th-compare-popup-dummy th-compare-output-wrap">
            <div class="inner-wrap_ " data-th-output="dummy-border-color" data-th-save='style' data-th='border-color'>
            
               <div class="thpreviewbox" style="padding-top: 82px;">

                <div class="th-compare-output-wrap-inner th-popup-preview" data-th-output="global-background" data-th-save="style" data-th="background-color">
                <div class="preview-top-header"><span></span><span></span><span></span></div>
    <div class="th-compare-heading" data-th-output="heading-style-bg" data-th-save="style" data-th="background-color|color">
        <div class="headingwrap">
            <span class="heading_" data-th-output="heading-style" data-th-save='style' data-th='color'><?php echo esc_html($th_headingText); ?></span>
            <span class="th-compare-count" data-th-output="heading-style" data-th-save='style' data-th='color'><?php esc_html_e('2 Items Shown','th-product-compare-pro'); ?></span>
        </div>
        <span class="error_"></span>
        <div class="th-compare-output-close">
            <i class="dashicons dashicons-no-alt" data-th-output="close-btn-style" data-th-save='style' data-th='background-color|color'></i>
        </div>
        <div class="wrap-category_">
            <div class="wrap-category_inner">
                <a href="#" data-compare-category="all" class="active"><?php esc_html_e('All','th-product-compare-pro'); ?></a>
                <a href="#" data-compare-category="hoodies"><?php esc_html_e('Tshirts','th-product-compare-pro'); ?></a>
            </div>
        </div>
        <div class="th-heighlights-products">
            <div class="th-hide-similarities" data-th-output="heading-style" data-th-save='style' data-th='color'><?php esc_html_e('Hide Similarities','th-product-compare-pro'); ?></div>
            <div class="th-highlight-difference" data-th-output="heading-style" data-th-save='style' data-th='color'><?php esc_html_e('Highlight Differences','th-product-compare-pro'); ?></div>
        </div>
    </div>

    <div class="th-compare-output-product">
        <table class="product-table-configure woocommerce th-desktop-type-displey with-footer-bar" data-th-output="product-img-bg-color" data-th-save="style" data-th="background-color">
            <tbody data-th-output="table-content-color" data-th-save="style" data-th="background-color|color">
                <tr class="_product_details_">
                    <td class="left-title"><span><?php esc_html_e('Product Details','th-product-compare-pro'); ?></span></td>
                    
                    <!-- First Product: Sunglasses -->
                    <td class="thcpr-by-all thcpr-by-accessories">
                        <div class="pc-product-details">
                            <div class="_image_">
                                <div class="image-and-addcart">
                                    <div class="img_">
                                        <button class="th-img-remove-btn" data-th-output="img-remove-icon-color" data-th-save="style" data-th="background-color|color"><i class="dashicons dashicons-no-alt"></i></button>
                                        <a target="_blank" href="#">
                                            <?php echo wp_kses($blankImage, th_product_compare::$allowKsesAttr);  ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="_title_">
                                <div class="product-title_">
                                    <a target="_blank" href="#"><?php esc_html_e('Title','th-product-compare-pro'); ?></a>
                                </div>
                            </div>
                            <div class="_SKU_" ><?php esc_html_e('SkU','th-product-compare-pro'); ?></div>
                            <div class="_price_">
                                <div class="price_">
                                    <span class="price_">
                                        <span class="woocommerce-Price-amount amount" >
                                            <bdi><span class="woocommerce-Price-currencySymbol" ><?php esc_html_e('$','th-product-compare-pro') ?></span><?php esc_html_e('90.00','th-product-compare-pro'); ?></bdi>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="_add-to-cart_">
                                <div class="th-add-to-cart_" data-th-output="add-to-cart" data-th-save="style" data-th="background-color|color">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart" aria-hidden="true">
                                        <circle cx="8" cy="21" r="1"></circle>
                                        <circle cx="19" cy="21" r="1"></circle>
                                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                                    </svg>
                                    <a href="#" 
                                       data-quantity="1" 
                                       class="th-compare-add-to-cart-btn" 
                                       rel="nofollow"><?php esc_html_e('Add to cart','th-product-compare-pro') ?></a>
                                </div>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Second Product: Hoodie with Zipper -->
                    <td class="thcpr-by-all thcpr-by-hoodies">
                        <div class="pc-product-details">
                            <div class="_image_">
                                <div class="image-and-addcart">
                                    <div class="img_">
                                        <button class="th-img-remove-btn" data-th-output="img-remove-icon-color" data-th-save="style" data-th="background-color|color"><i class="dashicons dashicons-no-alt"></i></button>
                                        <a target="_blank" href="#">
                                            <?php echo wp_kses($blankImage, th_product_compare::$allowKsesAttr);  ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="_title_">
                                <div class="product-title_">
                                    <a target="_blank" href="#"><?php esc_html_e('Title','th-product-compare-pro'); ?></a>
                                </div>
                            </div>
                            <div class="_SKU_" ><?php esc_html_e('SkU','th-product-compare-pro'); ?></div>
                            <div class="_price_">
                                <div class="price_">
                                    <span class="price_">
                                        <span class="woocommerce-Price-amount amount" >
                                            <bdi><span class="woocommerce-Price-currencySymbol" ><?php esc_html_e('$','th-product-compare-pro') ?></span><?php esc_html_e('90.00','th-product-compare-pro'); ?></bdi>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="_add-to-cart_">
                                <div class="th-add-to-cart_" data-th-output="add-to-cart" data-th-save="style" data-th="background-color|color">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart" aria-hidden="true">
                                        <circle cx="8" cy="21" r="1"></circle>
                                        <circle cx="19" cy="21" r="1"></circle>
                                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                                    </svg>
                                    <a href="#" 
                                       data-quantity="1" 
                                       class="th-compare-add-to-cart-btn" 
                                       rel="nofollow"><?php esc_html_e('Add to cart','th-product-compare-pro') ?></a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr class="_rating_">
                    <td class="left-title"><span><?php esc_html_e('Rating','th-product-compare-pro'); ?></span></td>
                    <td class="thcpr-by-all thcpr-by-accessories">
                        <div class="mobile-title"><?php esc_html_e('Rating','th-product-compare-pro'); ?></div>
                        <span class="th-compare-rating">
                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5" data-th-output="rating-color" data-th-save='style' data-th='color'>
                                <span></span>
                            </div>
                        </span>
                    </td>
                    <td class="thcpr-by-all thcpr-by-hoodies">
                        <div class="mobile-title"><?php esc_html_e('Rating','th-product-compare-pro'); ?></div>
                        <span class="th-compare-rating">
                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5" data-th-output="rating-color" data-th-save='style' data-th='color'>
                                <span></span>
                            </div>
                        </span>
                    </td>
                </tr>

                <tr class="_description_">
                    <td class="left-title"><span ><?php esc_html_e('Description','th-product-compare-pro'); ?></span></td>
                    <td class="thcpr-by-all thcpr-by-accessories">
                        <div class="mobile-title"><?php esc_html_e('Description','th-product-compare-pro'); ?></div>
                        <span><?php esc_html_e('This is a simple product.','th-product-compare-pro'); ?></span>
                    </td>
                    <td class="thcpr-by-all thcpr-by-hoodies">
                        <div class="mobile-title">Description</div>
                        <span><?php esc_html_e('This is a simple product.','th-product-compare-pro'); ?></span>
                    </td>
                </tr>

                <tr class="_availability_">
                    <td class="left-title"><span><?php esc_html_e('Availability','th-product-compare-pro'); ?></span></td>
                    <td class="thcpr-by-all thcpr-by-accessories">
                        <div class="mobile-title"><?php esc_html_e('Availability','th-product-compare-pro'); ?></div>
                        <span class="th-in-stoct"><?php esc_html_e('in stock','th-product-compare-pro'); ?></span>
                    </td>
                    <td class="thcpr-by-all thcpr-by-hoodies">
                        <div class="mobile-title"><?php esc_html_e('Availability','th-product-compare-pro'); ?></div>
                        <span class="th-in-stoct"><?php esc_html_e('in stock','th-product-compare-pro'); ?></span>
                    </td>
                </tr>

            

            </tbody>
        </table>
    </div>
</div> <!-- th-popup-preview -->

        <!-- th-footerbox-preview -->

     <div class="th-compare-output-wrap-inner th-footerbox-preview">
        <div class="preview-top-header"><span></span><span></span><span></span></div>
        <div class="th-compare-footer-wrap active position-bottom">
    <div class="th-compare-footer-level2" data-th-output="footer-bar-bg-color" data-th-save="style" data-th="background-color|color">
        <div class="th-compare-footer-level3">
            
            <!-- Left Section -->
            <div class="th-compare-left">
                
                <p class="th-atleast">
                    <span class="th-selected" data-th-output="footer-content-color" data-th-save="style" data-th="background-color|color"><?php echo esc_html($first_text); ?></span>
                    <span class="th-select-count" data-th-output="footer-content-color" data-th-save="style" data-th="background-color|color"><?php echo esc_html($second_text); ?> </span>
                </p>
                
                <div class="product_image">
                    <!-- Product 1: Sunglasses -->
                    <div data-product-id="21" class="img_">
                        <i class="th-remove-product th-compare-product-remove" data-th-product-id="21"></i>
                        <a target="_blank" href="http://localhost/wp2025/product/sunglasses/">
                            <?php echo wp_kses($blankImage, th_product_compare::$allowKsesAttr);  ?>
                        </a>
                    </div>
                    
                    <!-- Product 2: Hoodie with Zipper -->
                    <div data-product-id="23" class="img_">
                        <i class="th-remove-product th-compare-product-remove" data-th-product-id="23"></i>
                        <a target="_blank" href="http://localhost/wp2025/product/hoodie-with-zipper/">
                            <?php echo wp_kses($blankImage, th_product_compare::$allowKsesAttr);  ?>
                        </a>
                    </div>
                </div>
                
                <div class="th-addremove" >
                    <a href="#" class="th-add-product-bar">
                        <i class="dashicons dashicons-plus"></i>
                    </a>
                    <span class="th-compare-limit-count" data-th-output="footer-content-color" data-th-save="style" data-th="background-color|color"><span class="th-current-count">2</span>/<span class="th-max-count">8</span></span>
                </div>
            </div>
            
            <!-- Right Section -->
            <div class="th-compare-right">
                <a id="thpc-removeall" data-th-output="footer-content-color" data-th-save="style" data-th="background-color|color">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                         stroke-linejoin="round" class="lucide lucide-trash2 lucide-trash-2" aria-hidden="true">
                        <path d="M10 11v6"></path>
                        <path d="M14 11v6"></path>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                        <path d="M3 6h18"></path>
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                </a>
                
                <div class="th-compare-enable">
                    <a href="#" class="th-compare-footer-product-opner" data-th-output="footer-bar-btn-color" data-th-save="style" data-th="background-color|color">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                             stroke-linejoin="round" class="lucide lucide-layers text-indigo-600" aria-hidden="true">
                            <path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path>
                            <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path>
                            <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path>
                        </svg>
                        <span class="text_"><?php esc_html_e('Compare','th-product-compare-pro'); ?></span>
                    </a>
                </div>
            </div>
            
        </div>
        
    </div>
</div>

     </div> <!-- th-footerbox-preview -->



</div> <!-- th-compare-output-wrap-inner -->

            </div>
        </div>

    </div>
</div>