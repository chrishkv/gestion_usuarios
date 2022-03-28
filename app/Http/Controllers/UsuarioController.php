<?php

namespace App\Http\Controllers;

use App\Mail\NotificationEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index($user)
    {
        $usuario = User::whereId($user)->first();
        $roles = Role::all();
        $usuarioRoleNames = $usuario->getRoleNames()->toArray();
        return view('usuarios', compact('usuario', 'roles', 'usuarioRoleNames'));
    }

    public function update(Request $request, $user)
    {
        #validate
        $request->validate(array(
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'numeric|gt:0'
            )
        );

        $email = $request->email;
        $user = User::whereId($user)->first();
        $user->update(array(
            'name'      => $request->name,
            'last_name' => $request->name,
            'email'     => $email,
            'phone'     => $request->phone,
            'birthday'  => $request->birthday,
            'addres'    => $request->addres,
        ));

        $user->roles()->sync($request->roles);

        $this->sendNotificationEmail($email, 'Updated');

        return redirect()->route('home')->with('status', 'Update successfully');
    }

    public function destroy($user)
    {
        try {
            DB::beginTransaction();
            $user = User::whereId($user)->first();
            $email = $user->email;
            $result = $user->delete();
            if (!$result) {
                DB::rollBack();
                return back()->with('error', 'Error deleting');
            }
            DB::commit();
            $this->sendNotificationEmail($email, 'Deleted');

            return redirect()->route('home')->with('status', 'User deleted');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        };
    }

    public function sendNotificationEmail($email, $action)
    {
        Mail::to($email)->send(new NotificationEmail(
            array(
                'user_email' => $email,
                'user_action' => $action
            )));
    }
}
