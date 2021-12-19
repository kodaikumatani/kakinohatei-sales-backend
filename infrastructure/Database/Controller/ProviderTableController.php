<?php

namespace Infrastructure\Database\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Infrastructure\Database\Model\Provider;

class ProviderTableController extends Controller
{
    public function getId($providerID, $name)
    {
        $client = new Provider();
        if (DB::table('providers')->where('provider_id', $providerID)->doesntExist()) {
            // If it's an unregistered provider, add it.
            $client->fill([
                'provider_id' => $providerID,
                'name' => $name
            ]);
            $client->save();
        }
        return $providerID;
    }
}