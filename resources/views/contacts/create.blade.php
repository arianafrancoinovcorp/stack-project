<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Create Contact</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Fill in the contact details</p>
                </div>

                <a href="{{ route('contacts.index') }}"
                    class="inline-flex items-center px-3 py-1.5 bg-gray-200 text-gray-800 text-xs font-medium rounded 
                           hover:bg-gray-300 transition-colors">
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
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-xs font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm 
                                       focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-xs font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm 
                                       focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Entity -->
                        <div class="sm:col-span-2">
                            <label for="entity_id" class="block text-xs font-medium text-gray-700">Entity</label>
                            <select name="entity_id" id="entity_id"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm 
                                       focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select entity</option>
                                @foreach($entities as $entity)
                                <option value="{{ $entity->id }}" {{ old('entity_id') == $entity->id ? 'selected' : '' }}>
                                    {{ $entity->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Function -->
                        <div class="sm:col-span-2">
                            <label for="function_id" class="block text-xs font-medium text-gray-700">Function</label>
                            <select name="function_id" id="function_id"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm 
                                       focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select function</option>
                                @foreach($functions as $function)
                                <option value="{{ $function->id }}" {{ old('function_id') == $function->id ? 'selected' : '' }}>
                                    {{ $function->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-xs font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm 
                                       focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Mobile -->
                        <div>
                            <label for="mobile" class="block text-xs font-medium text-gray-700">Mobile</label>
                            <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm 
                                       focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-xs font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm 
                                       focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- GDPR Consent -->
                        <div class="sm:col-span-2 flex items-center gap-2 mt-2">
                            <input type="checkbox" name="rgpd_consent" id="rgpd_consent" value="1"
                                   {{ old('rgpd_consent') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="rgpd_consent" class="text-xs text-gray-700">GDPR Consent</label>
                        </div>

                        <!-- Notes -->
                        <div class="sm:col-span-2">
                            <label for="notes" class="block text-xs font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm 
                                       focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Status -->
                        <div class="sm:col-span-2">
                            <label for="status" class="block text-xs font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm 
                                       focus:ring-blue-500 focus:border-blue-500">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded shadow
                                   hover:bg-blue-700 transition-colors">
                            Save
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
