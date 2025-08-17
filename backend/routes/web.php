<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\NovaLoginController;

Route::middleware(['nova'])->group(function () {
    Route::get('/nova/login', [NovaLoginController::class, 'showLoginForm'])->name('nova.login');
    Route::post('/nova/login', [NovaLoginController::class, 'login']);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/set-id-and-redirect', function (Request $request) {
    // Simpan ID ke session
    Session::put('selected_id', $request->query('id'));

    // Redirect ke halaman Nova
    return redirect('/nova/resources/type-profile-categories');
})->name('set-id-and-redirect');