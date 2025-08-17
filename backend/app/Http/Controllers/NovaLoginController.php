<?php

namespace App\Http\Controllers;

use Laravel\Nova\Http\Controllers\LoginController as NovaBaseLoginController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NovaLoginController extends NovaBaseLoginController
{
    /**
     * Waktu penguncian dalam menit
     */
    public function decayMinutes()
    {
        return 5; // Mengunci selama 5 menit
    }

    /**
     * Gunakan email sebagai username
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Override key throttle untuk berdasarkan IP address saja
     */
    public function throttleKey(Request $request)
    {
        return $request->ip(); // Batasi berdasarkan IP address saja
    }

    /**
     * Proses login dengan pelambatan berbasis IP
     */
    public function login(Request $request)
    {
        // Jika terlalu banyak percobaan login
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );

            $minutes = ceil($seconds / 60);

            throw ValidationException::withMessages([
                $this->username() => __('auth.throttle', ['minutes' => $minutes]),
            ]);
        }

        // Jika login berhasil
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // Tambah attempt walau gagal (misal: salah email)
        $this->incrementLoginAttempts($request);

        // Jika gagal login
        return $this->sendFailedLoginResponse($request);
    }
}
