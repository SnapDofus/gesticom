<x-app-layout title="Galerie">
    <x-slot name="header">Galerie du chantier</x-slot>

    @php
        $stageLabels = [
            'foundation' => 'Fondation', 'rebar' => 'Ferraillage', 'formwork' => 'Coffrage',
            'slab' => 'Dallage', 'wall_elevation' => 'Élévation des murs', 'framing' => 'Charpente',
            'roofing' => 'Toiture', 'electrical' => 'Électricité', 'plumbing' => 'Plomberie',
            'tiling' => 'Carrelage', 'painting' => 'Peinture', 'finishing' => 'Finitions',
        ];
    @endphp

    <div class="space-y-4">
        <div class="flex justify-end">
            <button onclick="openModal('addPhotoModal')" class="mobile-btn-primary">
                + Ajouter des photos
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($photos as $photo)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
                <div class="aspect-square bg-gray-100 relative overflow-hidden">
                    <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->original_name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer cette photo ?')" class="bg-red-500 text-white p-1.5 rounded-lg hover:bg-red-600 text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
                <div class="p-3">
                    @if($photo->task)
                        <span class="text-xs font-medium text-purple-600">{{ $stageLabels[$photo->task->stage] ?? $photo->task->name }}</span>
                    @endif
                    @if($photo->comment)
                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($photo->comment, 60) }}</p>
                    @endif
                    <p class="text-xs text-gray-400 mt-1">{{ $photo->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p>Aucune photo pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>

    <div id="addPhotoModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Ajouter des photos</h3>
                <button onclick="closeModal('addPhotoModal')" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Photos (sélection multiple)</label>
                    <input type="file" name="photos[]" multiple accept="image/*" required
                        class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-3 file:border file:border-gray-300 file:rounded-lg file:text-sm file:bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Étape associée</label>
                    <select name="task_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Sélectionner une étape</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}">{{ $stageLabels[$task->stage] ?? $task->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Commentaire</label>
                    <textarea name="comment" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Ex: Avancement de l'étape..."></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeModal('addPhotoModal')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">Uploader</button>
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
