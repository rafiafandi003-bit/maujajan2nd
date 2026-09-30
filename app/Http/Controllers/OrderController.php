<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $food = Food::all();

        return view('customer.index', compact('food'));
    }

    public function store(Request $request)
    {
        // Validasi data pemesan saja
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|integer|min:1',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Ambil data item dari form
        |--------------------------------------------------------------------------
        */

        $items = $request->input('items', []);

        // Kalau form masih menggunakan quantity[]
        if (empty($items) && $request->has('quantity')) {

            $foodIds = $request->input('food_id', []);
            $quantities = $request->input('quantity', []);

            foreach ($foodIds as $index => $foodId) {

                $quantity = $quantities[$index] ?? 0;

                if ((int) $quantity > 0) {
                    $items[$foodId] = (int) $quantity;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Kalau form menggunakan item[] / item
        |--------------------------------------------------------------------------
        */

        if (empty($items) && $request->has('item')) {

            $items = $request->input('item', []);

            if (!is_array($items)) {
                $items = [];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Cek apakah ada menu yang dipilih
        |--------------------------------------------------------------------------
        */

        $orderedItems = [];

        foreach ($items as $foodId => $quantity) {

            if ((int) $quantity > 0) {

                $orderedItems[$foodId] = (int) $quantity;
            }
        }

        if (empty($orderedItems)) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pilih minimal satu menu makanan terlebih dahulu!'
                );
        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Buat Order
            |--------------------------------------------------------------------------
            */

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $totalPrice = 0;

            /*
            |--------------------------------------------------------------------------
            | Simpan Detail Pesanan
            |--------------------------------------------------------------------------
            */

            foreach ($orderedItems as $foodId => $quantity) {

                $food = Food::findOrFail($foodId);

                // Gunakan kolom harga
                $subtotal = $food->harga * $quantity;

                $totalPrice += $subtotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'food_id' => $food->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Update total harga
            |--------------------------------------------------------------------------
            */

            $order->update([
                'total_price' => $totalPrice
            ]);

            DB::commit();

            return redirect()
                ->route('customer.index')
                ->with(
                    'success',
                    'Pesanan berhasil dibuat! Nomor Meja: ' .
                    $order->table_number
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal memproses pesanan: ' .
                    $e->getMessage()
                );
        }
    }

    public function adminDashboard()
    {
        $orders = Order::with('orderDetails.food')
            ->latest()
            ->get();

        return view('dashboard', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with(
            'success',
            'Status pesanan #' . $order->id .
            ' berhasil diperbarui!'
        );
    }


    
}