<x-guest-layout>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-12 w-auto" src="{{ asset('assets/frontend/image/logo.png') }}" alt="Daftar MULAI CPNS">
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

                <div>
                    <x-input-label class="block text-sm font-medium text-gray-700" for="name" :value="__('Nama')" />
                    <div class="mt-1">
                        <x-text-input  id="name" name="name" type="text" autocomplete="nama" required :value="old('name')" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    
                    <div>
                        <x-input-label for="email" class="block text-sm font-medium text-gray-700"  :value="__('Email')" />
                        <div class="mt-1">
                            <x-text-input id="email" name="email" type="email" autocomplete="email" required :value="old('email')" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="email_confirmation" class="block text-sm font-medium text-gray-700"  :value="__('Ulangi Email')" />
                        <div class="mt-1">
                            <x-text-input id="email_confirmation" name="email_confirmation" type="email" autocomplete="email_confirmation" required :value="old('email_confirmation')" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <x-input-label for="password" class="block text-sm font-medium text-gray-700" :value="__('Password')" />
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="password_confirmation" class="block text-sm font-medium text-gray-700"  :value="__('Ulangi Password')" />
                        <div class="mt-1">
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" autocomplete="password_confirmation" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Darimana tahu MULAICPNS ?</label>
                    <select name="referrer" required="required" class="shadow-sm mt-2 focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option selected="selected" value="" disabled="disabled"> -- Silakan Pilih Referrer -- </option>
                        <option value="Google">Google</option>
                        <option value="Mesin pencari lainnya">Mesin pencari lainnya</option>
                        <option value="YouTube">YouTube</option>
                        <option value="Instagram">Instagram</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Teman atau Saudara">Teman, Pacar atau Saudara</option>
                        <option value="Iklan">Iklan</option>
                        <option value="Forum">Forum</option>
                        <option value="Media sosial lainnya">Media sosial lainnya</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        Sudah punya akun? <br>
                        <a href="{{ route('login') }}" class="font-medium text-amber-500 hover:text-amber-700">
                            Masuk Sekarang!
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 items-center bg-amber-500 hover:bg-amber-700 focus:ring-amber-500">
                        <span class="text-base">
                            Daftar
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
