<?php
if (!defined('ABSPATH')) exit;
class th_compare_admin
{
    public $optionName = 'th_compare_option';
    public static function get()
    {
        return new self();
    }
    private function __construct()
    {
        add_action('wp_ajax_th_compare_save_data', array($this, 'save'));
    }


    public function save()
    {
        if (isset($_POST['inputs']) && is_array($_POST['inputs'])) {
            $result = $this->setOption($_POST['inputs']);
            echo $result ? 'update' : false;
        }

        die();
    }
    // cookies
    public function setOption($inputs)
    {
        $checkOption = get_option($this->optionName);
        $saveOption = $this->sanitizeOptions($inputs);
        if ($checkOption) {
            $result = update_option($this->optionName, $saveOption);
        } else {
            $result = add_option($this->optionName, $saveOption);
        }
        return $result;
    }

    function sanitizeOptions($arr)
    {
        $return = [];
        foreach ($arr as $key => $value) {
            if ($key && $value) {
                $x = sanitize_text_field($key);
                $v = sanitize_text_field($value);
                $return[$x] = $v;
            }
        }
        return $return;
    }


    // class end
}
