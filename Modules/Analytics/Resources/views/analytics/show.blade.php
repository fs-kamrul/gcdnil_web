

@section('title', __( 'analytics::lang.' . $title))

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
                <h4 class="card-title">@lang('analytics::lang.analytics_show')</h4>
                <h4 class="card-title">{{ $analytics->name }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm">
                        <tbody>
                        <tr>
                            <td><b>@lang('analytics::lang.name')</b></td>
                            <td>{{ $analytics->name }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('analytics::lang.photo')</b></td>
                            <td>
                                <?php
                                echo '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'analytics') . '" alt="' . $analytics->name . '" class="img-rounded img-preview">';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>@lang('analytics::lang.description')</b></td>
                            <td>{!! $analytics->description !!}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('analytics::lang.status')</b></td>
                            <td>{{ $analytics->status }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
