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
            <button onclick="openModal('addTaskModal')" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                + Nouvelle tâche
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @foreach($tasks as $task)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 rounded-full {{ $task->status === 'completed' ? 'bg-green-500' : ($task->status === 'in_progress' ? 'bg-blue-500' : 'bg-gray-300') }}"></div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $task->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $stageLabels[$task->stage] ?? $task->stage }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-700">{{ $task->progress }}%</span>
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full transition-all" style="width: {{ $task->progress }}%"></div>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$task->status] ?? 'bg-gray-100' }}">
                            {{ $statusLabels[$task->status] ?? $task->status }}
                        </span>
                        <div class="flex items-center space-x-2">
                            <button onclick="editTask({{ $task->id }})" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Modifier</button>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette tâche ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
                @if($task->description)
                <p class="mt-2 text-sm text-gray-500">{{ $task->description }}</p>
                @endif
                @if($task->status !== 'completed')
                <div class="mt-3">
                    <input type="range" min="0" max="100" value="{{ $task->progress }}"
                        onchange="updateTaskProgress({{ $task->id }}, this.value)"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-purple-600">
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div id="addTaskModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Nouvelle tâche</h3>
                <button onclick="closeModal('addTaskModal')" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Étape</label>
                        <select name="stage" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            @foreach($stageLabels as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="status" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            @foreach($statusLabels as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                        <input type="date" name="start_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date fin prévue</label>
                        <input type="date" name="expected_end_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Avancement (%)</label>
                    <input type="number" min="0" max="100" name="progress" value="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeModal('addTaskModal')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); }

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
                    Swal.fire({
                        title: 'Modifier la tâche',
                        html: `<form id="editTaskForm" action="/tasks/${id}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="text-left space-y-3">
                                <div><label class="block text-sm font-medium">Nom</label><input type="text" name="name" value="${d.name}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Avancement (%)</label><input type="number" min="0" max="100" name="progress" value="${d.progress}" class="w-full border rounded-lg px-3 py-2 text-sm"></div>
                                <div><label class="block text-sm font-medium">Statut</label>
                                    <select name="status" class="w-full border rounded-lg px-3 py-2 text-sm">
                                        <option value="not_started" ${d.status === 'not_started' ? 'selected' : ''}>Non commencé</option>
                                        <option value="in_progress" ${d.status === 'in_progress' ? 'selected' : ''}>En cours</option>
                                        <option value="completed" ${d.status === 'completed' ? 'selected' : ''}>Terminé</option>
                                    </select></div>
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
