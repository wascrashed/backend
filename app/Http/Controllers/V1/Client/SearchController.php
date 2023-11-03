<?php

namespace App\Http\Controllers\V1\Client;

use App\Http\Controllers\Controller;
use App\Tbuy\Search\Services\SearchableModelService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        private readonly SearchableModelService $searchableModelService
    )
    {
    }

    public function index(Request $request)
    {
        return $this->searchableModelService->get($request->search);
    }
}
