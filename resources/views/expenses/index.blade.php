<x-app-layout title="Dépenses">
    <x-slot name="header">Gestion des dépenses</x-slot>

    <div class="space-y-4">
        <div class="flex justify-end">
            <button onclick="openModal('addExpenseModal')" class="mobile-btn-primary">
                + Nouvelle dépense
            </button>
        </div>

        {{-- Desktop table --}}
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4">
                <table id="expenses-table" class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Libellé</th>
                            <th class="pb-3 font-medium">Montant</th>
                            <th class="pb-3 font-medium">Catégorie</th>
                            <th class="pb-3 font-medium">Date</th>
                            <th class="pb-3 font-medium">Justificatif</th>
                            <th class="pb-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="py-3 font-medium text-gray-900">{{ $expense->label }}</td>
                            <td class="py-3 text-red-600 font-medium">{{ number_format($expense->amount, 0, ',', ' ') }} FCFA</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $expense->category === 'materials' ? 'bg-blue-100 text-blue-700' : ($expense->category === 'labor' ? 'bg-orange-100 text-orange-700' : ($expense->category === 'transport' ? 'bg-teal-100 text-teal-700' : 'bg-purple-100 text-purple-700')) }}">
                                    {{ ['materials' => 'Matériaux', 'labor' => 'Main d\'œuvre', 'transport' => 'Transport', 'misc' => 'Divers'][$expense->category] ?? $expense->category }}
                                </span>
                            </td>
                            <td class="py-3">{{ $expense->date->format('d/m/Y') }}</td>
                            <td class="py-3">
                                @if($expense->receipt)
                                    <a href="{{ Storage::url($expense->receipt) }}" target="_blank" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Voir</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <button onclick="editExpense({{ $expense->id }})" class="px-3 py-1.5 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Modifier</button>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette dépense ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile cards --}}
        <div class="md:hidden space-y-0">
            @forelse($expenses as $expense)
            <div class="mobile-card">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1 min-w-0 mr-3">
                        <h3 class="font-semibold text-gray-900 text-base truncate">{{ $expense->label }}</h3>
                        <p class="text-red-600 font-semibold text-lg mt-0.5">{{ number_format($expense->amount, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <button onclick="editExpense({{ $expense->id }})" class="w-9 h-9 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Supprimer cette dépense ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full
                        {{ $expense->category === 'materials' ? 'bg-blue-100 text-blue-700' : ($expense->category === 'labor' ? 'bg-orange-100 text-orange-700' : ($expense->category === 'transport' ? 'bg-teal-100 text-teal-700' : 'bg-purple-100 text-purple-700')) }}">
                        {{ ['materials' => 'Matériaux', 'labor' => 'Main d\'œuvre', 'transport' => 'Transport', 'misc' => 'Divers'][$expense->category] ?? $expense->category }}
                    </span>
                    <span class="text-sm text-gray-400">{{ $expense->date->format('d/m/Y') }}</span>
                    @if($expense->receipt)
                    <a href="{{ Storage::url($expense->receipt) }}" target="_blank" class="ml-auto text-purple-600 text-sm font-medium">Justificatif</a>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                <p>Aucune dépense pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Add Modal --}}
    <div id="addExpenseModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto md:mx-4 md:max-w-lg md:rounded-xl max-sm:modal-bottom-sheet max-sm:mx-0">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
                <h3 class="text-lg font-semibold text-gray-900">Nouvelle dépense</h3>
                <button onclick="closeModal('addExpenseModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Libellé</label>
                    <input type="text" name="label" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Montant (FCFA)</label>
                        <input type="number" step="0.01" name="amount" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <select name="category" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="materials">Matériaux</option>
                            <option value="labor">Main d'œuvre</option>
                            <option value="transport">Transport</option>
                            <option value="misc">Divers</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" name="date" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Justificatif</label>
                        <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-3 file:border file:border-gray-300 file:rounded-lg file:text-sm file:bg-gray-50">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observation</label>
                    <textarea name="observation" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('addExpenseModal')" class="mobile-btn-ghost">Annuler</button>
                    <button type="submit" class="mobile-btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    @endpush

    @push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
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

        function editExpense(id) {
            fetch(`/expenses/${id}/edit`)
                .then(r => r.json())
                .then(d => {
                    Swal.fire({
                        title: 'Modifier la dépense',
                        html: `<form id="editForm" action="/expenses/${id}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="text-left space-y-3">
                                <div><label class="block text-sm font-medium">Libellé</label><input type="text" name="label" value="${d.label}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Montant</label><input type="number" step="0.01" name="amount" value="${d.amount}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Catégorie</label><select name="category" class="w-full border rounded-lg px-3 py-2 text-sm">
                                    <option value="materials" ${d.category === 'materials' ? 'selected' : ''}>Matériaux</option>
                                    <option value="labor" ${d.category === 'labor' ? 'selected' : ''}>Main d'œuvre</option>
                                    <option value="transport" ${d.category === 'transport' ? 'selected' : ''}>Transport</option>
                                    <option value="misc" ${d.category === 'misc' ? 'selected' : ''}>Divers</option>
                                </select></div>
                                <div><label class="block text-sm font-medium">Date</label><input type="date" name="date" value="${d.date}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Observation</label><textarea name="observation" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm">${d.observation || ''}</textarea></div>
                            </div></form>`,
                        showCancelButton: true,
                        confirmButtonText: 'Modifier',
                        cancelButtonText: 'Annuler',
                        preConfirm: () => { document.getElementById('editForm').submit(); }
                    });
                });
        }

        if (window.innerWidth >= 768) {
            $(document).ready(function() {
                $('#expenses-table').DataTable({
                    language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json' },
                    pageLength: 25,
                    order: [[3, 'desc']]
                });
            });
        }
    </script>
    @endpush
</x-app-layout>
