<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class SaleListController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Penjualan',
            'mods' => 'sale_list',
        ];

        return view($this->defaultLayout('sale_list.index'), $data);
    }

    public function getData()
    {
        return DataTables::of(Sale::with('saleDetail')->with('user')->get())->addColumn('hashid', function ($data) {
            return Hashids::encode($data->id);
        })->addColumn('quantity', function ($data) {
            return $data->saleDetail->sum('quantity');
        })->addColumn('subtotal', function ($data) {
            return $data->saleDetail->sum('subtotal');
        })->addColumn('cashier', function ($data) {
            return $data->user->name;
        })->make(true);
    }

    public function detail(Sale $sale)
    {
        try {
            return response()->json([
                'data' => $sale->saleDetail
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Sale $sale)
    {
        try {
            $sale->delete();
            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Data tidak dapat dihapus karena sudah digunakan'
                ], 500);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]);
            }
        }
    }
}
