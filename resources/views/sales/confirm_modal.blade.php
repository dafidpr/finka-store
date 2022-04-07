<div class="modal fade" id="payment-confirmation-modal" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ $action }}" method="post" id="payment-confirm-form"
                data-success-callback="{{ route('sales') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="customer">Customer</label>
                                <input type="text" name="customer" class="form-control" id="customer"
                                    placeholder="Customer / Pelanggan" autocomplete="off"
                                    value="{{ isset($transaction) ? $transaction->customer : 'Umum' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="grand-total-sale">Grand Total</label>
                                <input type="text" name="grand_total_sale" class="form-control" id="grand-total-sale"
                                    placeholder="Grand Total Penjualan" autocomplete="off" readonly
                                    value="{{ isset($transaction) ? $transaction->saleDetail->sum('subtotal') : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="payment-method">Metode Pembayaran </label>
                            <select name="payment_method" class="form-control" id="payment-method">
                                <option value="cash"
                                    {{ isset($transaction) && $transaction->payment_method == 'cash' ? 'selected' : '' }}>
                                    Cash</option>
                                <option value="transfer"
                                    {{ isset($transaction) && $transaction->payment_method == 'transfer' ? 'selected' : '' }}>
                                    Transfer</option>
                            </select>
                            {{-- <div class="form-group mb-2">
                                <label for="discount-sale">Diskon</label>
                                <input type="text" name="discount" class="form-control autonumeric" id="discount-sale"
                                    placeholder="Diskon Penjualan" autocomplete="off"
                                    value="{{ isset($transaction) ? $transaction->discount : '' }}">
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="total-sale">Total</label>
                                <input type="text" name="total" class="form-control" id="total-sale"
                                    placeholder="Total Penjualan" autocomplete="off" readonly
                                    value="{{ isset($transaction) ? $transaction->saleDetail->sum('subtotal') - $transaction->discount : '' }}">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group mb-2">
                        <label for="payment-method">Metode Pembayaran </label>
                        <select name="payment_method" class="form-control" id="payment-method">
                            <option value="cash"
                                {{ isset($transaction) && $transaction->payment_method == 'cash' ? 'selected' : '' }}>
                                Cash</option>
                            <option value="transfer"
                                {{ isset($transaction) && $transaction->payment_method == 'transfer' ? 'selected' : '' }}>
                                Transfer</option>
                        </select>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="pay-total">Jumlah Bayar <span class="text-danger">*</span></label>
                                <input type="text" name="payment" class="form-control autonumeric" id="pay-total"
                                    placeholder="Jumlah Bayar" autocomplete="off" required
                                    value="{{ isset($transaction) ? $transaction->pay : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="pay-return">Kembali </label>
                                <input type="text" name="pay_return" class="form-control" id="pay-return"
                                    placeholder="Kembalian" autocomplete="off" readonly
                                    value="{{ isset($transaction) ? $transaction->pay_return : '0' }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="pay-return">Catatan </label>
                        <textarea name="description" class="form-control" id="description" cols="30"
                            rows="2">{{ isset($transaction) ? $transaction->description : '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary payment-bt" type="submit"><i class="fa fa-paper-plane"></i>
                        Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
