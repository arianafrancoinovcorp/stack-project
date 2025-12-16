<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Step 3 of 4</span>
                    <span class="text-sm text-gray-500">Team</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: 75%"></div>
                </div>
            </div>

            <!-- Team Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 sm:p-12">
                    <!-- Icon -->
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        Invite Your Team
                    </h1>
                    <p class="text-gray-600 mb-8">
                        Collaborate with your colleagues. Enter email addresses separated by commas.
                    </p>

                    <!-- Current Members -->
                    <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <p class="text-sm font-medium text-blue-900 mb-3">Current Members</p>
                        <div class="space-y-2">
                            @foreach($tenant->users as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-medium">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium rounded
                                    {{ $user->pivot->role === 'owner' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $user->pivot->role === 'admin' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $user->pivot->role === 'member' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($user->pivot->role) }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('onboarding.team') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-8">
                            <label for="emails" class="block text-sm font-medium text-gray-700 mb-2">
                                Invite Team Members
                            </label>
                            <textarea name="emails" 
                                      id="emails"
                                      rows="4"
                                      placeholder="john@example.com, jane@example.com, ..."
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            <p class="mt-2 text-xs text-gray-500">
                                Separate multiple emails with commas. They'll be added if they already have accounts.
                            </p>
                            @error('emails')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div class="mb-8 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r">
                            <div class="flex">
                                <svg class="h-5 w-5 text-yellow-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm text-yellow-700">
                                    Note: Email invitations for new users are coming soon. For now, only existing users can be added.
                                </p>
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
</x-app-layout>