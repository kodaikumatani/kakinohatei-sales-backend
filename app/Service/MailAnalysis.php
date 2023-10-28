<?php

namespace App\Service;

use Carbon\Carbon;
use Exception;

class MailAnalysis
{
    /***
     * Conversion of email text to first normalization.
     *
     * @param $internal_date
     * @param $message
     * @return array|null[]
     */
    public static function regex(Carbon $internal_date, string $text)
    {
        // 売上があるか判定
        if (strpos($text, '売上データはありません')) {
            return [];
        }

        // 生産者コード
        if (preg_match('/生産者コード:(\d+)/', $text, $matches)) {
            $producer_code = (int) $matches[1];
        } else {
            return [];
        }

        // 生産者名
        if (preg_match('/生産者コード:\d+\r\n(.*?)\s+様/', $text, $matches)) {
            $producer_name = $matches[1];
        }

        // 売上を店舗ごとに分割
        $sales = preg_split('/=+|構成比\r\n|\r\n【合計数量/', $text)[2];
        $stores = preg_split('/-+\r\n/', $sales);

        $record = [];
        foreach ($stores as $store) {
            // 店名
            if (preg_match('/^(.*?)\s:/', $store, $matches)) {
                $store_name = $matches[1];
            }

            // 日付
            if (preg_match('/\((.*?)現在\)/', $store, $matches)) {
                $date = self::formatDate($internal_date, $matches[1]);
            }

            // 売上を商品ごとに分割
            $products = array_slice(preg_split('/\r\n/', $store), 1);
            foreach (array_filter($products) as $product) {
                $items = preg_split("/\s+/", $product);
                $product_name = str_replace('（鳥取県産）', '', $items[1]);
                $price = str_replace([',', '円'], '', $items[2]);
                $quantity = str_replace([',', '個'], '', $items[3]);
                try {
                    $store_total = str_replace('個)', '', $items[5]);
                } catch (Exception $e) {
                    $store_total = null;
                }

                if ($product_name == '餅') {
                    $product_name = 'もち';
                }

                $record[] = [
                    'date' => $date,
                    'producer_code' => $producer_code,
                    'producer' => $producer_name,
                    'store' => $store_name,
                    'product' => $product_name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'store_total' => $store_total,
                ];
            }
        }

        return $record;
    }

    /**
     * Formatting Japanese display to Y-m-d H:i.
     */
    private static function formatDate(Carbon $internal_date, $text): string
    {
        $year = $internal_date->year;
        preg_match_all('/\d+/', $text, $match);
        $time = mktime($match[0][2], $match[0][3], 0, $match[0][0], $match[0][1], $year);

        return date('Y-m-d H:i', $time);
    }
}
