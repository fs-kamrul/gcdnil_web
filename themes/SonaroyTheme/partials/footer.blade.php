</div>

<div class="footer-artwork" id="footer-artwork">&nbsp;</div>
<!-- Footer Start -->
<footer>
    <div class="footer-wrapper full-width" id="footer-wrapper">
        <div id="footer-menu">
            {!! dynamic_sidebar('footer_sidebar') !!}
{{--            {!! Menus::renderMenuLocation('footer-menu', [--}}
{{--                'view'    => 'menu_footer',--}}
{{--                'status'    => 'nav-item nav-link',--}}
{{--                'options' => ['class' => ''],--}}
{{--            ]) !!}--}}
            <p>{{ theme_option('copyright') }}</p>
        </div>
        <div class="footer-credit" id="footer">
            {!! dynamic_sidebar('top_footer_sidebar') !!}
        </div>
    </div>
</footer>
<!-- Footer End -->

{!! Theme::footer() !!}
<script>
    $(document).ready(function () {
        // Initial check on document load
        checkWidth();

        // Check on window resize
        $(window).resize(function () {
            checkWidth();
        });

        function checkWidth() {
            var wi = $(window).width();
            if (wi < 980) {
                // Add your responsive menu behavior here
                $('.mzr-responsive').slideUp();
                $('#jmenu .show-menu').click(function () {
                    $(".mzr-responsive").slideToggle(400, "linear", function () {
                        // Animation complete.
                    });
                });

                $("#jmenu a.submenu").click(function () {
                    $('#jmenu a.submenu').siblings().addClass('sibling-toggle');
                    $(this).parent().find(".mzr-content").removeClass('sibling-toggle').addClass('slide-visible').slideToggle(400, "linear", function () {
                        // Animation complete.
                    });
                });
            }else{
                $('.meganizr').css('display', 'block');
            }
        }
    });
</script>
<script>
    // ===== Return to Top ====
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 800) {        // If page is scrolled more than 200px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });

    $('#return-to-top').click(function () {      // When arrow is clicked
        $('body,html').animate({
            scrollTop: 0                       // Scroll to top of body
        }, 500);
    });
</script>

{!! Theme::place('footer') !!}
<script>
    var KamrulVariables = KamrulVariables || {};

    @if (Auth::check())
        KamrulVariables.languages = {
        tables: {!! json_encode(trans('table::lang'), JSON_HEX_APOS) !!},
        notices_msg: {!! json_encode(trans('kamruldashboard::notices'), JSON_HEX_APOS) !!},
        pagination: {!! json_encode(trans('pagination'), JSON_HEX_APOS) !!},
        system: {
            'character_remain': '{{ trans('kamruldashboard::forms.character_remain') }}'
        },
    };
    KamrulVariables.authorized = "{{ setting('membership_authorization_at') && now()->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', setting('membership_authorization_at'))) <= 7 ? 1 : 0 }}";
    @else
        KamrulVariables.languages = {
        notices_msg: {!! json_encode(trans('kamruldashboard::notices'), JSON_HEX_APOS) !!},
    };
    @endif
</script>
@if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
    <script type="text/javascript">
        $(document).ready(function () {
            @if (session()->has('success_msg'))
            kamruldashboard.showSuccess('{{ session('success_msg') }}');
            @endif
            @if (session()->has('error_msg'))
            kamruldashboard.showError('{{ session('error_msg') }}');
            @endif
            @if (isset($error_msg))
            kamruldashboard.showError('{{ $error_msg }}');
            @endif
            @if (isset($errors))
            @foreach ($errors->all() as $error)
            kamruldashboard.showError('{{ $error }}');
            @endforeach
            @endif
        });
    </script>
    @endif


    </body>
    </html>
