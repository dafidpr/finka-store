@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">Overview</li>
    </ol>
@endsection

@section('content')
    <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
        <i class="mdi mdi-alert-circle-outline label-icon"></i><strong>Selamat Datang {{ Auth::user()->name }} </strong> -
        di
        Aplikasi Penjulan Finka Store
    </div>
    <div class="row mt-5">
        <!-- end col -->
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <!-- card -->
                    <div class="card card-h-100">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <h5 class="card-title me-2">Grafik Penjualan Tahun {{ date('Y') }}</h5>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-sm">
                                    <div id="sales-chart" data-colors='["#5156be", "#34c38f"]' class="apex-charts">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end col -->
    </div> <!-- end row-->
@endsection
