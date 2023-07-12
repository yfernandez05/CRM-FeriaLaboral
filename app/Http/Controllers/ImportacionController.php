<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Evento;
use App\Util\RuleManager;
use App\Models\Importacion;
use App\Util\ResultManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Util\LogErrorManager;
use App\Imports\EmpleosImport;
use App\Imports\ClientesImport;
use App\Imports\InstitucionesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;

class ImportacionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Importacion());
        $perpage = $this->getLimitPagination($request);

        $queryImportaciones = Importacion::where($filters)
            ->with('user');

        if ($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
                // Filtro para listar las importaciones de empresas
                $queryImportaciones->where(function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('idcuenta', '=', $this->user->idcuenta);
                    })
                    ->whereHas('user', function ($query) {
                        $query->where('idempresa', '=', $this->user->idempresa);
                    });
                });


        }

        if ($request->exists('fechadesde')){
            $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
            $queryImportaciones->whereDate('fecharegistro','>=', $fechadesde);
        }

        if ($request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();
            $queryImportaciones->whereDate('fecharegistro','<=', $fechahasta);
        }

        $importaciones = $queryImportaciones-> orderBy('idimportacion', 'DESC')
            ->paginate($perpage);

        return $importaciones;
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

            $file = $request->file('file');

            $importacion = new Importacion();
            $importacion->nombrearchivo = $file->getClientOriginalName();
            $importacion->fecharegistro = Carbon::now();
            $importacion->iduser = $this->user->id;
            $importacion->uuidimportacion = Str::uuid();
            $importacion->idcampania = $request->idcampania;

            $evento = $request->idevento;
            //$importacion->idevento = $request->idevento;

            // $collection = Excel::toCollection(new ClientesImport(), $file);
            // return $collection;
            $clientImport = new ClientesImport($importacion, $evento);
            Excel::import($clientImport, $file);

            $importacion->cantregistros = $clientImport->getRowCount();
            $importacion->save();

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

    public function saveInstitucion(Request $request){
        $result = "";
        try {

            $file = $request->file('file');
            $idasesor = $request->iduser;

            $importacion = new Importacion();
            $importacion->nombrearchivo = $file->getClientOriginalName();
            $importacion->fecharegistro = Carbon::now();
            $importacion->iduser = $this->user->id;
            $importacion->uuidimportacion = Str::uuid();
            //$importacion->iduser = $request->iduser;


            // $collection = Excel::toCollection(new ClientesImport(), $file);
            // return $collection;
            $institImport = new InstitucionesImport($importacion, $idasesor);
            Excel::import($institImport, $file);

            $importacion->cantregistros = $institImport->getRowCount();
            $importacion->save();

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

    public function saveEmpleo(Request $request){
        $result = "";
        try {

            $file = $request->file('file');


            $importacion = new Importacion();
            $importacion->nombrearchivo = $file->getClientOriginalName();
            $importacion->fecharegistro = Carbon::now();
            $importacion->iduser = $this->user->id;
            $importacion->uuidimportacion = Str::uuid();

            $idempresa = $this->user->idempresa;

            // $collection = Excel::toCollection(new ClientesImport(), $file);
            // return $collection;
            $empleosimport = new EmpleosImport($importacion, $idempresa);
            Excel::import($empleosimport, $file);
            //$empleosimport->idempresa = $this->user->idempresa;

            $importacion->cantregistros = $empleosimport->getRowCount();

            $importacion->save();

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
