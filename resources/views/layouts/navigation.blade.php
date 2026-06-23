<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="font-bold text-lg text-gray-900">StudioManager</span>
                </a>

                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                        Dashboard
                    </a>
                    <a href="{{ route('materials.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('materials.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                        Matériaux
                    </a>
                    <a href="{{ route('expenses.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('expenses.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                        Dépenses
                    </a>
                    <a href="{{ route('workers.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('workers.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                        Ouvriers
                    </a>
                    <a href="{{ route('tasks.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('tasks.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                        Tâches
                    </a>
                    <a href="{{ route('photos.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('photos.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                        Photos
                    </a>
                    <a href="{{ route('budgets.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('budgets.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                        Budget
                    </a>
                    <a href="{{ route('reports.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('reports.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                        Rapports
                    </a>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" id="notification-bell">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center hidden">0</span>
                </a>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <div class="w-7 h-7 bg-purple-600 rounded-full flex items-center justify-center text-white text-xs font-medium">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-1 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    function updateNotificationBadge() {
        fetch('{{ route("notifications.unread-count") }}')
            .then(r => r.json())
            .then(d => {
                const badge = document.getElementById('notification-badge');
                if (d.count > 0) {
                    badge.textContent = d.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            });
    }
    updateNotificationBadge();
    setInterval(updateNotificationBadge, 30000);
</script>
@endpush
