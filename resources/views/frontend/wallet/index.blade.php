@extends('frontend.layout') 

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- Flash --}}
    @if (session('success'))
        <div class="rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="rounded-md bg-red-50 border border-red-200 p-4 text-sm text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Kartu Saldo + Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-amber-500 text-white rounded-lg shadow p-5">
            <p class="text-sm opacity-90">Saldo Wallet</p>
            <p class="text-2xl font-bold mt-1">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
            <p class="text-sm text-gray-500">Total Diajak</p>
            <p class="text-2xl font-bold mt-1 text-gray-800">{{ $totalReferrals }} <span class="text-base font-normal text-gray-500">orang</span></p>
        </div>
        <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
            <p class="text-sm text-gray-500">Total Komisi</p>
            <p class="text-2xl font-bold mt-1 text-gray-800">Rp {{ number_format($totalCommission, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Kode Referral + Link --}}
    <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
        <h3 class="text-base font-semibold text-gray-800 mb-3">Kode Referral Anda</h3>
        <p class="text-sm text-gray-500 mb-3">Bagikan kode atau link ini. Setiap orang yang daftar lalu berlangganan, Anda dapat komisi 10%.</p>

        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Kode --}}
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Kode</label>
                <div class="flex">
                    <input id="refCode" type="text" readonly value="{{ auth()->user()->referral_code }}"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md bg-gray-50 font-mono text-gray-800 sm:text-sm" />
                    <button type="button" onclick="copyText('refCode', this)"
                        class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded-r-md">Salin</button>
                </div>
            </div>
            {{-- Link --}}
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Link</label>
                <div class="flex">
                    <input id="refLink" type="text" readonly
                        value="{{ url('/register') }}?ref={{ auth()->user()->referral_code }}"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md bg-gray-50 text-gray-800 sm:text-sm" />
                    <button type="button" onclick="copyText('refLink', this)"
                        class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded-r-md">Salin</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Tarik Saldo --}}
    <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
        <h3 class="text-base font-semibold text-gray-800 mb-3">Tarik Saldo</h3>

        @if ($withdrawals->where('status', 'pending')->count())
            <div class="rounded-md bg-amber-50 border border-amber-200 p-3 text-sm text-amber-700 mb-3">
                Anda punya permintaan penarikan yang sedang diproses. Tunggu sampai selesai sebelum mengajukan lagi.
            </div>
        @else
            <form method="POST" action="{{ route('wallet.withdraw') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                        <input type="number" name="amount" min="1" max="{{ $wallet->balance }}" required
                            value="{{ old('amount') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                        <p class="mt-1 text-xs text-gray-500">Maksimal: Rp {{ number_format($wallet->balance, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Bank</label>
                        <input type="text" name="bank_name" required value="{{ old('bank_name') }}"
                            placeholder="Contoh: BCA, BRI, Mandiri"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
                        <input type="text" name="account_number" required value="{{ old('account_number') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Pemilik Rekening</label>
                        <input type="text" name="account_name" required value="{{ old('account_name') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500 sm:text-sm" />
                    </div>
                </div>
                <button type="submit"
                    class="w-full sm:w-auto px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-md disabled:opacity-50"
                    @if($wallet->balance < 1) disabled @endif>
                    Ajukan Penarikan
                </button>
                @if($wallet->balance < 1)
                    <p class="text-xs text-gray-500">Saldo belum cukup untuk ditarik.</p>
                @endif
            </form>
        @endif
    </div>

    {{-- Riwayat Penarikan --}}
    <div class="bg-white rounded-lg shadow border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-800">Riwayat Penarikan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left font-medium">Tanggal</th>
                        <th class="px-5 py-3 text-left font-medium">Jumlah</th>
                        <th class="px-5 py-3 text-left font-medium">Tujuan</th>
                        <th class="px-5 py-3 text-left font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($withdrawals as $w)
                        <tr>
                            <td class="px-5 py-3 text-gray-600">{{ $w->created_at->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3 text-gray-800">Rp {{ number_format($w->amount, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $w->bank_name }} - {{ $w->account_number }}</td>
                            <td class="px-5 py-3">
                                @if ($w->status === 'pending')
                                    <span class="px-2 py-1 text-xs rounded bg-amber-100 text-amber-700">Diproses</span>
                                @elseif ($w->status === 'approved')
                                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">Disetujui</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">Belum ada penarikan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Riwayat Transaksi Saldo --}}
    <div class="bg-white rounded-lg shadow border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-800">Riwayat Saldo</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left font-medium">Tanggal</th>
                        <th class="px-5 py-3 text-left font-medium">Keterangan</th>
                        <th class="px-5 py-3 text-right font-medium">Jumlah</th>
                        <th class="px-5 py-3 text-right font-medium">Saldo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($transactions as $tx)
                        <tr>
                            <td class="px-5 py-3 text-gray-600">{{ $tx->created_at->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $tx->description ?? '-' }}</td>
                            <td class="px-5 py-3 text-right font-medium {{ $tx->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $tx->type === 'credit' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-right text-gray-800">Rp {{ number_format($tx->balance_after, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($transactions->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

</div>

<script>
function copyText(id, btn) {
    const el = document.getElementById(id);
    el.select();
    el.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(el.value).then(() => {
        const original = btn.textContent;
        btn.textContent = 'Tersalin!';
        setTimeout(() => { btn.textContent = original; }, 1500);
    });
}
</script>
@endsection