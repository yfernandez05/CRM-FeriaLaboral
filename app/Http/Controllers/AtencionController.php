<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Atencion;
use App\Models\Institucion;
use App\Util\RuleManager;
use App\Util\ResultManager;
use Illuminate\Http\Request;
use App\Util\LogErrorManager;
use Illuminate\Database\QueryException;

class AtencionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Cliente());
        $perpage = $this->getLimitPagination($request);

        $queryclientes = Cliente::where($filters)
            ->with('eventoCliente','campania','distrito','ultimaatencion');

        if($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar clientes  que pertenecen a una cuenta
            $queryclientes->whereHas('campania', function ($query) {
                $query->where('idcuenta','=', $this->user->idcuenta);
            });
        }

        if ($request->exists('fechadesde')){
            $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
            $queryclientes->whereDate('fecharegistro','>=', $fechadesde);
        }

        if ($request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();           
            $queryclientes->whereDate('fecharegistro','<=', $fechahasta);
        }

        $clientes = $queryclientes-> orderBy('idcliente', 'DESC')
            ->paginate($perpage);
    
        return $clientes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result;
        try {

            $atencion = $this->setModel(new Atencion(), $request);
            $atencion->iduser = $this->user->id;
            $atencion->userinsert = $this->user->email;
            $atencion->save();            

            $cliente = Cliente::findOrFail($request->idcliente);
            $cliente->idtipoatencion = $request->idtipoatencion;
            $cliente->update();

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Atencion::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result;
        try {

            $atencion = $this->setModel(Atencion::findOrFail($id), $request);
            $atencion->iduser = $this->user->id;
            $atencion->userupdate = $this->user->email;
            $atencion->update();

            $cliente = Cliente::findOrFail($request->idcliente);
            $cliente->idtipoatencion = $request->idtipoatencion;
            $cliente->update();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $result;
        try {
            $atencion = Atencion::find($id);
            $atencion->estado = RuleManager::DISABLED_STATE;

            $atencion->update();

            $result = ResultManager::successMessage('Atencion ' . RuleManager::getStateName($atencion->estado). ' correctamente');
        } catch (QueryException $e) {
            $result = ResultManager::gerericErrorMessage();
        } catch (Exception $e) {
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    public function detail($id)
    {
        return Atencion::where('idcliente',$id)->with('tipoatencion')-> orderBy('idatencion', 'DESC')->get();
    }

    private function setModel(Atencion $atenciones, Request $request): Atencion
    {
        $atenciones->idtipoatencion = $request->idtipoatencion;
        $atenciones->idcliente = $request->idcliente;
        $atenciones->fechaatencion = Carbon::createFromFormat('d-m-Y', $request->fechaatencion);
        $atenciones->comentario = $request->comentario;

        return $atenciones;
    }
}
