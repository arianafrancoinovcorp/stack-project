<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Step 2 of 4</span>
                    <span class="text-sm text-gray-500">Branding</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: 50%"></div>
                </div>
            </div>

            <!-- Branding Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 sm:p-12">
                    <!-- Icon -->
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        Customize Your Brand
                    </h1>
                    <p class="text-gray-600 mb-8">
                        Make your workspace uniquely yours with your logo and colors
                    </p>

                    <!-- Form -->
                    <form method="POST" action="{{ route('onboarding.branding') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Logo Upload -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Logo
                            </label>
                            
                            <div class="flex items-center space-x-6">
                                <!-- Preview -->
                                <div class="flex-shrink-0">
                                    <div id="logo-preview" class="w-24 h-24 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50">
                                        @if($tenant->logo)
                                            <img src="{{ Storage::url($tenant->logo) }}" alt="Logo" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                <!-- Upload Button -->
                                <div class="flex-1">
                                    <input type="file" name="logo" id="logo" accept="image/*" class="hidden" onchange="previewLogo(event)">
                                    <label for="logo" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        Upload Logo
                                    </label>
                                    <p class="mt-2 text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                </div>
                            </div>
                            @error('logo')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Primary Color -->
                        <div class="mb-6">
                            <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-2">
                                Primary Color
                            </label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       name="primary_color" 
                                       id="primary_color"
                                       value="{{ old('primary_color', $tenant->primary_color) }}"
                                       class="h-12 w-20 rounded border border-gray-300 cursor-pointer">
                                <input type="text" 
                                       id="primary_color_text"
                                       value="{{ old('primary_color', $tenant->primary_color) }}"
                                       readonly
                                       class="flex-1 border-gray-300 rounded-md shadow-sm bg-gray-50 text-sm">
                            </div>
                            @error('primary_color')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Secondary Color -->
                        <div class="mb-8">
                            <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-2">
                                Secondary Color
                            </label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       name="secondary_color" 
                                       id="secondary_color"
                                       value="{{ old('secondary_color', $tenant->secondary_color) }}"
                                       class="h-12 w-20 rounded border border-gray-300 cursor-pointer">
                                <input type="text" 
                                       id="secondary_color_text"
                                       value="{{ old('secondary_color', $tenant->secondary_color) }}"
                                       readonly
                                       class="flex-1 border-gray-300 rounded-md shadow-sm bg-gray-50 text-sm">
                            </div>
                            @error('secondary_color')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview -->
                        <div class="mb-8 p-6 rounded-lg border-2 border-gray-200 bg-gray-50">
                            <p class="text-sm font-medium text-gray-700 mb-4">Preview</p>
                            <div class="flex items-center space-x-3">
                                <button type="button" id="preview-primary" class="px-6 py-2 rounded-md text-white font-medium transition" style="background-color: {{ $tenant->primary_color }}">
                                    Primary Button
                                </button>
                                <button type="button" id="preview-secondary" class="px-6 py-2 rounded-md text-white font-medium transition" style="background-color: {{ $tenant->secondary_color }}">
                                    Secondary Button
                                </button>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                Continue
                            </button>

                            <a href="{{ route('onboarding.skip') }}" 
                               onclick="event.preventDefault(); document.getElementById('skip-form').submit();"
                               class="px-6 py-3 text-gray-600 font-medium text-center hover:text-gray-800 transition">
                                Skip
                            </a>
                        </div>
                    </form>

                    <form id="skip-form" method="POST" action="{{ route('onboarding.skip') }}" class="hidden">
                        @csrf
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        // Logo preview
        function previewLogo(event) {
            const preview = document.getElementById('logo-preview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Logo preview" class="w-full h-full object-cover rounded-lg">`;
                }
                reader.readAsDataURL(file);
            }
        }

        // Color sync
        document.getElementById('primary_color').addEventListener('input', function(e) {
            document.getElementById('primary_color_text').value = e.target.value;
            document.getElementById('preview-primary').style.backgroundColor = e.target.value;
        });

        document.getElementById('secondary_color').addEventListener('input', function(e) {
            document.getElementById('secondary_color_text').value = e.target.value;
            document.getElementById('preview-secondary').style.backgroundColor = e.target.value;
        });
    </script>
</x-app-layout>