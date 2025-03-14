<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session'       => 'required|numeric',
            'category_ps'   => 'required',
            'name'          => 'required|string',
            'no_hp'         => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Booking::create([
            'session'       => $request->session,
            'category_ps'   => $request->category_ps,
            'name'          => $request->name,
            'no_hp'         => $request->no_hp,
            'booking_day'   => $request->booking_day,
            'selected_date' => $request->selected_date,
            'total_price'   => $request->total_price,
            'status'        => 'unpaid'
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Booking berhasil!',
            'status'    => $data->status,
            'booking_id' => $data->id,
            'data'      => $data
        ]);
    }

    public function paymentProccess(Request $request)
    {
        $data = Booking::where('id', $request->booking_id)->first();
        if (!$data) {
            return response()->json(['message' => 'Booking tidak ditemukan!'], 404);
        }

        $bookingId = $data->id . '_' . time();
        $subTotal  = $data->total_price;
        $name      = $data->name;
        $phone     = $data->no_hp;

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id'      => $bookingId,
                'gross_amount'  => $subTotal,
            ),
            'customer_details'  => array(
                'first_name'    => $name,
                'phone'         => $phone,
            ),
            'ignore_duplicate_order_id' => true,
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return response()->json(['snapToken' => $snapToken]);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($request->transaction_status == 'capture' or $request->transaction_status == 'settlement') {
            $order_id_with_timestamp = $request->order_id;
            [$order_id, $timestamp] = explode('_', $order_id_with_timestamp);

            $order = Booking::where('id', $order_id)->first();
            $order->update(['status' => 'paid']);

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }
        }
        return response()->json(['message' => 'Callback received successfully']);
    }
}