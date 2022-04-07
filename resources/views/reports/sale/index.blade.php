@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <form action="{{ $action }}" method="post" id="formSubmit">
        @csrf
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="flatpickr-range form-control digits" type="text" id="daterange"
                                    name="daterange" data-language="en" data-bs-original-title="" title=""
                                    autocomplete="off" required>
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-pill" type="submit"><i class="bx bx-check-circle"></i>
                            Tampilkan
                            Laporan</button>
                    </div>
                    {{-- <div class="col-md-5">
                        <div class="text-end">
                            <button class="btn btn-light btn-pill print-pdf"><i class="bx bxs-file-pdf"></i> Unduh
                                PDF</button>
                        </div>
                    </div> --}}
                </div>
                <div class="row ">
                    <div class="dt-ext mt-4">
                        <div id="content-report">
                        </div>
                        <div class="text-center no-data mt-4">
                            <img src="{{ asset('assets/images/illustrations/report.svg') }}" class="card-img-top" alt=""
                                width="400px" height="400px">
                            <p class="card-text"><small class="text-secondary">Tidak Ada Data</small></p>
                        </div>
                    </div>
                </div>
            </div>
    </form>
@endsection
