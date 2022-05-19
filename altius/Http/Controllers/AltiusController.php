<?php

namespace Altius\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AltiusController extends BaseController {

    public function __construct() {
        $this->middleware('can:altius')
        ->except('setup','setupPost');
    }

    protected function _routes($r){
        $r->get('/altius','index')
            ->name('altius.index');

        
        $r->get('/altius/form','form')
            ->name('altius.form')
            ->post();

        $r->get('/altius/setup','setup')
            ->name('altius.setup')
            ->post();

    }
    

    public function index() {
        !d('Altius Local Package');


        
    }

    public function setup(){

        if(User::count())
            abort(403);

        $form = (new \Altius\Forms\FirstUserCreate)
            ->title('Create First User');
        return view()->make('altius::user.login',['form' => $form]);

    }

    public function setupPost() {
        
        if(User::count())
            abort(403);

        $valid = (new \Altius\Forms\FirstUserCreate)->validate();

        $user = new User;

        $user->name= $valid['name'];
        $user->email = $valid['email'];
        $user->password = Hash::make($valid['password']);

        $user->role='altius';

        $user->save();


        messages()->success('User %s created', $user->email);

        return redirect('/');
        


    }

    public function form() {
        $form = new \Altius\Test\Form;

        $form->setValues(['id' => 33, 'textfield' => 'asdf']);

        return view()->make('altius::test.testform',['form' => $form]);

        !d($f);

            !d(1);


        
    }
}