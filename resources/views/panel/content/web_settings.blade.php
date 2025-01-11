@extends('panel.layout')

@section('title', 'Website Settings')

@section('css')
<style>
    .circle-container {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
    }

    .circle-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .caption {
        text-align: center;
        margin-top: 10px;
        font-family: Arial, sans-serif;
    }
</style>
@endsection

@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
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
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<div class="container">
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <form action="{{ route('website.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="web_name" class="form-label">Website Name</label>
                    <input type="text" class="form-control @error('web_name') is-invalid @enderror" id="web_name"
                        name="web_name" placeholder="Nama Website" value="{{ $website->name }}">
                    @error('web_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="Nama Website">{{ $website->deskripsi }}</textarea>
                    @error('deskripsi')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @isset($website->logo)
                <div class="mb-3 d-flex justify-content-center">
                    <div class="circle-container">
                        <a href="{{ asset($website->logo ) }}" data-lightbox="image-1" data-title="Logo {{  $website->name }}">
                            <img src="{{ asset($website->logo ) }}" alt="Landscape image" class="circle-image">
                        </a>
                    </div>
                </div>
                @endisset
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo"
                        placeholder="Logo Website">
                    @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @isset($website->favicon)
                <div class="mb-3 d-flex justify-content-center">
                    <div class="circle-container">
                        <a href="{{ asset($website->favicon ) }}" data-lightbox="image-1" data-title="Favicon {{  $website->name }}">
                            <img src="{{ asset($website->favicon ) }}" alt="Landscape image" class="circle-image">
                        </a>
                    </div>
                </div>
                @endisset
                <div class="mb-3">
                    <label for="favicon" class="form-label">Favicon</label>
                    <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon"
                        name="favicon" placeholder="Favicon Website">
                    @error('favicon')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary w-50 m-2">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection