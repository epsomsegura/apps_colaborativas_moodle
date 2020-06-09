<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('settings.head')
    @include('settings.scripts')
</head>

<body>
    @include('settings.loader')
    
    @yield('content')
    @include('settings.errors')
</body>
<script src="{{asset('assets/js/sb-admin.js')}}"></script>
<script src="{{asset('js/softeacher.js')}}"></script>

</html>