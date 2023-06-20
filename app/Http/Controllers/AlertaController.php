<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AlertaController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Alerta());
        $perpage = $this->getLimitPagination($request);

        $queryalerta = Alerta::where($filters)
            ->with('campania');

        if ($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar campania  que pertenecen a una cuenta
            $queryalerta->whereHas('alerta.campania', function ($query)  {
                $query->where('idcuenta', '=', $this->user->idcuenta);
            });  
        }    

        if ($request->exists('fechadesde')) {
            $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
            $queryalerta->whereDate('fechainicio', '>=', $fechadesde);
        }

        if ($request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();
            $queryalerta->whereDate('fechainicio', '<=', $fechahasta);
        }   

        $alertas = $queryalerta->orderBy('idalerta', 'DESC')
            ->paginate($perpage);

        return $alertas; 
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
            
            $alerta = $this->setModel(new Alerta(), $request);
            $alerta->userinsert = $this->user->email;
            $alerta->save();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {

            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::errorMessage('Es posible que hay una Alerta registrada con el mismo nombre.');

        } catch (Exception $e) {

            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();

        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alerta  $alerta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Alerta::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alerta  $alerta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = "";
        try {

            $alerta = $this->setModel(Alerta::findOrFail($id), $request);
            $alerta->userupdate = $this->user->email;
            $alerta->update();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {

            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::errorMessage('Es posible que hay una Alerta registrada con el mismo nombre.');

        } catch (Exception $e) {

            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();
            
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alerta  $alerta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = "";
        //$errorMsg = 'No se puede eliminar. Hay Campañas que hacen uso de esta Alerta.';

        try {

            /* $numberDependents = Cliente::where(['idevento' => $id, 'estado' => RuleManager::ACTIVE_STATE])->count();
            if ($numberDependents == 0) {

                $evento = Evento::findOrFail($id);
                $evento->estado = $evento->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
                $evento->userupdate = $this->user->email;
                $evento->update();

                if ($evento->estado == RuleManager::ACTIVE_STATE) {
                    $result = ResultManager::successMessage('Evento activado correctamente.');
                }else if($evento->estado == RuleManager::DISABLED_STATE) {
                    $result = ResultManager::warningMessage('Evento eliminado correctamente.');
                }

            } else {
                $result = ResultManager::errorMessage($errorMsg);
            } */

            $alerta = Alerta::findOrFail($id);
            $alerta->estado = $alerta->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
            $alerta->userupdate = $this->user->email;
            $alerta->update();

            if ($alerta->estado == RuleManager::ACTIVE_STATE) {
                $result = ResultManager::successMessage('Alerta activado correctamente.');
            }else if($alerta->estado == RuleManager::DISABLED_STATE) {
                $result = ResultManager::warningMessage('Alerta desactivada correctamente.');
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

    private function setModel(Alerta $alerta, Request $request): Alerta
    {
        $alerta->nombrealerta = $request->nombrealerta;
        $alerta->descripcionalerta = $request->descripcionalerta;
        $alerta->urlalerta = $request->urlalerta;
        $alerta->fechainicio = Carbon::createFromFormat('d-m-Y H:i:s', $request->fechainicio);
        $alerta->fechafin = Carbon::createFromFormat('d-m-Y H:i:s', $request->fechafin);
        $alerta->idcampania = $request->idcampania;

        return $alerta;
    }

    public function showalert($id){
        return Alerta::where([['idcampania',$id],['estado',RuleManager::ACTIVE_STATE]])
        ->orderby('fechainicio','desc')
        ->get();
    }

    public function physicallyremove(Request $request){
        $result = "";

        $id = $request->id;
        try {
            Alerta::destroy($id);
            $result = ResultManager::successMessage('Alerta eliminada correctamente.');

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
