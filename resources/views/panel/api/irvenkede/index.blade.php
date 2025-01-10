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
        <form action="{{ route('irvankede.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="api_key" class="form-label">API Key</label>
                    <input type="text" class="form-control @error('api_key') is-invalid @enderror" id="api_key"
                        name="api_key" placeholder="Nama Website" value="{{ $website->api_key }}">
                    @error('api_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="secret_key" class="form-label">API Id</label>
                    <input type="text" class="form-control @error('secret_key') is-invalid @enderror" id="secret_key"
                        name="secret_key" placeholder="Nama Website" value="{{ $website->secret_key }}">
                    @error('secret_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="host" class="form-label">Host</label>
                    <input type="text" class="form-control @error('host') is-invalid @enderror" id="host" name="host"
                        placeholder="Nama Website" value="{{ $website->host }}">
                    @error('host')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="convert" class="form-label">Gain (%)</label>
                    <input type="text" class="form-control @error('convert') is-invalid @enderror" id="convert" name="convert" min="0" max="100"
                        placeholder="Selisih Diperloeh (%) MAX 100%" value="{{ ($website->convert * 100) }}">
                    @error('convert')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @if (isset($website->api_key) && isset($website->host))
                <div class="mb-3">
                    <label for="saldo" class="form-label">Saldo API</label>
                    <input type="text" class="form-control @error('saldo') is-invalid @enderror" id="saldo" name="saldo"
                        placeholder="Saldo API" readonly>
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

@section('js')
@if (isset($website->api_key) && isset($website->host))
<script>
    function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            fetch(`{{ $website->host }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        api_key: `{{ $website->api_key }}`,
                        api_id: `{{ $website->secret_key }}`
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        data.currency = "IDR"
                        document.querySelector('#saldo').value = `${formatNumber(data.data.balance)} ${data.currency}`;
                    } else {
                        document.querySelector('#saldo').value = `Tidak Diketahui`;
                    }
                })
                .catch(error => console.error(error));
</script>
@endif
@endsection