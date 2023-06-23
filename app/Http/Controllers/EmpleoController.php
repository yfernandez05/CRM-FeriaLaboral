<?php

namespace App\Http\Controllers;

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
use Illuminate\Database\QueryException;
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
            ->with('empresa');

        // Verificar si el usuario tiene el rol y el idempresa específicos
        if ($this->user->idrol === '6') {
            $query->where('idempresa', $this->user->idempresa);
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
    {
        $result = "";
        try {

            $empleo = $this->setModel(new Empleo(), $request);
            $empleo->userinsert = $this->user->email;
            $empleo->save();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que hay un empleo registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
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
        return Empleo::find($id);
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

        try {
            $empleo = Cliente::findOrFail($id);
            $empleo->estado = $empleo->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
            $empleo->userupdate = $this->user->email;
            $empleo->update();

            if ($empleo->estado == RuleManager::ACTIVE_STATE) {
                $result = ResultManager::successMessage('Empleo activado correctamente.');
            } else if($empleo->estado == RuleManager::DISABLED_STATE) {
                $result = ResultManager::warningMessage('Empleo desactivado correctamente.');
            }

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    private function setModel(Empleo $empleo, Request $request): Empleo
    {

        $empleo->idempresa = $this->user->idempresa;
        $empleo->titulo = $request->titulo;
        $empleo->descripcion = $request->descripcion;
        $empleo->requisitos = $request->requisitos;
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
