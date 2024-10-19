<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>{{ $active ?? '' ? "$active |" : '' }}Berbagi Bites Jogja</title>
</head>

<body>
    @include('partials.sidebar')
    <div class="md:ml-64 pt-24 px-4 md:pt-4 pb-4 ">
        @yield('container')
    </div>
</body>

</html>
