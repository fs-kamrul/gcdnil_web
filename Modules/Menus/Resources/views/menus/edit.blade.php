@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
    <style>
        .card-header {
            padding: 0.75rem 1.25rem !important;
        }
    </style>
{{--    <link href="{{ url('vendor/kamruldashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
{{--<link href="{{ url('vendor/kamruldashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">--}}
<!-- Nestable -->
{{--<link href="{{ url('vendor/kamruldashboard/vendor/nestable2/css/jquery.nestable.min.css') }}" rel="stylesheet">--}}
<link href="{{ url('vendor/kamruldashboard/menus/style.css') }}" rel="stylesheet">

@endsection
@section('javascript')
    <script>
        var URL_CREATE_ITEM_MENU = "{{ route('menus.add-item') }}";
        var URL_DELETE_ITEM_MENU = "{{ route('menus.delete-item') }}";
        var URL_UPDATE_ITEM_MENU = "{{ route('menus.update-item') }}";

        var URL_CREATE_MENU = "{{ route('menus.create-menu') }}";
        var URL_UPDATE_ITEMS_AND_MENU = "{{ route('menus.update-menu-and-items') }}";
        var URL_DELETE_MENU = "{{ route('menus.delete-menu') }}";

        var URL_CURRENT = "{{ url()->current() }}";
        var URL_FULL = "{{ request()->fullUrl() }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
    </script>
    {{-- <!-- Summernote -->--}}
 {{--    <script src="{{ url('vendor/kamruldashboard/vendor/summernote/js/summernote.min.js') }}"></script>--}}
    {{--<!-- Summernote init -->--}}
{{--    <script src="{{ url('vendor/kamruldashboard/js/plugins-init/summernote-init.js') }}"></script>--}}

    {{--    <!-- Nestable -->--}}
        <script src="{{ url('vendor/kamruldashboard/vendor/nestable2/js/jquery.nestable.min.js') }}"></script>
{{--    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>--}}
    {{--    <!-- All init script -->--}}
    <script src="{{ url('vendor/kamruldashboard/menus/menu.js') }}"></script>
{{--    <script src="{{ url('vendor/kamruldashboard/js/plugins-init/nestable-init.js') }}"></script>--}}
@endsection
@section('title', __( 'menus::lang.' . $title))
@section('content')
    @php
        $currentUrl = url()->current();
    @endphp

{{--    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">--}}
{{--    <link href="{{url('vendor/menu/style.css')}}" rel="stylesheet">--}}

    <div id="nguyen-huy" class="card mt-2 mb-2">
        <div class="card-header">
            <form method="GET" action="{{ $currentUrl }}" class="form-inline">
                <label for="email" class="mr-sm-2">@lang('menus::lang.select_the_menu_you_want_to_edit') </label>
{{--                {!! Menu::select('menu', $menulist, ['class' => 'form-control']) !!}--}}

                @isset($indmenu){!! array_select_field($indmenu->id,$menulist,'menu',4, __('menus::lang.menus'),'') !!} @else{!! array_select_field(1,$menulist,'menu',4, __('menus::lang.menus'),'') !!} @endisset

                <button type="submit" class="btn btn-primary ml-2">@lang('menus::lang.select')</button>
                <div class="ml-4 mb-2 mr-sm-2">
                    @lang('menus::lang.or') <a href="{{ $currentUrl }}?action=edit&menu=0">@lang('menus::lang.create_new_menu')</a>
                </div>
            </form>
        </div>

        <div class="card-body">
            <input type="hidden" id="idmenu" value="{{$indmenu->id ?? null}}"/>
            <div class="row">
                <div class="col-md-4">
                    @include('menus::partials.left')
                </div>
                {{-- /col-md-4 --}}
                <div class="col-md-8">
                    @include('menus::partials.right')
                </div>
            </div>
        </div>

        <div class="ajax-loader" id="ajax_loader">
            <div class="lds-ripple">
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
@endsection
