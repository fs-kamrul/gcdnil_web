@php
    $get_year = Option::getYear();
@endphp
@if(count($get_year) > 0)
    <div class="dropdown"  style="display: inline;">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-eye"></i>
        </button>
        <div class="dropdown-menu">
            @foreach($get_year as $key=>$value)
                <a class="dropdown-item"
                   role="button"
                   href="{{ route('get-student-list',[$item->id , $key]) }}"
                >{{ $value }}
                </a>
            @endforeach
        </div>
    </div>
@endif
