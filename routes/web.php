<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Auth\LoginController@showLoginForm');
/* Route::get('/', 'landing@index')->name('landing'); */

Auth::routes(['register' => false]);
Route::permanentRedirect('/register', '/login');

Route::permanentRedirect('/home', '/crm');

//Route spa
Route::get('crm/{path?}', "SpaController@index")->where('path', '([A-z0-9-\/_.]+)?')->name('spa');

//Routes for consume data
Route::prefix('rest')->name('rest.')->group(function () {

    Route::get('user/userasesor', 'UserController@userasesor')->name('user.userasesor');
    Route::get('user/select', 'UserController@select')->name('user.select');
    Route::resource('user', 'UserController');

    Route::get('rol/select', 'RolController@select')->name('rol.select');
    Route::resource('rol', 'RolController')->except(['show', 'create']);

    Route::get('cuenta/select', 'CuentaController@select')->name('cuenta.select');
    Route::resource('cuenta', 'CuentaController')->except(['show', 'create']);
    Route::get('campania/select', 'CampaniaController@select')->name('campania.select');
    Route::resource('campania', 'CampaniaController')->except(['show', 'create']);

    Route::get('empresa/select', 'EmpresaController@select')->name('empresa.select');
    Route::resource('empresa', 'EmpresaController');

    Route::get('carrera/select', 'CarreraController@select')->name('carrera.select');
    Route::resource('carrera', 'CarreraController');

    Route::get('experiencia/select', 'ExperienciaController@select')->name('experiencia.select');
    Route::resource('experiencia', 'ExperienciaController');

    Route::get('ciclo/select', 'CicloController@select')->name('ciclo.select');
    Route::resource('ciclo', 'CicloController');

    Route::get('empleo/exportarexcel', 'EmpleoController@exportarExcel')->name('empleo.exportarexcel');
    Route::get('empleo/descargarplantilla', 'EmpleoController@descargarplantilla')->name('empleo.descargarplantilla');
    Route::resource('empleo', 'EmpleoController');

    Route::get('evento/getevento', 'EventoController@getevento')->name('evento.getevento');
    Route::resource('evento', 'EventoController')->except(['edit', 'create']);

    Route::resource('tipoEvento', 'TipoEventoController');

    Route::get('alerta/{id}/showalert', 'AlertaController@showalert')->name('alerta.showalert');
    Route::post('alerta/physicallyremove', 'AlertaController@physicallyRemove')->name('alerta.physicallyremove');
    Route::resource('alerta','AlertaController');

   /*  Route::get('institucion/brochure/{id}', 'InstitucionController@brochure');
    Route::get('institucion/exportarexcel', 'InstitucionController@exportarExcel')->name('institucion.exportarexcel');
    Route::get('institucion/descargarplantilla', 'InstitucionController@descargarplantilla')->name('institucion.descargarplantilla');
    Route::resource('institucion', 'InstitucionController'); */

    Route::get('cliente/procedenciaAdsUtm', 'ClienteController@procedenciaAdsUtm')->name('cliente.procedenciaAdsUtm');
    Route::get('cliente/descargarplantilla', 'ClienteController@descargarplantilla')->name('cliente.descargarplantilla');
    Route::get('cliente/descargarpdf', 'ClienteController@descargarPDF')->name('cliente.descargarpdf');
    Route::get('cliente/exportarexcel', 'ClienteController@exportarExcel')->name('cuenta.exportarexcel');
    Route::get('cliente/exportarexcelcv', 'ClienteController@exportarExcelCV')->name('cliente.exportarexcelcv');
    Route::post('cliente/importarexcel', 'ClienteController@importarExcel')->name('cuenta.importarexcel');
    Route::post('cliente/physicallyremove', 'ClienteController@physicallyRemove')->name('cliente.physicallyremove');
    Route::resource('cliente', 'ClienteController')->except(['show', 'create']);

    Route::resource('clienteevento', 'EventoClienteController');

    Route::get('ubigeo/index', 'UbigeoController@index')->name('ubigeo.index');
    Route::get('ubigeo/departamentos', 'UbigeoController@departamentos')->name('ubigeo.departamentos');
    Route::get('ubigeo/provincias', 'UbigeoController@provincias')->name('ubigeo.provincias');
    Route::get('ubigeo/distritos', 'UbigeoController@distritos')->name('ubigeo.distritos');
    Route::get('ubigeo/distritosleccionados', 'UbigeoController@distritosleccionados')->name('ubigeo.distritosleccionados');

    Route::get('tipoAtencion/select', 'TipoAtencionController@select')->name('tipoAtencion.select');
    Route::resource('tipoAtencion', 'TipoAtencionController')->except(['show', 'create']);

    /* Route::get('tipoconfirmacion/select', 'TipoConfirmacionController@select');
    Route::resource('tipoconfirmacion', 'TipoConfirmacionController');  */

    Route::get('atencion/detail/{id}', 'AtencionController@detail')->name('tipoAtencion.detail');
    Route::resource('atencion', 'AtencionController')->except(['show', 'create']);

    Route::get('atencioninstitucion/detail/{id}', 'AtencionInstitucionController@detail');
    Route::resource('atencioninstitucion', 'AtencionInstitucionController');

    Route::post('import/saveInstitucion', 'ImportacionController@saveInstitucion');
    Route::post('import/saveEmpleo', 'ImportacionController@saveEmpleo');
    Route::resource('import', 'ImportacionController')->except(['show', 'create']);
    Route::resource('logerror', 'LogErrorController')->except(['show', 'create']);

    Route::get('reporte/cantidadclientesevento','ReporteController@cantidadclientesevento');
    Route::get('reporte/asistenciasevento','ReporteController@asistenciasevento');
    Route::get('reporte/totalcampanias','ReporteController@totalcampanias');
    Route::get('reporte/cantidadpautas','ReporteController@cantidadpautas');
    Route::get('reporte/cantidadprospectos','ReporteController@cantidadprospectos');
    Route::get('reporte/registroclientes','ReporteController@registroclientes');
    Route::get('reporte/clienteCarrera','ReporteController@clienteCarrera');
    Route::get('reporte/clienteedad','ReporteController@clienteedad');
    Route::get('reporte/clienteinstitucion','ReporteController@clienteinstitucion');
    Route::get('reporte/clientegrados','ReporteController@clientegrados');

    /* Route::get('invitacion/brochure/{id}', 'InvitacionController@brochure'); */
    //Route::get('invitacion/obtenerid/{id}', 'InvitacionController@obtenerid');
    /* Route::resource('invitacion', 'InvitacionController'); */

    Route::post('sala/physicallyRemove', 'SalaController@physicallyRemove')->name('sala.physicallyRemove');
    Route::resource('sala', 'SalaController');

    Route::post('moderador/physicallyremove', 'ModeradorController@physicallyRemove')->name('moderador.physicallyremove');
    Route::resource('moderador', 'ModeradorController');

    Route::resource('conexionsocket','ConexionSocketController');

});
