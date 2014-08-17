<?php

class FormHelper
{
    public static function array2options($array, $selected = NULL)
    {
        $options = '';
        
        foreach ($array as $value => $option) {
            if (is_array($option)) {
                $options .= '<optgroup label="' . $value . '">';
                $options .= self::array2options($option, $selected);
                $options .= '</optgroup>';
            } else {
                $options .= '<option value="' . $value . '"';
                
                if (isset($selected) &&
                    ((is_string($selected) && strcmp($value, $selected) == 0)
                      || ($selected === $value))
                ) {
                    $options .= ' selected="selected"';
                }
                
                $options .= ' >' . $option;
                $options .= '</option>';
            }
        }
        
        return $options;
    }
}

