@php
    use App\Helpers\RZWHelper;
@endphp

@extends('panel.layout')

@section('title', 'Manage Users')

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
                    <h3 class="mb-0">Users Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Users Management
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Users Management</h3>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 10px">No</th>
                            <th style="width: 10px">ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Saldo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                        
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td class="text-center">Rp {{ RZWHelper::FormatNumber($item->saldo) }}</td>
                                <td class="text-center">
                                    <a href="{{ route("users.edit", $item->id) }}" class="btn btn-warning">Edit</a>
                                    @if ($item->id !== Auth::user()->id)
                                    <button class="btn btn-danger" onclick="HapusUser('{{ $item->name }}', '{{ $item->id }}')">Hapus</button>
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
        function HapusUser(name, id) {
            Swal.fire({
                title: "Apakah Kamu Yakin?",
                text: "Kamu Yaking Ingin Menghapus User " + name,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                window.location.href = `{{ url('users/delete/${id}') }}`;
            });
        }
    </script>
@endsection