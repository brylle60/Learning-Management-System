<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('I want to register as')" />
            <div class="mt-2 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <!-- Student Option -->
                <label class="relative flex cursor-pointer rounded-lg border border-gray-300 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                    <input type="radio" name="role" value="student" class="sr-only" {{ old('role', 'student') == 'student' ? 'checked' : '' }} required>
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="block text-sm font-semibold text-gray-900">
                                🎓 Student
                            </span>
                            <span class="mt-1 flex items-center text-sm text-gray-500">
                                Browse and enroll in courses
                            </span>
                        </span>
                    </span>
                    <svg class="h-5 w-5 text-indigo-600 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </label>

                <!-- Instructor Option -->
                <label class="relative flex cursor-pointer rounded-lg border border-gray-300 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                    <input type="radio" name="role" value="instructor" class="sr-only" {{ old('role') == 'instructor' ? 'checked' : '' }} required>
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="block text-sm font-semibold text-gray-900">
                                👨‍🏫 Instructor
                            </span>
                            <span class="mt-1 flex items-center text-sm text-gray-500">
                                Create and teach courses
                            </span>
                        </span>
                    </span>
                    <svg class="h-5 w-5 text-indigo-600 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        // Add visual feedback for selected radio button
        document.querySelectorAll('input[name="role"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove selected styles from all labels
                document.querySelectorAll('label').forEach(label => {
                    label.classList.remove('border-indigo-600', 'ring-2', 'ring-indigo-600');
                    label.querySelector('svg')?.classList.add('hidden');
                });
                
                // Add selected styles to checked label
                if (this.checked) {
                    const label = this.closest('label');
                    label.classList.add('border-indigo-600', 'ring-2', 'ring-indigo-600');
                    label.querySelector('svg')?.classList.remove('hidden');
                }
            });
            
            // Trigger change event on page load for pre-selected option
            if (radio.checked) {
                radio.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-guest-layout>