@extends('layouts.main')
@section('container')
    <a class="bg-orange-400 hover:bg-orange-600 shadow-md px-5 py-2.5 rounded-md text-white"
        href="{{ route('donation.index') }}">
        < Kembali</a>
            <div class="max-w-md mx-auto mt-6 bg-navy p-5 text-center text-white font-bold rounded-t-md">
                Edit Donasi
            </div>
            <form method="POST" action="{{ route('donation.update', $donation->id) }}"
                class="max-w-md mx-auto shadow-md px-10  py-6 rounded-b-md">
                @csrf
                @method('PUT')
                <div class="relative z-0 w-full mb-7 group">
                    <label for="quota" class="peer-focus:font-medium absolute text-sm -top-5 text-gray-500">Donatur</label>
                    <input value="{{ $donation->sponsor->name }}" type="text" id="disabled-input-2"
                        aria-label="disabled input 2"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed"
                        value="Disabled readonly input" disabled readonly>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <label for="quota" class="peer-focus:font-medium absolute text-sm -top-5 text-gray-500">Kuota</label>
                    <input value="{{ $donation->quota }}" type="text" id="disabled-input-2" aria-label="disabled input 2"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed"
                        value="Disabled readonly input" disabled readonly>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="number" name="add" id="add"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " />
                        <label for="add"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tambah</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="number" name="diff" id="diff"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " />
                        <label for="diff"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kurang</label>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input value="{{ $donation->take }}" type="date" name="take" id="take"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " name="take" required />
                    <label for="take"
                        class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pengambilan</label>
                </div>
                <div class="flex flex-row w-1/4 gap-1">
                    <div class="relative z-0 w-full mb-5 group">
                        <input value="{{ $donation->hour }}" type="number" name="hour" id="hour"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " name="hour" required />
                        <label for="hour"
                            class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jam</label>
                    </div>
                    <div class="relative z-0 w-5 mb-5 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " disabled />
                        <label for="minute"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">:</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input value="{{ sprintf('%02d', $donation->minute) }}" type="number" name="minute" id="minute"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " name="minute" />
                        <label for="minute"
                            class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Menit</label>
                    </div>

                </div>


                <div class="relative z-0 w-full mb-5 group">
                    <input value="{{ $donation->message }}" type="text" name="message" id="message"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " name="message" />
                    <label for="message"
                        class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pesan
                        Khusus (opsional)</label>
                </div>
                <label class="inline-flex items-center cursor-pointer">
                    <input {{ $donation->charity ? 'checked' : '' }} type="checkbox" value="charity" name="charity"
                        class="sr-only peer">
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Donasi</span>
                </label>
                @if ($donation->beneficiaries)
                    <p class="text-xs text-gray-900">Beneficiaries :</p>
                    <div class="flex gap-x-3 flex-wrap flex-row">
                        @foreach ($universities as $item)
                            <div class="flex align-middle gap-2 my-2">
                                <input type="checkbox" name="beneficiaries[]" value="{{ $item->id }}"
                                    {{ in_array($item->id, json_decode($donation->beneficiaries)) ? 'checked' : '' }}
                                    id="beneficiaries">
                                <label for="beneficiaries" class="text-xs ">{{ $item->name }}</label>

                            </div>
                        @endforeach

                    </div>
                @endif
                <fieldset class="grid grid-cols-2 mt-3">
                    <div class="flex items-center mb-4">
                        <input id="country-option-1" type="radio" name="status" value="aktif"
                            class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
                            {{ $donation->status == 'aktif' ? 'checked' : '' }}>
                        <label for="country-option-1" class="block ms-2  text-sm font-medium text-gray-900">
                            Aktif
                        </label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input id="country-option-2" type="radio" name="status" value="selesai"
                            class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
                            {{ $donation->status == 'selesai' ? 'checked' : '' }}>
                        <label for="country-option-2" class="block ms-2 text-sm font-medium text-gray-900">
                            Selesai
                        </label>
                    </div>
                </fieldset>

                <button type="submit" value="simpan"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
            </form>
        @endsection
