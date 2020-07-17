<?php
/**
 * @return mixed
 * Custom functions made by themeqx
 */


/**
 * @return string
 */
if ( ! function_exists('pageJsonData')){
    function pageJsonData(){


        $jobModalOpen = false;
        if (session('job_validation_fails')){
            $jobModalOpen = true;
        }

        $data = [
            'facility_reg_valid_fail'     => session('facility_reg_valid_fail'),
        ];

        $routeLists = \Illuminate\Support\Facades\Route::getRoutes();

        $routes = [];
        foreach ($routeLists as $route){
            $routes[$route->getName()] = $data['home_url'].'/'.$route->uri;
        }
        $data['routes'] = $routes;

        return json_encode($data);
    }
}

function avatar_img_url($img = '', $source){
    $url_path = '';
    if ($img){
        if ($source == 'public'){
            $url_path = asset('uploads/avatar/'.$img);
        }elseif ($source == 's3'){
            $url_path = \Illuminate\Support\Facades\Storage::disk('s3')->url('uploads/avatar/'.$img);
        }
    }
    return $url_path;
}


/**
 * @param string $option_key
 * @return string
 */
function get_option($option_key = '', $default = false){
    $options = config('options');
    if(isset($options[$option_key])) {
        return $options[$option_key];
    }
    return $default;
}


/**
 * @param string $title
 * @param $model
 * @return string
 */

function unique_slug($title = '', $model = 'Job', $col = 'slug'){
    $slug = str_slug($title);
    if ($slug === ''){
        $string = mb_strtolower($title, "UTF-8");;
        $string = preg_replace("/[\/\.]/", " ", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $slug = preg_replace("/[\s_]/", '-', $string);
    }

    //get unique slug...
    $nSlug = $slug;
    $i = 0;

    $model = str_replace(' ','',"\App\ ".$model);
    while( ($model::where($col, '=', $nSlug)->count()) > 0){
        $i++;
        $nSlug = $slug.'-'.$i;
    }
    if($i > 0) {
        $newSlug = substr($nSlug, 0, strlen($slug)) . '-' . $i;
    } else
    {
        $newSlug = $slug;
    }
    return $newSlug;
}

/**
 * @param string $type
 * @return string
 *
 * @return stripe secret key or test key
 */

function get_stripe_key($type = 'publishable'){
    $stripe_key = '';

    if ($type == 'publishable'){
        if (get_option('stripe_test_mode') == 1){
            $stripe_key = get_option('stripe_test_publishable_key');
        }else{
            $stripe_key = get_option('stripe_live_publishable_key');
        }
    }elseif ($type == 'secret'){
        if (get_option('stripe_test_mode') == 1){
            $stripe_key = get_option('stripe_test_secret_key');
        }else{
            $stripe_key = get_option('sk_live_ojldRoMZ3j14I5pwpfCxidvT');
        }
    }

    return $stripe_key;
}

/**
 * @param int $ad_id
 * @param string $status
 */
function ad_status_change($ad_id = 0, $status = 1){
    if ($ad_id > 0){
        $ad = \App\Ad::find($ad_id);
        
        if ($ad){
            $previous_status = $ad->status;
            //Publish ad
            $ad->status = $status;
            $ad->save();
        }
    }

    return false;
}
function update_option($key, $value){
    $option = \App\Option::firstOrCreate(['option_key' => $key]);
    $option -> option_value = $value;
    return $option->save();
}

function e_form_error($field = '', $errors){
    $output = $errors->has($field)? '<span class="invalid-feedback" role="alert"><strong>'.$errors->first($field).'</strong></span>':'';
    return $output;
}

function e_form_invalid_class($field = '', $errors){
    return $errors->has($field) ? ' is-invalid' : '';
}


/**
 * Form Helper
 */

/**
 * @param $checked
 * @param bool $current
 * @param bool $echo
 * @return string
 */

if ( ! function_exists('checked')) {
    function checked($checked, $current = true, $echo = true)
    {
        return __checked_selected_helper($checked, $current, $echo, 'checked');
    }
}
/**
 * @param $selected
 * @param bool $current
 * @param bool $echo
 * @return string
 */

if ( ! function_exists('selected')) {
    function selected($selected, $current = true, $echo = true)
    {
        return __checked_selected_helper($selected, $current, $echo, 'selected');
    }
}

/**
 * @param $helper
 * @param $current
 * @param $echo
 * @param $type
 * @return string
 */

if ( ! function_exists('__checked_selected_helper')) {
    function __checked_selected_helper($helper, $current, $echo, $type)
    {
        if ((string)$helper === (string)$current)
            $result = " $type='$type'";
        else
            $result = '';

        if ($echo)
            echo $result;

        return $result;
    }
}
/**
 * End Form Helper
 */




