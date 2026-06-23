<x-app-layout title="Budget">
    <x-slot name="header">Gestion du budget</x-slot>

    @php
        $categoryLabels = ['global' => 'Global', 'materials' => 'Matériaux', 'labor' => 'Main d\'œuvre', 'transport' => 'Transport', 'misc' => 'Divers'];
        $catColors = ['global' => 'purple', 'materials' => 'blue', 'labor' => 'orange', 'transport' => 'teal', 'misc' => 'gray'];
    @endphp

    <div class="space-y-4">
        @if($global)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Budget global</h3>
                <span class="text-2xl font-bold text-purple-600">{{ number_format($global->planned_amount, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-500">Dépensé</p>
                    <p class="text-lg font-semibold text-red-600">{{ number_format($global->spent_amount, 0, ',', ' ') }} FCFA</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Restant</p>
                    <p class="text-lg font-semibold text-{{ $global->is_over_budget ? 'red' : 'green' }}-600">{{ number_format($global->remaining, 0, ',', ' ') }} FCFA</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Utilisation</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $global->progress_percentage }}%</p>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-{{ $global->is_over_budget ? 'red' : 'purple' }}-600 h-3 rounded-full transition-all" style="width: {{ min(100, $global->progress_percentage) }}%"></div>
            </div>
            @if($global->is_over_budget)
                <div class="mt-3 bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded-lg text-sm">
                    ⚠️ Budget global dépassé de {{ number_format($global->spent_amount - $global->planned_amount, 0, ',', ' ') }} FCFA
                </div>
            @endif
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($budgets->where('category', '!=', 'global') as $budget)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-900">{{ $categoryLabels[$budget->category] ?? $budget->category }}</h4>
                    <span class="text-sm font-medium text-gray-700">{{ number_format($budget->planned_amount, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-500">Dépensé : <strong class="text-gray-900">{{ number_format($budget->spent_amount, 0, ',', ' ') }} FCFA</strong></span>
                    <span class="text-{{ $budget->is_over_budget ? 'red' : 'gray' }}-500">{{ $budget->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-{{ $budget->is_over_budget ? 'red' : 'purple' }}-500 h-2 rounded-full" style="width: {{ min(100, $budget->progress_percentage) }}%"></div>
                </div>
                @if($budget->is_over_budget)
                    <p class="text-xs text-red-600 mt-2">Dépassé de {{ number_format($budget->spent_amount - $budget->planned_amount, 0, ',', ' ') }} FCFA</p>
                @else
                    <p class="text-xs text-gray-400 mt-2">Restant : {{ number_format($budget->remaining, 0, ',', ' ') }} FCFA</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
