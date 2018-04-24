<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Account\Events\UserHasLoggedIn;
use Modules\Account\Jobs\PrepUserDataAfterLogin;
use Modules\Servermessenger\Messenger\Task\TaskProducer;
use Modules\Users\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginPage()
    {
        return view('account::login');
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->all();

        if(filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            //user sent their email
            $loggedIn = $this->guard()->attempt(['email' => $credentials['email'], 'password' => $credentials['password']]);
        } else {
            //they sent their username instead
            $loggedIn = $this->guard()->attempt(['username' => $credentials['email'], 'password' => $credentials['password']]);
        }

        return $loggedIn;
    }

    protected function validateLogin(Request $request)
    {
        if($request->ajax()){
            $validator = \Validator::make($request->all(),[
                $this->username() => 'required', 'password' => 'required',
            ]);
            if($validator->fails()){
                return response()->json([
                    'hasError' => true,
                    'errors' => [
                        $validator->errors()->getMessages(),
                    ],
                    'message' => 'Failed login validation. You must have omitted a required field.'
                ],401);
            }

        }
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    protected function sendLoginResponse(Request $request)
    {

        if($request->hasSession()) $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        /**
         * @var User $user
         */
        $user = \Auth::user() ?? auth()->guard('api')->user();

        // todo: emit event=> UserHasLoggedIn
        publish(new UserHasLoggedIn($user));

        if($request->ajax() || $request->wantsJson()){
            return response()->json([
                'user' => $user,
                'message' => 'Successfully logged in',
                'setupRequired' => $user->requiresInitialSetup(),
                'redirect' => $user->requiresInitialSetup() ?
                    '/welcome/setup' :
                    redirect()->intended()->getTargetUrl()
            ]);
        }

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if($request->ajax()){
            return response()->json([
                'hasError' => true,
                'message' => 'Invalid username and/or password',
            ],422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => $this->getFailedLoginMessage(),
            ]);
    }

}
