<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;
use Inertia\Response;
use App\Models\Product;
use App\Models\Sale;

class SaleController extends Controller
{
    public function index(): Response
    {
        $products = Product::select('id', 'name', 'price', 'unit')
            ->where('is_active', true)
            ->where('type', 1) // penjualan
            ->orWhere('type', 3) // penjualan / pembelian
            ->orderBy('name', 'desc')
            ->get();

        return Inertia::render('Sale/List', [
            'transactions' => Sale::orderBy('sale_date', 'desc')->get(),
            'products' => $products,
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    /**
     * Display the sale's form.
     */
    public function create(Request $request): Response
    {
        $product = Product::select('id', 'name', 'price', 'unit')
            ->where('id', '=', $request->query('product_id'))
            ->where('is_active', true)
            ->where('type', 1) // penjualan
            ->orWhere('type', 3) // penjualan / pembelian
            ->firstOrFail();

        return Inertia::render('Sale/Create', [
            'product' => $product,
            'date' => $request->old('date', date('Y-m-d H:i:s')),
            'quantity' => $request->old('quantity', ''),
            'notes' => $request->old('notes', ''),
        ]);
    }

    /**
     * Save data product to database
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => ['date', 'required'],
            'product_id' => ['numeric', 'required'],
            'quantity' => ['numeric', 'min:1', 'required'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));

        $sales = Sale::create([
            'user_id' => $request->user()->id,
            'sale_date' => Carbon::createFromFormat('Y-m-d H:i:s', $request->post('date'))->toDateTimeString(),
            'product_id' => $request->post('product_id'),
            'price' => $product->price,
            'quantity' => $request->post('quantity'),
            'notes' => $request->post('notes'),
            'ref' => $product
        ]);

        if ($sales) {
            session()->flash('success', 'Data penjualan berhasil disimpan');
        } else {
            session()->flash('error', 'Data penjualan gagal disimpan');
        }


        return Redirect::to('/sale');
    }

}
