<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Atencion;
use App\Util\RuleManager;
use App\Util\ResultManager;
use Illuminate\Http\Request;
use App\Util\LogErrorManager;
use App\Exports\ClientesExport;
use App\Exports\plantillaCliente;
use App\Models\Campania;
use App\Models\Empleo;
use App\Models\Evento;
use App\Models\EventoCliente;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ClienteController extends BaseController
{
    public function __construct()
    {
        parent::__construct(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Cliente());
        //agregamos el modelo EVENTO adicionales en cliente + evento, hace el filtro de busqueda en Cliente + Evento
        $filtersEvento = $this->getFilters($request, new EventoCliente());
        $filterCampania = $this->getFilters($request, new Campania());
        $perpage = $this->getLimitPagination($request);

        if($request->idevento)
        {
            $querycliente = Cliente::where($filters)
            ->with('eventoCliente','campania','distrito','files','perfil')
            //agregamos filtro adicionales
            ->whereHas('eventoCliente', function ($query) use ($filtersEvento) {
                $query->where($filtersEvento);
            }) /*
            ->whereHas('evento')  */;

            if ($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
                //filtro mostrar usuarios que pertenecen a una cuenta
                $querycliente->whereHas('campania', function ($query) {
                    $query->where('idcuenta', '=', $this->user->idcuenta);
                });
            }

            if ($request->exists('fechadesde')) {
                $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
                $querycliente->whereDate('fecharegistro', '>=', $fechadesde);
            }

            if ($request->exists('fechahasta')) {
                $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();
                $querycliente->whereDate('fecharegistro', '<=', $fechahasta);
            }

            $cliente = $querycliente->orderBy('idcliente', 'DESC')
            ->paginate($perpage);

        }else{

        $querycliente = Cliente::where($filters)
            ->with('eventoCliente','campania','distrito','files','perfil'/* ,'empleo' */,'empleosPostulados')
            //agregamos filtro adicionales
            ->whereHas('campania', function ($query) use ($filterCampania) {
                $query->where($filterCampania);
            });

            if ($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
                // Filtro para usuarios que no son administradores
                $querycliente->where(function ($query) {
                    $query->whereHas('campania', function ($query) {
                        $query->where('idcuenta', '=', $this->user->idcuenta);
                    })
                    ->whereHas('empleosPostulados', function ($query) {
                        $query->where('idempresa', '=', $this->user->idempresa);
                    });
                })
                ->with(['empleosPostulados' => function ($query) {
                    $query->where('idempresa', $this->user->idempresa);
                }]);
            }

            if ($request->exists('fechadesde')) {
                $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
                $querycliente->whereDate('fecharegistro', '>=', $fechadesde);
            }

            if ($request->exists('fechahasta')) {
                $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();
                $querycliente->whereDate('fecharegistro', '<=', $fechahasta);
            }

            $cliente = $querycliente->orderBy('idcliente', 'DESC')
            /*Cmbiar momentaneo*/
            //->where('idcampania','=',10)
            ->paginate($perpage);
        }
        return $cliente;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = "";
        try {
            $cliente = new Cliente();
            $cliente = $this->setModel($cliente, $request);
            $cliente->userinsert = $this->user->email;
            $cliente->save();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $duplicateEntry = 1062; // registro duplicado

            if (count($e->errorInfo)) {
                if ($e->errorInfo[1] == $duplicateEntry) {
                    $result = ResultManager::warningMessage('La dirección de correo electrónico que ha ingresado ya está registrada.');
                } else {
                    $result = ResultManager::errorMessage('Intente nuevamente más tarde.');
                }

            } else {
                $result = ResultManager::errorMessage('Intente nuevamente más tarde.');
            }

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return Cliente::with('campania', 'distrito')->find($id);
        return Cliente::with('eventoCliente','campania', 'distrito')
        ->whereHas('campania')->find($id);

        // return Cliente::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $result = "";
        try {

            $cliente = $this->setModel(Cliente::findOrFail($id), $request);
            $cliente->userupdate = $this->user->email;
            $cliente->update();

            if($request->idevento != 0){
                EventoCliente::updateOrCreate(
                    ['idcliente' => $id],
                    ['idevento' => $request->idevento],
                );
            }else{
                EventoCliente::destroy($id);
            }

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya un postulante registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = "";
        $errorMsg = 'No se puede eliminar. Hay Atenciones que hacen uso de Postulante';

        try {
            $numberDependents = Atencion::where(['idcliente' => $id, 'estado' => 'A'])->count();

            if ($numberDependents == 0) {

                $cliente = Cliente::findOrFail($id);
                $cliente->estado = $cliente->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
                $cliente->userupdate = $this->user->email;
                $cliente->update();

                if ($cliente->estado == RuleManager::ACTIVE_STATE) {
                    $result = ResultManager::successMessage('Postulante activado correctamente.');
                } else if($cliente->estado == RuleManager::DISABLED_STATE) {
                    $result = ResultManager::warningMessage('Postulante eliminado correctamente.');
                }

            } else {
                $result = ResultManager::warningMessage($errorMsg);
            }
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::errorMessage($errorMsg);

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function physicallyRemove(Request $request)
    {
        $result = "";
        $errorMsg = 'No se puede eliminar. Hay Atenciones que hacen uso de Postulantes';

        $id = $request->id;
        try {
            $numberDependents = Atencion::where(['idcliente' => $id, 'estado' => 'A'])->count();

            if ($numberDependents == 0) {

                Cliente::destroy($id);

                $result = ResultManager::successMessage('Postulante eliminado correctamente.');
            } else {
                $result = ResultManager::warningMessage($errorMsg);
            }
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::errorMessage($errorMsg);

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    private function setModel(Cliente $cliente, Request $request): Cliente
    {
        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->telefono = $request->telefono;
        $cliente->dni = $request->dni;
        $cliente->carrera = $request->carrera;
        $cliente->grado = $request->grado;
        $cliente->edad = $request->edad;
        $cliente->tipoparticipante = $request->tipoparticipante;
        $cliente->origen = $request->origen;
        $cliente->colegio = $request->colegio;
        $cliente->anioegreso = $request->anioegreso;
        $cliente->email = $request->email;
        $cliente->idcampania = $request->idcampania;
        //$cliente->idevento = $request->idevento;
        $cliente->procedencia = $request->procedencia;
        $cliente->utm = $request->utm;
        $cliente->campaign_content = $request->campaign_content;
        $cliente->campaign_medium = $request->campaign_medium;
        $cliente->campaign_name = $request->campaign_name;
        $cliente->campaign_source = $request->campaign_source;
        $cliente->campaign_term = $request->campaign_term;
        $cliente->grado = $request->grado;
        $cliente->coddistrito = $request->coddistrito;

        return $cliente;
    }

    public function exportarExcel(Request $request)
    {
        try {
            $name = 'postulantes[' . Carbon::now('America/Lima')->format('d-m-Y H:i:s') . ' ].xlsx';
            return Excel::download(new ClientesExport($request), $name);

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        }
    }

    public function descargarplantilla(Request $request)
    {
        try {
            $name = 'plantillaClientes[' . Carbon::now('America/Lima')->format('d-m-Y H:i:s') . ' ].xlsx';
            return Excel::download(new plantillaCliente($request), $name);

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        }
    }

    public function procedenciaAdsUtm(){
        $procedencia = [
             ["procedencia" => 'Orgánico'],
             ["procedencia" => 'Pauta'],
        ];
        return $procedencia;
    }

    /* public function saveclienteevent(Request $request){
        $result = $request[0];
        $clienteid = Cliente::where([['idcampania',9],['estado','A']])->find(304);
        return $clienteid;
    } */
}
