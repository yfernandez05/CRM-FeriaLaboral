<?php

namespace App\Http\Controllers;

use App\Exports\EmpleosExport;
use Exception;
use App\Models\Empleo;
use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Empresa;
use Maatwebsite\Excel\Facades\Excel;
use App\Util\RuleManager;
use App\Util\ResultManager;
use Illuminate\Http\Request;
use App\Util\LogErrorManager;
use App\Exports\plantillaEmpleo;
use App\Models\ClienteEmpleo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmpleoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Empleo());
        $perpage = $this->getLimitPagination($request);

        $query = Empleo::where($filters)
            ->with('empresa','experiencia','carreras','ciclos','departamentos');

        // Verificar si el usuario tiene el rol y el idempresa específicos
        if ($this->user->idrol == '6') {
            $query->where('idempresa', $this->user->idempresa);
        }

        if ($request->exists('fechadesde')) {
            $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
            $query->whereDate('fecha_publicacion', '>=', $fechadesde);
        }

        if ($request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();
            $query->whereDate('fecha_publicacion', '<=', $fechahasta);
        }

        $empleo = $query->orderBy('id', 'DESC')
            ->paginate($perpage);

        return $empleo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //return dd($request->idcarrera);
        $result = "";
        DB::beginTransaction();
        try {
            

            $empleo = $this->setModel(new Empleo(), $request);
            $empleo->userinsert = $this->user->email;
            $empleo->save();

            /* save emeplo_carrera*/
            $carrerasIds = $request->idcarrera;
            $empleo->carreras()->attach($carrerasIds);
            $empleo->load('carreras');

            /* save empleo_ciclo */
            $ciclosIds = $request->idciclo;
            $empleo->ciclos()->attach($ciclosIds);
            $empleo->load('ciclos');

            DB::commit();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            DB::rollback();
            dd($e);
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que hay un empleo registrado con el mismo nombre.');

        } catch (Exception $e) {
            DB::rollback();
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            dd($e);
            $result = ResultManager::gerericErrorMessage($e);
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Empleo::with('experiencia','carreras','ciclos')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = "";
        try {

            $empleo = $this->setModel(Empleo::findOrFail($id), $request);
            $empleo->userupdate = $this->user->email;
            $empleo->update();

            $carrerasIds = $request->idcarrera;
            $empleo->carreras()->sync($carrerasIds);

            /* save empleo_ciclo */
            $ciclosIds = $request->idciclo;
            $empleo->ciclos()->sync($ciclosIds);

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = "";
        $errorMsg = 'No se puede eliminar. Hay Atenciones que hacen uso de Postulante';

        try {
            $numberDependents = ClienteEmpleo::where(['idempleo' => $id, 'estado' => 'A'])->count();

            if ($numberDependents == 0) {
                $empleo = Empleo::findOrFail($id);
                $empleo->estado = $empleo->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
                $empleo->userupdate = $this->user->email;
                $empleo->update();

            if ($empleo->estado == RuleManager::ACTIVE_STATE) {
                $result = ResultManager::successMessage('Empleo restaurado correctamente.');
            } else if($empleo->estado == RuleManager::DISABLED_STATE) {
                $result = ResultManager::warningMessage('Empleo desactivado correctamente.');
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

    public function exportarExcel(Request $request)
    {
        try {
            $name = 'empleos[' . Carbon::now('America/Lima')->format('d-m-Y H:i:s') . ' ].xlsx';
            return Excel::download(new EmpleosExport($request), $name);

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        }
    }

    private function setModel(Empleo $empleo, Request $request): Empleo
    {
        $empleo->idempresa = $this->user->idempresa;
        $empleo->idexperiencia = $request->idexperiencia;
        $empleo->titulo = $request->titulo;
        $empleo->vacantes = $request->vacantes;
        if($request->preciopromedio != 0){
            $empleo->preciopromedio = $request->preciopromedio;
        }else{
            $empleo->preciopromedio = null;
        }     
        $empleo->coddepartamento = $request->coddepartamento;
        $empleo->descripcion = $request->descripcion;
        $empleo->requisitos = $request->requisitos;
        $empleo->beneficios = $request->beneficios;
        //$empleo->fecha_publicacion = $request->fecha_publicacion;
        $empleo->fecha_cierre = $request->fecha_cierre;

        return $empleo;
    }

    public function descargarplantilla(Request $request)
    {
        try {
            $name = 'plantillaEmpleo[' . Carbon::now('America/Lima')->format('d-m-Y H:i:s') . ' ].xlsx';
            return Excel::download(new plantillaEmpleo($request), $name);

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        }
    }
}
