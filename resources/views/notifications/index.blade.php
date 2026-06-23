<x-app-layout title="Notifications">
    <x-slot name="header">Notifications</x-slot>

    <div class="space-y-4">
        @if($notifications->where('is_read', false)->count() > 0)
        <div class="flex justify-end">
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm text-purple-600 hover:text-purple-800 font-medium">Tout marquer comme lu</button>
            </form>
        </div>
        @endif

        <div class="space-y-2">
            @forelse($notifications as $notification)
            <div class="bg-white rounded-xl shadow-sm border {{ $notification->is_read ? 'border-gray-100' : 'border-purple-200 bg-purple-50/30' }} p-4 flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                        {{ $notification->type === 'budget_over' ? 'bg-red-100' : ($notification->type === 'task_completed' ? 'bg-green-100' : 'bg-blue-100') }}">
                        <svg class="w-4 h-4 {{ $notification->type === 'budget_over' ? 'text-red-600' : ($notification->type === 'task_completed' ? 'text-green-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($notification->type === 'budget_over' || $notification->type === 'budget_warning')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            @elseif($notification->type === 'task_completed')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            @endif
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium {{ $notification->is_read ? 'text-gray-700' : 'text-gray-900' }}">{{ $notification->title }}</p>
                        <p class="text-sm text-gray-500">{{ $notification->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @if(!$notification->is_read)
                <form action="{{ route('notifications.read', $notification) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-purple-600 hover:text-purple-800 font-medium">Marquer lu</button>
                </form>
                @endif
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <p>Aucune notification</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
