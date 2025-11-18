

@section('title', __( 'option::lang.' . $title))

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
                <h4 class="card-title">@lang('option::lang.optionsubject_show')</h4>
                <h4 class="card-title">{{ $optionsubject->name }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm">
                        <tbody>
                        <tr>
                            <td><b>@lang('option::lang.name')</b></td>
                            <td>{{ $optionsubject->name }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('option::lang.photo')</b></td>
                            <td>
                                <?php
                                echo '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option/optionsubject') . '" alt="' . $optionsubject->name . '" class="img-rounded img-preview">';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>@lang('option::lang.description')</b></td>
                            <td>{!! $optionsubject->description !!}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('option::lang.status')</b></td>
                            <td>{{ $optionsubject->status }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
