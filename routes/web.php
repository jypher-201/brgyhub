<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResidentController;
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
    return view('errors.unauthorized'); // create this blade file if needed
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

    // Admin routes
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        // Add more admin routes here if needed
    });

    // Resident routes
    Route::middleware([RoleMiddleware::class . ':resident'])->group(function () {
        Route::get('/resident/dashboard', [ResidentController::class, 'index'])
            ->name('resident.dashboard');

        // Add more resident routes here if needed
    });
});
