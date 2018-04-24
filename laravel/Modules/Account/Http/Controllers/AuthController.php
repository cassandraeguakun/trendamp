<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\System\Http\Resources\UserResource;
use Modules\System\Models\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {

    }

    public function showLoginPage()
    {
        return view('account::pages.login');
    }

    public function webLogin()
    {
        //return \request()->all();

        return $this->apiLogin('web', [
            'redirect' => '/'
        ]);
    }

    public function apiLogin($guard = 'api', array $additional_success_return = [])
    {
        $credentials = $this->credentials(\request());

        if(auth()->guard()->attempt($credentials)){
            return $this->apiLoginSuccessResponse($additional_success_return);
        }
        else{
            return errorResponse([
                'message' => 'Invalid login credentials'
            ]);
        }
    }

    protected function apiLoginSuccessResponse(array $additional_data = []){
        /** @var User $user */
        $user = auth()->user();
        $token =  $user->createToken(config('app.name'))->accessToken;

        $return_data = array_merge([
            'token' => $token
        ], $additional_data);

        return response()->json($return_data);
    }

    protected function credentials(Request $request)
    {
        $usernameInput = trim($request->{$this->username()});
        $usernameColumn = filter_var($usernameInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [$usernameColumn => $usernameInput, 'password' => $request->password];

    }

    public function getAuthUser()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    public function logoutUser(Request $request)
    {
        unset($_COOKIE['_AUTH_TOKEN_']);
        setcookie("_AUTH_TOKEN_", null, -1);

        return $this->logout($request);
    }


}
