<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                'name'    => 'bKash',
                'type'    => 'manual',
                'logo'    => '/assets/image/bkash.png',
                'methods' => 'both',
                'status'  => 'active',
                'settings' => [
                    ['name' => 'Receiver Number', 'value' => '01712345678', 'type' => 'text'],
                    ['name' => 'Account Type', 'value' => 'Personal (Send Money)', 'type' => 'text'],
                    ['name' => 'Instructions', 'value' => 'বিকাশ অ্যাপ অথবা *247# ডায়াল করে উল্লেখিত নাম্বারে Send Money করুন। টাকা পাঠানো সম্পন্ন হলে নিচে আপনার বিকাশ নাম্বার, TrxID ও পেমেন্ট স্লিপের স্ক্রিনশট দিন।', 'type' => 'textarea'],
                ],
                'deposit_fields' => [
                    ['name' => 'Sender Number', 'type' => 'text', 'required' => true],
                    ['name' => 'Transaction ID (TrxID)', 'type' => 'text', 'required' => true],
                    ['name' => 'Payment Screenshot', 'type' => 'file', 'required' => false],
                ]
            ],
            [
                'name'    => 'Nagad',
                'type'    => 'manual',
                'logo'    => '/assets/image/nagad.png',
                'methods' => 'both',
                'status'  => 'active',
                'settings' => [
                    ['name' => 'Receiver Number', 'value' => '01812345678', 'type' => 'text'],
                    ['name' => 'Account Type', 'value' => 'Personal (Send Money)', 'type' => 'text'],
                    ['name' => 'Instructions', 'value' => 'নগদ অ্যাপ অথবা *167# ডায়াল করে উল্লেখিত নাম্বারে Send Money করুন। টাকা পাঠানো সম্পন্ন হলে নিচে আপনার নগদ নাম্বার, TrxID ও স্ক্রিনশট দিন।', 'type' => 'textarea'],
                ],
                'deposit_fields' => [
                    ['name' => 'Sender Number', 'type' => 'text', 'required' => true],
                    ['name' => 'Transaction ID (TrxID)', 'type' => 'text', 'required' => true],
                    ['name' => 'Payment Screenshot', 'type' => 'file', 'required' => false],
                ]
            ],
            [
                'name'    => 'Binance USDT (TRC20)',
                'type'    => 'manual',
                'logo'    => '/assets/image/usdt.png',
                'methods' => 'both',
                'status'  => 'active',
                'settings' => [
                    ['name' => 'Wallet Address', 'value' => 'TYDzmsp8JnL1gNsmHhLzQ9497eUvB35jYQ', 'type' => 'text'],
                    ['name' => 'Network', 'value' => 'TRC20 (Tron)', 'type' => 'text'],
                    ['name' => 'Exchange Rate', 'value' => '1 USDT = 125 BDT', 'type' => 'text'],
                    ['name' => 'Instructions', 'value' => 'Send USDT (TRC20 Network only) to the given wallet address. Enter your Transaction Hash (TxID) and upload the transfer receipt screenshot.', 'type' => 'textarea'],
                ],
                'deposit_fields' => [
                    ['name' => 'Transaction Hash / TxID', 'type' => 'text', 'required' => true],
                    ['name' => 'Payment Proof Screenshot', 'type' => 'file', 'required' => false],
                ]
            ]
        ];

        foreach ($gateways as $gw) {
            PaymentGateway::updateOrCreate(
                ['name' => $gw['name']],
                $gw
            );
        }
    }
}
