@extends('panel.layout')

@section('title', 'Website Settings')

@section('content')
<div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
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
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="container">
        <div class="card card-primary card-outline mb-4"> <!--begin::Header-->
            <form action="{{ route('website.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="web_name" class="form-label">Website Name</label>
                        <input type="text" class="form-control @error('web_name') is-invalid @enderror" id="web_name" name="web_name"
                            placeholder="Nama Website" value="{{ $website->name }}">
                        @error('web_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Nama Website">{{ $website->deskripsi }}</textarea>
                        @error('deskripsi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" placeholder="Logo Website">
                        @error('logo')
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
