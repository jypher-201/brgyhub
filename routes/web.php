<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\IssueReportController;
use App\Http\Controllers\SuggestionController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AdminSuggestionController;
use App\Http\Controllers\AdminIssueController;

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
Route::prefix('admin')->middleware([RoleMiddleware::class . ':admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manage Issue Reports
    Route::get('/issues', [AdminIssueController::class, 'index'])->name('issues.index');
    Route::get('/issues/{issueReport}', [AdminIssueController::class, 'show'])->name('issues.show');
    Route::get('/issues/{id}/edit', [AdminIssueController::class, 'edit'])->name('issues.edit');
    Route::put('/issues/{id}', [AdminIssueController::class, 'update'])->name('issues.update');

    // Admin Suggestions
    Route::get('/suggestions', [AdminSuggestionController::class, 'index'])->name('suggestions.index');
    Route::get('/suggestions/{id}/edit', [AdminSuggestionController::class, 'edit'])->name('suggestions.edit');
    Route::get('/suggestions/{id}', [AdminSuggestionController::class, 'show'])->name('suggestions.show');
    Route::put('/suggestions/{id}', [AdminSuggestionController::class, 'update'])->name('suggestions.update');

    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
});


    /// Resident routes
    Route::prefix('resident')->middleware([RoleMiddleware::class . ':resident'])->name('resident.')->group(function () {

    Route::get('/dashboard', [ResidentController::class, 'index'])->name('dashboard');

    // Issue Reports
    Route::get('/issues', [IssueReportController::class, 'index'])->name('issues.index');
    Route::get('/issues/create', [IssueReportController::class, 'create'])->name('issues.create');
    Route::post('/issues', [IssueReportController::class, 'store'])->name('issues.store');
    Route::get('/issues/{id}', [IssueReportController::class, 'show'])->name('issues.show'); 

    // Suggestions
    Route::get('/suggestions', [SuggestionController::class, 'index'])->name('suggestions.index');
    Route::get('/suggestions/create', [SuggestionController::class, 'create'])->name('suggestions.create');
    Route::post('/suggestions', [SuggestionController::class, 'store'])->name('suggestions.store');

    // Notification routes
    Route::get('/notifications', [ResidentController::class, 'notifications'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [ResidentController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [ResidentController::class, 'markAllAsRead'])->name('notifications.readAll');
});

});
