<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home pages
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('memories.index');
});
Route::get('/timeline', function () {
    return view('pages.timeline');
});
Route::get('/gallery', function () {
    return view('pages.gallery');
});


/*
|--------------------------------------------------------------------------
|Memory Wall Routes 
|--------------------------------------------------------------------------
*/
 
use App\Http\Controllers\MemoryController;

Route::get('/memories', [MemoryController::class, 'index'])->name('memories.index');
Route::prefix('api/memories')->group(function () {
    Route::get('/',  [MemoryController::class, 'getMemories'])->name('api.memories.get');
    Route::post('/', [MemoryController::class, 'store'])->name('api.memories.store');
    Route::put('/{id}', [MemoryController::class, 'update'])->name('api.memories.update');
    Route::delete('/{id}', [MemoryController::class, 'destroy'])->name('api.memories.destroy');
});


/*
|--------------------------------------------------------------------------
| love quiz routes
|--------------------------------------------------------------------------
*/


use App\Http\Controllers\QuizController;
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/quiz/start', [QuizController::class, 'startQuiz'])->name('quiz.start');
Route::post('/quiz/answer', [QuizController::class, 'submitAnswer'])
    ->middleware('quiz.session')
    ->name('quiz.answer');
Route::post('/quiz/complete', [QuizController::class, 'completeQuiz'])
    ->middleware('quiz.session')
    ->name('quiz.complete');
Route::get('/quiz/leaderboard', [QuizController::class, 'getLeaderboard'])->name('quiz.leaderboard');


/*
|--------------------------------------------------------------------------
| love survey routes
|--------------------------------------------------------------------------
*/


use App\Http\Controllers\LoveSurveyController;
Route::get('/love-survey', [LoveSurveyController::class, 'index'])->name('love-survey');
Route::post('/love-survey/submit', [LoveSurveyController::class, 'submitSurvey'])->name('survey.submit');
Route::get('/love-survey/complete', [LoveSurveyController::class, 'complete'])->name('survey.complete');


/*
|--------------------------------------------------------------------------
| Keepsake Routes
|--------------------------------------------------------------------------
*/


use App\Http\Controllers\KeepsakeController;
// Main keepsakes page
Route::get('/keepsakes', [KeepsakeController::class, 'index'])->name('keepsakes.index');
// API routes for AJAX operations
Route::prefix('keepsakes')->name('keepsakes.')->group(function () {
    // Get keepsakes (for dynamic loading)
    Route::get('/api/list', [KeepsakeController::class, 'getKeepsakes'])->name('api.list');
    // CRUD operations
    Route::post('/api/store', [KeepsakeController::class, 'store'])->name('api.store');
    Route::get('/api/{id}', [KeepsakeController::class, 'show'])->name('api.show');
    Route::put('/api/{id}', [KeepsakeController::class, 'update'])->name('api.update');
    Route::delete('/api/{id}', [KeepsakeController::class, 'destroy'])->name('api.destroy');
    // Special actions
    Route::post('/api/{id}/favorite', [KeepsakeController::class, 'toggleFavorite'])->name('api.favorite');
    // Calendar data
    Route::get('/api/calendar/data', [KeepsakeController::class, 'getCalendarData'])->name('api.calendar');
    // Export
    Route::get('/api/export', [KeepsakeController::class, 'export'])->name('api.export');
});


Route::get('/debug', function () {
    return [
        'procfile_exists' => file_exists(base_path('Procfile')),
        'railway_json_exists' => file_exists(base_path('railway.json')),
        'db_connection' => config('database.default'),
        'database_url' => env('DATABASE_URL') ? 'SET' : 'NOT SET',
        'migrations_path_exists' => is_dir(database_path('migrations')),
        'migration_files' => count(glob(database_path('migrations/*.php'))),
    ];
});



Route::get('/test-css', function () {
    $cssPath = public_path('css/main.css');
    return [
        'css_exists' => file_exists($cssPath),
        'css_path' => $cssPath,
        'public_path' => public_path(),
        'asset_url' => asset('css/main.css'),
        'app_url' => config('app.url'),
    ];
});








Route::get('/debug-files', function () {
    return [
        'public_path' => public_path(),
        'css_exists' => file_exists(public_path('css/main.css')),
        'css_path' => public_path('css/main.css'),
        'files_in_public' => is_dir(public_path()) ? scandir(public_path()) : 'not a directory',
        'files_in_css' => is_dir(public_path('css')) ? scandir(public_path('css')) : 'css folder not found',
    ];
});