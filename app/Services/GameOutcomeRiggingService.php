<?php

namespace App\Services;

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
     * Check if coin toss / heads or tails outcome should be rigged.
     */
    public function determineCoinTossOutcome(?User $user, string $userSelection): string
    {
        $mode = $this->getUserRigMode($user);
        $userSelection = strtolower(trim($userSelection));
        $opposite = ($userSelection === 'heads' || $userSelection === 'head' || $userSelection === 'h') ? 'tails' : 'heads';

        if ($mode === 'always_win') {
            return ($userSelection === 'head' || $userSelection === 'h') ? 'heads' : $userSelection;
        }

        if ($mode === 'always_lose') {
            return $opposite;
        }

        // Standard 50-50 / house margin
        return (rand(1, 100) <= 48) ? (($userSelection === 'head' || $userSelection === 'h') ? 'heads' : $userSelection) : $opposite;
    }

    /**
     * Check if slot spin should be rigged.
     * Returns 'win' | 'lose' | 'normal'
     */
    public function determineSpinRigAction(?User $user): string
    {
        $mode = $this->getUserRigMode($user);
        if ($mode === 'always_win') {
            return 'win';
        }
        if ($mode === 'always_lose') {
            return 'lose';
        }
        return 'normal';
    }

    /**
     * Check if lottery number / color pick should be rigged.
     * $userPicks: Array of numbers or colors user bet on (e.g. [0, 5, 'green'])
     * $candidateNumbers: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
     */
    public function determineLotteryWinningNumber(?User $user, array $userNumbers, array $allNumbers = [0,1,2,3,4,5,6,7,8,9]): ?int
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

        return null; // Let standard house profit engine decide
    }
}
