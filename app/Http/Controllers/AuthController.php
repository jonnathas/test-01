<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        if( $validated = $this->validation($request)){
            return response()->json($validated, 422);
        }

        $credentials = $request->only(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
                'error' => [
                    'message' => 'Usuário ou senha inválida'
                ]
            ],
            401);
        }

        return response()->json([
            'data' => [
                'token' => $token ,
                'user' => auth('api')->user()]
            ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return ['data' => ['token' => auth('api')->refresh()]];
    }

    public function validation(Request $request){
        
        $result = false;

        if((!$request->has('email'))&&(!$request->has('password'))){
            
            $result['message'] = 'Ocorreu um erro de validação';
            
            $result['errors'] = [

                [
                    "fieldname" => "email",
                    "message"=> "O campo Email é obrigatório."
                ],
                [
                    "fieldname"=> "password",
                    "message"=> "O campo Senha é obrigatório."
                ]
            ];
        }

        
        if(($request->has('email'))&&(!$request->has('password'))){
            
            $result['message'] = 'Ocorreu um erro de validação';

            $result['errors'] = [

                [
                    "fieldname"=> "password",
                    "message"=> "O campo Senha é obrigatório."
                ]
            ];
        }
        
        if((!$request->has('email'))&&($request->has('password'))){
            
            $result['message'] = 'Ocorreu um erro de validação';
            
            $result['errors'] = [

                [
                    "fieldname" => "email",
                    "message"=> "O campo Email é obrigatório."
                ],           
            ];
        }
        return $result;
    }
}