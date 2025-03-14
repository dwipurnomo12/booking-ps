<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class RiwayatBookingController extends Controller
{
    public function index()
    {
        return view('riwayat-booking');
    }

    public function searchData(Request $request)
    {
        $data = Booking::where('no_hp', $request->no_hp)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data ditemukan!',
            'data'      => $data
        ]);
    }
}