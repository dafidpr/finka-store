<!DOCTYPE html>
<html>

<head>
    <title>POS (Point Of Sales) Version 1.0.0</title>
    <style>
        .dotted {
            border: 1px dotted #292828;
            border-style: none none dotted;
            color: #fff;
            background-color: #fff;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

    </style>
</head>

<body style="width: 76mm; margin:auto">
    <div id="wrapper">
        <p style="text-align: center; font-size: 20px; line-height: 0.2em;"><b>Finka Store</b></p>
        <p style="text-align: center; font-size: 15px; line-height: 0.2em;">Jl. Pemuda No. 23 Dsn. Kemiri, </p>
        <p style="text-align: center; font-size: 15px; line-height: 0.2em;">Ds. Kemiri, RT 02 RW. 01,</p>
        <p style="text-align: center; font-size: 15px; line-height: 0.2em;">Kec. Singojuruh, Banyuwangi</p>
        <p style="text-align: center; font-size: 15px; line-height: 0.2em;">0812-4664-3098</p>
        <hr class='dotted' />
        <table style="font-size: 15px; width: 40%;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ $sale->created_at }}</td>
            </tr>
            <tr>
                <td>No. Nota</td>
                <td>:</td>
                <td>{{ $sale->code }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>:</td>
                <td>{{ ucfirst($sale->customer) }}</td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>:</td>
                <td>{{ ucfirst($sale->user->name) }}</td>
            </tr>
            <tr>
                <td>Pembayaran</td>
                <td>:</td>
                <td>{{ ucfirst($sale->payment_method == 'cash' ? 'Cash' : 'Transfer') }}</td>
            </tr>
        </table>
        <hr class='dotted' />
        <div style="font-size: 15px;">
            <table style="100%">
                @foreach ($sale->saleDetail as $item)
                    <tr>
                        <td colspan="3">
                            <label for="" style="font-weight: bold">{{ $item->product }}</label>
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $item->quantity }} x </td>
                        <td> Rp. {{ number_format($item->price) }}</td>
                        <td style="text-align: right;" width="163"> Rp. {{ number_format($item->subtotal) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <hr class='dotted' />
        <table width="100%" style="font-size: 15px;">
            {{-- <tr>
                <td>Diskon</td>
                <td style="text-align: right">Rp. {{ number_format($sale->discount) }}</td>
            </tr> --}}
            <tr>
                <td>Total</td>
                <td style="text-align: right">Rp. {{ number_format($sale->saleDetail->sum('subtotal')) }}</td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td style="text-align: right">Rp. {{ number_format($sale->pay) }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td style="text-align: right">Rp. {{ number_format($sale->pay_return) }}</td>
            </tr>
        </table>
        <hr class='dotted' />


        <center>
            <p style="text-align: center; font-size: 15px;">TERIMA KASIH</p>
            <p style="text-align: center; font-size: 15px;">BARANG YANG SUDAH DIBELI TIDAK DAPAT DITUKAR / DIKEMBALIKAN
            </p>
        </center>

        <script>
            window.print()
        </script>
</body>

</html>
