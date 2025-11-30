<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Edit Contact</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Update the contact details</p>
                </div>
                <a href="{{ route('contacts.index') }}"
                   class="inline-flex items-center px-3 py-1.5 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 transition-colors">
                    Back
                </a>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-2 border-red-500 text-red-700 text-xs rounded-r">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <form action="{{ route('contacts.update', $contact) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- Entity -->
                        <div class="sm:col-span-2">
                            <label for="entity_id" class="block text-xs font-medium text-gray-700">Entity</label>
                            <select name="entity_id" id="entity_id"
                                    class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select entity</option>
                                @foreach($entities as $entity)
                                    <option value="{{ $entity->id }}"
                                        {{ old('entity_id', $contact->entity_id) == $entity->id ? 'selected' : '' }}>
                                        {{ $entity->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-xs font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $contact->name) }}"
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email', $contact->email) }}"
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Mobile -->
                        <div>
                            <label for="mobile" class="block text-xs font-medium text-gray-700">Mobile</label>
                            <input type="text" name="mobile" id="mobile"
                                   value="{{ old('mobile', $contact->mobile) }}"
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Position -->
                        <div>
                            <label for="position" class="block text-xs font-medium text-gray-700">Position</label>
                            <input type="text" name="position" id="position"
                                   value="{{ old('position', $contact->position) }}"
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Notes -->
                        <div class="sm:col-span-2">
                            <label for="notes" class="block text-xs font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $contact->notes) }}</textarea>
                        </div>

                        <!-- Status -->
                        <div class="sm:col-span-2">
                            <label for="status" class="block text-xs font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                    class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="active" {{ old('status', $contact->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status', $contact->status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded shadow hover:bg-blue-700 transition-colors">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
