import React, { useState, useEffect, useRef } from 'react';
import GameWrapper from './GameWrapper';
import { gameAudio } from '../audio/GameAudio';
import confetti from 'canvas-confetti';
import { Play, Zap, RotateCw, Trophy, Sparkles, Pause, Flame } from 'lucide-react';
import FoodFruitVFXOverlay from '../vfx/FoodFruitVFXOverlay';
import FoodFruitSymbol from '../vfx/FoodFruitSymbol';
import JuiceMeterTank from '../vfx/JuiceMeterTank';
import '../vfx/FoodFruitVfxStyles.css';

export default function SlotEngine({
    title = 'Casino Slot',
    gameKey = 'slot',
    rows = 3,
    cols = 5,
    symbols = {},
    spinUrl = '/games/slot/spin',
    stateUrl = '/games/slot/state',
    bgImage = null,
    bgMusicUrl = null,
    rules = null,
    defaultGrid = null,
    paytable = []
}) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [betAmount, setBetAmount] = useState(20);
    const [isDemo, setIsDemo] = useState(!window.IS_AUTH);
    const [isSpinning, setIsSpinning] = useState(false);
    const [isTurbo, setIsTurbo] = useState(false);
    const [autoSpinCount, setAutoSpinCount] = useState(0);
    const [grid, setGrid] = useState(defaultGrid || generateRandomGrid());
    const [winningLines, setWinningLines] = useState([]);
    const [winningCells, setWinningCells] = useState(new Set());
    const [lastWin, setLastWin] = useState(0);
    const [statusMessage, setStatusMessage] = useState('Press SPIN to squeeze big fruit wins!');
    const [juiceLevel, setJuiceLevel] = useState(25);
    const [isFrenzyActive, setIsFrenzyActive] = useState(false);

    const isSpinningRef = useRef(false);
    const autoSpinRef = useRef(0);
    const vfxRef = useRef(null);
    const reelContainerRef = useRef(null);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.CSRF_TOKEN || '';

    function generateRandomGrid() {
        const symbolKeys = Object.keys(symbols);
        if (symbolKeys.length === 0) return Array(rows).fill(null).map(() => Array(cols).fill('🍒'));
        return Array(rows).fill(null).map(() => 
            Array(cols).fill(null).map(() => symbolKeys[Math.floor(Math.random() * symbolKeys.length)])
        );
    }

    useEffect(() => {
        if (stateUrl) fetchState();
    }, [stateUrl]);

    useEffect(() => {
        autoSpinRef.current = autoSpinCount;
        if (autoSpinCount > 0 && !isSpinningRef.current) {
            handleSpin();
        }
    }, [autoSpinCount]);

    const fetchState = async () => {
        try {
            const res = await fetch(stateUrl);
            const data = await res.json();
            if (data.success && data.user_balance !== null && !isDemo) {
                setBalance(data.user_balance);
            }
        } catch (e) {
            console.error('State load error', e);
        }
    };

    const handleSpin = async () => {
        if (isSpinningRef.current) return;
        if (betAmount <= 0 || betAmount > balance) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Insufficient balance for this spin!');
            setAutoSpinCount(0);
            return;
        }

        isSpinningRef.current = true;
        setIsSpinning(true);
        setWinningLines([]);
        setWinningCells(new Set());
        setLastWin(0);
        setStatusMessage('Reels Spinning...');
        gameAudio.playSFX('spin');

        // Fast dummy spinning reel animation
        const spinInterval = setInterval(() => {
            setGrid(generateRandomGrid());
        }, isTurbo ? 60 : 100);

        try {
            const res = await fetch(spinUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    bet: betAmount,
                    amount: betAmount,
                    bet_amount: betAmount,
                    is_demo: isDemo
                })
            });

            const data = await res.json();
            clearInterval(spinInterval);

            if (!data.success && data.status !== 'success') {
                gameAudio.playSFX('error');
                setStatusMessage('❌ ' + (data.error || data.message || 'Spin failed'));
                isSpinningRef.current = false;
                setIsSpinning(false);
                setAutoSpinCount(0);
                return;
            }

            // Sync balance
            if (data.new_balance !== undefined && !isDemo) {
                setBalance(data.new_balance);
            } else if (data.balance !== undefined && !isDemo) {
                setBalance(data.balance);
            } else {
                setBalance(prev => Math.max(0, prev - betAmount));
            }

            // Determine final grid
            const resultGrid = data.grid || data.grid_matrix || data.matrix || data.initial_grid || generateRandomGrid();
            const winAmount = Number(data.win_amount || data.total_win || data.win || 0);
            const winLines = data.winning_lines || data.lines || [];

            // Delay for reel stop feel
            const stopDelay = isTurbo ? 250 : 800;
            setTimeout(() => {
                setGrid(resultGrid);
                setWinningLines(winLines);
                setLastWin(winAmount);

                // Identify winning cells & trigger Fruit / Candy / Juice VFX
                const winCellSet = new Set();

                if (winAmount > 0) {
                    const isBigWin = winAmount >= betAmount * 5;
                    setStatusMessage(`🎉 WIN! +৳${winAmount.toLocaleString()}`);

                    // Collect win cell positions or match highlights
                    for (let r = 0; r < rows; r++) {
                        for (let c = 0; c < Math.min(cols, 3); c++) {
                            // If first 3 cols have same symbol or line match
                            if (resultGrid[r] && resultGrid[r][0] && resultGrid[r][c] === resultGrid[r][0]) {
                                winCellSet.add(`${r}-${c}`);
                            }
                        }
                    }
                    if (winCellSet.size === 0) {
                        winCellSet.add('1-1');
                        winCellSet.add('1-2');
                        winCellSet.add('1-3');
                    }
                    setWinningCells(winCellSet);

                    // Trigger VFX & Audio
                    gameAudio.playSFX('slice');
                    setTimeout(() => gameAudio.playSFX('splash'), 150);

                    if (reelContainerRef.current && vfxRef.current) {
                        const rect = reelContainerRef.current.getBoundingClientRect();
                        const cellW = rect.width / cols;
                        const cellH = rect.height / rows;

                        // Emit juice splash & fruit slice on winning cells
                        winCellSet.forEach(key => {
                            const [r, c] = key.split('-').map(Number);
                            const symKey = resultGrid[r] ? resultGrid[r][c] : 'watermelon';
                            const symObj = symbols[symKey];
                            const icon = (typeof symObj === 'object' ? symObj.icon : symObj) || '🍉';
                            const posX = (c + 0.5) * cellW;
                            const posY = (r + 0.5) * cellH;

                            vfxRef.current.slice(posX, posY, icon, symKey);
                            vfxRef.current.splash(posX, posY, symKey, 20);
                        });

                        // Check for bombs
                        for (let r = 0; r < rows; r++) {
                            for (let c = 0; c < cols; c++) {
                                const sym = String(resultGrid[r]?.[c] || '').toLowerCase();
                                if (sym.includes('bomb')) {
                                    const posX = (c + 0.5) * cellW;
                                    const posY = (r + 0.5) * cellH;
                                    gameAudio.playSFX('bomb');
                                    vfxRef.current.candyBomb(posX, posY, 10);
                                }
                            }
                        }

                        // Big Win Celebration
                        if (isBigWin) {
                            gameAudio.playSFX('bigwin');
                            vfxRef.current.bigWinRain(4500);
                            confetti({ particleCount: 120, spread: 100, origin: { y: 0.6 } });
                        }
                    }

                    // Fill Juice Reservoir Tank
                    setJuiceLevel(prev => {
                        const next = Math.min(100, prev + 15 + Math.floor(winAmount / 50));
                        if (next >= 100) {
                            setIsFrenzyActive(true);
                            gameAudio.playSFX('frenzy');
                        }
                        return next;
                    });

                    if (data.new_balance !== undefined && !isDemo) {
                        setBalance(data.new_balance);
                    } else if (data.balance !== undefined && !isDemo) {
                        setBalance(data.balance);
                    } else {
                        setBalance(prev => prev + winAmount);
                    }
                } else {
                    setStatusMessage('Good luck on your next fruit squeeze!');
                    setJuiceLevel(prev => Math.min(100, prev + 3));
                }

                isSpinningRef.current = false;
                setIsSpinning(false);

                // Auto-spin logic
                if (autoSpinRef.current > 0) {
                    setTimeout(() => {
                        setAutoSpinCount(prev => prev - 1);
                    }, isTurbo ? 350 : 900);
                }
            }, stopDelay);

        } catch (e) {
            clearInterval(spinInterval);
            gameAudio.playSFX('error');
            setStatusMessage('❌ Network connection error');
            isSpinningRef.current = false;
            setIsSpinning(false);
            setAutoSpinCount(0);
        }
    };

    const handleFrenzyReset = () => {
        setIsFrenzyActive(false);
        setJuiceLevel(20);
        if (vfxRef.current) {
            vfxRef.current.bigWinRain(3000);
        }
    };

    return (
        <GameWrapper
            title={title}
            bgImage={bgImage}
            bgMusicUrl={bgMusicUrl}
            balance={balance}
            onRefreshBalance={fetchState}
            rules={rules}
        >
            <div className="w-full max-w-4xl flex flex-col items-center gap-4 relative">
                {/* Top Status & Juice Meter Header */}
                <div className="w-full flex items-center justify-between flex-wrap gap-2 px-2">
                    <div className="px-4 py-1.5 rounded-full bg-slate-950/90 border border-amber-400/40 text-xs sm:text-sm font-bold text-amber-300 shadow flex items-center gap-2">
                        <Sparkles className="w-4 h-4 text-yellow-400 animate-spin" />
                        <span>{statusMessage}</span>
                    </div>

                    {/* Interactive Liquid Juice Tank */}
                    <JuiceMeterTank
                        level={juiceLevel}
                        maxLevel={100}
                        title="Juice Fill Meter"
                        onFrenzy={() => {
                            gameAudio.playSFX('frenzy');
                            if (vfxRef.current) {
                                vfxRef.current.shake(600);
                            }
                        }}
                    />
                </div>

                {/* Slot Reels Container */}
                <div 
                    ref={reelContainerRef}
                    className="w-full relative rounded-3xl bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 border-4 border-amber-500/50 p-3 sm:p-5 shadow-[0_20px_60px_rgba(0,0,0,0.95)] flex flex-col items-center overflow-hidden"
                >
                    {/* Full Canvas VFX Particle Engine Overlay */}
                    <FoodFruitVFXOverlay ref={vfxRef} />

                    {/* Reels Grid */}
                    <div 
                        className="w-full grid gap-2 sm:gap-3 bg-slate-950/90 p-2 sm:p-4 rounded-2xl border-2 border-slate-800 shadow-inner relative z-10"
                        style={{
                            gridTemplateColumns: `repeat(${cols}, minmax(0, 1fr))`
                        }}
                    >
                        {Array.from({ length: cols }).map((_, colIdx) => (
                            <div 
                                key={colIdx} 
                                className={`flex flex-col gap-2 bg-gradient-to-b from-slate-900 via-slate-800/80 to-slate-900 p-1 sm:p-2 rounded-xl border border-slate-700/60 shadow overflow-hidden ${
                                    isSpinning ? 'animate-pulse' : ''
                                }`}
                            >
                                {Array.from({ length: rows }).map((_, rowIdx) => {
                                    const cell = grid[rowIdx] ? grid[rowIdx][colIdx] : null;
                                    const isWin = winningCells.has(`${rowIdx}-${colIdx}`);
                                    return (
                                        <div
                                            key={rowIdx}
                                            className="h-16 sm:h-24 md:h-28 rounded-lg bg-slate-950/70 border border-slate-700/40 flex items-center justify-center p-1 relative transform transition duration-300 hover:scale-105"
                                        >
                                            <FoodFruitSymbol
                                                symbolKey={cell}
                                                symbolData={symbols[cell]}
                                                isWinning={isWin}
                                                isSpinning={isSpinning}
                                            />
                                        </div>
                                    );
                                })}
                            </div>
                        ))}
                    </div>

                    {/* Win Amount Floating Banner */}
                    {lastWin > 0 && (
                        <div className="mt-3 px-6 py-2 rounded-2xl bg-gradient-to-r from-amber-500 via-yellow-400 to-amber-500 text-slate-950 font-black text-lg sm:text-2xl shadow-[0_0_35px_rgba(245,158,11,0.9)] animate-bounce flex items-center gap-2 z-20">
                            <Trophy className="w-6 h-6 text-slate-950" />
                            <span>WIN: +৳{lastWin.toLocaleString()}</span>
                        </div>
                    )}
                </div>

                {/* Control Panel */}
                <div className="w-full bg-slate-950/90 backdrop-blur-xl border border-amber-500/30 rounded-3xl p-4 sm:p-6 shadow-2xl flex flex-col gap-4">
                    {/* Top Row Modes */}
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

                        {/* Turbo & Auto Options */}
                        <div className="flex items-center gap-2">
                            <button
                                onClick={() => setIsTurbo(!isTurbo)}
                                className={`px-3 py-1.5 rounded-xl border text-xs font-bold flex items-center gap-1 transition ${
                                    isTurbo ? 'bg-amber-500/20 border-amber-400 text-amber-300 ring-1 ring-amber-400' : 'bg-slate-900 border-slate-700 text-slate-400'
                                }`}
                            >
                                <Zap className="w-4 h-4 text-amber-400" /> Turbo
                            </button>

                            {autoSpinCount > 0 ? (
                                <button
                                    onClick={() => setAutoSpinCount(0)}
                                    className="px-3 py-1.5 rounded-xl bg-rose-600/30 border border-rose-500 text-rose-300 text-xs font-bold flex items-center gap-1 animate-pulse"
                                >
                                    <Pause className="w-4 h-4" /> Stop ({autoSpinCount})
                                </button>
                            ) : (
                                <div className="flex items-center gap-1 bg-slate-900 border border-slate-800 p-1 rounded-xl">
                                    {[10, 25, 50].map(cnt => (
                                        <button
                                            key={cnt}
                                            onClick={() => setAutoSpinCount(cnt)}
                                            className="px-2 py-0.5 text-[11px] font-bold text-slate-400 hover:text-amber-300 rounded hover:bg-slate-800"
                                        >
                                            {cnt}
                                        </button>
                                    ))}
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Quick Bet Chips */}
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

                    {/* Bet Amount & Spin Button */}
                    <div className="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                        <div className="sm:col-span-7 flex items-center gap-2 bg-slate-900 border border-slate-700 rounded-2xl p-2">
                            <span className="text-xs font-bold text-slate-400 uppercase tracking-wider pl-2">Bet (৳):</span>
                            <input
                                type="number"
                                min="1"
                                max="50000"
                                value={betAmount}
                                onChange={(e) => setBetAmount(Math.max(1, Number(e.target.value)))}
                                disabled={isSpinning}
                                className="w-full bg-transparent text-amber-300 font-mono font-bold text-lg focus:outline-none"
                            />
                            <button onClick={() => setBetAmount(prev => Math.max(1, Math.floor(prev / 2)))} className="px-2.5 py-1 bg-slate-800 text-xs font-bold rounded-lg text-slate-300">1/2</button>
                            <button onClick={() => setBetAmount(prev => prev * 2)} className="px-2.5 py-1 bg-slate-800 text-xs font-bold rounded-lg text-slate-300">2X</button>
                            <button onClick={() => setBetAmount(balance)} className="px-2.5 py-1 bg-slate-800 text-xs font-bold rounded-lg text-amber-400">MAX</button>
                        </div>

                        <div className="sm:col-span-5">
                            <button
                                onClick={handleSpin}
                                disabled={isSpinning}
                                className={`w-full py-4 rounded-2xl font-black text-base uppercase tracking-widest transition-all duration-200 transform shadow-xl flex items-center justify-center gap-2 ${
                                    isSpinning
                                        ? 'bg-slate-800 text-slate-500 cursor-not-allowed border border-slate-700'
                                        : 'bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-slate-950 hover:scale-[1.02] active:scale-95 shadow-[0_0_25px_rgba(245,158,11,0.5)] border-2 border-yellow-200'
                                }`}
                            >
                                <RotateCw className={`w-5 h-5 ${isSpinning ? 'animate-spin' : ''}`} />
                                {isSpinning ? 'SPINNING...' : 'SPIN (স্পিন করো)'}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </GameWrapper>
    );
}
