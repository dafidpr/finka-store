<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Journal Entry</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        .valid {
            background-color: rgb(218, 193, 55);
        }

        .invalid {
            background-color: rgb(226, 58, 36);
            color: white;
        }

    </style>

</head>

<body>
    @php
        use App\Models\Transaction;
    @endphp
    <div style="text-align: center; font-weight: bold;">JOURNAL ENTRY</div>
    @foreach ($data as $i => $transaction)
        
        <div style="margin-top: 60px;font-size: 15px;">
            <table width="100%" cellspacing="0" cellpadding="4">
                <tr>
                    <td width="20px">Akun</td>
                    <td width="1px">:</td>
                    <td>{{ $transaction->account->name }}</td>
                </tr>
                <tr>
                    <td width="20px">Tanggal</td>
                    <td width="1px">:</td>
                    <td>{{ date('D, d M Y', strtotime($transaction->date)) }}</td>
                </tr>
                <tr>
                    <td width="20px">Keterangan</td>
                    <td width="1px">:</td>
                    <td>{{ $transaction->reference }}</td>
                </tr>
            </table>
        </div>
        <table style="margin-top: 20px" width="100%" border="1" cellspacing="0" cellpadding="5">
            <thead style="background-color: #eaf1dd">
                <tr>
                    <th>Akun</th>
                    <th>Customer / Mitra</th>
                    <th>Keterangan</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $transactionChildren = Transaction::where('sourceable_type', $transaction->sourceable_type)->where('sourceable_id', $transaction->sourceable_id)->where('is_header', false)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->get();
                    $debit = 0;
                    $credit = 0;
                @endphp
                @foreach ($transactionChildren as $item)
                    <tr>
                        <td>{{ $item->account->name }}</td>
                        <td>{{ isset($item->transactionable->salesable->name) ? $item->transactionable->salesable->name : '-' }}
                        </td>
                        <td>{{ isset($item->reference) ? $item->reference : '-' }}</td>
                        <td>Rp.
                            {{ $item->mutation == 'debit' ? number_format($item->amount, 0, ',', '.') : 0 }}
                        </td>
                        <td>Rp.
                            {{ $item->mutation == 'credit' ? number_format($item->amount, 0, ',', '.') : 0 }}
                        </td>
                    </tr>
                    @php
                        $debit = $debit + ($item->mutation == 'debit' ? $item->amount : 0);
                        $credit = $credit + ($item->mutation == 'credit' ? $item->amount : 0);
                    @endphp
                @endforeach
            </tbody>
        </table>
        <table style="float: right; margin-top: 10px" width="23%" border="1" cellspacing="0" cellpadding="5">
            <tr>
                <th>Total Debit</th>
                <th>Total Kredit</th>
            </tr>
            <tr>
                <td>Rp. {{ number_format($debit, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($credit, 0, ',', '.') }}</td>
            </tr>
        </table>
    @endforeach
</body>

</html>
