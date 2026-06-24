<nav class="bg-white border-b border-gray-200 shadow-sm" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 shrink-0">
                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="font-bold text-lg text-gray-900">StudioManager</span>
                </a>

                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

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
                    <button @click.stop="open = !open" class="flex items-center space-x-2 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <div class="w-7 h-7 bg-purple-600 rounded-full flex items-center justify-center text-white text-xs font-medium">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-1 z-50" x-cloak>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="mobileOpen" @click.away="mobileOpen = false" x-cloak class="md:hidden border-t border-gray-100 pb-4 pt-2 space-y-1">
            <a href="{{ route('dashboard') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('materials.index') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('materials.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Matériaux</span>
            </a>
            <a href="{{ route('expenses.index') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('expenses.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Dépenses</span>
            </a>
            <a href="{{ route('workers.index') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('workers.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Ouvriers</span>
            </a>
            <a href="{{ route('tasks.index') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('tasks.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span>Tâches</span>
            </a>
            <a href="{{ route('photos.index') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('photos.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Photos</span>
            </a>
            <a href="{{ route('budgets.index') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('budgets.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Budget</span>
            </a>
            <a href="{{ route('reports.index') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('reports.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Rapports</span>
            </a>
            <div class="border-t border-gray-100 my-2 pt-2">
                <a href="{{ route('notifications.index') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span>Notifications</span>
                </a>
                <a href="{{ route('profile.edit') }}" @click="mobileOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition-colors">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Déconnexion</span>
                    </button>
                </form>
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
