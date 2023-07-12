<?php

namespace App\Http\Controllers;

use App\Exports\InstitucionesExport;
use App\Exports\plantillaInstitucion;
use App\Models\AtencionInstitucion;
use App\Models\Institucion;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InstitucionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Institucion());
        $perpage = $this->getLimitPagination($request);
        $queryinstitucion = Institucion::where($filters)
            ->with('user');

            if($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idcuenta, RuleManager::ADMINISTRATORS_ACCESS)) {
                //filtro mostrar clientes  que pertenecen a una cuenta
               /*  $queryclientes->whereHas('campania', function ($query) {
                    
                }); */
                $queryinstitucion->where('iduser','=',  $this->user->id );
            }

        $instituciones = $queryinstitucion->orderBy('idinstitucion', 'DESC')
            ->paginate($perpage);
            
        return $instituciones;
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

            $institucion = $this->setModel(new Institucion(), $request);
            $institucion->userinsert = $this->user->email;
            //$institucion->idcuenta = $this->user->idcuenta;
            $institucion->save();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya una Institucion registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Institucion  $institucion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Institucion::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Institucion  $institucion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = "";
        try {

            $institucion = $this->setModel(Institucion::findOrFail($id), $request);
            $institucion->userupdate = $this->user->email;
            //$institucion->idcuenta = $this->user->idcuenta;
            $institucion->update();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya una Institucion registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Institucion  $institucion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = "";
        $errorMsg = 'No se puede eliminar. Hay Atenciones que hacen uso de esta Institucion';

        try {

            $numberDependents = AtencionInstitucion::where(['idinstitucion' => $id, 'estado' => 'A'])->count();

            if ($numberDependents == 0) {
                $institucion = Institucion::find($id);
                $institucion->estado = $institucion->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
                $institucion->update();

                if ($institucion->estado == RuleManager::ACTIVE_STATE) {
                    $result = ResultManager::successMessage('Institucion activado correctamente.');
                }else if($institucion->estado == RuleManager::DISABLED_STATE) {
                    $result = ResultManager::warningMessage('Institucion eliminado correctamente.');
                }
            } else {
                $result = ResultManager::warningMessage($errorMsg);
            }

        } catch (QueryException $e) {
            $result = ResultManager::gerericErrorMessage();
        } catch (Exception $e) {
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    public function setModel(Institucion $institucion,Request $request): Institucion{
        $institucion->institucion = $request->institucion;
        $institucion->nombresdirector = $request->nombresdirector;
        $institucion->apellidosdirector = $request->apellidosdirector;
        $institucion->pkubigeo = $request->pkubigeo;
        $institucion->direccion = $request->direccion;
        $institucion->sede = $request->sede;
        $institucion->telefono = $request->telefono;
        $institucion->celular = $request->celular;
        $institucion->cargo = $request->cargo;
        $institucion->departamento = $request->departamento;
        $institucion->distrito = $request->distrito;
        $institucion->paginaweb = $request->paginaweb;
        $institucion->tipoinstitucion = $request->tipoinstitucion;
        $institucion->procedencia = $request->procedencia;
        $institucion->contactoalterno = $request->contactoalterno;
        $institucion->correoalterno = $request->correoalterno;
        $institucion->cargoalterno = $request->cargoalterno;
        $institucion->telefonoalterno = $request->telefonoalterno;
        $institucion->celularalterno = $request->celularalterno;
        $institucion->email = $request->email;
        $institucion->iduser = $request->iduser;
        return $institucion;
    }

    public function descargarplantilla(Request $request)
    {
        try {
            $name = 'plantillaInstitucion[' . Carbon::now('America/Lima')->format('d-m-Y H:i:s') . ' ].xlsx';
            return Excel::download(new plantillaInstitucion($request), $name);
            
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        }
    }

    public function brochure($id)
    {
        if (empty($id)) {
            return redirect()->route('spa');
        }

        $invitacion = Institucion::find($id);
       
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        //return optional($this->fecharegistro)->format('d-m-Y');
        $fecha = Carbon::now();;
        $mes = $meses[($fecha->format('n')) - 1];
        $date= $fecha->format('d') . ' de ' . $mes . ' del ' . $fecha->format('Y');

        //$invitacion = Invitacion::all();

        $pdf = Pdf::loadView('invitacion.brochureInstitucion', ['invitacion' => $invitacion, 'date' => $date]);
        return $pdf->stream('Invitación Descubre tu vocación - '.$invitacion->nombreinstitucion.'.pdf');
    }

    public function exportarExcel(Request $request)
    {
        try {
            $name = 'instituciones[' . Carbon::now('America/Lima')->format('d-m-Y H:i:s') . ' ].xlsx';
            return Excel::download(new InstitucionesExport($request), $name);
            
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        }
    }

}
