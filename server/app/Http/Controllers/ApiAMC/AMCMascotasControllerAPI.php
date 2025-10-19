<?php

namespace App\Http\Controllers\ApiAMC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\MascotaAMC;

use function PHPUnit\Framework\isNan;

class AMCMascotasControllerAPI extends Controller
{
    //Método controlador que devuelve la lista de mascotas del usuario autenticado
    //solo se accede a este método controlador si el usuario está autenticado porque usamos el middleware sanctum en la ruta
    public function listarMascotasAMC():JsonResponse
    {
        $mascotasUsuario=[];
        $datosMascotas=Auth::user()->mascotas;
        foreach ($datosMascotas as $mascota){
            $mascotasUsuario[]=[
                'id'=>$mascota['id'],
                'nombre'=>$mascota['nombre'],
                'descripcion'=>$mascota['descripcion'],
                'tipo'=>$mascota['tipo'],
                'publica'=>$mascota['publica'],
                'megusta'=>$mascota['megusta']
            ];
        }
        //forzamos que retorne un objeto json
        return response()->json($mascotasUsuario);
    }

    
}
