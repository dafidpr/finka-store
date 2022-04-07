<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;

class SalesController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Penjualan',
            'mods' => 'sale',
            'action' => route('sales.store')
        ];

        return view($this->defaultLayout, $data);
    }

    public function store(Request $request)
    {
        try {
            $sale = Sale::create([
                'user_id' => Auth::user()->id,
                'code' => $this->getSaleCode('POS'),
                'customer' => $request->customer,
                'payment_method' => $request->payment_method,
                'discount' => 0,
                'description' => $request->description == null ? '-' : $request->description,
                'pay' => stripCharacter($request->pay_total),
                'pay_return' => stripCharacter($request->pay_return),
                'date' => Carbon::now()->format('Y-m-d')
            ]);
            foreach ($request->name as $key => $req) {
                if ($request->name[$key] != '' && $request->price[$key] != '' && $request->qty[$key] != '' && $request->subtotal[$key] != '') {
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product' => $request->name[$key],
                        'price' => stripCharacter($request->price[$key]),
                        'quantity' => stripCharacter($request->qty[$key]),
                        'subtotal' => stripCharacter($request->subtotal[$key])
                    ]);
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil di simpan',
                'data' => $sale
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }
    public function edit(Sale $sale)
    {
        $data = [
            'title' => 'Edit Penjualan',
            'mods' => 'sale',
            'transaction' => $sale,
            'transactionChildren' => $sale->saleDetail,
            'action' => route('sales.update', ['sale' => $sale->hashid])
        ];

        return view($this->defaultLayout('sales.index'), $data);
    }

    public function update(Request $request, Sale $sale)
    {
        try {
            $sale->update([
                'customer' => $request->customer,
                'payment_method' => $request->payment_method,
                'discount' => 0,
                'description' => $request->description == null ? '-' : $request->description,
                'pay' => stripCharacter($request->pay_total),
                'pay_return' => stripCharacter($request->pay_return),
            ]);
            foreach ($request->name as $key => $req) {
                if ($request->name[$key] != '' && $request->price[$key] != '' && $request->qty[$key] != '' && $request->subtotal[$key] != '') {
                    if (isset($request->transaction_child_id[$key])) {
                        $saleDetailId = Hashids::decode($request->transaction_child_id[$key]);
                        SaleDetail::where('id', $saleDetailId[0])->update([
                            'product' => $request->name[$key],
                            'price' => stripCharacter($request->price[$key]),
                            'quantity' => stripCharacter($request->qty[$key]),
                            'subtotal' => stripCharacter($request->subtotal[$key])
                        ]);
                    } else {
                        SaleDetail::create([
                            'sale_id' => $sale->id,
                            'product' => $request->name[$key],
                            'price' => stripCharacter($request->price[$key]),
                            'quantity' => stripCharacter($request->qty[$key]),
                            'subtotal' => stripCharacter($request->subtotal[$key])
                        ]);
                    }
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil di simpan',
                'data' => $sale
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function destroySaleItem(SaleDetail $saleDetail)
    {
        try {
            $saleDetail->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data telah dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    protected function getSaleCode($prefixCode)
    {
        $code = 'SALE/' . $prefixCode . '/' . date('Y') . '/';
        $previousSale = Sale::whereYear('created_at', DB::raw('YEAR(CURDATE())'))
            ->orderBy('created_at', 'DESC')->take(1)->first();

        $code .= ($previousSale ? str_pad(((int) explode('/', $previousSale->code)[3]) + 1, 6, '0', STR_PAD_LEFT) : str_pad(1, 6, '0', STR_PAD_LEFT));
        return $code;
    }

    public function print(Request $request)
    {
        $hashId = Hashids::decode($request->code);
        if (!empty($hashId)) {
            $sale = Sale::where('id', $hashId[0])->with('saleDetail')->with('user')->first();
            $data = [
                'sale' => $sale,
            ];
            return view('sales.print', $data);
        } else {
            return redirect()->route('sales');
        }
    }
}
