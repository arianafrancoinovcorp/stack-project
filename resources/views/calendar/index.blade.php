<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-gray-900">Calendar</h1>
                <a href="{{ route('calendar.create') }}"
                   class="px-3 py-2 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                    + New Activity
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-3 px-3 py-2 bg-green-50 border-l-2 border-green-500 text-green-700 text-xs rounded-r">
                {{ session('success') }}
            </div>
            @endif

            <!-- Filters -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-4 mb-4">
                <form method="GET" action="{{ route('calendar.index') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        
                        <!-- Filter by User -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">User</label>
                            <select name="user_id" id="userFilter" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter by Entity -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Entity</label>
                            <select name="entity_id" id="entityFilter" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Entities</option>
                                @foreach($entities as $entity)
                                    <option value="{{ $entity->id }}" {{ request('entity_id') == $entity->id ? 'selected' : '' }}>
                                        {{ $entity->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Actions -->
                        <div class="flex items-end gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                                Filter
                            </button>
                            <a href="{{ route('calendar.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-xs hover:bg-gray-300">
                                Clear
                            </a>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Calendar Card -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-4" style="min-height: 600px;">
                <div id="calendar"></div>
            </div>

        </div>
    </div>

    <!-- FullCalendar v5 CSS/JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            
            // Obter parâmetros de filtro da URL
            const urlParams = new URLSearchParams(window.location.search);
            const userId = urlParams.get('user_id') || '';
            const entityId = urlParams.get('entity_id') || '';

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: function(info, successCallback, failureCallback) {
                    // Carregar eventos via AJAX com filtros
                    fetch('{{ route("calendar.events") }}?user_id=' + userId + '&entity_id=' + entityId)
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                },
                editable: false,
                selectable: true,
                dayMaxEvents: true,
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }
                },
                locale: 'pt'
            });
            
            calendar.render();

            // Recarregar calendário quando os filtros mudarem
            document.getElementById('userFilter').addEventListener('change', function() {
                calendar.refetchEvents();
            });

            document.getElementById('entityFilter').addEventListener('change', function() {
                calendar.refetchEvents();
            });
        });
    </script>
</x-app-layout>