<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('kamruldashboard::lang.'.$name)</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
    @php
        Arr::set($selectAttributes, 'class', Arr::get($selectAttributes, 'class') . ' ui-select');
    @endphp
    {!! Form::select($name, $list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes) !!}
        </div>
    </div>
</div>
