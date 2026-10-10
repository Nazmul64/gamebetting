import React, { useState } from 'react';
import GameWrapper from '../../components/GameWrapper';
import { gameAudio } from '../../audio/GameAudio';
import confetti from 'canvas-confetti';
import { Trophy, Mountain, ArrowUp, AlertTriangle } from 'lucide-react';

const MULTIPLIERS = [1.2, 1.5, 2.0, 2.8, 4.0, 6.0, 10.0, 18.0, 35.0, 80.0];

export default function TreasureClimb({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [betAmount, setBetAmount] = useState(50);
    const [currentStep, setCurrentStep] = useState(0); // 0 to 10
    const [gameState, setGameState] = useState('idle'); // idle, climbing, cashed_out, fallen
    const [statusMessage, setStatusMessage] = useState('Place bet and START CLIMBING to reach high multipliers!');

    const handleStart = () => {
        if (betAmount <= 0 || betAmount > balance) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Insufficient balance!');
            return;
        }

        setBalance(prev => Math.max(0, prev - betAmount));
        setCurrentStep(0);
        setGameState('climbing');
        setStatusMessage('Select CLIMB UP or CASHOUT anytime!');
        gameAudio.playSFX('click');
    };

    const handleStep = () => {
        if (gameState !== 'climbing') return;

        // 75% success chance per step
        const isSuccess = Math.random() < 0.75;

        if (isSuccess) {
            const next = currentStep + 1;
            setCurrentStep(next);
            gameAudio.playSFX('coin');

            if (next === MULTIPLIERS.length) {
                // Reached peak!
                const win = betAmount * MULTIPLIERS[next - 1];
                setBalance(prev => prev + win);
                setGameState('cashed_out');
                gameAudio.playSFX('bigwin');
                confetti({ particleCount: 120, spread: 90, origin: { y: 0.6 } });
                setStatusMessage(`🏆 SUMMIT REACHED! Won ৳${win.toLocaleString()} (${MULTIPLIERS[next - 1]}x)!`);
            } else {
                setStatusMessage(`Level ${next} Reached! Current Payout: ৳${(betAmount * MULTIPLIERS[next - 1]).toFixed(2)} (${MULTIPLIERS[next - 1]}x)`);
            }
        } else {
            // Fallen
            gameAudio.playSFX('lose');
            setGameState('fallen');
            setStatusMessage('💥 Slipped! The climb collapsed. Try again!');
        }
    };

    const handleCashout = () => {
        if (gameState !== 'climbing' || currentStep === 0) return;

        const win = betAmount * MULTIPLIERS[currentStep - 1];
        setBalance(prev => prev + win);
        setGameState('cashed_out');
        gameAudio.playSFX('cashout');
        confetti({ particleCount: 70, spread: 70, origin: { y: 0.6 } });
        setStatusMessage(`🎉 CASHED OUT: ৳${win.toLocaleString()} (${MULTIPLIERS[currentStep - 1]}x)!`);
    };

    return (
        <GameWrapper
            title="Treasure Climb Tower"
            bgImage={config.bg_image || '/images/climb-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            balance={balance}
            rules="Climb the Treasure Mountain step by step. Each higher level increases your multiplier up to 80X! Cash out anytime before falling."
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4">
                {/* Climb Mountain Tower */}
                <div className="w-full relative rounded-3xl bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 border-4 border-amber-500/40 p-4 sm:p-6 shadow-2xl flex flex-col items-center">
                    <div className="mb-4 px-4 py-1.5 rounded-full bg-slate-950 border border-amber-400/40 text-xs sm:text-sm font-bold text-amber-300 shadow">
                        {statusMessage}
                    </div>

                    {/* Step Ladder */}
                    <div className="w-full max-w-md flex flex-col-reverse gap-2 bg-slate-950/80 p-3 rounded-2xl border border-slate-800">
                        {MULTIPLIERS.map((m, idx) => {
                            const isCurrent = currentStep === idx + 1;
                            const isPassed = currentStep > idx + 1;
                            return (
                                <div
                                    key={idx}
                                    className={`py-2 px-4 rounded-xl font-bold flex justify-between items-center transition duration-300 ${
                                        isCurrent
                                            ? 'bg-gradient-to-r from-amber-500 to-yellow-400 text-slate-950 ring-4 ring-amber-400/50 scale-105'
                                            : isPassed
                                            ? 'bg-emerald-950/70 border border-emerald-500/40 text-emerald-300'
                                            : 'bg-slate-900 border border-slate-800 text-slate-400'
                                    }`}
                                >
                                    <span className="text-xs uppercase font-mono">Level {idx + 1}</span>
                                    <span className="font-mono font-black text-sm">{m}X</span>
                                </div>
                            );
                        })}
                    </div>
                </div>

                {/* Control Panel */}
                <div className="w-full bg-slate-950/90 border border-amber-500/30 rounded-3xl p-4 sm:p-6 shadow-2xl flex flex-col gap-4">
                    {gameState === 'climbing' ? (
                        <div className="grid grid-cols-2 gap-3">
                            <button
                                onClick={handleStep}
                                className="py-4 bg-gradient-to-r from-amber-400 to-yellow-500 text-slate-950 font-black rounded-2xl text-base uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg transition active:scale-95"
                            >
                                <ArrowUp className="w-5 h-5" /> CLIMB UP (উপরে উঠো)
                            </button>
                            <button
                                onClick={handleCashout}
                                disabled={currentStep === 0}
                                className={`py-4 rounded-2xl font-black text-base uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg transition active:scale-95 ${
                                    currentStep > 0
                                        ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-slate-950 ring-2 ring-emerald-300'
                                        : 'bg-slate-800 text-slate-500 cursor-not-allowed'
                                }`}
                            >
                                <Trophy className="w-5 h-5" /> CASHOUT ({currentStep > 0 ? `${MULTIPLIERS[currentStep - 1]}x` : '0x'})
                            </button>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                            <div className="sm:col-span-7 flex items-center gap-2 bg-slate-900 border border-slate-700 rounded-2xl p-2">
                                <span className="text-xs font-bold text-slate-400 pl-2">Bet (৳):</span>
                                <input
                                    type="number"
                                    min="1"
                                    max="50000"
                                    value={betAmount}
                                    onChange={(e) => setBetAmount(Math.max(1, Number(e.target.value)))}
                                    className="w-full bg-transparent text-amber-300 font-mono font-bold text-lg focus:outline-none"
                                />
                            </div>
                            <div className="sm:col-span-5">
                                <button
                                    onClick={handleStart}
                                    className="w-full py-4 bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 text-slate-950 font-black text-base uppercase tracking-widest rounded-2xl shadow-xl transition hover:scale-[1.02] active:scale-95"
                                >
                                    START CLIMB (শুরু করো)
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </GameWrapper>
    );
}
