<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Makanan
        </h2>
    </x-slot>

```
<div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">

    <form action="{{ route('foods.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded-lg shadow-sm border">

        @csrf

        {{-- Nama Makanan --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">
                Nama Makanan
            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="w-full border rounded p-2"
                   required>

            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">
                Kategori
            </label>

            <select name="kategori"
                    class="w-full border rounded p-2"
                    required>

                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
                <option value="Cemilan">Cemilan</option>

            </select>

            @error('kategori')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Harga --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">
                Harga (Rp)
            </label>

            <input type="number"
                   name="harga"
                   value="{{ old('harga') }}"
                   class="w-full border rounded p-2"
                   required>

            @error('harga')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">
                Deskripsi
            </label>

            <textarea name="deskripsi"
                      class="w-full border rounded p-2"
                      rows="3"
                      required>{{ old('deskripsi') }}</textarea>

            @error('deskripsi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gambar --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">
                Gambar Makanan
            </label>

            <input type="file"
                   name="gambar"
                   class="w-full border rounded p-2">

            @error('gambar')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded font-semibold">
            Simpan Data
        </button>

    </form>

</div>
```

</x-app-layout>
