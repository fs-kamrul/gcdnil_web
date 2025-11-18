<div class="academic-group">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="row">
                    @php
                        $wow = 0;
                        $increment = 0.1;
                    @endphp
                    @foreach($academic_groups as $key=>$academic_group)
                        @php
                            $wow = ($key == 6) ? 0 : $wow+$increment;
                        @endphp
                        {!! Theme::partial('admin_board.academic_groups.item', ['academic_group' => $academic_group, 'img_slider' => true, 'wow' => $wow]) !!}
                    @endforeach
                    @if ($academic_groups->total() > 0)
                        {!! $academic_groups->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="group-side">
                    <div class="group-icon wow fadeInUp" data-wow-delay="0.3s">
                        <a href="{{ url('admission-form') }}">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                            <span>@lang('adminboard::lang.apply_now')</span>
                        </a>
                    </div>
                    <div class="group-icon wow fadeInUp" data-wow-delay="0.4s">
                        <a href="{{ url('tuition-fees') }}">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            <span>@lang('adminboard::lang.tuition_fees')</span>
                        </a>
                    </div>
                    <div class="group-icon wow fadeInUp" data-wow-delay="0.5s">
                        <a href="{{ url('instruction') }}">
                            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                            <span>@lang('adminboard::lang.eligibility')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


