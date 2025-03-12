<?php
namespace App\Http\Controllers;

use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    // 轉換匯率
    public function convert(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'from_currency' => 'required|string|size:3|in:USD,TWD,JPY',
                'to_currency'   => 'required|string|size:3|in:USD,TWD,JPY',
                'amount'        => 'required|numeric|min:0',
            ]);

            $fromCurrency = strtoupper($validatedData['from_currency']);
            $toCurrency   = strtoupper($validatedData['to_currency']);
            $amount       = $validatedData['amount'];

            $convertedData = $this->currencyService->getExchange($fromCurrency, $toCurrency, $amount);

            return response()->json([
                'from_currency'    => $fromCurrency,
                'to_currency'      => $toCurrency,
                'amount'           => $amount,
                'converted_amount' => $convertedData['converted_amount'],
                'rate'             => $convertedData['rate'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error'   => '處理請求時發生錯誤',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
