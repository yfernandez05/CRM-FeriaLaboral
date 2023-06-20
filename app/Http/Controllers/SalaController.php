<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Sala;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SalaController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Sala(), []);
        $perpage = $this->getLimitPagination($request);
        $querysala = Sala::where($filters);
 
        $salas = $querysala->where('idtiposala','>',0)->orderBy('chat_id', 'DESC')
            ->paginate($perpage);
            
        return $salas;
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

            $sala = $this->setModel(new Sala(), $request);
            //$sala->userinsert = $this->user->email;
            $sala->save();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que hay una sala registrada con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sala  $sala
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Sala::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sala  $sala
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = '';
        try {

            $sala = $this->setModel(Sala::findOrFail($id), $request);
            //$sala->userupdate = $this->user->email;
            $sala->update();

            $result = ResultManager::genericSuccessMessage();
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que hay una sala registrada con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sala  $sala
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = '';

        try {
            $sala = Sala::findOrFail($id);
            $sala->estado = $sala->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
            //$sala->userupdate = $this->user->email;
            $sala->update();

            if ($sala->estado == RuleManager::ACTIVE_STATE) {
                $result = ResultManager::successMessage('Sala activada correctamente.');
            } else if($sala->estado == RuleManager::DISABLED_STATE) {
                $result = ResultManager::warningMessage('Sala deshabilitada correctamente.');
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

    private function setModel(Sala $sala, Request $request): Sala
    {

        $sala->nombresala = $request->nombresala;
        $sala->descripcion = $request->descripcion;
        $sala->datofijado = $request->datofijado;
        $sala->idtiposala = $request->idtiposala;

        return $sala;
    }

    public function physicallyRemove(Request $request)
    {
        $result = "";
        $id = $request->id;

        try {
            $resultSala =

            $resultMessage = Message::where('chat_id',$id);
            $resultMessage->delete();

            $resultSala = Sala::find($id);
            $resultSala->delete();

            $result = ResultManager::successMessage('Sala eliminada correctamente.');

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }
}
