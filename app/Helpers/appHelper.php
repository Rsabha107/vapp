<?php

// namespace App\Http\Helpers;

use App\Models\Event;
use App\Models\Vapp\ParkingCapacity;
use App\Models\Vapp\VappRequest;
use App\Models\Vapp\VappRequestStatus;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


if (!function_exists('get_label')) {

    function get_label($label, $default, $locale = '')
    {
        if (Lang::has('labels.' . $label, $locale)) {
            return trans('labels.' . $label, [], $locale);
        } else {
            return $default;
        }
    }
}

if (!function_exists('getQrCode')) {

    function getQrCode($id, $size)
    {
        // $qr_code = QrCode::size($size)->generate($id);
        $qr_code = base64_encode(QrCode::format('svg')->size($size)->errorCorrection('H')->generate($id));

        return ($qr_code);
    }
}

if (!function_exists('time_range_segment')) {

    function time_range_segment($time_range, $segment)
    {
        if ($segment == 'from') {
            $return_segment = Str::substr($time_range, 0,  Str::position($time_range, "-") - 1);
            return $return_segment;
        } elseif ($segment == 'to') {
            $return_segment = Str::substr($time_range, Str::position($time_range, "-") + 1);
            return $return_segment;
        } else {
            return null;
        }
    }
}

/**
 * Generate initials from a name
 *
 * @param string $name
 * @return string
 */
if (!function_exists('generate')) {
    function generateInitials(string $name): string
    {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return mb_strtoupper(
                mb_substr($words[0], 0, 1, 'UTF-8') .
                    mb_substr(end($words), 0, 1, 'UTF-8'),
                'UTF-8'
            );
        }
        return makeInitialsFromSingleWord($name);
    }
}

/**
 * Make initials from a word with no spaces
 *
 * @param string $name
 * @return string
 */
if (!function_exists('makeInitialsFromSingleWord')) {
    function makeInitialsFromSingleWord(string $name): string
    {
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return mb_substr(implode('', $capitals[1]), 0, 2, 'UTF-8');
        }
        return mb_strtoupper(mb_substr($name, 0, 2, 'UTF-8'), 'UTF-8');
    }
}


if (!function_exists('format_date')) {
    function format_date($date, $time = null, $format = null, $apply_timezone = true)
    {
        if ($date) {
            // Log::info('date: '.$date);
            // Log::info('time: '.$time);
            // Log::info('format: '.$format);
            $format = $format ?? get_php_date_format();
            $time = $time ?? '';

            $date = $time != '' ? \Carbon\Carbon::parse($date) : \Carbon\Carbon::parse($date);

            // Log::info('date: '.$date);

            // if ($time !== '') {
            //     if ($apply_timezone) {
            //         $date->setTimezone(config('app.timezone'));
            //     }
            //     $format .= ' ' . $time;
            // }

            // Log::info($date->format($format));

            return $date->format($format);
        } else {
            return '-';
        }
    }
}

if (!function_exists('get_php_date_format')) {
    function get_php_date_format()
    {
        // $general_settings = get_settings('general_settings');
        $date_format = 'DD-MM-YYYY|d-m-Y';
        // $date_format = $general_settings['date_format'] ?? 'DD-MM-YYYY|d-m-Y';
        $date_format = explode('|', $date_format);
        return $date_format[1];
    }
}

if (!function_exists('get_settings')) {

    // function get_settings($variable)
    // {
    //     $fetched_data = Setting::all()->where('variable', $variable)->values();
    //     if (isset($fetched_data[0]['value']) && !empty($fetched_data[0]['value'])) {
    //         if (isJson($fetched_data[0]['value'])) {
    //             $fetched_data = json_decode($fetched_data[0]['value'], true);
    //         }
    //         return $fetched_data;
    //     }
    // }
}

if (!function_exists('get_approval_id')) {

    function get_approval_id($variable)
    {
        $ret = VappRequestStatus::where('title', $variable)->first();
        if ($ret) {
            return $ret->id;
        } else {
            return null;
        }
    }
}

if (!function_exists('get_totals')) {
    function get_totals($event_id, $venue_id,  $vapp_size_id, $parking_id, $variation_id, $status_name)
    {
        $status_id = get_approval_id($status_name);
        Log::info('Helper::appHelper get_totals $status_id: ' . $status_id);
        $query = VappRequest::where('event_id', $event_id)
            ->where('venue_id', $venue_id)
            ->where('parking_id', $parking_id)
            ->where('variation_id', $variation_id)
            ->where('vapp_size_id', $vapp_size_id)
            ->where('request_status_id', $status_id)->get();

        Log::info('event_id: ' . $event_id);
        Log::info('venue_id: ' . $venue_id);
        Log::info('vapp_size_id: ' . $vapp_size_id);
        Log::info('parking_id: ' . $parking_id);
        Log::info('variation_id: ' . $variation_id);
        Log::info('status_name: ' . $status_name);

        Log::info($query);
        $ret = $query->sum('approved_vapps');
        if ($ret) {
            return $ret;
        } else {
            return 0;
        }
    }
}

if (!function_exists('get_totals_capacity')) {
    function get_totals_capacity($event_id, $venue_id,  $vapp_size_id, $parking_id, $variation_id, $status_name)
    {
        $status_id = get_approval_id($status_name);
        Log::info('Helper::appHelper get_totals_capacity $status_id: ' . $status_id);

        $query = ParkingCapacity::with('parking_master.vapp_sizes')
            ->whereHas('parking_master.vapp_sizes', function ($q) use ($vapp_size_id) {
                $q->where('vapp_sizes.id', $vapp_size_id); // or any filter
            })->where('event_id', $event_id)
            ->where('venue_id', $venue_id)
            ->where('parking_id', $parking_id);

        $ret = $query->sum('capacity');

        // $query = ParkingCapacity::where('event_id', $event_id)
        //     ->where('venue_id', $venue_id)
        //     ->where('parking_id', $parking_id)
        //     ->where('variation_id', $variation_id)
        //     ->where('vapp_size_id', $vapp_size_id)
        //     ->where('request_status_id', $status_id)->get();

        Log::info('event_id: ' . $event_id);
        Log::info('venue_id: ' . $venue_id);
        Log::info('vapp_size_id: ' . $vapp_size_id);
        Log::info('parking_id: ' . $parking_id);
        Log::info('variation_id: ' . $variation_id);
        Log::info('status_name: ' . $status_name);

        // Log::info(json_encode($query));
        // $ret = $query->sum('approved_vapps');
        if ($ret) {
            return $ret;
        } else {
            return 0;
        }
    }
}




if (!function_exists('get_project_progress')) {

    function get_project_progress($id)
    {
        $project = Event::findOrFail($id);

        $progress_value = 0;
        $task_count = $project->tasks->count();
        $task_progress_sum = $project->tasks->sum('progress');

        if ($task_count) {
            $progress_value = round(($task_progress_sum / $task_count), 2);
        }

        // Log::info('Helper::appHelper $task_count: '.$task_count);
        // Log::info('Helper::appHelper $task_progress_sum: '.$task_progress_sum);
        // Log::info('Helper::appHelper $progress_value: '.$progress_value);

        return $progress_value;
    }
}
