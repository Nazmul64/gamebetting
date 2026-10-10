import React, { useState, useEffect } from 'react';
import GameWrapper from '../../components/GameWrapper';
import { gameAudio } from '../../audio/GameAudio';
import confetti from 'canvas-confetti';
import { Timer, History, Sparkles, TrendingUp, CircleDot } from 'lucide-react';

const TIME_TABS = [
    { label: 'Win Go 30s', type: '30s' },
    { label: 'Win Go 1Min', type: '1m' },
    { label: 'Win Go 3Min', type: '3m' },
    { label: 'Win Go 5Min', type: '5m' },
];

export default function WinGo({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [timeType, setTimeType] = useState('30s');
    const [periodNumber, setPeriodNumber] = useState('...');
    const [timeLeft, setTimeLeft] = useState(30);
    const [betAmount, setBetAmount] = useState(20);
    const [selectedBet, setSelectedBet] = useState(null); // { type: 'color'|'number'|'size', value: 'green'|'red'|'violet'|0..9|'big'|'small' }
    const [history, setHistory] = useState([]);
    const [statusMessage, setStatusMessage] = useState('Select Color, Number or Size to place bet');
    const [isSubmitting, setIsSubmitting] = useState(false);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.CSRF_TOKEN || '';

    useEffect(() => {
        fetchState();
        const interval = setInterval(fetchState, 1000);
        return () => clearInterval(interval);
    }, [timeType]);

    const fetchState = async () => {
        try {
            const res = await fetch(`/games/wingo/state?type=${timeType}`);
            const data = await res.json();
            if (data) {
                setPeriodNumber(data.period_number);
                setTimeLeft(data.time_remaining || 0);
                if (data.user_balance !== null) {
                    setBalance(data.user_balance);
                }
                if (data.history) {
                    setHistory(data.history);
                }
            }
        } catch (e) {
            console.error(e);
        }
    };

    const handlePlaceBet = async () => {
        if (!selectedBet) {
            setStatusMessage('⚠️ Please select a color, number or size first!');
            return;
        }
        if (timeLeft <= 5) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Betting closed for this period! Wait for next round.');
            return;
        }
        if (betAmount <= 0 || betAmount > balance) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Insufficient balance!');
            return;
        }

        setIsSubmitting(true);
        gameAudio.playSFX('bet');

        try {
            const res = await fetch('/games/wingo/bet', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    time_type: timeType,
                    bet_type: selectedBet.type,
                    select_value: selectedBet.value,
                    amount: betAmount
                })
            });

            const data = await res.json();
            if (data.success) {
                gameAudio.playSFX('coin');
                setStatusMessage(`✅ Bet placed on ${selectedBet.value.toString().toUpperCase()} for ৳${betAmount}!`);
                if (data.new_balance !== undefined) setBalance(data.new_balance);
                setSelectedBet(null);
            } else {
                gameAudio.playSFX('error');
                setStatusMessage('❌ ' + (data.message || data.error || 'Bet placement failed.'));
            }
        } catch (e) {
            gameAudio.playSFX('error');
            setStatusMessage('❌ Network connection error');
        } finally {
            setIsSubmitting(false);
        }
    };

    const getNumberColorClass = (num) => {
        if (num === 0) return 'bg-gradient-to-br from-rose-500 to-purple-600';
        if (num === 5) return 'bg-gradient-to-br from-emerald-500 to-purple-600';
        if ([1, 3, 7, 9].includes(num)) return 'bg-emerald-600';
        return 'bg-rose-600';
    };

    return (
        <GameWrapper
            title="WinGo Color Prediction Lottery"
            bgImage={config.bg_image || '/images/wingo-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            balance={balance}
            onRefreshBalance={fetchState}
            rules="WinGo is a 30s-5m color & number lottery. Green/Red pays 2x, Violet pays 4.5x, exact numbers 0-9 pay 9x, Big/Small pays 2x!"
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4">
                {/* Time Type Tabs */}
                <div className="w-full grid grid-cols-4 gap-2 bg-slate-950/80 p-1.5 rounded-2xl border border-slate-800">
                    {TIME_TABS.map(tab => (
                        <button
                            key={tab.type}
                            onClick={() => {
                                gameAudio.playSFX('click');
                                setTimeType(tab.type);
                            }}
                            className={`py-2 rounded-xl text-xs font-bold transition ${
                                timeType === tab.type
                                    ? 'bg-gradient-to-r from-amber-500 to-yellow-500 text-slate-950 shadow-md font-extrabold'
                                    : 'text-slate-400 hover:text-white'
                            }`}
                        >
                            {tab.label}
                        </button>
                    ))}
                </div>

                {/* Period & Countdown Timer Card */}
                <div className="w-full bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 border-2 border-amber-500/40 rounded-3xl p-5 shadow-2xl flex items-center justify-between">
                    <div>
                        <div className="text-xs text-slate-400 font-bold uppercase tracking-wider">Current Period</div>
                        <div className="text-lg sm:text-2xl font-black font-mono text-amber-300 tracking-wide mt-0.5">
                            {periodNumber}
                        </div>
                    </div>

                    <div className="flex flex-col items-end">
                        <div className="text-xs text-slate-400 font-bold uppercase tracking-wider flex items-center gap-1">
                            <Timer className="w-3.5 h-3.5 text-amber-400 animate-pulse" /> Time Remaining
                        </div>
                        <div className="flex items-center gap-1 mt-1 font-mono">
                            <span className="px-2.5 py-1 bg-slate-950 border border-amber-500/40 rounded-lg text-lg sm:text-2xl font-black text-amber-400">
                                00
                            </span>
                            <span className="text-amber-400 font-bold">:</span>
                            <span className={`px-2.5 py-1 bg-slate-950 border rounded-lg text-lg sm:text-2xl font-black ${
                                timeLeft <= 5 ? 'text-rose-500 border-rose-500 animate-ping' : 'text-amber-400 border-amber-500/40'
                            }`}>
                                {timeLeft < 10 ? `0${timeLeft}` : timeLeft}
                            </span>
                        </div>
                    </div>
                </div>

                {/* Status Message */}
                <div className="w-full px-4 py-2 rounded-2xl bg-slate-950/80 border border-slate-800 text-xs sm:text-sm font-bold text-amber-300 text-center shadow">
                    {statusMessage}
                </div>

                {/* Betting Buttons: Colors */}
                <div className="w-full grid grid-cols-3 gap-3">
                    <button
                        onClick={() => setSelectedBet({ type: 'color', value: 'green' })}
                        className={`py-4 rounded-2xl font-black text-sm sm:text-base uppercase tracking-wider transition transform hover:scale-102 active:scale-95 shadow-lg border-2 ${
                            selectedBet?.value === 'green'
                                ? 'bg-emerald-500 border-white text-slate-950 ring-4 ring-emerald-400/50'
                                : 'bg-gradient-to-r from-emerald-600 to-teal-700 border-emerald-500/50 text-white'
                        }`}
                    >
                        🟢 GREEN (x2)
                    </button>

                    <button
                        onClick={() => setSelectedBet({ type: 'color', value: 'violet' })}
                        className={`py-4 rounded-2xl font-black text-sm sm:text-base uppercase tracking-wider transition transform hover:scale-102 active:scale-95 shadow-lg border-2 ${
                            selectedBet?.value === 'violet'
                                ? 'bg-purple-500 border-white text-slate-950 ring-4 ring-purple-400/50'
                                : 'bg-gradient-to-r from-purple-600 to-indigo-700 border-purple-500/50 text-white'
                        }`}
                    >
                        🟣 VIOLET (x4.5)
                    </button>

                    <button
                        onClick={() => setSelectedBet({ type: 'color', value: 'red' })}
                        className={`py-4 rounded-2xl font-black text-sm sm:text-base uppercase tracking-wider transition transform hover:scale-102 active:scale-95 shadow-lg border-2 ${
                            selectedBet?.value === 'red'
                                ? 'bg-rose-500 border-white text-slate-950 ring-4 ring-rose-400/50'
                                : 'bg-gradient-to-r from-rose-600 to-red-700 border-rose-500/50 text-white'
                        }`}
                    >
                        🔴 RED (x2)
                    </button>
                </div>

                {/* Numbers Grid (0 - 9) */}
                <div className="w-full grid grid-cols-5 gap-2 sm:gap-3 bg-slate-950/80 p-3 sm:p-4 rounded-3xl border border-slate-800">
                    {[0, 1, 2, 3, 4, 5, 6, 7, 8, 9].map(num => (
                        <button
                            key={num}
                            onClick={() => setSelectedBet({ type: 'number', value: num })}
                            className={`h-14 sm:h-16 rounded-2xl font-black text-lg sm:text-2xl flex flex-col items-center justify-center transition transform hover:scale-105 active:scale-95 shadow border-2 ${getNumberColorClass(num)} ${
                                selectedBet?.type === 'number' && selectedBet?.value === num
                                    ? 'border-yellow-300 ring-4 ring-yellow-400/60 scale-105'
                                    : 'border-transparent text-white'
                            }`}
                        >
                            <span>{num}</span>
                            <span className="text-[9px] font-bold text-white/80">x9.0</span>
                        </button>
                    ))}
                </div>

                {/* Big / Small Choice */}
                <div className="w-full grid grid-cols-2 gap-3">
                    <button
                        onClick={() => setSelectedBet({ type: 'size', value: 'big' })}
                        className={`py-3.5 rounded-2xl font-black text-sm sm:text-base uppercase tracking-wider border-2 transition ${
                            selectedBet?.value === 'big'
                                ? 'bg-amber-400 border-white text-slate-950 ring-4 ring-amber-400/50'
                                : 'bg-gradient-to-r from-amber-600 to-orange-700 border-amber-500/50 text-white'
                        }`}
                    >
                        BIG (5-9) x2.0
                    </button>
                    <button
                        onClick={() => setSelectedBet({ type: 'size', value: 'small' })}
                        className={`py-3.5 rounded-2xl font-black text-sm sm:text-base uppercase tracking-wider border-2 transition ${
                            selectedBet?.value === 'small'
                                ? 'bg-cyan-400 border-white text-slate-950 ring-4 ring-cyan-400/50'
                                : 'bg-gradient-to-r from-cyan-600 to-blue-700 border-cyan-500/50 text-white'
                        }`}
                    >
                        SMALL (0-4) x2.0
                    </button>
                </div>

                {/* Bet Control Panel */}
                <div className="w-full bg-slate-950/90 backdrop-blur-xl border border-amber-500/30 rounded-3xl p-4 sm:p-6 shadow-2xl flex flex-col gap-4">
                    <div className="flex items-center gap-1.5 flex-wrap">
                        {[10, 20, 50, 100, 500, 1000, 5000].map(chip => (
                            <button
                                key={chip}
                                onClick={() => {
                                    gameAudio.playSFX('click');
                                    setBetAmount(chip);
                                }}
                                className={`px-2.5 py-1 rounded-lg text-xs font-bold font-mono border transition ${betAmount === chip ? 'bg-amber-400 text-slate-950 border-amber-300' : 'bg-slate-900 text-slate-300 border-slate-700'}`}
                            >
                                +{chip}
                            </button>
                        ))}
                    </div>

                    <div className="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                        <div className="sm:col-span-7 flex items-center gap-2 bg-slate-900 border border-slate-700 rounded-2xl p-2">
                            <span className="text-xs font-bold text-slate-400 uppercase tracking-wider pl-2">Bet (৳):</span>
                            <input
                                type="number"
                                min="1"
                                max="50000"
                                value={betAmount}
                                onChange={(e) => setBetAmount(Math.max(1, Number(e.target.value)))}
                                className="w-full bg-transparent text-amber-300 font-mono font-bold text-lg focus:outline-none"
                            />
                            <button onClick={() => setBetAmount(prev => Math.max(1, Math.floor(prev / 2)))} className="px-2.5 py-1 bg-slate-800 text-xs font-bold rounded-lg text-slate-300">1/2</button>
                            <button onClick={() => setBetAmount(prev => prev * 2)} className="px-2.5 py-1 bg-slate-800 text-xs font-bold rounded-lg text-slate-300">2X</button>
                        </div>
                        <div className="sm:col-span-5">
                            <button
                                onClick={handlePlaceBet}
                                disabled={isSubmitting || timeLeft <= 5}
                                className={`w-full py-4 bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 text-slate-950 font-black text-base uppercase tracking-widest rounded-2xl shadow-[0_0_20px_rgba(245,158,11,0.5)] border-2 border-yellow-200 transition hover:scale-[1.02] active:scale-95 ${
                                    timeLeft <= 5 ? 'opacity-50 cursor-not-allowed' : ''
                                }`}
                            >
                                {timeLeft <= 5 ? 'LOCKED (লক)' : `BET ৳${betAmount}`}
                            </button>
                        </div>
                    </div>
                </div>

                {/* History Table */}
                {history.length > 0 && (
                    <div className="w-full bg-slate-950/80 border border-slate-800 rounded-3xl p-4">
                        <div className="flex items-center gap-2 text-xs font-bold text-slate-400 mb-3">
                            <History className="w-4 h-4 text-amber-400" /> Recent Lottery Results
                        </div>
                        <div className="overflow-x-auto">
                            <table className="w-full text-left text-xs">
                                <thead>
                                    <tr className="border-b border-slate-800 text-slate-400">
                                        <th className="py-2">Period</th>
                                        <th className="py-2">Number</th>
                                        <th className="py-2">Size</th>
                                        <th className="py-2">Color</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {history.slice(0, 8).map((h, i) => (
                                        <tr key={i} className="border-b border-slate-900/60 font-mono">
                                            <td className="py-2 text-slate-300">{h.period_number}</td>
                                            <td className="py-2 font-bold text-amber-400 text-sm">{h.winning_number}</td>
                                            <td className="py-2 uppercase font-bold text-slate-300">{h.winning_size}</td>
                                            <td className="py-2">
                                                <span className={`px-2 py-0.5 rounded-full text-[10px] font-bold uppercase text-white ${
                                                    h.winning_color === 'green' ? 'bg-emerald-600' : h.winning_color === 'violet' ? 'bg-purple-600' : 'bg-rose-600'
                                                }`}>
                                                    {h.winning_color}
                                                </span>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}
            </div>
        </GameWrapper>
    );
}
