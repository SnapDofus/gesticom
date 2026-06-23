<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport chantier</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { color: #9333ea; font-size: 20px; margin-bottom: 5px; }
        h2 { font-size: 14px; margin-top: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 6px 8px; text-align: left; border-bottom: 1px solid #ddd; font-size: 11px; }
        th { background: #f3f0ff; color: #9333ea; font-weight: 600; }
        .text-right { text-align: right; }
        .progress-bar { width: 100%; height: 10px; background: #e5e7eb; border-radius: 5px; overflow: hidden; }
        .progress-fill { height: 100%; background: #9333ea; border-radius: 5px; }
        .status { padding: 2px 6px; border-radius: 4px; font-size: 10px; }
        .status-done { background: #d1fae5; color: #065f46; }
        .status-progress { background: #dbeafe; color: #1e40af; }
        .status-not { background: #e5e7eb; color: #374151; }
    </style>
</head>
<body>
    <h1>Rapport d'avancement du chantier</h1>
    <p style="color: #666; margin-bottom: 20px;">Généré le {{ now()->format('d/m/Y') }}</p>

    <h2>Avancement global : {{ round($tasks->avg('progress') ?? 0) }}%</h2>

    <table>
        <thead>
            <tr>
                <th>Tâche</th>
                <th>Statut</th>
                <th class="text-right">Avancement</th>
                <th class="text-right">Barre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->name }}</td>
                <td>
                    <span class="status {{ $task->status === 'completed' ? 'status-done' : ($task->status === 'in_progress' ? 'status-progress' : 'status-not') }}">
                        {{ $task->status === 'completed' ? 'Terminé' : ($task->status === 'in_progress' ? 'En cours' : 'Non commencé') }}
                    </span>
                </td>
                <td class="text-right">{{ $task->progress }}%</td>
                <td style="width: 150px;"><div class="progress-bar"><div class="progress-fill" style="width: {{ $task->progress }}%"></div></div></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
