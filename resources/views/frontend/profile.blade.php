@extends('frontend.layout')
@section('content')
    <div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
        <div class="mx-auto px-4 sm:px-6 md:px-5">
            <div class="bg-white px-5 pt-5 pb-8 rounded-lg">
                @include('frontend.breadcrumb', ['content' => 'Profil'])
                <div>
                    @if (session('status') === 'account-updated' || session('status') === 'profile-updated' || session('status') === 'password-updated')
                        <div class="rounded-md bg-green-50 p-4 my-5">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-5 w-5 text-green-400">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-bold text-green-800">
                                        Berhasil!
                                    </p>
                                    <p class="text-sm font-medium text-green-800">
                                        @if (session('status') === 'account-updated')
                                            Informasi akun berhasil disimpan
                                        @elseif (session('status') === 'profile-updated')
                                            Informasi profil berhasil disimpan
                                        @elseif(session('status') === 'password-updated')
                                            Password baru berhasil disimpan.
                                        @endif
                                    </p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none">
                                            <span class="sr-only">Dismiss</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-5 w-5">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($errors->updatePassword->any())
                        <div class="rounded-md bg-red-50 p-4 my-5">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-5 w-5 text-red-400">
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-bold text-pink-800">
                                        Terjadi Kesalahan!
                                    </p>
                                    <ul class="text-sm font-medium text-pink-800 list-disc">
                                        @foreach ($errors->updatePassword->get('current_password') as $error) <li class="ml-4"> <a>{{ $error }}</a></li> @endforeach
                                        @foreach ($errors->updatePassword->get('password') as $error) <li class="ml-4"><a>{{ $error }}</a></li> @endforeach
                                        @foreach ($errors->updatePassword->get('password_confirmation') as $error) <li class="ml-4"><a>{{ $error }}</a></li> @endforeach
                                    </ul>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none">
                                            <span class="sr-only">Dismiss</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-5 w-5">
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                ></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">
                                Whoops! Terjadi kesalahan.
                            </div>
                            {{-- <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->get('email') as $error) <li>{{ $error }}</li> @endforeach
                                @foreach ($errors->get('password') as $error) <li>{{ $error }}</li> @endforeach
                            </ul> --}}
                        </div>
                    @endif
                    
                    <div class="xl:grid xl:grid-cols-12 xl:space-y-0 space-y-4 xl:space-x-4">
                        <div class="xl:col-span-3">
                            <aside class="bg-white rounded-md shadow border py-4">
                                <div class="flex-shrink-0 flex border-b border-gary-300 px-4 pb-4">
                                    <div class="flex-shrink-0 w-full group block">
                                        <div class="flex items-center">
                                            <div><img src="https://ui-avatars.com/api/?name={{ $user?->name }}&amp;background=6366f1&amp;color=fff" alt="" class="h-8 sm:h-10 w-8 sm:w-10 rounded-full" /></div>
                                            <div class="ml-3 truncate">
                                                <p class="text-sm font-medium text-gray-800 truncate">{{ $user?->name }}</p>
                                                <p class="text-xs font-medium text-gray-500 group-hover:text-gray-800 truncate">{{ $user?->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <nav aria-label="Tabs" class="space-y-1">
                                    <a href="#" class="bg-blue-50 border-blue-700 text-blue-700 hover:bg-blue-50 hover:text-blue-700 group border-l-4 px-3 py-2 flex items-center text-sm font-medium profile-button" data-profile="akun">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-blue-700 group-hover:text-blue-700 flex-shrink-0 -ml-1 mr-3 h-5 sm:h-6 w-5 sm:w-6 profile-svg" data-profile="akun">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" ></path>
                                        </svg>
                                        <span class="truncate">Akun</span>
                                    </a>
                                    <a href="#" class="border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-800 group border-l-4 px-3 py-2 flex items-center text-sm font-medium profile-button" data-profile="profil">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-5 sm:h-6 w-5 sm:w-6 profile-svg" data-profile="profil">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" ></path>
                                        </svg>
                                        <span class="truncate">Profil</span>
                                    </a>
                                    <a href="#" class="border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-800 group border-l-4 px-3 py-2 flex items-center text-sm font-medium profile-button" data-profile="password">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-5 sm:h-6 w-5 sm:w-6 profile-svg" data-profile="password">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" ></path>
                                        </svg>
                                        <span class="truncate">Ubah Password</span>
                                    </a>
                                </nav>
                            </aside>
                        </div>
                        <div class="xl:col-span-9">
                            <div class="block profile akun">
                                <form method="post" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('patch')

                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="text-sm font-medium">Nama:</label>
                                            <input type="text" name="name" placeholder="Nama" required class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3" value="{{ $user?->name }}"/>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Email:</label>
                                            <input readonly name="email" type="email" placeholder="Alamat email" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 bg-gray-200" value="{{ $user?->email }}"/>
                                        </div>
                                    </div>
                                    <input type="hidden" name="type" value="akun">
                                    <button type="submit" class="mt-5 bg-blackinline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-offset-2 focus:ring-indigo-500" >
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                            <div class="hidden profile profil">
                                <form method="post" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('patch')

                                    <div class="grid md:grid-cols-1 lg:grid-cols-2 gap-4">
                                        <div class="grid grid-cols-1 gap-4">
                                            <div>
                                                <label class="text-sm font-medium">Telepon:</label>
                                                <input name="phone" type="text" placeholder="Telepon" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3" value="{{ $user?->detail?->phone }}"/>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium">Tanggal Lahir Anda: -</label>
                                                <input name ="birth" type="date" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3" value="{{ $user?->detail?->birth }}"/>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium">Pendidikan Terakhir:</label>
                                                <select name="education" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3">
                                                    <option selected="selected" value="" disabled="disabled">-- Pilih Pendidikan --</option>
                                                    <option value="SD" @if($user?->detail?->education == 'SD') selected @endif>SD/MI Sederajat</option>
                                                    <option value="SMP" @if($user?->detail?->education == 'SMP') selected @endif>SMP/MTs Sederajat</option>
                                                    <option value="SMA" @if($user?->detail?->education == 'SMA') selected @endif>SMA/SMK/MA Sederajat</option>
                                                    <option value="D1" @if($user?->detail?->education == 'D1') selected @endif>D1</option>
                                                    <option value="D2" @if($user?->detail?->education == 'D2') selected @endif>D2</option>
                                                    <option value="D3" @if($user?->detail?->education == 'D3') selected @endif>D3</option>
                                                    <option value="D4" @if($user?->detail?->education == 'D4') selected @endif>D4</option>
                                                    <option value="S1" @if($user?->detail?->education == 'S1') selected @endif>S1</option>
                                                    <option value="S2" @if($user?->detail?->education == 'S2') selected @endif>S2</option>
                                                    <option value="S3" @if($user?->detail?->education == 'S3') selected @endif>S3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-4">
                                            <div>
                                                <label class="text-sm font-medium">Jurusan:</label>
                                                <input name="major" type="text" placeholder="Jurusan" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3" value="{{ $user?->detail?->major }}"/>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium">Provinsi:</label>
                                                <select name="province_id" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 get-city">
                                                    <option value="0" selected="selected" disabled="disabled">-- Pilih Provinsi --</option>
                                                    @if ($provinces->count())
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province?->id }}" @if($province?->id == $user?->detail?->province_id) selected @endif>{{ $province?->name }}</option>
                                                        @endforeach    
                                                    @endif
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium">Kota/Kabupaten:</label>
                                                <select id="container-city" name="city_id" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3">
                                                    <option value="0" selected="selected" disabled="disabled">-- Pilih Kota/Kabupaten --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Alamat:</label>
                                            <textarea name="address" cols="30" rows="5" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3"> {{ $user?->detail?->address }}</textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" id="city_id" value="{{ $user?->detail?->city_id }}">
                                    <input type="hidden" name="type" value="profil">

                                    <button type="submit" class="mt-5 bg-blackinline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-offset-2 focus:ring-indigo-500" >
                                        Simpan Profil
                                    </button>
                                </form>
                            </div>
                            <div class="hidden profile password">
                                <form method="post" action="{{ route('password.update') }}" data-gtm-form-interact-id="3">
                                    @csrf
                                    @method('put')

                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <x-input-label for="update_password_current_password" :value="__('Password Sekarang:')" class="text-sm font-medium" />
                                            <x-text-input id="update_password_current_password" name="current_password" type="password" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3" autocomplete="current-password" placeholder="Password Sekarang" data-gtm-form-interact-field-id="3" />
                                        </div>
                                        <div>
                                            <x-input-label for="update_password_password" :value="__('Password Baru:')" class="text-sm font-medium"/>
                                            <x-text-input id="update_password_password" name="password" type="password" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3" autocomplete="new-password" placeholder="Password Baru"/>
                                        </div>
                                        <div>
                                            <x-input-label for="update_password_password_confirmation" :value="__('Ulangi Password Baru:')" class="text-sm font-medium" />
                                            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3" autocomplete="new-password" placeholder="Ulangi Password Baru"/>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-5 bg-blackinline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-offset-2 focus:ring-indigo-500" >
                                        Simpan Password Baru
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-bottom')
    <script>
        $(document).ready(function(){
            

            $(document).on('click', '.profile-button', function(){
                let data = $(this).data('profile');
                
                // left menu
                $('.profile-button').removeClass('bg-blue-50 border-blue-700 text-blue-700 hover:bg-blue-50 hover:text-blue-700').addClass('border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-800')
                $(this).removeClass('border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-800').addClass('bg-blue-50 border-blue-700 text-blue-700 hover:bg-blue-50 hover:text-blue-700')

                $('.profile-svg').removeClass('text-blue-700 group-hover:text-blue-700').addClass('text-gray-400 group-hover:text-gray-500')
                $(`.profile-svg[data-profile="${data}"]`).removeClass('text-gray-400 group-hover:text-gray-500').addClass('text-blue-700 group-hover:text-blue-700')

                $('.profile').removeClass('block').addClass('hidden')
                $(`.profile.${data}`).removeClass('hidden').addClass('block')
            })

            $(document).on('change', '.get-city', function(){
                let province_id = $(this).val()
                getCity(province_id)
            })

            function getCity(province_id){
                $.ajax({
                    url : "{{ route('profile.city') }}",
                    data : {province_id},
                    success : function(reply){
                        if(reply.status == 1){
                            $('#container-city').empty()
                            $.each(reply.data, function(k,v){
                                $('#container-city').append(`
                                    <option value="${v.id}">${v.name}</option>
                                `)
                            })
                        }
                    }
                })    
            }

            let province = $('.get-city').val()
            if(province > 0){
                getCity(province)
                setTimeout(() => {
                    $('#container-city').val($('#city_id').val());
                }, 1000);
            }

           
            
        })
    </script>
@endpush