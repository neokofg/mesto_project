<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\Resident;
use App\Models\ResidentInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResidentsService {

    public function get($u): mixed
    {
        try {
            return Resident::where("organization_id","=",$u->organization->id)->get();
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function get_invitations($u): mixed
    {
        try {
            return ResidentInvitation::where("organization_id","=",$u->organization->id)->get();
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function generate_key($u, $r): mixed
    {
        try {
            $hash = DB::transaction(function() use($u,$r){
                $o = $u->organization()->first();
                $r_i = new ResidentInvitation();
                $r_i->hash = substr(str_replace(['.','/','$'],"",Hash::make($o->id . now()->format('Y-m-dTH:i:s'))), 0, 16);
                $r_i->name = $r['name'];
                $r_i->flat = $r['flat'];
                $r_i->floor = $r['floor'];
                $r_i->email = $r['email'];
                $r_i->organization_id = $o->id;
                $r_i->save();
                return $r_i->hash;
            });
            return $hash;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function decline_key($h): mixed
    {
        try {
            DB::transaction(function () use($h) {
                $r_i = ResidentInvitation::where("hash", '=', $h)->firstOrFail();
                $r_i->delete();
            });
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function approve_key($h): mixed
    {
        try {
            $credentials = DB::transaction(function () use($h){
                $r_i = ResidentInvitation::where("hash", '=', $h)->firstOrFail();

                $l = rand(300000,500000);
                $p = substr(str_replace(['.','/','$'],"",Hash::make($r_i->id . now()->format('Y-m-dTH:i:s'))), 0, 10);

                $r = new Resident();
                $r->name = $r_i->name;
                $r->flat = $r_i->flat;
                $r->floor = $r_i->floor;
                $r->email = $r_i->email;
                $r->organization_id = $r_i->organization_id;
                $r->password = $p;
                $r->login = $l;
                $r->save();

                $t = $r->createToken('')->plainTextToken;

                $r_i->delete();

                Mail::send('emails.new_resident', ['login' => $l, 'password' => $p], function($message) use($r){
                    $message->to($r->email);
                    $message->subject('mesto');
                });

                return [
                    "login" => $l,
                    "password" => $p,
                    "token" => $t
                ];
            });
            return $credentials;
        } catch (\Throwable $e) {
            dd($e);
            return false;
        }
    }

    public function update($r)
    {
        try {
            $r = Auth::user();
            $r->description = $r['description'];
            $r->save();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
