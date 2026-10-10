import React, { useState, useEffect } from 'react';
import GameWrapper from '../../components/GameWrapper';
import { gameAudio } from '../../audio/GameAudio';
import confetti from 'canvas-confetti';
import { Dices, Sparkles, TrendingDown, Equal, TrendingUp } from 'lucide-react';

export default function UnderAndOver7({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [betAmount, setBetAmount] = useState(50);
    const [choice, setChoice] = useState('over'); // 'under', 'equal', 'over'
    const [isDemo, setIsDemo] = useState(!window.IS_AUTH);
    const [isRolling, setIsRolling] = useState(false);
    const [dice, setDice] = useState([3, 4]);
    const [lastSum, setLastSum] = useState(7);
    const [lastWin, setLastWin] = useState(null);
    const [history, setHistory] = useState([]);
    const [statusMessage, setStatusMessage] = useState('Pick Under (<7), Equal (=7), or Over (>7) and Roll!');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.CSRF_TOKEN || '';

    useEffect(() => {
        fetchState();
    }, []);

    const fetchState = async () => {
        try {
            const res = await fetch('/games/under-and-over-7/state');
            const data = await res.json();
            if (data.success) {
                if (data.user_balance !== null && !isDemo) setBalance(data.user_balance);
                if (data.history) setHistory(data.history);
            }
        } catch (e) {
            console.error(e);
        }
    };

    const handleRoll = async () => {
        if (isRolling) return;
        if (betAmount <= 0 || betAmount > balance) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Insufficient balance!');
            return;
        }

        setIsRolling(true);
        setLastWin(null);
        setStatusMessage('Rolling the golden dice...');
        gameAudio.playSFX('roll');

        // Dice roll animation interval
        const rollInterval = setInterval(() => {
            setDice([Math.floor(Math.random() * 6) + 1, Math.floor(Math.random() * 6) + 1]);
        }, 80);

        try {
            const res = await fetch('/games/under-and-over-7/bet', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    amount: betAmount,
                    choice: choice,
                    is_demo: isDemo
                })
            });
            const data = await res.json();
            clearInterval(rollInterval);

            if (!data.success) {
                gameAudio.playSFX('error');
                setStatusMessage('❌ ' + (data.error || 'Betting failed.'));
                setIsRolling(false);
                return;
            }

            const finalDie1 = data.die1 || Math.floor(Math.random() * 6) + 1;
            const finalDie2 = data.die2 || Math.floor(Math.random() * 6) + 1;
            const finalSum = data.sum || (finalDie1 + finalDie2);

            setDice([finalDie1, finalDie2]);
            setLastSum(finalSum);

            if (data.is_win) {
                gameAudio.playSFX(choice === 'equal' ? 'bigwin' : 'win');
                setLastWin(data);
                setStatusMessage(`🎉 WON ৳${Number(data.win_amount).toLocaleString()}! Dice Sum = ${finalSum}`);
                confetti({ particleCount: 70, spread: 80, origin: { y: 0.6 } });
                if (data.new_balance !== undefined && !isDemo) {
                    setBalance(data.new_balance);
                } else {
                    setBalance(prev => prev + data.win_amount);
                }
            } else {
                gameAudio.playSFX('lose');
                setStatusMessage(`🎲 Dice Sum = ${finalSum}. Better luck next roll!`);
                if (data.new_balance !== undefined && !isDemo) {
                    setBalance(data.new_balance);
                } else {
                    setBalance(prev => Math.max(0, prev - betAmount));
                }
            }

            setIsRolling(false);
            fetchState();

        } catch (e) {
            clearInterval(rollInterval);
            gameAudio.playSFX('error');
            setStatusMessage('❌ Network connection error');
            setIsRolling(false);
        }
    };

    const renderDie = (val) => {
        const dotPositions = {
            1: ['col-start-2 row-start-2'],
            2: ['col-start-1 row-start-1', 'col-start-3 row-end-4'],
            3: ['col-start-1 row-start-1', 'col-start-2 row-start-2', 'col-start-3 row-end-4'],
            4: ['col-start-1 row-start-1', 'col-start-3 row-start-1', 'col-start-1 row-end-4', 'col-start-3 row-end-4'],
            5: ['col-start-1 row-start-1', 'col-start-3 row-start-1', 'col-start-2 row-start-2', 'col-start-1 row-end-4', 'col-start-3 row-end-4'],
            6: ['col-start-1 row-start-1', 'col-start-3 row-start-1', 'col-start-1 row-start-2', 'col-start-3 row-start-2', 'col-start-1 row-end-4', 'col-start-3 row-end-4'],
        };

        return (
            <div className="w-20 h-20 sm:w-28 sm:h-28 rounded-2xl bg-gradient-to-br from-amber-100 via-amber-200 to-amber-400 p-3 sm:p-4 shadow-[0_10px_25px_rgba(245,158,11,0.5)] border-2 border-amber-300 grid grid-cols-3 grid-rows-3 gap-1 transform transition duration-300">
                {(dotPositions[val] || []).map((pos, i) => (
                    <div key={i} className={`w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full bg-slate-950 shadow-inner ${pos}`} />
                ))}
            </div>
        );
    };

    return (
        <GameWrapper
            title="Under and Over 7 (Dice)"
            bgImage={config.bg_image || '/images/dice-bg.jpg'}
            bgMusicUrl={config.bg_audio || config.audio_url || null}
            balance={balance}
            onRefreshBalance={fetchState}
            rules="Predict whether the sum of two rolled dice will be Under 7 (<7, pays 2.3x), Exactly 7 (=7, pays 5.8x), or Over 7 (>7, pays 2.3x)."
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4">
                {/* Dice Stage */}
                <div className="w-full relative rounded-3xl bg-gradient-to-b from-indigo-950/90 via-slate-950 to-slate-950 border-4 border-amber-500/40 p-6 sm:p-10 shadow-2xl flex flex-col items-center justify-center min-h-[300px]">
                    <div className="mb-4 px-4 py-1.5 rounded-full bg-slate-900/90 border border-amber-400/40 text-xs sm:text-sm font-bold text-amber-300 shadow">
                        {statusMessage}
                    </div>

                    {/* Dice Display */}
                    <div className="flex items-center justify-center gap-6 sm:gap-10 my-4">
                        <div className={isRolling ? 'animate-spin' : ''}>{renderDie(dice[0])}</div>
                        <div className="text-2xl sm:text-4xl font-black text-amber-400">+</div>
                        <div className={isRolling ? 'animate-spin' : ''}>{renderDie(dice[1])}</div>
                    </div>

                    <div className="mt-2 text-sm sm:text-base font-extrabold text-slate-300 tracking-wider">
                        TOTAL SUM: <span className="text-2xl font-mono text-amber-300">{lastSum}</span>
                    </div>
                </div>

                {/* Choice Selector */}
                <div className="w-full grid grid-cols-3 gap-3">
                    <button
                        onClick={() => {
                            gameAudio.playSFX('click');
                            setChoice('under');
                        }}
                        className={`p-4 rounded-2xl border-2 font-black transition flex flex-col items-center gap-1 shadow-lg ${choice === 'under' ? 'bg-gradient-to-b from-blue-600 to-indigo-800 border-cyan-400 text-white shadow-cyan-500/30 ring-2 ring-cyan-400' : 'bg-slate-900/80 border-slate-800 text-slate-400 hover:border-slate-700'}`}
                    >
                        <TrendingDown className="w-6 h-6 text-cyan-300" />
                        <span className="text-sm sm:text-base uppercase">UNDER 7</span>
                        <span className="text-xs text-cyan-300 font-mono">x2.30 Payout</span>
                    </button>

                    <button
                        onClick={() => {
                            gameAudio.playSFX('click');
                            setChoice('equal');
                        }}
                        className={`p-4 rounded-2xl border-2 font-black transition flex flex-col items-center gap-1 shadow-lg ${choice === 'equal' ? 'bg-gradient-to-b from-amber-500 to-yellow-700 border-yellow-300 text-slate-950 shadow-amber-500/50 ring-2 ring-yellow-400' : 'bg-slate-900/80 border-slate-800 text-slate-400 hover:border-slate-700'}`}
                    >
                        <Equal className="w-6 h-6 text-yellow-300" />
                        <span className="text-sm sm:text-base uppercase">EQUAL 7</span>
                        <span className="text-xs text-yellow-300 font-mono font-bold">x5.80 JACKPOT</span>
                    </button>

                    <button
                        onClick={() => {
                            gameAudio.playSFX('click');
                            setChoice('over');
                        }}
                        className={`p-4 rounded-2xl border-2 font-black transition flex flex-col items-center gap-1 shadow-lg ${choice === 'over' ? 'bg-gradient-to-b from-rose-600 to-red-800 border-rose-400 text-white shadow-rose-500/30 ring-2 ring-rose-400' : 'bg-slate-900/80 border-slate-800 text-slate-400 hover:border-slate-700'}`}
                    >
                        <TrendingUp className="w-6 h-6 text-rose-300" />
                        <span className="text-sm sm:text-base uppercase">OVER 7</span>
                        <span className="text-xs text-rose-300 font-mono">x2.30 Payout</span>
                    </button>
                </div>

                {/* Bet Controls */}
                <div className="w-full bg-slate-950/90 backdrop-blur-xl border border-amber-500/30 rounded-3xl p-4 sm:p-6 shadow-2xl flex flex-col gap-4">
                    <div className="flex items-center justify-between flex-wrap gap-2">
                        <div className="flex items-center gap-2 bg-slate-900 p-1 rounded-xl border border-slate-800">
                            <button
                                onClick={() => setIsDemo(false)}
                                className={`px-4 py-1.5 rounded-lg text-xs font-bold transition ${!isDemo ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950' : 'text-slate-400'}`}
                            >
                                💰 Real Money
                            </button>
                            <button
                                onClick={() => setIsDemo(true)}
                                className={`px-4 py-1.5 rounded-lg text-xs font-bold transition ${isDemo ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white' : 'text-slate-400'}`}
                            >
                                🎮 Demo Mode
                            </button>
                        </div>

                        <div className="flex items-center gap-1.5 flex-wrap">
                            {[10, 50, 100, 500, 1000].map(chip => (
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
                                disabled={isRolling}
                                className="w-full bg-transparent text-amber-300 font-mono font-bold text-lg focus:outline-none"
                            />
                            <button onClick={() => setBetAmount(prev => Math.max(1, Math.floor(prev / 2)))} className="px-2.5 py-1 bg-slate-800 text-xs font-bold rounded-lg text-slate-300">1/2</button>
                            <button onClick={() => setBetAmount(prev => prev * 2)} className="px-2.5 py-1 bg-slate-800 text-xs font-bold rounded-lg text-slate-300">2X</button>
                        </div>
                        <div className="sm:col-span-5">
                            <button
                                onClick={handleRoll}
                                disabled={isRolling}
                                className="w-full py-4 bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 text-slate-950 font-black text-base uppercase tracking-widest rounded-2xl shadow-[0_0_20px_rgba(245,158,11,0.5)] border-2 border-yellow-200 transition hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2"
                            >
                                <Dices className="w-5 h-5" />
                                {isRolling ? 'ROLLING...' : 'ROLL DICE (ডিল করো)'}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </GameWrapper>
    );
}
