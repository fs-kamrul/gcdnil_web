<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('Site Plan')</title>
    <style>
        table{
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
        .header_2{
            font-size: 17px;
            text-align: center;
        }
        .row {
             display: flex;
             justify-content: space-between;
             margin-bottom: 10px;
         }

        .box {
            width: 48%; /* Adjust as needed */
            border: 1px solid #000;
            padding: 10px;
        }
    </style>
</head>
@php
$n = 0;
@endphp
<body>
{{--<table class="header">--}}
{{--    <tr>--}}
{{--        <td>--}}
{{--            <img class="logo" src="{{ asset(getImageUrlById(theme_option('logo'), 'shortcodes')) }}" height="60px">--}}
{{--        </td>--}}
{{--        <td class="title">--}}
{{--            <span>{{ theme_option('site_title') }}</span><br/>--}}
{{--            <span>{{ theme_option('address') }}</span>--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            <img src="{{ asset(getImageUrl($record->photo, 'admission')) }}" height="100px">--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}
<table class="header_2">
    <tr>
    @foreach($record as $key=>$value)
        @php
            $even = checkOddEven($key);
        @endphp
        <td>
            <span>@lang('ক্লাস'): {{ Option::getClassNameById($value->class) }}</span><br/>
            <span>@lang('নাম'): {{ $value->name }}</span><br/>
            <span>@lang('সিরিয়াল নং'): {{ $value->id }}</span><br/>
            <span>@lang('রোল নং'): {{ englishToBanglaNumber($value->roll) }}</span>
        </td>
        @if(!$even)
    </tr>
    <tr>
        @endif
    @endforeach
    </tr>
</table>
</body>
</html>
