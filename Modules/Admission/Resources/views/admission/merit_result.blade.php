<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('Merit Result')</title>
    <style>
        table {
            width: 100%;
            padding-bottom: 10px;
        }

        tr {
            border: 1px solid #000;
        }

        td {
            width: 50%;
            border: 1px solid #000;
            padding: 10px;
            padding-top: 50px;
            padding-bottom: 50px;
            margin-bottom: 20px;
        }

        .header_2 {
            font-size: 17px;
            text-align: center;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .box {
            width: 100%; /* Adjust as needed */
            /*border: 1px solid #000;*/
            padding: 10px;
        }
        .long_tex{
            font-size: 28px;
        }
        .box_title{
            width: 100%;
            text-align: center;
            font-size: 16px;
            padding-bottom: 10px;
            box-sizing: border-box;
            position: relative;
        }
        /*.box_title::before,*/
        /*.box_title::after {*/
        /*    content: "--------: ";*/
        /*    display: inline-block;*/
        /*    color: #000; !* Set the color of the dashed line *!*/
        /*}*/

        /*.box_title::after {*/
        /*    content: " : ----------";*/
        /*}*/
        .image_set{
            padding-bottom: 20px;
            width: 100%;
            /*border: 1px solid #000;*/
            text-align: center;
        }
        .box_result{
            padding-left: 40px;
            padding-right: 40px;
            width: 100%;
            /*border: 1px solid #000;*/
            text-align: justify;
        }
    </style>
</head>
@php
    $n = 0;
@endphp
<body>
<div>
    <div class="image_set">
        <img class="logo" src="{{ asset(getImageUrlById(theme_option('logo'), 'shortcodes')) }}" height="80px">
    </div>
    <div class="image_set long_tex">
        <span>{{ theme_option('site_title') }}</span><br/>
        <span>{{ theme_option('address') }}</span>
    </div>
</div>
@php
$dach_line = 60;
@endphp
@foreach($record as $key=>$value)
<div class="box">
    <div class="box_title">{{ str_repeat("-", $dach_line) }}: {{ $value->name }} : {{ str_repeat("-", $dach_line) }}</div>
    <div class="box_result">
        @foreach($value->admissions as $key2=>$value2)
            {{ $value2->id }} ({{ $value2->roll }}),
        @endforeach
    </div>
</div>
@endforeach
{{--<table class="header_2">--}}
{{--    <tr>--}}
{{--        @foreach($record as $key=>$value)--}}
{{--            @php--}}
{{--                $even = checkOddEven($key);--}}
{{--            @endphp--}}
{{--            <td>--}}
{{--                <span>@lang('ক্লাস'): {{ Option::getClassNameById($value->class) }}</span><br/>--}}
{{--                <span>@lang('নাম'): {{ $value->name }}</span><br/>--}}
{{--                <span>@lang('সিরিয়াল নং'): {{ $value->id }}</span><br/>--}}
{{--                <span>@lang('রোল নং'): {{ englishToBanglaNumber($value->roll) }}</span>--}}
{{--            </td>--}}
{{--            @if(!$even)--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        @endif--}}
{{--        @endforeach--}}
{{--    </tr>--}}
{{--</table>--}}
</body>
</html>
