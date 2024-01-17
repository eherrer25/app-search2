<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 

            if($user->type == 1 && $user->habilitado == 'si' && $user->status == 1){
                $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
                $success['name'] =  $user->name;

                $user->api_token =  $success['token'];
                $user->save();
   
                return $this->sendResponse($success, 'Usuario accedió exitosamente!.');
            }
            
            $user->tokens()->delete();
            Auth::logout();
            
            // $request->session()->invalidate();
            // $request->session()->regenerateToken();

            return $this->sendError('Unauthorised.', ['error'=>'Acceso denegado.']);
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Acceso denegado.']);
        } 
    }

     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200,['Content-type'=>'application/json;charset=utf-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    // public function update(Request $request)
    // {
    //     $token = Str::random(60);
 
    //     $request->user()->forceFill([
    //         'api_token' => hash('sha256', $token),
    //     ])->save();
 
    //     return ['token' => $token];
    // }
}
