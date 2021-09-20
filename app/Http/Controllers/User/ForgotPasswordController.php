<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends ApiController
{
    public function forgot() {
        $credentials = request()->validate(['email' => 'required|email']);
        Password::sendResetLink($credentials);
        return $this->showMessage('Se envió el link para resetear la contraseña');
    }

     public function reset() {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:6'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return $this->errorResponse('Token proporcionado no válido', 400);
        }
        return $this->showMessage('La contraseña ha sido cambiada correctamente');
    }
}
