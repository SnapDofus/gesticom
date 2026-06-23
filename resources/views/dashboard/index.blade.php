@php
    $categoryLabels = ['materials' => 'Matériaux', 'labor' => 'Main d\'œuvre', 'transport' => 'Transport', 'misc' => 'Divers'];
    $statusLabels = ['not_started' => 'Non commencé', 'in_progress' => 'En cours', 'completed' => 'Terminé'];
    $stageLabels = [
        'foundation' => 'Fondation', 'rebar' => 'Ferraillage', 'formwork' => 'Coffrage',
        'slab' => 'Dallage', 'wall_elevation' => 'Murs', 'framing' => 'Charpente',
        'roofing' => 'Toiture', 'electrical' => 'Électricité', 'plumbing' => 'Plomberie',
        'tiling' => 'Carrelage', 'painting' => 'Peinture', 'finishing' => 'Finitions',
    ];
@endphp

<x-app-layout title="Dashboard">
    <x-slot name="header">Tableau de bord</x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Budget total</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['totalBudget'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dépensé</p>
                        <p class="text-2xl font-bold text-{{ $stats['budgetProgress'] > 100 ? 'red' : 'orange' }}-600 mt-1">{{ number_format($stats['totalSpent'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-{{ $stats['budgetProgress'] > 100 ? 'red' : 'purple' }}-600 h-1.5 rounded-full" style="width: {{ min(100, $stats['budgetProgress']) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['budgetProgress'] }}% du budget</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Restant</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($stats['remainingBudget'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Avancement</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1">{{ $stats['overallProgress'] }}%</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $stats['overallProgress'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-sm text-gray-500">Matériaux</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['purchasedMaterials'] }}/{{ $stats['materialCount'] }} achetés</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-sm text-gray-500">Tâches</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['completedTasks'] }}/{{ $stats['totalTasks'] }} terminées</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-sm text-gray-500">Ouvriers</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['workerCount'] }} inscrits</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-sm text-gray-500">Photos</p>
                <p class="text-lg font-semibold text-gray-900">{{ $stats['photoCount'] }} prises</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Évolution des dépenses</h3>
                <canvas id="expensesChart" height="200"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par catégorie</h3>
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Avancement des travaux</h3>
            <canvas id="progressChart" height="120"></canvas>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Dernières dépenses</h3>
                <div class="space-y-3">
                    @forelse($recentExpenses as $expense)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $expense->label }}</p>
                                <p class="text-xs text-gray-500">{{ $expense->date->format('d/m/Y') }} · {{ $categoryLabels[$expense->category] ?? $expense->category }}</p>
                            </div>
                            <span class="text-sm font-semibold text-red-600">{{ number_format($expense->amount, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aucune dépense récente.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Dernières tâches</h3>
                <div class="space-y-3">
                    @forelse($recentTasks as $task)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $task->name }}</p>
                                <p class="text-xs text-gray-500">{{ $stageLabels[$task->stage] ?? $task->stage }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $task->status === 'completed' ? 'bg-green-100 text-green-700' : ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ $statusLabels[$task->status] ?? $task->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aucune tâche récente.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const colors = {
            purple: '#9333ea',
            blue: '#3b82f6',
            green: '#10b981',
            orange: '#f59e0b',
            red: '#ef4444',
            teal: '#14b8a6',
        };

        @if($expensesByMonth->isNotEmpty())
        new Chart(document.getElementById('expensesChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($expensesByMonth->keys()) !!},
                datasets: [{
                    label: 'Dépenses',
                    data: {!! json_encode($expensesByMonth->values()) !!},
                    borderColor: colors.purple,
                    backgroundColor: colors.purple + '20',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { ticks: { callback: v => v.toLocaleString() + ' FCFA' } }
                }
            }
        });
        @endif

        @if($expensesByCategory->isNotEmpty())
        const catColors = { materials: colors.blue, labor: colors.orange, transport: colors.teal, misc: colors.purple };
        const catLabels = { materials: 'Matériaux', labor: 'Main d\'œuvre', transport: 'Transport', misc: 'Divers' };
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($expensesByCategory->keys()->map(fn($k) => $catLabels[$k] ?? $k)) !!},
                datasets: [{
                    data: {!! json_encode($expensesByCategory->values()) !!},
                    backgroundColor: {!! json_encode($expensesByCategory->keys()->map(fn($k) => $catColors[$k] ?? colors.gray)) !!},
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
        @endif

        @if($tasksProgress->isNotEmpty())
        new Chart(document.getElementById('progressChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($tasksProgress->pluck('name')) !!},
                datasets: [{
                    label: 'Avancement %',
                    data: {!! json_encode($tasksProgress->pluck('progress')) !!},
                    backgroundColor: colors.purple,
                    borderRadius: 4,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { min: 0, max: 100 },
                    y: { ticks: { font: { size: 11 } } }
                }
            }
        });
        @endif
    </script>
    @endpush
</x-app-layout>
