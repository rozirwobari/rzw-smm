<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopupModels;
use App\Models\User;

class Midtrans extends Controller
{

    private function verifySignature($requestBody, $receivedSignature)
    {
        // Ambil server key dari config/env
        $serverKey = "SB-Mid-server-1at9b7iJOc5LsQ5MNyBhgXdQ";

        // Ambil nilai yang diperlukan
        $orderId = $requestBody['order_id'];
        $statusCode = $requestBody['status_code'];
        $grossAmount = $requestBody['gross_amount'];
        
        // Buat signature key
        $signatureKey = $orderId . $statusCode . $grossAmount . $serverKey;

        // Generate signature
        $calculatedSignature = hash('sha512', $signatureKey);
        
        // Bandingkan dengan signature yang diterima
        return hash_equals($calculatedSignature, $receivedSignature);
    }

    private function topup($user_id, $jumlah)
    {
        $user = User::where('id', $user_id)->first();
        if ($user) {
            $user->saldo = ($user->saldo + $jumlah);
            $user->update();
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        if (!$this->verifySignature($data,  $request->signature_key)) {
            session()->flash('alert', [
                'type' => 'error',
                'message' => 'Terjadi Kesalahan Signature',
                'title' => 'Oppss!'
            ]);
            return response()->json([
                'message' => 'Invalid signature'
            ], 400);
        }

        $transaksi = TopupModels::where('id_transaksi', $request->order_id)->first();
        if ($transaksi) {
            if ($request->transaction_status == 'settlement') {
                $transaksi->status = 1;
                $transaksi->payment = $request->payment_type | "Transfer";
                $transaksi->status_label = 'Paid';
                $this->topup($transaksi->user_id, $transaksi->nominal);
            } else if ($request->transaction_status == 'cancel') {
                $transaksi->status = 2;
                $transaksi->payment = $request->payment_type | "Transfer";
                $transaksi->status_label = 'Cancel';
            } else if ($request->transaction_status == 'expire') {
                $transaksi->status = 3;
                $transaksi->payment = $request->payment_type | "Transfer";
                $transaksi->status_label = 'Kadaluarsa';
            } else if ($request->transaction_status == 'pending') {
                $transaksi->status = 0;
                $transaksi->payment = $request->payment_type | "Transfer";
                $transaksi->status_label = 'Pending';
            } else {
                return response()->json([
                    'message' => 'Status tidak valid'
                ], 400);
            }
            $transaksi->data_pay = json_encode($data);
            $transaksi->update();
        }
        return response()->json($transaksi, 201);
    }

    public function tested(Request $request) {
        return response()->json([
            'message' => $request->all()
        ], 200);
    }
}
