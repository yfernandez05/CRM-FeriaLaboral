<?php

namespace App\Http\Controllers;

use App\Models\ConexionSocket;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ConexionSocketController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new ConexionSocket(), []);
        $perpage = $this->getLimitPagination($request);

        $queryconexion = ConexionSocket::where($filters);

        $conexionSocket = $queryconexion-> orderBy('idconexion', 'DESC')
        ->paginate($perpage);

        return $conexionSocket;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConexionSocket  $conexionSocket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ConexionSocket::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConexionSocket  $conexionSocket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConexionSocket $conexionSocket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConexionSocket  $conexionSocket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = '';
        try {

            $conexionSocket = ConexionSocket::find($id);
            $conexionSocket->estado = $conexionSocket->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;

            $conexionSocket->update();

            $result = ResultManager::successMessage('Conexión ' . RuleManager::getStateName($conexionSocket->estado). ' correctamente');
        } catch (QueryException $e) {
            $result = ResultManager::gerericErrorMessage();
        } catch (Exception $e) {
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }
}
