@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-md-6 col-sm-10 col-12">
        <div class="card shadow-sm mb-3">
            <form action="{{ $action }}" method="post" data-request="ajax"
                data-success-callback="{{ route('update-profile') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Nama" autocomplete="off"
                            value="{{ $user->name }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off"
                            value="{{ $user->username }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="text" name="email" class="form-control" placeholder="Email" autocomplete="off"
                            value="{{ $user->email }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Alamat <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" id="address" cols="30" rows="3">{{ $user->address }}</textarea>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary waves-effect wafes-primary mx-1" type="submit"><i
                            class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
