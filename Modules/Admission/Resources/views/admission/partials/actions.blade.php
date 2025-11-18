@if (Auth::user()->can('admission_show'))
    <a target="_blank" href="{{ route('admission_show', $item->uuid) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip"
       data-bs-original-title="{{ trans('kamruldashboard::tables.view') }}"><i class="fa fa-eye"></i></a>
@endif
{{--@if (Auth::user()->can('admission.edit'))--}}
{{--    <a href="{{ route('admission.edit', $item->id) }}" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"--}}
{{--       data-bs-original-title="{{ trans('kamruldashboard::tables.edit') }}"><i class="fa fa-edit"></i></a>--}}
{{--@endif--}}
{{--@if (Auth::user()->can('admission.destroy'))--}}
{{--    <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog" data-bs-toggle="tooltip"--}}
{{--       data-section="{{ route('admission.destroy', $item->id) }}" role="button" data-bs-original-title="{{ trans('kamruldashboard::tables.delete_entry') }}" >--}}
{{--        <i class="fa fa-trash"></i>--}}
{{--    </a>--}}
{{--@endif--}}
