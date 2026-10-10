import React, { useState, useEffect } from 'react';
import GameWrapper from '../../components/GameWrapper';
import { gameAudio } from '../../audio/GameAudio';
import { Timer, History, Hash } from 'lucide-react';

export default function TrxWinGo({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [periodNumber, setPeriodNumber] = useState('...');
    const [timeLeft, setTimeLeft] = useState(30);
    const [betAmount, setBetAmount] = useState(20);
    const [selectedBet, setSelectedBet] = useState(null);
    const [statusMessage, setStatusMessage] = useState('TRX Block Hash Lottery: Select Color or Number');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.CSRF_TOKEN || '';

    useEffect(() => {
        fetchState();
        const interval = setInterval(fetchState, 1000);
        return () => clearInterval(interval);
    }, []);

    const fetchState = async () => {
        try {
            const res = await fetch('/games/trx-wingo/state');
            const data = await res.json();
            if (data) {
                setPeriodNumber(data.period_number);
                setTimeLeft(data.time_remaining || 0);
                if (data.user_balance !== null) setBalance(data.user_balance);
            }
        } catch (e) {
            console.error(e);
        }
    };

    const handlePlaceBet = async () => {
        if (!selectedBet) return;
        if (timeLeft <= 5) return;

        try {
            const res = await fetch('/games/trx-wingo/bet', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    bet_type: selectedBet.type,
                    select_value: selectedBet.value,
                    amount: betAmount
                })
            });
            const data = await res.json();
            if (data.success) {
                gameAudio.playSFX('coin');
                setStatusMessage(`✅ Bet placed on ${selectedBet.value}`);
                if (data.new_balance !== undefined) setBalance(data.new_balance);
                setSelectedBet(null);
            }
        } catch (e) {
            gameAudio.playSFX('error');
        }
    };

    return (
        <GameWrapper
            title="Trx WinGo (Tron Block Hash)"
            bgImage={config.bg_image || '/images/trx-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            balance={balance}
            onRefreshBalance={fetchState}
            rules="Trx WinGo uses official TRON blockchain block hashes for provably fair cryptographic outcomes."
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4">
                <div className="w-full bg-slate-900 border-2 border-red-500/40 rounded-3xl p-5 shadow-2xl flex items-center justify-between">
                    <div>
                        <div className="text-xs text-slate-400 font-bold uppercase flex items-center gap-1">
                            <Hash className="w-3.5 h-3.5 text-red-400" /> TRX Period
                        </div>
                        <div className="text-xl sm:text-2xl font-black font-mono text-red-300">{periodNumber}</div>
                    </div>
                    <div className="flex flex-col items-end">
                        <div className="text-xs text-slate-400 font-bold uppercase">Time Remaining</div>
                        <div className="font-mono text-2xl font-black text-red-400 bg-slate-950 px-3 py-1 rounded-xl border border-red-500/40 mt-1">
                            00:{timeLeft < 10 ? `0${timeLeft}` : timeLeft}
                        </div>
                    </div>
                </div>

                <div className="w-full grid grid-cols-3 gap-3">
                    <button
                        onClick={() => setSelectedBet({ type: 'color', value: 'green' })}
                        className={`py-4 rounded-2xl font-black text-sm uppercase transition ${selectedBet?.value === 'green' ? 'bg-emerald-500 text-slate-950 ring-4 ring-emerald-400' : 'bg-emerald-700 text-white'}`}
                    >
                        🟢 GREEN
                    </button>
                    <button
                        onClick={() => setSelectedBet({ type: 'color', value: 'violet' })}
                        className={`py-4 rounded-2xl font-black text-sm uppercase transition ${selectedBet?.value === 'violet' ? 'bg-purple-500 text-slate-950 ring-4 ring-purple-400' : 'bg-purple-700 text-white'}`}
                    >
                        🟣 VIOLET
                    </button>
                    <button
                        onClick={() => setSelectedBet({ type: 'color', value: 'red' })}
                        className={`py-4 rounded-2xl font-black text-sm uppercase transition ${selectedBet?.value === 'red' ? 'bg-rose-500 text-slate-950 ring-4 ring-rose-400' : 'bg-rose-700 text-white'}`}
                    >
                        🔴 RED
                    </button>
                </div>

                <div className="w-full grid grid-cols-5 gap-2 bg-slate-950/80 p-3 rounded-3xl border border-slate-800">
                    {[0, 1, 2, 3, 4, 5, 6, 7, 8, 9].map(num => (
                        <button
                            key={num}
                            onClick={() => setSelectedBet({ type: 'number', value: num })}
                            className={`h-14 rounded-2xl font-black text-xl border-2 transition ${selectedBet?.value === num ? 'bg-amber-400 text-slate-950 border-white' : 'bg-slate-900 text-slate-200 border-slate-800'}`}
                        >
                            {num}
                        </button>
                    ))}
                </div>

                {/* Bet Control */}
                <div className="w-full bg-slate-950/90 border border-amber-500/30 rounded-3xl p-4 shadow-2xl flex flex-col gap-3">
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
                                onClick={handlePlaceBet}
                                disabled={timeLeft <= 5}
                                className="w-full py-3.5 bg-gradient-to-r from-red-500 to-amber-500 text-slate-950 font-black rounded-2xl uppercase tracking-wider"
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
