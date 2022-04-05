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
                data-success-callback="{{ route('update-password') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="">Password Lama <span class="text-danger">*</span></label>
                        <input type="password" name="old_password" class="form-control" placeholder="Password Lama"
                            autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control" placeholder="Password Baru"
                            autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Confirm Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_new_password" class="form-control"
                            placeholder="Confirm Password Baru" autocomplete="off">
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
