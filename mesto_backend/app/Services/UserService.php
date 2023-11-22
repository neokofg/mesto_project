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

}
