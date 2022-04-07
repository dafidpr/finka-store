@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-12 mb-3 text-end">
        <button class="btn btn-primary" data-toggle="ajax" data-target="{{ route('sales') }}"><i class="fa fa-plus"></i>
            Tambah Transaksi</button>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <table class="table align-middle datatable dt-responsive table-check nowrap"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;" id="dataTable"
                data-url="{{ route('sales.list.getData') }}">
                <thead class="table-light">
                    <th width="5%">No</th>
                    <th>No. Nota</th>
                    <th>Kasir</th>
                    <th>Customer</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Catatan</th>
                    <th></th>
                </thead>
            </table>
        </div>
    </div>
    @include('sale_list.partials.detail')
@endsection
