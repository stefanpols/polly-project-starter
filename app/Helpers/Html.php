<?php

namespace App\Helpers;


use PHPMailer\PHPMailer\PHPMailer;
use Polly\Core\Config;
use Polly\Core\Logger;
use Polly\Core\View;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;


class Html
{
    public static function formHidden(string $field, string $value) : string
    {
        return '<input type="hidden" name="'.$field.'" value="'.$value.'">';
    }

    public static function formInput(string $label, string $field, string $value=null, $class=null, $attributes=null) : string
    {
        return '<div class="row">
                        <label class="col-md-3 form-label">'.$label.'</label>
                        <div class="col-md-9">
                            <input autocomplete="off" '.($attributes?:"").' class="form-control-solid form-control-sm form-control '.$class.'" placeholder="'.$label.'" name="'.$field.'" value="'.$value.'">
                        </div>
                    </div>';
    }

    public static function formTextarea(string $label, string $field, string $value=null, $class=null, $attributes=null) : string
    {
        return '<div class="row">
                        <label class="col-md-3 form-label">'.$label.'</label>
                        <div class="col-md-9">
                            <textarea autocomplete="off" '.($attributes?:"").' class="form-control-solid form-control-sm form-control '.$class.'" placeholder="'.$label.'" name="'.$field.'">'.$value.'</textarea>
                        </div>
                    </div>';
    }

    public static function formSelect(string $label, string $field, string $value=null, array $options=[]) : string
    {
        $select = '<div class="row">
                        <label class="col-md-3 form-label">'.$label.'</label>
                        <div class="col-md-9">
                            <select autocomplete="off" class="select2 form-control form-select form-select-sm form-control-solid" name="'.$field.'" placeholder="'.$label.'">';

        foreach($options as $key=>$name)
        {
            $select .= '<option value="'.$key.'" '.($value == $key ? 'selected' : '').'>'.$name.'</option>';
        }

        $select .= '        </select>
                        </div>
                    </div>';

        return $select;
    }
}
