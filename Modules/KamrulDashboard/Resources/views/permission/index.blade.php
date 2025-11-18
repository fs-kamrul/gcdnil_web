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

        let copyButtonTrans = '{{ trans('kamruldashboard::lang.datatables.copy') }}'
        let csvButtonTrans = '{{ trans('kamruldashboard::lang.datatables.csv') }}'
        let excelButtonTrans = '{{ trans('kamruldashboard::lang.datatables.excel') }}'
        let pdfButtonTrans = '{{ trans('kamruldashboard::lang.datatables.pdf') }}'
        let printButtonTrans = '{{ trans('kamruldashboard::lang.datatables.print') }}'
        let colvisButtonTrans = '{{ trans('kamruldashboard::lang.datatables.colvis') }}'
        let selectAllButtonTrans = '{{ trans('kamruldashboard::lang.datatables.select_all') }}'
        let selectNoneButtonTrans = '{{ trans('kamruldashboard::lang.datatables.deselect_all') }}'

        $(document).ready(function() {
            $.noConflict();

            $('#permission').DataTable({
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
                ajax: "{{ url('kamruldashboard/api/permission') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    // {data: 'photo', name: 'photo'},
                    {data: 'name', name: 'name'},
                    // {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ]
            });
        })
    </script>
@endsection

@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('kamruldashboard::lang.permission')</h4>
                @if(auth()->user()->can('permission_import'))
{{--                <a href="{{ url('kamruldashboard/permission/import') }}" type="button" class="btn btn-warning"><i class="icon-plus"></i> @lang('kamruldashboard::lang.permission_import')</a>--}}
                @endif
                @if(auth()->user()->can('permission_access'))
                <a href="{{ url('kamruldashboard/permission/create') }}" type="button" class="btn btn-dark"><i class="icon-plus"></i> @lang('kamruldashboard::lang.permission_create')</a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="permission" class="display" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th>@lang('kamruldashboard::lang.id')</th>
                            <th>@lang('kamruldashboard::lang.name')</th>
                            <th>@lang('kamruldashboard::lang.action')</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
