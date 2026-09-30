<?php
namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::latest()->paginate(10);
        return view('admin.foods.index', compact('foods'));
    }

    public function create()
    {
        return view('admin.foods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'kategori'    => 'required|in:Makanan,Minuman,Cemilan',
            'harga'       => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('foods', 'public');
        }

        Food::create([
            'name'        => $request->name,
            'kategori'    => $request->kategori,
            'harga'       => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar'       => $imagePath,
        ]);

        return redirect()->route('foods.index')
            ->with('success', 'Data makanan berhasil ditambahkan!');
    }

    public function edit(Food $food)
    {
        return view('admin.foods.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'kategori'    => 'required|in:Makanan,Minuman,Cemilan',
            'harga'       => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $food->gambar;

        if ($request->hasFile('gambar')) {
            if ($food->gambar && Storage::disk('public')->exists($food->gambar)) {
                Storage::disk('public')->delete($food->gambar);
            }

            $imagePath = $request->file('gambar')->store('foods', 'public');
        }

        $food->update([
            'name'        => $request->name,
            'kategori'    => $request->kategori,
            'harga'       => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar'       => $imagePath,
        ]);

        return redirect()->route('foods.index')
            ->with('success', 'Data makanan berhasil diperbarui!');
    }

    public function destroy(Food $food)
    {
        if ($food->gambar && Storage::disk('public')->exists($food->gambar)) {
            Storage::disk('public')->delete($food->gambar);
        }

        $food->delete();

        return redirect()->route('foods.index')
            ->with('success', 'Data makanan berhasil dihapus!');
    }
}