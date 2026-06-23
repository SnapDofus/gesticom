<?php

namespace App\Exports;

use App\Models\WorkerPayment;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return WorkerPayment::with('worker')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function headings(): array
    {
        return [
            'Ouvrier',
            'Date',
            'Montant',
            'Observation',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->worker->full_name ?? 'N/A',
            $payment->date->format('d/m/Y'),
            number_format($payment->amount, 0, ',', ' ') . ' FCFA',
            $payment->observation ?? '-',
        ];
    }
}
