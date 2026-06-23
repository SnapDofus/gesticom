<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) return;

        $materials = [
            ['name' => 'Brique de 15', 'unit' => 'briques', 'quantity_planned' => 1000, 'estimated_price' => 400000],
            ['name' => 'Ciment', 'unit' => 'tonnes', 'quantity_planned' => 2, 'estimated_price' => 180000],
            ['name' => 'Semelles isolées', 'unit' => 'unités', 'quantity_planned' => 11, 'estimated_price' => 44000],
            ['name' => 'Barres de 10', 'unit' => 'barres', 'quantity_planned' => 22, 'estimated_price' => 110000],
            ['name' => 'Barres de 6', 'unit' => 'barres', 'quantity_planned' => 11, 'estimated_price' => 36000],
            ['name' => 'Fil d\'attache', 'unit' => 'rouleaux', 'quantity_planned' => 1, 'estimated_price' => 7000],
            ['name' => 'Semelles filantes 6m', 'unit' => 'unités', 'quantity_planned' => 10, 'estimated_price' => 110000],
            ['name' => 'Planches de coffrage 4m', 'unit' => 'planches', 'quantity_planned' => 10, 'estimated_price' => 60000],
            ['name' => 'Fonds de 15 de 3m', 'unit' => 'fonds', 'quantity_planned' => 10, 'estimated_price' => 35000],
            ['name' => 'Lattes de 5m', 'unit' => 'lattes', 'quantity_planned' => 15, 'estimated_price' => 45000],
            ['name' => 'Chevrons de 4m', 'unit' => 'chevrons', 'quantity_planned' => 20, 'estimated_price' => 100000],
            ['name' => 'Pointes de 80', 'unit' => 'kg', 'quantity_planned' => 5, 'estimated_price' => 7000],
            ['name' => 'Pointes TOC', 'unit' => 'kg', 'quantity_planned' => 3, 'estimated_price' => 7500],
        ];

        foreach ($materials as $material) {
            Material::create([
                'name' => $material['name'],
                'unit' => $material['unit'],
                'quantity_planned' => $material['quantity_planned'],
                'quantity_purchased' => 0,
                'estimated_price' => $material['estimated_price'],
                'actual_price' => null,
                'supplier' => null,
                'purchase_date' => null,
                'status' => 'not_purchased',
                'observation' => null,
                'user_id' => $user->id,
            ]);
        }
    }
}
