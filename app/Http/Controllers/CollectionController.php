<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Services\CollectionService;

class CollectionController extends Controller
{
    protected $collectionService;

    // Gunakan Dependency Injection untuk Service
    public function __construct(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
    }

    /**
     * Display the specified collection.
     *
     * @param  \App\Models\Collection  $collection // Objek Collection dari Route Model Binding
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        // Karena Route Model Binding sudah memberikan objek $collection,
        // kita kirim objek ini ke service untuk dimuat dengan data yang lengkap.
        $detailedCollection = $this->collectionService->getCollectionDetailWithEbooks($collection);

        // Kirim data yang sudah lengkap ke view
        return view('collections.show', ['collection' => $detailedCollection]);
    }
}
