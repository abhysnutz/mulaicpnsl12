<x-guest-layout>
    {{-- 

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form> --}}

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img src="https://ayopppk.com/assets/logo/ayopppk.svg" alt="Lupa Password AYOPPPK" class="mx-auto h-12 w-auto">
        <h2 class="mt-6 text-center text-2xl font-extrabold text-gray-900"> Lupa Password </h2>
    </div>
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <x-input-label for="email" class="block text-sm font-medium text-gray-700" :value="__('Alamat Email')" />
                    <div class="mt-1">
                        <x-text-input id="email" name="email" type="email" autocomplete="email" required="required" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" :value="old('email')" />
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-sm"> Belum punya akun? <br>
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500"> Daftar Sekarang! </a>
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 items-center bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                        <span class="text-base"> Kirim link reset password </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
