<?php

use App\Models\FormCustom;
use App\Models\FormOption;
use App\Models\FormResponse;
use App\Models\Fragment;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\User;

if (!function_exists('setting')) {
    function setting($key)
    {
        $data = Setting::key($key);
        return $data;
    }
}

if (!function_exists('semesters')) {
    function semesters()
    {
        $data = Semester::orderBy('position', 'desc')->take(6)->get();
        return $data;
    }
}

if (!function_exists('semesterActive')) {
    function semesterActive()
    {
        $data = Semester::whereStatus(1)->first();
        return $data;
    }
}

if (!function_exists('getFormResponse')) {
    function getFormResponse($formId)
    {
        $data = FormResponse::where('form_custom_id', $formId)->get();
        return $data;
    }
}

if (!function_exists('formBuilder')) {
    function formBuilder($data)
    {
        $html = '';
        $required = '';

        if (!empty($jsonValidator = json_decode($data->validator, true))) {
            if (in_array('required', $jsonValidator))
                $required = 'required';
        }
        switch ($data->type) {
            case 'text':
            case 'number':
                $html = "<input type='$data->type' class='form-control' name='$data->name' placeholder='$data->placeholder' $required>";
                break;
            case 'linear_scale':
                $fo = FormOption::where('form_custom_id', $data->id)->get();
                $len = count($fo);

                foreach ($fo as $key => $f) {
                    $labelStart = '';
                    $labelEnd = '';
                    
                    if ($key == 0)
                        $labelStart = "<small><label class=\"form-check-label\" for=\"inlineCheckbox2\">$f->option_label</label></small>";
                    
                    if ($key == ($len - 1))
                        $labelEnd = "<small><label class=\"form-check-label\" for=\"inlineCheckbox2\">$f->option_label_2</label></small>";
                    // $html .= "<input type='radio' class='form-control form-inline' name='$data->name' value='$f->option_value' $required>";
                    $html .= "
                        <div class=\"form-check form-check-inline\">
                            $labelStart&nbsp;
                            <input class=\"form-check-input\" type=\"radio\" id=\"inlineCheckbox1\" value=\"$f->option_value\" name=\"$data->name\" $required>
                            $labelEnd&nbsp;
                        </div>
                    ";
                }
                break;
            case 'textarea':
                $html = "<textarea name=\"$data->name\" $required placeholder=\"$data->placeholder\"></textarea>";
                break;
            case 'combobox':
                $fo = FormOption::where('form_custom_id', $data->id)->get();
                $html = "<select name=\"$data->name\" $required>";

                foreach ($fo as $key => $f)
                    $html .= "<option value=\"$f->option_value\">$f->option_label</option>";

                $html .= '</select>';
                break;
            case 'radio':
            case 'checkbox':
                $fo = FormOption::where('form_custom_id', $data->id)->get();
                $len = count($fo);
                $arr = '';
                if ($data->type == 'checkbox')
                    $arr = '[]';
                
                foreach ($fo as $key => $f) {
                    $html .= "
                        <div class=\"form-check form-check-inline\">
                            <input class=\"form-check-input\" type=\"$data->type\" id=\"inlineCheckbox1\" value=\"$f->option_value\" name=\"$data->name$arr\" $required>
                            $f->option_label&nbsp;
                        </div>
                    ";
                }
                break;
        }
        return $html;
    }

    function getNameByEmail($email)
    {
        if (!empty($email)) {
            $user = User::whereEmail($email)->first();
            return "by $user->name";
        }

        return '';
    }
}

if (!function_exists('ytParse')) {
    function ytParse($link)
    {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $matches);
        
        return $matches[0] ?? false;
    }
}

if (!function_exists('localLink')) {
    function localLink($locale)
    {
        $path = request()->path();
        $web = request()->getSchemeAndHttpHost();

        $queryStr = '';
        if (!empty($_SERVER['QUERY_STRING']))
            $queryStr = '?'.$_SERVER['QUERY_STRING'];

        $fix = "$web/$locale/$path$queryStr";

        if (in_array('id', explode('/', $path)) || in_array('en', explode('/', $path))) {
            $exp = explode('/', $path);
            //del first el arr
            array_shift($exp);
            $joinPath = implode('/', $exp);

            if (!empty($_SERVER['QUERY_STRING']))
                $queryStr = '?'.$_SERVER['QUERY_STRING'];

            $fix = "$web/$locale/$joinPath".$queryStr;
        }
        
        return $fix;
    }
}

if (!function_exists('getLang')) {
    function getLang()
    {
        return empty(session()->get('lang')) ? "en." : session()->get('lang');
    }
}

if (!function_exists('clearDot')) {
    function clearDot($str)
    {
        return str_replace('.', '', $str);
    }
}

// if (!function_exists('__')) {
    function ___($key)
    {
        return Fragment::getTranslate($key);
    }
// }