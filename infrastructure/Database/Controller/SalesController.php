<?php

namespace Infrastructure\Database\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\ManageMailboxes;
use Infrastructure\Database\Model\Sales;

class SalesController extends Controller
{
    public function saveRecord()
    {
        $mail = new ManageMailboxes();
        $sales = new Sales();
        $store = new StoresController(); 
        $product = new ProductsController();
        foreach($mail->getMessage() as $message) {
            if (!is_null($message)) {
                $storeID = $store->getId($message['store']);
                $productID = $product->getId($message['product']);
                $doesntExist = $sales->doesntExistRecord($message,$storeID,$productID);
                if ($doesntExist) {
                    // If it's an unregistered record, add it.
                    Sales::create([
                        'received_at' => $message['received_at'],
                        'store_id' => $storeID,
                        'recorded_at' => $message['recorded_at'],
                        'product_id' => $productID,
                        'price' => $message['price'],
                        'quantity' => $message['quantity'],
                        'store_sum' => $message['store_sum']
                    ]);
                }
            }
        }
    }
}