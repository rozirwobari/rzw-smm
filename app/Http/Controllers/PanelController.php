<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TopupModels;
use App\Models\TransaksiModels;

class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $topup = TopupModels::where('user_id', $user->id)->get();
        $transaksi = TransaksiModels::where('user_id', $user->id)->get();
        $transaksiBulanan = $this->TransaksiBulanan($user->id);
        $transaksiMingguan = $this->TransaksiMingguan($user->id);
        // print(json_encode($transaksiMingguan));
        // dd();
        return view('panel.content.index', compact('user', 'topup', 'transaksi', 'transaksiBulanan', 'transaksiMingguan'));
    }


    private function TransaksiBulanan($user_id)
    {
        $transaksi = TransaksiModels::where('user_id', $user_id)
                    ->where('created_at', '>=', date('Y-m-01', strtotime('-5 months')))
                    ->where('created_at', '<=', date('Y-m-t'))
                    ->get();
    
        $transaksiList['name'] = 'Transaksi Bulanan';
    
        $bulanSekarang = date('m');
        $tahunSekarang = date('Y');
    
        $dataBulanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = date('m', strtotime("-$i months"));
            $tahun = date('Y', strtotime("-$i months"));
            $key = $tahun . '-' . $bulan;
    
            $jumlahTransaksi = $transaksi->filter(function ($item) use ($key) {
                return $item->created_at->format('Y-m') === $key;
            })->sum('nominal');
    
            $dataBulanan[] = $jumlahTransaksi;
        }
    
        $transaksiList['data'] = $dataBulanan;
    
        return [$transaksiList];
    }

    private function TransaksiMingguan($user_id)
    {
        $transaksi = TransaksiModels::where('user_id', $user_id)
                    ->whereBetween('created_at', [date('Y-m-d', strtotime('this week')), date('Y-m-d', strtotime('this week +6 days'))])
                    ->get();
    
        $transaksiList['name'] = 'Transaksi Mingguan';
    
        $hariSekarang = date('N');
    
        $dataMingguan = [];
        for ($i = 1; $i <= 7; $i++) {
            $tanggal = date('Y-m-d', strtotime('this week +' . ($i - 1) . ' days'));
    
            $jumlahTransaksi = $transaksi->filter(function ($item) use ($tanggal) {
                return date('Y-m-d', strtotime($item->created_at)) === $tanggal;
            })->sum('nominal');
    
            $dataMingguan[] = $jumlahTransaksi;
        }
    
        $transaksiList['data'] = $dataMingguan;
    
        return [$transaksiList];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
