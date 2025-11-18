<div class="row">
    <div class="form-group col-md-6">
        <label for="dsc_capacity" class="control-label">{{ __('Capacity') }}</label>
        {!! Form::number('dsc_addition[dsc_capacity]', $dsc_addition['dsc_capacity'], ['class' => 'form-control', 'id' => 'dsc_capacity']) !!}
    </div>
    <div class="form-group col-md-6">
        <label for="dsc_seats" class="control-label">{{ __('Seats') }}</label>
        {!! Form::number('dsc_addition[dsc_seats]', $dsc_addition['dsc_seats'], ['class' => 'form-control', 'id' => 'dsc_seats']) !!}
    </div>
    <div class="form-group col-md-6 ">
        <div class="row">
            <div class="col-md-6">
                <label for="dsc_hourly_rent" class="control-label">{{ __('Hourly Rent') }}</label>
                {!! Form::number('dsc_addition[dsc_hourly_rent]', $dsc_addition['dsc_hourly_rent'], ['class' => 'form-control', 'id' => 'dsc_hourly_rent']) !!}
            </div>
            <div class="col-md-6">
                <label for="dsc_currency" class="control-label">{{ __('Currency') }}</label>
                {!! Form::text('dsc_addition[dsc_currency]', $dsc_addition['dsc_currency'], ['class' => 'form-control', 'id' => 'dsc_currency']) !!}
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <div class="row">
            <div class="col-md-6">
                <label for="dsc_boards" class="control-label">{{ __('Boards') }}</label>
                {!! Form::number('dsc_addition[dsc_boards]', $dsc_addition['dsc_boards'], ['class' => 'form-control', 'id' => 'dsc_boards']) !!}
            </div>
            <div class="col-md-6">
                <label for="dsc_inch" class="control-label">{{ __('Inch') }}</label>
                {!! Form::text('dsc_addition[dsc_inch]', $dsc_addition['dsc_inch'], ['class' => 'form-control', 'id' => 'dsc_inch']) !!}
            </div>
        </div>
    </div>
</div>
