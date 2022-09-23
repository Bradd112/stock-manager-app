@extends('layout')

@section('content')
    <storages :existing-storages='@json(\App\Http\Resources\StorageResource::collection($storages))'
    ></storages>

    <brands :existing-brands='@json(\App\Http\Resources\BrandResource::collection($brands))'
    ></brands>
@endsection
