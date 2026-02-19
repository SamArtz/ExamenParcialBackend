<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReturnController extends Controller
{
    public function store(int $loan_id)
    {
        return DB::transaction(function () use ($loan_id) {

            $loan = Loan::with('book')->findOrFail($loan_id);

            
            if ($loan->return_date !== null) {
                return response()->json([
                    'message' => 'Este préstamo ya fue devuelto.'
                ], 422);
            }

            $book = $loan->book;

           
            $loan->update([
                'return_date' => Carbon::now(),
            ]);

            
            $newAvailable = min($book->available_copies + 1, $book->total_copies);

            $book->available_copies = $newAvailable;

            
            if ($newAvailable > 0) {
                $book->status = true;
            }

            $book->save();

            return response()->json([
                'message' => 'Devolución registrada correctamente.',
                'loan' => [
                    'id' => $loan->id,
                    'book_id' => $loan->book_id,
                    'applicant_name' => $loan->applicant_name,
                    'loan_date' => $loan->loan_date,
                    'return_date' => $loan->return_date,
                    'returned' => $loan -> True
                ],
                'book' => [
                    'id' => $book->id,
                    'available_copies' => $book->available_copies,
                    'total_copies' => $book->total_copies,
                    'status' => (bool) $book->status,
                ]
            ], 200);
        });
    }
}
