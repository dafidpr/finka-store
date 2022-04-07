<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Laporan Jurnal',
            'mods' => 'sale_report',
            'action' => route('reports.sale.search'),
        ];

        return view($this->defaultLayout('reports.sale.index'), $data);
    }

    public function search(Request $request)
    {
        try {

            $dateRange = explode(' to ', $request->daterange);
            $dateStart = Carbon::createFromFormat('Y-m-d', $dateRange[0])->format('Y-m-d');
            $dateEnd = Carbon::createFromFormat('Y-m-d', $dateRange[1])->format('Y-m-d');
            $data = [
                'data' => Sale::with('saleDetail')->with('user')->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get(),
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd
            ];

            return view('reports.sale.data', $data);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
