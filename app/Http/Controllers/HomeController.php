<?php

namespace App\Http\Controllers;

use App\Repositories\BrandRepository;
use App\Repositories\StorageRepository;

class HomeController extends Controller
{
    public function index(StorageRepository $storageRepository, BrandRepository $brandRepository)
    {
        $storages = $storageRepository->getStorages();
        $brands = $brandRepository->getBrands();

        return view('home', compact('storages', 'brands'));
    }
}
