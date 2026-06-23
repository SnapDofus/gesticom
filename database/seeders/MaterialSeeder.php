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
            ['name' => 'Brique de 15', 'quantity_planned' => 1000, 'estimated_price' => 400],
            ['name' => 'Ciment', 'quantity_planned' => 2, 'estimated_price' => 90000],
            ['name' => 'Semelles isolées', 'quantity_planned' => 11, 'estimated_price' => 4000],
            ['name' => 'Barres de 10', 'quantity_planned' => 22, 'estimated_price' => 5000],
            ['name' => 'Barres de 6', 'quantity_planned' => 11, 'estimated_price' => 3273],
            ['name' => 'Fil d\'attache', 'quantity_planned' => 1, 'estimated_price' => 7000],
            ['name' => 'Semelles filantes 6m', 'quantity_planned' => 10, 'estimated_price' => 11000],
            ['name' => 'Planches de coffrage 4m', 'quantity_planned' => 10, 'estimated_price' => 6000],
            ['name' => 'Fonds de 15 de 3m', 'quantity_planned' => 10, 'estimated_price' => 3500],
            ['name' => 'Lattes de 5m', 'quantity_planned' => 15, 'estimated_price' => 3000],
            ['name' => 'Chevrons de 4m', 'quantity_planned' => 20, 'estimated_price' => 5000],
            ['name' => 'Pointes de 80', 'quantity_planned' => 5, 'estimated_price' => 1400],
            ['name' => 'Pointes TOC', 'quantity_planned' => 3, 'estimated_price' => 2500],
        ];

        foreach ($materials as $material) {
            Material::create([
                'name' => $material['name'],
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
