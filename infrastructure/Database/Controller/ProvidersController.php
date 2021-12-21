<?php

namespace Infrastructure\Database\Controller;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Infrastructure\Database\Model\Provider;

class ProvidersController extends Controller
{
    public function getId($providerID, $name)
    {
        if (DB::table('providers')->where('provider_id', $providerID)->doesntExist()) {
            // If it's an unregistered provider, add it.
            Provider::create([
                'provider_id' => $providerID,
                'name' => $name
            ]);
        }
        return $providerID;
    }
}