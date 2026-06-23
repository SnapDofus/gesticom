<x-app-layout title="Rapports">
    <x-slot name="header">Exports et rapports</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Rapport financier</h3>
            <p class="text-sm text-gray-500 mt-1">Toutes les dépenses et budgets du projet</p>
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('reports.financial') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">PDF</a>
                <a href="{{ route('reports.expenses-excel') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">Excel</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Rapport matériaux</h3>
            <p class="text-sm text-gray-500 mt-1">Liste complète des matériaux et coûts</p>
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('reports.materials') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">PDF</a>
                <a href="{{ route('reports.materials-excel') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">Excel</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Rapport chantier</h3>
            <p class="text-sm text-gray-500 mt-1">État des tâches et avancement des travaux</p>
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('reports.tasks') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">PDF</a>
                <a href="{{ route('reports.payments-excel') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">Excel</a>
            </div>
        </div>
    </div>
</x-app-layout>
