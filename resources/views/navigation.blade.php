<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <a href="{{ route('siswa.create') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Tambah Siswa
                    </a>

                    <table class="mt-6 w-full border-collapse border border-gray-300 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border px-4 py-2">Foto</th>
                                <th class="border px-4 py-2">NIS</th>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Kelas</th>
                                <th class="border px-4 py-2">Jurusan</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $s)
                                <tr>
                                    <td class="border px-4 py-2 text-center">
                                        @if($s->foto)
                                            <img src="{{ asset('storage/'.$s->foto) }}" 
                                                 alt="Foto {{ $s->nama }}" 
                                                 class="w-16 h-16 object-cover rounded">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">{{ $s->nis }}</td>
                                    <td class="border px-4 py-2">{{ $s->nama }}</td>
                                    <td class="border px-4 py-2">{{ $s->kelas }}</td>
                                    <td class="border px-4 py-2">{{ $s->jurusan }}</td>
                                    <td class="border px-4 py-2">{{ $s->status }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('siswa.edit', $s->id) }}" 
                                           class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('siswa.destroy', $s->id) }}" 
                                              method="POST" 
                                              class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:underline"
                                                    onclick="return confirm('Yakin hapus data ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
