<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Empleo;
use App\Models\EmpleoCarrera;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CarreraController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Carrera());
        $perpage = $this->getLimitPagination($request);

        $carreras = Carrera::where($filters)
            ->orderBy('idcarrera', 'DESC')
            ->paginate($perpage);
            
        return $carreras;
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

            $carrera = $this->setModel(new Carrera(), $request);
            $carrera->userinsert = $this->user->email;
            $carrera->save();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya una Carrera registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Carrera::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = "";
        try {

            $carrera = $this->setModel(Carrera::findOrFail($id), $request);
            $carrera->userupdate = $this->user->email;
            $carrera->update();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya una Carrera registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = "";
        $errorMsg='No se puede eliminar. Hay empleos que hacen uso de esta carrera.';
        try {
        $numberDependents = EmpleoCarrera::where(['id_carrera'=> $id,'estado' => 'A'])->count();

         if($numberDependents == 0){

            $carrera = Carrera::findOrFail($id);
            $carrera->estado = $carrera->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
            $carrera->update();

            if ($carrera->estado == RuleManager::ACTIVE_STATE) {
                $result = ResultManager::successMessage('Carrera restaurado correctamente.');
            } else if($carrera->estado == RuleManager::DISABLED_STATE) {
                $result = ResultManager::successMessage('Carrera eliminado correctamente.');
            }

         }else{
             $result=ResultManager::warningMessage($errorMsg);
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

    public function setModel(Carrera $carrera,Request $request): Carrera
    {
        $carrera->nombre = $request->nombre;

        return $carrera;
    }

    public function select(Request $request)
    {
        $filters = $this->getFilters($request, new Carrera());

        $carrera = Carrera::where($filters)
            -> orderBy('idcarrera')
            ->get();

        return $carrera;
    }
}
