<x-app-layout title="Tâches">
    <x-slot name="header">Suivi des travaux</x-slot>

    @php
        $stageLabels = [
            'foundation' => 'Fondation', 'rebar' => 'Ferraillage', 'formwork' => 'Coffrage',
            'slab' => 'Dallage', 'wall_elevation' => 'Élévation des murs', 'framing' => 'Charpente',
            'roofing' => 'Toiture', 'electrical' => 'Électricité', 'plumbing' => 'Plomberie',
            'tiling' => 'Carrelage', 'painting' => 'Peinture', 'finishing' => 'Finitions',
        ];
        $statusLabels = ['not_started' => 'Non commencé', 'in_progress' => 'En cours', 'completed' => 'Terminé'];
        $statusColors = ['not_started' => 'bg-gray-100 text-gray-600', 'in_progress' => 'bg-blue-100 text-blue-700', 'completed' => 'bg-green-100 text-green-700'];
    @endphp

    <div class="space-y-4">
        <div class="flex justify-end">
            <button onclick="openModal('addTaskModal')" class="mobile-btn-primary">
                + Nouvelle tâche
            </button>
        </div>

        <div class="grid grid-cols-1 gap-3 md:gap-4">
            @foreach($tasks as $task)
            <div class="mobile-card">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start space-x-3 flex-1 min-w-0">
                        <div class="w-3 h-3 rounded-full shrink-0 mt-1 {{ $task->status === 'completed' ? 'bg-green-500' : ($task->status === 'in_progress' ? 'bg-blue-500' : 'bg-gray-300') }}"></div>
                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-900 text-base truncate">{{ $task->name }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $stageLabels[$task->stage] ?? $task->stage }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 sm:shrink-0">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-gray-700 min-w-[2.5rem]">{{ $task->progress }}%</span>
                            <div class="w-20 sm:w-24 bg-gray-200 rounded-full h-2.5">
                                <div class="bg-purple-600 h-2.5 rounded-full transition-all" style="width: {{ $task->progress }}%"></div>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $statusColors[$task->status] ?? 'bg-gray-100' }}">
                            {{ $statusLabels[$task->status] ?? $task->status }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            @if($task->status === 'not_started')
                            <form action="{{ route('tasks.status', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="text-xs px-2.5 py-1.5 font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors whitespace-nowrap">Commencer</button>
                            </form>
                            @endif
                            @if($task->status === 'in_progress')
                            <form action="{{ route('tasks.status', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="text-xs px-2.5 py-1.5 font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition-colors whitespace-nowrap">Terminer</button>
                            </form>
                            @endif
                            <button onclick="editTask({{ $task->id }})" class="w-9 h-9 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer cette tâche ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @if($task->description)
                <p class="mt-2 text-sm text-gray-500">{{ $task->description }}</p>
                @endif
                @if($task->status !== 'completed')
                <div class="mt-3">
                    <form id="progress-form-{{ $task->id }}" action="{{ route('tasks.progress', $task) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="range" min="0" max="100" name="progress" value="{{ $task->progress }}"
                            onchange="document.getElementById('progress-form-{{ $task->id }}').submit()"
                            class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-purple-600 touch-pan-y">
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div id="addTaskModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto md:mx-4 md:max-w-lg md:rounded-xl max-sm:modal-bottom-sheet max-sm:mx-0">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
                <h3 class="text-lg font-semibold text-gray-900">Nouvelle tâche</h3>
                <button onclick="closeModal('addTaskModal')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Étape</label>
                        <select name="stage" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            @foreach($stageLabels as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="status" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            @foreach($statusLabels as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                        <input type="date" name="start_date" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date fin prévue</label>
                        <input type="date" name="expected_end_date" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Avancement (%)</label>
                    <input type="number" min="0" max="100" name="progress" value="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('addTaskModal')" class="mobile-btn-ghost">Annuler</button>
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

        function updateTaskProgress(id, value) {
            fetch(`/tasks/${id}/progress`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ progress: value })
            }).then(r => r.json()).then(d => {
                if (d.success) location.reload();
            });
        }

        function editTask(id) {
            fetch(`/tasks/${id}/edit`)
                .then(r => r.json())
                .then(d => {
                    const stageLabels = {'foundation':'Fondation','rebar':'Ferraillage','formwork':'Coffrage','slab':'Dallage','wall_elevation':'Élévation des murs','framing':'Charpente','roofing':'Toiture','electrical':'Électricité','plumbing':'Plomberie','tiling':'Carrelage','painting':'Peinture','finishing':'Finitions'};
                    const statusLabels = {'not_started':'Non commencé','in_progress':'En cours','completed':'Terminé'};
                    let stageOpts = '', statusOpts = '';
                    for (const [k,v] of Object.entries(stageLabels)) stageOpts += `<option value="${k}" ${d.stage===k?'selected':''}>${v}</option>`;
                    for (const [k,v] of Object.entries(statusLabels)) statusOpts += `<option value="${k}" ${d.status===k?'selected':''}>${v}</option>`;
                    Swal.fire({
                        title: 'Modifier la tâche',
                        html: `<form id="editTaskForm" action="/tasks/${id}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="text-left space-y-3">
                                <div><label class="block text-sm font-medium">Nom</label><input type="text" name="name" value="${d.name}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Étape</label><select name="stage" class="w-full border rounded-lg px-3 py-2 text-sm">${stageOpts}</select></div>
                                <div><label class="block text-sm font-medium">Avancement (%)</label><input type="number" min="0" max="100" name="progress" value="${d.progress}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Statut</label><select name="status" class="w-full border rounded-lg px-3 py-2 text-sm">${statusOpts}</select></div>
                                <div><label class="block text-sm font-medium">Description</label><textarea name="description" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm">${d.description || ''}</textarea></div>
                            </div></form>`,
                        showCancelButton: true,
                        confirmButtonText: 'Modifier',
                        cancelButtonText: 'Annuler',
                        preConfirm: () => { document.getElementById('editTaskForm').submit(); }
                    });
                });
        }
    </script>
    @endpush
</x-app-layout>
