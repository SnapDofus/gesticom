<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport matériaux</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { color: #9333ea; font-size: 20px; margin-bottom: 5px; }
        h2 { font-size: 14px; margin-top: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 6px 8px; text-align: left; border-bottom: 1px solid #ddd; font-size: 11px; }
        th { background: #f3f0ff; color: #9333ea; font-weight: 600; }
        .text-right { text-align: right; }
        .total { font-weight: bold; }
        .status { padding: 2px 6px; border-radius: 4px; font-size: 10px; }
        .status-purchased { background: #d1fae5; color: #065f46; }
        .status-partial { background: #fed7aa; color: #9a3412; }
        .status-not { background: #e5e7eb; color: #374151; }
    </style>
</head>
<body>
    <h1>Rapport des matériaux</h1>
    <p style="color: #666; margin-bottom: 20px;">Généré le {{ now()->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Matériau</th>
                <th class="text-right">Qté prévue</th>
                <th class="text-right">Qté achetée</th>
                <th class="text-right">Prix estimé</th>
                <th class="text-right">Prix réel</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
            <tr>
                <td>{{ $material->name }}</td>
                <td class="text-right">{{ $material->quantity_planned }}</td>
                <td class="text-right">{{ $material->quantity_purchased }}</td>
                <td class="text-right">{{ number_format($material->estimated_price, 0, ',', ' ') }} FCFA</td>
                <td class="text-right">{{ $material->actual_price ? number_format($material->actual_price, 0, ',', ' ') . ' FCFA' : '-' }}</td>
                <td>
                    <span class="status {{ $material->status === 'fully_purchased' ? 'status-purchased' : ($material->status === 'partially_purchased' ? 'status-partial' : 'status-not') }}">
                        {{ $material->status === 'fully_purchased' ? 'Acheté' : ($material->status === 'partially_purchased' ? 'Partiel' : 'Non acheté') }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
