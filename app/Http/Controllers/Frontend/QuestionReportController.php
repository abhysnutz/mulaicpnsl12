<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionReport;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuestionReportController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'question_id' => 'required|integer',
            'exam_id'     => 'nullable|integer',
            'type'        => 'required|string|max:100',
            'note'        => 'nullable|string|max:1000',
        ]);

        $report = QuestionReport::create([
            'question_id' => $data['question_id'],
            'user_id'     => auth()->id(),
            'exam_id'     => $data['exam_id'] ?? null,
            'type'        => $data['type'],
            'note'        => $data['note'] ?? null,
            'status'      => 'baru',
        ]);

        // Notif Telegram (pakai pola yang udah ada)
        $this->notifyTelegram($report);

        return response()->json(['message' => 'Laporan terkirim. Terima kasih!']);
    }

    private function notifyTelegram(QuestionReport $report): void
    {
        $token  = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id'); // ke chat utama, bukan grup error

        if (! $token || ! $chatId) {
            return;
        }

        $text = "📝 *Laporan Soal Baru*\n\n"
            . "*Soal ID:* {$report->question_id}\n"
            . "*Jenis:* {$report->type}\n"
            . "*Catatan:* " . ($report->note ?: '-') . "\n"
            . "*Pelapor:* " . (auth()->user()->name ?? 'User') . "\n"
            . "*Waktu:* " . $report->created_at->format('d M Y H:i');

        try {
            Http::timeout(5)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal kirim notif laporan soal: ' . $e->getMessage());
        }
    }
}