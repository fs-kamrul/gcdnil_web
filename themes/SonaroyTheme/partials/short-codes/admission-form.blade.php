<div class="admission_form_search sixteen container">
    <div class="row g-3">
{{--    <form action="{{ route('admission.search') }}" method="POST" class="row g-3">--}}
{{--        @csrf--}}
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
            <label for="student_id" class="form-label">
                @lang('admission::lang.student_id') <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                class="form-control @error('student_id') is-invalid @enderror"
                name="student_id"
                value="{{ old('student_id') }}"
                id="student_id"
                placeholder="{{ __('admission::lang.student_id') }}"
            >
            @error('student_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100" id="searchBtn">
                @lang('Search')
            </button>
        </div>
    </div>
    <div id="search-message" class="mt-3"></div>
{{--    </form>--}}
</div>
<div class="admission_form" id="admission_form" style="display: none;">
{{--    {!!    Form::open(['route' => 'admission_store.store', 'method' => 'POST', 'class' => 'mt_45', 'enctype' => 'multipart/form-data']) !!}--}}
    {!!    Form::open(['route' => 'admission_store.store','id'=>'admissionForm', 'method' => 'POST', 'class' => 'mt_45', 'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        {{ method_field('POST') }}
{{--        @csrf--}}
        <input type="hidden" name="student_id" id="form_student_id">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="su_name">@lang('Student Name (English)') <span class="red">*</span></label>
            <input type="text" readonly class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="su_name" placeholder="{{ __('Student Name (English)') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="bl_name">@lang('Student Name (বাংলা)') <span class="red">*</span></label>
            <input type="text" class="form-control @error('bl_name') is-invalid @enderror" name="bl_name" value="{{ old('bl_name') }}" id="bl_name" placeholder="{{ __('Student Name (বাংলা)') }}">
            @error('bl_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="phone_nu">@lang('Phone Number') <span class="red">*</span></label>
            <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" id="phone_nu" placeholder="{{ __('Phone Number') }}">
            @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="father_name">@lang('Father Name (English)') <span class="red">*</span></label>
            <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name') }}" id="father_name" placeholder="{{ __('Father Name (English)') }}">
            @error('father_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="bl_father_name">@lang('Father Name (বাংলা)') <span class="red">*</span></label>
            <input type="text" class="form-control @error('bl_father_name') is-invalid @enderror" name="bl_father_name" value="{{ old('bl_father_name') }}" id="bl_father_name" placeholder="{{ __('Father Name (বাংলা)') }}">
            @error('bl_father_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="father_phone">@lang('Father Phone Number')
{{--                <span class="red">*</span>--}}
            </label>
            <input type="number" class="form-control @error('father_phone') is-invalid @enderror" name="father_phone" value="{{ old('father_phone') }}" id="father_phone" placeholder="{{ __('Father Phone Number') }}">
            @error('father_phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="mother_nane">@lang('Mother Name (English)') <span class="red">*</span></label>
            <input type="text" class="form-control @error('mother_nane') is-invalid @enderror" name="mother_nane" value="{{ old('mother_nane') }}" id="mother_nane" placeholder="{{ __('Mother Name (English)') }}">
            @error('mother_nane')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="bl_mother_nane">@lang('Mother Name (বাংলা)') <span class="red">*</span></label>
            <input type="text" class="form-control @error('bl_mother_nane') is-invalid @enderror" name="bl_mother_nane" value="{{ old('bl_mother_nane') }}" id="bl_mother_nane" placeholder="{{ __('Mother Name (বাংলা)') }}">
            @error('bl_mother_nane')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="mother_phone">@lang('Mother Phone Number') </label>
            <input type="text" class="form-control @error('mother_phone') is-invalid @enderror" name="mother_phone" value="{{ old('mother_phone') }}" id="mother_phone" placeholder="{{ __('Mother Phone Number') }}">
            @error('mother_phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="dob">@lang('Date of Birth') <span class="red">*</span></label>
            <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" id="dob" placeholder="{{ __('Date of Birth') }}">
            @error('dob')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="religion">@lang('Religion') </label>
            {!! Form::select('religion', Option::getReligion(), old('religion'), [ 'id' => "religion", 'class'=>"form-control"]) !!}
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="blood_group">@lang('Blood Group') </label>
            {!! Form::select('blood_group', Option::getBloodGroup(), old('blood_group'), [ 'id' => "blood_group", 'class'=>"form-control"]) !!}
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="gender">@lang('Gender') </label>
            {!! Form::select('gender', Option::getGender(), old('gender'), [ 'id' => "gender", 'class'=>"form-control" ]) !!}
        </div>
        @if (is_module_active('Location'))
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="pre_country">@lang('Nationality') </label>
                {!! Form::select('nationality',
                    Location::getNationality(),
                    old('nationality'),
                    ['class'=>"form-control",'id'=>"nationality"]
                    )
                !!}
            </div>
        @endif
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="birth_registration">@lang('Birth Registration Number') <span class="red">*</span></label>
            <input type="text" class="form-control @error('birth_registration') is-invalid @enderror" name="birth_registration" value="{{ old('birth_registration') }}" id="birth_registration" placeholder="{{ __('Birth Registration Number') }}">
            @error('birth_registration')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <h3>@lang('Important Information') ***</h3>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="ad_class">@lang('Admission Class') </label>
            {!! Form::select('class', Option::getClass(), old('class'), [ 'id' => "ad_class", 'class'=>"form-control" ]) !!}
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="admission_group">@lang('Admission Group') </label>
            {!! Form::select('admission_group', Option::getGroup(), old('admission_group'), [ 'id' => "admission_group", 'class'=>"form-control" ]) !!}
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="year">@lang('Admission Year') </label>
            {!! Form::select('year', Option::getYear(), old('year'), [ 'id' => "year", 'class'=>"form-control" ]) !!}
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="pre_institution">@lang('Previous Institution Name') <span class="red">*</span></label>
            <input type="text" class="form-control @error('pre_institution') is-invalid @enderror" name="pre_institution" value="{{ old('pre_institution') }}" id="pre_institution" placeholder="{{ __('Previous Institution Name') }}">
            @error('pre_institution')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="pre_class">@lang('Previous Class') </label>
            {!! Form::select('pre_class', Option::getClass(), old('pre_class'), [ 'id' => "pre_class", 'class'=>"form-control" ]) !!}
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="pre_gpa">@lang('Previous GPA') <span class="red">*</span></label>
            <input type="text" class="form-control @error('pre_gpa') is-invalid @enderror" name="pre_gpa" value="{{ old('pre_gpa') }}" id="pre_gpa" placeholder="{{ __('Previous GPA') }}">
            @error('pre_gpa')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="ssc_year">@lang('SSC Year') </label>
            {!! Form::select('ssc_year', Option::getYear(), old('ssc_year'), [ 'id' => "ssc_year", 'class'=>"form-control" ]) !!}
        </div>
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <h3>@lang('Present Address')</h3>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="pre_address">@lang('Address') <span class="red">*</span></label>
            <input type="text" class="form-control @error('pre_address') is-invalid @enderror" name="pre_address" value="{{ old('pre_address') }}" id="pre_address" placeholder="{{ __('Address') }}">
            @error('pre_address')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="pre_postcode">@lang('Post Code') <span class="red">*</span></label>
            <input type="text" class="form-control @error('pre_postcode') is-invalid @enderror" name="pre_postcode" value="{{ old('pre_postcode') }}" id="pre_postcode" placeholder="{{ __('Post Code') }}">
            @error('pre_postcode')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
{{--        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">--}}
{{--            <label for="name">@lang('Name') <span class="red">*</span></label>--}}
{{--            <input type="text" name="name" value="{{ old('name') }}" id="name" placeholder="{{ __('Name') }}">--}}
{{--        </div>--}}

        @if (is_module_active('Location'))
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="pre_country">@lang('Country') </label>
                {!! Form::select('pre_country',
                    Location::getCountry(),
                    old('pre_country'),
                    [
                        'data-type' => "country",
                        'id' => "pre_country",
                        'class'=>"form-control"
                    ]) !!}
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="pre_states">@lang('States') </label>
                {!! Form::select('pre_states',
                    Location::getStates(),
                    old('pre_states'),
                    [
                        'data-type' => "state",
                        'data-url' => route('ajax.states-by-country'),
                        'id' => "pre_states",
                        'class'=>"form-control"
                    ]) !!}
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="pre_city">@lang('City') </label>
                {!! Form::select('pre_city',
                    Location::getCitiesByState(1),
                    old('pre_city'),
                    [
                        'data-type' => "city",
                        'data-url' => route('ajax.cities-by-state'),
                        'id' => "pre_city",
                        'class'=>"form-control"
                    ],
                ) !!}
            </div>
        @endif
        <div class="col-12">
            <div class="form-check mt-3 mb-3">
                <input class="" type="checkbox" value="" id="sameAsPresent">
                <label class="form-check-label" for="sameAsPresent">
                    Same as Present Address
                </label>
            </div>
        </div>

        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <h3>@lang('Permanent Address')</h3>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="per_address">@lang('Address') <span class="red">*</span></label>
            <input type="text" class="form-control @error('per_address') is-invalid @enderror" name="per_address" value="{{ old('per_address') }}" id="per_address" placeholder="{{ __('Address') }}">
            @error('per_address')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="per_postcode">@lang('Post Code') <span class="red">*</span></label>
            <input type="text" class="form-control @error('per_postcode') is-invalid @enderror" name="per_postcode" value="{{ old('per_postcode') }}" id="per_postcode" placeholder="{{ __('Post Code') }}">
            @error('per_postcode')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if (is_module_active('Location'))
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="per_country">@lang('Country') </label>
                {!! Form::select('per_country',
                    Location::getCountry(),
                    old('per_country'),
                    [
                        'data-type' => "per_country",
                        'id' => "per_country",
                        'class'=>"form-control"
                    ]) !!}
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="per_states">@lang('States') </label>
                {!! Form::select('per_states',
                    Location::getStates(),
                    old('per_states'),
                    [
                        'data-type' => "per_state",
                        'data-url' => route('ajax.states-by-country'),
                        'id' => "per_states",
                        'class'=>"form-control"
                    ]) !!}
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="per_city">@lang('City') </label>
                {!! Form::select('per_city',
                    Location::getCitiesByState(1),
                    old('per_city'),
                    [
                        'data-type' => "per_city",
                        'data-url' => route('ajax.cities-by-state'),
                        'id' => "per_city",
                        'class'=>"form-control"
                    ],
                ) !!}
            </div>
        @endif

{{--        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">--}}
{{--            <h3>@lang('Local Guardian Information')</h3>--}}
{{--        </div>--}}
{{--        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">--}}
{{--            <label for="loc_name">@lang('Name') <span class="red">*</span></label>--}}
{{--            <input type="text" class="form-control @error('loc_name') is-invalid @enderror" name="loc_name" value="{{ old('loc_name') }}" id="loc_name" placeholder="{{ __('Name') }}">--}}
{{--            @error('loc_name')--}}
{{--            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">--}}
{{--            <label for="loc_phone">@lang('Phone') <span class="red">*</span></label>--}}
{{--            <input type="text" class="form-control @error('loc_phone') is-invalid @enderror" name="loc_phone" value="{{ old('loc_phone') }}" id="loc_phone" placeholder="{{ __('Phone') }}">--}}
{{--            @error('loc_phone')--}}
{{--            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">--}}
{{--            <label for="loc_relation">@lang('Relation with Student') <span class="red">*</span></label>--}}
{{--            <input type="text" class="form-control @error('loc_relation') is-invalid @enderror" name="loc_relation" value="{{ old('loc_relation') }}" id="loc_relation" placeholder="{{ __('Relation with Student') }}">--}}
{{--            @error('loc_relation')--}}
{{--            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">--}}
{{--            <label for="loc_address">@lang('Address') <span class="red">*</span></label>--}}
{{--            <input type="text" class="form-control @error('loc_address') is-invalid @enderror" name="loc_address" value="{{ old('loc_address') }}" id="loc_address" placeholder="{{ __('Address') }}">--}}
{{--            @error('loc_address')--}}
{{--            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">--}}
{{--            <label for="loc_postcode">@lang('Post Code') <span class="red">*</span></label>--}}
{{--            <input type="text" class="form-control @error('loc_postcode') is-invalid @enderror" name="loc_postcode" value="{{ old('loc_postcode') }}" id="loc_postcode" placeholder="{{ __('Post Code') }}">--}}
{{--            @error('loc_postcode')--}}
{{--            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">--}}
{{--            <h3>@lang('SSC Document')</h3>--}}
{{--        </div>--}}
{{--        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">--}}
{{--            <label for="ssc_transcript">@lang('SSC Transcript') <span class="red">*</span></label><br/>--}}
{{--            <input type="file" class="form-control @error('ssc_transcript') is-invalid @enderror" name="ssc_transcript" value="{{ old('ssc_transcript') }}" id="ssc_transcript" placeholder="{{ __('SSC Transcript') }}"><br/>--}}
{{--            @error('ssc_transcript')--}}
{{--            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--            --}}{{--            <span class="red">* @lang('Select Your Image:(Color Photo, JPEG, JPG, PNG Format, 300 x 300 pixel)')<br> @lang('Picture Size 150 kb only').</span>--}}
{{--        </div>--}}
{{--        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">--}}
{{--            <label for="ssc_testimonial">@lang('SSC Testimonial') <span class="red">*</span></label><br/>--}}
{{--            <input type="file" class="form-control @error('ssc_testimonial') is-invalid @enderror" name="ssc_testimonial" value="{{ old('ssc_testimonial') }}" id="ssc_testimonial" placeholder="{{ __('SSC Testimonial') }}"><br/>--}}
{{--            @error('ssc_testimonial')--}}
{{--            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--            --}}{{--            <span class="red">* @lang('Select Your Image:(Color Photo, JPEG, JPG, PNG Format, 300 x 300 pixel)')<br> @lang('Picture Size 150 kb only').</span>--}}
{{--        </div>--}}
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <h3>@lang('Student Photo')</h3>
        </div>
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <label for="photo">@lang('Student Photo') <span class="red">*</span></label><br/>
            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" value="{{ old('photo') }}" id="photo" placeholder="{{ __('Student Photo') }}"><br/>
            @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <span class="red">* @lang('Select Your Image:(Color Photo, JPEG, JPG, PNG Format, 300 x 300 pixel)')<br> @lang('Picture Size 150 kb only').</span>
        </div>
        @if (setting('enable_captcha') && is_module_active('Captcha'))
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="contact-column-12">
                    <div class="contact-form-group">
                        {!! Captcha::display() !!}
                    </div>
                </div>
            </div>
        @endif
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <h3>@lang('Choose Subjects')</h3>
        </div>
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <label>@lang('Choose Subject') <span class="red">*</span></label>
                <div id="subjects-container"></div>
        </div>

        {{--                        <div class="col-12">--}}
        {{--                            <p>{!! clean(__('The field with (<span style="color:#FF0000;">*</span>) is required.')) !!}</p>--}}
        {{--                        </div>--}}
    </div>
    <button class="outline_btn">@lang('Save')</button>
    {!! Form::close() !!}
</div>

