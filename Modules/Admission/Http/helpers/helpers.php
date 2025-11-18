<?php
if (!defined('ADMISSION_MODULE_SCREEN_NAME')) {
    define('ADMISSION_MODULE_SCREEN_NAME', 'admission');
}
if (!defined('ADMISSION_FORM_TEMPLATE_VIEW')) {
    define('ADMISSION_FORM_TEMPLATE_VIEW', 'admission-form-template-view');
}
//add_next_line
if (! defined('ADMISSIONMERIT_MODULE_SCREEN_NAME')) {
    define('ADMISSIONMERIT_MODULE_SCREEN_NAME', 'admissionmerit');
}

if (!defined('ADMISSIONMARK_MODULE_SCREEN_NAME')) {
    define('ADMISSIONMARK_MODULE_SCREEN_NAME', 'admissionmark');
}

if (!defined('ADMISSIONSUBJECT_MODULE_SCREEN_NAME')) {
    define('ADMISSIONSUBJECT_MODULE_SCREEN_NAME', 'admissionsubject');
}


if (!function_exists('englishToBanglaNumber')) {
    function englishToBanglaNumber($number)
    {
        $englishNumbers = range(0, 9);
        $banglaNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

//        if(Language::getCurrentLocale() == 'bn'){
        $convertedNumber = str_replace($englishNumbers, $banglaNumbers, $number);
//
        return $convertedNumber;
//        }
        //    return $number;
    }
}
if (!function_exists('calculate_age')) {
    function calculate_age($birthdate)
    {
//        $birthdate = '1990-05-15';
        $birthDateObj = new DateTime($birthdate);
        $currentDateObj = new DateTime();
        $ageInterval = $currentDateObj->diff($birthDateObj);
        $age = $ageInterval->y;
//        echo "Age: " . $age . " years";
        return $age;
    }
}
if (!function_exists('checkOddEven')) {
    function checkOddEven($number)
    {
        if ($number % 2 === 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
if (!function_exists('checkColumCount')) {
    function checkColumCount($number)
    {
        if ($number == 1) {
            return 12;
        } elseif ($number == 2) {
            return 6;
        } elseif ($number == 3) {
            return 4;
        } elseif ($number == 4) {
            return 3;
        } elseif ($number == 5) {
            return 2;
        } elseif ($number == 6) {
            return 2;
        } else {
            return 1;
        }
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($number)
    {
        // Format the number with two decimal places
        $formattedNumber = number_format($number, 2);

        // Remove trailing zeros
        $formattedNumber = rtrim($formattedNumber, '0');

        // If the number ends with a decimal point, remove it
        $formattedNumber = rtrim($formattedNumber, '.');

        return $formattedNumber;
    }
}

if (!function_exists('numToWordBd')) {
    function numToWordBd($number)
    {
        $words = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety'
        ];

        $units = ['Crore', 'Lakh', 'Thousand', 'Hundred', ''];
        $divisors = [10000000, 100000, 1000, 100, 1];

        if ($number == 0) {
            return "Zero Taka only";
        }

        $result = '';

        foreach ($divisors as $i => $divisor) {
            if ($number >= $divisor) {
                $part = intval($number / $divisor);
                $number %= $divisor;

                if ($part > 0) {
                    $result .= convertTwoDigits($part, $words) . ' ' . $units[$i] . ' ';
                }
            }
        }

        return trim("Taka " . $result . "only");
    }
}
function convertTwoDigits($n, $words)
{
    if ($n == 0) return '';
    if ($n < 20) return $words[$n];
    $tens = intval($n / 10) * 10;
    $unit = $n % 10;
    return $words[$tens] . ($unit ? ' ' . $words[$unit] : '');
}
