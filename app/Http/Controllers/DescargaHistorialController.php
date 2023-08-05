<?php

namespace App\Http\Controllers;

use App\Models\DescargaHistorial;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DescargaHistorialController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return dd('descargarhistorial');
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
        DB::beginTransaction();
        try {
            if(!in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)){
                $descargaHistorial = new DescargaHistorial();
                $descargaHistorial->usuario_id = auth()->user()->id;
                $descargaHistorial->tipodocumento_id = $request->tipodocumento;
                $descargaHistorial->save();
                DB::commit();
                $result = ResultManager::genericSuccessMessage();
            }
            
        } catch (QueryException $e) {
            DB::rollback();
            //dd($e);
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage($e);
        } catch (Exception $e) {
            DB::rollback();
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            //dd($e);
            $result = ResultManager::gerericErrorMessage($e);
        }
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DescargaHistorial  $descargaHistorial
     * @return \Illuminate\Http\Response
     */
    public function show(DescargaHistorial $descargaHistorial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DescargaHistorial  $descargaHistorial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DescargaHistorial $descargaHistorial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DescargaHistorial  $descargaHistorial
     * @return \Illuminate\Http\Response
     */
    public function destroy(DescargaHistorial $descargaHistorial)
    {
        //
    }

    public function setModel(DescargaHistorial $descargaHistorial,Request $request): DescargaHistorial
    {
        $descargaHistorial->nombre =  $this->user->idempresa;;

        return $descargaHistorial;
    }
}
