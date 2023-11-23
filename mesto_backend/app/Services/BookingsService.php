<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Excursion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingsService {

    public function create($r)
    {
        try {
            DB::transaction(function() use($r) {
               $b = new Booking();
               $b->format = $r['format'];
               $b->number = $r['number'];
               $b->email = $r['email'];
               $b->clients = $r['clients'];
               $b->fromDate = $r['fromDate'];
               $b->toDate = $r['toDate'];
               $b->organization_id = $r['organization_id'];
               $b->save();
            });
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function get($r)
    {
        try {
            return Booking::where('id','=',$r['id'])->first();
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function index($r)
    {
        try {
            $o = Auth::user()->organization()->first();
            $b = $o->bookings();
            if(isset($r['status'])) {
                $b = $b->where('status','=',$r['status']);
            }
            if (isset($r['fromDate'], $r['toDate'])) {
                $b = $b->where('fromDate', '>=', $r['fromDate'])
                    ->where('toDate', '<=', $r['toDate']);
            }
            return $b->get();
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function update($r)
    {
        try {
            DB::transaction(function() use($r) {
                $b = Booking::where('id','=',$r['bookingId'])->first();
                unset($r['bookingId']);
                $b->update($r);
            });
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function accept($r)
    {
        try {
            DB::transaction(function() use($r) {
                $e = new Excursion();
                $e->exDate = $r['exDate'];
                $e->organization_id = Auth::user()->organization()->first()->id;
                $e->save();

                foreach($r['bookings'] as $b_i) {
                    $b = Booking::find($b_i);
                    $b->exTime = $r['exDate'];
                    $b->excursion_id = $e->id;
                    $b->save();
                    Mail::send('emails.booking_approved', ['date' => $r['exDate']], function($message) use($b){
                        $message->to($b->email);
                        $message->subject('mesto');
                    });
                }
            });
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
