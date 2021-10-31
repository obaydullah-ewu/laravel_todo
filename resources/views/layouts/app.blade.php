<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="{{ asset('assets/js/fontawesome.js') }}"></script>

    <!-- Styles -->
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" integrity="" crossorigin="anonymous">


{{--        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}

    <!--Start:: Toastr -->
    <link href="{{ asset('assets/cloudflare/ajax/libs/bootstrap/bootstrap.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/cloudflare/ajax/libs/toastr/toastr.min.css') }}">
    <script src="{{ asset('assets/cloudflare/ajax/libs/toastr/toastr.min.js') }}"></script>
    <!--End:: Toastr -->

    <!--Start:: Datetime  -->
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="{{ asset('assets/cloudflare/ajax/libs/bootstrapMin/bootstrap.min.css') }}">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">--}}
    <link rel="stylesheet" href="{{ asset('assets/cloudflare/ajax/libs/bootstrapMin/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/icon/bootstrap.min.css') }}">
    <!--End:: Datetime -->

</head>
<body>
    <div id="app">
        @include('layouts.navbar')

        <div class="container">
            <main class="py-4">
                @yield('content')
            </main>
        </div>

    </div>
    @yield('script')
    <script>
        @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.success("{{ session('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('info'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if(Session::has('warning'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    <script src="{{ asset('assets/js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('assets/cloudflare/ajax/libs/popper/popper.min.js') }}" integrity="" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" integrity="" crossorigin="anonymous"></script>

    <!--Start:: Datetime Picker -->

    <script src="{{ asset('assets/cloudflare/ajax/libs/datetime/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/cloudflare/ajax/libs/datetime/moment.min.js') }}"></script>
    <script src="{{ asset('assets/cloudflare/ajax/libs/datetime/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/cloudflare/ajax/libs/datetime/datetimepicker.min.js') }}"></script>

    <!--End:: Datetime Picker -->
    <script type="text/javascript">
        $(function() {
            $('#datetimepicker').datetimepicker();
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('#datetimepicker2').datetimepicker();
        });
    </script>
</body>
</html>
