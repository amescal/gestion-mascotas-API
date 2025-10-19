<?php

use App\Http\Controllers\ApiAMC\AMCMascotasControllerAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAMC\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/** Respuesta por defecto cuando no hay usuario autenticado*/
Route::get('/login', function () {
    return response()->json(["mensaje"=>"Es necesaria autenticación para acceder"],401);
})->name('login');

/** Ruta que permite a un usuario autenticado ver sus datos completos (JSON) tras autenticación.
 *  HTTP GET
 *  http://localhost:.../api/user
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Ruta que permite a un usuario hacer login vía API. 
 *  HTTP POST
 *  http://localhost:.../api/login
 */
Route::post('/login', [LoginController::class,'doLogin']);

/** Ruta que permite a un usuario hacer logout (borrar tokens) 
 *  HTTP Cualquiera
 *  http://localhost:.../api/logout
 */
Route::any('/logout', [LoginController::class,'doLogout'])->middleware('auth:sanctum');

/** Ruta que genera un listado de mascotas del usuario 
 *  HTTP GET
 *  http://localhost:.../api/mascotasAMC
 */
Route::get('/mascotasAMC', [AMCMascotasControllerAPI::class, 'listarMascotasAMC'])->middleware('auth:sanctum');

/** Ruta que permite a un usuario autenticado crear una mascota 
 *  HTTP POST
 *  http://localhost:.../api/crearmascotaAMC
 */
Route::post('/crearmascotaAMC', [AMCMascotasControllerAPI::class, 'crearMascotaAMC'])->middleware('auth:sanctum');

/** Ruta que permite a un usuario autenticado actualizar una mascota propia 
 *  HTTP PUT
 *  http://localhost:.../api/mascotaAMC/{mascota}
 */
Route::put('/mascotaAMC/{mascota}', [AMCMascotasControllerAPI::class, 'cambiarMascotaAMC'])->whereNumber('mascota')->middleware('auth:sanctum');

/** Ruta que permite a un usuario autenticado borrar una mascota propia 
 *  HTTP DELETE
 *  http://localhost:.../api/mascotaAMC/{mascota}
 */
Route::delete('/mascotaAMC/{mascota}', [AMCMascotasControllerAPI::class, 'borrarMascotaAMC'])->middleware('auth:sanctum');
