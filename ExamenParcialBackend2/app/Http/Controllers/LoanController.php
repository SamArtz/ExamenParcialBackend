<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use Carbon\Carbon;

class LoanController extends Controller{

    public function store(StoreLoanRequest $request)
    {
        $book = Book::findOrFail($request->book_id);

        if ($book->available_copies <= 0) {
            return response()->json(['message' => 'No hay copias disponibles para este libro.'], 422);
        }

        $loan = Loan::create([
            'book_id' => $book->id,
            'applicant_name' => $request->applicant_name,
            'loan_date' => Carbon::now(), 
        ]);
        $book->decrement('available_copies');      
        if ($book->available_copies == 0) {
            $book->update(['status' => false]);
        }
        return response()->json($loan, 201);
    }
}