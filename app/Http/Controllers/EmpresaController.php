<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EmpresaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Empresa());
        $perpage = $this->getLimitPagination($request);

        $query = Empresa::where($filters);


        $empresa = $query-> orderBy('idempresa', 'DESC')
            ->paginate($perpage);

        return $empresa;
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

            $empresa = $this->setModel(new Empresa(), $request);
            $empresa->userinsert = $this->user->email;
            $empresa->save();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que hay una empresa registrada con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Empresa::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = "";
        try {

            $empresa = $this->setModel(Empresa::findOrFail($id), $request);
            $empresa->userupdate = $this->user->email;
            $empresa->update();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que hay una empresa registrada con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = "";
        $errorMsg = 'No se puede eliminar. hay registros que hacen uso de esta Empresa';

        try {
            //$numberDependents = Empresa::where(['idempresa' => $id, 'estado' => RuleManager::ACTIVE_STATE])->count();
            $numberDependents = 0;

            if ($numberDependents == 0) {

                $empresa = Empresa::findOrFail($id);
                $empresa->estado = $empresa->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
                $empresa->userupdate = $this->user->email;               
                $empresa->update();

                if ($empresa->estado == RuleManager::ACTIVE_STATE) {
                    $result = ResultManager::successMessage('Empresa restaurado correctamente.');
                } else if($empresa->estado == RuleManager::DISABLED_STATE) {
                    $result = ResultManager::successMessage('Empresa eliminado correctamente.');
                }

            }else{
                $result=ResultManager::warningMessage($errorMsg);
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

    private function setModel(Empresa $empresa, Request $request): Empresa
    {

        $empresa->empresa = $request->empresa;
        $empresa->ruc = strval($request->ruc);
        $empresa->razonsocial = $request->razonsocial;

        return $empresa;
    }

    public function select(Request $request)
    {
        $filters = $this->getFilters($request, new Empresa());

        $empresa = Empresa::where($filters)
            -> orderBy('idempresa')
            ->get();

        return $empresa;
    }
}
