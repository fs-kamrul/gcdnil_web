<script type="text/javascript">
    var LaracmsVariables = LaracmsVariables || {};

    @if (Auth::check())
        LaracmsVariables.languages = {
            tables: {!! json_encode(trans('shortcodes::.lang.tables'), JSON_HEX_APOS) !!},
            notices_msg: {!! json_encode(trans('shortcodes::lang.notices'), JSON_HEX_APOS) !!},
            pagination: {!! json_encode(trans('pagination'), JSON_HEX_APOS) !!},
            system: {
                'character_remain': '{{ trans('shortcodes::lang.character_remain') }}'
            },
        };
    LaracmsVariables.authorized = "{{ setting('membership_authorization_at') && now()->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', setting('membership_authorization_at'))) <= 7 ? 1 : 0 }}";
    @else
        LaracmsVariables.languages = {
            notices_msg: {!! json_encode(trans('cshortcodes::notices'), JSON_HEX_APOS) !!},
        };
    @endif
</script>

@push('footer')
    @if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
        <script type="text/javascript">
            $(document).ready(function () {
                @if (session()->has('success_msg'))
                Laracms.showSuccess('{{ session('success_msg') }}');
                @endif
                @if (session()->has('error_msg'))
                Laracms.showError('{{ session('error_msg') }}');
                @endif
                @if (isset($error_msg))
                Laracms.showError('{{ $error_msg }}');
                @endif
                @if (isset($errors))
                @foreach ($errors->all() as $error)
                Laracms.showError('{{ $error }}');
                @endforeach
                @endif
            });
        </script>
    @endif
@endpush
