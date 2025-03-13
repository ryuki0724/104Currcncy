# 匯率轉換 API

這是一個使用 Laravel 框架開發的匯率轉換 API，可以實現不同貨幣之間的轉換計算。

## 環境需求

-   PHP 8.1+
-   Laravel 10.x
-   Composer

## 安裝步驟

1. 克隆專案

```bash
git clone https://github.com/ryuki0724/104Currcncy.git
```
```bash
cd 104Currcncy
```

2. 安裝依賴

```bash
composer install
```

3. 設定環境變數

```bash
cp .env.example .env
php artisan key:generate
```

4. 啟動服務

```bash
php artisan serve
```

## API 端點

### 匯率轉換

**POST /api/currency/convert**

將一種貨幣轉換為另一種貨幣。

#### 請求參數

| 參數          | 類型    | 必填 | 描述                    |
| ------------- | ------- | ---- | ----------------------- |
| from_currency | string  | 是   | 來源貨幣代碼 (3 個字元) |
| to_currency   | string  | 是   | 目標貨幣代碼 (3 個字元) |
| amount        | numeric | 是   | 要轉換的金額            |

#### 範例請求

```bash
curl -X POST http://localhost:8000/api/currency/convert \
  -H "Content-Type: application/json" \
  -d '{"from_currency":"USD","to_currency":"TWD","amount":100}'
```

#### 成功回應 (200 OK)

```json
{
    "from_currency": "USD",
    "to_currency": "TWD",
    "amount": 100,
    "converted_amount": 3150,
    "rate": 31.5
}
```

#### 錯誤回應 (500 Internal Server Error)

```json
{
    "error": "處理請求時發生錯誤",
    "message": "找不到貨幣的匯率資料"
}
```

## 專案結構

-   `app/Http/Controllers/CurrencyController.php` - 處理匯率轉換請求的控制器
-   `app/Services/CurrencyService.php` - 提供匯率轉換邏輯的服務類
-   `routes/api.php` - API 路由定義

## 支援的貨幣

目前支援以下貨幣的轉換：

-   USD (美元)
-   TWD (新台幣)
-   JPY (日圓)

## 作者

吉田龍生
