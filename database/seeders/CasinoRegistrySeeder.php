<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CasinoGameRegistry;
use App\Services\CasinoCentralTrackingService;

class CasinoRegistrySeeder extends Seeder
{
    public function run(): void
    {
        $tracker = new CasinoCentralTrackingService();
        $tracker->syncHistoricData();
    }
}
