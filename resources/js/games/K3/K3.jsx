import React, { useState, useEffect } from 'react';
import GameWrapper from '../../components/GameWrapper';
import { gameAudio } from '../../audio/GameAudio';
import { Timer, Dices, History, Sparkles } from 'lucide-react';

export default function K3({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [periodNumber, setPeriodNumber] = useState('...');
    const [timeLeft, setTimeLeft] = useState(30);
    const [betAmount, setBetAmount] = useState(20);
    const [selectedSum, setSelectedSum] = useState(null);
    const [dice, setDice] = useState([2, 3, 5]);
    const [history, setHistory] = useState([]);
    const [statusMessage, setStatusMessage] = useState('Select Total Sum (3 - 18) and place bet');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.CSRF_TOKEN || '';

    useEffect(() => {
        fetchState();
        const interval = setInterval(fetchState, 1000);
        return () => clearInterval(interval);
    }, []);

    const fetchState = async () => {
        try {
            const res = await fetch('/games/k3/state');
            const data = await res.json();
            if (data) {
                setPeriodNumber(data.period_number);
                setTimeLeft(data.time_remaining || 0);
                if (data.user_balance !== null) setBalance(data.user_balance);
                if (data.history) setHistory(data.history);
            }
        } catch (e) {
            console.error(e);
        }
    };

    const handlePlaceBet = async () => {
        if (!selectedSum) {
            setStatusMessage('⚠️ Select a sum total first!');
            return;
        }
        if (timeLeft <= 5) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Betting closed for this round!');
            return;
        }

        try {
            const res = await fetch('/games/k3/bet', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    bet_type: 'total',
                    select_value: selectedSum,
                    amount: betAmount
                })
            });
            const data = await res.json();
            if (data.success) {
                gameAudio.playSFX('coin');
                setStatusMessage(`✅ Bet placed on Sum ${selectedSum} for ৳${betAmount}`);
                if (data.new_balance !== undefined) setBalance(data.new_balance);
                setSelectedSum(null);
            } else {
                gameAudio.playSFX('error');
                setStatusMessage('❌ ' + (data.message || 'Failed'));
            }
        } catch (e) {
            gameAudio.playSFX('error');
        }
    };

    return (
        <GameWrapper
            title="K3 Dice Lottery"
            bgImage={config.bg_image || '/images/k3-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            balance={balance}
            onRefreshBalance={fetchState}
            rules="K3 is a 3-dice lottery. Guess the total sum of 3 dice from 3 to 18 with high multipliers up to 207.36x!"
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4">
                {/* Countdown Card */}
                <div className="w-full bg-slate-900 border-2 border-amber-500/40 rounded-3xl p-5 shadow-2xl flex items-center justify-between">
                    <div>
                        <div className="text-xs text-slate-400 font-bold uppercase">Period</div>
                        <div className="text-xl sm:text-2xl font-black font-mono text-amber-300">{periodNumber}</div>
                    </div>

                    <div className="flex flex-col items-end">
                        <div className="text-xs text-slate-400 font-bold uppercase flex items-center gap-1">
                            <Timer className="w-3.5 h-3.5 text-amber-400" /> Time Left
                        </div>
                        <div className="font-mono text-2xl font-black text-amber-400 bg-slate-950 px-3 py-1 rounded-xl border border-amber-500/40 mt-1">
                            00:{timeLeft < 10 ? `0${timeLeft}` : timeLeft}
                        </div>
                    </div>
                </div>

                <div className="w-full px-4 py-2 rounded-2xl bg-slate-950/80 border border-slate-800 text-xs sm:text-sm font-bold text-amber-300 text-center">
                    {statusMessage}
                </div>

                {/* 3-18 Sum Grid */}
                <div className="w-full grid grid-cols-4 sm:grid-cols-8 gap-2 bg-slate-950/80 p-4 rounded-3xl border border-slate-800">
                    {[3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18].map(s => (
                        <button
                            key={s}
                            onClick={() => setSelectedSum(s)}
                            className={`p-3 rounded-2xl font-black flex flex-col items-center justify-center border-2 transition ${
                                selectedSum === s
                                    ? 'bg-amber-400 border-yellow-200 text-slate-950 ring-4 ring-amber-400/50 scale-105'
                                    : 'bg-slate-900 border-slate-800 text-slate-200 hover:border-slate-700'
                            }`}
                        >
                            <span className="text-lg font-mono">{s}</span>
                            <span className="text-[10px] text-amber-400 font-bold">
                                {s === 3 || s === 18 ? '207x' : s === 4 || s === 17 ? '69x' : s === 5 || s === 16 ? '34x' : s === 6 || s === 15 ? '20x' : s === 7 || s === 14 ? '13x' : s === 8 || s === 13 ? '9.8x' : s === 9 || s === 12 ? '7.6x' : '6.9x'}
                            </span>
                        </button>
                    ))}
                </div>

                {/* Bet Control */}
                <div className="w-full bg-slate-950/90 backdrop-blur-xl border border-amber-500/30 rounded-3xl p-4 sm:p-6 shadow-2xl flex flex-col gap-4">
                    <div className="flex items-center gap-1.5 flex-wrap">
                        {[10, 20, 50, 100, 500, 1000].map(chip => (
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
                                disabled={timeLeft <= 5}
                                className={`w-full py-4 bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 text-slate-950 font-black text-base uppercase tracking-widest rounded-2xl shadow-xl transition active:scale-95 ${
                                    timeLeft <= 5 ? 'opacity-50 cursor-not-allowed' : ''
                                }`}
                            >
                                {timeLeft <= 5 ? 'LOCKED' : `BET ৳${betAmount}`}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </GameWrapper>
    );
}
