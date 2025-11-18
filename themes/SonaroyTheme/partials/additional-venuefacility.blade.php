@isset($record)
    {!! checkbox_design_html($venuefacility,$category,'venuefacility[]',12, __('post::lang.category')) !!}
@else
    {!! checkbox_design_html($venuefacility,get_venuefacility(),'venuefacility[]',12, __('post::lang.category')) !!}
@endisset
