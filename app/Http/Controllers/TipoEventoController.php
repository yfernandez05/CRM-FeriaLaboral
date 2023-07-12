<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\TipoEvento;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TipoEventoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new TipoEvento());
        $perpage = $this->getLimitPagination($request);

        $tipoeventos = TipoEvento::where($filters)
            ->orderBy('idtipoevento','DESC')
            ->paginate($perpage);

        return $tipoeventos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result ="";
        try {
            $tipoevento = $this->setModel(new TipoEvento(),$request);
            $tipoevento->save();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this,__FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya un Tipo de Evento registrado con el mismo nombre.');
        
        } catch (Exception $e){
            LogErrorManager::saveInDB($this,__FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoEvento  $tipoEvento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return TipoEvento::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoEvento  $tipoEvento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result ="";
        try {
            $tipoevento = $this->setModel(TipoEvento::findOrFail($id), $request);
            $tipoevento->save();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya un Tipo de Evento registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoEvento  $tipoEvento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result ="";
        $errorMsg='No se puede eliminar. Hay un Evento que hace uso de este Tipo de Atencion.';
        try {
        $numberDependents = Evento::where(['idtipoevento'=>$id,'estado'=> RuleManager::ACTIVE_STATE])->count();

         if($numberDependents == 0){

            $tipoevento=TipoEvento::findOrFail($id);
            $tipoevento->estado = $tipoevento->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
            $tipoevento->userupdate = $this->user->email;
            $tipoevento->update();

            if ($tipoevento->estado == RuleManager::ACTIVE_STATE) {
                $result = ResultManager::successMessage('Tipo de Evento activado correctamente.');
            } else if($tipoevento->estado == RuleManager::DISABLED_STATE) {
                $result = ResultManager::warningMessage('Tipo de Evento eliminado correctamente.');
            }
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

    private function setModel(TipoEvento $tipoevento, Request $request): TipoEvento 
    {
        $tipoevento->tipoevento = $request->tipoevento;
        $tipoevento->backgroundColor = $request->backgroundColor;
        $tipoevento->textColor = $request->textColor;
        
        return $tipoevento;
    }
}
