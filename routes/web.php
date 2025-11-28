<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\IssueReportController;
use App\Http\Controllers\SuggestionController;
use App\Http\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page (public)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Unauthorized page (optional)
Route::get('/unauthorized', function () {
    return view('errors.unauthorized'); // create this blade if needed
})->name('unauthorized');

// Authenticated routes (Jetstream)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {

    // Main dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'resident') {
            return redirect()->route('resident.dashboard');
        }

        return redirect()->route('unauthorized');
    })->name('dashboard');

    // -------------------------------
    // Admin routes
    // -------------------------------
    Route::prefix('admin')->middleware([RoleMiddleware::class . ':admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Manage Issue Reports
    Route::get('/issues', [\App\Http\Controllers\AdminIssueController::class, 'index'])
        ->name('issues.index');

    Route::post('/issues/{issueReport}/update', [\App\Http\Controllers\AdminIssueController::class, 'update'])
        ->name('issues.update');


        // Manage Suggestions
        Route::get('/suggestions', [SuggestionController::class, 'adminIndex'])->name('suggestions');
        Route::post('/suggestions/{suggestion}/respond', [SuggestionController::class, 'respond'])->name('suggestions.respond');
    });

    // -------------------------------
    // Resident routes
    // -------------------------------
    Route::prefix('resident')->middleware([RoleMiddleware::class . ':resident'])->name('resident.')->group(function () {
        Route::get('/dashboard', [ResidentController::class, 'index'])->name('dashboard');

        // Issue Reports
        Route::get('/issues', [IssueReportController::class, 'index'])->name('issues.index');
        Route::get('/issues/create', [IssueReportController::class, 'create'])->name('issues.create');
        Route::post('/issues', [IssueReportController::class, 'store'])->name('issues.store');

        // Suggestions
        Route::get('/suggestions', [SuggestionController::class, 'index'])->name('suggestions.index');
        Route::get('/suggestions/create', [SuggestionController::class, 'create'])->name('suggestions.create');
        Route::post('/suggestions', [SuggestionController::class, 'store'])->name('suggestions.store');
    });

});
