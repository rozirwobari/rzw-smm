@php
    use App\Helpers\RZWHelper;
@endphp

@extends('panel.layout')

@section('title', 'Transaksi')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Topup</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Topup
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="container mt-5">
        <div class="text-start mb-3">
            <a href="{{ route('topup') }}" class="btn btn-sm btn-warning">Kembali</a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="mb-3">From:</h6>
                        <div><strong>{{ Auth::user()->name }}</strong></div>
                        <div>Email: {{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <h6>Invoice Number: {{ $transaksi->id_transaksi }}</h6>
                    </div>
                    <div class="col-sm-6">
                        <h6>Date: {{ date('d/m/Y', strtotime($transaksi->created_at)) }}</h6>
                    </div>
                </div>

                <div class="table-responsive-sm mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-end">Rate</th>
                                <th class="text-end">Total Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Topup RZW Panel</td>
                                <td class="text-end">{{ RZWHelper::FormatNumber($transaksi->nominal) }}</td>
                                <td class="text-end">Rp 1</td>
                                <td class="text-end">Rp {{ RZWHelper::FormatNumber($transaksi->nominal) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                <td class="text-end">Rp {{ RZWHelper::FormatNumber($transaksi->nominal) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td class="text-end"><strong>Rp {{ RZWHelper::FormatNumber($transaksi->nominal) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @if ($transaksi->status == 0)
                    <div class="row text-center mt-4">
                        <div class="col-12">
                            <button type="button" onclick="Payment()" class="btn btn-primary w-50">Bayar</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        function Payment() {
            snap.pay('{{ $transaksi->snaptoken }}', {
                // Optional
                onSuccess: function(result) {
                    window.location.reload();
                },
                // Optional
                onPending: function(result) {
                    window.location.reload();
                },
                // Optional
                onError: function(result) {
                    window.location.reload();
                }
            });
        }
    </script>
@endsection
