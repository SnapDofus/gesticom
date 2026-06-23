<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpensesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Expense::where('user_id', Auth::id())->get();
    }

    public function headings(): array
    {
        return [
            'Libellé',
            'Montant',
            'Catégorie',
            'Date',
            'Observation',
        ];
    }

    public function map($expense): array
    {
        $categories = [
            'materials' => 'Matériaux',
            'labor' => 'Main d\'œuvre',
            'transport' => 'Transport',
            'misc' => 'Divers',
        ];

        return [
            $expense->label,
            number_format($expense->amount, 0, ',', ' ') . ' FCFA',
            $categories[$expense->category] ?? $expense->category,
            $expense->date->format('d/m/Y'),
            $expense->observation ?? '-',
        ];
    }
}
