<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $total = $this->faker->numberBetween(1, 20);
        $available = $this->faker->numberBetween(0, $total); 

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'isbn' => $this->faker->unique()->isbn13(), 
            'total_copies' => $total,
            'available_copies' => $available,
            'status' => $available > 0, 
        ];
    }
}
