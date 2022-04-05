<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>{{ $title }} | Finka Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.jpg') }}">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
    @yield('content')

    <div style="z-index: 11">
        <div id="toast-primary" class="toast overflow-hidden mt-3" role="alert" aria-live="assertive" aria-atomic="true"
            style="position: fixed;top: 10px;right: 10px;">
            <div class="align-items-center text-white bg-primary border-0">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <div style="z-index: 11">
        <div id="toast-success" class="toast overflow-hidden mt-3" role="alert" aria-live="assertive" aria-atomic="true"
            style="position: fixed;top: 10px;right: 10px;">
            <div class="align-items-center text-white bg-success border-0">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <div style="z-index: 11">
        <div id="toast-warning" class="toast overflow-hidden mt-3" role="alert" aria-live="assertive" aria-atomic="true"
            style="position: fixed;top: 10px;right: 10px;">
            <div class="align-items-center text-white bg-warning border-0">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <div style="z-index: 11">
        <div id="toast-danger" class="toast overflow-hidden mt-3" role="alert" aria-live="assertive" aria-atomic="true"
            style="position: fixed;top: 10px;right: 10px;">
            <div class="align-items-center text-white bg-danger border-0">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <!-- pace js -->
    <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>
    <!-- password addon init -->
    <script src="{{ asset('assets/js/pages/pass-addon.init.js') }}"></script>
    <script src="{{ asset('assets/js/main/app.js') }}"></script>
    <!-- Mods -->
    @if (isset($mods))
        @if (is_array($mods))
            @foreach ($mods as $mod)
                <script src="{{ asset('mods/mod_' . $mod . '.js') }}"></script>
            @endforeach
        @else
            <script src="{{ asset('mods/mod_' . $mods . '.js') }}"></script>
        @endif
    @endif
</body>

</html>
