<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Makanan
        </h2>
    </x-slot>

```
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">

                <form action="{{ route('foods.update', $food->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- Nama Makanan --}}
                    <div class="mb-5">
                        <label for="name"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Makanan
                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $food->name) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-5">
                        <label for="kategori"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori
                        </label>

                        <select id="kategori"
                                name="kategori"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>

                            <option value="">-- Pilih Kategori --</option>

                            <option value="Makanan"
                                {{ old('kategori', $food->kategori) == 'Makanan' ? 'selected' : '' }}>
                                Makanan
                            </option>

                            <option value="Minuman"
                                {{ old('kategori', $food->kategori) == 'Minuman' ? 'selected' : '' }}>
                                Minuman
                            </option>

                            <option value="Cemilan"
                                {{ old('kategori', $food->kategori) == 'Cemilan' ? 'selected' : '' }}>
                                Cemilan
                            </option>

                        </select>
                    </div>

                    {{-- Harga --}}
                    <div class="mb-5">
                        <label for="harga"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Harga (Rp)
                        </label>

                        <input type="number"
                               id="harga"
                               name="harga"
                               value="{{ old('harga', $food->harga) }}"
                               min="0"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-5">
                        <label for="deskripsi"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>

                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  required>{{ old('deskripsi', $food->deskripsi) }}</textarea>
                    </div>

                    {{-- Gambar Lama --}}
                    @if ($food->gambar)
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Saat Ini
                            </label>

                            <img src="{{ asset('storage/' . $food->gambar) }}"
                                 alt="{{ $food->name }}"
                                 class="w-40 h-40 object-cover rounded-lg border shadow-sm">
                        </div>
                    @endif

                    {{-- Upload Gambar --}}
                    <div class="mb-6">
                        <label for="gambar"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Baru
                            <span class="text-gray-500 font-normal">
                                (Opsional)
                            </span>
                        </label>

                        <input type="file"
                               id="gambar"
                               name="gambar"
                               accept="image/*"
                               class="w-full border-gray-300 rounded-lg shadow-sm p-2">

                        <p class="text-sm text-gray-500 mt-1">
                            Kosongkan jika tidak ingin mengganti gambar.
                        </p>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center gap-3">

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold transition">
                            Update Data
                        </button>

                        <a href="{{ route('foods.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg font-semibold transition">
                            Kembali
                        </a>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
```

</x-app-layout>
