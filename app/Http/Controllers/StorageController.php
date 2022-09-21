<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorageRequest;
use App\Http\Resources\StorageResource;
use App\Models\Storage;
use App\Repositories\StorageRepository;

class StorageController extends Controller
{
    public function index(StorageRepository $storageRepository)
    {
        $storages = $storageRepository->getStorages();

        return view('storages', compact('storages'));
    }

    public function store(StorageRequest $request)
    {
        $storage = Storage::create($request->all());

        return new StorageResource($storage);
    }
}
