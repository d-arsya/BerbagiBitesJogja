@php
    use Carbon\Carbon;
@endphp
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>{{ $active ?? '' ? "$active |" : '' }}Berbagi Bites Jogja</title>
</head>

<body class="bg-navy pb-72">
    <header class="w-full bg-tosca p-5">
        <a href="https://berbagibitesjogja.site">
            <img src="{{ asset('assets/putih.png') }}" class="h-12 inline" alt="">
            <span class="font-bold text-2xl text-white">Berbagi Bites Jogja</span>
        </a>
    </header>
    <div class="max-w-lg mx-auto px-8 mt-6">
        <div class="pt-12 h-screen bg-navy px-12">
            {{-- ada  --}}
            <h1 class="text-center text-4xl font-bold text-white">Heroes</h1>
            <div class="w-full rounded-lg bg-tosca mt-8 py-5 px-6">
                <h1 class="text-2xl text-white font-semibold text-center">Let's Rescue</h1>
                <form action="{{ route('user.authenticate') }}" method="POST">
                    @csrf 
                    <input autocomplete="off" type="text" name="username" id="" class="bg-tosca w-full text-slate-100 mt-6 focus:outline-none" placeholder="Username">
                    <div class="w-full h-px bg-navy mt-1"></div>
                    <input autocomplete="off" type="password" name="password" id="" class="bg-tosca w-full text-slate-100 mt-6 focus:outline-none" placeholder="Password">
                    <div class="w-full h-px bg-navy mt-1"></div>
                    <input type="submit" value="Let's go" class="w-full bg-white rounded-md p-1 text-lg font-bold mt-10 text-navy">
                </form>
            </div>
        </div>ba
    </div>
    <footer class="fixed bottom-0 w-full bg-navy py-4">
        <h1 id="clickFooter" class="text-center text-sm text-white font-semibold">© Copyright 2024 BERBAGI BITES
            JOGJA. All Rights Reserved.</h1>
    </footer>
</body>

</html>
