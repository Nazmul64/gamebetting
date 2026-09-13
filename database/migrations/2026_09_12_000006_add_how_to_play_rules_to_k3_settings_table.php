<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\K3Setting;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasColumn('k3_settings', 'how_to_play_rules')) {
            Schema::table('k3_settings', function (Blueprint $table) {
                $table->longText('how_to_play_rules')->nullable()->after('audio_win_url');
            });
        }

        $defaultRules = "Fast 3 / Quick 3 Game Rules\n\nFast 3 open with 3 numbers in each period as the opening number, The opening numbers are 111 to 666 Natural number, No zeros in the array, And the opening numbers are in no particular order, Quick 3 is to guess all or part of the 3 winning numbers.\n\nBetting Types\n\nSum Value\nPlace a bet on the sum of three numbers\n\nChoose 3 same number all\nFor all the same three numbers (111, 222, ..., 666) Make an all-inclusive bet\n\nChoose 3 same number single\nFrom all the same three numbers (111, ..., 666) Choose a group of numbers in any of them to place bets\n\nChoose 2 Same Multiple\nPlace a bet on two designated same numbers and an arbitrary number among the three numbers\n\nChoose 2 Same Single\nPlace a bet on two designated same numbers and a designated different number among the three numbers\n\n3 numbers different\nPlace a bet on three different numbers\n\n2 numbers different\nPlace a bet on two designated different numbers and an arbitrary number among the three numbers\n\nChoose 3 Consecutive number all\nFor all three consecutive numbers (123, 234, 345, 456) Place a bet\n\nDescription of Winning and Odds\n\nSum Value\nA bet with the same opening number and value is the winning\n\nChoose 3 same number all\nIf the opening numbers are any three of the same number, it is the winning\n\nChoose 3 same number single\nA bet that is exactly the same as the opening number is the winning\n\nChoose 2 Same Multiple\nThe same number as the two same numbers in the opening number (except for the three same numbers) is the winning\n\nChoose 2 Same Single\nA bet that is exactly the same as the opening number is the winning\n\n3 numbers different\nA bet that is exactly the same as the opening number is the winning\n\n2 numbers different\nThe same as the two arbitrary numbers in the opening number is the winning\n\nChoose 3 Consecutive number all\nIf the opening numbers are any three consecutive numbers, it is the winning";

        K3Setting::whereNull('how_to_play_rules')->orWhere('how_to_play_rules', '')->update([
            'how_to_play_rules' => $defaultRules
        ]);
    }

    public function down(): void {
        if (Schema::hasColumn('k3_settings', 'how_to_play_rules')) {
            Schema::table('k3_settings', function (Blueprint $table) {
                $table->dropColumn('how_to_play_rules');
            });
        }
    }
};
