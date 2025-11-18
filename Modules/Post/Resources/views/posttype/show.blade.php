

@section('title', __( 'post::lang.' . $title))

@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
{{--    <link href="{{ url('vendor/kamruldashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
<link href="{{ url('vendor/kamruldashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">


@endsection
@section('javascript')

<!-- Summernote -->
<script src="{{ url('vendor/kamruldashboard/vendor/summernote/js/summernote.min.js') }}"></script>
<!-- Summernote init -->
<script src="{{ url('vendor/kamruldashboard/js/plugins-init/summernote-init.js') }}"></script>

@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('post::lang.posttype_show')</h4>
                <h4 class="card-title">{{ $posttype->name }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm">
<!--                            <thead>-->
<!--                            <tr>-->
<!--                                <th>#</th>-->
<!--                                <th>Name</th>-->
<!--                                <th>Status</th>-->
<!--                                <th>Date</th>-->
<!--                                <th>Price</th>-->
<!--                            </tr>-->
<!--                            </thead>-->
                        <tbody>
                        <tr>
                            <td><b>@lang('post::lang.name')</b></td>
                            <td>{{ $posttype->name }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('post::lang.photo')</b></td>
                            <td>
                                <?php
                                $photo_path = 'uploads/post/posttype/';
                                if($posttype->photo == ''){
                                    $photo = 'vendor/kamruldashboard/images/image-not-found.jpg';
                                }else{
                                    $photo = $photo_path . $posttype->photo;
                                }
                                echo '<img style="height: 100px;width: 100px;" src="' . url($photo) . '" alt="' . $posttype->photo . '" class="img-rounded img-preview">';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>@lang('post::lang.description')</b></td>
                            <td>{!! $posttype->description !!}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('post::lang.status')</b></td>
                            <td>{{ $posttype->status }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
