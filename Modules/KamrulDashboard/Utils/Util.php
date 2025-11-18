<?php

namespace Modules\KamrulDashboard\Utils;

use App\Utils\obj;
use App\Utils\strin;
use Config;
use GuzzleHttp\Client;

class Util
{
    /**
     * This function unformats a number and returns them in plain eng format
     *
     * @param int $input_number
     *
     * @return float
     */
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = '';
        $decimal_separator  = '';

        if (!empty($currency_details)) {
            $thousand_separator = $currency_details->thousand_separator;
            $decimal_separator = $currency_details->decimal_separator;
        } else {
            $thousand_separator = session()->has('currency') ? session('currency')['thousand_separator'] : '';
            $decimal_separator = session()->has('currency') ? session('currency')['decimal_separator'] : '';
        }

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }


    /**
    * Calculates percentage for a given number
    *
    * @param int $number
    * @param int $percent
    * @param int $addition default = 0
    *
    * @return float
    */
    public function calc_percentage($number, $percent, $addition = 0)
    {
        return ($addition + ($number * ($percent / 100)));
    }

    /**
     * Calculates base value on which percentage is calculated
     *
     * @param int $number
     * @param int $percent
     *
     * @return float
     */
    public function calc_percentage_base($number, $percent)
    {
        return ($number * 100) / (100 + $percent);
    }

    /**
     * Calculates percentage
     *
     * @param int $base
     * @param int $number
     *
     * @return float
     */
    public function get_percent($base, $number)
    {
        if ($base == 0) {
            return 0;
        }

        $diff = $number - $base;
        return ($diff / $base) * 100;
    }

    //Returns all avilable purchase statuses
    public function orderStatuses()
    {
        return [ 'received' => __('kamruldashboard::lang_v1.received'), 'pending' => __('kamruldashboard::lang_v1.pending'), 'ordered' => __('kamruldashboard::lang_v1.ordered')];
    }


    /**
     * Returns the list of modules enabled
     *
     * @return array
     */
    public function allModulesEnabled()
    {
        $enabled_modules = session()->has('business') ? session('business')['enabled_modules'] : null;
        $enabled_modules = (!empty($enabled_modules) && $enabled_modules != 'null') ? $enabled_modules : [];

        return $enabled_modules;
        //Module::has('Restaurant');
    }

    /**
     * Returns the list of modules enabled
     *
     * @return array
     */
    public function isModuleEnabled($module)
    {
        $enabled_modules = $this->allModulesEnabled();

        if (in_array($module, $enabled_modules)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Converts date in business format to mysql format
     *
     * @param string $date
     * @param bool $time (default = false)
     * @return strin
     */
    public function uf_date($date, $time = false)
    {
        $date_format = session('business.date_format');
        $mysql_format = 'Y-m-d';
        if ($time) {
            if (session('business.time_format') == 12) {
                $date_format = $date_format . ' h:i A';
            } else {
                $date_format = $date_format . ' H:i';
            }
            $mysql_format = 'Y-m-d H:i:s';
        }

        return !empty($date_format) ? \Carbon::createFromFormat($date_format, $date)->format($mysql_format) : null;
    }

    /**
     * Converts time in business format to mysql format
     *
     * @param string $time
     * @return strin
     */
    public function uf_time($time)
    {
        $time_format = 'H:i';
        if (session('business.time_format') == 12) {
            $time_format = 'h:i A';
        }
        return !empty($time_format) ? \Carbon::createFromFormat($time_format, $time)->format('H:i') : null;
    }

    /**
     * Converts time in business format to mysql format
     *
     * @param string $time
     * @return strin
     */
    public function format_time($time)
    {
        $time_format = 'H:i';
        if (session('business.time_format') == 12) {
            $time_format = 'h:i A';
        }
        return !empty($time) ? \Carbon::createFromFormat('H:i:s', $time)->format($time_format) : null;
    }

    /**
     * Converts date in mysql format to business format
     *
     * @param string $date
     * @param bool $time (default = false)
     * @return strin
     */
    public function format_date($date, $show_time = false, $business_details = null)
    {
        $format = !empty($business_details) ? $business_details->date_format : session('business.date_format');
        if (!empty($show_time)) {
            $time_format = !empty($business_details) ? $business_details->time_format : session('business.time_format');
            if ($time_format == 12) {
                $format .= ' h:i A';
            } else {
                $format .= ' H:i';
            }
        }

        return !empty($date) ? \Carbon::createFromTimestamp(strtotime($date))->format($format) : null;
    }


    /**
    * Checks if the given user is admin
    *
    * @param obj $user
    * @param int $business_id
    *
    * @return bool
    */
    public function is_admin($user, $business_id = null)
    {
        $business_id = empty($business_id) ? $user->business_id : $business_id;

        return $user->hasRole('Admin#' . $business_id) ? true : false;
    }

    /**
    * Checks if the feature is allowed in demo
    *
    * @return mixed
    */
    public function notAllowedInDemo()
    {
        //Disable in demo
        if (config('app.env') == 'demo') {
            $output = ['success' => 0,
                    'msg' => __('kamruldashboard::lang_v1.disabled_in_demo')
                ];
            if (request()->ajax()) {
                return $output;
            } else {
                return back()->with('status', $output);
            }
        }
    }

    /**
     * Generates unique token
     *
     * @param void
     *
     * @return string
     */
    public function generateToken()
    {
        return md5(rand(1, 10) . microtime());
    }

    /**
     * Uploads document to the server if present in the request
     * @param obj $request, string $file_name, string dir_name
     *
     * @return string
     */
    public function uploadFile($request, $file_name, $dir_name, $file_type = 'document')
    {
        //If app environment is demo return null
        if (config('app.env') == 'demo') {
            return null;
        }

        $uploaded_file_name = null;
        if ($request->hasFile($file_name) && $request->file($file_name)->isValid()) {

            //Check if mime type is image
            if ($file_type == 'image') {
                if (strpos($request->$file_name->getClientMimeType(), 'image/') === false) {
                    throw new \Exception("Invalid image file");
                }
            }

            if ($file_type == 'document') {
                if (!in_array($request->$file_name->getClientMimeType(), array_keys(config('constants.document_upload_mimes_types')))) {
                    throw new \Exception("Invalid document file");
                }
            }

            if ($request->$file_name->getSize() <= config('constants.document_size_limit')) {
                $new_file_name = time() . '_' . $request->$file_name->getClientOriginalName();
                if ($request->$file_name->storeAs($dir_name, $new_file_name)) {
                    $uploaded_file_name = $new_file_name;
                }
            }
        }

        return $uploaded_file_name;
    }

    public function getCronJobCommand()
    {
        $php_binary_path = empty(PHP_BINARY) ? "php" : PHP_BINARY;

        $command = "* * * * * " . $php_binary_path . " " . base_path('artisan') . " schedule:run >> /dev/null 2>&1";

        if (config('app.env') == 'demo') {
            $command = '';
        }

        return $command;
    }

    /**
     * Checks whether mail is configured or not
     *
     * @return boolean
     */
    public function IsMailConfigured()
    {
        $is_mail_configured = false;

        if (!empty(env('MAIL_DRIVER')) &&
            !empty(env('MAIL_HOST')) &&
            !empty(env('MAIL_PORT')) &&
            !empty(env('MAIL_USERNAME')) &&
            !empty(env('MAIL_PASSWORD')) &&
            !empty(env('MAIL_FROM_ADDRESS'))
            ) {
            $is_mail_configured = true;
        }

        return $is_mail_configured;
    }

    public function getDays()
    {
      return [
            'saturday' => __('kamruldashboard::lang_v1.saturday'),
            'sunday' => __('kamruldashboard::lang_v1.sunday'),
            'monday' => __('kamruldashboard::lang_v1.monday'),
            'tuesday' => __('kamruldashboard::lang_v1.tuesday'),
            'wednesday' => __('kamruldashboard::lang_v1.wednesday'),
            'thursday' => __('kamruldashboard::lang_v1.thursday'),
            'friday' => __('kamruldashboard::lang_v1.friday')
        ];
    }

    /**
    * Formats number to words
    * Requires php-intl extension
    *
    * @return string
    */
    public function numToWord($number, $lang = null, $format = 'international')
    {
        if ($format == 'indian') {
           return $this->numToIndianFormat($number);
        }

        if (!extension_loaded('intl')) {
            return '';
        }

        if (empty($lang)) {
            $lang = !empty(auth()->user()) ? auth()->user()->language : 'en';
        }

        $f = new \NumberFormatter($lang, \NumberFormatter::SPELLOUT);

        return $f->format($number);
    }

    /**
    * Formats number to words in indian format
    *
    * @return string
    */
    public function numToIndianFormat(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $whole_number_part = implode('', array_reverse($str));
        $decimal_part = ($decimal > 0) ? " point " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) : '';
        return ($whole_number_part ? $whole_number_part : '') . $decimal_part;
    }

    public function getBackupCleanCronJobCommand()
    {
        $php_binary_path = empty(PHP_BINARY) ? "php" : PHP_BINARY;

        $command = "* * * * * " . $php_binary_path . " " . base_path('artisan') . " backup:clean >> /dev/null 2>&1";

        if (config('app.env') == 'demo') {
            $command = '';
        }

        return $command;
    }

    /**
    * Get location from latitude and longitude
    * Uses Google's Geocoding api
    * @param $lat string latitude
    * @param $long string longitude
    *
    * @return string
    */
    public function getLocationFromCoordinates($lat, $long)
    {
        try {
            $access_token = env('GOOGLE_MAP_API_KEY');
            $client = new Client();
            $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$long}&key={$access_token}";

            $response = $client->get($url);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function roundQuantity($quantity)
    {
        $quantity_precision = config('constants.quantity_precision', 2);

        return round($quantity, $quantity_precision);
    }

    public function getDropdownForRoles($business_id)
    {
//        $app_roles = Role::where('business_id', $business_id)
//                    ->pluck('name', 'id');
//
//        $roles = [];
//        foreach ($app_roles as $key => $value) {
//            $roles[$key] = str_replace("#".$business_id, '', $value);
//        }
//
//        return $roles;
    }


}
