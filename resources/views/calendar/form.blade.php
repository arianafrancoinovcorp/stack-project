<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900">
                    {{ isset($activity) ? 'Edit Activity' : 'New Activity' }}
                </h1>
            </div>

            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <form method="POST" action="{{ isset($activity) ? route('calendar.update', $activity) : route('calendar.store') }}">
                    @csrf
                    @if(isset($activity))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Data -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Date *</label>
                            <input type="date" name="date" value="{{ old('date', $activity->date ?? '') }}"
                                   class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('date')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hora -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Time *</label>
                            <input type="time" name="time" value="{{ old('time', $activity->time ?? '') }}"
                                   class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('time')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duração -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Duration (minutes) *</label>
                            <input type="number" name="duration" value="{{ old('duration', $activity->duration ?? 60) }}"
                                   class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required min="1">
                            @error('duration')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Utilizador (Partilha) -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">User *</label>
                            <select name="user_id" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Select user</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $activity->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Conhecimento -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Knowledge</label>
                            <select name="knowledge_id" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select knowledge</option>
                                @foreach($knowledges as $knowledge)
                                    <option value="{{ $knowledge->id }}" {{ old('knowledge_id', $activity->knowledge_id ?? '') == $knowledge->id ? 'selected' : '' }}>
                                        {{ $knowledge->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('knowledge_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Entidade -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Entity</label>
                            <select name="entity_id" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select entity</option>
                                @foreach($entities as $entity)
                                    <option value="{{ $entity->id }}" {{ old('entity_id', $activity->entity_id ?? '') == $entity->id ? 'selected' : '' }}>
                                        {{ $entity->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('entity_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                            <select name="type_id" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_id', $activity->type_id ?? '') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Acção -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Action</label>
                            <select name="action_id" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select action</option>
                                @foreach($actions as $action)
                                    <option value="{{ $action->id }}" {{ old('action_id', $activity->action_id ?? '') == $action->id ? 'selected' : '' }}>
                                        {{ $action->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('action_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Status *</label>
                            <select name="status" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="pending" {{ old('status', $activity->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="done" {{ old('status', $activity->status ?? '') == 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Partilha (checkbox) -->
                        <div class="flex items-center">
                            <input type="checkbox" name="shared" value="1" id="shared"
                                   {{ old('shared', $activity->shared ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="shared" class="ml-2 text-xs text-gray-700">Shared Activity</label>
                        </div>

                        <!-- Descrição -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3"
                                      class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $activity->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('calendar.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-xs hover:bg-gray-300">
                            Cancel
                        </a>
                        
                        <div class="flex gap-2">
                            @if(isset($activity))
                                <button type="button" onclick="if(confirm('Are you sure?')) document.getElementById('delete-form').submit();"
                                        class="px-4 py-2 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                    Delete
                                </button>
                            @endif
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                                {{ isset($activity) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </div>
                </form>

                @if(isset($activity))
                    <form id="delete-form" method="POST" action="{{ route('calendar.destroy', $activity) }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>