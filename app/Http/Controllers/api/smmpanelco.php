<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiModels;
use Illuminate\Support\Facades\Http;

class smmpanelco extends Controller
{

    public function __construct()
    {
        $website = ApiModels::where('name', 'smmpanelco')->first();
        if ($website) {
            $this->api_key = $website->api_key;
            $this->secret_key = $website->secret_key;
            $this->host = $website->host;
        }
    }

    public function index()
    {
        $website = ApiModels::where('name', 'smmpanelco')->first();
        return view('panel.api.smmpanelco.index', compact('website'));
    }

    public function update(Request $request)
    {
        $website = ApiModels::where('name', 'smmpanelco')->first();
        $website->update([
            'api_key' => $request->apikey,
            'secret_key' => $request->secret_key,
            'host' => $request->host,
        ]);
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'description' => 'Data Berhasil Diubah',
            'title' => 'Berhasil',
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function GetLayanan()
    {

        try {
            $data = [
                'key' => $this->api_key,
                'action' => 'services',
            ];
            $response = Http::asForm()->post($this->host, $data);
            $datas = $response->json(null, true);
            $categories = array_column($datas, 'category');
            $uniqueCategories = array_unique($categories);
            $categoryIndexMap = array_flip($uniqueCategories);
            
            foreach ($datas as &$item) {
                $item['category_id'] = (int) $categoryIndexMap[$item['category']];
            }
    
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

    public function CreateLayanan($id_layanan, $data, $quantity)
    {

        try {
            $data = [
                'key' => $this->api_key,
                'action' => 'add',

                'service' => $id_layanan,
                'link' => $data,
                'quantity' => $quantity,
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

    public function CheckOrder($id_order)
    {
        $data = [
            'key' => $this->api_key,
            'action' => 'status',

            'order' => $id_order,
        ];
        $response = Http::asForm()->post($this->host, $data);
        $data = $response->json(null, true);
        if (!$data['status']) {
            return [
                'charge' => "0",
                'start_count' => "0",
                'status' => "Unknown",
                'remains' => "0",
                'currency' => "0",
            ];
        }
        return $data;
    }

    public function GetSaldo()
    {
        $data = [
            'key' => $this->api_key,
            'action' => 'balance',
        ];
        $response = Http::asForm()->post($this->host, $data);
        $data = $response->json(null, true);
        if (!isset($data)) {
            return false;
        }
        return $data;
    }
}
