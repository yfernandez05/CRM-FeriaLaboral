<?php

namespace App\Http\Controllers;

use App\Models\Campania;
use App\Models\Cliente;
use App\Models\Evento;
use App\Util\RuleManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Client;

class ReporteController extends BaseController
{
    public function cantidadclientesevento(Request $request){  

        /* $eventos = Cliente::with('evento')->whereHas('evento')->select('eventos.idevento', 'eventos.nombreevento' ,DB::raw('count(clientes.idcliente) as total'));

        if ($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar campania  que pertenecen a una cuenta
            $eventos->whereHas('evento.campania', function ($query)  {
                $query->where('idcuenta', '=', $this->user->idcuenta);
            });             
        }

        $clientefiltereventos = $eventos 
        ->join('eventos', 'clientes.idevento', '=', 'eventos.idevento')
        ->where('clientes.estado' , '=', RuleManager::ACTIVE_STATE)
        ->groupBy('eventos.idevento')
        ->get(); */

        $clientefiltereventos = DB::select(
            'CALL SP_REGSITROEVENTOSCAMPANIA_CLIENTES (?,?)',
            [
                $request->idevento,
                $request->idcampania,
            ]
        );
        

        return $clientefiltereventos;
    }

    public function asistenciasevento(Request $request){
        $clientefilterasistencia = DB::select(
            'CALL SP_REGSITROAASISTENCIAS_CLIENTES (?,?)',
            [
                $request->idevento,
                $request->idcampania,
            ]
        );

        return $clientefilterasistencia;
    }

    public function totalcampanias(Request $request){
        $campania = Campania::with('evento')->whereHas('evento')->select('campanias.nombrecampania',DB::raw('count(campanias.idcampania) as total'));

        if ($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar campania  que pertenecen a una cuenta
            $campania->whereHas('evento.campania', function ($query)  {
                $query->where('idcuenta', '=', $this->user->idcuenta);
            });          
        }

        $campaniafiltertotal = $campania
        ->where('campanias.estado' , '=', RuleManager::ACTIVE_STATE)
        ->groupBy('campanias.idcampania')
        ->get();         

        return $campaniafiltertotal;

    }

    public function cantidadpautas(Request $request){
        $clientefilterasistencia = DB::select(
            'CALL SP_REGSITROPROCEDENCIA_CLIENTES (?,?)',
            [
                $request->idevento,
                $request->idcampania,
            ]
        );       

        return $clientefilterasistencia;
    }

    public function cantidadprospectos(){
        $clientefilterapautas = Cliente::with('evento')->whereHas('evento');

        if ($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar campania  que pertenecen a una cuenta
            $clientefilterapautas->whereHas('evento.campania', function ($query)  {
                $query->where('idcuenta', '=', $this->user->idcuenta);
            });
        }

        $prospectos = $clientefilterapautas
        ->get();
        /* ->where('estado' , '=', RuleManager::ACTIVE_STATE)
        ->all(); */
        return $prospectos;
    }

    public function registroclientes(Request $request){
        $filters = $this->getFilters($request, new Cliente()); 
        
        $clientes = Cliente::where($filters)       
        ->with('eventoCliente','campania','distrito')
        ->whereHas('campania');

        /* if ($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar campania  que pertenecen a una cuenta            
            $clientes->whereHas('campania', function ($query) {
                $query->where('idcuenta', '=', $this->user->idcuenta);
            });
        }
        */
        //filtro de fechas input buscar por fechas
        /* if ($request->exists('fechadesde')) {
            $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
            $clientes->whereDate('fecharegistro', '>=', $fechadesde); //pasamos como consulta el campo fecharegistro
        }
        if ($request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();
            $clientes->whereDate('fecharegistro', '<=', $fechahasta); //pasasmos como consulta el campos fecharegistro
        }  */

        /* $clientefilterasistencia = $clientes 
        ->select('idcliente','idevento', DB::raw("WhereDate(clientes.fecharegistro,'%m-%d') as fecharegistro") ,DB::raw('count(idcliente) as total'))
        ->groupBy('fecharegistro')
        ->get(); */

        //$consulta =  Cliente::WhereDate('fecharegistro', '2022-05-02')->get();

        //$store= DB::select('call SP_REGSITROSFECHAS_CLIENTES' ());
        $id=0;
        $store = DB::select(
            'CALL SP_REGSITROSFECHAS_CLIENTES (?, ?)',
            [
                $request->idevento,
                $request->idcampania,
            ]
        );
        return $store;
    }

    public function clienteCarrera(Request $request){
        $clienteCarrea = DB::select(
            'CALL SP_REGISITROCARRERA_CLIENTES (?,?)',
            [
                $request->idevento,
                $request->idcampania,
            ]
        );
        return $clienteCarrea;
    }

    public function clienteedad(Request $request){
        $clienteEdad = DB::select(
            'CALL SP_REGISITROEDAD_CLIENTES (?,?)',
            [
                $request->idevento,
                $request->idcampania,
            ]
        );
        return $clienteEdad;
    }

    public function clienteinstitucion(Request $request){
        $clienteInstitucion = DB::select(
            'CALL SP_REGISITROINSTITUCION_CLIENTES (?,?)',
            [
                $request->idevento,
                $request->idcampania,
            ]
        );
        return $clienteInstitucion;
    }

    public function clientegrados(Request $request){
        $clienteGrado = DB::select('CALL SP_REGSITROGRADO_CLIENTES (?,?)',[
            $request->idevento,
            $request->idcampania,
        ]);

        return $clienteGrado;
    }

}
