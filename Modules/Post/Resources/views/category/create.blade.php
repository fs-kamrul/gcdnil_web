@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
<link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/slug/slug.css') }}" type="text/css"/>
<link href="{{ url('vendor/Modules/KamrulDashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">


@endsection
@section('javascript')

    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ url('vendor/Modules/KamrulDashboard/slug/slug.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('vendor/Modules/KamrulDashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ url('vendor/Modules/KamrulDashboard/js/plugins-init/summernote-init.js') }}"></script>
@endsection
@section('title', __( 'post::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'category');
//    dd($language['code']);
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Post\Http\Models\Category::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('category.createcategory.store') }}"  enctype="multipart/form-data">
@endif
@csrf

    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('post::lang.category_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>@lang('post::lang.name')</label>
                                <input type="text" id="name" name="name" value="@isset($record){{$record->name}}@else{{ old('name') }}@endisset" class="form-control" placeholder="@lang('post::lang.name')">
                                @error('name')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            @php
                                if(isset($record)){
                                    $slug = get_slug_table_data(null, \Modules\Post\HTTP\Models\Category::class,$record->id, \Modules\Post\Http\Models\Category::class);
                                }
                            @endphp
                            {!! Form::permalink('slug', isset($slug) ? $slug->key : null, isset($slug) ? $slug->reference_id : null, isset($slug) ? $slug->prefix : null) !!}
                            @isset($record){!! select_design_html($record->parent_id,$category,'parent_id',12, __('post::lang.parent')) !!} @else{!! select_design_html(1,$category,'parent_id',12, __('post::lang.parent')) !!} @endisset

                            <div class="form-group col-md-12">
                                <label>@lang('post::lang.order')</label>
                                @php
                                if(isset($record)){
                                    $order_value = $record->order;
                                }else{
                                    $order_value = old('order');
                                    if(empty($order_value)){
                                        $order_value = \Modules\Post\Http\Models\Category::orderBy('order', 'desc')->first()->order + 1;
                                    }
                                }
                                @endphp
                                <input type="number" id="order" name="order" value="{{ $order_value }}" class="form-control" placeholder="@lang('post::lang.order')">
                                @error('order')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>

                            @isset($record){!! input_design_html('photo',$record,6,'file', __('post::lang.photo')) !!} @else{!! input_design_html('photo',null,6,'file', __('post::lang.photo')) !!} @endisset


                            @isset($record){!! status_design_html($record->status,6, __('post::lang.status')) !!} @else{!! status_design_html(1,6, __('post::lang.status')) !!} @endisset

                            <div class="col-xl-12 col-xxl-12">
                                <label><strong>@lang('post::lang.description')</strong></label>
                                <textarea class="summernote" id="description" name="description">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>
                                @error('description')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('post::lang.publish')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        <div class="form-row">
                            <div class="form-row">
                                <button type="submit" class="btn btn-primary">{{ __('post::lang.'.$button) }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection
