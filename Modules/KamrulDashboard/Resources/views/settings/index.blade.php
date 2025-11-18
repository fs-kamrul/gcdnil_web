@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
    <link href="{{ url('vendor/kamruldashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

@endsection
@section('javascript')

    <script>
        $(document).ready(function() {
            $.noConflict();

            $('#users').DataTable({
                ajax: '',
                serverSide: true,
                processing: true,
                aaSorting: [[0, "desc"]],
                ajax: "{{ url('systemsettings/settings/getList') }}",
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'key', name: 'key'},
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action'}
                ]
            });
        })
    </script>
@endsection

@section('title', __( 'kamruldashboard::all_lang.' . $title))
@section('content')
{{--    <div class="row">--}}
{{--        <div class="col-xl-12 col-xxl-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title">@lang('faqs::lang.faqs')</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <h1>Hello World</h1>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('kamruldashboard::all_lang.' . $title)</h4>
                <a href="{{ url('systemsettings/settings/add') }}" type="button" class="btn btn-dark"><i class="icon-plus"></i> @lang('kamruldashboard::all_lang.create')</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="users" class="display" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th>@lang('kamruldashboard::all_lang.title')</th>
                            <th>@lang('kamruldashboard::all_lang.key')</th>
                            <th>@lang('kamruldashboard::all_lang.description')</th>
                            <th>@lang('kamruldashboard::all_lang.action')</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
