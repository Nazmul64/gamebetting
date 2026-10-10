import React, { useState, useEffect } from 'react';
import GameWrapper from '../../components/GameWrapper';
import { gameAudio } from '../../audio/GameAudio';
import confetti from 'canvas-confetti';
import { Sparkles, History, Trophy, ShieldCheck, Flame } from 'lucide-react';

const MULTIPLIERS = [
    { label: 'Pair (জোড়া)', mult: 'x1.0', desc: 'Any 2 identical rank cards', color: 'from-blue-500 to-indigo-600' },
    { label: 'Flush (ফ্লাশ)', mult: 'x5.0', desc: '3 cards of same suit', color: 'from-emerald-500 to-teal-600' },
    { label: 'Straight (সোজা)', mult: 'x10.0', desc: '3 consecutive cards', color: 'from-amber-500 to-orange-600' },
    { label: 'Three of a Kind (তিনটি এক)', mult: 'x50.0', desc: '3 same rank cards', color: 'from-purple-500 to-pink-600' },
    { label: 'Straight Flush (রয়েল)', mult: 'x75.0', desc: '3 consecutive same suit', color: 'from-rose-500 to-red-700' },
];

export default function IndianPoker({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [betAmount, setBetAmount] = useState(50);
    const [isDemo, setIsDemo] = useState(!window.IS_AUTH);
    const [isPlaying, setIsPlaying] = useState(false);
    const [cards, setCards] = useState(['back', 'back', 'back']);
    const [revealed, setRevealed] = useState([false, false, false]);
    const [lastWin, setLastWin] = useState(null);
    const [history, setHistory] = useState([]);
    const [statusMessage, setStatusMessage] = useState('Place your bet and press DEAL CARDS');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.CSRF_TOKEN || '';

    useEffect(() => {
        fetchState();
    }, []);

    const fetchState = async () => {
        try {
            const res = await fetch('/games/indian-poker/state');
            const data = await res.json();
            if (data.success) {
                if (data.user_balance !== null && !isDemo) {
                    setBalance(data.user_balance);
                }
                if (data.history) {
                    setHistory(data.history);
                }
            }
        } catch (e) {
            console.error('State fetch error', e);
        }
    };

    const handleDeal = async () => {
        if (isPlaying) return;
        if (betAmount <= 0 || betAmount > balance) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Insufficient balance for this bet!');
            return;
        }

        setIsPlaying(true);
        setRevealed([false, false, false]);
        setCards(['back', 'back', 'back']);
        setLastWin(null);
        setStatusMessage('Shuffling & Dealing 3 Royal Cards...');
        gameAudio.playSFX('shuffle');

        try {
            const res = await fetch('/games/indian-poker/bet', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    amount: betAmount,
                    is_demo: isDemo
                })
            });

            const data = await res.json();

            if (!data.success) {
                gameAudio.playSFX('error');
                setStatusMessage('❌ ' + (data.error || 'Betting failed. Please try again.'));
                setIsPlaying(false);
                return;
            }

            // Deduct local balance immediately or sync from server
            if (data.new_balance !== undefined && !isDemo) {
                setBalance(data.new_balance);
            } else {
                setBalance(prev => Math.max(0, prev - betAmount));
            }

            // Animate card reveal sequentially
            const outcomeCards = data.cards || ['AS', 'KH', 'QD'];

            setTimeout(() => {
                gameAudio.playSFX('deal');
                setRevealed([true, false, false]);
                setCards([outcomeCards[0], 'back', 'back']);
            }, 500);

            setTimeout(() => {
                gameAudio.playSFX('deal');
                setRevealed([true, true, false]);
                setCards([outcomeCards[0], outcomeCards[1], 'back']);
            }, 1000);

            setTimeout(() => {
                gameAudio.playSFX('deal');
                setRevealed([true, true, true]);
                setCards(outcomeCards);

                // Check win result
                if (data.is_win) {
                    gameAudio.playSFX(data.multiplier >= 10 ? 'bigwin' : 'win');
                    setLastWin(data);
                    setStatusMessage(`🎉 ${data.hand_name || 'WINNER'}! Won ৳${Number(data.win_amount).toLocaleString()}`);
                    confetti({
                        particleCount: data.multiplier >= 10 ? 120 : 60,
                        spread: 80,
                        origin: { y: 0.6 }
                    });
                    if (data.new_balance !== undefined && !isDemo) {
                        setBalance(data.new_balance);
                    } else {
                        setBalance(prev => prev + data.win_amount);
                    }
                } else {
                    gameAudio.playSFX('lose');
                    setStatusMessage('Better luck next time! Try another royal hand.');
                }

                setIsPlaying(false);
                fetchState();
            }, 1500);

        } catch (err) {
            gameAudio.playSFX('error');
            setStatusMessage('❌ Network connection error. Please retry.');
            setIsPlaying(false);
        }
    };

    const renderCard = (cardCode, isRev, idx) => {
        if (!isRev || cardCode === 'back') {
            return (
                <div className="w-24 h-36 sm:w-32 sm:h-48 md:w-36 md:h-52 rounded-2xl bg-gradient-to-br from-amber-700 via-yellow-900 to-amber-950 p-1 border-2 border-amber-400/80 shadow-[0_10px_25px_rgba(0,0,0,0.8)] flex items-center justify-center transform transition duration-500 hover:scale-105">
                    <div className="w-full h-full rounded-xl bg-slate-900/90 border border-amber-500/40 flex flex-col items-center justify-center p-2 relative overflow-hidden">
                        <div className="absolute inset-0 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:8px_8px] opacity-20"></div>
                        <Flame className="w-8 h-8 text-amber-400 animate-pulse" />
                        <span className="text-[10px] font-black tracking-widest text-amber-400 mt-2">1X CASINO</span>
                    </div>
                </div>
            );
        }

        const suit = cardCode.slice(-1);
        const rank = cardCode.slice(0, -1);
        const isRed = suit === 'H' || suit === 'D';
        const suitSymbol = suit === 'H' ? '♥' : suit === 'D' ? '♦' : suit === 'S' ? '♠' : '♣';

        return (
            <div className="w-24 h-36 sm:w-32 sm:h-48 md:w-36 md:h-52 rounded-2xl bg-gradient-to-b from-slate-100 to-slate-200 text-slate-900 p-2 sm:p-3 border-2 border-amber-400 shadow-[0_12px_30px_rgba(245,158,11,0.4)] flex flex-col justify-between transform transition duration-500 animate-flipIn select-none">
                <div className="flex flex-col items-start leading-none">
                    <span className={`text-base sm:text-2xl font-black ${isRed ? 'text-rose-600' : 'text-slate-900'}`}>{rank}</span>
                    <span className={`text-sm sm:text-lg ${isRed ? 'text-rose-600' : 'text-slate-900'}`}>{suitSymbol}</span>
                </div>

                <div className="self-center">
                    <span className={`text-3xl sm:text-5xl ${isRed ? 'text-rose-600' : 'text-slate-900'}`}>{suitSymbol}</span>
                </div>

                <div className="flex flex-col items-end leading-none rotate-180">
                    <span className={`text-base sm:text-2xl font-black ${isRed ? 'text-rose-600' : 'text-slate-900'}`}>{rank}</span>
                    <span className={`text-sm sm:text-lg ${isRed ? 'text-rose-600' : 'text-slate-900'}`}>{suitSymbol}</span>
                </div>
            </div>
        );
    };

    return (
        <GameWrapper
            title="Indian Poker 3-Card Casino"
            bgImage={config.bg_image || '/indian-poker/assets/images/bg.jpg'}
            bgMusicUrl={config.bg_audio || config.audio_url || null}
            balance={balance}
            onRefreshBalance={fetchState}
            rules={
                <div className="space-y-3">
                    <p>Indian Poker is a fast-paced 3-card poker game. Select your bet amount and click Deal Cards to draw a 3-card hand.</p>
                    <ul className="list-disc pl-5 space-y-1">
                        <li><strong>Straight Flush:</strong> 3 consecutive cards of same suit (x75.0 Payout)</li>
                        <li><strong>Three of a Kind:</strong> 3 cards of exact same rank (x50.0 Payout)</li>
                        <li><strong>Straight:</strong> 3 sequential cards of any suit (x10.0 Payout)</li>
                        <li><strong>Flush:</strong> 3 cards of same suit (x5.0 Payout)</li>
                        <li><strong>Pair:</strong> 2 matching cards of same rank (x1.0 Payout)</li>
                    </ul>
                </div>
            }
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4">
                {/* Hand Multipliers Grid Bar */}
                <div className="w-full grid grid-cols-2 sm:grid-cols-5 gap-2">
                    {MULTIPLIERS.map((m, idx) => (
                        <div
                            key={idx}
                            className={`p-2 rounded-xl bg-slate-900/80 border border-slate-700/60 backdrop-blur flex flex-col items-center justify-center text-center shadow-md transition hover:border-amber-400 ${lastWin && lastWin.multiplier >= parseFloat(m.mult.replace('x','')) ? 'ring-2 ring-amber-400 bg-amber-950/60' : ''}`}
                        >
                            <span className="text-[10px] sm:text-xs text-slate-300 font-semibold truncate w-full">{m.label}</span>
                            <span className="text-xs sm:text-sm font-black bg-gradient-to-r from-amber-300 to-yellow-500 bg-clip-text text-transparent">{m.mult}</span>
                        </div>
                    ))}
                </div>

                {/* Table & Cards Stage */}
                <div className="w-full relative rounded-3xl bg-gradient-to-b from-emerald-950/90 via-slate-950/95 to-slate-950 border-4 border-amber-500/40 p-6 sm:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.9)] flex flex-col items-center justify-center min-h-[300px] sm:min-h-[360px]">
                    {/* Glowing Aura Effect */}
                    <div className="absolute inset-0 rounded-3xl bg-radial from-amber-500/10 via-transparent to-transparent pointer-events-none"></div>

                    {/* Status Badge */}
                    <div className="mb-6 px-4 py-1.5 rounded-full bg-slate-900/90 border border-amber-400/40 text-xs sm:text-sm font-bold text-amber-300 shadow-lg tracking-wide flex items-center gap-2">
                        <Sparkles className="w-4 h-4 text-yellow-400 animate-spin" />
                        <span>{statusMessage}</span>
                    </div>

                    {/* 3 Royal Cards Container */}
                    <div className="flex items-center justify-center gap-3 sm:gap-6 md:gap-8 z-10">
                        {cards.map((card, i) => (
                            <div key={i} className="perspective-1000">
                                {renderCard(card, revealed[i], i)}
                            </div>
                        ))}
                    </div>

                    {/* Big Win Banner Overlay */}
                    {lastWin && lastWin.is_win && (
                        <div className="mt-4 px-6 py-2 rounded-2xl bg-gradient-to-r from-amber-600 via-yellow-500 to-amber-600 text-slate-950 font-black text-lg sm:text-xl shadow-[0_0_30px_rgba(245,158,11,0.8)] animate-bounce tracking-wider flex items-center gap-2">
                            <Trophy className="w-6 h-6 text-slate-950" />
                            <span>WIN: +৳{Number(lastWin.win_amount).toLocaleString()} ({lastWin.hand_name})</span>
                        </div>
                    )}
                </div>

                {/* Bet Control Panel */}
                <div className="w-full bg-slate-950/90 backdrop-blur-xl border border-amber-500/30 rounded-3xl p-4 sm:p-6 shadow-2xl flex flex-col gap-4">
                    {/* Mode Selector & Quick Actions */}
                    <div className="flex items-center justify-between flex-wrap gap-2">
                        <div className="flex items-center gap-2 bg-slate-900 p-1 rounded-xl border border-slate-800">
                            <button
                                onClick={() => setIsDemo(false)}
                                className={`px-4 py-1.5 rounded-lg text-xs font-bold transition ${!isDemo ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow' : 'text-slate-400 hover:text-white'}`}
                            >
                                💰 Real Money
                            </button>
                            <button
                                onClick={() => setIsDemo(true)}
                                className={`px-4 py-1.5 rounded-lg text-xs font-bold transition ${isDemo ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow' : 'text-slate-400 hover:text-white'}`}
                            >
                                🎮 Demo Mode
                            </button>
                        </div>

                        {/* Quick Chips */}
                        <div className="flex items-center gap-1.5 flex-wrap">
                            {[10, 50, 100, 500, 1000, 5000].map(chip => (
                                <button
                                    key={chip}
                                    onClick={() => {
                                        gameAudio.playSFX('click');
                                        setBetAmount(chip);
                                    }}
                                    className={`px-2.5 py-1 rounded-lg text-xs font-bold font-mono border transition active:scale-95 ${betAmount === chip ? 'bg-amber-400 text-slate-950 border-amber-300 shadow-md' : 'bg-slate-900 text-slate-300 border-slate-700 hover:border-amber-400'}`}
                                >
                                    +{chip}
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* Bet Input & Deal Button */}
                    <div className="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                        <div className="sm:col-span-7 flex items-center gap-2 bg-slate-900 border border-slate-700 rounded-2xl p-2 focus-within:border-amber-400">
                            <span className="text-xs font-bold text-slate-400 uppercase tracking-wider pl-2">Bet (৳):</span>
                            <input
                                type="number"
                                min="1"
                                max="50000"
                                value={betAmount}
                                onChange={(e) => setBetAmount(Math.max(1, Number(e.target.value)))}
                                disabled={isPlaying}
                                className="w-full bg-transparent text-amber-300 font-mono font-bold text-lg focus:outline-none"
                            />
                            <button
                                onClick={() => setBetAmount(prev => Math.max(1, Math.floor(prev / 2)))}
                                className="px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-xs font-bold rounded-lg text-slate-300 transition"
                            >
                                1/2
                            </button>
                            <button
                                onClick={() => setBetAmount(prev => prev * 2)}
                                className="px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-xs font-bold rounded-lg text-slate-300 transition"
                            >
                                2X
                            </button>
                            <button
                                onClick={() => setBetAmount(balance)}
                                className="px-2.5 py-1 bg-slate-800 hover:bg-slate-700 text-xs font-bold rounded-lg text-amber-400 transition"
                            >
                                MAX
                            </button>
                        </div>

                        <div className="sm:col-span-5">
                            <button
                                onClick={handleDeal}
                                disabled={isPlaying}
                                className={`w-full py-4 rounded-2xl font-black text-base uppercase tracking-widest transition-all duration-200 transform shadow-xl flex items-center justify-center gap-2 ${
                                    isPlaying 
                                        ? 'bg-slate-800 text-slate-500 cursor-not-allowed border border-slate-700' 
                                        : 'bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-slate-950 hover:scale-[1.02] active:scale-95 shadow-[0_0_25px_rgba(245,158,11,0.5)] border-2 border-yellow-200'
                                }`}
                            >
                                <Sparkles className="w-5 h-5" />
                                {isPlaying ? 'DEALING...' : 'DEAL CARDS'}
                            </button>
                        </div>
                    </div>
                </div>

                {/* Recent History Table */}
                {history.length > 0 && (
                    <div className="w-full bg-slate-950/70 border border-slate-800 rounded-2xl p-4">
                        <div className="flex items-center gap-2 text-xs font-bold text-slate-400 mb-2">
                            <History className="w-4 h-4 text-amber-400" /> Recent Hands History
                        </div>
                        <div className="flex gap-2 overflow-x-auto pb-2 scrollbar-thin">
                            {history.slice(0, 8).map((h, idx) => (
                                <div
                                    key={idx}
                                    className={`flex-shrink-0 px-3 py-1.5 rounded-xl border text-xs font-medium flex items-center gap-2 ${h.status === 'won' ? 'bg-emerald-950/60 border-emerald-500/40 text-emerald-300' : 'bg-slate-900 border-slate-800 text-slate-400'}`}
                                >
                                    <span>{h.hand_type || 'Loss'}</span>
                                    <span className="font-bold font-mono text-amber-400">{h.status === 'won' ? `+৳${h.win_amount}` : `-৳${h.bet_amount}`}</span>
                                </div>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </GameWrapper>
    );
}
