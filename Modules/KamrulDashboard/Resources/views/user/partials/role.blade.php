<a data-type="select"
{{--   data-source="{{ route('role.list.json') }}"--}}
   data-pk="{{ $item->id }}"
{{--   data-url="{{ route('role.assign') }}"--}}
   data-value="{{ $item->role_id ? $item->role_id : 0 }}"
   data-title="{{ trans('kamruldashboard::users.assigned_role') }}"
   class="editable"
   href="#">
    {{ $item->role_id ? $item->role->name : trans('kamruldashboard::lang.no_role_assigned') }}
</a>
