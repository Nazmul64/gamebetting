<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed default platform settings
        \App\Models\Setting::updateOrCreate(['key' => 'referral_commission_l1'], ['value' => '10']);
        \App\Models\Setting::updateOrCreate(['key' => 'referral_commission_l2'], ['value' => '5']);
        \App\Models\Setting::updateOrCreate(['key' => 'referral_commission_l3'], ['value' => '2']);
        \App\Models\Setting::updateOrCreate(['key' => 'withdraw_commission'], ['value' => '5']);

        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }
    }
}
