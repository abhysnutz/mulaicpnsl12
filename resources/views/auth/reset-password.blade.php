<x-guest-layout>
    {{-- <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
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
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form> --}}
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-12 w-auto" src="https://ayopppk.com/assets/logo/ayopppk.svg" alt="Reset Password AYOPPPK">
        <h2 class="mt-6 text-center text-2xl font-extrabold text-gray-900">
            Atur ulang password
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

            {{-- START ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        Whoops! Terjadi kesalahan.
                    </div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach
                        @foreach ($errors->get('password') as $error) <li>{{ $error }}</li> @endforeach
                        @foreach ($errors->get('password_confirmation') as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
            {{-- END ERROR MESSAGE --}}
           
            <form class="space-y-5" method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <x-input-label for="email" class="block text-sm font-medium text-gray-700" :value="__('Alamat Email')" />
                    <div class="mt-1">
                        <x-text-input readonly id="email" name="email" type="email" autocomplete="email" required="" :value="old('email', $request->email)" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                    </div>
                </div>
                <div>
                    <x-input-label for="password" class="block text-sm font-medium text-gray-700" :value="__('Password')" />
                    <div class="mt-1">
                        <x-text-input id="password" name="password" type="password" autocomplete="new-password" required="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                    </div>
                </div>
                <div>
                    <x-input-label for="password_confirmation" class="block text-sm font-medium text-gray-700" :value="__('Confirm Password')" />
                    <div class="mt-1">
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Atur ulang kata sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
