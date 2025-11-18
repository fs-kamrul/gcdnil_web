<div class="sixteen columns mb_100" id="contents">
    <div class="container">
        <div class="row g-4">
            <!-- Left column: Profile image & basic info -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <img src="{{ getImageUrl($team->photo,'adminboard/adminteam') }}"
                         class="card-img-top img-fluid"
                         alt="{{ $team->name }}"
                         style="object-fit: cover; height: 300px;">
                    <div class="card-body text-center">
                        <h3 class="fw-bold">{{ $team->name }}</h3>
                        <h6 class="text-muted">{{ $team->designation }}</h6>
                    </div>
                </div>
            </div>

            <!-- Right column: Tabs -->
            <div class="col-lg-8">
                <!-- Bootstrap Nav Tabs -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="message-tab" data-toggle="tab" href="#message" role="tab">
                            <i class="fa fa-envelope-open-o"></i> @lang('adminboard::lang.message')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" role="tab">
                            <i class="fa fa-user"></i> @lang('adminboard::lang.about')
                        </a>
                    </li>
                    @if($team->admin_educations->count())
                        <li class="nav-item">
                            <a class="nav-link" id="education-tab" data-toggle="tab" href="#education" role="tab">
                                <i class="fa fa-graduation-cap"></i> @lang('adminboard::lang.admineducation')
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab">
                            <i class="fa fa-mobile"></i> @lang('adminboard::lang.contact')
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content border p-3 bg-white shadow-sm rounded">

                    <!-- Message Tab -->
                    <div class="tab-pane fade show active" id="message" role="tabpanel" aria-labelledby="message-tab">
                        {!! clean($team->description) !!}
                        <hr>
                        <div class="mb-10"><strong>{{ $team->name }}</strong><br>{{ $team->designation }}</div>
                    </div>

                    <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                        <!-- About content -->
                        <table class="table table-sm text-left">
                            @if($team->name)
                                <tr><td>@lang('adminboard::lang.full_name'):</td><td>{{ $team->name }}</td></tr>
                            @endif
                            @if($team->index_no)
                                <tr><td>@lang('adminboard::lang.index_no'):</td><td>{{ $team->index_no }}</td></tr>
                            @endif
                            @if($team->father_name)
                                <tr><td>@lang('adminboard::lang.father_name'):</td><td>{{ $team->father_name }}</td></tr>
                            @endif
                            @if($team->mother_name)
                                <tr><td>@lang('adminboard::lang.mother_name'):</td><td>{{ $team->mother_name }}</td></tr>
                            @endif
                            @if($team->dob)
                                <tr><td>@lang('adminboard::lang.dob'):</td><td>{{ date('d M Y', strtotime($team->dob)) }}</td></tr>
                            @endif
                        </table>
                    </div>


                    <!-- Education Tab -->
                    @if($team->admin_educations->count())
                        <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                            <table class="table table-sm text-left">
                                @foreach($team->admin_educations as $education)
                                    <tr><td>{{$education->name}}:</td><td>{{$education->pivot->name_title}}</td></tr>
                                @endforeach
                            </table>
                        </div>
                    @endif

                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <table class="table table-sm text-left">
                            @if($team->office_address)
                                <tr><td>@lang('adminboard::lang.office_address'):</td><td>{{ $team->office_address }}</td></tr>
                            @endif
                            @if($team->email)
                                <tr><td>@lang('adminboard::lang.email'):</td><td>{{ $team->email }}</td></tr>
                            @endif
                            @if($team->phone)
                                <tr><td>@lang('adminboard::lang.phone'):</td><td>{{ $team->phone }}</td></tr>
                            @endif
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
