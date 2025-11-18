<div class="table-actions">
    {!! $extra !!}
    @if (!empty($edit))
        @if (Auth::user()->can(str_replace(".","_","$edit")))
            <a href="{{ route($edit, $item->id) }}" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="{{ trans('table::lang.edit') }}"><i class="fa fa-edit"></i></a>
        @endif
    @endif

    @if (!empty($delete))
        @if (Auth::user()->can(str_replace(".","_","$delete")))
            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog" data-bs-toggle="tooltip" data-section="{{ route($delete, $item->id) }}" role="button" data-bs-original-title="{{ trans('table::lang.delete_entry') }}" >
                <i class="fa fa-trash"></i>
            </a>
        @endif
    @endif
</div>
