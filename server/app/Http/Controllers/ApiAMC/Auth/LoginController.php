<?php

namespace App\Http\Controllers\ApiAMC\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    public function doLogin(Request $request):JsonResponse
    {
        //Creamos un validador
        $validator=Validator::make($request->only(['email','password']), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Si no se valida, al ser una respuesta JSON se retorna 422 Unprocessabel Entity y un objeto JSON con los errores
        if ($validator->fails()) {
            return response()->json(['mensaje'=>'Email o password no proporcionados o no válidos.'], 422);
        }


        $data=$validator->safe()->only('email', 'password');
        // Se valida el usuario (en vez de attempt hacemos solo validate, porque no necesitamos que se almacene en la sesión)
        if (!Auth::validate($data)) {
            return response()->json([
                'mensaje' => 'Credenciales no válidas',
            ], 401);
        }

        // Si llegamos hasta aquí, la validación se ha producido. Buscamos el usuario autenticado y generamos un token
        $user = User::where('email', $validator->getData()['email'])->first();

        $token = $user->createToken('TOKEN-ACCESO-API');

        // Enviamos el token.
        return response()->json([
            'mensaje' => 'Login correcto',
            'token' => $token->plainTextToken
        ]);
    }

    public function doLogout(Request $request):JsonResponse
    {
        //Borramos el token del usuario autenticado (dejando los demás intactos)
        $eliminados=$request->user()->currentAccessToken()->delete();
        //También se pueden borrar todos los tokens:
        //$eliminados=$request->user()->tokens()->delete();

        return response()->json([
            'mensaje' => $eliminados>0?'Logout correcto':'El usuario no estaba autenticado',
            'codigo' => $eliminados>0?1:0
        ],200);
    }
}
