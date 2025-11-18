<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('Admission Form')</title>
    <style>
        table{
            width: 100%;
            /*padding-bottom: 2px;*/
        }
        th, td {
            padding-bottom: 4px;
            /*border: 1px solid #ddd;*/
        }
        .border_bos {
            border: 1px solid #000000;
        }
        .logo{
            /*padding-top: -40px;*/
        }
        .header{
            /*padding-left: -40px;*/
            /*padding-right: -60px;*/
            align-items: flex-start;
            margin: 0;
        }
        .header_2{
            font-size: 22px;
            /*text-align: center;*/
        }
        .header_3{
            font-size: 18px;
            text-align: left;
        }
        .header_6{
            font-size: 14px;
            text-align: left;
            border: 1px solid black;     /* Outer border of the table */
            border-collapse: collapse;   /* Makes inner borders merge into single lines */
        }
        .header_6 th,
        .header_6 td {
            border: 1px solid #656060;      /* Borders for each cell */
            padding: 5px;                /* Space inside cells */
            text-align: left;
        }
        .header_4{
            font-size: 18px;
            text-align: center;
            padding-top: 50px;
        }
        .header_5{
            font-size: 18px;
            text-align: left;
        }
        .title{
            font-size: 30px;
            text-align: center;
        }
        .underline {
            display: inline-block;
            border-bottom: 2px dotted;
            background-image: linear-gradient(to right, transparent 50%, black 50%);
            background-size: 4px 1px; /* Adjust the size of the dots */
            width: 100%;
        }

        .underline_th {
            border-bottom: 2px dotted #000;
            /*padding: 8px; !* Adjust padding as needed *!*/
            /*text-align: center;*/
        }
        .title_2{
            width: 25%; /* Adjust as needed */
            /*border: 1px solid #000;*/
            /*padding: 10px;*/
        }
        .title_3{
            font-size: 22px;
            width: 42%; /* Adjust as needed */
            /*border: 1px solid #000;*/
            /*padding: 10px;*/
        }
        .box{
            /*width: 50%; !* Adjust as needed *!*/
            border: 1px solid #000;
            text-align: center;
            /*padding: 10px;*/
        }
        .topline {
            display: inline-block;
            border-top: 2px dotted;
            background-image: linear-gradient(to right, transparent 50%, black 50%);
            background-size: 4px 1px; /* Adjust the size of the dots */
            width: 100%;
        }
        .full_address{
            font-size: 18px;
        }
        .site_title{
            font-size: 26px;
        }
    </style>

    <style>

        .slip-container {
            width: 100%;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header img {
            width: 250px;
            height: auto;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }
        .copy-type {
            font-size: 12px;
            margin-bottom: 15px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 4px 6px;
            vertical-align: top;
        }
        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .payment-table th,
        .payment-table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
            text-align: center;
        }
        .amount-words {
            font-weight: bold;
            margin-top: 15px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
@php
$n = 0;
@endphp
<body>
<table class="header">
    <tr>
        <td>
            <img class="logo" src="{{ asset(getImageUrlById(theme_option('logo'), 'shortcodes')) }}" height="100px">
        </td>
        <td class="title">
            <span class="">{{ theme_option('site_title') }}</span><br/>
            <span class="full_address">{{ theme_option('address') }}</span>
        </td>
        <td>
            <img src="{{ asset(getImageUrl($record->photo, 'admission')) }}" height="100px">
        </td>
    </tr>
</table>
<table class="header_2">
    <tr>
        <td class="title_2">
            <span>@lang('ক্রমিক নং'): </span><span class="underline"> {{ englishToBanglaNumber($record->id) }}</span>
        </td>
        <td class="box">
            <span>@lang('ভর্তির আবেদন ফরম'): </span><span class="underline"> {{ englishToBanglaNumber(Option::getYearNameById($record->year)) }}</span>
        </td>
        <td class="title_2">

        </td>
    </tr>
</table>
<table class="header_3">
    <tr>
        <td colspan="1">
            <span>@lang('ভর্তিইচ্ছুক ক্লাস') :</span><span class="underline"> {{ Option::getClassNameById($record->class) }}</span>
        </td>
        <td colspan="1">
            <span>@lang('রোল নং') :</span><span class="underline"> {{ englishToBanglaNumber($record->roll) }}</span>
        </td>
        <td colspan="2">
            <span>@lang('নিবন্ধন নং') :</span><span class="underline"> {{ englishToBanglaNumber($record->student_id) }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('শিক্ষার্থীর নাম') :</span><span class="underline"> {{ $record->name }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('ফোন নম্বর') :</span><span class="underline"> {{ englishToBanglaNumber($record->phone) }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('পিতার নাম') :</span><span class="underline"> {{ $record->father_name }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('মাতার নাম') :</span><span class="underline"> {{ $record->mother_nane }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('জন্ম তারিখ') :</span><span class="underline"> {{ englishToBanglaNumber($record->dob) }}</span>
        </td>
        <td colspan="">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('বয়স') :</span><span class="underline"> {{ englishToBanglaNumber(calculate_age($record->dob)) }}</span>
        </td>
        <td colspan="">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('রক্তের গ্রুপ') :</span><span class="underline"> {{ Option::getBloodGroupNameById($record->blood_group) }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('জন্ম নিবন্ধন নম্বর') :</span><span class="underline"> {{ englishToBanglaNumber($record->birth_registration) }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="">
            {{ englishToBanglaNumber(++$n) }}.  <span>@lang('ধর্ম') :</span><span class="underline"> {{ Option::getReligionNameById($record->religion) }}</span>
        </td>
        <td colspan="">
            {{ englishToBanglaNumber(++$n) }}.  <span>@lang('জাতীয়তা') :</span><span class="underline"> {{ Location::getNationalityNameById($record->nationality) }}</span>
        </td>
        <td colspan="">
            {{ englishToBanglaNumber(++$n) }}.  <span>@lang('মোবাইল নং') :</span><span class="underline"> {{ englishToBanglaNumber($record->phone) }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            {{ englishToBanglaNumber(++$n) }}.  <span>@lang('পূর্বের অধ্যয়নরত বিদ্যালয়ের নাম') :</span><span class="underline"> {{ $record->pre_institution }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('পূর্বের ক্লাস') :</span><span class="underline"> {{ Option::getClassNameById($record->pre_class) }}</span>
        </td>
        <td colspan="">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('এসএসসি বর্ষ') :</span><span class="underline"> {{ englishToBanglaNumber(Option::getYearNameById($record->ssc_year)) }}</span>
        </td>
        <td colspan="2">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('পূর্বের জিপিএ') :</span><span class="underline"> {{ englishToBanglaNumber($record->pre_gpa) }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            {{ englishToBanglaNumber(++$n) }}.  <span>@lang('শিক্ষার্থীর বর্তমান ঠিকানা') :</span><span class="underline"> {{ $record->pre_address }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="">
            <span>@lang('পোস্টকোড') :</span><span class="underline"> {{ englishToBanglaNumber($record->pre_postcode) }}</span>
        </td>
        <td colspan="1">
            @if($record->pre_states)
            <span>@lang('জেলা') :</span><span class="underline"> {{ Location::getStateNameById($record->pre_states) }}</span>
            @endif
        </td>
        <td colspan="1">
            @if($record->pre_city)
            <span>@lang('উপজেলা') :</span><span class="underline"> {{ Location::getCityNameById($record->pre_city) }}</span>
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="3">
            {{ englishToBanglaNumber(++$n) }}.  <span>@lang('শিক্ষার্থীর স্থায়ী ঠিকানা') :</span><span class="underline"> {{ $record->per_address }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="">
            <span>@lang('পোস্টকোড') :</span><span class="underline"> {{ englishToBanglaNumber($record->per_postcode) }}</span>
        </td>
        <td colspan="1">
            @if($record->per_states)
            <span>@lang('জেলা') :</span><span class="underline"> {{ Location::getStateNameById($record->per_states) }}</span>
            @endif
        </td>
        <td colspan="1">
            @if($record->per_city)
            <span>@lang('উপজেলা') :</span><span class="underline"> {{ Location::getCityNameById($record->per_city) }}</span>
            @endif
        </td>
    </tr>
{{--    <tr>--}}
{{--        <td colspan="3">--}}
{{--            {{ englishToBanglaNumber(++$n) }}.  <span>@lang('স্থানীয় অভিভাবকের নাম') :</span><span class="underline"> {{ $record->loc_name }}</span>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td colspan="">--}}
{{--            <span>@lang('সম্পর্ক') :</span><span class="underline"> {{ englishToBanglaNumber($record->loc_relation) }}</span>--}}
{{--        </td>--}}
{{--        <td colspan="1">--}}
{{--            <span>@lang('পেশা') :</span><span class="underline"> {{ Location::getStateNameById($record->loc_address) }}</span>--}}
{{--        </td>--}}
{{--        <td colspan="2">--}}
{{--            <span>@lang('মোবাইল নং') :</span><span class="underline"> {{ englishToBanglaNumber($record->loc_phone) }}</span>--}}
{{--        </td>--}}
{{--    </tr>--}}
</table>

{{--<table class="header_4">--}}
{{--    <tr>--}}
{{--        <td class="">--}}
{{--            <span class="topline">@lang('অভিভাবকের স্বাক্ষর')</span>--}}
{{--        </td>--}}
{{--        <td class="">--}}
{{--            <span class="topline">@lang('আবেদনকারীর স্বাক্ষর')</span>--}}
{{--        </td>--}}
{{--        <td class="">--}}
{{--            <span class="topline">@lang('প্রতিষ্ঠান প্রধানের স্বাক্ষর')</span>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}

{{--<table class="header_5">--}}
{{--    <tr>--}}
{{--        <td>--}}
{{--            <span class="underline">@lang('প্রয়োজনীয় কাগজপত্র') :</span><br/><br/>--}}
{{--            <span>@lang('১.৫ম শ্রেণী প্রত্যয়নপত্র ।')</span><br/>--}}
{{--            <span>@lang('শিক্ষার্থীর অনলাইন জন্ম নিবন্ধন ফটোকপি ।')</span><br/>--}}
{{--            <span>@lang('পিতা মাতার NID অথবা স্থানীয় অভিভাবকের NID ফটোকপি ।')</span>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}
{{----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------}}
{{--<table class="header">--}}
{{--    <tr>--}}
{{--        <td>--}}
{{--            <img class="logo" src="{{ asset(getImageUrlById(theme_option('logo'), 'shortcodes')) }}"  width="100px">--}}
{{--        </td>--}}
{{--        <td class="title">--}}
{{--            <span>{{ theme_option('site_title') }}</span><br/>--}}
{{--            <span class="full_address">{{ theme_option('address') }}</span>--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            <img src="{{ asset(getImageUrl($record->photo, 'admission')) }}" height="100px">--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}
{{--<table class="header_2">--}}
{{--    <tr>--}}
{{--        <td class="title_2">--}}
{{--            <span>@lang('ক্রমিক নং'): </span><span class="underline"> {{ englishToBanglaNumber($record->id) }}</span>--}}
{{--        </td>--}}
{{--        <td class="" style="text-align: center">--}}
{{--            <span>@lang('ভর্তির আবেদন ফরম'): </span><span class="underline"> {{ englishToBanglaNumber(Option::getYearNameById($record->year)) }}</span>--}}
{{--        </td>--}}
{{--        <td class="" style="text-align: center">--}}
{{--            <span>@lang('ভর্তিইচ্ছুক ক্লাস') :</span><span class="underline"> {{ Option::getClassNameById($record->class) }}</span>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}
{{--<table class="header_2">--}}
{{--    <tr>--}}
{{--        <td class="title_3">--}}
{{--        </td>--}}
{{--        <td class="box">--}}
{{--            <span>@lang('প্রবেশ পত্র')</span>--}}
{{--        </td>--}}
{{--        <td class="title_3">--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}
{{--<table class="header_3">--}}
{{--    <tr>--}}
{{--        <td colspan="1">--}}
{{--            <span>@lang('ভর্তিইচ্ছুক ক্লাস') :</span><span class="underline"> {{ Option::getClassNameById($record->class) }}</span>--}}
{{--        </td>--}}
{{--        <td colspan="1">--}}
{{--            <span>@lang('রোল নং') :</span><span class="underline"> {{ englishToBanglaNumber($record->roll) }}</span>--}}
{{--        </td>--}}
{{--        <td colspan="2">--}}
{{--            <span>@lang('নিবন্ধন নং') :</span><span class="underline"> {{ englishToBanglaNumber($record->student_id) }}</span>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td colspan="4">--}}
{{--            <span class="">@lang('শিক্ষার্থীর নাম') :</span><span class="underline"> {{ $record->name }}</span>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td colspan="1" class="">--}}
{{--            <span>@lang('ভর্তি পরীক্ষার তারিখ') :</span><span></span>--}}
{{--        </td>--}}
{{--        <td colspan="3" class="">--}}
{{--            <span>@lang('সময়') :</span><span></span>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}
<table class="header_6" border="">
    <tr>
        <td colspan="2">
            {{ englishToBanglaNumber(++$n) }}. <span>@lang('সিলেক্টেড সাবজেক্ট নাম') (Selected Subject Name) </span>
        </td>
    </tr>
        @foreach($record->sets as $set)
        <tr>
            <td colspan="1" class="">
            {{ $set->name }}
            </td>

            <td colspan="1">
                @foreach($set->set_subjects as $key => $subject)
                    <span>{{ englishToBanglaNumber($key+1) . '. ' . $subject->name }}, </span>
                @endforeach
            </td>
        </tr>
        @endforeach

</table>
<table class="header_7">
    <tr>
        <td colspan="1" class="underline_th">

        </td>
        <td colspan="1" class="underline_th">

        </td>
    </tr>
</table>
<style>
    .header_7{
        margin-top: 10px;
        text-align: center;
        margin-top: 40px;
        /*border: 1px solid #000;*/
    }
    .title_4{
        /*border: 1px solid #000;*/
        font-size: 17px;
    }
    .title_5{
        font-size: 22px;
        text-align: left !important;
    }
</style>
<table class="header_7">
    <tr>
        <td class="title_5" style="width: 50%">
{{--            <strong>@lang('বিঃদ্রঃ পরীক্ষার দিন অবশ্যই প্রবেশপত্র আনতে হবে ।')</strong>--}}
        </td>
        <td class="title_4">
            {{ setting('principal_name')  }}<br/>
{{--            @lang('প্রধান শিক্ষক')<br/>--}}
            @lang('অধ্যক্ষ ( ভারপ্রাপ্ত)')<br/>
            {{ theme_option('site_title') }}<br/>
            @lang('মোবাইলঃ') {{ englishToBanglaNumber(theme_option('site_phone')) }}<br/>
        </td>
    </tr>
</table>

@if($payment)
<div class="page-break"></div>
<div class="slip-container">
    <div class="header">
{{--        <img src="/path/to/pdf_header.png" alt="Logo">--}}
{{--        <img class="logo" src="{{ asset(getImageUrlById(theme_option('logo'), 'shortcodes')) }}" height="100px">--}}
        <img class="logo" src="{{ public_path('pdf_header.png') }}" height="100px">
        <div class="title">Admission Fee Collection Slip</div>
        <div class="copy-type">(College Copy)</div>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Student Name:</strong> {{ $record->name }}</td>
            <td><strong>Student ID:</strong> {{ $record->student_id }}</td>
        </tr>
        <tr>
            <td><strong>Phone:</strong> {{ $record->phone }}</td>
            <td><strong>Class Roll:</strong> {{ $record->roll }}</td>
        </tr>
        <tr>
            <td><strong>Group:</strong> {{ Option::getGroupNameById($record->admission_group) }}</td>
            <td><strong>Session:</strong> {{ Option::getYearNameById($record->ssc_year) }}</td>
        </tr>
    </table>

    <table class="payment-table">
        <thead>
        <tr>
            <th>Transaction No</th>
            <th>Transaction Date</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $payment->tran_id }}</td>
            <td>{{ $payment->created_at }}</td>
            <td>{{ number_format($payment->amount, 2) }}</td>
        </tr>
        </tbody>
    </table>

    <div class="amount-words">
        Amount in Words: {{  numToWordBd($payment->amount) }}
    </div>
</div>

<br/><br/><br/><br/><br/><br/><br/><br/><br/>
<div class="slip-container">
    <div class="header">
{{--        <img src="/path/to/pdf_header.png" alt="Logo">--}}
        {{--        <img class="logo" src="{{ asset(getImageUrlById(theme_option('logo'), 'shortcodes')) }}" height="100px">--}}
        <img class="logo" src="{{ public_path('pdf_header.png') }}" height="100px">
        <div class="title">Admission Fee Collection Slip</div>
        <div class="copy-type">(Student Copy)</div>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Student Name:</strong> {{ $record->name }}</td>
            <td><strong>Student ID:</strong> {{ $record->student_id }}</td>
        </tr>
        <tr>
            <td><strong>Phone:</strong> {{ $record->phone }}</td>
            <td><strong>Class Roll:</strong> {{ $record->roll }}</td>
        </tr>
        <tr>
            <td><strong>Group:</strong> {{ Option::getGroupNameById($record->admission_group) }}</td>
            <td><strong>Session:</strong> {{ Option::getYearNameById($record->ssc_year) }}</td>
        </tr>
    </table>

    <table class="payment-table">
        <thead>
        <tr>
            <th>Transaction No</th>
            <th>Transaction Date</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $payment->tran_id }}</td>
            <td>{{ $payment->created_at }}</td>
            <td>{{ number_format($payment->amount, 2) }}</td>
        </tr>
        </tbody>
    </table>

    <div class="amount-words">
        Amount in Words: {{  numToWordBd($payment->amount) }}
    </div>
</div>
@endif
</body>
</html>
