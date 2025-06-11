<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'nom_distribuidora',
        'fec_acceso',
        'ind_pf',
        'ind_ct',
        'ind_cups',
        'ind_sabt',
        'cod_id_group',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Perform any actions that should be done after the user has been authenticated.
     *
     * @return void
     */

    public function authenticated()
    {
        $this->update(['fec_acceso' => now()]);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function conexion()
    {
        // Verificar si hay un usuario autenticado
        if (Auth::check()) {
            // Obtener el usuario actualmente autenticado
            $user = Auth::user();

            // Verificar si el usuario actual tiene la propiedad nom_distribuidora
            if ($user && isset($user->nom_distribuidora)) {
                // Verificar si el nombre de la distribuidora no es 'admin'
                if ($user->nom_distribuidora != 'admin') {
                    // Determinar la conexión de base de datos correspondiente utilizando el modelo User
                    return User::setDynamicConnection($user->nom_distribuidora);
                }
            }
            // Si no hay usuario autenticado o no se encuentra la propiedad nom_distribuidora, devolver el valor por defecto
            return 'pgsql';
        }
        return redirect()->route('login')->with('message', 'Tu sesión ha expirado debido a inactividad.');
    }

    /**
     * Función que establece la conexión dinámica según el nombre de la distribuidora proporcionado.
     *
     * @param string $nom_distribuidora El nombre de la distribuidora para la cual se establecerá la conexión.
     * @return string La cadena de conexión correspondiente a la distribuidora proporcionada.
     */

    public static function setDynamicConnection($nom_distribuidora)
    {
        // Se utiliza un switch para determinar la conexión basada en el nombre de la distribuidora.
        switch ($nom_distribuidora) {
            case 'Cela':
                return 'pgsql-cela';
            case 'Chera':
                return 'pgsql-chera';
            case 'Sotdechera':
                return 'pgsql-sotdechera';
            case 'Biosca':
                return 'pgsql-biosca';
            case 'Santaclara':
                return 'pgsql-santaclara';
            case 'Alvarobenito':
                return 'pgsql-alvarobenito';
            case 'Vilaller':
                return 'pgsql-vilaller';
            case 'Sampol':
                return 'pgsql-sampol';
            case 'Pastor':
                return 'pgsql-pastor';
            case 'Mercedes':
                return 'pgsql-mercedes';
            case 'Hnoscastro':
                return 'pgsql-hnoscastro';
            case 'Alconera':
                return 'pgsql-alconera';
            case 'Meliana':
                return 'pgsql-meliana';
            case 'Cerrajon':
                return 'pgsql-cerrajon';
            case 'Dielec':
                return 'pgsql-dielec';
            case 'Chulilla':
                return 'pgsql-chulilla';
            case 'Coelca':
                return 'pgsql-coelca';
            case 'Hidroelcarmen':
                return 'pgsql-hidroelcarmen';
            case 'Lijar':
                return 'pgsql-lijar';
            case 'Talayuelas':
                return 'pgsql-talayuelas';
            case 'Laprohida':
                return 'pgsql-laprohida';
			case 'Martinsilva':
                return 'pgsql-martinsilva';
			case 'Ebrofanas':
                return 'pgsql-ebrofanas';
			case 'Leandro':
                return 'pgsql-leandro';	
			case 'Ferez':
                return 'pgsql-ferez';
			case 'Sierramagina':
                return 'pgsql-sierramagina';				
            default:
                // Si no coincide con ninguno de los casos anteriores, se devuelve una conexión por defecto.
                return 'pgsql';
        }
    }

    public static function cerrarConexion()
    {
        // Cierra la conexión
        DB::disconnect(User::conexion());
    }


    // CONEXION PARA PUNTO FRONTERA ------------------------------------------------

    public static function setDynamicMySQLConnection($nom_distribuidora)
{
    // Limpiamos y normalizamos el nombre de la distribuidora para que coincida con el formato de las variables .env
    // Convertimos a minúsculas y reemplazamos espacios o caracteres especiales si los hubiera por un guion bajo o similar,
    // o simplemente capitalizamos la primera letra si ese es el patrón en el .env (como en tu caso).
    // Para tu .env, parece que el patrón es `DB_MYSQL_NOMBRESDITRIBUIDORA_CONNECTION`.
    $connectionName = 'mysql_' . strtolower($nom_distribuidora);

    // Si tu .env usa nombres capitalizados (ej: CELA, CHERA), usa:
    // $connectionName = 'mysql_' . strtoupper($nom_distribuidora);

    // Si tus conexiones en el .env son como 'DB_MYSQL_Cela_CONNECTION', puedes usar:
    // $connectionName = 'mysql_' . ucfirst(strtolower($nom_distribuidora));
    // Pero basándonos en tu .env, parece que los nombres de las bases de datos son en minúscula.

    // Verifica si existe una configuración para la conexión dinámica en las configuraciones de la base de datos.
    // Esto asume que estás usando un framework como Laravel o Symfony que gestiona las configuraciones de la base de datos.
    // Si no es el caso, deberías cargar las variables del .env y comprobarlas directamente.
    if (config('database.connections.' . $connectionName)) {
        return $connectionName;
    }

    // Si no se encuentra una conexión específica, se devuelve una conexión MySQL por defecto.
    return 'mysql';
}



    public static function conexionPuntoFrontera()
    {
        // Verificar si hay un usuario autenticado
        if (Auth::check()) {

            // Obtener el usuario actualmente autenticado
            $user = Auth::user();

            if ($user->cod_id_group != 'admin') {
                // Determinar la conexión de base de datos correspondiente utilizando el modelo User
                return User::setDynamicMySQLConnection($user->nom_distribuidora);
            }
            return 'pgsql';
        }
        return redirect()->route('login')->with('message', 'Tu sesión ha expirado debido a inactividad.');
    }
}
