<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use Carbon\Carbon;

class LoanController extends Controller{

public function store(StoreLoanRequest $request)
{
    // 1. Obtener el libro [cite: 66]
    $book = Book::findOrFail($request->book_id);

    // 2. Verificar que copias_disponibles > 0 [cite: 65]
    if ($book->copias_disponibles <= 0) {
        // Retornar error 422 si no hay existencias 
        return response()->json(['message' => 'No hay copias disponibles para este libro.'], 422);
    }

    // 3. Crear el registro en la tabla loans [cite: 66]
    $loan = Loan::create([
        'book_id' => $book->id,
        'applicant_name' => $request->applicant_name,
        'loan_date' => Carbon::now(), // Registra fecha/hora actual [cite: 51]
    ]);

    // 4. Reducir copias_disponibles [cite: 52, 67]
    $book->decrement('copias_disponibles');

    // 5. Si copias_disponibles == 0, cambiar estado a no disponible [cite: 53, 68]
    if ($book->copias_disponibles == 0) {
        $book->update(['estado' => false]); // El estado debe ser booleano [cite: 36, 46]
    }

    // 6. Retornar respuesta 201 Created [cite: 70]
    return response()->json($loan, 201);
}
}