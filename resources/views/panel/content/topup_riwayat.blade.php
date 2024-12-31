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

    <div class="container">
        <div class="text-center card p-4 my-4">
            <h4 class="align-items-center">Total Saldo <span class="text-success fw-bold">Rp {{ RZWHelper::FormatNumber(Auth::user()->saldo) }}</span></h4>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10 d-flex align-items-center">
                        <h3 class="card-title">Riwayat Order</h3>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-primary" onclick="Topup()">TopUp</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 10px">No</th>
                            <th>ID Transaksi</th>
                            <th>Jumlah</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topup as $item)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $item->id_transaksi }}</td>
                                <td class="text-center">Rp {{ RZWHelper::FormatNumber($item->nominal) }}</td>
                                <td class="text-center">{{ RZWHelper::FormatTanggal($item->created_at) }}</td>
                                @php
                                    $status = '';
                                    $statusClass = '';
                                    switch ($item->status) {
                                        case 0:
                                            $status = 'Pending';
                                            $statusClass = 'text-bg-warning';
                                            break;
                                        case 1:
                                            $status = 'Berhasil';
                                            $statusClass = 'text-bg-success';
                                            break;
                                        case 2:
                                            $status = 'Gagal';
                                            $statusClass = 'text-bg-danger';
                                            break;
                                        default:
                                            $status = 'Tidak Diketahui';
                                            $statusClass = 'text-bg-secondary';
                                            break;
                                    }
                                @endphp
                                <td class="text-center">
                                    <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('topup.transaksi', $item->id_transaksi) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
                                    @if ($item->status == 0 && $item->snaptoken != null)
                                        <button onclick="Payment('{{ $item->snaptoken }}')"
                                            class="btn btn-sm btn-success">Bayar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>
@endsection

@section('js')
    <script>
        function Payment(snaptoken) {
            snap.pay(snaptoken, {
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



        function Topup() {
            Swal.fire({
                title: "Masukan Jumlah Topup",
                input: "number",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: "Topup",
                showLoaderOnConfirm: true,
                preConfirm: async (jumlah) => {
                    try {
                        const response = await fetch(`{{ url('topup') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                // Tambahkan CSRF token untuk Laravel
                                'X-CSRF-TOKEN': `{{ csrf_token() }}`,
                            },
                            body: JSON.stringify({
                                jumlah: jumlah,
                            })
                        });

                        const data = await response.json();
                        if (!data.status) {
                            return Swal.showValidationMessage(data.message);
                        }
                        return data;
                    } catch (error) {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((data) => {
                data = data.value;
                console.log('Response data:', data);
                if (data.status) {
                    window.location.href = `{{ url('topup/transaksi') }}/${data.data.id_transaksi}`;
                }
            });
        }
    </script>
@endsection
