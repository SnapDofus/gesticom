<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport financier</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { color: #9333ea; font-size: 20px; margin-bottom: 5px; }
        h2 { font-size: 14px; margin-top: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 6px 8px; text-align: left; border-bottom: 1px solid #ddd; font-size: 11px; }
        th { background: #f3f0ff; color: #9333ea; font-weight: 600; }
        .text-right { text-align: right; }
        .total { font-weight: bold; }
        .summary { margin-top: 20px; }
        .summary-item { margin-bottom: 5px; }
        .label { color: #666; }
        .value { font-weight: bold; }
        .over { color: #ef4444; }
    </style>
</head>
<body>
    <h1>Rapport financier</h1>
    <p style="color: #666; margin-bottom: 20px;">Généré le {{ now()->format('d/m/Y') }}</p>

    <div class="summary">
        <h2>Résumé</h2>
        <div class="summary-item"><span class="label">Budget total : </span><span class="value">{{ number_format($totalBudget, 0, ',', ' ') }} FCFA</span></div>
        <div class="summary-item"><span class="label">Total dépensé : </span><span class="value {{ $totalSpent > $totalBudget ? 'over' : '' }}">{{ number_format($totalSpent, 0, ',', ' ') }} FCFA</span></div>
        <div class="summary-item"><span class="label">Reste : </span><span class="value">{{ number_format(max(0, $totalBudget - $totalSpent), 0, ',', ' ') }} FCFA</span></div>
    </div>

    <h2>Détail des dépenses</h2>
    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Catégorie</th>
                <th>Date</th>
                <th class="text-right">Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->label }}</td>
                <td>{{ ['materials' => 'Matériaux', 'labor' => 'Main d\'œuvre', 'transport' => 'Transport', 'misc' => 'Divers'][$expense->category] ?? $expense->category }}</td>
                <td>{{ $expense->date->format('d/m/Y') }}</td>
                <td class="text-right">{{ number_format($expense->amount, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-right total">Total</td>
                <td class="text-right total">{{ number_format($totalSpent, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tbody>
    </table>

    <h2>Budgets par catégorie</h2>
    <table>
        <thead>
            <tr>
                <th>Catégorie</th>
                <th class="text-right">Prévu</th>
                <th class="text-right">Dépensé</th>
                <th class="text-right">Reste</th>
            </tr>
        </thead>
        <tbody>
            @foreach($budgets as $budget)
            <tr>
                <td>{{ ['global' => 'Global', 'materials' => 'Matériaux', 'labor' => 'Main d\'œuvre', 'transport' => 'Transport', 'misc' => 'Divers'][$budget->category] ?? $budget->category }}</td>
                <td class="text-right">{{ number_format($budget->planned_amount, 0, ',', ' ') }} FCFA</td>
                <td class="text-right">{{ number_format($budget->spent_amount, 0, ',', ' ') }} FCFA</td>
                <td class="text-right">{{ number_format($budget->remaining, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
