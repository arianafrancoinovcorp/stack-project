<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Edit Entity</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Update the entity details</p>
                </div>
                <a href="{{ route('entities.index', ['type' => $entity->types[0] ?? 'client']) }}"
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
                <form action="{{ route('entities.update', $entity) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- Types (Client / Supplier) -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-gray-700">Type</label>
                            <div class="flex gap-4 mt-1">
                                @foreach($types as $typeOption)
                                <label class="flex items-center gap-1 text-sm">
                                    <input type="checkbox" name="types[]" value="{{ $typeOption->id }}"
                                        {{ (old('types') && in_array($typeOption->id, old('types'))) 
                    || ($entity->types->contains($typeOption->id)) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    {{ ucfirst($typeOption->name) }}
                                </label>
                                @endforeach
                            </div>
                        </div>



                        <!-- NIF -->
                        <div>
                            <label for="nif" class="block text-xs font-medium text-gray-700">NIF</label>
                            <input type="text" name="nif" id="nif" value="{{ old('nif', $entity->nif) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-xs font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $entity->name) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Address -->
                        <div class="sm:col-span-2">
                            <label for="address" class="block text-xs font-medium text-gray-700">Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $entity->address) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Zip Code -->
                        <div>
                            <label for="zip_code" class="block text-xs font-medium text-gray-700">Zip Code</label>
                            <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $entity->zip_code) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-xs font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $entity->city) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Country -->
                        <div>
                            <label for="country_id" class="block text-xs font-medium text-gray-700">Country</label>
                            <select name="country_id" id="country_id"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $entity->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-xs font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $entity->phone) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Mobile -->
                        <div>
                            <label for="mobile" class="block text-xs font-medium text-gray-700">Mobile</label>
                            <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $entity->mobile) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-xs font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $entity->email) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- RGPD Consent -->
                        <div class="sm:col-span-2 flex items-center gap-2 mt-2">
                            <input type="checkbox" name="rgpd_consent" id="rgpd_consent" value="1" {{ old('rgpd_consent', $entity->rgpd_consent) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="rgpd_consent" class="text-xs text-gray-700">RGPD Consent</label>
                        </div>

                        <!-- Notes -->
                        <div class="sm:col-span-2">
                            <label for="notes" class="block text-xs font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $entity->notes) }}</textarea>
                        </div>

                        <!-- Status -->
                        <div class="sm:col-span-2">
                            <label for="status" class="block text-xs font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="active" {{ old('status', $entity->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $entity->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
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