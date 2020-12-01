<?php

use App\DailyPerformance;
use Carbon\Carbon;
use App\Facility;
/**
 * @return mixed
 * Custom functions made by Cornel
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
            'client_reg_valid_fail'       => session('client_reg_valid_fail'),
            'case_manager_reg_valid_fail' => session('case_manager_reg_valid_fail'),
            'report_valid_fail'           => session('report_valid_fail'),
            'home_url'                    => route('home'),
            'asset_url'                   => asset('assets'),
            'csrf_token'                  => csrf_token(),
            'uploads'                     => asset('/assets/images/uploads/'),
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


/**
 * @return integer
 */
function getWeekRefillAvg()
{
    $refill = DailyPerformance::select('refill_performance')
            ->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
    $refill_arr = [];
    foreach ($refill as $val) {
        array_push($refill_arr, $val->refill_performance);
    }
    return ceil(collect($refill_arr)->average());
}

function getWeekViralLoadAvg()
{
    $vrl = DailyPerformance::select('viral_load_performance')
            ->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
    $vr_arr = [];
    foreach ($vrl as $val) {
        array_push($vr_arr, $val->viral_load_performance);
    }
    return ceil(collect($vr_arr)->average());
}

function getWeekIctAvg()
{
    $ict = DailyPerformance::select('ict_performance')
            ->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
    $ict_arr = [];
    foreach ($ict as $val) {
        array_push($ict_arr, $val->ict_performance);
    }
    return ceil(collect($ict_arr)->average());
}

function getWeekTptAvg()
{
    $tpt = DailyPerformance::select('tpt_performance')
            ->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
    $tpt_arr = [];
    foreach ($tpt as $val) {
        array_push($tpt_arr, $val->tpt_performance);
    }
    return ceil(collect($tpt_arr)->average());
}

function getWeekTrackingAvg()
{
    $tracking = DailyPerformance::select('tracking_performance')
            ->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
    $tr_arr = [];
    foreach ($tracking as $val) {
        array_push($tr_arr, $val->tracking_performance);
    }
    return ceil(collect($tr_arr)->average());
}

function getWeekAttAvg()
{
    $att = DailyPerformance::select('attendance_performance')
            ->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
    $att_arr = [];
    foreach ($att as $val) {
        array_push($att_arr, $val->attendance_performance);
    }
    return ceil(collect($att_arr)->average());
}

/**
 * Custom function 
 * To calcualte diff in performance 
 * between this week and the last
 * Calcualate for all indicators
 * @return integer
 * Custom functions made by Cornel
 */

function performanceDiff($indicator, $thisWeekAvg)
{
    $diff = 0;
    // get the last week avg for the indicator
    $lastWeekAvg = lastWeekIndicatorAvg($indicator);
    if ($lastWeekAvg !== 0) {
        $diff = $thisWeekAvg - $lastWeekAvg;
    }
    return $diff;
}

//function to get the last week average for the indicator 
function lastWeekIndicatorAvg($indicator)
{
    $indicatorAvg = DailyPerformance::select($indicator)
                    ->whereBetween('created_at', [
                        Carbon::now()->subWeek(),
                        Carbon::now()->startOfWeek()
                    ])->get();
    if ($indicatorAvg->count() > 0) {
        $val_arr = [];
        foreach ($indicatorAvg as $val) {
            array_push($val_arr, $val->$indicator);
        }
        return ceil(collect($val_arr)->average());
    }else{
        return 0;
    }
}

/**
 * Custom calculate report average
 * @return integer
 * Custom functions made by Cornel
 */
function calcAverage($report)
{
   $collection = collect([
                    ceil(($report->viral_load_numo / $report->viral_load_deno)*100),
                    ceil(($report->refill_numo / $report->refill_deno)*100),
                    ceil(($report->ict_numo / $report->ict_deno)*100),
                    ceil(($report->tpt_numo / $report->tpt_deno)*100),
                    100
                ]);
   return ceil($collection->average());
}

function timeAgo($date)
{
    $timestamp = strtotime($date);
    $strTime = array('sec','min','hour','day','month','year');
    $length = array('60','60','24','30','12','10');

    $currentTime = time();
    if ($currentTime >= $timestamp) {
        $diff = time() - $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++){
            $diff = $diff/$length[$i];
        }

        $diff = round($diff);
        return $diff.' '.$strTime[$i].'(s) ago';
    }
}

//get a specific case manager average weekly peformance
function cm_performance($case_mg){
    $performances = $case_mg->performances;
    $perf_arr = array_map(function($performances){
        return $performances['performance'];
    }, $performances->toArray());
    return collect($perf_arr)->avg();
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

function e_form_error($field = '', $errors){
    $output = $errors->has($field)? '<span class="invalid-feedback" role="alert"><strong>'.$errors->first($field).'</strong></span>':'';
    return $output;
}

function e_form_invalid_class($field = '', $errors){
    return $errors->has($field) ? ' is-invalid' : '';
}

/**
     * convert a csv to an array 
     * for import into db
     *
     * @return \Illuminate\Http\Response
     */
    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

            $header = null;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    if (!$header) 
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            return $data;
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

if (! function_exists('__facilities')) {
    function __facilities()
    {
        return Facility::all();
    }
}
/**
 * End Form Helper
 */




