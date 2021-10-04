<?php ?>
<div class="setting_">
    <span class="th-tab-heading"><?php _e('Advance Setting', 'th-product-compare'); ?></span>
    <div class="field-to-show">
        <table>
            <tbody>
                <tr>
                    <td>Field To Show</td>
                    <td>
                        <div class="th-compare-radio">
                            <!--image-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-image" value="image">
                            <label for="compare-fields-image">Image</label>
                        </div>
                        <div class="th-compare-radio">
                            <!--title-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-title" value="title">
                            <label for="compare-fields-title">Title</label>
                        </div>
                        <div class="th-compare-radio">
                            <!--price-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-price" value="price">
                            <label for="compare-fields-price">Price</label>
                        </div>
                        <div class="th-compare-radio">
                            <!--add-to-cart-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-add-to-cart" value="add-to-cart">
                            <label for="compare-fields-add-to-cart">Add To Cart</label>
                        </div>
                        <div class="th-compare-radio">
                            <!--description-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-description" value="description">
                            <label for="compare-fields-description">Description</label>
                        </div>
                        <div class="th-compare-radio">
                            <!--sku-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-sku" value="sku">
                            <label for="compare-fields-sku">SKU</label>
                        </div>
                        <div class="th-compare-radio">
                            <!--availability-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-availability" value="availability">
                            <label for="compare-fields-availability">Availability</label>
                        </div>


                        <div class="th-compare-radio">
                            <!--weight-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-weight" value="weight">
                            <label for="compare-fields-weight">Weight</label>
                        </div>
                        <div class="th-compare-radio">
                            <!--dimension-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-dimension" value="dimension">
                            <label for="compare-fields-dimension">Dimension</label>
                        </div>
                        <div class="th-compare-radio">
                            <!--size-->
                            <input type="checkbox" name='compare-fields[]' data-th-save='compare-field' id="compare-fields-size" value="size">
                            <label for="compare-fields-size">Size</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>