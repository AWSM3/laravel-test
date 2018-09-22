<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}" media="all"/>
    @stack('styles')
</head>
<body>
<div class="container-fluid">
    <div class="row">
        @include('partials.sidebar')
    </div>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">@yield('title')</h1>
        </div>
        @yield('content')
    </main>
</div>

<script src="{{ asset('/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
