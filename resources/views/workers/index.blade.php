<x-app-layout title="Ouvriers">
    <x-slot name="header">Gestion des ouvriers</x-slot>

    <div class="space-y-4">
        <div class="flex justify-end">
            <button onclick="openModal('addWorkerModal')" class="mobile-btn-primary">
                + Nouvel ouvrier
            </button>
        </div>

        {{-- Desktop table --}}
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
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
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('workers.payments', $worker) }}" class="px-3 py-1.5 text-sm font-medium text-purple-600 hover:bg-purple-50 rounded-lg transition-colors">Paiements</a>
                                    <button onclick="quickPay({{ $worker->id }}, '{{ $worker->full_name }}', {{ $worker->daily_wage }})" class="px-3 py-1.5 text-sm font-medium text-green-600 hover:bg-green-50 rounded-lg transition-colors">Payer</button>
                                    <button onclick="editWorker({{ $worker->id }})" class="px-3 py-1.5 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Modifier</button>
                                    <form action="{{ route('workers.destroy', $worker) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet ouvrier ?')">
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
            @forelse($workers as $worker)
            <div class="mobile-card">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1 min-w-0 mr-3">
                        <h3 class="font-semibold text-gray-900 text-base">{{ $worker->full_name }}</h3>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $worker->function ?? 'Aucune fonction' }}</p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <a href="{{ route('workers.payments', $worker) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </a>
                        <button onclick="quickPay({{ $worker->id }}, '{{ $worker->full_name }}', {{ $worker->daily_wage }})" class="w-9 h-9 flex items-center justify-center rounded-xl bg-green-50 text-green-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </button>
                        <button onclick="editWorker({{ $worker->id }})" class="w-9 h-9 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form action="{{ route('workers.destroy', $worker) }}" method="POST" onsubmit="return confirm('Supprimer cet ouvrier ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-gray-400">Téléphone</span>
                        <p class="font-medium text-gray-900 mt-0.5">{{ $worker->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400">Salaire/jour</span>
                        <p class="font-medium text-gray-900 mt-0.5">{{ number_format($worker->daily_wage, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
                <div class="mt-2 pt-3 border-t border-gray-50 flex items-center justify-between">
                    <p class="text-sm">Total payé : <span class="font-semibold text-purple-600">{{ number_format($worker->total_paid, 0, ',', ' ') }} FCFA</span></p>
                    <button onclick="quickPay({{ $worker->id }}, '{{ $worker->full_name }}', {{ $worker->daily_wage }})" class="text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg">Payer</button>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                <p>Aucun ouvrier pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Add Modal --}}
    <div id="addWorkerModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto md:mx-4 md:max-w-lg md:rounded-xl max-sm:modal-bottom-sheet max-sm:mx-0">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
                <h3 class="text-lg font-semibold text-gray-900">Nouvel ouvrier</h3>
                <button onclick="closeModal('addWorkerModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('workers.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                    <input type="text" name="full_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fonction</label>
                        <select name="function" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Sélectionner une fonction</option>
                            <option value="Chef de chantier">Chef de chantier</option>
                            <option value="Maçon">Maçon</option>
                            <option value="Ferrailleur">Ferrailleur</option>
                            <option value="Coffreur">Coffreur</option>
                            <option value="Électricien">Électricien</option>
                            <option value="Plombier">Plombier</option>
                            <option value="Carreleur">Carreleur</option>
                            <option value="Peintre">Peintre</option>
                            <option value="Menuisier">Menuisier</option>
                            <option value="Charpentier">Charpentier</option>
                            <option value="Manceuvre">Manceuvre</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Salaire journalier (FCFA)</label>
                    <input type="number" step="0.01" name="daily_wage" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('addWorkerModal')" class="mobile-btn-ghost">Annuler</button>
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

        function quickPay(id, name, wage) {
            Swal.fire({
                title: 'Payer ' + name,
                html: `<p class="text-sm text-gray-500 mb-3">Salaire journalier : <strong>${wage.toLocaleString()} FCFA</strong></p>
                    <div class="space-y-2">
                        <input type="number" id="pay-days" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-lg text-center font-semibold focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Nombre de jours" min="1" value="1">
                        <p class="text-sm text-gray-500">Total à payer : <strong id="pay-total">${wage.toLocaleString()} FCFA</strong></p>
                    </div>`,
                showCancelButton: true,
                confirmButtonText: 'Confirmer le paiement',
                cancelButtonText: 'Annuler',
                didOpen: () => {
                    document.getElementById('pay-days').addEventListener('input', function() {
                        const days = parseInt(this.value) || 0;
                        document.getElementById('pay-total').textContent = (days * wage).toLocaleString() + ' FCFA';
                    });
                },
                preConfirm: () => {
                    const days = document.getElementById('pay-days').value;
                    if (!days || parseInt(days) < 1) {
                        Swal.showValidationMessage('Veuillez entrer un nombre de jours valide');
                        return false;
                    }
                    return days;
                }
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/workers/' + id + '/quick-pay';
                    form.innerHTML = '<input name="_token" value="{{ csrf_token() }}">' +
                                     '<input name="days" value="' + parseInt(result.value) + '">';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function editWorker(id) {
            fetch(`/workers/${id}/edit`)
                .then(r => r.json())
                .then(d => {
                    const functions = ['Chef de chantier','Maçon','Ferrailleur','Coffreur','Électricien','Plombier','Carreleur','Peintre','Menuisier','Charpentier','Manceuvre','Autre'];
                    let fnOpts = '<option value="">Sélectionner</option>';
                    functions.forEach(f => fnOpts += `<option value="${f}" ${d.function===f?'selected':''}>${f}</option>`);
                    Swal.fire({
                        title: 'Modifier l\'ouvrier',
                        html: `<form id="editWorkerForm" action="/workers/${id}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="text-left space-y-3">
                                <div><label class="block text-sm font-medium">Nom complet</label><input type="text" name="full_name" value="${d.full_name}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Téléphone</label><input type="text" name="phone" value="${d.phone || ''}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Fonction</label><select name="function" class="w-full border rounded-lg px-3 py-2 text-sm">${fnOpts}</select></div>
                                <div><label class="block text-sm font-medium">Salaire journalier</label><input type="number" step="0.01" name="daily_wage" value="${d.daily_wage}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                            </div></form>`,
                        showCancelButton: true,
                        confirmButtonText: 'Modifier',
                        cancelButtonText: 'Annuler',
                        preConfirm: () => { document.getElementById('editWorkerForm').submit(); }
                    });
                });
        }

        if (window.innerWidth >= 768) {
            $(document).ready(function() {
                $('#workers-table').DataTable({
                    language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json' },
                    pageLength: 25,
                    responsive: true
                });
            });
        }
    </script>
    @endpush
</x-app-layout>
