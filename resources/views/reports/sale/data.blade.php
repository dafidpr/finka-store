<div class="mt-5">
    <h3 class="text-center">Laporan Penjualan</h3>
    <p class="text-center">Periode : {{ $dateStart . 's/d' . $dateEnd }}</p>
    @php
        $total = 0;
    @endphp
    @foreach ($data as $transaction)
        @php
            $total += $transaction->saleDetail->sum('subtotal');
        @endphp
        <div class="border shadow-sm mt-3 py-4 px-3">
            <div class="row">
                <div class="col-md-6">
                    <table class="mb-4">
                        <tr>
                            <td width="40%">Kode Transaksi</td>
                            <td width="6%">:</td>
                            <td>{{ $transaction->code }}</td>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <td>:</td>
                            <td>{{ $transaction->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="mb-4">
                        <tr>
                            <td width="60%">Customer</td>
                            <td width="6%">:</td>
                            <td>{{ $transaction->customer }}</td>
                        </tr>
                        <tr>
                            <td>Pembayaran</td>
                            <td>:</td>
                            <td>{{ $transaction->payment_method == 'cash' ? 'Cash' : 'Transfer' }}</td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>:</td>
                            <td>{{ $transaction->description == null ? '-' : $transaction->description }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <table class="table align-middle datatable dt-responsive table-check nowrap" id="sale-class-table"
                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                <thead class="table-light">
                    <tr>
                        <th width="3%">No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="sale-body">
                    @foreach ($transaction->saleDetail as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product }}</td>
                            <td>Rp. {{ number_format($item->price) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp. {{ number_format($item->subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="4" class="text-center"><strong>TOTAL</strong></td>
                        <td><strong> Rp. {{ number_format($transaction->saleDetail->sum('subtotal')) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach
    <div class="border shadow-sm mt-3 py-4 px-3">
        <div class="row">
            <div class="col-md-4">
                <h4>Total Penjualan</h4>
            </div>
            <div class="col-md-8">
                <h4 style="text-align:right" id="total">Rp.
                    {{ number_format($total) }}</h4>
            </div>
        </div>
    </div>
</div>
