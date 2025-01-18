@php
    use App\Helpers\RZWHelper;
@endphp

@extends('panel.layout')

@section('css')
    <style>
        .rzw-bg-purple {
            color: #fff !important;
            background-color: #6658DD !important;
        }
    </style>
@endsection

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Riwayat Order</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Riwayat Order
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Riwayat Order</h3>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 10px">No</th>
                            <th class="text-start">Category</th>
                            <th class="text-start">Layanan</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Tgl Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $item)
                            @php
                                $datas = json_decode($item->data, true);
                                $layanan = $datas['layanan'];
                            @endphp
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $layanan['category'] }}</td>
                                <td>{{ $layanan['name'] }}</td>
                                <td class="text-center">Rp {{ RZWHelper::FormatNumber($item->nominal) }}</td>
                                <td class="text-center">{{ RZWHelper::FormatNumber($datas['jumlah']) }}</td>
                                <td class="text-center">{{ RZWHelper::FormatTanggal($item->created_at) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>
@endsection
