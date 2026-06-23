<x-app-layout title="Ouvriers">
    <x-slot name="header">Gestion des ouvriers</x-slot>

    <div class="space-y-4">
        <div class="flex justify-end">
            <button onclick="openModal('addWorkerModal')" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                + Nouvel ouvrier
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4">
                <table id="workers-table" class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Nom complet</th>
                            <th class="pb-3 font-medium">Téléphone</th>
                            <th class="pb-3 font-medium">Fonction</th>
                            <th class="pb-3 font-medium">Salaire/jour</th>
                            <th class="pb-3 font-medium">Total payé</th>
                            <th class="pb-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workers as $worker)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="py-3 font-medium text-gray-900">{{ $worker->full_name }}</td>
                            <td class="py-3">{{ $worker->phone ?? '-' }}</td>
                            <td class="py-3">{{ $worker->function ?? '-' }}</td>
                            <td class="py-3">{{ number_format($worker->daily_wage, 0, ',', ' ') }} FCFA</td>
                            <td class="py-3 font-medium text-purple-600">{{ number_format($worker->total_paid, 0, ',', ' ') }} FCFA</td>
                            <td class="py-3">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('workers.payments', $worker) }}" class="text-purple-600 hover:text-purple-800 text-xs font-medium">Paiements</a>
                                    <button onclick="editWorker({{ $worker->id }})" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Modifier</button>
                                    <form action="{{ route('workers.destroy', $worker) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet ouvrier ?')">
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

    <div id="addWorkerModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Nouvel ouvrier</h3>
                <button onclick="closeModal('addWorkerModal')" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('workers.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                    <input type="text" name="full_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fonction</label>
                        <input type="text" name="function" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Salaire journalier (FCFA)</label>
                    <input type="number" step="0.01" name="daily_wage" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeModal('addWorkerModal')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">Enregistrer</button>
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

        function editWorker(id) {
            fetch(`/workers/${id}/edit`)
                .then(r => r.json())
                .then(d => {
                    Swal.fire({
                        title: 'Modifier l\'ouvrier',
                        html: `<form id="editWorkerForm" action="/workers/${id}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="text-left space-y-3">
                                <div><label class="block text-sm font-medium">Nom complet</label><input type="text" name="full_name" value="${d.full_name}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Téléphone</label><input type="text" name="phone" value="${d.phone || ''}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Fonction</label><input type="text" name="function" value="${d.function || ''}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Salaire journalier</label><input type="number" step="0.01" name="daily_wage" value="${d.daily_wage}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                            </div></form>`,
                        showCancelButton: true,
                        confirmButtonText: 'Modifier',
                        cancelButtonText: 'Annuler',
                        preConfirm: () => { document.getElementById('editWorkerForm').submit(); }
                    });
                });
        }

        $(document).ready(function() {
            $('#workers-table').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json' },
                pageLength: 25
            });
        });
    </script>
    @endpush
</x-app-layout>
