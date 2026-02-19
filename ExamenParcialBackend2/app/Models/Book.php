<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'isbn',
        'total_copies',
        'available_copies',
        'status',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'total_copies' => 'integer',
        'available_copies' => 'integer',
    ];

    // Relación: un libro tiene muchos préstamos
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
