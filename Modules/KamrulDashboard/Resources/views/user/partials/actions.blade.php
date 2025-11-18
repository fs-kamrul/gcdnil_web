@if (Auth::user()->can('user_edit'))
    <a href="{{ route('user.edit', $item->id) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip"
       data-bs-original-title="{{ trans('kamruldashboard::users.view_user_profile') }}"><i class="fa fa-eye"></i></a>
@endif

@if (Auth::user()->can('user_destroy'))
    <a href="#" class="btn btn-icon btn-danger deleteDialog" data-bs-toggle="tooltip"
       data-section="{{ route('user.destroy', $item->id) }}" role="button"
       data-bs-original-title="{{ trans('kamruldashboard::tables.delete_entry') }}">
        <i class="fa fa-trash"></i>
    </a>
@endif
