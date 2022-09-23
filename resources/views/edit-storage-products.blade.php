@extends('layout')

@section('content')
    <edit-storage-products :storage='@json(new \App\Http\Resources\StorageResource($storage))'
                           :existing-products='@json(\App\Http\Resources\ProductResource::collection($products))'
                           :brands='@json(\App\Http\Resources\BrandResource::collection($brands))'
    ></edit-storage-products>
@endsection
