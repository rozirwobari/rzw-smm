<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Auth;
use App\Models\ApiModels;
use App\Jobs\TransaksiUpdate;
use App\Models\TransaksiModels;
use App\Models\User;
use Illuminate\Support\Str;

class irvankede extends Controller
{

    public function __construct()
    {
        $apimodels = new ApiModels();
        $this->irvankede = $apimodels;
        $irvankede = $apimodels::where('name', 'irvankede')->first();
        $this->irvankede = $irvankede;
        $this->api_key = $irvankede->api_key;
        $this->api_id = $irvankede->secret_key;
        $this->host = $irvankede->host;
    }

    private function GenerateIdTransaksi($length = 15)
    {
        $randomString = Str::random($length);
        $randomNumber = rand(1000, 9999);
        $transactionId = strtoupper($randomString . $randomNumber);
        return $transactionId;
    }

    public function index()
    {
        $website = ApiModels::where('name', 'irvankede')->first();
        return view('panel.api.irvenkede.index', compact('website'));
    }

    public function update(Request $request)
    {
        $website = ApiModels::where('name', 'irvankede')->first();
        $website->update([
            'api_key' => $request->api_key,
            'secret_key' => $request->secret_key,
            'host' => $request->host,
            'convert' => ($request->convert / 100),
        ]);
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'description' => 'Data Berhasil Diubah',
            'title' => 'Berhasil',
        ]);
    }

    public function LayanaIrvankede()
    {
        $data = $this->GetLayanan();
        $kurs = $this->GetKurs();
        return view('panel.api.irvenkede.order', compact('data', 'kurs'));
    }

    public function ShowIrvanKede()
    {
        $job = new TransaksiUpdate();
        $job->dispatch();

        $transaksi = TransaksiModels::query()->where('user_id', Auth::id())->where('layanan', 'irvankede')->latest()->get();
        return view('panel.api.irvenkede.orders_riwayat', compact('transaksi'));
    }

    public function StoreIrvanKede(Request $request)
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

            $data = collect($this->GetLayanan()['data']);
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
                $kurs = $this->GetKurs();
                $total_kurs = ceil($priceReal * $jumlah) * $kurs;
                $total_harga = ceil($priceReal * $jumlah) + $total_kurs;

                if (Auth::user()->saldo < $total_harga) {
                    return redirect()->back()->with('alert', [
                        'type' => 'error',
                        'description' => 'Saldo Tidak Cukup, Silahkan Topup',
                        'title' => 'Oppss',
                    ]);
                }

                $responseirvankede = $this->CreateLayanan($id_layanan, $target, $jumlah);
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
                    'layanan' => 'irvankede',
                    'data' => json_encode([
                        'layanan' => $layanan,
                        'target' => $target,
                        'jumlah' => $jumlah,
                    ]),
                ]);


                $user = User::find(Auth::user()->id);
                $user->saldo -= $total_harga;
                $user->save();

                return redirect()->route('layanan1.history')->with('alert', [
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
     * Display a listing of the resource.
     */
    public function GetLayanan()
    {

        try {
            $data = [
                'api_id' => $this->api_id,
                'api_key' => $this->api_key,
            ];
            $response = Http::asForm()->post('https://irvankedesmm.co.id/api/services', $data);
            $data = $response->json(null, true);
            $datas = $data['data'];
            $categories = array_column($datas, 'category');
            $uniqueCategories = array_unique($categories);
            $categoryIndexMap = array_flip($uniqueCategories);
            
            foreach ($datas as &$item) {
                $item['category_id'] = (int) $categoryIndexMap[$item['category']];
            }
            
            // dd($datas, $uniqueCategories);
            return [
                'data' => $datas,
                'category' => $uniqueCategories,
            ];
        } catch (\Exception $e) {
            return redirect()->route('panel')->with('alert', [
                'type' => 'error',
                'description' => 'Coba Buka Halaman Kembali',
                'title' => 'Oppss',
            ]);
        }
    }

    public function CreateLayanan($id_layanan, $target, $quantity)
    {
        try {
            $data = [
                'api_id' => $this->api_id,
                'api_key' => $this->api_key,
    
                'service' => $id_layanan,
                'target' => $target,
                'quantity' => $quantity,
            ];
            $response = Http::asForm()->post('https://irvankedesmm.co.id/api/order', $data);
            $data = $response->json(null, true);
            return $data;
        } catch (\Exception $e) {
            return redirect()->route('panel')->with('alert', [
                'type' => 'error',
                'description' => 'Coba Buka Halaman Kembali',
                'title' => 'Oppss',
            ]);
        }
    }

    public function CheckOrder($id_order)
    {
        $data = [
            'api_id' => $this->api_id,
            'api_key' => $this->api_key,

            'id' => $id_order,
        ];
        $response = Http::asForm()->post('https://irvankedesmm.co.id/api/status', $data);
        $data = $response->json(null, true);
        if (!$data['status']) {
            return [
                'data' => [
                    'status' => 'Unknown',
                ]
            ];
        }
        return $data;
    }

    public function GetProfile()
    {
        try {
            $data = [
                'api_id' => $this->api_id,
                'api_key' => $this->api_key,
            ];
            $response = Http::asForm()->post($this->host, $data);
            $data = $response->json(null, true);
            return $data;
        } catch (\Exception $e) {
            return redirect()->route('panel')->with('alert', [
                'type' => 'error',
                'description' => 'Coba Buka Halaman Kembali',
                'title' => 'Oppss',
            ]);
        }
    }

    public function GetKurs()
    {
        return $this->irvankede->convert;
    }
}
