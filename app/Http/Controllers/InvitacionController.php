<?php

namespace App\Http\Controllers;

use App\Models\Invitacion;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class InvitacionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Invitacion());
        $perpage = $this->getLimitPagination($request);
        $queryinvitacion = Invitacion::where($filters)
            ->with('user');

        if($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idcuenta, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar clientes  que pertenecen a una cuenta
        /*  $queryclientes->whereHas('campania', function ($query) {
                
            }); */
            $queryinvitacion->where('iduser','=',  $this->user->id );
        }

        $invitacion = $queryinvitacion->orderBy('idinvitacion', 'DESC')
        ->paginate($perpage);
        
    return $invitacion;
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

            $invitacion = $this->setModel(new Invitacion(), $request);
            $invitacion->userinsert = $this->user->email;
            $invitacion->iduser = $this->user->id;
            if($request->idinstitucion != null){
                $invitacion->idinstitucion = $request->idinstitucion;
            }
            $invitacion->save();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya una Invitacion registrado con los mismos datos.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invitacion  $invitacion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Invitacion::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invitacion  $Invitacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = "";
        try {

            $invitacion = $this->setModel(Invitacion::findOrFail($id), $request);
            $invitacion->userupdate = $this->user->email;
            $invitacion->update();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {

            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::errorMessage('Es posible que hay una Invitacion registrado con los mismo datos.');

        } catch (Exception $e) {

            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();
            
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invitacion  $invitacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = "";      

        try {

            $invitacion = Invitacion::findOrFail($id);
            $invitacion->estado = $invitacion->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
            $invitacion->userupdate = $this->user->email;
            $invitacion->update();

            if ($invitacion->estado == RuleManager::ACTIVE_STATE) {
                $result = ResultManager::successMessage('Invitacion activado correctamente.');
            }else if($invitacion->estado == RuleManager::DISABLED_STATE) {
                $result = ResultManager::warningMessage('Invitacion eliminado correctamente.');
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

    public function setModel(Invitacion $invitacion,Request $request): Invitacion{
        $invitacion->nombreinstitucion = $request->nombreinstitucion;
        $invitacion->nombreencargado = $request->nombreencargado;
        //$invitacion->idatencion = $request->idatencion;
        $invitacion->fecharegistro = Carbon::createFromFormat('d-m-Y H:i:s', $request->fecharegistro);

        return $invitacion;
    }

    public function brochure($id)
    {
        if (empty($id)) {
            return redirect()->route('spa');
        }

        $invitacion = Invitacion::with('user')->find($id);
        //$invitacion = Invitacion::all();

        $pdf = Pdf::loadView('invitacion.brochure', ['invitacion' => $invitacion]);
        return $pdf->stream('Invitación Descubre tu vocación - '.$invitacion->nombreinstitucion.'.pdf');
    }

    /* public function obtenerid($id){
        $codigo =  Invitacion::where('idinstitucion','=',$id)->get();
        return $codigo;
    } */
}
