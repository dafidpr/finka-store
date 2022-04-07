@extends('layouts.ajax')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-toggle="ajax">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
@endsection

@section('content')
    <div class="col-12">
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="card-title">Total Penjualan</h4>
                    </div>
                    <div class="col-md-8">
                        @if (isset($transaction) && isset($transactionChildren))
                            <h4 style="text-align:right" id="total">Rp.
                                {{ number_format($transaction->saleDetail->sum('subtotal')) }}</h4>
                        @else
                            <h4 style="text-align:right" id="total">Rp. 0</h4>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ $action }}" method="post" data-request="ajax"
                    data-success-callback="{{ route('sales') }}" id="payment-form">
                    @csrf

                    <div class="table-responsive">
                        <table class="table align-middle datatable dt-responsive table-check nowrap"
                            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                            <thead class="table-light">
                                <th width="400">Nama Barang</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Sub Total</th>
                                <th></th>
                            </thead>
                            <tbody id="addRenderColumn">
                                @if (isset($transaction) && isset($transactionChildren))
                                    @foreach ($transactionChildren as $value)
                                        <input type="text" name="transaction_child_id[]" class="form-control" hidden
                                            value="{{ $value->hashid }}" id="transaction-child-id-{{ $value->hashid }}">
                                        <tr id="firstColumn">
                                            <td class="input-name">
                                                <input type="text" name="name[]" class="form-control"
                                                    placeholder="Nama Barang" autocomplete="off"
                                                    value="{{ $value->product }}">
                                            </td>
                                            <td class="input-price">
                                                <input type="text" name="price[]" class="form-control price autonumeric"
                                                    placeholder="0" autocomplete="off" value="{{ $value->price }}">
                                            </td>
                                            <td class="input-qty">
                                                <input type="number" name="qty[]" class="form-control qty" placeholder="0"
                                                    autocomplete="off" value="{{ $value->quantity }}">
                                            </td>
                                            <td class="input-subtotal">
                                                <input type="text" name="subtotal[]" readonly class="form-control subtotal"
                                                    placeholder="0" autocomplete="off" value="{{ $value->subtotal }}">
                                            </td>
                                            <td class="button-form">
                                                <button class="btn btn-danger waves-effect waves-light removeColumn"
                                                    data-transaction-child-id="{{ $value->hashid }}" type="button"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr id="firstColumn">
                                        <td class="input-name">
                                            <input type="text" name="name[]" class="form-control"
                                                placeholder="Nama Barang" autocomplete="off" value="">
                                        </td>
                                        <td class="input-price">
                                            <input type="text" name="price[]" class="form-control price autonumeric"
                                                placeholder="0" autocomplete="off" value="0">
                                        </td>
                                        <td class="input-qty">
                                            <input type="number" name="qty[]" class="form-control qty" placeholder="0"
                                                autocomplete="off" value="">
                                        </td>
                                        <td class="input-subtotal">
                                            <input type="text" name="subtotal[]" readonly class="form-control subtotal"
                                                placeholder="0" autocomplete="off" value="">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger waves-effect waves-light removeColumn"
                                                type="button"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="row mb-3">
                        <div class="col-8">
                            <button class="btn btn-pill btn-primary" id="addForm" type="button"><i
                                    class="fa fa-plus"></i> Tambah Form</button>
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <button class="btn btn-primary payment" data-bs-toggle="modal"
                            data-bs-target="#payment-confirmation-modal" type="button"><i class="fa fa-paper-plane"></i>
                            Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('sales.confirm_modal')
@endsection
