<?php

namespace App\Http\Controllers;

use App\Mail\NotificationEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    public function index($user)
    {
        $usuario = User::whereId($user)->first();
        return view('usuarios', compact('usuario'));
    }

    public function update(Request $request, $user)
    {
        #validate
        $request->validate(array(
                'name' => 'required',
                'email' => 'required|email'
            )
        );

        $email = $request->email;
        User::whereId($user)->update(array(
            'name'  => $request->name,
            'email' => $email,
        ));

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
