<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = Listing::search($query)->get();

        dd($results->toArray());

        return Inertia::render('Listings/Index', [
            'searchResults' => $results,
            'filters' => [
                'search' => $query
            ]
        ]);
    }
}
