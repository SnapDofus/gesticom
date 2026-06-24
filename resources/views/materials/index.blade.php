<x-app-layout title="Matériaux">
    <x-slot name="header">Gestion des matériaux</x-slot>

    <div class="space-y-4">
        <div class="flex justify-end">
            <button onclick="openModal('addMaterialModal')" class="mobile-btn-primary">
                + Nouveau matériau
            </button>
        </div>

        {{-- Desktop table --}}
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4">
                <table id="materials-table" class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Matériau</th>
                            <th class="pb-3 font-medium">Qté prévue</th>
                            <th class="pb-3 font-medium">Qté achetée</th>
                            <th class="pb-3 font-medium">Unité</th>
                            <th class="pb-3 font-medium">Prix estimé</th>
                            <th class="pb-3 font-medium">Prix réel</th>
                            <th class="pb-3 font-medium">Statut</th>
                            <th class="pb-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materials as $material)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="py-3 font-medium text-gray-900">{{ $material->name }}</td>
                            <td class="py-3">{{ $material->quantity_planned }}</td>
                            <td class="py-3">{{ $material->quantity_purchased }}</td>
                            <td class="py-3 text-gray-500">{{ $material->unit ?? '-' }}</td>
                            <td class="py-3">{{ number_format($material->estimated_price, 0, ',', ' ') }} FCFA</td>
                            <td class="py-3">{{ $material->actual_price ? number_format($material->actual_price, 0, ',', ' ') . ' FCFA' : '-' }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $material->status === 'fully_purchased' ? 'bg-green-100 text-green-700' : ($material->status === 'partially_purchased' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ $material->status === 'fully_purchased' ? 'Acheté' : ($material->status === 'partially_purchased' ? 'Partiel' : 'Non acheté') }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <button onclick="editMaterial({{ $material->id }})" class="px-3 py-1.5 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Modifier</button>
                                    @if($material->status !== 'fully_purchased')
                                    <button onclick="purchaseMaterial({{ $material->id }}, '{{ $material->name }}', {{ $material->quantity_planned }}, {{ $material->quantity_purchased }}, '{{ $material->unit }}')" class="px-3 py-1.5 text-sm font-medium text-green-600 hover:bg-green-50 rounded-lg transition-colors">Acheter</button>
                                    @endif
                                    <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce matériau ?')">
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
            @forelse($materials as $material)
            <div class="mobile-card">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1 min-w-0 mr-3">
                        <h3 class="font-semibold text-gray-900 text-base truncate">{{ $material->name }}</h3>
                        <span class="inline-block mt-1.5 px-2.5 py-1 text-xs font-medium rounded-full
                            {{ $material->status === 'fully_purchased' ? 'bg-green-100 text-green-700' : ($material->status === 'partially_purchased' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ $material->status === 'fully_purchased' ? 'Acheté' : ($material->status === 'partially_purchased' ? 'Partiel' : 'Non acheté') }}
                        </span>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <button onclick="editMaterial({{ $material->id }})" class="w-9 h-9 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form action="{{ route('materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Supprimer ce matériau ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-gray-400">Qté prévue</span>
                        <p class="font-medium text-gray-900 mt-0.5">{{ $material->quantity_planned }} {{ $material->unit }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400">Qté achetée</span>
                        <p class="font-medium text-gray-900 mt-0.5">{{ $material->quantity_purchased }} {{ $material->unit }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400">Prix estimé</span>
                        <p class="font-medium text-gray-900 mt-0.5">{{ number_format($material->estimated_price, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div>
                        <span class="text-gray-400">Prix réel</span>
                        <p class="font-medium text-gray-900 mt-0.5">{{ $material->actual_price ? number_format($material->actual_price, 0, ',', ' ') . ' FCFA' : '-' }}</p>
                    </div>
                </div>
                @if($material->status !== 'fully_purchased')
                <button onclick="purchaseMaterial({{ $material->id }}, '{{ $material->name }}', {{ $material->quantity_planned }}, {{ $material->quantity_purchased }}, '{{ $material->unit }}')" class="mobile-btn-primary w-full mt-3">Acheter</button>
                @endif
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                <p>Aucun matériau pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Add Modal --}}
    <div id="addMaterialModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto md:mx-4 md:max-w-lg md:rounded-xl max-sm:modal-bottom-sheet max-sm:mx-0">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
                <h3 class="text-lg font-semibold text-gray-900">Nouveau matériau</h3>
                <button onclick="closeModal('addMaterialModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('materials.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom du matériau</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unité</label>
                        <input type="text" name="unit" placeholder="ex: briques, kg, tonnes" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité prévue</label>
                        <input type="number" step="0.01" name="quantity_planned" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité achetée</label>
                        <input type="number" step="0.01" name="quantity_purchased" value="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix estimé (total)</label>
                        <input type="number" step="0.01" name="estimated_price" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix réel (total)</label>
                        <input type="number" step="0.01" name="actual_price" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                        <input type="text" name="supplier" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date d'achat</label>
                        <input type="date" name="purchase_date" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observation</label>
                        <textarea name="observation" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('addMaterialModal')" class="mobile-btn-ghost">Annuler</button>
                    <button type="submit" class="mobile-btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editMaterialModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto md:mx-4 md:max-w-lg md:rounded-xl max-sm:modal-bottom-sheet max-sm:mx-0">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
                <h3 class="text-lg font-semibold text-gray-900">Modifier le matériau</h3>
                <button onclick="closeModal('editMaterialModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form id="editMaterialForm" method="POST" class="p-5 space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="name" id="edit_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unité</label>
                        <input type="text" name="unit" id="edit_unit" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité prévue</label>
                        <input type="number" step="0.01" name="quantity_planned" id="edit_quantity_planned" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité achetée</label>
                        <input type="number" step="0.01" name="quantity_purchased" id="edit_quantity_purchased" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix estimé</label>
                        <input type="number" step="0.01" name="estimated_price" id="edit_estimated_price" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix réel</label>
                        <input type="number" step="0.01" name="actual_price" id="edit_actual_price" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                        <input type="text" name="supplier" id="edit_supplier" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date d'achat</label>
                        <input type="date" name="purchase_date" id="edit_purchase_date" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observation</label>
                        <textarea name="observation" id="edit_observation" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('editMaterialModal')" class="mobile-btn-ghost">Annuler</button>
                    <button type="submit" class="mobile-btn-primary">Modifier</button>
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
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
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

        function purchaseMaterial(id, name, planned, purchased, unit) {
            const remaining = planned - purchased;
            if (remaining <= 0) {
                Swal.fire('Déjà acheté', 'Ce matériau est déjà entièrement acheté.', 'info');
                return;
            }
            const unitLabel = unit ? ' ' + unit : '';
            Swal.fire({
                title: 'Acheter ' + name,
                html: `<p class="text-sm text-gray-500 mb-3">Restant à acheter : <strong>${remaining}${unitLabel}</strong> sur <strong>${planned}${unitLabel}</strong></p>
                    <input type="number" id="purchase-qty" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-lg text-center font-semibold focus:outline-none focus:ring-2 focus:ring-purple-500" value="${remaining}" min="0.01" max="${remaining}" step="0.01">`,
                showCancelButton: true,
                confirmButtonText: 'Valider l\'achat',
                cancelButtonText: 'Annuler',
                preConfirm: () => {
                    const qty = document.getElementById('purchase-qty').value;
                    if (!qty || parseFloat(qty) <= 0) {
                        Swal.showValidationMessage('Veuillez entrer une quantité valide');
                        return false;
                    }
                    if (parseFloat(qty) > remaining) {
                        Swal.showValidationMessage('La quantité ne peut pas dépasser ' + remaining);
                        return false;
                    }
                    return qty;
                }
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/materials/' + id + '/purchased';
                    form.innerHTML = '<input name="_token" value="{{ csrf_token() }}">' +
                                     '<input name="_method" value="PATCH">' +
                                     '<input name="quantity" value="' + parseFloat(result.value) + '">';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function editMaterial(id) {
            fetch(`/materials/${id}/edit`)
                .then(r => r.json())
                .then(d => {
                    document.getElementById('edit_name').value = d.name;
                    document.getElementById('edit_unit').value = d.unit || '';
                    document.getElementById('edit_quantity_planned').value = d.quantity_planned;
                    document.getElementById('edit_quantity_purchased').value = d.quantity_purchased;
                    document.getElementById('edit_estimated_price').value = d.estimated_price;
                    document.getElementById('edit_actual_price').value = d.actual_price || '';
                    document.getElementById('edit_supplier').value = d.supplier || '';
                    document.getElementById('edit_purchase_date').value = d.purchase_date || '';
                    document.getElementById('edit_observation').value = d.observation || '';
                    document.getElementById('editMaterialForm').action = `/materials/${id}`;
                    openModal('editMaterialModal');
                });
        }

        if (window.innerWidth >= 768) {
            $(document).ready(function() {
                $('#materials-table').DataTable({
                    language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json' },
                    pageLength: 25,
                    responsive: true,
                    order: [[0, 'asc']]
                });
            });
        }
    </script>
    @endpush
</x-app-layout>
