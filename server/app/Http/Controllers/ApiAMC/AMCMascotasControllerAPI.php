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


    //Método controlador que crea una mascota con los datos que recibe via post, si estos son correctos
    //solo se accede a este método controlador si el usuario está autenticado porque usamos el middleware sanctum en la ruta
    public function crearMascotaAMC(Request $request)
    {
        //vamos a usar la validacion implementada en Laravel con el facades Validator
        $validador=Validator::make($request->all(), 
            [
            'nombre' => 'required|string|min:4|max:50',
            'descripcion' => 'required|string|max:250',
            'tipo' => 'required|string|in:Perro,Gato,Pájaro,Dragón,Conejo,Hamster,Tortuga,Pez,Serpiente',
            'publica' => 'required|string|in:Si,No'
            ],
            [//personalización de los mensajes de error al validar
                'nombre.required'=>'El nombre de la mascota no se ha indicado',
                'nombre.string'=>'El nombre de la mascota tiene que ser una cadena',
                'nombre.min'=>'El nombre de la mascota tiene que tener al menos 4 caracteres',
                'nombre.max'=>'El nombre de la mascota no puede tener más de 50 caracteres',
                'descripcion.required'=>'La descripción de la mascota no se ha indicado',
                'descripcion.string'=>'La descripción de la mascota tiene que ser una cadena',
                'descripcion.max'=>'La descripción de la mascota no puede tener más de 250 caracteres',
                'tipo.required'=>'No has seleccionado un tipo de mascota',
                'tipo.string'=>'El tipo de mascota tiene que ser una cadena',
                'tipo.in'=>'El tipo de mascota no es uno de los permitidos en la lista de tipos de mascota',
                'publica.required'=>'No has indicado si la mascota es o no pública',
                'publica.string'=>'Si la mascota es o no pública tiene que ser una cadenda',
                'publica.in'=>'Si la mascota es pública sólo puede ser Si o No'
        ]);

        //si la validacion de los datos falla porque no se cumplen las reglas establecidas en el validador
        if($validador->fails()){
            //recogemos los errores
            $errores=$validador->errors()->all();
            //devolvemos como json los errores y el c'odigo 400
            return response()->json([
                'mensaje' => 'Datos incorrectos',
                'errores' => $errores
            ], 400);
        //si el validador no falla
        } else {
            //recogemos los datos validados
            $datosValidados=$validador->validated();
            //añadimos el id del usuario a los datos validados porque lo necesitamos para crear una nueva mascota
            $datosValidados['user_id']=auth()->id();
            //usamos el modelo MascotaAMC para guardar los datos, create crea y guarda la mascota en la bd
            $nuevaMascota=MascotaAMC::create($datosValidados);
            //devolvemos el estado 200 y la id de la nueva mascota creada
            return response()->json([
                'id_mascota' => $nuevaMascota->id,
                'implementador' => 'Ana Mesones Calvillo'
            ], 200);
        }
    }
    
    //Método controlador que cambia una mascota con los datos que recibe en formato json
    //solo se accede a este método controlador si el usuario está autenticado porque usamos el middleware sanctum en la ruta
    public function cambiarMascotaAMC(MascotaAMC $mascota, Request $request)
    {
        //Laravel ya controla que el id de la mascota pertenezca a la base de datos, si no lo encuentra genera una respuesta 404
        //si la mascota que se quiere actualizar no es una de las mascotas del usuario autenticado
        if($mascota->user_id!==auth()->id()){
            //devolvemos el estado 403 e informamos del error
            return response()->json([
                'mensaje' => 'No puedes modificar una mascota que no te pertenece'
            ], 403);
        //si la mascota es del usuario    
        } else {
            //si los datos recibidos NO son tipo JSON
            if(!$request->isJson()){
                //devolvemos el estado 403 e informamos del error
                return response()->json([
                    'mensaje' => 'Los datos recibidos no están en formato JSON'
                ], 403);
            //si los datos recibidos son de tipo JSON
            } else {
                //validamos los datos recibidos usando el facades Validator
                $validador=Validator::make($request->json()->all(), 
                    [
                    'descripcion' => 'required|string|max:250',
                    'publica' => 'required|string|in:Si,No'
                    ],
                    [//personalización de los mensajes de error al validar
                        'descripcion.required'=>'La descripción de la mascota no se ha indicado',
                        'descripcion.string'=>'La descripción de la mascota tiene que ser una cadena',
                        'descripcion.max'=>'La descripción de la mascota no puede tener más de 250 caracteres',
                        'publica.required'=>'No has indicado si la mascota es o no pública',
                        'publica.string'=>'Si la mascota es o no pública tiene que ser una cadenda',
                        'publica.in'=>'Si la mascota es pública sólo puede ser Si o No'
                    ]
                );
                //si la validacion de los datos falla porque no se cumplen las reglas establecidas en el validador
                if($validador->fails()){
                    //recogemos los errores
                    $errores=$validador->errors()->all();
                    //devolvemos como json los errores y el c'odigo 400
                    return response()->json([
                        'mensaje' => 'Datos incorrectos',
                        'errores' => $errores
                    ], 400);
                //si el validador no falla
                } else {
                    //recogemos los datos
                    $datosRecibidos=$validador->validated();
                    //Actualizamos los datos de la mascota
                    $mascota->update($datosRecibidos);
                    //devolvemos el estado 200 y la id de la nueva mascota creada
                    return response()->json([
                        'mensaje' => 'Mascota modificada correctamente'
                    ], 200);
                }
            }
        }
    }

    //Método controlador que elimina una mascota si pertenece al usuario
    //solo se accede a este método controlador si el usuario está autenticado porque usamos el middleware sanctum en la ruta
    public function borrarMascotaAMC($mascota)
    {
        //si $mascota no es un número
        if(!is_numeric($mascota)){
            //devolvemos el estado 400 y un mensaje informando del error
            return response()->json([
                'mensaje' => 'El ID de la mascota que quieres borrar tiene que ser un número'
            ], 400);
        //si $mascota es un número    
        } else {
            //buscamos la instancia de mascota con la id pasada por parametro en el metodo controlador
            $instanciaMascota=MascotaAMC::find($mascota);
            //si esa instancia no existe (porque las mascota no está en la base de datos)
            //o si la instacia de mascosta existe pero no pertenece al usuario
            if(!$instanciaMascota || $instanciaMascota->user_id!==auth()->id()){
                //devolvemos el estado 200 y un mensaje informando al usuario, neutro para no dar informacion de la bd
                return response()->json([
                'mensaje' => 'La petición es correcta pero no se ha realizado ninguna acción'
                ], 200);
            }
            //si la mascota existe en la base de datos y ademas pertenece al usuario
            if($instanciaMascota && $instanciaMascota->user_id===auth()->id()){
                //si podemos proceder a borrarla
                $instanciaMascota->delete();
                //devolvemos el estado 200 y un mensaje informando que la operacion se ha realizado con exito
                return response()->json([
                'mensaje' => 'Mascota borrada correctamente'
                ], 200);
            }
        }
    }

}
