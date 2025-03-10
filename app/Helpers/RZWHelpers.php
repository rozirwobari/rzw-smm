<?php

namespace App\Helpers;
use App\Http\Controllers\api\irvankede;


class RZWHelper
{
    public static function FormatTanggal($date)
    {
        $bulan = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $tgl = date('d', strtotime($date));
        $bln = $bulan[date('n', strtotime($date))];
        $thn = date('Y', strtotime($date));
        $jam = date('H:i:s', strtotime($date));

        return "$tgl $bln $thn | $jam";
    }

    public static function FormatNumber($number)
    {
        return number_format($number, 0, ',', '.');
    }

    public static function APICheckOrderIrvanKede($id_order)
    {
        $irvankede = new irvankede();
        $response = $irvankede->CheckOrder($id_order);
        return $response;
    }
}