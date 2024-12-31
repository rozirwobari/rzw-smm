<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class buzzerpanel extends Controller
{

    public function __construct()
    {
        $this->api_key = 'zSIqfR0T5inv8b4ltB13NysYPdDM9A';
        $this->secret_key = '4711kl09exnd4rdx6tfil52puqbotswk9v7hyijmozfg53gjzw';
    }
    /**
     * Display a listing of the resource.
     */
    public function GetLayanan()
    {

        try {
            $data = [
                'api_key' => $this->api_key,
                'action' => 'services',
                'secret_key' => $this->secret_key,
            ];
            $response = Http::asForm()->post('https://buzzerpanel.id/api/json.php', $data);
            $data = $response->json(null, true);
            $datas = $data['data'];
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
                'api_key' => $this->api_key,
                'action' => 'order',
                'secret_key' => $this->secret_key,
    
                'service' => $id_layanan,
                'data' => $data,
                'quantity' => $quantity,
            ];
            $response = Http::asForm()->post('https://buzzerpanel.id/api/json.php', $data);
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
}
