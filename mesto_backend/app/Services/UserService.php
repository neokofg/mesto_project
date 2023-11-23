<?php

namespace App\Services;

use App\Models\User;

class UserService {

    public function get($u)
    {
        try {
            return User::whereId($u->id)->with("organization")->first();
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function update($u, $r)
    {
        try {
            if(isset($r['name'])) {
                $o = $u->organization()->first();
                $o->name = $r['name'];
                $o->save();
            }
            if(isset($r['email'])) {
                $u->email = $r['email'];
                $u->save();
            }
            return $u->fresh();
        } catch (\Throwable $e) {
            dd($e);
            return false;
        }
    }
}
