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
        @if ($donations->count() > 0)
            @if ($donations->contains('id', session('donation')))
                @php
                    $donation = $donations->find(session('donation'));
                @endphp

                <h1 class="text-center text-xl font-bold text-white">BBJ X {{ $donation->sponsor()->name }}</h1>
                <h1 class="text-center text-white text-xs italic font-semibold rounded-md mt-2">
                    {{ Carbon::parse($donation->pengambilan)->isoFormat('dddd, DD MMMM Y') }}</h1>
                <div class="w-full rounded-lg bg-tosca mt-8 py-5 px-6">
                    <h1 class="text-xl text-white text-center italic">Terimakasih telah menjadi heroes hari ini
                    </h1>
                    <h1 class="text-3xl text-white font-medium text-center italic my-4">
                        {{ implode(' ', str_split(session('kode'))) }}
                    </h1>
                    <a href="{{ route('hero.cancel') }}">
                        <div class="m-auto bg-red-600 hover:bg-red-800 w-max rounded-md p-2 text-white">
                            Batalkan
                        </div>
                    </a>
                    <h1 class="text-xs text-white text-center italic mt-1">tunjukkan untuk menukarkan makanan</h1>
                    <h1 class="text-xs text-white text-center italic mt-3">ikuti instagram kami</h1>
                    <a href="https://www.instagram.com/berbagibitesjogja/"
                        class="text-xs text-center block text-white font-medium text-center italic">@berbagibitesjogja</a>
                </div>
                <div class="w-full rounded-lg bg-tosca mt-8 py-5 px-6">
                    <h1 class="text-md text-white font-medium text-center italic mb-4">Informasi Pengambilan
                    </h1>
                    <a href="{{ $donation->maps }}"
                        class="text-center text-white text-md italic font-medium rounded-md mt-3"><svg class="inline"
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                        </svg> {{ $donation->lokasi }}</a>
                    <h1 class="text-white text-md italic font-medium rounded-md mt-3"><svg class="inline mr-1"
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-clock-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                        </svg>{{ $donation->jam }}.00 WIB</h1>
                </div>
            @else
                <div class="flex flex-row flex-wrap gap-3">
                    @foreach ($donations as $id => $donation)
                        <a href="#donatur{{ $id }}"
                            class="link-tab {{ $id == 0 ? 'bg-white text-navy' : 'text-white' }} bg-tosca text-sm  p-2 rounded-md flex-grow text-center">
                            {{ $donation->sponsor()->name }}
                        </a>
                    @endforeach
                </div>
                <div class="p-4">
                    @foreach ($donations as $id => $donation)
                        <div id="donatur{{ $id }}" class="tab-content {{ $id != 0 ? 'hidden' : '' }}">
                            <h1 class="text-center text-xl font-bold text-white">BBJ X {{ $donation->sponsor()->name }}
                            </h1>
                            <h1 class="text-center text-white text-xs italic font-semibold rounded-md mt-2">
                                {{ Carbon::parse($donation->pengambilan)->isoFormat('dddd, DD MMMM Y') }}</h1>
                            @if ($donation->sisa > 0)
                                <div class="w-full rounded-lg bg-tosca mt-4 py-5 px-6">
                                    <h1 class="text-lg text-white font-semibold text-center">RSVP Now</h1>
                                    <form action="{{ route('hero.store') }}" method="POST">
                                        @csrf
                                        <input type="number" name="donation" value="{{ $donation->id }}"
                                            class="hidden">
                                        <input autocomplete="off" type="text" name="nama" id=""
                                            class="bg-tosca w-full text-slate-100 mt-6 focus:outline-none"
                                            placeholder="Nama Lengkap" required>
                                        <div class="w-full h-px bg-navy mt-1"></div>
                                        <div class="relative w-full">
                                            <span class="absolute left-0 bottom-0 text-slate-100">+62</span>
                                            <input autocomplete="off" type="number" name="telepon" id=""
                                                class="bg-tosca w-full text-slate-100 mt-6 pl-8 focus:outline-none"
                                                placeholder="Nomor Whatsapp" required>

                                        </div>
                                        <div class="w-full h-px bg-navy mt-1"></div>
                                        @error('telepon')
                                            <p class="text-xs italic font-thin text-pink-200">Silahkan masukkan format
                                                telepon yang
                                                benar</p>
                                        @enderror
                                        <select class="bg-tosca w-full text-slate-100 mt-6 focus:outline-none"
                                            placeholder="Nomor Whatsapp" name="fakultas" required>
                                            <option value="">Fakultas</option>
                                            <option value="Biologi">Biologi</option>
                                            <option value="Ekonomi Bisnis">Ekonomi Bisnis</option>
                                            <option value="Filsafat">Filsafat</option>
                                            <option value="Fisipol">Fisipol</option>
                                            <option value="Geografi">Geografi</option>
                                            <option value="Hukum">Hukum</option>
                                            <option value="Ilmu Budaya">Ilmu Budaya</option>
                                            <option value="Kedokteran">Kedokteran</option>
                                            <option value="Kedokteran Gigi">Kedokteran Gigi</option>
                                            <option value="Kedokteran Hewan">Kedokteran Hewan</option>
                                            <option value="Kehutanan">Kehutanan</option>
                                            <option value="MIPA">MIPA</option>
                                            <option value="Pascasarjana">Pascasarjana</option>
                                            <option value="Pertanian">Pertanian</option>
                                            <option value="Peternakan">Peternakan</option>
                                            <option value="Psikologi">Psikologi</option>
                                            <option value="Teknologi Pertanian">Teknologi Pertanian</option>
                                            <option value="Vokasi">Vokasi</option>
                                        </select>
                                        <div class="w-full h-px bg-navy mt-1"></div>
                                        <input type="submit" value="Submit"
                                            class="w-full bg-white rounded-md p-1 text-md font-bold mt-10 text-navy">
                                    </form>
                                </div>
                            @else
                                <div class="w-full rounded-lg bg-tosca mt-8 py-5 px-6">
                                    <h1 class="text-md text-white font-medium text-center italic">Mohon maaf kuota telah
                                        terpenuhi, datang lagi lain waktu
                                    </h1>
                                    <h1 class="text-xs text-white font-medium text-center italic mt-3">ikuti instagram
                                        kami</h1>
                                    <a href="https://www.instagram.com/berbagibitesjogja/"
                                        class="text-xs text-center block text-white font-medium text-center italic">@berbagibitesjogja</a>
                                </div>
                            @endif
                            <h1 class="text-pink-900 text-md font-semibold text-center mt-4">Heroes</h1>
                            <h1 class="text-white text-2xl font-bold text-center mt-2">
                                {{ $donation->kuota - $donation->sisa }}/{{ $donation->kuota }}</h1>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
        <div class="w-full rounded-lg bg-tosca mt-8 py-5 px-6">
            <h1 class="text-xl text-white font-medium text-center italic">Maaf, belum ada food rescue hari ini</h1>
            <h1 class="text-md text-white font-medium text-center italic mt-3">ikuti instagram kami</h1>
                <a href="https://www.instagram.com/berbagibitesjogja/"
                    class="text-sm text-center block text-white font-medium text-center italic">@berbagibitesjogja</a>
        </div>
        @endif
    </div>
    <footer class="fixed bottom-0 w-full bg-navy py-4">
        <h1 id="clickFooter" class="text-center text-sm text-white font-semibold">© Copyright 2024 BERBAGI BITES
            JOGJA. All Rights Reserved.</h1>
    </footer>
</body>

</html>
