<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class TransaksiModels extends Model
{
    protected $table = 'transaksi';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
