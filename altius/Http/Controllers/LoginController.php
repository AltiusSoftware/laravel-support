<?php

namespace Altius\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends BaseController {

    protected function _routes($r){
        $r->get('/login','login')
            ->name('login')
            ->post();

        $r->get('/logout','logout')
            ->name('logout')
            ->post();

        $r->get('password/remind','passwordRemind')
            ->name('password.remind')
            ->post();

        $r->get('password/setup','passwordSetup')
            ->name('password.setup')
            ->post();
    }

    public function login() {
        $form = (new \Altius\Forms\Login)
            ->ajax();
        return view()->make('altius::user.login',['form' => $form]);

    }
    public function logout() {
            Auth::logout();
 
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            messages()->success('You have logged out');
            return redirect('/');            
    }

    public function loginPost() {
        $form = new \Altius\Forms\Login;

        $valid = $form->validate();

        if (Auth::attempt(
                [ 'email' => $valid['email'], 'password' => $valid['password']],request()->has('remember'))) {
            request()->session()->regenerate();
 
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');




    }
    public function passwordRemind() {
        $form = (new \Altius\Forms\PasswordRemind)
                //->ajax()
                ;
        return view()->make('altius::basicform',['form' => $form]);


    }
    public function passwordRemindPost() {
        $valid= (new \Altius\Forms\PasswordRemind)
            ->validate();

        $user = User::firstWhere(['email'=>$valid['email']]);

        if($user) {
            $code = md5($user->email . $user->password);
            $url = url()->temporarySignedRoute('password.setup',now()->addMinutes(30),['code' => $code]);
            if(app()->environment('local'))
                echo($url);
        } else {

            !d('not found');
            exit;
        }



    }
    public function passwordSetup() {
        if (! request()->hasValidSignature()) {
            messages()->warning('This link has expired!');
            return redirect()->route('password.remind');
        }
        $user = User::where(\DB::raw('md5(concat(email,password))'),request()->get('code'))->first();

        $form = (new \Altius\Forms\PasswordSetup);

        $form->title='Setup your password';

        return view()->make('altius::basicform',['form' => $form]);

    }

    public function passwordSetupPost() {
        if (! request()->hasValidSignature()) {
            messages()->warning('This link has expired!');
            return redirect()->route('password.remind');
        }

        $valid=  (new \Altius\Forms\PasswordSetup)
                    ->validate();

        $user = User::where(\DB::raw('md5(concat(email,password))'),request()->get('code'))->first();

        $user->password = Hash::make($valid['password']);
        $user->save();

        messages()->success('Your password has been setup');

        return redirect()->route('home');

    }
}
