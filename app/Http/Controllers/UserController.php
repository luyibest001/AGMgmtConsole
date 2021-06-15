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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function doLogin(Request $request){

        $validated = $request->validate([
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        ]);


// run the validation rules on the inputs from the form

        $response = new \Illuminate\Http\Response();

        if (!$validated) {
            return $response->setContent("invalid parameters");
            //return redirect()->route('login-page', ['success'=>false, 'message'=>'invalid email or password.']); // send back the input (not the password) so that we can repopulate the form
        } else {
            $credentials = request(['email', 'password']);

            // attempt to do the login
            if (! $token = auth('api')->attempt($credentials)) {
                //return redirect()->route('login-page', ['success'=>false, 'message'=>'incorrect email or password.']); // send back the input (not the password) so that we can repopulate the form
                /*$response->withException();
                $response->status(401);
                return $response;*/
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            session(['user'=>$this->getUser()]);

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
            'expires_in' => auth('api')->factory()->getTTL() * 60
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
