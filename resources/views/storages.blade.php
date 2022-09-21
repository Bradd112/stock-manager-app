@extends('layout')

@section('content')
    <storages new-storage-store-url="{{ route('storage.store') }}"
              :existing-storages='@json(\App\Http\Resources\StorageResource::collection($storages))'
    ></storages>
@endsection
