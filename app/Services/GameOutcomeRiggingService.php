<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Exception;

class GameOutcomeRiggingService
{
    /**
     * Get the active rigging mode for the user.
     * Returns: 'normal' | 'always_win' | 'always_lose'
     */
    public function getUserRigMode(?User $user): string
    {
        if (!$user) {
            return 'normal';
        }
        return $user->game_rig_mode ?: 'normal';
    }

    /**
     * Get Global Demo Balance configured by Admin
     */
    public function getGlobalDemoBalance(): float
    {
        return (float)Setting::getVal('global_demo_balance', 10000.00);
    }

    /**
     * Check if user account is blocked or on deposit hold.
     * Throws Exception with specific admin reason if restricted.
     */
    public function validatePlayerCanPlay(?User $user, bool $isDemo = false): void
    {
        if ($isDemo || !$user) {
            return;
        }

        if ($user->is_blocked) {
            $reason = $user->block_reason ? "কারণ: {$user->block_reason}" : "নিরাপত্তাজনিত কারণে আপনার অ্যাকাউন্ট সাময়িকভাবে স্থগিত করা হয়েছে।";
            throw new Exception("অ্যাকাউন্ট ব্লক করা আছে! {$reason}");
        }

        if ($user->deposit_hold) {
            $reason = $user->hold_reason ? "কারণ: {$user->hold_reason}" : "অ্যাকাউন্ট যাচাইকরণের জন্য ডিপোজিট ও বেটিং সাময়িকভাবে স্থগিত রাখা হয়েছে।";
            throw new Exception("ডিপোজিট হোল্ডে আছে! {$reason}");
        }
    }

    /**
     * Determine if player should win the current bet/round.
     * Rules:
     * - Admin user rig 'always_win': 100% win
     * - Admin user rig 'always_lose': 0% win (100% lose)
     * - Demo Mode: 70% win rate for player
     * - Real Mode: 70% House Profit (30% win rate for player)
     */
    public function shouldPlayerWin(?User $user, bool $isDemo = false): bool
    {
        $mode = $this->getUserRigMode($user);
        if ($mode === 'always_win') {
            return true;
        }
        if ($mode === 'always_lose') {
            return false;
        }

        if ($isDemo) {
            // Demo mode: 70% win rate
            return (rand(1, 100) <= 70);
        }

        // Real mode: Admin 70% profit, Player 30% win rate
        return (rand(1, 100) <= 30);
    }

    /**
     * Check if slot spin should result in win or lose.
     * Returns 'win' | 'lose'
     */
    public function determineSpinRigAction(?User $user, bool $isDemo = false): string
    {
        return $this->shouldPlayerWin($user, $isDemo) ? 'win' : 'lose';
    }

    /**
     * Check if coin toss / heads or tails outcome should be win or loss for user.
     */
    public function determineCoinTossOutcome(?User $user, string $userSelection, bool $isDemo = false): string
    {
        $userSelection = strtolower(trim($userSelection));
        $isHeads = ($userSelection === 'heads' || $userSelection === 'head' || $userSelection === 'h');
        $normSelection = $isHeads ? 'heads' : 'tails';
        $opposite = $isHeads ? 'tails' : 'heads';

        $isWin = $this->shouldPlayerWin($user, $isDemo);
        return $isWin ? $normSelection : $opposite;
    }

    /**
     * Check if lottery number / color pick should be rigged.
     * $userNumbers: Array of numbers user bet on (e.g. [0, 5, 8])
     * $allNumbers: Array of possible numbers [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
     */
    public function determineLotteryWinningNumber(?User $user, array $userNumbers, array $allNumbers = [0,1,2,3,4,5,6,7,8,9], bool $isDemo = false): ?int
    {
        $mode = $this->getUserRigMode($user);
        if ($mode === 'always_win' && !empty($userNumbers)) {
            return $userNumbers[array_rand($userNumbers)];
        }

        if ($mode === 'always_lose' && !empty($userNumbers)) {
            $losingNumbers = array_values(array_diff($allNumbers, $userNumbers));
            if (!empty($losingNumbers)) {
                return $losingNumbers[array_rand($losingNumbers)];
            }
        }

        if ($isDemo) {
            // 70% win chance in demo
            $shouldWin = (rand(1, 100) <= 70);
            if ($shouldWin && !empty($userNumbers)) {
                return $userNumbers[array_rand($userNumbers)];
            }
            $losingNumbers = array_values(array_diff($allNumbers, $userNumbers));
            if (!empty($losingNumbers)) {
                return $losingNumbers[array_rand($losingNumbers)];
            }
        } else {
            // Real mode: 70% house profit, 30% player win
            $shouldWin = (rand(1, 100) <= 30);
            if ($shouldWin && !empty($userNumbers)) {
                return $userNumbers[array_rand($userNumbers)];
            }
            $losingNumbers = array_values(array_diff($allNumbers, $userNumbers));
            if (!empty($losingNumbers)) {
                return $losingNumbers[array_rand($losingNumbers)];
            }
        }

        return null;
    }
}
