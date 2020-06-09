<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('settings.head')
    @include('settings.scripts')
</head>

<body class="sb-nav-fixed">
    @include('settings.loader')

    @include('settings.topbar')

    <div id="layoutSidenav">
        @include('settings.sidebar')

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h2 class="mt-4">@yield('title')</h2>
                    <hr>
                    @yield('content')
                </div>

            </main>
            @include('settings.footer')
            @include('settings.errors')
        </div>
    </div>

</body>
<script src="{{asset('assets/js/sb-admin.js')}}"></script>
<script src="{{asset('js/softeacher.js')}}"></script>

</html>