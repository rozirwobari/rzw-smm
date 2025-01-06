<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ApiModels;

class irvankede extends Controller
{

    public function __construct()
    {
        $apimodels = new ApiModels();
        $irvankede = $apimodels::where('name', 'irvankede')->first();
        $this->irvankede = $irvankede;
        $this->api_key = $irvankede->api_key;
        $this->api_id = $irvankede->secret_key;
        $this->host = $irvankede->host;
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
            'api_key' => $this->api_key,
            'action' => 'status',
            'secret_key' => $this->secret_key,

            'id' => $id_order,
        ];
        $response = Http::asForm()->post('https://buzzerpanel.id/api/json.php', $data);
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
