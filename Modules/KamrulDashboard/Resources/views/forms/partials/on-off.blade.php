<div class="card">
    <div class="card-header">
        <h4 class="card-title">@lang('kamruldashboard::lang.'.$name)</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">

        <div class="onoffswitch">
            <input type="hidden" name="{{ $name }}" value="0">
            <input type="checkbox" name="{{ $name }}" class="onoffswitch-checkbox" id="{{ $name }}" value="1" @if ($value) checked @endif {!! Html::attributes($attributes) !!}>
            <label class="onoffswitch-label" for="{{ $name }}">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
            </label>
        </div>
        </div>
    </div>
</div>
