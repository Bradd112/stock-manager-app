<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Storage;
use App\Repositories\BrandRepository;
use App\Repositories\ProductRepository;

class ProductsController extends Controller
{
    public function editStorageProducts(
        int $storageId,
        ProductRepository $productRepository,
        BrandRepository $brandRepository
    ) {
        $storage = Storage::findOrFail($storageId);

        $products = $productRepository->getProductsByStorageId($storageId);

        $brands = $brandRepository->getBrands();

        return view('edit-storage-products', compact('storage', 'products', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());

        return new ProductResource($product);
    }

    public function destroy(int $productId)
    {
        Product::destroy($productId);

        return response('OK');
    }

    public function update(ProductRequest $request, int $productId)
    {
        $product = Product::findOrFail($productId);

        $product->fill($request->all());

        if (! $request->has('brand_id')) {
            $product->brand_id = null;
        }

        $product->save();

        return new ProductResource($product);
    }
}
