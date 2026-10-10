import React, { useState, useEffect } from 'react';
import GameWrapper from '../../components/GameWrapper';
import { gameAudio } from '../../audio/GameAudio';
import confetti from 'canvas-confetti';
import { PlusCircle, Hand, Trophy, RotateCcw, Sparkles } from 'lucide-react';

export default function CardGames21({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [betAmount, setBetAmount] = useState(50);
    const [isDemo, setIsDemo] = useState(!window.IS_AUTH);
    const [gameState, setGameState] = useState('idle'); // idle, playing, resolved
    const [betId, setBetId] = useState(null);
    const [playerCards, setPlayerCards] = useState([]);
    const [dealerCards, setDealerCards] = useState([]);
    const [playerScore, setPlayerScore] = useState(0);
    const [dealerScore, setDealerScore] = useState(0);
    const [statusMessage, setStatusMessage] = useState('Place your bet and press DEAL to start');
    const [lastOutcome, setLastOutcome] = useState(null);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.CSRF_TOKEN || '';

    useEffect(() => {
        fetchState();
    }, []);

    const fetchState = async () => {
        try {
            const res = await fetch('/games/card-games-21/state');
            const data = await res.json();
            if (data.success && data.user_balance !== null && !isDemo) {
                setBalance(data.user_balance);
            }
        } catch (e) {
            console.error(e);
        }
    };

    const handleDeal = async () => {
        if (gameState === 'playing') return;
        if (betAmount <= 0 || betAmount > balance) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Insufficient balance!');
            return;
        }

        setGameState('playing');
        setPlayerCards([]);
        setDealerCards([]);
        setLastOutcome(null);
        setStatusMessage('Dealing cards to Player & Dealer...');
        gameAudio.playSFX('shuffle');

        try {
            const res = await fetch('/games/card-games-21/deal', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ amount: betAmount, is_demo: isDemo })
            });
            const data = await res.json();

            if (!data.success) {
                gameAudio.playSFX('error');
                setStatusMessage('❌ ' + (data.error || 'Failed to deal cards.'));
                setGameState('idle');
                return;
            }

            setBetId(data.bet_id);
            if (data.new_balance !== undefined && !isDemo) {
                setBalance(data.new_balance);
            } else {
                setBalance(prev => prev - betAmount);
            }

            // Animate cards arrival
            setTimeout(() => {
                gameAudio.playSFX('deal');
                setPlayerCards(data.player_cards || []);
                setPlayerScore(data.player_score || 0);
            }, 300);

            setTimeout(() => {
                gameAudio.playSFX('deal');
                setDealerCards(data.dealer_cards || []);
                setDealerScore(data.dealer_score || 0);

                if (data.is_completed) {
                    handleGameEnd(data);
                } else {
                    setStatusMessage('Choose HIT for another card or STAND to hold.');
                }
            }, 700);

        } catch (e) {
            gameAudio.playSFX('error');
            setStatusMessage('❌ Connection error');
            setGameState('idle');
        }
    };

    const handleHit = async () => {
        if (gameState !== 'playing') return;
        gameAudio.playSFX('card');
        setStatusMessage('Hitting one card...');

        try {
            const res = await fetch('/games/card-games-21/hit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ bet_id: betId, is_demo: isDemo })
            });
            const data = await res.json();

            if (!data.success) {
                setStatusMessage('❌ ' + (data.error || 'Hit failed.'));
                return;
            }

            setPlayerCards(data.player_cards || []);
            setPlayerScore(data.player_score || 0);

            if (data.is_completed) {
                setDealerCards(data.dealer_cards || []);
                setDealerScore(data.dealer_score || 0);
                handleGameEnd(data);
            }
        } catch (e) {
            setStatusMessage('❌ Error occurred while hitting card.');
        }
    };

    const handleStand = async () => {
        if (gameState !== 'playing') return;
        gameAudio.playSFX('click');
        setStatusMessage('Dealer playing hand...');

        try {
            const res = await fetch('/games/card-games-21/stand', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ bet_id: betId, is_demo: isDemo })
            });
            const data = await res.json();

            if (!data.success) {
                setStatusMessage('❌ ' + (data.error || 'Stand failed.'));
                return;
            }

            setDealerCards(data.dealer_cards || []);
            setDealerScore(data.dealer_score || 0);
            handleGameEnd(data);
        } catch (e) {
            setStatusMessage('❌ Error occurred on stand.');
        }
    };

    const handleGameEnd = (data) => {
        setGameState('resolved');
        setLastOutcome(data);

        if (data.is_win || data.status === 'won') {
            gameAudio.playSFX('win');
            setStatusMessage(`🎉 You WON! +৳${Number(data.win_amount).toLocaleString()}`);
            confetti({ particleCount: 70, spread: 70, origin: { y: 0.6 } });
            if (data.new_balance !== undefined && !isDemo) {
                setBalance(data.new_balance);
            } else {
                setBalance(prev => prev + (data.win_amount || 0));
            }
        } else if (data.status === 'push' || data.is_push) {
            gameAudio.playSFX('coin');
            setStatusMessage('🤝 Push / Tie! Bet refunded.');
            if (data.new_balance !== undefined && !isDemo) {
                setBalance(data.new_balance);
            } else {
                setBalance(prev => prev + betAmount);
            }
        } else {
            gameAudio.playSFX('lose');
            setStatusMessage(`💥 Dealer won. ${data.message || 'Better luck next hand!'}`);
        }
    };

    const renderCard = (cardCode, isDealerHidden = false) => {
        if (isDealerHidden || cardCode === 'back' || !cardCode) {
            return (
                <div className="w-16 h-24 sm:w-24 sm:h-36 rounded-xl bg-gradient-to-br from-indigo-900 to-slate-900 border-2 border-indigo-400/60 shadow-lg flex items-center justify-center p-1">
                    <div className="w-full h-full border border-indigo-500/30 rounded-lg flex items-center justify-center bg-indigo-950/80">
                        <span className="text-xs font-black text-indigo-300">21</span>
                    </div>
                </div>
            );
        }

        const suit = cardCode.slice(-1);
        const rank = cardCode.slice(0, -1);
        const isRed = suit === 'H' || suit === 'D';
        const suitSymbol = suit === 'H' ? '♥' : suit === 'D' ? '♦' : suit === 'S' ? '♠' : '♣';

        return (
            <div className="w-16 h-24 sm:w-24 sm:h-36 rounded-xl bg-slate-100 text-slate-900 border-2 border-amber-400 shadow-md p-1 sm:p-2 flex flex-col justify-between select-none animate-fadeIn">
                <div className="flex justify-between items-start leading-none font-bold text-xs sm:text-base">
                    <span className={isRed ? 'text-rose-600' : 'text-slate-900'}>{rank}</span>
                    <span className={isRed ? 'text-rose-600' : 'text-slate-900'}>{suitSymbol}</span>
                </div>
                <div className="text-center text-xl sm:text-3xl font-black leading-none">
                    <span className={isRed ? 'text-rose-600' : 'text-slate-900'}>{suitSymbol}</span>
                </div>
                <div className="flex justify-between items-end leading-none font-bold text-xs sm:text-base rotate-180">
                    <span className={isRed ? 'text-rose-600' : 'text-slate-900'}>{rank}</span>
                    <span className={isRed ? 'text-rose-600' : 'text-slate-900'}>{suitSymbol}</span>
                </div>
            </div>
        );
    };

    return (
        <GameWrapper
            title="Card Games 21 (Blackjack)"
            bgImage={config.bg_image || '/images/casino-bg.jpg'}
            bgMusicUrl={config.bg_audio || config.audio_url || null}
            balance={balance}
            onRefreshBalance={fetchState}
            rules="Get closer to 21 than the dealer without going over. Cards 2-10 are face value, J/Q/K are 10, Ace is 1 or 11. Payout is 2x on win."
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4">
                {/* Table Field */}
                <div className="w-full relative rounded-3xl bg-gradient-to-b from-emerald-900/90 via-slate-950 to-slate-950 border-4 border-amber-500/40 p-4 sm:p-8 shadow-2xl flex flex-col justify-between min-h-[380px]">
                    {/* Status Pill */}
                    <div className="self-center px-4 py-1.5 rounded-full bg-slate-950/80 border border-amber-500/40 text-xs sm:text-sm font-bold text-amber-300 shadow">
                        {statusMessage}
                    </div>

                    {/* Dealer Section */}
                    <div className="flex flex-col items-center gap-2 my-2">
                        <div className="flex items-center gap-2">
                            <span className="text-xs uppercase font-bold text-slate-400">Dealer Hand</span>
                            {dealerCards.length > 0 && gameState === 'resolved' && (
                                <span className="px-2 py-0.5 rounded-md bg-rose-950 border border-rose-500 text-rose-300 font-mono font-bold text-xs">
                                    Score: {dealerScore}
                                </span>
                            )}
                        </div>
                        <div className="flex items-center justify-center gap-2 min-h-[100px]">
                            {dealerCards.length === 0 ? (
                                <span className="text-xs text-slate-500 italic">Waiting for round...</span>
                            ) : (
                                dealerCards.map((c, i) => (
                                    <div key={i}>{renderCard(c, gameState === 'playing' && i === 1)}</div>
                                ))
                            )}
                        </div>
                    </div>

                    {/* Divider */}
                    <div className="w-full border-t border-dashed border-amber-500/30 my-2 relative flex justify-center">
                        <span className="absolute -top-2.5 px-3 bg-slate-950 text-[10px] uppercase font-bold text-amber-400/80 tracking-widest">
                            21 PAYS 2:1
                        </span>
                    </div>

                    {/* Player Section */}
                    <div className="flex flex-col items-center gap-2 my-2">
                        <div className="flex items-center gap-2">
                            <span className="text-xs uppercase font-bold text-slate-400">Your Hand</span>
                            {playerCards.length > 0 && (
                                <span className="px-2 py-0.5 rounded-md bg-amber-950 border border-amber-500 text-amber-300 font-mono font-bold text-xs">
                                    Score: {playerScore}
                                </span>
                            )}
                        </div>
                        <div className="flex items-center justify-center gap-2 min-h-[100px]">
                            {playerCards.length === 0 ? (
                                <span className="text-xs text-slate-500 italic">Press DEAL to start round</span>
                            ) : (
                                playerCards.map((c, i) => <div key={i}>{renderCard(c)}</div>)
                            )}
                        </div>
                    </div>
                </div>

                {/* Control Panel */}
                <div className="w-full bg-slate-950/90 backdrop-blur-xl border border-amber-500/30 rounded-3xl p-4 sm:p-6 shadow-2xl flex flex-col gap-4">
                    <div className="flex items-center justify-between flex-wrap gap-2">
                        <div className="flex items-center gap-2 bg-slate-900 p-1 rounded-xl border border-slate-800">
                            <button
                                onClick={() => setIsDemo(false)}
                                disabled={gameState === 'playing'}
                                className={`px-4 py-1.5 rounded-lg text-xs font-bold transition ${!isDemo ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow' : 'text-slate-400'}`}
                            >
                                💰 Real Money
                            </button>
                            <button
                                onClick={() => setIsDemo(true)}
                                disabled={gameState === 'playing'}
                                className={`px-4 py-1.5 rounded-lg text-xs font-bold transition ${isDemo ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow' : 'text-slate-400'}`}
                            >
                                🎮 Demo Mode
                            </button>
                        </div>

                        {/* Chips */}
                        <div className="flex items-center gap-1.5 flex-wrap">
                            {[10, 50, 100, 500, 1000].map(chip => (
                                <button
                                    key={chip}
                                    disabled={gameState === 'playing'}
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

                    {/* Action Controls */}
                    {gameState === 'playing' ? (
                        <div className="grid grid-cols-2 gap-3">
                            <button
                                onClick={handleHit}
                                className="py-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-slate-950 font-black rounded-2xl text-base uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg transition active:scale-95"
                            >
                                <PlusCircle className="w-5 h-5" /> HIT (কার্ড নাও)
                            </button>
                            <button
                                onClick={handleStand}
                                className="py-4 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-slate-950 font-black rounded-2xl text-base uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg transition active:scale-95"
                            >
                                <Hand className="w-5 h-5" /> STAND (থাকুক)
                            </button>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                            <div className="sm:col-span-7 flex items-center gap-2 bg-slate-900 border border-slate-700 rounded-2xl p-2 focus-within:border-amber-400">
                                <span className="text-xs font-bold text-slate-400 uppercase tracking-wider pl-2">Bet (৳):</span>
                                <input
                                    type="number"
                                    min="1"
                                    max="50000"
                                    value={betAmount}
                                    onChange={(e) => setBetAmount(Math.max(1, Number(e.target.value)))}
                                    className="w-full bg-transparent text-amber-300 font-mono font-bold text-lg focus:outline-none"
                                />
                                <button
                                    onClick={() => setBetAmount(prev => Math.max(1, Math.floor(prev / 2)))}
                                    className="px-2.5 py-1 bg-slate-800 text-xs font-bold rounded-lg text-slate-300"
                                >
                                    1/2
                                </button>
                                <button
                                    onClick={() => setBetAmount(prev => prev * 2)}
                                    className="px-2.5 py-1 bg-slate-800 text-xs font-bold rounded-lg text-slate-300"
                                >
                                    2X
                                </button>
                            </div>
                            <div className="sm:col-span-5">
                                <button
                                    onClick={handleDeal}
                                    className="w-full py-4 bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 text-slate-950 font-black text-base uppercase tracking-widest rounded-2xl shadow-[0_0_20px_rgba(245,158,11,0.5)] border-2 border-yellow-200 transition hover:scale-[1.02] active:scale-95"
                                >
                                    DEAL (শুরু কর)
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </GameWrapper>
    );
}
