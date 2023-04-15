<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;
use Closure;

class ProductController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Product/List', [
            'products' => Product::orderBy('id', 'desc')->get(),
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    /**
     * Display the product's form.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Product/Create', [
            'name' => $request->old('name', ''),
            'price' => $request->old('price', ''),
            'unit' => $request->old('unit', ''),
            'type' => $request->old('type', ''),
            'is_active' => $request->old('is_active', '')
        ]);
    }

    /**
     * Save data product to database
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['string', 'required', 'unique:products', 'min:4', 'max:255'],
            'price' => ['string', 'required',
                function (string $attribute, mixed $value, Closure $fail) {
                    $price = str_replace(".", "", $value);
                    if (intval($price) <= 0) {
                        $fail("The {$attribute} field must be at least 1");
                    }
                },
            ],
            'unit' => ['string', 'required', 'max:255'],
            'type' => ['numeric', 'required'],
            'is_active' => ['numeric', 'required'],
        ]);

        $product = Product::create([
            'name' => $request->post('name'),
            'price' => $request->post('price'),
            'unit' => $request->post('unit'),
            'type' => $request->post('type'),
            'is_active' => $request->post('is_active'),
        ]);

        if ($product) {
            session()->flash('success', 'Data produk berhasil disimpan');
        } else {
            session()->flash('error', 'Data produk gagal disimpan');
        }


        return Redirect::to('/product');
    }

    /**
     * Display the product's form with populated data.
     */
    public function edit(Request $request, $id): Response
    {
        $product = Product::findOrFail($id);

        return Inertia::render('Product/Edit', [
            'product_id' => intval($id),
            'name' => $request->old('name', $product->name),
            'price' => $request->old('price', number_format($product->price, 0, ',', '.')),
            'unit' => $request->old('unit', $product->unit),
            'type' => $request->old('type', $product->type),
            'is_active' => $request->old('is_active', intval($product->is_active))
        ]);
    }

    /**
     * Update data product to database
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => ['string', 'required', 'min:4', 'max:255', Rule::unique('products')->ignore($product)],
            'price' => ['string', 'required',
                function (string $attribute, mixed $value, Closure $fail) {
                    $price = str_replace(".", "", $value);
                    if (intval($price) <= 0) {
                        $fail("The {$attribute} field must be at least 1");
                    }
                },
            ],
            'unit' => ['string', 'required', 'max:255'],
            'type' => ['numeric', 'required'],
            'is_active' => ['numeric', 'required'],
        ]);

        $product->name = $request->post('name');
        $product->price = $request->post('price');
        $product->unit = $request->post('unit');
        $product->type = $request->post('type');
        $product->is_active = $request->post('is_active');
        $product->save();

        if ($product->save()) {
            session()->flash('success', 'Data produk berhasil diupdate');
        } else {
            session()->flash('error', 'Data produk gagal diupdate');
        }

        return Redirect::to('/product');
    }

    public function search(Request $request)
    {
        $products = Product::select('id', 'name', 'price', 'unit')
            ->where('is_active', true)
            ->when($request->filled('search'), function (Builder $query, string $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->filled('type'), function (Builder $query, string $type) {
                $query->where('type', $type)
                    ->orWhere('type', 3);
            })
            ->get();

        return response()->json($products);
    }
}
