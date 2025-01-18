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
                            <th>Status</th>
                            <th>Tgm Pemesanan</th>
                            <th>Action</th>
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
                                <td class="text-center">{{ RZWHelper::FormatTanggal($item->created_at) }}</td>
                                <td class="text-center">{{ RZWHelper::FormatNumber($datas['jumlah']) }}</td>

                                @php
                                    $statusClass = '';
                                    $status = RZWHelper::APICheckOrderIrvanKede($item->api_orderid)['data']['status'];
                                    switch ($status) {
                                        case 'Success':
                                            $statusClass = 'text-bg-success';
                                            break;
                                        case 'Pending':
                                            $statusClass = 'text-bg-warning';
                                            break;
                                        case 'Processing':
                                        case 'In progress':
                                            $statusClass = 'rzw-bg-purple';
                                            break;
                                        case 'Partial':
                                        case 'Error':
                                            $statusClass = 'text-bg-danger';
                                            break;
                                        default:
                                            $statusClass = 'text-bg-secondary';
                                            break;
                                    }
                                @endphp
                                <td class="text-center">
                                    <span class="badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#{{ $item->id_transaksi }}">
                                        Detail
                                    </button>


                                    <div class="modal fade" id="{{ $item->id_transaksi }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="{{ $item->id_transaksi }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="{{ $item->id_transaksi }}">Detail Pesanan
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="mb-3 text-start">
                                                            <label for="exampleInputEmail1" class="form-label fw-bold">ID Transaksi</label>
                                                            <textarea class="form-control" readonly>{{ $item->id_transaksi }}</textarea>
                                                        </div>
                                                        <div class="mb-3 text-start">
                                                            <label for="exampleInputEmail1" class="form-label fw-bold">Category</label>
                                                            <textarea class="form-control" readonly>{{ $layanan['category'] }}</textarea>
                                                        </div>
                                                        <div class="mb-3 text-start">
                                                            <label for="exampleInputEmail1" class="form-label fw-bold">Layanan</label>
                                                            <textarea class="form-control" readonly>{{ $layanan['name'] }}</textarea>
                                                        </div>
                                                        <div class="mb-3 text-start">
                                                            <label for="exampleInputEmail1" class="form-label fw-bold">Target</label>
                                                            <textarea class="form-control" readonly>{{ $datas['target'] }}</textarea>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>
@endsection
