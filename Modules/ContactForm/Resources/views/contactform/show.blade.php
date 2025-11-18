

@section('title', __( 'contactform::lang.' . $title))

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
                <h4 class="card-title">@lang('contactform::lang.contactform_show')</h4>
                <h4 class="card-title">{{ $contactform->name }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm">
                        <tbody>
                        <tr>
                            <td><b>@lang('contactform::lang.name')</b></td>
                            <td>{{ $contactform->name }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('contactform::lang.photo')</b></td>
                            <td>
                                <?php
                                $photo_path = '../uploads/contactform/';
                                if($contactform->photo == ''){
                                    $photo = 'vendor/kamruldashboard/images/image-not-found.jpg';
                                }else{
                                    $photo = $photo_path . $contactform->photo;
                                }
                                echo '<img style="height: 100px;width: 100px;" src="' . url($photo) . '" alt="' . $contactform->photo . '" class="img-rounded img-preview">';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>@lang('contactform::lang.description')</b></td>
                            <td>{!! $contactform->description !!}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('contactform::lang.status')</b></td>
                            <td>{{ $contactform->status }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
