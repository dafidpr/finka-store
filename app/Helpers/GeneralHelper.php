<?php

use App\Models\User;
use App\Models\Setting;
use App\Models\Account;
use App\Models\Charity;
use App\Models\Customer;
use App\Models\Debt;
use App\Models\DebtCredit;
use App\Models\Expense;
use App\Models\Liability;
use App\Models\Notification;
use App\Models\PartnerSalaryDiscount;
use App\Models\Purchase;
use App\Models\Receivable;
use App\Models\ReceivableCredit;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use Carbon\Carbon;

if (!function_exists('getInfoLogin')) {
    function getInfoLogin()
    {
        $user = Auth::user();
        return $user;
    }
}

if (!function_exists('hashId')) {
    function hashId($id, $type = 'encode')
    {
        if ($type === 'encode') {
            return Hashids::encode($id);
        } else {
            return Hashids::decode($id);
        }
    }
}

if (!function_exists('stripCharacter')) {
    function stripCharacter($input)
    {
        return preg_replace("/[^0-9]/", "", $input);
    }
}

if (!function_exists('stripCurrencyRequest')) {
    function stripCurrencyRequest(Request $request, $currencyKey)
    {
        foreach ($currencyKey as $key => $crky) {
            if ($request->has($crky)) {
                $request->merge([$crky => $request->has($crky) ? stripCharacter($request[$crky]) : null]);
            }
        }

        return $request;
    }
}
