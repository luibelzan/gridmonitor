<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ErrorController extends Controller
{
    public function error419()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

            return view('/login');
        }
    }
