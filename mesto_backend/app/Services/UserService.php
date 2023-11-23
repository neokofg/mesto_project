<?php

namespace App\Services;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService {

    public function get()
    {
        try {
            return Auth::user();
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
