<?php

namespace App\Http\Controllers;

use App\Models\Empleo;
use App\Models\Experiencia;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ExperienciaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Experiencia());
        $perpage = $this->getLimitPagination($request);

        $experiencias = Experiencia::where($filters)
            ->orderBy('id', 'DESC')
            ->paginate($perpage);
            
        return $experiencias;
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

            $experiencia = $this->setModel(new Experiencia(), $request);
            $experiencia->userinsert = $this->user->email;
            $experiencia->save();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya una experiencia registrada con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Experiencia  $experiencia
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Experiencia::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Experiencia  $experiencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = "";
        try {

            $experiencia = $this->setModel(Experiencia::findOrFail($id), $request);
            $experiencia->userupdate = $this->user->email;
            $experiencia->update();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya una experiencia registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Experiencia  $experiencia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = "";
        $errorMsg='No se puede eliminar. Hay empleos que hacen uso de esta Experiencia.';

        try {
        $numberDependents = Empleo::where(['idexperiencia'=> $id, 'estado' => 'A'])->count();
       
         if($numberDependents == 0){

            $experiencia = Experiencia::findOrFail($id);
            $experiencia->estado = $experiencia->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
            $experiencia->update();

            if ($experiencia->estado == RuleManager::ACTIVE_STATE) {
                $result = ResultManager::successMessage('Experiencia restaurada correctamente.');
            } else if($experiencia->estado == RuleManager::DISABLED_STATE) {
                $result = ResultManager::successMessage('Experiencia eliminada correctamente.');
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

    public function select(Request $request)
    {
        $filters = $this->getFilters($request, new Experiencia());

        $experiencia = Experiencia::where($filters)
            -> orderBy('id')
            ->get();

        return $experiencia;
    }

    public function setModel(Experiencia $experiencia,Request $request): Experiencia
    {
        $experiencia->nombre = $request->nombre;

        return $experiencia;
    }
}
