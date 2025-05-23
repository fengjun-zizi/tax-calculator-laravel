<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TaxHistory;

class TaxController extends Controller
{
    public function showForm()
    {
        $history = TaxHistory::latest()->paginate(5);

        return view('calculate', [
            'history' => $history,
        ]);
    }
、
    public function calculateTax(Request $request)
    {
        $request->validate([
            'income' => 'required|numeric|min:0',
        ]);

        $income = (int) $request->input('income');

        $taxRate = DB::table('tax_rates')
            ->where('income_from', '<=', $income)
            ->where('income_to', '>=', $income)
            ->value('percentage');

        $taxRate = $taxRate ?? 0;
        $tax = $income * ($taxRate / 100);

        
        TaxHistory::create([
            'income' => $income,
            'tax_rate' => $taxRate,
            'tax_amount' => $tax,
        ]);

       
        $history = TaxHistory::latest()->paginate(5);

        return view('calculate', [
            'income' => $income,
            'taxRate' => $taxRate,
            'tax' => $tax,
            'history' => $history,
        ]);
    }

    
  public function deleteRecord($id)
{
    try {
        $record = TaxHistory::findOrFail($id);
        $record->delete();

        return response()->json(['status' => 'success', 'message' => 'Record deleted.']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
}