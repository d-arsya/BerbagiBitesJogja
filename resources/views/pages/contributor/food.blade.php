@extends('layouts.main')
@section('container')
    <div class="mt-6">
        <div>
            {{ $foodDonators->links() }}
        </div>

        <table class="mt-6 shadow-md sm:rounded-lg text-center w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 hidden sm:table-cell">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 hidden sm:table-cell">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($foodDonators as $item)
                    <tr class="odd:bg-white even:bg-gray-50 border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $item->name }}
                            <span class="md:hidden block mt-3">
                                <span
                                    class="bg-{{ $item->status == 'waiting' ? 'orange-400' : ($item->status == 'cancel' ? 'red-600' : 'tosca') }} py-1 px-6 rounded-full text-white ">{{ $item->status }}</span>

                            </span>
                        </th>
                        <td class="px-6 py-4 hidden sm:table-cell">
                            {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM Y hh:mm') }}
                        </td>
                        <td class="px-2 py-4 flex-row justify-center gap-2 hidden sm:flex">
                            @if ($item->status == 'waiting')
                                <form action="{{ route('contributor.food.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="p-2 rounded-md bg-lime-500 hover:bg-lime-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                            class="bi bi-bag-check" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                            <path
                                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                        </svg>


                                    </button>

                                </form>
                                <form action="{{ route('contributor.food.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus?')" type="submit"
                                        class="p-2 rounded-md bg-red-300 hover:bg-red-600">
                                        <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.1665 3.50008H17.3332V5.16675H15.6665V16.0001C15.6665 16.2211 15.5787 16.4331 15.4224 16.5893C15.2661 16.7456 15.0542 16.8334 14.8332 16.8334H3.1665C2.94549 16.8334 2.73353 16.7456 2.57725 16.5893C2.42097 16.4331 2.33317 16.2211 2.33317 16.0001V5.16675H0.666504V3.50008H4.83317V1.00008C4.83317 0.779068 4.92097 0.567106 5.07725 0.410826C5.23353 0.254545 5.44549 0.166748 5.6665 0.166748H12.3332C12.5542 0.166748 12.7661 0.254545 12.9224 0.410826C13.0787 0.567106 13.1665 0.779068 13.1665 1.00008V3.50008ZM13.9998 5.16675H3.99984V15.1667H13.9998V5.16675ZM6.49984 1.83341V3.50008H11.4998V1.83341H6.49984Z"
                                                fill="white" />
                                        </svg>


                                    </button>

                                </form>
                            @else
                                <span
                                    class="bg-{{ $item->status == 'waiting' ? 'orange-400' : ($item->status == 'cancel' ? 'red-600' : 'tosca') }} py-1 px-6 rounded-full text-white ">{{ $item->status }}</span>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
