<?php

namespace App\Tbuy\Tariff\Observers;

use App\Tbuy\Tariff\Models\Tariff;

class TariffObserver
{
    public function deleting(Tariff $tariff)
    {
        $tariff->privileges()->delete();
    }
}
