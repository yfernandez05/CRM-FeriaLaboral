<?php

namespace App\Http\Controllers;

use App\User;
use App\Util\LogErrorManager;
use App\Util\ResultManager;
use App\Util\RuleManager;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
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

        $filters = $this->getFilters($request, new User(), []);
        $perpage = $this->getLimitPagination($request);

        $queryUsers = User::where($filters)
            ->where('idrol', '>', RuleManager::SYSTEM_ADMIN_ROLE)
            ->with('rol')
            ->with('cuenta')
            ->with('empresa');
        // ->whereHas('rol', function($query){
        //     $query->where('estado','A');
        // })
            
        if($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar usuarios que pertenecen a una cuenta
            $queryUsers->where('idcuenta','=',$this->user->idcuenta);
        }

        $users = $queryUsers->orderBy('id', 'DESC')
            ->paginate($perpage);

        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $usuario = new User();
            $usuario = $this->setModel($usuario, $request);
            $usuario->password = Hash::make($request->password);
            $usuario->api_token = Hash::make($request->api_token);
            $usuario->save();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya un Usuario registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return User::find($id);
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

            $usuario = $this->setModel(User::find($id), $request);

            $usuario->update();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya una Usuario registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    public function select(Request $request)
    {
        $filters = $this->getFilters($request, new User());

        $users = User::where($filters)
            ->where('idrol', '>', RuleManager::SYSTEM_ADMIN_ROLE)
            ->where('idcuenta','=', $this->user->idcuenta)
            ->with('rol')
            ->orderBy('id', 'DESC')
            ->get();

        return $users;

    }

    private function setModel(User $usuario, Request $request): User
    {

        $usuario->idrol = $request->idrol;
        $usuario->name = $request->name;
        $usuario->email = $request->email;  
        $usuario->api_token = $request->api_token;
        $usuario->idcuenta = $request->idcuenta;
        $usuario->idempresa = $request->idempresa;
        // $usuario->password = Hash::make($request->password);

        return $usuario;
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
            $usuario = User::find($id);
            $usuario->estado = $usuario->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;

            $usuario->update();

            $result = ResultManager::successMessage('Usuario ' . RuleManager::getStateName($usuario->estado). ' correctamente');
        } catch (QueryException $e) {
            $result = ResultManager::gerericErrorMessage();
        } catch (Exception $e) {
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    public function userasesor(){
        return User::where('idrol','=', RuleManager::ASESOR_ACCESS)->get();
    }

}
