<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TaxHistory;
use Illuminate\Support\Facades\Validator;

class TaxApiController extends Controller
{
    public function calculate(Request $request)
    {
        // 验证输入
        $validator = Validator::make($request->all(), [
            'income' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $income = (int) $request->input('income');

        // 查找税率
        $taxRate = DB::table('tax_rates')
            ->where('income_from', '<=', $income)
            ->where('income_to', '>=', $income)
            ->value('percentage');

        $taxRate = $taxRate ?? 0;
        $tax = $income * ($taxRate / 100);

        // 保存到 tax_histories 表
        TaxHistory::create([
            'income' => $income,
            'tax_rate' => $taxRate,
            'tax_amount' => $tax,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'income' => $income,
                'tax_rate' => $taxRate,
                'tax' => $tax
            ]
        ]);
    }
}
