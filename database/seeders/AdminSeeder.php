<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Create the admin user if it doesn't already exist.
     * Email: admin@gmaill.com
     * Password: admin@gmaill.com (same as email — change this in production!)
     */
    public function run(): void
    {
        $adminEmail = 'admin@gmaill.com';

        // Only create if not already exists
        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name'     => 'Admin',
                'email'    => $adminEmail,
                'password' => Hash::make($adminEmail), // password = admin@gmail.com
                'gender'   => 'Male',
                'mobile'   => '01700000000',
                'country'  => 'Bangladesh',
                'currency' => 'BDT',
                'balance'  => 0,
                'is_admin' => true,
            ]);

            $this->command->info('✅ Admin user created: ' . $adminEmail . ' (password: ' . $adminEmail . ')');
        } else {
            // If already exists, make sure is_admin is set to true
            User::where('email', $adminEmail)->update(['is_admin' => true]);
            $this->command->info('✅ Admin user already exists. is_admin flag updated.');
        }
    }
}
