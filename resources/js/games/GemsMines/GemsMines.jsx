import React, { useState } from 'react';
import GameWrapper from '../../components/GameWrapper';
import { gameAudio } from '../../audio/GameAudio';
import confetti from 'canvas-confetti';
import { Bomb, Gem, Trophy, Sparkles } from 'lucide-react';

export default function GemsMines({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [betAmount, setBetAmount] = useState(50);
    const [mineCount, setMineCount] = useState(3);
    const [isDemo, setIsDemo] = useState(!window.IS_AUTH);
    const [gameState, setGameState] = useState('idle'); // idle, playing, cashed_out, exploded
    const [grid, setGrid] = useState(Array(25).fill({ status: 'hidden', isMine: false }));
    const [revealedCount, setRevealedCount] = useState(0);
    const [currentMultiplier, setCurrentMultiplier] = useState(1.0);
    const [statusMessage, setStatusMessage] = useState('Select mines and press START GAME to uncover gems');

    const handleStart = () => {
        if (betAmount <= 0 || betAmount > balance) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Insufficient balance!');
            return;
        }

        // Generate 25 tiles with mineCount mines randomly
        const indices = Array.from({ length: 25 }, (_, i) => i);
        for (let i = indices.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [indices[i], indices[j]] = [indices[j], indices[i]];
        }
        const mineIndices = new Set(indices.slice(0, mineCount));

        const newGrid = Array(25).fill(null).map((_, idx) => ({
            status: 'hidden',
            isMine: mineIndices.has(idx)
        }));

        setBalance(prev => Math.max(0, prev - betAmount));
        setGrid(newGrid);
        setRevealedCount(0);
        setCurrentMultiplier(1.0);
        setGameState('playing');
        setStatusMessage('Click any tile to reveal Gems 💎 (Avoid Mines 💣)');
        gameAudio.playSFX('click');
    };

    const handleTileClick = (idx) => {
        if (gameState !== 'playing') return;
        if (grid[idx].status !== 'hidden') return;

        const tile = grid[idx];
        if (tile.isMine) {
            // Hit a mine!
            gameAudio.playSFX('error');
            const explodedGrid = grid.map((t) => ({
                ...t,
                status: t.isMine ? 'mine' : 'gem'
            }));
            setGrid(explodedGrid);
            setGameState('exploded');
            setStatusMessage('💥 BOOM! You hit a mine. Game Over.');
        } else {
            // Found a gem!
            gameAudio.playSFX('coin');
            const newRevealedCount = revealedCount + 1;
            const mult = calculateMultiplier(newRevealedCount, mineCount);

            const updatedGrid = [...grid];
            updatedGrid[idx] = { ...tile, status: 'gem' };
            setGrid(updatedGrid);
            setRevealedCount(newRevealedCount);
            setCurrentMultiplier(mult);
            setStatusMessage(`💎 Gem Found! Current Payout: ৳${(betAmount * mult).toFixed(2)} (${mult.toFixed(2)}x)`);

            // If all non-mines found
            if (newRevealedCount === (25 - mineCount)) {
                handleCashout();
            }
        }
    };

    const handleCashout = () => {
        if (gameState !== 'playing' || revealedCount === 0) return;

        const winAmount = parseFloat((betAmount * currentMultiplier).toFixed(2));
        setBalance(prev => prev + winAmount);
        setGameState('cashed_out');
        gameAudio.playSFX('cashout');
        confetti({ particleCount: 80, spread: 80, origin: { y: 0.6 } });
        setStatusMessage(`🎉 CASHED OUT: ৳${winAmount.toLocaleString()} (${currentMultiplier.toFixed(2)}x)!`);

        // Reveal remaining grid
        const revealedGrid = grid.map((t) => ({
            ...t,
            status: t.status === 'hidden' ? (t.isMine ? 'mine' : 'gem') : t.status
        }));
        setGrid(revealedGrid);
    };

    function calculateMultiplier(gems, mines) {
        let total = 1.0;
        for (let i = 0; i < gems; i++) {
            total *= (25 - i) / (25 - mines - i);
        }
        return Math.max(1.05, total * 0.98);
    }

    return (
        <GameWrapper
            title="Gems Mines"
            bgImage={config.bg_image || '/images/mines-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            balance={balance}
            rules="Pick tiles on the 5x5 grid. Find shiny gems to multiply your payout, but avoid hidden mines! Cash out anytime."
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4">
                {/* 5x5 Mines Grid */}
                <div className="w-full relative rounded-3xl bg-slate-950/90 border-4 border-amber-500/40 p-4 sm:p-6 shadow-2xl flex flex-col items-center">
                    <div className="mb-4 px-4 py-1.5 rounded-full bg-slate-900 border border-amber-400/40 text-xs sm:text-sm font-bold text-amber-300 shadow">
                        {statusMessage}
                    </div>

                    <div className="grid grid-cols-5 gap-2 sm:gap-3 p-3 bg-slate-900/90 rounded-2xl border border-slate-800">
                        {grid.map((tile, idx) => (
                            <button
                                key={idx}
                                onClick={() => handleTileClick(idx)}
                                disabled={gameState !== 'playing' || tile.status !== 'hidden'}
                                className={`w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 rounded-2xl font-black flex items-center justify-center transition-all duration-300 transform shadow-md ${
                                    tile.status === 'hidden'
                                        ? 'bg-gradient-to-b from-slate-800 to-slate-900 hover:from-slate-700 hover:to-slate-800 border-2 border-slate-700 hover:border-amber-400 hover:scale-105 active:scale-95'
                                        : tile.status === 'gem'
                                        ? 'bg-gradient-to-br from-emerald-500 to-teal-700 border-2 border-emerald-300 text-white shadow-emerald-500/40 animate-flipIn'
                                        : 'bg-gradient-to-br from-rose-600 to-red-900 border-2 border-rose-400 text-white shadow-rose-500/40 animate-bounce'
                                }`}
                            >
                                {tile.status === 'gem' ? <Gem className="w-6 h-6 sm:w-8 sm:h-8 text-emerald-200" /> : tile.status === 'mine' ? <Bomb className="w-6 h-6 sm:w-8 sm:h-8 text-white" /> : null}
                            </button>
                        ))}
                    </div>

                    {/* Current Multiplier Indicator */}
                    {gameState === 'playing' && revealedCount > 0 && (
                        <div className="mt-4 px-6 py-2 rounded-2xl bg-amber-400 text-slate-950 font-black text-base sm:text-lg flex items-center gap-2 animate-pulse shadow-lg">
                            <Trophy className="w-5 h-5" />
                            <span>CURRENT PAYOUT: ৳{(betAmount * currentMultiplier).toFixed(2)} ({currentMultiplier.toFixed(2)}x)</span>
                        </div>
                    )}
                </div>

                {/* Control Panel */}
                <div className="w-full bg-slate-950/90 border border-amber-500/30 rounded-3xl p-4 sm:p-6 shadow-2xl flex flex-col gap-4">
                    <div className="flex items-center justify-between flex-wrap gap-2">
                        {/* Mine Count Selector */}
                        <div className="flex items-center gap-2">
                            <span className="text-xs font-bold text-slate-400 flex items-center gap-1">
                                <Bomb className="w-4 h-4 text-rose-400" /> Mines:
                            </span>
                            <div className="flex gap-1 bg-slate-900 p-1 rounded-xl border border-slate-800">
                                {[1, 3, 5, 10, 24].map(m => (
                                    <button
                                        key={m}
                                        disabled={gameState === 'playing'}
                                        onClick={() => setMineCount(m)}
                                        className={`px-3 py-1 rounded-lg text-xs font-bold transition ${mineCount === m ? 'bg-rose-500 text-white shadow' : 'text-slate-400 hover:text-white'}`}
                                    >
                                        {m}
                                    </button>
                                ))}
                            </div>
                        </div>

                        {/* Quick Chips */}
                        <div className="flex items-center gap-1.5">
                            {[10, 50, 100, 500].map(chip => (
                                <button
                                    key={chip}
                                    disabled={gameState === 'playing'}
                                    onClick={() => setBetAmount(chip)}
                                    className={`px-2.5 py-1 rounded-lg text-xs font-bold font-mono border transition ${betAmount === chip ? 'bg-amber-400 text-slate-950' : 'bg-slate-900 text-slate-300 border-slate-700'}`}
                                >
                                    +{chip}
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* Action Button: Start or Cashout */}
                    {gameState === 'playing' ? (
                        <button
                            onClick={handleCashout}
                            disabled={revealedCount === 0}
                            className={`w-full py-4 rounded-2xl font-black text-lg uppercase tracking-wider shadow-xl transition active:scale-95 flex items-center justify-center gap-2 ${
                                revealedCount > 0
                                    ? 'bg-gradient-to-r from-emerald-400 via-teal-400 to-emerald-500 text-slate-950 ring-2 ring-emerald-300 shadow-emerald-500/40 hover:scale-[1.02]'
                                    : 'bg-slate-800 text-slate-500 cursor-not-allowed'
                            }`}
                        >
                            <Trophy className="w-6 h-6" />
                            CASHOUT ৳{(betAmount * currentMultiplier).toFixed(2)} ({currentMultiplier.toFixed(2)}x)
                        </button>
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
                                    START GAME (শুরু)
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </GameWrapper>
    );
}
