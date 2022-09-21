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

    public function destroy(int $storageId)
    {
        Storage::destroy($storageId);

        return response('OK');
    }

    public function update(StorageRequest $request, int $storageId)
    {
        $storage = Storage::findOrFail($storageId);

        $storage->fill($request->all());

        if (! $request->has('is_in_abroad')) {
            $storage->is_in_abroad = false;
        }

        $storage->save();

        return response('OK');
    }
}
