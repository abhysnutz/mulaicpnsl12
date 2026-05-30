<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\QuestionReport;
use Illuminate\Http\Request;

class QuestionReportController extends Controller
{
    public function index()
    {
        $reports = QuestionReport::with(['user', 'question'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('backend.question-report.index', compact('reports'));
    }

    public function update(Request $request)
    {
        $report = QuestionReport::findOrFail($request->id);
        $report->status = $request->status; // 'ditangani'
        $report->save();

        return redirect()->back()->with('success', 'Status laporan diperbarui!');
    }
}