<?php

namespace App\Http\Controllers;

use App\Models\Moderador;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ModeradorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Moderador());
        $perpage = $this->getLimitPagination($request);
        $querymod = Moderador::where($filters)
        ->with('campania');

        $moderador = $querymod->where('moderador','>',0)->orderBy('idcliente', 'DESC')
            ->paginate($perpage);
            
        return $moderador;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = '';
        try {
            $moderador = new Moderador();
            $moderador = $this->setModel($moderador, $request);
            $moderador->userinsert = $this->user->email;
            $moderador->save();

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
     * Display the specified resource.
     *
     * @param  \App\Moderador  $moderador
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Moderador::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Moderador  $moderador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = '';
        try {

            $cliente = $this->setModel(Moderador::findOrFail($id), $request);
            $cliente->userupdate = $this->user->email;
            $cliente->update();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya un Moderador registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Moderador  $moderador
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = '';

        try {
           

           

                $moderador = Moderador::findOrFail($id);
                $moderador->estado = $moderador->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
                $moderador->userupdate = $this->user->email;
                $moderador->update();

                if ($moderador->estado == RuleManager::ACTIVE_STATE) {
                    $result = ResultManager::successMessage('Moderador activado correctamente.');
                } else if($moderador->estado == RuleManager::DISABLED_STATE) {
                    $result = ResultManager::warningMessage('Moderador desactivado correctamente.');
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

    public function physicallyRemove(Request $request)
    {
        $result = '';

        $id = $request->id;
        try {
            Moderador::destroy($id);
            $result = ResultManager::successMessage('Moderador eliminado correctamente.');

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    private function setModel(Moderador $moderador, Request $request): Moderador
    {
        $moderador->nombres = $request->nombres;
        $moderador->apellidos = $request->apellidos;
        $moderador->edad = $request->edad;
        $moderador->email = $request->email;
        $moderador->idcampania = $request->idcampania;
        $moderador->moderador = 1;

        return $moderador;
    }
}
