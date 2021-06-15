<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function doLogin(Request $request){

        // run the validation rules on the inputs from the form
        $validated = $request->validate([
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required'
        ]);

        if (!$validated) {
            return response()->json(['error'=>'invalid parameters', 'code'=>400], 200);
        } else {
            $credentials = request(['email', 'password']);

            // attempt to do the login
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized', 'code'=>401], 200);
            }

            session(['user'=>auth('api')->user()]);

            //\Log::info(session('user'));

            return $this->respondWithToken($token);
            /*$response->withCookie(
                cookie(
                    'token',
                    $token,
                    auth('api')->factory()->getTTL() * 60,
                )
            );

            return $response;*/
        }
    }

    /**
     * Log the user out (Invalidate the token).
     * @return mixed
     */
    public function doLogout()
    {
        auth('api')->logout();
        session()->forget('user');

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated User.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(){

        return response()->json(auth('api')->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'code'=>200
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

}
