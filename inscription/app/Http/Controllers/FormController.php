<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\FormModel;
use Exception;

class FormController extends Controller
{
    public function index(): View
    {
     
        return view(view: 'formulaire');
    }
    public function create(): View
    {
     
        return view(view: 'formulaire');
    }


    public function store(Request $request)
    {
        try{
            $data = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'tel' => 'required|string|max:255']);
            var_dump(value: $data);
                
                
                $user = FormModel::create($data);
                $user->name = $data['name'];
                $user->surname = $data['surname'];
                $user->username = $data['username'];
                $user->password = $data['password'];
                $user->email = $data['email'];
                $user->tel = $data['tel'];
                var_dump($user);
                return view('validation');
        }catch(Exception $e) {
            return view('error');
        }
    }
}; 
