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
                        <p class="text-2xl font-bold mt-1 {{ $stats['budgetProgress'] > 100 ? 'text-red-600' : 'text-orange-600' }}">{{ number_format($stats['totalSpent'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full {{ $stats['budgetProgress'] > 100 ? 'bg-red-600' : 'bg-purple-600' }}" style="width: {{ min(100, $stats['budgetProgress']) }}%"></div>
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
                @if($expensesByMonth->isNotEmpty())
                    <div id="expensesChart"></div>
                @else
                    <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm">Aucune dépense enregistrée</p>
                        <a href="{{ route('expenses.index') }}" class="text-purple-600 hover:underline text-sm mt-1">Ajouter une dépense</a>
                    </div>
                @endif
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par catégorie</h3>
                @if($expensesByCategory->isNotEmpty())
                    <div id="categoryChart"></div>
                @else
                    <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                        <p class="text-sm">Aucune dépense enregistrée</p>
                        <a href="{{ route('expenses.index') }}" class="text-purple-600 hover:underline text-sm mt-1">Ajouter une dépense</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Avancement des travaux</h3>
            <div id="progressChart"></div>
        </div>

        @if($workers->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Calculateur paie ouvriers</h3>

            {{-- Desktop table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b border-gray-100">
                            <th class="pb-2 font-medium">Ouvrier</th>
                            <th class="pb-2 font-medium">Fonction</th>
                            <th class="pb-2 font-medium">Tarif/jour</th>
                            <th class="pb-2 font-medium">Jours</th>
                            <th class="pb-2 font-medium">Total estimé</th>
                            <th class="pb-2 font-medium">Déjà payé</th>
                            <th class="pb-2 font-medium">Reste</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workers as $w)
                        <tr class="border-b border-gray-50">
                            <td class="py-2 font-medium text-gray-900">{{ $w['full_name'] }}</td>
                            <td class="py-2 text-gray-500">{{ $w['function'] ?? '-' }}</td>
                            <td class="py-2">{{ number_format($w['daily_wage'], 0, ',', ' ') }} FCFA</td>
                            <td class="py-2"><input type="number" min="0" value="0" class="worker-days" data-wage="{{ $w['daily_wage'] }}" data-paid="{{ $w['total_paid'] }}" style="width:70px" oninput="calcWorkerRow(this)"></td>
                            <td class="py-2 font-medium worker-estimated">0 FCFA</td>
                            <td class="py-2 text-orange-600">{{ number_format($w['total_paid'], 0, ',', ' ') }} FCFA</td>
                            <td class="py-2 font-semibold worker-remaining text-green-600">0 FCFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-gray-200 font-semibold text-gray-900">
                            <td class="pt-3" colspan="3">Total général</td>
                            <td class="pt-3" id="totalDays">0</td>
                            <td class="pt-3" id="totalEstimated">0 FCFA</td>
                            <td class="pt-3" id="totalPaid">0 FCFA</td>
                            <td class="pt-3" id="totalRemaining">0 FCFA</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Mobile cards --}}
            <div class="md:hidden space-y-3" id="worker-calc-mobile">
                @foreach($workers as $w)
                <div class="border border-gray-100 rounded-xl p-3 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">{{ $w['full_name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $w['function'] ?? '-' }}</p>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($w['daily_wage'], 0, ',', ' ') }} FCFA/jour</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="text-xs text-gray-500 shrink-0">Jours :</label>
                        <input type="number" min="0" value="0" class="worker-days flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm text-center" data-wage="{{ $w['daily_wage'] }}" data-paid="{{ $w['total_paid'] }}" oninput="calcWorkerRow(this)">
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span>Total estimé : <strong class="worker-estimated text-gray-900">0 FCFA</strong></span>
                        <span>Payé : <strong class="text-orange-600">{{ number_format($w['total_paid'], 0, ',', ' ') }} FCFA</strong></span>
                    </div>
                    <div class="text-sm font-semibold text-right">
                        Reste : <span class="worker-remaining text-green-600">0 FCFA</span>
                    </div>
                </div>
                @endforeach
                <div class="border-t border-gray-200 pt-3 mt-3 space-y-1 text-sm font-semibold text-right">
                    <p>Total jours : <span id="totalDays">0</span></p>
                    <p>Total estimé : <span id="totalEstimated">0 FCFA</span></p>
                    <p>Déjà payé : <span id="totalPaid">0 FCFA</span></p>
                    <p>Reste : <span id="totalRemaining">0 FCFA</span></p>
                </div>
            </div>
        </div>
        @endif

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
    <script>
        function calcWorkerRow(input) {
            const days = parseInt(input.value) || 0;
            const wage = parseFloat(input.dataset.wage);
            const paid = parseFloat(input.dataset.paid);
            const estimated = days * wage;
            const remaining = Math.max(0, estimated - paid);
            const row = input.closest('tr');
            row.querySelector('.worker-estimated').textContent = estimated.toLocaleString() + ' FCFA';
            row.querySelector('.worker-remaining').textContent = remaining.toLocaleString() + ' FCFA';
            row.querySelector('.worker-remaining').className = 'py-2 font-semibold worker-remaining ' + (remaining > 0 ? 'text-orange-600' : 'text-green-600');
            let totDays = 0, totEst = 0, totPaid = 0, totRem = 0;
            document.querySelectorAll('.worker-days').forEach(inp => {
                const d = parseInt(inp.value) || 0;
                totDays += d;
                totEst += d * parseFloat(inp.dataset.wage);
                totPaid += parseFloat(inp.dataset.paid);
            });
            totRem = Math.max(0, totEst - totPaid);
            document.getElementById('totalDays').textContent = totDays;
            document.getElementById('totalEstimated').textContent = totEst.toLocaleString() + ' FCFA';
            document.getElementById('totalPaid').textContent = totPaid.toLocaleString() + ' FCFA';
            document.getElementById('totalRemaining').textContent = totRem.toLocaleString() + ' FCFA';
        }
    </script>
    <script>
        const purple = '#9333ea', blue = '#3b82f6', green = '#10b981', orange = '#f59e0b', teal = '#14b8a6';

        @if($expensesByMonth->isNotEmpty())
        new ApexCharts(document.getElementById('expensesChart'), {
            chart: { type: 'area', height: 250, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
            series: [{
                name: 'Dépenses',
                data: {!! json_encode($expensesByMonth->values()) !!}
            }],
            xaxis: {
                categories: {!! json_encode($expensesByMonth->keys()) !!},
                labels: { style: { colors: '#6b7280', fontSize: '12px' } }
            },
            yaxis: {
                labels: {
                    formatter: v => v.toLocaleString() + ' FCFA',
                    style: { colors: '#6b7280', fontSize: '12px' }
                }
            },
            stroke: { curve: 'smooth', width: 2, colors: [purple] },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0 } },
            colors: [purple],
            dataLabels: { enabled: false },
            grid: { borderColor: '#f3f4f6' },
            tooltip: { y: { formatter: v => v.toLocaleString() + ' FCFA' } }
        }).render();
        @endif

        @if($expensesByCategory->isNotEmpty())
        const catColors = { materials: blue, labor: orange, transport: teal, misc: purple };
        const catLabels = { materials: 'Matériaux', labor: 'Main d\'œuvre', transport: 'Transport', misc: 'Divers' };
        new ApexCharts(document.getElementById('categoryChart'), {
            chart: { type: 'donut', height: 280, fontFamily: 'Inter, sans-serif' },
            series: {!! json_encode($expensesByCategory->values()) !!},
            labels: {!! json_encode($expensesByCategory->keys()->map(fn($k) => $catLabels[$k] ?? $k)) !!},
            colors: {!! json_encode($expensesByCategory->keys()->map(fn($k) => $catColors[$k] ?? '#6b7280')) !!},
            dataLabels: { enabled: false },
            legend: { position: 'bottom', fontSize: '13px', labels: { colors: '#374151' } },
            plotOptions: {
                pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', formatter: () => {!! json_encode(number_format($expensesByCategory->sum(), 0, ',', ' '))!!} + ' FCFA' } } } }
            },
            stroke: { show: false },
            tooltip: { y: { formatter: v => v.toLocaleString() + ' FCFA' } }
        }).render();
        @endif

        new ApexCharts(document.getElementById('progressChart'), {
            chart: { type: 'bar', height: 250, fontFamily: 'Inter, sans-serif', toolbar: { show: false } },
            series: [{
                name: 'Avancement %',
                data: {!! json_encode($tasksProgress->pluck('progress')) !!}
            }],
            xaxis: {
                categories: {!! json_encode($tasksProgress->pluck('name')) !!},
                labels: { style: { colors: '#6b7280', fontSize: '11px' } }
            },
            yaxis: { max: 100, labels: { style: { colors: '#6b7280', fontSize: '12px' } } },
            colors: {!! json_encode($tasksProgress->map(fn($t) => $t['status'] === 'completed' ? green : ($t['status'] === 'in_progress' ? purple : '#e5e7eb'))) !!},
            plotOptions: {
                bar: { borderRadius: 4, horizontal: true, distributed: true }
            },
            dataLabels: { enabled: true, formatter: v => v + '%', style: { colors: ['#1f2937'], fontSize: '11px', fontWeight: 600 } },
            grid: { borderColor: '#f3f4f6' },
            tooltip: { y: { formatter: v => v + '%' } }
        }).render();
    </script>
    @endpush
</x-app-layout>
