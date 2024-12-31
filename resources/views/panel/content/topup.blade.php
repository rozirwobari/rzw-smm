@extends('panel.layout')


@section('title', 'Orders')

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
        <div class="card card-primary card-outline mb-4"> <!--begin::Header-->
            <form action="{{ url('topup') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Jumlah</label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" min="1" placeholder="Min Rp 10.000" value="{{ old('jumlah') }}">
                        <span class="text-danger" id="noted_jumlah"></span>
                        @error('jumlah')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Topup</button>
                </div>
            </form>
        </div>
    </div>
@endsection
