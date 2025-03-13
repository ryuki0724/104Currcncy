<?php
namespace App\Services;

class CurrencyService
{
    /**
     * 模擬貨幣資料
     *
     * @var array
     */
    private array $currencyData;

    public function __construct()
    {
        $this->currencyData = [
            [
                "base_currency" => "USD",
                "last_updated"  => "2023-12-25T12:00:00Z",
                "rates"         => [
                    "USD" => 1.0000,
                    "TWD" => 31.5000,
                    "JPY" => 148.5000,
                ],
            ],
            [
                "base_currency" => "TWD",
                "last_updated"  => "2023-12-25T12:00:00Z",
                "rates"         => [
                    "USD" => 0.0317,
                    "TWD" => 1.0000,
                    "JPY" => 4.7143,
                ],
            ],
            [
                "base_currency" => "JPY",
                "last_updated"  => "2023-12-25T12:00:00Z",
                "rates"         => [
                    "USD" => 0.00673,
                    "TWD" => 0.2121,
                    "JPY" => 1.0000,
                ],
            ],
        ];
    }

    /**
     * 取得匯率
     *
     * @param string $from
     * @param string $to
     * @return array
     */
    public function getExchange($from, $to, $amount)
    {
        $currencyData = $this->currencyData;

        foreach ($currencyData as $currency) {
            if ($currency['base_currency'] === $from) {
                return [
                    'rate'             => $currency['rates'][$to],
                    'converted_amount' => $this->formatAmountByCurrency($currency['rates'][$to] * $amount, $to),
                ];
            }
        }

        throw new \Exception("找不到貨幣的匯率資料");
    }

    /**
     * 根據幣別格式化金額
     *
     * @param float $amount 金額
     * @param string $currency 幣別代碼
     * @return float|int 格式化後的金額
     */
    private function formatAmountByCurrency($amount, $currency)
    {
        switch ($currency) {
            case 'TWD':
            case 'JPY':
                return (int) round($amount);
            case 'USD':
                return round($amount, 2);
            default:
                return $amount;
        }
    }
}
