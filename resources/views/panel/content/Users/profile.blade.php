@extends('panel.layout')

@section('title', 'Edit User ' . $user->name)

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Users</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Users
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="container">
        <div class="card card-primary card-outline mb-4"> <!--begin::Header-->
            <form action="{{ route('profile.saved', $user->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}"
                            placeholder="Email User" readonly>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}"
                            placeholder="Nama User">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="oldpassword" class="form-label">Password Lama</label>
                        <input type="password" class="form-control @error('oldpassword') is-invalid @enderror" id="oldpassword" name="oldpassword" placeholder="Password Lama">
                        @error('oldpassword')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="newpassword" class="form-label">Password Baru</label>
                        <input type="newpassword" class="form-control @error('newpassword') is-invalid @enderror" id="newpassword" name="newpassword" placeholder="Password Baru">
                        @error('newpassword')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Simpan</button> </div>
            </form>
        </div>
    </div>
@endsection