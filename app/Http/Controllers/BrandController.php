<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;

class BrandController extends Controller
{
    public function store(BrandRequest $request)
    {
        $brand = Brand::create($request->all());

        return new BrandResource($brand);
    }

    public function destroy(int $brandId)
    {
        Brand::destroy($brandId);

        return response('OK');
    }

    public function update(BrandRequest $request, int $brandId)
    {
        $brand = Brand::findOrFail($brandId);
        $brand->fill($request->all());
        $brand->save();

        return response('OK');
    }
}
