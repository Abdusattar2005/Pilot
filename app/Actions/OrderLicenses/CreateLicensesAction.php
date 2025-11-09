<?php

namespace App\Actions\OrderLicenses;

use App\Models\OrderLicense;
use Illuminate\Support\Collection;

class CreateLicensesAction
{
    
    public function handle(int $order_id, Collection $licenseIds)
    {
        foreach ($licenseIds as $licenseId) {
            OrderLicense::firstOrCreate([
                'order_id' => $order_id,
                'license_id' => $licenseId,
            ]);
        }
    }
}
