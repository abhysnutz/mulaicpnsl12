<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PaymentController as BackendPaymentController;
use App\Http\Controllers\Backend\QuestionController as BackendQuestionController;
use App\Http\Controllers\Backend\TryoutController as BackendTryoutController;
use App\Http\Controllers\Backend\TryoutQuestionController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\DownloadController;
use App\Http\Controllers\Frontend\ExamController;
use App\Http\Controllers\frontend\PaymentController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\TryoutController;
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

Route::group(['middleware' => ['auth','examDirect','checkSingleSession'], 'as' => 'profile.'], function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('edit');
    Route::get('city', [ProfileController::class, 'city'])->name('city');
    Route::patch('profile', [ProfileController::class, 'update'])->name('update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'tryout', 'middleware' => ['auth','checkSingleSession'], 'as' => 'tryout.'], function () {
    Route::get('/', [TryoutController::class, 'index'])->name('index')->middleware('examDirect');
    Route::get('{id}/prepare', [TryoutController::class, 'prepare'])->name('prepare')->middleware(['examDirect','checkTryoutAccess']);
    Route::post('exam', [TryoutController::class, 'exam'])->name('exam');
    Route::get('{id}/working', [TryoutController::class, 'working'])->name('working');
    Route::get('questions', [TryoutController::class, 'questions'])->name('questions');
    Route::get('question', [TryoutController::class, 'question'])->name('question');
    Route::get('time', [TryoutController::class, 'time'])->name('time');
    Route::post('answer', [TryoutController::class, 'answer'])->name('answer');
    Route::post('finish/{id}', [TryoutController::class, 'finish'])->name('finish');
    Route::post('cancel{id}', [TryoutController::class, 'cancel'])->name('cancel');

    Route::group(['prefix' => 'result', 'as' => 'result.'], function () {
        Route::get('/', [ExamController::class, 'index'])->name('index');
        Route::get('{id}/statistic', [ExamController::class, 'statistic'])->name('statistic');
        Route::get('{id}/explanation', [ExamController::class, 'explanation'])->name('explanation');
        Route::get('questions', [ExamController::class, 'questions'])->name('questions');
        Route::get('answer', [ExamController::class, 'answer'])->name('answer');
    });
});

Route::group(['prefix' => 'download', 'middleware' => ['auth','checkSingleSession'], 'as' => 'download.'], function () {
    Route::get('/', [   DownloadController::class, 'index'])->name('index');
});

Route::group(['prefix' => 'payment', 'middleware' => ['auth','checkSingleSession'], 'as' => 'payment.'], function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::post('store', [PaymentController::class, 'store'])->name('store');
});

Route::get('petunjuk_upgrade', function(){ return view('frontend.petunjuk_upgrade'); })->middleware(['auth','checkSingleSession'])->name('petunjuk_upgrade');

// END FRONTEND

// START BACKEND
Route::group(['prefix' => 'console', 'middleware' => ['auth','admin','checkSingleSession'], 'as' => 'console.'], function() {
    Route::get('/', function(){ return redirect()->route('console.dashboard.index'); });

    Route::group(['prefix' => 'dashboard','as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
    
    Route::group(['prefix' => 'user', 'as' => 'user.'], function (){
        Route::get('/', [UserController::class,'index'])->name('index');
    });

    Route::group(['prefix' => 'payment', 'as' => 'payment.'], function (){
        Route::get('/', [BackendPaymentController::class,'index'])->name('index');
        Route::post('update', [BackendPaymentController::class,'update'])->name('update');
    });

    Route::group(['prefix' => 'tryout', 'as' => 'tryout.'], function (){
        Route::get('/', [BackendTryoutController::class,'index'])->name('index');
        Route::get('create', [BackendTryoutController::class,'create'])->name('create');
        Route::post('store', [BackendTryoutController::class,'store'])->name('store');
        Route::get('{id}/edit', [BackendTryoutController::class, 'edit'])->name('edit');
        Route::put('{id}', [BackendTryoutController::class, 'update'])->name('update');
        Route::delete('{id}', [BackendTryoutController::class, 'destroy'])->name('destroy');

        // QUESTION
        Route::group(['prefix' => '{tryout_id}/question', 'as' => 'question.'], function (){
            Route::get('/', [TryoutQuestionController::class,'index'])->name('index');
            Route::get('create', [TryoutQuestionController::class,'create'])->name('create');
            Route::post('store', [TryoutQuestionController::class,'store'])->name('store');
            Route::get('{id}/edit', [TryoutQuestionController::class, 'edit'])->name('edit');
            Route::put('{id}', [TryoutQuestionController::class, 'update'])->name('update');
            Route::delete('{id}', [TryoutQuestionController::class, 'destroy'])->name('destroy');
            Route::post('reorder', [TryoutQuestionController::class, 'reorder'])->name('reorder');
            Route::post('attach', [TryoutQuestionController::class, 'attach'])->name('attach');
            Route::get('export', [TryoutQuestionController::class, 'export'])->name('export');
            Route::post('import', [TryoutQuestionController::class, 'import'])->name('import');
        });
    });

    Route::group(['prefix' => 'question', 'as' => 'question.'], function (){
        Route::get('/', [BackendQuestionController::class,'index'])->name('index');
        Route::get('create', [BackendQuestionController::class,'create'])->name('create');
        Route::post('store', [BackendQuestionController::class,'store'])->name('store');
        Route::get('{id}/edit', [BackendQuestionController::class, 'edit'])->name('edit');
        Route::put('{id}', [BackendQuestionController::class, 'update'])->name('update');
        Route::delete('{id}', [BackendQuestionController::class, 'destroy'])->name('destroy');
        Route::post('image', [BackendQuestionController::class, 'image'])->name('image');
        Route::post('{id}/clone', [BackendQuestionController::class, 'clone'])->name('clone');
        Route::get('preview/{id}', [BackendQuestionController::class, 'preview'])->name('preview');
        Route::get('export', [BackendQuestionController::class, 'export'])->name('export');
        Route::post('import', [BackendQuestionController::class, 'import'])->name('import');
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