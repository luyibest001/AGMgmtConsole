<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogin(Request $request){

        $validated = $request->validate([
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        ]);
// run the validation rules on the inputs from the form

// if the validator fails, redirect back to the form
        if (!$validated) {
            return redirect()->route('login-page', ['success'=>false, 'message'=>'invalid email or password.']); // send back the input (not the password) so that we can repopulate the form
        } else {
            // create our user data for the authentication
            $userdata = array(
                'email' => $request->email,
                'password' => $request->password
            );

            // attempt to do the login
            if (\Auth::attempt($userdata)) {

                // validation successful!
                // redirect them to the secure section or whatever
                // return Redirect::to('secure');
                // for now we'll just echo success (even though echoing in a controller is bad)
                $user = \Auth::user();

                //set global session for user
                session(['user' => $user]);
                return redirect()->route('home-page');

            } else {

                // validation not successful, send back to form
                return redirect()->route('login-page', ['success'=>false, 'message'=>'incorrect email or password.']); // send back the input (not the password) so that we can repopulate the form
            }
        }
    }

    /**
     * @return mixed
     */
    public function doLogout()
    {
        \Auth::logout(); // log the user out of our application
        session()->forget('user');
        return redirect()->route('home-page'); // redirect the user to the login screen
    }

    public function getUser(){
        $user = session('user');
        if(isset($user)){
            return response()->json(['user'=>$user], 200);
        }
        return response()->json(['user'=>null], 404);
    }
}
