<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\City;
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
    public function show(Request $request, Collection $collection)
    {
        // ✅ Get filter parameters
        $perPage = $request->input('per_page', 50);
        $sortBy = $request->input('sort_by', 'featured');

        // ✅ Validate parameters
        $validPerPage = ['50', '100', '150', '200', '250', '300', 'all'];
        $validSortBy = ['featured', 'newest', 'release_date'];

        if (!in_array($perPage, $validPerPage)) {
            $perPage = 50;
        }

        if (!in_array($sortBy, $validSortBy)) {
            $sortBy = 'featured';
        }

        // Karena Route Model Binding sudah memberikan objek $collection,
        // kita kirim objek ini ke service untuk dimuat dengan data yang lengkap.
        $detailedCollection = $this->collectionService->getCollectionDetailWithEbooks($collection);

        // ✅ Apply sorting to ebooks
        $ebooks = $detailedCollection->ebooks;

        switch ($sortBy) {
            case 'newest':
                $ebooks = $ebooks->sortByDesc('created_at');
                break;
            case 'release_date':
                $ebooks = $ebooks->sortBy('release_date');
                break;
            case 'featured':
            default:
                $ebooks = $ebooks->sortByDesc('view_count');
                break;
        }

        // ✅ Apply pagination or show all
        if ($perPage === 'all') {
            $paginatedEbooks = new \Illuminate\Pagination\LengthAwarePaginator(
                $ebooks->values(),
                $ebooks->count(),
                $ebooks->count(),
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $paginatedEbooks = new \Illuminate\Pagination\LengthAwarePaginator(
                $ebooks->forPage($request->input('page', 1), $perPage)->values(),
                $ebooks->count(),
                $perPage,
                $request->input('page', 1),
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        // Update collection ebooks with paginated result
        $detailedCollection->setRelation('ebooks', $paginatedEbooks);

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        // ✅ Kirim data yang sudah lengkap ke view dengan filter parameters
        return view('collections.show', [
            'collection' => $detailedCollection,
            'citiesHeader' => $citiesHeader,
            'perPage' => $perPage,
            'sortBy' => $sortBy,
        ]);
    }
}
