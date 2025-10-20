<x-guest-layout>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img src="{{ asset('assets/frontend/image/logo.png') }}" alt="Lupa Password MULAICPNS" class="mx-auto h-12 w-auto">
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
                        <x-text-input id="email" name="email" type="email" autocomplete="email" required="required" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm" :value="old('email')" />
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-sm"> Belum punya akun? <br>
                        <a href="{{ route('register') }}" class="font-medium text-amber-500 hover:text-amber-700"> Daftar Sekarang! </a>
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 items-center bg-amber-500 hover:bg-amber-700 focus:ring-amber-500">
                        <span class="text-base"> Kirim link reset password </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
