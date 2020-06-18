<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }
    public function show($id)
    {

        return User::findOrFail($id);
    }

    public function create(Request $request)
    {
        $validation = $this->validateRequest($request);
        if ($validation->fails()) {
            return $validation->errors();
        }
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');


        $user->saveOrFail();

        return "User created successfully"; //-> input('name'); - retorna só o que pedi
    }

    public function update(Request $request, $id){
        $validation = $this->validateRequest($request);
        if ($validation->fails()) {
            return $validation->errors();
        }
        User::where('id', $id)
            ->update($request->all());
            //->update(['name => $request->input('name')])

        return "User updated";
    }

    public function delete(Request $request, $id){
        User::where('id', $id)
            ->delete();
        return "User deleted";
    }

    private function validateRequest($request){
        return Validator::make($request->all(),[
            'name' => 'required|min:3|max:255'
        ]);
    }
}
