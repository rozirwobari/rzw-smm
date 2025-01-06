<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\api\buzzerpanel;
use App\Http\Controllers\api\irvankede;
use App\Models\ApiModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\TransaksiModels;
use App\Helpers\RZWHelper;
use Illuminate\Support\Str;
use App\Models\User;
use App\Jobs\TransaksiUpdate;

class OrderController extends Controller
{
    private $buzzerpanel;
    private $DataBuzzerpanel;
    private $DataIrvanKede;

    public function __construct()
    {
        $this->buzzerpanel = new buzzerpanel();
        $this->irvankede = new irvankede();
        $this->DataBuzzerpanel = $this->buzzerpanel->GetLayanan();
        $this->DataIrvanKede = $this->irvankede->GetLayanan();
    }

    private function GenerateIdTransaksi($length = 15)
    {
        // Menggunakan Str::random untuk menghasilkan string acak, bisa disesuaikan panjangnya
        $randomString = Str::random($length);  // 8 karakter acak (huruf dan angka)
        
        // Menambahkan angka acak ke dalam string
        $randomNumber = rand(1000, 9999);  // Angka acak 4 digit
        
        // Menggabungkan string acak dan angka
        $transactionId = strtoupper($randomString . $randomNumber); // Mengubah menjadi huruf besar
        
        return $transactionId;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->DataBuzzerpanel;
        return view('panel.content.orders', compact('data'));
    }

    /**
     * Display a listing of the resource.
     */
    public function layanan2()
    {
        $data = $this->DataIrvanKede;
        $kurs = $this->irvankede->GetKurs();
        return view('panel.api.irvenkede.order', compact('data', 'kurs'));
    }

    public function StoreLayanan2(Request $request)
    {
        $id_layanan = $request->layanan;
        $target = $request->target;
        $jumlah = $request->jumlah;

        try {
            $validated = $request->validate([
                'layanan' => 'required',
                'target' => 'required',
            ],[
                'layanan.required' => 'Layanan harus dipilih',
                'target.required' => 'Target harus diisi',
            ]);

            $data = collect($this->DataIrvanKede['data']);
            $layanan = $data->firstWhere('id', $id_layanan);
            try {
                $validated = $request->validate([
                    'jumlah' => 'required|numeric|min:' . $layanan['min'] . '|max:' . $layanan['max'],
                ],[
                    'jumlah.required' => 'Jumlah harus diisi',
                    'jumlah.numeric' => 'Jumlah harus berupa angka',
                    'jumlah.min' => 'Jumlah minimal ' . $layanan['min'],
                    'jumlah.max' => 'Jumlah maksimal ' . $layanan['max'],
                ]);

                $priceReal = $layanan['price'] / 1000;
                $kurs = $this->irvankede->GetKurs();
                $total_kurs = ceil($priceReal * $jumlah) * $kurs;
                $total_harga = ceil($priceReal * $jumlah) + $total_kurs;

                if (Auth::user()->saldo < $total_harga) {
                    return redirect()->back()->with('alert', [
                        'type' => 'error',
                        'description' => 'Saldo Tidak Cukup, Silahkan Topup',
                        'title' => 'Oppss',
                    ]);
                }

                $responseirvankede = $this->irvankede->CreateLayanan($id_layanan, $target, $jumlah);
                if (!$responseirvankede['status']) {
                    return redirect()->back()->with('alert', [
                        'type' => 'error',
                        'description' => 'Order Gagal, Silahkan Coba Lagi Nanti',
                        'title' => 'Oppss',
                    ]);
                }

                TransaksiModels::create([
                    'user_id' => Auth::user()->id,
                    'id_transaksi' => $this->GenerateIdTransaksi(),
                    'nominal' => $total_harga,
                    'api_orderid' => $responseirvankede['data']['id'],
                    'status_checked_at' => now(),
                    'layanan' => 'Layanan 2',
                    'data' => json_encode([
                        'layanan' => $layanan,
                        'target' => $target,
                        'jumlah' => $jumlah,
                    ]),
                ]);


                $user = User::find(Auth::user()->id);
                $user->saldo -= $total_harga;
                $user->save();

                return redirect()->route('orders')->with('alert', [
                    'type' => 'success',
                    'description' => 'Order Berhasil',
                    'title' => 'Berhasil',
                ]);

            } catch (ValidationException $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function ShowLayanan2()
    {
        $job = new TransaksiUpdate();
        $job->dispatch();

        $transaksi = TransaksiModels::query()->where('user_id', Auth::id())->where('layanan', 'layanan 2')->latest()->get();
        return view('panel.content.orders_riwayat', compact('transaksi'));
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
        $id_layanan = $request->layanan;
        $target = $request->target;
        $jumlah = $request->jumlah;

        try {
            $validated = $request->validate([
                'layanan' => 'required',
                'target' => 'required',
            ],[
                'layanan.required' => 'Layanan harus dipilih',
                'target.required' => 'Target harus diisi',
            ]);

            $data = collect($this->DataBuzzerpanel['data']);
            $layanan = $data->firstWhere('id', $id_layanan);

            try {
                $validated = $request->validate([
                    'jumlah' => 'required|numeric|min:' . $layanan['min'] . '|max:' . $layanan['max'],
                ],[
                    'jumlah.required' => 'Jumlah harus diisi',
                    'jumlah.numeric' => 'Jumlah harus berupa angka',
                    'jumlah.min' => 'Jumlah minimal ' . $layanan['min'],
                    'jumlah.max' => 'Jumlah maksimal ' . $layanan['max'],
                ]);

                $priceReal = $layanan['price'] / 1000;
                $total_harga = ceil($priceReal * $jumlah);

                if (Auth::user()->saldo < $total_harga) {
                    return redirect()->back()->with('alert', [
                        'type' => 'error',
                        'description' => 'Saldo Tidak Cukup, Silahkan Topup',
                        'title' => 'Oppss',
                    ]);
                }

                $responseBuzzerpanel = $this->buzzerpanel->CreateLayanan($id_layanan, $target, $jumlah);
                if (!$responseBuzzerpanel['status']) {
                    return redirect()->back()->with('alert', [
                        'type' => 'error',
                        'description' => 'Order Gagal, Silahkan Coba Lagi Nanti',
                        'title' => 'Oppss',
                    ]);
                }

                TransaksiModels::create([
                    'user_id' => Auth::user()->id,
                    'id_transaksi' => $this->GenerateIdTransaksi(),
                    'nominal' => $total_harga,
                    'api_orderid' => $responseBuzzerpanel['data']['id'],
                    'status_checked_at' => now(),
                    'layanan' => 'Layanan 1',
                    'data' => json_encode([
                        'layanan' => $layanan,
                        'target' => $target,
                        'jumlah' => $jumlah,
                    ]),
                ]);


                $user = User::find(Auth::user()->id);
                $user->saldo -= $total_harga;
                $user->save();

                return redirect()->route('orders')->with('alert', [
                    'type' => 'success',
                    'description' => 'Order Berhasil',
                    'title' => 'Berhasil',
                ]);

            } catch (ValidationException $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $job = new TransaksiUpdate();
        $job->dispatch();

        $transaksi = TransaksiModels::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('panel.content.orders_riwayat', compact('transaksi'));
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
