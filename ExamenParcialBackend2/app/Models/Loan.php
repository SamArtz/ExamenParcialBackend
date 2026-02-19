<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['book_id', 'applicant_name', 'loan_date', 'return_date'];

    // Un préstamo pertenece a un libro [cite: 82]
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
