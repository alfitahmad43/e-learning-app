<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dokumen Unggahan - ') }} {{ $mahasiswa->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('dosen.dashboard') }}" class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Kembali ke Daftar Mahasiswa
                    </a>
                    <hr class="my-4">

                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($documents->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama File Asli</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Unggah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($documents as $doc)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ $doc->original_file_name }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $doc->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <form action="{{ route('dosen.grade', $doc) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <x-text-input type="number" name="grade" step="0.01" min="0" max="100" :value="old('grade', $doc->grade)" class="mt-1 block w-24 text-sm" />
                                            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-primary-button class="ml-2 text-xs">
                                                {{ __('Simpan Nilai') }}
                                            </x-primary-button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Mahasiswa ini belum mengunggah dokumen apapun.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>