import React, { useState, useEffect, useRef } from 'react';
import GameWrapper from '../../components/GameWrapper';
import { gameAudio } from '../../audio/GameAudio';
import confetti from 'canvas-confetti';
import { Plane, Trophy, Sparkles, TrendingUp } from 'lucide-react';

export default function CrashGame({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [betAmount, setBetAmount] = useState(50);
    const [multiplier, setMultiplier] = useState(1.0);
    const [gameState, setGameState] = useState('idle'); // idle, flying, cashed_out, crashed
    const [crashPoint, setCrashPoint] = useState(1.0);
    const [statusMessage, setStatusMessage] = useState('Place your bet and wait for aircraft takeoff');

    const animFrameRef = useRef(null);
    const startTimeRef = useRef(null);

    const handleTakeoff = () => {
        if (betAmount <= 0 || betAmount > balance) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Insufficient balance!');
            return;
        }

        setBalance(prev => Math.max(0, prev - betAmount));
        setGameState('flying');
        setMultiplier(1.0);
        setStatusMessage('Aircraft airborne! Watch multiplier rise...');
        gameAudio.playSFX('spin');

        // Determine crash point
        const target = parseFloat((1.0 + Math.random() * 5 + (Math.random() < 0.2 ? Math.random() * 20 : 0)).toFixed(2));
        setCrashPoint(target);

        startTimeRef.current = performance.now();

        const loop = (now) => {
            const elapsed = (now - startTimeRef.current) / 1000;
            const currentMult = parseFloat((1.0 + Math.pow(elapsed * 0.7, 1.8)).toFixed(2));

            if (currentMult >= target) {
                // Crashed!
                setMultiplier(target);
                setGameState('crashed');
                gameAudio.playSFX('lose');
                setStatusMessage(`💥 FLEW AWAY at ${target}x!`);
                cancelAnimationFrame(animFrameRef.current);
            } else {
                setMultiplier(currentMult);
                animFrameRef.current = requestAnimationFrame(loop);
            }
        };

        animFrameRef.current = requestAnimationFrame(loop);
    };

    const handleCashout = () => {
        if (gameState !== 'flying') return;
        cancelAnimationFrame(animFrameRef.current);

        const win = parseFloat((betAmount * multiplier).toFixed(2));
        setBalance(prev => prev + win);
        setGameState('cashed_out');
        gameAudio.playSFX('cashout');
        confetti({ particleCount: 90, spread: 80, origin: { y: 0.6 } });
        setStatusMessage(`🎉 CASHED OUT: ৳${win.toLocaleString()} (${multiplier}x)!`);
    };

    return (
        <GameWrapper
            title={config.title || "Crash Aviator / HelicopterX"}
            bgImage={config.bg_image || '/images/crash-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            balance={balance}
            rules="The aircraft takes off with an increasing multiplier. Cash out before the plane flies away!"
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4">
                {/* Flight Arena Canvas */}
                <div className="w-full relative rounded-3xl bg-slate-950/95 border-4 border-amber-500/40 p-6 sm:p-10 shadow-2xl flex flex-col items-center justify-center min-h-[340px] overflow-hidden">
                    <div className="absolute inset-0 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:24px_24px] opacity-15"></div>

                    {/* Flight Curve & Plane */}
                    <div className="relative z-10 flex flex-col items-center justify-center">
                        <div className={`p-4 rounded-full bg-slate-900 border-2 border-cyan-400 shadow-[0_0_40px_rgba(6,182,212,0.6)] ${gameState === 'flying' ? 'animate-bounce' : ''}`}>
                            <Plane className="w-12 h-12 text-cyan-400 transform -rotate-45" />
                        </div>
                        <div className="font-mono font-black text-4xl sm:text-6xl text-amber-300 mt-4 tracking-tight drop-shadow-[0_0_20px_rgba(245,158,11,0.6)]">
                            {multiplier.toFixed(2)}x
                        </div>
                    </div>

                    <div className="mt-4 px-4 py-1 rounded-full bg-slate-900 border border-slate-700 text-xs font-bold text-slate-300">
                        {statusMessage}
                    </div>
                </div>

                {/* Bet Control */}
                <div className="w-full bg-slate-950/90 border border-amber-500/30 rounded-3xl p-4 sm:p-6 shadow-2xl flex flex-col gap-4">
                    {gameState === 'flying' ? (
                        <button
                            onClick={handleCashout}
                            className="w-full py-5 bg-gradient-to-r from-emerald-400 via-teal-400 to-emerald-500 text-slate-950 font-black text-xl uppercase tracking-wider rounded-2xl shadow-xl hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2"
                        >
                            <Trophy className="w-6 h-6" />
                            CASHOUT ৳{(betAmount * multiplier).toFixed(2)} ({multiplier}x)
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
                                    onClick={handleTakeoff}
                                    className="w-full py-4 bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 text-slate-950 font-black text-base uppercase tracking-widest rounded-2xl shadow-xl transition hover:scale-[1.02] active:scale-95"
                                >
                                    BET & TAKEOFF
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </GameWrapper>
    );
}
