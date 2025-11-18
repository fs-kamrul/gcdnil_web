

@section('title', __( 'captcha::lang.' . $title))

@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')


<style>
    @media print {
        .print_only {
            display: block;
            visibility: visible;
        }
        body * {
            visibility: hidden;
        }
        #print_div, #print_div * {
            visibility: visible;
        }
        #print_div {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
@endsection
@section('javascript')

@endsection
@section('content')

<div class="row" id="print_div">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('captcha::lang.captcha_show')</h4>
                <h4 class="card-title">{{ $captcha->name }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm">
                        <tbody>
                        <tr>
                            <td><b>@lang('captcha::lang.name')</b></td>
                            <td>{{ $captcha->name }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('captcha::lang.photo')</b></td>
                            <td>
                                <?php
                                echo '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'captcha') . '" alt="' . $captcha->name . '" class="img-rounded img-preview">';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>@lang('captcha::lang.description')</b></td>
                            <td>{!! $captcha->description !!}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('captcha::lang.status')</b></td>
                            <td>{{ $captcha->status }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
