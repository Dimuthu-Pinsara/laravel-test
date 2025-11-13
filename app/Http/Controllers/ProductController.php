<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $file = 'products.json';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->getProducts();
        return view('product', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $products = $this->getProducts();

            $newProduct = [
                'product_name' => $request->product_name,
                'quantity' => (int)$request->quantity,
                'price' => (float)$request->price,
                'datetime' => now()->toDateTimeString(),
                'total_value' => (float)$request->quantity * (float)$request->price,
            ];

            $products[] = $newProduct;
            Storage::put($this->file, json_encode($products, JSON_PRETTY_PRINT));

            return response()->json(['products' => $products], 200);
        } catch (\Throwable $th) {

            Log::error('Failed to store product.', [
                'error'   => $th->getMessage(),
                'trace'   => $th->getTraceAsString(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Failed to store product.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {

            $products = $this->getProducts();
            $index = $request->index;

            $products[$index]['product_name'] = $request->product_name;
            $products[$index]['quantity'] = (int)$request->quantity;
            $products[$index]['price'] = (float)$request->price;
            $products[$index]['total_value'] = (float)$request->quantity * (float)$request->price;

            Storage::put($this->file, json_encode($products, JSON_PRETTY_PRINT));

            return response()->json(['products' => $products], 200);
        } catch (\Throwable $th) {

            Log::error('Failed to update product.', [
                'error'   => $th->getMessage(),
                'trace'   => $th->getTraceAsString(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Failed to update product.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function getProducts()
    {

        if (!Storage::exists($this->file)) {
            Storage::put($this->file, json_encode([]));
        }

        return json_decode(Storage::get($this->file), true);
    }
}
