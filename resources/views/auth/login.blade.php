<x-guest-layout>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-12 w-auto" src="https://ayopppk.com/assets/logo/ayopppk.svg"
            alt="Login AYOPPPK">
        <h2 class="mt-6 text-center text-2xl font-extrabold text-gray-900">
            Login ke Akun Anda
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

            {{-- START NOTIF MESSAGE --}}
             @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        Whoops! Terjadi kesalahan.
                    </div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach
                        @foreach ($errors->get('password') as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('status'))
                <div class="font-medium text-sm text-green-600 mb-4">
                    {{ session('status') }}
                </div>
            @endif
            {{-- END NOTIF MESSAGE --}}

            <form class="space-y-5" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <x-input-label for="email" class="block text-sm font-medium text-gray-700" :value="__('Email')" />
                    <div class="mt-1">
                        <x-text-input id="email" name="email" type="email" autocomplete="email" required :value="old('email')" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" autofocus autocomplete="username" />
                    </div>
                </div>

                <div>
                    <x-input-label for="password" class="block text-sm font-medium text-gray-700" :value="__('Password')" />
                    <div class="mt-1">
                        <x-text-input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" checked
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            Ingat Saya?
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        Belum punya akun? <br>
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Daftar dulu, yuk!
                        </a>
                    </div>

                    <div class="text-sm text-right">
                        Lupa password? <br>
                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Atur ulang password!
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>