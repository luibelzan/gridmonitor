<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;




class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        Session::put('vista_actual', 'registro');
        return view('auth.register');
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nom_distribuidora' => ['nullable', 'string', 'max:50'],
            'cod_id_group' => [ 'nullable','string', 'max:50'],
        ]);




        $indicators = [
            'ind_pf' => $request->has('ind_pf'),
            'ind_ct' => $request->has('ind_ct'),
            'ind_cups' => $request->has('ind_cups'),
            'ind_sabt' => $request->has('ind_sabt'),
            'ind_ws' => $request->has('ind_ws'),
        ];


        $user = User::create(array_merge(
            $request->only(['name', 'email', 'password', 'nom_distribuidora', 'cod_id_group','fec_acceso']),
            $indicators,            // Merging the indicators array
            ['email_verified_at' => now()], // Setting email_verified_at to current time
            ['remember_token' => Str::random(10)], // Setting email_verified_at to current time
            ['fec_acceso'=> now()]
        ));


        // Asignacion de roles
        if ($user->email == 'admin@admin.com') {
            $user->assignRole('admin');
        } else {
            $user->assignRole('user');
        }


        // Auth::login($user);


        event(new Registered($user));


        return redirect(route('admin', absolute: false));
    }
}




