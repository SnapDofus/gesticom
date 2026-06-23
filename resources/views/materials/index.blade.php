<x-app-layout title="Matériaux">
    <x-slot name="header">Gestion des matériaux</x-slot>

    <div class="space-y-4">
        <div class="flex justify-end">
            <button onclick="openModal('addMaterialModal')" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                + Nouveau matériau
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4">
                <table id="materials-table" class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Matériau</th>
                            <th class="pb-3 font-medium">Qté prévue</th>
                            <th class="pb-3 font-medium">Qté achetée</th>
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
                            <td class="py-3">{{ number_format($material->estimated_price, 0, ',', ' ') }} FCFA</td>
                            <td class="py-3">{{ $material->actual_price ? number_format($material->actual_price, 0, ',', ' ') . ' FCFA' : '-' }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $material->status === 'fully_purchased' ? 'bg-green-100 text-green-700' : ($material->status === 'partially_purchased' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ $material->status === 'fully_purchased' ? 'Acheté' : ($material->status === 'partially_purchased' ? 'Partiel' : 'Non acheté') }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center space-x-2">
                                    <button onclick="editMaterial({{ $material->id }})" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Modifier</button>
                                    @if($material->status !== 'fully_purchased')
                                    <form action="{{ route('materials.purchased', $material) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-800 text-xs font-medium">Acheter</button>
                                    </form>
                                    @endif
                                    <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce matériau ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="addMaterialModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Nouveau matériau</h3>
                <button onclick="closeModal('addMaterialModal')" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('materials.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom du matériau</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité prévue</label>
                        <input type="number" step="0.01" name="quantity_planned" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité achetée</label>
                        <input type="number" step="0.01" name="quantity_purchased" value="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix estimé (unité)</label>
                        <input type="number" step="0.01" name="estimated_price" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix réel (unité)</label>
                        <input type="number" step="0.01" name="actual_price" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                        <input type="text" name="supplier" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date d'achat</label>
                        <input type="date" name="purchase_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observation</label>
                        <textarea name="observation" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeModal('addMaterialModal')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editMaterialModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Modifier le matériau</h3>
                <button onclick="closeModal('editMaterialModal')" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form id="editMaterialForm" method="POST" class="p-5 space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="name" id="edit_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité prévue</label>
                        <input type="number" step="0.01" name="quantity_planned" id="edit_quantity_planned" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité achetée</label>
                        <input type="number" step="0.01" name="quantity_purchased" id="edit_quantity_purchased" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix estimé</label>
                        <input type="number" step="0.01" name="estimated_price" id="edit_estimated_price" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix réel</label>
                        <input type="number" step="0.01" name="actual_price" id="edit_actual_price" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                        <input type="text" name="supplier" id="edit_supplier" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date d'achat</label>
                        <input type="date" name="purchase_date" id="edit_purchase_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observation</label>
                        <textarea name="observation" id="edit_observation" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeModal('editMaterialModal')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">Modifier</button>
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
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); }

        function editMaterial(id) {
            fetch(`/materials/${id}/edit`)
                .then(r => r.json())
                .then(d => {
                    document.getElementById('edit_name').value = d.name;
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

        $(document).ready(function() {
            $('#materials-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                },
                pageLength: 25,
                order: [[0, 'asc']]
            });
        });
    </script>
    @endpush
</x-app-layout>
