@extends('frontend.layout') 
@push('css-top')
    <style>
        /* Hide arrows for number input in Chrome, Safari, Edge, and Opera */
        .no-arrows::-webkit-outer-spin-button,
        .no-arrows::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Hide arrows for number input in Firefox */
        .no-arrows {
        -moz-appearance: textfield;
        }

    </style>
@endpush
@section('content') 
    <div class="pt-4 pb-20 sm:pt-6 sm:pb-6">
        <div class="mx-auto px-4 sm:px-6 md:px-5">
            <div class="bg-white px-5 pt-5 pb-8 rounded-lg">

                @if ($payment_pending)
                    <div class="error-notification bg-green-500 dark:bg-green-500 dark:opacity-90 rounded-xl p-3 sm:p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="h-5 w-5 text-white dark:text-green-500">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-2 sm:ml-3">
                                <p class="text-xs sm:text-sm font-semibold text-white">Whoops!</p>
                                <p class="text-xs sm:text-sm text-white">Silahkan Transfer sebesar Rp. <span class="font-bold">{{ number_format($payment_pending?->total, 0, ',', '.') }}</span>, sesuai riwayat transaksi dibawah .</p>
                            </div>
                            <div class="ml-auto pl-2 sm:pl-3">
                                <button onclick="$('.error-notification').hide()" class="inline-flex text-white dark:text-green-600 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-4 sm:h-5 w-4 sm:w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                


                <div class="container mx-auto p-4 md:p-6 lg:grid lg:grid-cols-2 lg:gap-8">
                    <div class="bg-indigo-50 rounded-lg p-4 mb-6 lg:mb-0">
                        <h2 class="text-lg font-semibold text-blue-700 mb-4">PETUNJUK TRANSFER</h2>
                        <ol class="space-y-2">
                            <li class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm">1</span>
                                <span class="text-gray-700">Isi Form Transfer dibawah dengan lengkap dan benar</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm">2</span>
                                <span class="text-gray-700">Klik tombol "Simpan" untuk mendapatkan kode unik</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm">4</span>
                                <span class="text-gray-700">Silahkan transfer sesuai nominal yang disertai kode unik Riwayat Transaksi terakhir dibawah ini.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm">5</span>
                                <span class="text-gray-700">Fungsi kode unik (3 angka terakhir) adalah untuk membedakan nominal transfer dengan peserta yang lain.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm">6</span>
                                <span class="text-gray-700">Konfirmasi kirim Whatsapp ke mimin dengan melampirkan bukti transfer ya.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm">7</span>
                                <span class="text-gray-700">Jika Whatsapp belum terbaca atau belum dibalas mimin, silahkan Miscall atau telepon via WA.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm">8</span>
                                <span class="text-gray-700">Jika masih belum direspon juga maka harap bersabar mungkin mimin lagi istirahat / lagi gak pegang HP, tapi gak usah khawatir akan tetap diproses.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm">9</span>
                                <span class="text-gray-700">Terima kasih</span>
                            </li>
                        </ol>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <form class="space-y-4" method="POST" action="{{ route('payment.store') }}">
                            @csrf
                            <!-- Nama Lengkap -->
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" disabled value="{{ Auth::user()?->name }}">
                            </div>
                            <!-- Email -->
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" disabled value="{{ Auth::user()?->email }}">
                            </div>
                            <!-- WhatsApp -->
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">No. WhatsApp</label>
                                <input name="whatsapp" type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 no-arrows" placeholder="628123456789" required>
                            </div>
                            <!-- Metode Pembayaran -->
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                                <select name="payment_method_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @if ($methods->count())
                                        @foreach ($methods as $method)
                                            <option value="{{ $method->id }}">{{ $method?->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <!-- Button Group -->
                            <div class="flex flex-wrap gap-3 pt-4">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-bold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"> Simpan </button>
                                <a href="https://api.whatsapp.com/send?phone=6282187299335&text=Konfirmasi%20Member%20Premium%2C%20%0A{{ env('APP_URL') }}%0A%0ANama%20%3A%20{{ Auth::user()?->name }}%0A%0ABesar%20Transfer%20%3A%20Rp.%20{{ number_format($payment_pending?->total, 0, ',', '.') }}%20%0A%0ATransfer%20Ke%20%3A%20{{ $payment_pending?->method?->name }}%20%0A%0AMohon%20Aktivasi" target="_blank" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"> WA Konfirmasi Donasi </a>
                                {{-- <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"> Petunjuk </button> --}}
                            </div>
                        </form>
                    </div>
                </div>

                
                <div class="flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h2 class="text-xl font-semibold text-indigo-700">Riwayat Transaksi</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-indigo-500 text-white">
                                <th class="px-6 py-3 text-left text-sm font-medium">No</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Tanggal</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Rekening/No Tujuan</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Jumlah Transfer</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($payments as $key => $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($payment?->created_at)->format('d-M-Y H:i') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <div> <span class="text-bold">{{ $payment?->method?->name }}</span></div>
                                        <div>No. Rekening: <span class="text-bold">{{ $payment?->method?->account_number }}</span></div>
                                        <div>Nama: <span class="text-bold">{{ $payment?->method?->account_name }}</span></div>
                                    </td>
                                    <td class="px-6 py-4 text-bold">{{ $payment?->total ?? 0}}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-2 text-sm @if($payment?->status == 'pending') bg-amber-500 @elseif($payment?->status == 'confirmed') bg-green-500 @else bg-red-500 @endif text-bold text-white rounded capitalize">{{ $payment?->status }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button onclick="showDetail('{{ $payment?->method?->name }}','{{ $payment?->method?->account_number }}','{{ $payment?->method?->account_name }}','{{ $payment?->unique_code }}','{{ $payment?->total }}','{{ \Carbon\Carbon::parse($payment?->created_at)->format('d-M-Y H:i') }}','{{ $payment?->status }}')" class="openModal px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">No Data</td>
                                </tr>
                            @endforelse
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-opacity-70 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Detail Invoice</h2>
          </div>
      
          <div class="space-y-4">
            <!-- Row Item -->
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Nama Bank</span>
              <span class="font-medium" id="detail-bank-name"></span>
            </div>
      
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Nomor Rekening</span>
              <span class="font-medium" id="detail-account-number"></span>
            </div>
      
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Nama Pemilik</span>
              <span class="font-medium" id="detail-account-name"></span>
            </div>
      
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Nominal Unik</span>
              <span class="font-medium" id="detail-unique-code"></span>
            </div>
      
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Jumlah Transfer</span>
              <span class="font-medium" id="detail-total"></span>
            </div>
      
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Tanggal Request</span>
              <span class="font-medium" id="detail-date"></span>
            </div>
      
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Status</span>
              <span class="font-medium" id="detail-status"></span>
            </div>
          </div>
      
          <div class="mt-6 text-center">
            <button id="closeModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
              Tutup
            </button>
          </div>
        </div>
      </div>
@endsection

@push('js-bottom')
<script>
   
    // Open modal
    $('.openModal').on('click',function(){
        $('#modal').removeClass('hidden')
    })

    $('#closeModal').on('click',function(){
        $('#modal').addClass('hidden')
    })

    function showDetail(bank,number,name,code,total,date,status){
        $('#detail-bank-name').text(bank)
        $('#detail-account-number').text(number)
        $('#detail-account-name').text(name)
        $('#detail-unique-code').text(code)
        $('#detail-total').text(total)
        $('#detail-date').text(date)
        $('#detail-status').text(status)
    }

    $('#modal').on('click',function(e){
        if (event.target === modal) {
            $('#modal').addClass('hidden') // Close modal if clicked outside
        }
    })
  </script>
  
@endpush