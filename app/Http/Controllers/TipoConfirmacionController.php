<?php

namespace App\Http\Controllers;

use App\Models\AtencionInstitucion;
use App\Models\TipoConfirmacion;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TipoConfirmacionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new TipoConfirmacion());
        $perpage = $this->getLimitPagination($request);

        $tipoatencioninstitucion = TipoConfirmacion::where($filters)
            ->where('idtipoconfirmacion','>=',RuleManager::SYSTEM_ADMIN_ROLE)
            ->orderBy('idtipoconfirmacion','DESC')
            ->paginate($perpage);

        return $tipoatencioninstitucion;
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
            $tipoconfirmacion = $this->setModel(new TipoConfirmacion(),$request);
            $tipoconfirmacion->save();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this,__FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya un Tipo de Atencion registrado con el mismo nombre.');
        
        } catch (Exception $e){
            LogErrorManager::saveInDB($this,__FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoConfirmacion  $TipoConfirmacion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return TipoConfirmacion::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoConfirmacion  $TipoConfirmacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = "";
        try {
            $tipoconfirmacion = $this->setModel(TipoConfirmacion::findOrFail($id), $request);
            $tipoconfirmacion->save();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya un Tipo de Confirmacion registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoConfirmacion  $TipoConfirmacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = "";
        $errorMsg='No se puede eliminar. Hay una Atencion que hace uso de este Tipo Confirmacion.';
        try {
        $numberDependents = AtencionInstitucion::where(['idtipoconfirmacion'=>$id,'estado'=> RuleManager::ACTIVE_STATE])->count();

         if($numberDependents == 0){

            $tipoconfirmacion=TipoConfirmacion::findOrFail($id);
            $tipoconfirmacion->estado=RuleManager::DISABLED_STATE;
            $tipoconfirmacion->update();

            $result = ResultManager::successMessage('Tipo Confirmacion eliminado correctamente.');
         }else{
             $result=ResultManager::errorMessage($errorMsg);
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
        $filters = $this->getFilters($request, new TipoConfirmacion());

        $queryTipoconfirmacion = TipoConfirmacion::where($filters);
                   
        /* if ($request->exists('istosave')){
            $queryTipoconfirmacion->where('idtipoconfirmacion','>',RuleManager::UNATTENDED_STATE_TYPE);
        } */

        $tipoaconfirmacion = $queryTipoconfirmacion->orderBy('idtipoconfirmacion', 'DESC')
            ->get();

        return $tipoaconfirmacion;

    }

    private function setModel(TipoConfirmacion $tipoconfirmacion, Request $request): TipoConfirmacion 
    {
        $tipoconfirmacion->tipoconfirmacion = $request->tipoconfirmacion;
        $tipoconfirmacion->color = $request->color;
        return $tipoconfirmacion;
    }
}
