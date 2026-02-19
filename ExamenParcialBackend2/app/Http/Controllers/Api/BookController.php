<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // GET /api/books
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->query('title') . '%');
        }

        if ($request->filled('isbn')) {
            $query->where('isbn', 'like', '%' . $request->query('isbn') . '%');
        }

        if ($request->filled('status')) {
            $status = filter_var($request->query('status'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($status !== null) {
                $query->where('is_available', $status);
            }
        }

        return BookResource::collection(
            $query->orderBy('title')->get()
        );
    }
}

