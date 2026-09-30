<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menu Restoran Fandi</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6 font-sans">

<div class="max-w-5xl mx-auto">

    {{-- JUDUL --}}
    <div class="text-center mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Menu Restoran Fandi
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            Pilih menu makanan dan masukkan nomor meja Anda
        </p>

    </div>


    {{-- NOTIFIKASI SUCCESS --}}
    @if(session('success'))

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 text-center font-semibold">
            {{ session('success') }}
        </div>

    @endif


    {{-- NOTIFIKASI ERROR --}}
    @if(session('error'))

        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 text-center font-semibold">
            {{ session('error') }}
        </div>

    @endif


    {{-- VALIDASI --}}
    @if($errors->any())

        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 font-semibold">

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FILTER KATEGORI --}}
    <div class="flex flex-wrap justify-center gap-3 mb-8">

        <button
            type="button"
            onclick="filterCategory('all', this)"
            class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-blue-600 text-white shadow-md">

            Semua Menu

        </button>


        <button
            type="button"
            onclick="filterCategory('Makanan', this)"
            class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-gray-200 border">

            Makanan

        </button>


        <button
            type="button"
            onclick="filterCategory('Minuman', this)"
            class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-gray-200 border">

            Minuman

        </button>


        <button
            type="button"
            onclick="filterCategory('Cemilan', this)"
            class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-gray-200 border">

            Cemilan

        </button>

    </div>


    {{-- FORM PESANAN --}}
    <form
        id="orderForm"
        action="{{ route('customer.checkout') }}"
        method="POST">

        @csrf


        {{-- INFORMASI PEMESAN --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border mb-6">

            <h2 class="text-lg font-bold text-gray-700 mb-4 pb-2 border-b">
                1. Informasi Pemesanan
            </h2>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- NAMA --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-600 mb-1">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="customer_name"
                        name="customer_name"
                        required
                        placeholder="Masukkan nama pemesan"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">

                </div>


                {{-- MEJA --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-600 mb-1">
                        Nomor Meja
                    </label>

                    <input
                        type="number"
                        id="table_number"
                        name="table_number"
                        required
                        min="1"
                        placeholder="Contoh: 05"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">

                </div>

            </div>

        </div>


        {{-- PILIH MENU --}}
        <h2 class="text-lg font-bold text-gray-700 mb-4">
            2. Pilih Menu
        </h2>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($food as $item)

                <div
                    class="food-card bg-white rounded-xl shadow-sm border overflow-hidden flex flex-col justify-between"
                    data-category="{{ $item->kategori ?? 'Makanan' }}">

                    {{-- ISI KARTU --}}
                    <div>

                        {{-- GAMBAR --}}
                        @if($item->gambar)

                            <img
                                src="{{ asset('storage/' . $item->gambar) }}"
                                alt="{{ $item->name }}"
                                class="w-full h-48 object-cover">

                        @else

                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                Tidak ada gambar
                            </div>

                        @endif


                        {{-- INFORMASI MAKANAN --}}
                        <div class="p-4">

                            <h3 class="text-lg font-bold text-gray-800">
                                {{ $item->name }}
                            </h3>


                            <p class="text-sm text-gray-500 mt-1">
                                {{ $item->kategori ?? 'Makanan' }}
                            </p>


                            <p class="text-blue-600 font-bold text-lg mt-2">
                                Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                            </p>


                            <p class="text-sm text-gray-600 mt-2">
                                {{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}
                            </p>

                        </div>

                    </div>


                    {{-- JUMLAH PESANAN --}}
                    <div class="p-4 border-t">

                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Jumlah
                        </label>


                        {{-- INI YANG DIBACA ORDERCONTROLLER --}}
                        <input
                            type="number"
                            name="items[{{ $item->id }}]"
                            value="0"
                            min="0"
                            data-price="{{ $item->harga }}"
                            data-name="{{ $item->name }}"
                            class="quantity-input w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">


                        <p class="subtotal text-sm font-semibold text-gray-700 mt-2">
                            Subtotal: Rp 0
                        </p>

                    </div>

                </div>

            @empty

                <div class="col-span-full bg-white rounded-xl p-8 text-center shadow-sm">

                    <p class="text-gray-500">
                        Belum ada menu makanan.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- TOTAL PESANAN --}}
        <div class="bg-white rounded-xl shadow-sm border mt-8 p-6">

            <div class="flex justify-between items-center mb-4">

                <span class="text-lg font-bold text-gray-700">
                    Total Pesanan
                </span>


                <span
                    id="totalPrice"
                    class="text-2xl font-bold text-blue-600">

                    Rp 0

                </span>

            </div>


            {{-- TOMBOL BUKA KONFIRMASI --}}
            <button
                type="button"
                onclick="openConfirmationModal()"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition">

                Pesan Sekarang

            </button>

        </div>


        {{-- MODAL KONFIRMASI --}}
        <div
            id="confirmModal"
            class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">

            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl">


                <h3 class="text-xl font-bold text-gray-800 border-b pb-3 mb-4">
                    Konfirmasi Pesanan
                </h3>


                {{-- DATA PEMESAN --}}
                <div class="space-y-2 text-sm text-gray-600 mb-4">

                    <div class="flex justify-between">

                        <span class="font-semibold">
                            Nama:
                        </span>

                        <span
                            id="modalName"
                            class="text-gray-900 font-bold">
                        </span>

                    </div>


                    <div class="flex justify-between">

                        <span class="font-semibold">
                            No. Meja:
                        </span>

                        <span
                            id="modalTable"
                            class="text-gray-900 font-bold">
                        </span>

                    </div>

                </div>


                {{-- DAFTAR ITEM --}}
                <div class="border-t border-b py-3 mb-4 max-h-48 overflow-y-auto">

                    <p class="font-semibold text-xs text-gray-400 uppercase mb-2">
                        Rincian Item
                    </p>


                    <ul
                        id="modalItemList"
                        class="space-y-2 text-sm">
                    </ul>

                </div>


                {{-- TOTAL --}}
                <div class="flex justify-between items-center text-lg font-bold text-gray-800 mb-6">

                    <span>
                        Total Pembayaran:
                    </span>

                    <span
                        id="modalTotalPrice"
                        class="text-green-600 text-xl">

                        Rp 0

                    </span>

                </div>


                {{-- BUTTON --}}
                <div class="flex gap-3">

                    <button
                        type="button"
                        onclick="closeConfirmationModal()"
                        class="w-1/2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2.5 rounded-xl transition">

                        Batal

                    </button>


                    <button
                        type="submit"
                        class="w-1/2 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl shadow transition">

                        Ya, Kirim Pesanan

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | FILTER KATEGORI
    |--------------------------------------------------------------------------
    */

    function filterCategory(category, button) {

        const cards = document.querySelectorAll('.food-card');

        const buttons = document.querySelectorAll('.btn-category');


        buttons.forEach(btn => {

            btn.classList.remove(
                'bg-blue-600',
                'text-white',
                'shadow-md'
            );

            btn.classList.add(
                'bg-white',
                'text-gray-600'
            );

        });


        button.classList.remove(
            'bg-white',
            'text-gray-600'
        );

        button.classList.add(
            'bg-blue-600',
            'text-white',
            'shadow-md'
        );


        cards.forEach(card => {

            const cardCategory =
                card.getAttribute('data-category');


            if (
                category === 'all' ||
                cardCategory === category
            ) {

                card.style.display = 'flex';

            } else {

                card.style.display = 'none';

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG TOTAL
    |--------------------------------------------------------------------------
    */

    const quantityInputs =
        document.querySelectorAll('.quantity-input');


    function calculateTotal() {

        let total = 0;


        quantityInputs.forEach(input => {

            const quantity =
                parseInt(input.value) || 0;


            const price =
                parseFloat(
                    input.getAttribute('data-price')
                ) || 0;


            const subtotal =
                quantity * price;


            const card =
                input.closest('.food-card');


            const subtotalElement =
                card.querySelector('.subtotal');


            subtotalElement.innerText =
                'Subtotal: Rp ' +
                subtotal.toLocaleString('id-ID');


            total += subtotal;

        });


        document.getElementById('totalPrice').innerText =
            'Rp ' + total.toLocaleString('id-ID');

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE TOTAL SAAT JUMLAH DIUBAH
    |--------------------------------------------------------------------------
    */

    quantityInputs.forEach(input => {

        input.addEventListener(
            'input',
            calculateTotal
        );

    });


    /*
    |--------------------------------------------------------------------------
    | BUKA MODAL KONFIRMASI
    |--------------------------------------------------------------------------
    */

    function openConfirmationModal() {

        const customerName =
            document.getElementById('customer_name').value.trim();


        const tableNumber =
            document.getElementById('table_number').value.trim();


        // Cek nama
        if (customerName === '') {

            alert('Silakan isi nama pemesan terlebih dahulu.');

            document.getElementById('customer_name').focus();

            return;

        }


        // Cek nomor meja
        if (tableNumber === '') {

            alert('Silakan isi nomor meja terlebih dahulu.');

            document.getElementById('table_number').focus();

            return;

        }


        let hasItem = false;

        let total = 0;


        const modalItemList =
            document.getElementById('modalItemList');


        modalItemList.innerHTML = '';


        quantityInputs.forEach(input => {

            const quantity =
                parseInt(input.value) || 0;


            if (quantity > 0) {

                hasItem = true;


                const price =
                    parseFloat(
                        input.getAttribute('data-price')
                    ) || 0;


                const name =
                    input.getAttribute('data-name');


                const subtotal =
                    quantity * price;


                total += subtotal;


                const li =
                    document.createElement('li');


                li.className =
                    'flex justify-between gap-3';


                li.innerHTML = `
                    <span>
                        ${name} x ${quantity}
                    </span>

                    <span class="font-semibold">
                        Rp ${subtotal.toLocaleString('id-ID')}
                    </span>
                `;


                modalItemList.appendChild(li);

            }

        });


        // Belum pilih makanan
        if (!hasItem) {

            alert('Pilih minimal satu menu terlebih dahulu.');

            return;

        }


        // Masukkan data ke modal
        document.getElementById('modalName').innerText =
            customerName;


        document.getElementById('modalTable').innerText =
            tableNumber;


        document.getElementById('modalTotalPrice').innerText =
            'Rp ' + total.toLocaleString('id-ID');


        // Tampilkan modal
        const modal =
            document.getElementById('confirmModal');


        modal.classList.remove('hidden');

        modal.classList.add('flex');

    }


    /*
    |--------------------------------------------------------------------------
    | TUTUP MODAL
    |--------------------------------------------------------------------------
    */

    function closeConfirmationModal() {

        const modal =
            document.getElementById('confirmModal');


        modal.classList.add('hidden');

        modal.classList.remove('flex');

    }


    /*
    |--------------------------------------------------------------------------
    | KLIK AREA LUAR MODAL
    |--------------------------------------------------------------------------
    */

    document.getElementById('confirmModal')
        .addEventListener('click', function(event) {

            if (event.target === this) {

                closeConfirmationModal();

            }

        });

</script>

</body>
</html>