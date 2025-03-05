<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class DashboardSABTController extends Controller {

    public function dashboardsabt() {
        
        if(!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        $connection = User::conexion();

        if($connection == 'psql') {
            return view('admin');
        } else {

            $distorsionesArmonicas = $this->getDistorsionesArmonicas($connection);
            $numDistorsionesArmonicas = $this->getNumDistorsionesArmonicas($connection);
            $promedioFase = $this->getPromedioFase($connection);
            $numFlickers = $this->getNumFlickers($connection);
            $desbalancesTension = $this->getDesbalancesTension($connection);
            $numDesbalancesTension = $this->getDesbalancesTension($connection);
            $variacionesTension = $this->getVariacionesTension($connection);
            $numVariacionesTension = $this->getNumVariacionesTension($connection);

            return view('dashboardsabt', [
                'distorsionesArmonicas' => $distorsionesArmonicas,
                'numDistorsionesArmonicas' => $numDistorsionesArmonicas,
                'promedioFase' => $promedioFase,
                'numFlickers' => $numFlickers,
                'desbalancesTension' => $desbalancesTension,
                'numDesbalancesTension' => $numDesbalancesTension,
                'variacionesTension' => $variacionesTension,
                'numVariacionesTension' => $numVariacionesTension,
            ]);
        }
    }

    //KPI1
    public function getDistorsionesArmonicas($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s96')) {
                $distorsionesArmonicas = DB::connection($connection)->select("
                SELECT  
                    AVG(hr_thd) AS avg_hr_thd,  
                    AVG(hs_thd) AS avg_hs_thd,  
                    AVG(ht_thd) AS avg_ht_thd FROM core.t_s96 		 
                WHERE fh >= NOW() - INTERVAL '72 hours';");

                return $distorsionesArmonicas ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {
            return ['message' => 'No hay datos'];
        }

    }

    //KPI1
    public function getNumDistorsionesArmonicas($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s96')) {
                $numDistorsionesArmonicas = DB::connection($connection)->select("
                SELECT COUNT(*) AS total_distorsiones 
                FROM core.t_s96 
                WHERE hr_thd > 8 OR hs_thd > 8 OR ht_thd > 8;");

                return $numDistorsionesArmonicas ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }

    //KPI2
    public function getPromedioFase($connection) {
        try {
            if(Schema::connection($connection)-> hasTable('t_s94')) {
                $promedioFase = DB::connection($connection)->select("
                SELECT  
                    AVG(fr) AS avg_fr, 
                    AVG(fs) AS avg_fs, 
                    AVG(ft) AS avg_ft 
                FROM core.t_s94 
                WHERE fh >= NOW() - INTERVAL '3 days'; ");

                return $promedioFase ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }

    //KPI2
    public function getNumFlickers($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s94')) {
                $numFlickers = DB::connection($connection)->select("
                SELECT COUNT(*) AS total_flickers 
                FROM core.t_s94 
                WHERE fr > 1 OR fs > 1 OR ft > 1; ");

                return $numFlickers ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    //KPI3
    public function getDesbalancesTension($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s95')) {
                $desbalancesTension = DB::connection($connection)->select("
                SELECT AVG(vu) AS avg_desbalance_tension 
                FROM core.t_s95 
                WHERE fh >= NOW() - INTERVAL '72 hours'; ");

                return $desbalancesTension ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    //KPI3
    public function getNumDesbalancesTension($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s95')) {
                $numDesbalancesTension = DB::connection($connection)->select("
                SELECT COUNT(*) AS total_desbalances 
                FROM core.t_s95 
                WHERE vu > 2; ");

                return $numDesbalancesTension ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    //KPI4
    public function getVariacionesTension($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s97')) {
                $variacionesTension = DB::connection($connection)->select("
                SELECT SUM(nr) AS total_variaciones_r, 
                    SUM(ns) AS total_variaciones_s, 
                    SUM(nt) AS total_variaciones_t 
                FROM core.t_s97 WHERE fh >= NOW() - INTERVAL '72 hours';");

                return $variacionesTension ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getNumVariacionesTension($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s97')) {
                $numVariacionesTension = DB::connection($connection)->select("
                SELECT id_rtu, sum(nr) , sum(ns), sum(nt)  
                FROM core.t_s97 
                group by 1; ");
                
                return $numVariacionesTension ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }
}