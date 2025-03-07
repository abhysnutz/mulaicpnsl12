<x-guest-layout>
    {{-- <form method="POST" action="{{ route('register') }}">
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
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form> --}}

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-12 w-auto" src="https://ayopppk.com/assets/logo/ayopppk.svg"
            alt="Daftar AYOPPPK">
        <h2 class="mt-6 text-center text-2xl font-extrabold text-gray-900">
            Daftar Akun
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto w-full md:w-1/2">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

            {{-- START ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        Whoops! Terjadi kesalahan.
                    </div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->get('name') as $error) <li>{{ $error }}</li> @endforeach
                        @foreach ($errors->get('telepon') as $error) <li>{{ $error }}</li> @endforeach
                        @foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach
                        @foreach ($errors->get('password') as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
            {{-- END ERROR MESSAGE --}}

            <form class="space-y-5 " method="POST" action="{{ route('register') }}">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <x-input-label class="block text-sm font-medium text-gray-700" for="name" :value="__('Nama')" />
                        <div class="mt-1">
                            <x-text-input  id="name" name="name" type="text" autocomplete="nama" required :value="old('name')" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                    <div>
                        <x-input-label class="block text-sm font-medium text-gray-700" for="telepon" :value="__('Nomor Telepon / Whatsapp')" />
                        <div class="mt-1">
                            <x-text-input  id="telepon" name="telepon" type="text" autocomplete="telepon" required :value="old('telepon')" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />

                        </div>
                    </div>
                    <div>
                        <x-input-label for="email" class="block text-sm font-medium text-gray-700"  :value="__('Email')" />
                        <div class="mt-1">
                            <x-text-input id="email" name="email" type="email" autocomplete="email" required :value="old('email')" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="email_confirmation" class="block text-sm font-medium text-gray-700"  :value="__('Konfirmasi Email')" />
                        <div class="mt-1">
                            <x-text-input id="email_confirmation" name="email_confirmation" type="email" autocomplete="email_confirmation" required :value="old('email_confirmation')" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <x-input-label for="password" class="block text-sm font-medium text-gray-700" :value="__('Password Email')" />
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="password_confirmation" class="block text-sm font-medium text-gray-700"  :value="__('Konfirmasi Password')" />
                        <div class="mt-1">
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" autocomplete="password_confirmation" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        Sudah punya akun? <br>
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Masuk Sekarang!
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 items-center bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                        <span class="text-base">
                            Daftar
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
