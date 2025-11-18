@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
{{--    @include('layouts.components.datatable')--}}
@endsection
@section('javascript')

    <script>

        let copyButtonTrans = '{{ trans('location::lang.datatables.copy') }}'
        let csvButtonTrans = '{{ trans('location::lang.datatables.csv') }}'
        let excelButtonTrans = '{{ trans('location::lang.datatables.excel') }}'
        let pdfButtonTrans = '{{ trans('location::lang.datatables.pdf') }}'
        let printButtonTrans = '{{ trans('location::lang.datatables.print') }}'
        let colvisButtonTrans = '{{ trans('location::lang.datatables.colvis') }}'
        let selectAllButtonTrans = '{{ trans('location::lang.datatables.select_all') }}'
        let selectNoneButtonTrans = '{{ trans('location::lang.datatables.deselect_all') }}'

        $(document).ready(function() {
            $.noConflict();

            $('#country').DataTable({
                pageLength: 10,
                dom: 'lBfrtip<"actions">',
                buttons: [
                    // {
                    //     extend: 'selectAll',
                    //     className: 'btn btn-primary',
                    //     text: selectAllButtonTrans,
                    //     exportOptions: {
                    //         columns: ':visible'
                    //     },
                    //     action: function(e, dt) {
                    //         e.preventDefault()
                    //         dt.rows().deselect();
                    //         dt.rows({ search: 'applied' }).select();
                    //     }
                    // },
                    // {
                    //     extend: 'selectNone',
                    //     className: 'btn btn-primary',
                    //     text: selectNoneButtonTrans,
                    //     exportOptions: {
                    //         columns: ':visible'
                    //     }
                    // },
                    {
                        extend: 'copy',
                        className: 'btn btn-primary',
                        text: copyButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-primary',
                        text: csvButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-primary',
                        text: excelButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-primary',
                        text: pdfButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary',
                        text: printButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-primary',
                        text: colvisButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                serverSide: true,
                processing: true,
                aaSorting: [[0, "desc"]],
                ajax: "{{ url('location/api/country') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'photo', name: 'photo'},
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status'},
                    {data: 'user', name: 'user'},
                    {data: 'action', name: 'action'}
                ]
            });
        })
    </script>
@endsection

@section('title', __( 'location::lang.' . $title))
@section('content')
{{--    <div class="row">--}}
{{--        <div class="col-xl-12 col-xxl-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title">@lang('country::lang.country')</h4>--}}
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
                <h4 class="card-title">@lang('location::lang.country')</h4>
                @if(auth()->user()->can('country_import'))
                    <a href="{{ url('location/country/import') }}" type="button" class="btn btn-warning"><i class="icon-plus"></i> @lang('location::lang.country_import')</a>
                @endif
                @if(auth()->user()->can('country_create'))
                    <a href="{{ url('location/country/create') }}" type="button" class="btn btn-dark"><i class="icon-plus"></i> @lang('location::lang.country_create')</a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="country" class="display" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th>@lang('location::lang.id')</th>
                            <th>@lang('location::lang.photo')</th>
                            <th>@lang('location::lang.name')</th>
                            <th>@lang('location::lang.status')</th>
                            <th>@lang('location::lang.create_by')</th>
                            <th>@lang('location::lang.action')</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
