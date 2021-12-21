<?php

namespace Infrastructure\Database\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Service\ManageMailboxes;
use Infrastructure\Database\Model\Sales;

class SalesController extends Controller
{
    public function saveSalesData()
    {
        $mail = new ManageMailboxes();
        $provider = new ProvidersController();
        $store = new StoresController();
        $product = new ProductsController();

        foreach($mail->getMessage() as $message) {
            $providerID = $provider->getId($message['provider_id'], $message['provider']);
            $storeID = $store->getId($message['store']);
            $productID = $product->getId($message['product']);

            $query = DB::table('sales')->where([
                'provider_id' => $providerID,
                'store_id' => $storeID,
                'record_date' => $message['record_date'],
                'product_id' => $productID
            ]);

            if ($query->doesntExist()) {
                // If it's an unregistered record, add it.
                Sales::create([
                    'provider_id' => $providerID,
                    'store_id' => $storeID,
                    'record_date' => $message['record_date'],
                    'product_id' => $productID,
                    'price' => $message['price'],
                    'quantity' => $message['quantity'],
                    'store_sum' => $message['store_sum']
                ]);
            }
        }
    }
}