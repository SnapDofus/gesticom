<?php

namespace App\Exports;

use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MaterialsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Material::where('user_id', Auth::id())->get();
    }

    public function headings(): array
    {
        return [
            'Matériau',
            'Qté prévue',
            'Qté achetée',
            'Prix estimé (unité)',
            'Prix réel (unité)',
            'Fournisseur',
            'Statut',
        ];
    }

    public function map($material): array
    {
        $statuses = [
            'not_purchased' => 'Non acheté',
            'partially_purchased' => 'Partiellement acheté',
            'fully_purchased' => 'Complètement acheté',
        ];

        return [
            $material->name,
            $material->quantity_planned,
            $material->quantity_purchased,
            number_format($material->estimated_price, 0, ',', ' ') . ' FCFA',
            $material->actual_price ? number_format($material->actual_price, 0, ',', ' ') . ' FCFA' : '-',
            $material->supplier ?? '-',
            $statuses[$material->status] ?? $material->status,
        ];
    }
}
