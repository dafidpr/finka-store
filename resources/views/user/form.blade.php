@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users') }}" data-toggle="ajax">User</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')

    <div class="col-md-6 col-sm-8 col-12">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form action="{{ $action }}" method="post" data-request="ajax"
                    data-success-callback="{{ route('users') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Nama" autocomplete="off"
                            value="{{ isset($values) ? $values->name : '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="">Posisi <span class="text-danger">*</span></label>
                        <input type="text" name="position" class="form-control" placeholder="Posisi" autocomplete="off"
                            value="{{ isset($values) ? $values->position : '' }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="mb-3">
                                <label for="">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    autocomplete="off" value="{{ isset($values) ? $values->email : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="mb-3">
                                <label for="">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" placeholder="Username"
                                    autocomplete="off" value="{{ isset($values) ? $values->username : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="mb-3">
                                <label for="">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    autocomplete="off" {{ isset($values) ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="mb-3">
                                <label for="">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="confirm_password" class="form-control"
                                    placeholder="Confirm Password" autocomplete="off"
                                    {{ isset($values) ? 'disabled' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">Alamat </label>
                        <textarea name="address" id="address" cols="30" class="form-control"
                            rows="2">{{ isset($values) ? $values->address : '' }}</textarea>
                    </div>
                    <hr>
                    <div class="mb-3 text-end">
                        <button class="btn btn-danger" type="button" data-toggle="ajax"
                            data-target="{{ route('users') }}"><i class="fa fa-arrow-left"></i> Kembali</button>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
