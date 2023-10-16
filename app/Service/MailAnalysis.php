<?php

namespace App\Service;

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
    public static function regex($internal_date, $message): array
    {
        try {
            $record = [];
            $pattern = "/=+|構成比\r\n|\r\n【合計数量/";
            $split_message = preg_split($pattern, $message);

            if (str_contains($split_message[1], '売上データはありません。')) {
                return [null];
            }
            // Get proctor_id and proctor name
            $split_header = preg_split("/\r\n/", $split_message[0]);
            $producer_code = str_replace('生産者コード:', '', $split_header[0]);
            $producer_name = str_replace(' 様', '', $split_header[1]);
            // Divide sales-info by store.
            $stores = preg_split("/-+\r\n/", $split_message[2]);

            foreach (array_filter($stores) as $store) {
                preg_match("{\((.*)\)}", $store, $match);
                $date = self::formatDate($internal_date, $match[1]);
                $store_name = preg_split('/\s:\s/', $store)[0];
                $products = preg_split("/\n/", preg_split("/現在\)\r\n/", $store)[1]);

                foreach (array_filter($products) as $product) {
                    $items = preg_split("/\s+/", $product);
                    $product_name = str_replace('（鳥取県産）', '', $items[1]);
                    $price = str_replace([',', '円'], '', $items[2]);
                    $quantity = str_replace('個', '', $items[3]);
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
        } catch (Exception $e) {
            echo $e->getMessage(), "\n";

            return [null];
        }
    }

    /**
     * Formatting Japanese display to Y-m-d H:i.
     */
    private static function formatDate($internal_date, $text): string
    {
        $year = date('Y', $internal_date);
        preg_match_all('/\d+/', $text, $match);
        $time = mktime($match[0][2], $match[0][3], 0, $match[0][0], $match[0][1], $year);

        return date('Y-m-d H:i', $time);
    }
}
