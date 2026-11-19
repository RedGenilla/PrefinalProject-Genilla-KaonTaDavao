<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            'Poblacion',
            'Talomo',
            'Agdao',
            'Buhangin',
            'Toril',
            'Bunawan',
        ];

        // Create each required district.
        foreach ($districts as $name) {
            District::create([
                'name' => $name,
            ]);
        }
    }
}
