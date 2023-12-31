<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\User;
use App\Models\UsersVerify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AuthService {

    public function register($r): Bool
    {
        try {
            //generating code
            $c = $this->generateCode();

            $e = $r['email'];
            $p = $r['password'];
            $n = $r['organization_name'];

            DB::transaction(function () use($c, $e, $p, $n) {
                //creating User model
                $u = User::where("is_email_verified", "=", false)->firstOrCreate(["email" => $e], ["name" => $n, "password" => Hash::make($p)]);
                if(!$u){
                    return false;
                }
                //creating Verify model
                $u_v = UsersVerify::firstOrNew(['user_id' => $u->id]);
                $u_v->code = $c;
                $u_v->email = $e;
                $u_v->save();

                //sending mail
                Mail::send('emails.email_verification', ['code' => $c], function($message) use($e){
                    $message->to($e);
                    $message->subject('mesto');
                });
            });
            return true;
        } catch(Throwable $e) {
            return false;
        }

    }

    public function register_approve($r): mixed
    {
        try {
            $c = $r['code'];

            $token = DB::transaction(function () use($c) {
                $u_v = UsersVerify::where("code", '=', $c)->firstOrFail();
                $u = User::where("id", '=', $u_v->user_id)->firstOrFail();
                $o = new Organization();
                $o->name = $u->name;
                $o->user_id = $u->id;
                $o->save();

                $u->is_email_verified = true;
                $u->name = rand(100000,300000);
                $u->save();

                $u_v->delete();

                Mail::send('emails.new_user', ['name' => $u->name], function($message) use($u){
                    $message->to($u->email);
                    $message->subject('mesto');
                });

                return $u->createToken($u->id . "|token")->plainTextToken;
            });
            return $token;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function login($r)
    {
        try {
            $u_c = ['name' => $r['login'], 'password' => $r['password']];
            $r_c = ['login' => $r['login'], 'password' => $r['password']];
            if(Auth::attempt($u_c)) {
                return Auth::user()->createToken('')->plainTextToken;
            } else if(Auth::guard('resident')->attempt($r_c)) {
                return Auth::guard('resident')->user()->createToken('')->plainTextToken;
            } else {
                return false;
            }
        } catch(Throwable $e) {
            dd($e);
            return false;
        }
    }

    private function generateCode(): Int
    {
        $is_unique = false;
        while($is_unique == false){
            $code = rand(1000,9999);
            if(!UsersVerify::where('code',$code)->exists()){
                $is_unique = true;
            }
        }
        return $code;
    }
}
