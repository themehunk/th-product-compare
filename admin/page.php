<?php if (!defined('ABSPATH')) exit; ?>
<div class="th-product-compare-wrap">
    <div class="th-product-compare-container">
        <nav class="th-nav_">
            <a href="#"><?php _e('General', 'th-product-compare'); ?></a>
            <a href="#"><?php _e('Style', 'th-product-compare'); ?></a>
            <a href="#"><?php _e('Setting', 'th-product-compare'); ?></a>
        </nav>
        <div class="th-setting_">
            <div class="th-appear">
                <h1>how to appear</h1>
            </div>

            <div class="th-option_">
                <h1>General Settings</h1>
                <table>
                    <tr>
                        <td>Link or Button</td>
                        <td>
                            <select name="input-type">
                                <option value="button">Button</option>
                                <option value="link">Link</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Text / Button Text</td>
                        <td>
                            <input type="text" name="input-text">
                        </td>
                    </tr>
                </table>
            </div>
            <button class="th-option-save-btn">Save</button>
        </div>
    </div>
</div>

