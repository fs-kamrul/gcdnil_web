
@isset($record)
    {!! checkbox_design_html($keyfacility,$category,'keyfacility[]',12, __('post::lang.category')) !!}
@else
    {!! checkbox_design_html($keyfacility,get_keyfacility(),'keyfacility[]',12, __('post::lang.category')) !!}
@endisset
