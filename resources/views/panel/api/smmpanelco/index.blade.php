@php
    use App\Helpers\RZWHelper;
@endphp


@extends('panel.layout')

@section('title', 'Website Settings')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Website Settings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Website Settings
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card card-primary card-outline mb-4">
            <form action="{{ route('smmpanelco.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="apikey" class="form-label">API Key</label>
                        <input type="text" class="form-control @error('apikey') is-invalid @enderror" id="apikey"
                            name="apikey" placeholder="Api Key smmpanel.co" value="{{ $website->api_key ?? '' }}">
                        @error('apikey')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="host" class="form-label">Host</label>
                        <input type="text" class="form-control @error('host') is-invalid @enderror" id="host"
                            name="host" placeholder="Host smmpanel.co" value="{{ $website->host ?? '' }}">
                        @error('host')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="convert" class="form-label">Convert IDR</label>
                        <input type="number" min="1" class="form-control @error('convert') is-invalid @enderror" id="convert"
                            name="convert" placeholder="NilaiConvert IDR" value="{{ $website->convert ?? '1' }}">
                        @error('convert')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (isset($website->api_key) && isset($website->host) && RZWHelper::PanelSmmpanelcoSaldo())
                        <div class="mb-3">
                            <label for="saldo" class="form-label">Saldo API</label>
                            <input type="text" class="form-control @error('saldo') is-invalid @enderror" id="saldo"
                                name="saldo" placeholder="Saldo API" value="{{ RZWHelper::PanelSmmpanelcoSaldo()['balance'] }} {{ RZWHelper::PanelSmmpanelcoSaldo()['currency'] }}" readonly>
                            @error('saldo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary w-50 m-2">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection