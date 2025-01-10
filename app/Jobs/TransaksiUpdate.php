<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\TransaksiModels;
use App\Helpers\RZWHelpers;
use App\Http\Controllers\api\buzzerpanel;
class TransaksiUpdate implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transactions = TransaksiModels::whereNull('status')
            ->orWhere('status_checked_at', '<', now()->subMinutes(5))
            ->get();
            
        foreach ($transactions as $transaction) {
            try {
                $buzzerpanel = new buzzerpanel();
                $response = $buzzerpanel->CheckOrder($transaction->api_orderid);
                if (isset($response['data']['status'])) {
                    $transaction->update([
                        'status' => $response['data']['status'],
                        'status_checked_at' => now()
                    ]);
                }
            } catch (\Exception $e) {
                print("Gagal Update Status : " . $e->getMessage());
            }
            sleep(3);
        }
    }
}
