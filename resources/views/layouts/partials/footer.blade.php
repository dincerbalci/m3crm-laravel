</div>
<!-- BEGIN: Dark Mode Switcher-->

<div data-url="{{ route('dark_mode') }}"
    class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
    <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
    <a href="{{ route('dark_mode') }}">
        <div
            class="dark-mode-switcher__toggle dark-mode-switcher__toggle--{{ Session::get('dark_mode') == 'dark' ? 'active' : 'inactive' }} border">
        </div>
    </a>
</div>
<!-- END: Dark Mode Switcher-->
<script src="{{ asset('theme/dist/js/app.js') }}"></script>

<!-- BEGIN: JS Assets-->
{{-- <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script> --}}
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script> --}}
{{-- <script  src="{{ asset('theme/dist/js/vanilla.js')}}"></script> --}}
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>
<script src="{{ asset('theme/dist/js/jquery.inputmask.bundle.js') }}"></script>
<script src="{{ asset('theme/dist/js/main.js') }}"></script>
<script src="{{ asset('theme/dist/plugins/masked-input/masked-input.js') }}"></script>
<script src="{{ asset('theme/dist/plugins/masked-input/masked-input.min.js') }}"></script>
@stack('scripts')
<script>
    @if (Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}"

        switch (type) {
            case 'info':
                // toastr.info("{{ Session::get('message') }}");
                break;
            case 'success':
                debugger
                $("#success-notification-text").text("{{ Session::get('message') }}");
                $("#success-notification-toggle").click();
            case 'warning':
                // toastr.warning("{{ Session::get('message') }}");
                break;
            case 'error':
                //toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif

    $(document).ready(function() {
        $('#cnic').focus();
        // App.init();
        // FormPlugins.init();
        masking();

        $('#cnic').on('keypress', function(e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                cnic = $("#cnic").val();
            }
        });
    });

    function masking() {

        $("#cnic").inputmask({
            "mask": "99999-9999999-9"
        });

        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }

    function sideBarView(parentId) {
        let value = {
            parentId: parentId
        };
        $.ajax({
            type: 'GET',
            url: "{{ route('side_bar_view') }}",
            data: value,
            success: function(result) {
                document.getElementById('content').innerHTML = '';
                document.getElementById('content').innerHTML = result;
            }

        });
    }
    $('.side-menu--active').parent().parent().addClass('side-menu__sub-open');
    $('.side-menu--active').parent().parent().parent().parent().addClass('side-menu__sub-open');
    $('.side-menu--active').parent().parent().parent().children(1).addClass('side-menu--active');
    $('.side-menu--active').parent().parent().parent().parent().parent().children(1).addClass('side-menu--active');
</script>


<!-- END: JS Assets-->
</body>

</html>
