@php
    if($value){
        $date = date('Y-m-d', strtotime($value));
    }else{
        $date = date('Y-m-d');
    }

@endphp
<div class="card">
    <div class="card-body">
        <div class="basic-form">
            <div class="form-row">
                <div class="form-group col-md-{{ $col }} col-xl-{{ $col }}">
                    <label>@lang($module.'::lang.'.$name)</label>
                    {!! Form::date($name, $date, array_merge(['class' => 'form-control'], $attributes)) !!}
                    @error($name)
                    {!! getValidationMessage()!!}
                    @enderror
                    @if(isset($help_block) && $help_block != null)
                    {!! Form::helper($help_block) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

