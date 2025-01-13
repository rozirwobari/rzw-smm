<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\api\buzzerpanel;
use Illuminate\Support\Facades\Validator;
use App\Models\TopupModels;
use Illuminate\Support\Facades\Auth;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\WebSettingModel;

class TopupController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', true);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $website = WebSettingModel::first();
        return view('panel.content.topup', compact('website'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function topup(Request $request)
    {
        $jumlah = $request->jumlah;
        $topupModels = new TopupModels();
        $id_transaksi = "TOPUP" . rand() . time();
        try {
            $validasi = Validator::make($request->all(), [
                'jumlah' => 'required|numeric|min:10000',
            ],[
                'jumlah.required' => 'Jumlah tidak boleh kosong',
                'jumlah.numeric' => 'Jumlah harus berupa angka',
                'jumlah.min' => 'Jumlah minimal Rp 10.000',
            ]);

            if ($validasi->fails()) {
                // return redirect()->back()->withErrors($validasi)->withInput();
                return response()->json([
                    'status' => false,
                    'message' => $validasi->errors()->first(),
                ], 200);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $id_transaksi,
                    'gross_amount' => $jumlah,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'item_details' => [
                    [
                        'id' => 'topup',
                        'price' => (int)$jumlah,
                        'quantity' => 1,
                        'name' => "Topup RZW Panel"
                    ]
                ],
            ];
            // dd($params);
            
            $snapToken = Snap::getSnapToken($params);

            $topupModels->user_id = Auth::user()->id;
            $topupModels->id_transaksi = $id_transaksi;
            $topupModels->nominal = $jumlah;
            $topupModels->snaptoken = $snapToken;
            $topupModels->save();

            return response()->json([
                'status' => true,
                'data' => [
                    'id_transaksi' => $id_transaksi,
                ]
            ], 200);
            // return redirect()->route('topup.transaksi', $id_transaksi);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function transaksi($id_transaksi)
    {
        $transaksi = TopupModels::where('id_transaksi', $id_transaksi)->first();
        if ($transaksi) {
            $website = WebSettingModel::first();
            return view('panel.content.topup_transaksi', compact('transaksi', 'website'));
        } else {
            return redirect()->back()->with('alert', [
                'type' => 'danger',
                'description' => 'Transaksi Tidak Ditemukan',
                'title' => 'Ops!'
            ]);
        }
    }

    public function topupHistory()
    {
        $website = WebSettingModel::first();
        $topup = TopupModels::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('panel.content.topup_riwayat', compact('topup', 'website'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
