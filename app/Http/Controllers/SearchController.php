<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $results = null;

        if ($query = $request->get('query')) {
            $results = Post::search($query)->paginate(10);
        }

        return view('search', [
            'results' => $results
        ]);
    }
}
