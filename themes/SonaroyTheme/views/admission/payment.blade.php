<div class="sixteen columns container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>
<div class="sixteen columns container mt-4">
    <div class="row">
        <!-- Left Column: Basic Info -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Basic Information
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $admission->name }}</p>
                    <p><strong>Phone:</strong> {{ $admission->phone ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $admission->email ?? 'N/A' }}</p>
                    <p><strong>Date of Birth:</strong> {{ $admission->dob }}</p>
                    <p><strong>Nationality:</strong> {{ $admission->nationalities->nationality }}</p>
                    <p><strong>Blood Group:</strong> {{ $admission->blood_groups->name }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-warning text-black">
                    Payment
                </div>
                <div class="card-body">
                    @if($admission->payment_status =='due')
                        <form action="{{ route('admission_ssl_payment') }}" method="post">
                            @csrf
                            <input type="hidden" name="ref_id" value="{{ $admission->uuid }}">
{{--                            <input type="text" name="amount" value="{{ $admission->payment_amount }}">--}}
                            <p><strong>Pay Amount:</strong> {{ $admission->payment_amount }}</p>
                            <button type="submit" class="btn btn-submit">Pay Now</button>
                            <a href="#"><img src="{{ url('logo.png') }}" width="100%"></a>
                        </form>
                    @else
                        <p><strong>Payment Already Paid</strong> </p>
                        <a target="_blank" href="{{ route('admission_show', $admission->uuid) }}" class="btn btn-info mt-5 text-white">Download Form</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Details -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-warning text-dark">
                    Admission Details
                </div>
                <div class="card-body">
                    <p><strong>Class:</strong> {{ $admission->classes->name }}</p>
                    <p><strong>Year:</strong> {{ $admission->years->name }}</p>
                    <p><strong>Admission Group:</strong> {{ $admission->admission_groups->name }}</p>
                    <p><strong>Status:</strong> {{ $admission->status ? 'Active' : 'Inactive' }}</p>
                </div>
            </div>
            @php
//            dd($admission->set_name);
//            dd($admission->set_subjects);
            @endphp
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    Subjects
                </div>
                <div class="card-body">
                    @foreach($admission->sets as $set)
                        <p><strong>{{ $set->name }}</strong> </p>
                        <p>
                        @foreach($set->set_subjects as $key => $subject)
                            <span>{{ $key+1 . '. ' . $subject->name }}, </span>
                        @endforeach
                        </p>
                    @endforeach
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    Parent Information
                </div>
                <div class="card-body">
                    <p><strong>Father's Name:</strong> {{ $admission->father_name }}</p>
                    <p><strong>Father's Phone:</strong> {{ $admission->father_phone }}</p>
                    <p><strong>Mother's Name:</strong> {{ $admission->mother_nane }}</p>
                    <p><strong>Mother's Phone:</strong> {{ $admission->mother_phone }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-info text-white">
                    Address
                </div>
                <div class="card-body">
                    <p><strong>Present Address:</strong> {{ $admission->pre_address }}</p>
                    <p><strong>Permanent Address:</strong> {{ $admission->per_address }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
