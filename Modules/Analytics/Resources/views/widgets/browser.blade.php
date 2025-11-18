@if (count($browsers) > 0)
    <div class="scroller">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('kamruldashboard::lang.browser') }}</th>
                    <th>{{ trans('kamruldashboard::lang.session') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($browsers as $browser)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="text-start">{{ $browser['browser'] }}</td>
                        <td>{{ $browser['sessions'] }} ({{ trans('analytics::lang.sessions') }})</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    @include('kamruldashboard::partials.no-data')
@endif
