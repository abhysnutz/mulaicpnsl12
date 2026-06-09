<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ReferralCommission;
use App\Models\User;

class ReferralCommissionController extends Controller
{
    public function index()
    {
        // Daftar semua komisi (riwayat)
        $commissions = ReferralCommission::with(['referrer', 'referee'])
            ->orderBy('id', 'DESC')
            ->get();

        // Rekap per pengajak: total komisi & jumlah orang diajak yang sudah bayar
        $topReferrers = ReferralCommission::with('referrer')
            ->selectRaw('referrer_id, COUNT(*) as total_transaksi, SUM(amount) as total_komisi')
            ->groupBy('referrer_id')
            ->orderByDesc('total_komisi')
            ->get();

        $totalKomisiKeseluruhan = ReferralCommission::sum('amount');

        return view('backend.commission.index', compact(
            'commissions',
            'topReferrers',
            'totalKomisiKeseluruhan'
        ));
    }
}