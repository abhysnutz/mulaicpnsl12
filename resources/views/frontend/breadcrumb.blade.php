<div>
    <nav aria-label="Back" class="sm:hidden">
        <a href="{{ url('/') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-400">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
            Kembali
        </a>
    </nav>
    <nav aria-label="Breadcrumb" class="hidden sm:flex mb-6">
        <ol class="flex items-center space-x-4">
            <li>
                <div>
                    <a href="https://ayopppk.com/user" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                        <svg x-description="Heroicon name: solid/home" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="flex-shrink-0 h-5 w-5">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" ></path>
                        </svg>
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="flex-shrink-0 h-5 w-5 text-gray-400">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="https://ayopppk.com/user/akun" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                        {{ $content ?? null }}
                    </a>
                </div>
            </li>
        </ol>
    </nav>
</div>
<div class="mt-5 md:mt-2 md:flex md:items-center md:justify-between bg-white mb-5">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">{{ $content ?? null }}</h2>
    </div>
</div>