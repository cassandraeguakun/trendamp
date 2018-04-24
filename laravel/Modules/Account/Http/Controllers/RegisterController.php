<?php

namespace Modules\Account\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Account\Jobs\Register;
use Modules\Account\Repositories\AccountRepository;
use Modules\Users\Http\Resources\BasicUserResource;
use Modules\Users\Models\User;
use Carbon\Carbon;

class RegisterController extends Controller
{

    public function __construct()
    {

    }

    public function showRegPage()
    {
        return view('account::register');
    }


    public function registerView()
    {
        return view('app::pages.register');
    }

    public function register()
    {
        $data = $this->validate(\request(), [
            'email' => 'required|email|same:confirm_email|unique:users',
            'password' => 'required',
        ]);

        $user = dispatch_now(new Register($data));

        auth()->login($user);

        $token =  $user->createToken(config('app.name'))->accessToken;

        return response()->json([
            'message' => 'Registration successful.',
            'token' => $token
        ]);
    }

    public function validateUser(Request $request, User $user, AccountRepository $accountRepository)
    {
        $data = $request->validate([
            'username' => 'required|unique:users|max:48',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = $accountRepository->register($data);

        if($request->ajax()){
            return response()->json([
                'user' => $user,
                'message' => 'Registration successful.'
            ]);
        }

        return $user;
    }







}
