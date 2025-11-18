

@section('title', __( 'menus::lang.' . $title))

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
                <h4 class="card-title">@lang('menus::lang.menus_show')</h4>
                <h4 class="card-title">{{ $menus->name }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm">
                        <tbody>
                        <tr>
                            <td><b>@lang('menus::lang.name')</b></td>
                            <td>{{ $menus->name }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('menus::lang.photo')</b></td>
                            <td>
                                <?php
                                $photo_path = 'uploads/menus/';
                                if($menus->photo == ''){
                                    $photo = 'vendor/kamruldashboard/images/image-not-found.jpg';
                                }else{
                                    $photo = $photo_path . $menus->photo;
                                }
                                echo '<img style="height: 100px;width: 100px;" src="' . url($photo) . '" alt="' . $menus->photo . '" class="img-rounded img-preview">';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>@lang('menus::lang.description')</b></td>
                            <td>{!! $menus->description !!}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('menus::lang.status')</b></td>
                            <td>{{ $menus->status }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
