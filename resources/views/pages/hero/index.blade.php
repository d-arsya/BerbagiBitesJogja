@extends('layouts.main')
@section('container')
<a href="{{ route('hero.backups') }}" class="bg-orange-400 hover:bg-orange-600 p-2 text-white rounded-md shadow-md">
    Backups
</a>
<div class="mt-6">
    <div>
        {{ $heroes->links() }}
    </div>
    <table class="shadow-md sm:rounded-lg mt-12 text-center w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nama
                </th>
                <th scope="col" class="px-6 py-3 hidden sm:table-cell">
                    Fakultas
                </th>
                <th scope="col" class="hidden sm:table-cell px-6 py-3">
                    Telepon
                </th>
                <th scope="col" class="px-6 py-3">
                    Donasi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($heroes as $item)
            <tr class="odd:bg-white even:bg-gray-50 border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $item->nama }}
                    <span class="md:hidden italic font-normal text-gray-500 block">
                        <a href="{{ route('hero.faculty',$item->fakultas) }}">
                            {{ $item->fakultas }}
                        </a>
                    </span>
                </th>
                <td class="px-6 py-4 hidden sm:table-cell">
                    <a href="{{ route('hero.faculty',$item->fakultas) }}">
                        {{ $item->fakultas }}
                    </a>
                    
                </td>
                <td class="px-6 py-4 hidden sm:table-cell">
                    <a href="https://wa.me/{{ $item->telepon }}">
                        {{ $item->telepon }}
                    </a>
                    
                </td>
                <td class="px-6 py-4 flex flex-col">
                    @php
                        $donation = $item->donation();
                        $sponsor = $donation->sponsor();
                        @endphp
                    <a href="{{ route('donation.show',$donation->id) }}" class="block">
                        <span class="block">
                            {{ $sponsor->name }}

                        </span>
                        {{ \Carbon\Carbon::parse($donation->pengambilan)->format('d-m-Y') }}
                    </a>
                    
                </td>
            </tr>
                
            @endforeach
        </tbody>
    </table>
</div>

@endsection