<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataDonasiController;
use App\Http\Controllers\DataPenerimaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataPenyaluranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('landing.home'))->name('home');

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {

        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return app(DashboardController::class)->index();
        }

        if (!$user->isVerified()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->route('donatur.dashboard');

    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    // DATA DONASI
    Route::resource('data_donasi', DataDonasiController::class);

    Route::put('/data_donasi/{id}/proses',
        [DataDonasiController::class, 'proses'])
        ->name('data_donasi.proses');

    Route::put('/data_donasi/{id}/tolak',
        [DataDonasiController::class, 'tolak'])
        ->name('data_donasi.tolak');

    // DATA PENGGUNA
    Route::get('/data_pengguna',
        [UserController::class, 'index'])
        ->name('data_pengguna.index');

    Route::get('/data_pengguna/{id}/edit',
        [UserController::class, 'edit'])
        ->name('data_pengguna.edit');

    Route::put('/data_pengguna/{id}',
        [UserController::class, 'update'])
        ->name('data_pengguna.update');

    Route::delete('/data_pengguna/{id}',
        [UserController::class, 'destroy'])
        ->name('data_pengguna.destroy');

    Route::get('/data_pengguna/cetak-pdf',
        [UserController::class, 'cetakPdf'])
        ->name('data_pengguna.cetak_pdf');

    // DATA PENERIMA
    Route::resource('data_penerima', DataPenerimaController::class);

    // DATA PENYALURAN
    Route::resource('data_penyaluran', DataPenyaluranController::class);

    // LAPORAN
    Route::prefix('laporan')->name('laporan.')->group(function () {

        Route::get('/donasi',
            [LaporanController::class, 'donasi'])
            ->name('donasi');

        Route::get('/donasi/pdf',
            [LaporanController::class, 'donasiPdf'])
            ->name('donasi.pdf');

        Route::get('/penyaluran',
            [LaporanController::class, 'penyaluran'])
            ->name('penyaluran');

        Route::get('/penyaluran/pdf',
            [LaporanController::class, 'penyaluranPdf'])
            ->name('penyaluran.pdf');
    });
});

/*
|--------------------------------------------------------------------------
| DONATUR AREA (WAJIB VERIFIED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('donatur')
    ->name('donatur.')
    ->group(function () {

        Route::get('/dashboard', function () {

            /** @var User $user */
            $user = Auth::user();

            if (!$user || !$user->isVerified()) {
                return redirect()->route('verification.notice');
            }

            return app(DonaturController::class)->dashboard();

        })->name('dashboard');

        Route::get('/donasi', [DonaturController::class, 'donasiIndex'])->name('donasi.index');
        Route::get('/riwayat-donasi',[DonaturController::class, 'riwayatDonasi'])->name('riwayat_donasi');
        Route::get('/donasi/create', [DonaturController::class, 'donasiCreate'])->name('donasi.create');
        Route::post('/donasi', [DonaturController::class, 'donasiStore'])->name('donasi.store');

        Route::get('/donasi/{id}', [DonaturController::class, 'donasiShow'])->name('donasi.show');
        Route::get('/donasi/{id}/edit', [DonaturController::class, 'donasiEdit'])->name('donasi.edit');
        Route::put('/donasi/{id}', [DonaturController::class, 'donasiUpdate'])->name('donasi.update');
        Route::delete('/donasi/{id}', [DonaturController::class, 'donasiDestroy'])->name('donasi.destroy');

        Route::get('/penyaluran', [DonaturController::class, 'penyaluran'])->name('penyaluran');

        Route::get('/profil', [UserController::class, 'editProfil'])->name('profil');
        Route::put('/profil', [UserController::class, 'updateProfil'])->name('profil.update');
});

/*
|--------------------------------------------------------------------------
| EMAIL VERIFICATION
|--------------------------------------------------------------------------
*/
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('login')
            ->with('success', 'Email sudah diverifikasi, silakan login.');
    }

    $request->fulfill();

    return redirect()->route('login')
        ->with('success', 'Email berhasil diverifikasi, silakan login.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Link verifikasi dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/back-to-login', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');

})->middleware('auth')->name('back.login');
