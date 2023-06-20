<?php

namespace App\Http\Controllers;

use App\Models\AtencionInstitucion;
use App\Models\Institucion;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AtencionInstitucionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Institucion());
        $perpage = $this->getLimitPagination($request);

        $queryinstituciones = Institucion::where($filters)
        ->with('user','campania','ultimaatencion');

        if($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idcuenta, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar clientes  que pertenecen a una cuenta
           /*  $queryclientes->whereHas('campania', function ($query) {
                
            }); */
            $queryinstituciones->where('iduser','=',  $this->user->id );
        }

        if ($request->exists('fechadesde')){
            $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
            $queryinstituciones->whereDate('fecharegistro','>=', $fechadesde);
        }

        if ($request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();           
            $queryinstituciones->whereDate('fecharegistro','<=', $fechahasta);
        }

        $institucion = $queryinstituciones-> orderBy('idinstitucion', 'DESC')
            ->paginate($perpage);
    
        return $institucion;
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

            $atencionInstitucion = $this->setModel(new AtencionInstitucion(), $request);
            $atencionInstitucion->iduser = $this->user->id;
            $atencionInstitucion->userinsert = $this->user->email;
            $atencionInstitucion->save();

            $institucion = Institucion::findOrFail($request->idinstitucion);
            $institucion->idtipoconfirmacion = $request->idtipoconfirmacion;
            $institucion->idcampania = $request->idcampania;;
            $institucion->update();

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
     * Display the specified resource.
     *
     * @param  \App\AtencionInstitucion  $atencionInstitucion
     * @return \Illuminate\Http\Response
     */
    public function show(AtencionInstitucion $atencionInstitucion)
    {
        //
    }

    public function detail($id)
    {
        return AtencionInstitucion::where('idinstitucion',$id)
        ->with('user','tipoatencion','campania')
        -> orderBy('idatencion', 'DESC')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AtencionInstitucion  $atencionInstitucion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AtencionInstitucion $atencionInstitucion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AtencionInstitucion  $atencionInstitucion
     * @return \Illuminate\Http\Response
     */
    public function destroy(AtencionInstitucion $atencionInstitucion)
    {
        //
    }

    private function setModel(AtencionInstitucion $atencioninstitucion, Request $request): AtencionInstitucion
    {
        $atencioninstitucion->idtipoconfirmacion = $request->idtipoconfirmacion;
        $atencioninstitucion->idinstitucion = $request->idinstitucion;
        $atencioninstitucion->fechaatencion = Carbon::createFromFormat('d-m-Y', $request->fechaatencion);
        $atencioninstitucion->comentario = $request->comentario;
        $atencioninstitucion->idcampania = $request->idcampania;

        return $atencioninstitucion;
    }

}
