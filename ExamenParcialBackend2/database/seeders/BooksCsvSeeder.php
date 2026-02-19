<?php



namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BooksCsvSeeder extends Seeder
{
    public function run()
    {
        Book::truncate();

        $csvFile = fopen(base_path('database\seeders\libros.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if ($firstline) { 
                $firstline = false;
                continue;
            }

            $total = (int) $data[3];
            $available = (int) $data[4];

            if ($available > $total) {
                $available = $total;
            }

            
            $isAvailable = isset($data[5]) ? (bool) ((int) $data[5]) : ($available > 0);

            Book::create([
                'title' => $data[0],
                'description' => $data[1] ?? null,
                'isbn' => $data[2],
                'total_copies' => $total,
                'available_copies' => $available,
                'status' => $isAvailable,
            ]);
        }

        fclose($csvFile);
    }
}

