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
@endsection
