<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Styles -->
<link rel="stylesheet" href="{{asset('assets/css/sb-admin.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">

<link rel="stylesheet" href="{{asset('css/softeacher.css')}}">

<script>
    var host = "{{url('')}}";
</script>

<!-- Title -->
<title>{{config('app.name')}}-@yield('title')</title>