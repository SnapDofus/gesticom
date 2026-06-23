<x-app-layout title="Paiements - {{ $worker->full_name }}">
    <x-slot name="header">Paiements de {{ $worker->full_name }}</x-slot>

    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Salaire journalier : <span class="font-semibold text-gray-900">{{ number_format($worker->daily_wage, 0, ',', ' ') }} FCFA</span>
                | Total payé : <span class="font-semibold text-purple-600">{{ number_format($worker->total_paid, 0, ',', ' ') }} FCFA</span>
            </div>
            <button onclick="openModal('addPaymentModal')" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                + Nouveau paiement
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Date</th>
                            <th class="pb-3 font-medium">Montant</th>
                            <th class="pb-3 font-medium">Observation</th>
                            <th class="pb-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="py-3">{{ $payment->date->format('d/m/Y') }}</td>
                            <td class="py-3 font-medium text-gray-900">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</td>
                            <td class="py-3 text-gray-500">{{ $payment->observation ?? '-' }}</td>
                            <td class="py-3">
                                <form action="{{ route('workers.payments.destroy', [$worker, $payment]) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce paiement ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-8 text-center text-gray-500">Aucun paiement enregistré.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex">
            <a href="{{ route('workers.index') }}" class="text-sm text-purple-600 hover:text-purple-800">&larr; Retour aux ouvriers</a>
        </div>
    </div>

    <div id="addPaymentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Nouveau paiement</h3>
                <button onclick="closeModal('addPaymentModal')" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('workers.payments.store', $worker) }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Montant (FCFA)</label>
                    <input type="number" step="0.01" name="amount" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observation</label>
                    <textarea name="observation" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeModal('addPaymentModal')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); }
    </script>
    @endpush
</x-app-layout>
