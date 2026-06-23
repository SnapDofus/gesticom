<x-app-layout title="Paiements - {{ $worker->full_name }}">
    <x-slot name="header">Paiements de {{ $worker->full_name }}</x-slot>

    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="text-sm text-gray-500 flex flex-wrap gap-x-2">
                <span>Salaire : <span class="font-semibold text-gray-900">{{ number_format($worker->daily_wage, 0, ',', ' ') }} FCFA</span></span>
                <span class="hidden sm:inline">|</span>
                <span>Total payé : <span class="font-semibold text-purple-600">{{ number_format($worker->total_paid, 0, ',', ' ') }} FCFA</span></span>
            </div>
            <button onclick="openModal('addPaymentModal')" class="mobile-btn-primary w-full sm:w-auto">
                + Nouveau paiement
            </button>
        </div>

        {{-- Desktop table --}}
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
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
                                    <button type="submit" class="px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">Supprimer</button>
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

        {{-- Mobile cards --}}
        <div class="md:hidden space-y-0">
            @forelse($payments as $payment)
            <div class="mobile-card">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-400">{{ $payment->date->format('d/m/Y') }}</span>
                    <form action="{{ route('workers.payments.destroy', [$worker, $payment]) }}" method="POST" onsubmit="return confirm('Supprimer ce paiement ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
                <p class="text-lg font-semibold text-gray-900">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</p>
                @if($payment->observation)
                <p class="text-sm text-gray-500 mt-1">{{ $payment->observation }}</p>
                @endif
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                <p>Aucun paiement enregistré pour cet ouvrier.</p>
            </div>
            @endforelse
        </div>

        <div class="flex">
            <a href="{{ route('workers.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">&larr; Retour aux ouvriers</a>
        </div>
    </div>

    {{-- Add Payment Modal --}}
    <div id="addPaymentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto md:mx-4 md:max-w-lg md:rounded-xl max-sm:modal-bottom-sheet max-sm:mx-0">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
                <h3 class="text-lg font-semibold text-gray-900">Nouveau paiement</h3>
                <button onclick="closeModal('addPaymentModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('workers.payments.store', $worker) }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Montant (FCFA)</label>
                    <input type="number" step="0.01" name="amount" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observation</label>
                    <textarea name="observation" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('addPaymentModal')" class="mobile-btn-ghost">Annuler</button>
                    <button type="submit" class="mobile-btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    </script>
    @endpush
</x-app-layout>
