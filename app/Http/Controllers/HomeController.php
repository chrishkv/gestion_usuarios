<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuarios = User::paginate(5);

        return view('home', compact('usuarios'));
    }

    public function changePassword()
    {
        return view('change-password');
    }

    public function updatePassword(Request $request)
    {
        #validate
        $request->validate(array(
                'oldPassword' => 'required',
                'newPassword' =>  'required|confirmed'
            )
        );

        if (!Hash::check($request->oldPassword, auth()->user()->password))
            return back()->with('error', 'La clave actual no coincide');

        User::whereId(auth()->user()->id)->update(array(
            'password' => Hash::make($request->newPassword)
        ));

        return back()->with('status', 'The password was changed successfully');
    }

    public function search(Request $request)
    {
        $name = $request->all()['name'];
        $usuarios = User::where('name','like',"%{$name}%")->paginate(5);

        return view('home', compact('usuarios'));
    }
}
