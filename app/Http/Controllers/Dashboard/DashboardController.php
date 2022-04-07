<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'mods' => 'dashboard'
        ];

        return view($this->defaultLayout, $data);
    }

    public function getSaleChart()
    {
        $month = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        $sales = Sale::with('saleDetail')->whereYear('created_at', date('Y'))->get();
        $incomeOfYear = [];
        foreach ($month as $key => $value) {
            $incomeOfYear[$key] = [
                'month' => $value,
                'income' => 0
            ];
            $totalIncome = 0;
            foreach ($sales as $item) {
                $month = Carbon::parse($item->date)->format('m');
                if (($month - 1) == $key) {
                    $totalIncome += $item->saleDetail->sum('subtotal');
                    $incomeOfYear[$key] = [
                        'month' => $value,
                        'income' => $totalIncome,
                    ];
                }
            }
        }
        return response()->json([
            'status' => 'success',
            'data' => $incomeOfYear,
        ]);
    }
}
