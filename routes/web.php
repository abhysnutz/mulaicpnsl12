<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PaymentController as BackendPaymentController;
use App\Http\Controllers\Backend\QuestionController as BackendQuestionController;
use App\Http\Controllers\Backend\QuestionReportController as BackendQuestionReportController;
use App\Http\Controllers\Backend\TryoutController as BackendTryoutController;
use App\Http\Controllers\Backend\TryoutSourceController;
use App\Http\Controllers\Backend\TryoutQuestionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UserActivityController;
use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ReferralCommissionController;
use App\Http\Controllers\Backend\WithdrawalController;
use App\Http\Controllers\Frontend\DownloadController;
use App\Http\Controllers\Frontend\ExamController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\TryoutController;
use App\Http\Controllers\Frontend\WalletController;
use App\Http\Controllers\QuestionTimeController;
use App\Http\Controllers\Frontend\QuestionReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

Route::get('/info', function () {
    return phpinfo();
});

// START FRONTEND
Route::get('/', function () {
    return view('frontend.home');
});

Route::get('/dashboard', function () {
    return view('frontend.dashboard.index');
})->middleware(['auth','examDirect','checkSingleSession'])->name('dashboard.index');

// PROFILE
Route::controller(ProfileController::class)->middleware(['auth','examDirect','checkSingleSession'])->name('profile.')->group(function () {
    Route::get('profile', 'edit')->name('edit');
    Route::get('city', 'city')->name('city');
    Route::patch('profile', 'update')->name('update');
    Route::delete('profile', 'destroy')->name('destroy');
});

// TRYOUT
Route::group(['prefix' => 'tryout', 'middleware' => ['auth','checkSingleSession'], 'as' => 'tryout.'], function () {
    Route::controller(TryoutController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('examDirect');
        Route::get('{id}/prepare', 'prepare')->name('prepare')->middleware(['examDirect','checkTryoutAccess']);
        Route::post('exam', 'exam')->name('exam');
        Route::get('{id}/working', 'working')->name('working');
        Route::get('questions', 'questions')->name('questions');
        Route::get('question', 'question')->name('question');
        Route::get('time', 'time')->name('time');
        Route::post('answer', 'answer')->name('answer');
        Route::post('finish/{id}', 'finish')->name('finish');
        Route::post('cancel{id}', 'cancel')->name('cancel');
    });

    Route::controller(QuestionTimeController::class)->group(function () {
        Route::post('question/start', 'start')->name('question.start');
        Route::post('question/end', 'end')->name('question.end');
    });

    Route::post('question/report', [QuestionReportController::class, 'store'])->name('question.report');

    Route::controller(ExamController::class)->prefix('result')->name('result.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{id}/statistic', 'statistic')->name('statistic');
        Route::get('{id}/explanation', 'explanation')->name('explanation');
        Route::get('questions', 'questions')->name('questions');
        Route::get('answer', 'answer')->name('answer');
    });
});


// DOWNLOAD
Route::controller(DownloadController::class)->prefix('download')->middleware(['auth','checkSingleSession'])->name('download.')->group(function () {
    Route::get('/', 'index')->name('index');
});

// PAYMENT
Route::controller(PaymentController::class)->prefix('payment')->middleware(['auth','checkSingleSession'])->name('payment.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
    });

Route::get('petunjuk_upgrade', function(){ return view('frontend.petunjuk_upgrade'); })->middleware(['auth','checkSingleSession'])->name('petunjuk_upgrade');

// WALLET
Route::controller(WalletController::class)->prefix('wallet')->middleware(['auth','examDirect','checkSingleSession'])->name('wallet.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('withdraw', 'withdraw')->name('withdraw');
});
// END FRONTEND

// START BACKEND
Route::group(['prefix' => 'console', 'middleware' => ['auth','admin','checkSingleSession'], 'as' => 'console.'], function() {
    Route::get('/', function(){ return redirect()->route('console.dashboard.index'); });

    // DASHBOARD
    Route::controller(DashboardController::class)->prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // USER
    Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('{user}/suspend', 'suspend')->name('suspend');
        Route::post('{user}/unsuspend', 'unsuspend')->name('unsuspend');
    });

    // PAYMENT
    Route::controller(BackendPaymentController::class)->prefix('payment')->name('payment.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update', 'update')->name('update');
    });

    // TRYOUT
    Route::controller(BackendTryoutController::class)->prefix('tryout')->name('tryout.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}', 'destroy')->name('destroy');
    });


    Route::controller(TryoutSourceController::class)->prefix('tryout-source')->name('tryout-source.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // TRYOUT > QUESTION
    Route::controller(TryoutQuestionController::class)->prefix('tryout/{tryout_id}/question')->name('tryout.question.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('{id}/edit', 'edit')->name('edit');
            Route::put('{id}', 'update')->name('update');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::post('reorder', 'reorder')->name('reorder');
            Route::post('attach', 'attach')->name('attach');
            Route::get('export', 'export')->name('export');
            Route::post('import', 'import')->name('import');
            Route::post('import/analyze', 'analyzeImport')->name('import.analyze');
            Route::post('import/commit', 'commitImport')->name('import.commit');


        });

    // QUESTION BANK
    Route::controller(BackendQuestionController::class)->prefix('question')->name('question.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}', 'destroy')->name('destroy');
        Route::post('image', 'image')->name('image');
        Route::post('{id}/clone', 'clone')->name('clone');
        Route::get('preview/{id}', 'preview')->name('preview');
        Route::get('export', 'export')->name('export');
        Route::post('import', 'import')->name('import');
        Route::post('import/analyze', 'analyzeImport')->name('import.analyze');
        Route::post('import/commit', 'commitImport')->name('import.commit');
    });

    // DATABASE BACKUP
    Route::controller(BackupController::class)->prefix('backup')->name('backup.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('export', 'export')->name('export');
        Route::post('upload', 'upload')->name('upload');
        Route::post('import/{filename}', 'import')->name('import');
        Route::get('download/{filename}', 'download')->name('download');
        Route::delete('{filename}', 'destroy')->name('destroy');
        Route::post('migrate-fresh', 'migrateFresh')->name('migrate-fresh');
    });

    // QUESTION REPORT
    Route::controller(BackendQuestionReportController::class)->prefix('question-report')->name('question-report.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update', 'update')->name('update');
    });

    // USER ACTIVITY
    Route::controller(UserActivityController::class)->prefix('user-activity')->name('user-activity.')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // WITHDRAWAL
    Route::controller(WithdrawalController::class)->prefix('withdrawal')->name('withdrawal.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update', 'update')->name('update');
    });

    // KOMISI REFERRAL
    Route::controller(ReferralCommissionController::class)->prefix('commission')->name('commission.')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    // SETTINGS
    Route::controller(SettingController::class)->prefix('setting')->name('setting.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
        Route::delete('destroy', 'destroy')->name('destroy');
    });
});

Route::post('/upload-image', function (Request $request) {
    $request->validate([
        'file' => 'required|image|max:2048', // Maksimal 2MB
    ]);

    $path = $request->file('file')->store('uploads');
    $url = Storage::url($path);

    return response()->json(['imageUrl' => $url]);
});

require __DIR__.'/auth.php';