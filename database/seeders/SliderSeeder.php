<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            [
                'title' => 'SPINOLEAGUE TOURNAMENT',
                'subtitle' => '05.03.2026 - 01.03.2027',
                'badge_text' => '05.03.2026 - 01.03.2027',
                'prize_text' => 'STAND BY THE CHAMPIONS | PRIZE POOL: <span>€12,000,000</span>',
                'button_text' => 'PLAY NOW',
                'button_url' => '/play',
                'image' => 'https://images.unsplash.com/photo-1518156677180-95a2893f3e9f?q=80&w=1200&auto=format&fit=crop',
                'bg_gradient' => 'linear-gradient(to right, rgba(10,17,30,0.95) 35%, rgba(10,17,30,0.1) 100%)',
                'order' => 1,
                'status' => 'active',
            ],
            [
                'title' => 'NEW PROVIDER LAUNCH',
                'subtitle' => 'Exclusive Release',
                'badge_text' => 'Exclusive Release',
                'prize_text' => 'EXPERIENCE THE THRILL OF <span>PLAYCOGNITO</span> SLOTS',
                'button_text' => 'PLAY NOW',
                'button_url' => '/play',
                'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1200&auto=format&fit=crop',
                'bg_gradient' => 'linear-gradient(to right, rgba(10,17,30,0.95) 35%, rgba(10,17,30,0.1) 100%)',
                'order' => 2,
                'status' => 'active',
            ],
            [
                'title' => 'GOLDEN DRAGON CHALLENGE',
                'subtitle' => 'Limited Time Only',
                'badge_text' => 'Limited Time Only',
                'prize_text' => 'MULTIPLY YOUR WINNINGS UP TO <span>500,000 BDT</span>',
                'button_text' => 'PLAY NOW',
                'button_url' => '/play',
                'image' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=1200&auto=format&fit=crop',
                'bg_gradient' => 'linear-gradient(to right, rgba(10,17,30,0.95) 35%, rgba(10,17,30,0.1) 100%)',
                'order' => 3,
                'status' => 'active',
            ]
        ];

        foreach ($defaults as $slide) {
            Slider::firstOrCreate(['title' => $slide['title']], $slide);
        }
    }
}
