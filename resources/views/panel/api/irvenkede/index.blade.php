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
            <form action="{{ route('website.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="apikey" class="form-label">API Key</label>
                        <input type="text" class="form-control @error('apikey') is-invalid @enderror" id="apikey"
                            name="apikey" placeholder="Nama Website" value="{{ $website->apikey }}">
                        @error('apikey')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="host" class="form-label">Host</label>
                        <input type="text" class="form-control @error('host') is-invalid @enderror" id="host"
                            name="host" placeholder="Nama Website" value="{{ $website->host }}">
                        @error('host')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (!isset($website->apikey) && !isset($website->host))
                        <div class="mb-3">
                            <label for="saldo" class="form-label">Saldo API</label>
                            <input type="text" class="form-control @error('saldo') is-invalid @enderror" id="saldo"
                                name="saldo" placeholder="Saldo API" readonly>
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
    @if (!isset($website->apikey) && !isset($website->host))
        <script>
            fetch(`{{ $website->host }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        key: `{{ $website->apikey }}`,
                        action: `balance`
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#saldo').value = `${data.balance} ${data.currency}`;
                })
                .catch(error => console.error(error));
        </script>
    @endif
@endsection
