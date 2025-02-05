<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{


    // public function admin()
    // {
    //     // Verificar si el usuario está autenticado
    //     if (!Auth::check()) {
    //         // Si no está autenticado, redirigir a la página de inicio de sesión
    //         return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
    //     }
    //     Session::put('vista_actual', 'admin');
    //     return view('admin/admin');
    // }


    public function mostrarusuarios(Request $request) //Listado de usuarios


    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        //si ha hecho una busqueda por filtro, lo mandamos a su método
        if (
            $request->filled('name') || $request->filled('email') || $request->filled('nom_distribuidora')
        ) {
            return $this->buscarUsuarios($request);
        }


        Session::put('vista_actual', 'admin');


        $users = User::orderBy('id')->paginate(10); // Paginar los resultados, 10 usuarios por página
        return view('admin/admin', [
            'users' => $users,
        ]);
    }


    /*FILTRO DE BÚSQUEDA*/
    public function buscarUsuarios(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        $query = User::query();




        // Manda una consulta según el filtro que haya rellenado
        if ($request->filled('name')) {
            $name = strtolower($request->input('name'));
            $query->whereRaw('LOWER(name) LIKE ?', ["%$name%"]);
        }


        if ($request->filled('email')) {
            $email = strtolower($request->input('email'));
            $query->whereRaw('LOWER(email) LIKE ?', ["%$email%"]);
        }
       
        if ($request->filled('nom_distribuidora')) {
            $nom_distribuidora = strtolower($request->input('nom_distribuidora'));
            $query->whereRaw('LOWER(nom_distribuidora) LIKE ?', ["%$nom_distribuidora%"]);
        }


        $users = $query->paginate(10); //paginacion


        return view('admin/admin', [
            'users' => $users,


        ]);
    }
    public function editarusuario($id) //dirigirnos a la vista de editar usuario
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        $usuario = User::find($id);


        return view('admin/editarusuario', ['usuario' => $usuario]);
    }


    public function actualizarUsuario(Request $request, $id) //funcion para actualizar el usuario en la base de datos
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        // Validación de los datos del formulario si es necesario
        $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|email',
            'nom_distribuidora' => 'required|string',
            'tip_user' => 'nullable|string',
            'fec_acceso' => 'nullable|date',
            'cod_id_group' => 'nullable|string',
        ]);


        // Buscar el usuario por su ID
        $usuario = User::find($id);


        // Actualizar los datos del usuario con los valores del formulario
        $usuario->name = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->nom_distribuidora = $request->input('nom_distribuidora');
        $usuario->fec_acceso = $request->input('fec_acceso');
        $usuario->ind_pf = $request->has('ind_pf');
        $usuario->ind_ct = $request->has('ind_ct');
        $usuario->ind_cups = $request->has('ind_cups');
        $usuario->ind_sabt = $request->has('ind_sabt');
        $usuario->ind_ws = $request->has('ind_ws');
        $usuario->cod_id_group = $request->input('cod_id_group');


        // Guardar los cambios en la base de datos
        $usuario->save();


        // Redirigir a alguna vista de confirmación o a donde desees
        return redirect()->route('admin')->with('success', 'Usuario actualizado correctamente');
    }


    public function eliminarusuario($id)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        // dd($id); // Verifica si el ID se recibe correctamente


        // Encuentra al usuario por su ID
        $usuario = User::find($id);
        // dd($usuario);
        // Verifica si el usuario existe
        if ($usuario) {
            // Elimina al usuario
            $usuario->delete();
            return redirect()->route('admin')->with('success', 'El usuario ha sido eliminado correctamente.');
        } else {
            // Si el usuario no existe, muestra un mensaje de error o redirige a una página de error
            return redirect()->back()->with('error', 'El usuario no pudo ser encontrado.');
        }
    }
}




