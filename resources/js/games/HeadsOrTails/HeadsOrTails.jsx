import React, { useState, useEffect, useRef } from 'react';
import confetti from 'canvas-confetti';
import { Volume2, VolumeX, Home, Play } from 'lucide-react';
import { gameAudio } from '../../audio/GameAudio';

export default function HeadsOrTails({ config = {} }) {
    const [balance, setBalance] = useState(window.USER_BALANCE || 1000);
    const [betAmount, setBetAmount] = useState(50);
    const [choice, setChoice] = useState('heads');
    const [isDemo, setIsDemo] = useState(!window.IS_AUTH);
    const [isFlipping, setIsFlipping] = useState(false);
    const [coinSide, setCoinSide] = useState('heads');
    const [gameMode, setGameMode] = useState('lobby');
    const [doublingStep, setDoublingStep] = useState(1);
    const [currentDoublingWin, setCurrentDoublingWin] = useState(0);
    const [soundMuted, setSoundMuted] = useState(false);
    const [showStakeModal, setShowStakeModal] = useState(false);
    const [showRulesModal, setShowRulesModal] = useState(false);
    const [rulesType, setRulesType] = useState('rules');
    const [statusMessage, setStatusMessage] = useState('MAKE YOUR CHOICE! HEADS OR TAILS?');

    const vfxCanvasRef = useRef(null);
    const fireCanvasRef = useRef(null);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.CSRF_TOKEN || '';

    useEffect(() => {
        fetchState();
    }, []);

    // Rain VFX
    useEffect(() => {
        const canvas = vfxCanvasRef.current;
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let animId;

        const resize = () => {
            canvas.width = canvas.parentElement?.clientWidth || window.innerWidth;
            canvas.height = canvas.parentElement?.clientHeight || window.innerHeight;
        };
        resize();
        window.addEventListener('resize', resize);

        const drops = [];
        const count = Math.floor(canvas.width / 20);
        for (let i = 0; i < count; i++) {
            drops.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                length: 12 + Math.random() * 16,
                speed: 7 + Math.random() * 7,
                opacity: 0.15 + Math.random() * 0.3
            });
        }

        let waveTick = 0;
        const renderWaves = (ctx, width, height) => {
            waveTick += 0.03;
            const baseY = height * 0.68;

            ctx.fillStyle = 'rgba(4, 25, 52, 0.35)';
            ctx.beginPath();
            ctx.moveTo(0, height);
            for (let x = 0; x <= width; x += 16) {
                const y = baseY + Math.sin(x * 0.004 + waveTick * 0.7) * 20 + Math.cos(x * 0.008 + waveTick * 0.4) * 12;
                ctx.lineTo(x, y);
            }
            ctx.lineTo(width, height);
            ctx.closePath();
            ctx.fill();

            ctx.fillStyle = 'rgba(8, 48, 88, 0.45)';
            ctx.beginPath();
            ctx.moveTo(0, height);
            for (let x = 0; x <= width; x += 12) {
                const y = (baseY + 35) + Math.sin(x * 0.006 - waveTick * 0.9) * 24 + Math.cos(x * 0.011 + waveTick * 0.6) * 14;
                ctx.lineTo(x, y);
            }
            ctx.lineTo(width, height);
            ctx.closePath();
            ctx.fill();

            ctx.fillStyle = 'rgba(2, 20, 42, 0.55)';
            ctx.strokeStyle = 'rgba(224, 242, 254, 0.7)';
            ctx.lineWidth = 3.5;
            ctx.beginPath();
            ctx.moveTo(0, height);
            for (let x = 0; x <= width; x += 10) {
                const y = (baseY + 70) + Math.sin(x * 0.008 + waveTick * 1.1) * 25 + Math.sin(x * 0.018 + waveTick * 1.4) * 8;
                ctx.lineTo(x, y);
            }
            ctx.lineTo(width, height);
            ctx.closePath();
            ctx.fill();
            ctx.stroke();

            ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';
            for (let i = 0; i < 18; i++) {
                const px = ((Math.sin(i * 97 + waveTick * 0.5) * 0.5 + 0.5) * width);
                const py = (baseY + 68) + Math.sin(px * 0.008 + waveTick * 1.1) * 25 - (i % 5) * 2;
                ctx.beginPath();
                ctx.arc(px, py, 1.8 + (i % 3), 0, Math.PI * 2);
                ctx.fill();
            }
        };

        const render = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            renderWaves(ctx, canvas.width, canvas.height);

            ctx.lineWidth = 1.2;
            for (let drop of drops) {
                ctx.strokeStyle = `rgba(186, 230, 253, ${drop.opacity})`;
                ctx.beginPath();
                ctx.moveTo(drop.x, drop.y);
                ctx.lineTo(drop.x + drop.length * 0.2, drop.y + drop.length);
                ctx.stroke();

                drop.y += drop.speed;
                drop.x += drop.speed * 0.2;
                if (drop.y > canvas.height) {
                    drop.y = -20;
                    drop.x = Math.random() * canvas.width;
                }
            }
            animId = requestAnimationFrame(render);
        };
        render();

        return () => {
            cancelAnimationFrame(animId);
            window.removeEventListener('resize', resize);
        };
    }, [gameMode]);

    // Fire VFX
    useEffect(() => {
        const canvas = fireCanvasRef.current;
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        canvas.width = 100;
        canvas.height = 100;
        let animId;

        const particles = [];
        for (let i = 0; i < 20; i++) {
            particles.push({
                x: canvas.width * 0.5 + (Math.random() - 0.5) * 16,
                y: canvas.height * 0.7 + Math.random() * 15,
                size: 5 + Math.random() * 8,
                speedY: 1.5 + Math.random() * 2,
                speedX: (Math.random() - 0.5) * 1,
                life: 0,
                maxLife: 20 + Math.random() * 20
            });
        }

        const renderFire = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (let p of particles) {
                p.life++;
                p.y -= p.speedY;
                p.x += p.speedX;
                p.size *= 0.96;

                const ratio = p.life / p.maxLife;
                const r = 255;
                const g = Math.floor(200 * (1 - ratio));
                const b = 0;
                const a = 1 - ratio;

                ctx.fillStyle = `rgba(${r}, ${g}, ${b}, ${a})`;
                ctx.beginPath();
                ctx.arc(p.x, p.y, Math.max(0.1, p.size), 0, Math.PI * 2);
                ctx.fill();

                if (p.life >= p.maxLife || p.size <= 0.5) {
                    p.x = canvas.width * 0.5 + (Math.random() - 0.5) * 16;
                    p.y = canvas.height * 0.7 + Math.random() * 10;
                    p.size = 5 + Math.random() * 8;
                    p.life = 0;
                }
            }
            animId = requestAnimationFrame(renderFire);
        };
        renderFire();

        return () => cancelAnimationFrame(animId);
    }, [gameMode]);

    const fetchState = async () => {
        try {
            const res = await fetch('/games/heads-or-tails/state');
            const data = await res.json();
            if (data && data.user_balance !== null && !isDemo) {
                setBalance(data.user_balance);
            }
        } catch (e) {
            console.error(e);
        }
    };

    const handleToss = async () => {
        if (isFlipping) return;
        if (!isDemo && currentDoublingWin === 0 && betAmount > balance) {
            gameAudio.playSFX('error');
            setStatusMessage('⚠️ Insufficient balance!');
            return;
        }

        setIsFlipping(true);
        setStatusMessage('FLIPPING 3D GOLD COIN...');
        gameAudio.playSFX('coin');

        const isContinuingDoubling = (gameMode === 'doubling' && doublingStep > 1 && currentDoublingWin > 0);

        try {
            const res = await fetch('/games/heads-or-tails/toss', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    amount: betAmount,
                    side: choice,
                    mode: gameMode,
                    step: doublingStep,
                    is_continuing: isContinuingDoubling,
                    is_demo: isDemo
                })
            });
            const data = await res.json();

            setTimeout(() => {
                setIsFlipping(false);

                if (data.error) {
                    gameAudio.playSFX('error');
                    setStatusMessage('❌ ' + data.error);
                    return;
                }

                const winningSide = data.winning_side || 'heads';
                setCoinSide(winningSide);

                if (data.is_win) {
                    gameAudio.playSFX('win');
                    confetti({ particleCount: 80, spread: 70, origin: { y: 0.6 } });

                    if (gameMode === 'doubling') {
                        const winAmt = Number(data.win_amount);
                        setCurrentDoublingWin(winAmt);
                        setStatusMessage('LUCKY YOU! CONTINUE?');
                        if (doublingStep < 7) {
                            setDoublingStep(prev => prev + 1);
                        } else {
                            handleCashout();
                        }
                    } else {
                        setStatusMessage(`YOU WON ${Number(data.win_amount).toLocaleString()} ৳!`);
                        if (data.new_balance !== null && !isDemo) setBalance(data.new_balance);
                        else if (isDemo) setBalance(prev => prev + data.win_amount);
                    }
                } else {
                    gameAudio.playSFX('lose');
                    setStatusMessage('BETTER LUCK NEXT TIME');

                    if (gameMode === 'doubling') {
                        setDoublingStep(1);
                        setCurrentDoublingWin(0);
                    }

                    if (data.new_balance !== null && !isDemo) setBalance(data.new_balance);
                    else if (isDemo && !isContinuingDoubling) setBalance(prev => Math.max(0, prev - betAmount));
                }

                fetchState();
            }, 1200);

        } catch (e) {
            setIsFlipping(false);
            gameAudio.playSFX('error');
            setStatusMessage('❌ Network error');
        }
    };

    const handleCashout = async () => {
        if (currentDoublingWin <= 0) return;
        gameAudio.playSFX('win');
        confetti({ particleCount: 100, spread: 80, origin: { y: 0.5 } });

        try {
            const res = await fetch('/games/heads-or-tails/cashout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    win_amount: currentDoublingWin,
                    is_demo: isDemo
                })
            });
            const data = await res.json();
            if (data.success) {
                setStatusMessage(`💰 CASHED OUT ${currentDoublingWin.toLocaleString()} ৳!`);
                if (data.new_balance !== null && !isDemo) setBalance(data.new_balance);
                else if (isDemo) setBalance(prev => prev + currentDoublingWin);
            }
        } catch (e) {
            console.error(e);
        }

        setDoublingStep(1);
        setCurrentDoublingWin(0);
    };

    return (
        <div className="relative w-full h-[720px] flex flex-col bg-[#020712] text-white overflow-hidden font-sans select-none rounded-2xl border border-amber-500/30 shadow-2xl">
            
            {/* Background Layer */}
            <div
                className="absolute inset-0 bg-cover bg-bottom transition-all duration-700 pointer-events-none"
                style={{
                    backgroundImage: gameMode === 'lobby' 
                        ? "url('/heads-or-tails/start-background.f43dc2bae9fa.jpg')" 
                        : gameMode === 'fixed'
                            ? "url('/heads-or-tails/fix-background.06e37cff9f16.jpg')"
                            : "url('/heads-or-tails/raise-background.1fd52c82dfb4.jpg')"
                }}
            />
            <canvas ref={vfxCanvasRef} className="absolute inset-0 pointer-events-none z-10" />

            {/* Top Bar */}
            <div className="relative z-20 flex items-center justify-between px-6 py-3 bg-slate-950/70 backdrop-blur-md border-b border-slate-800">
                <div className="flex items-center gap-2 text-xs font-bold text-slate-400">
                    <span>1XGAMES</span> / <span>OTHER GAMES</span> / <span className="text-amber-400 font-black">HEADS OR TAILS</span>
                </div>

                <div className="flex items-center gap-4">
                    <div
                        onClick={() => { setRulesType('jackpot'); setShowRulesModal(true); }}
                        className="w-36 h-8 bg-[url('/heads-or-tails/jackpot-header-bg.1b89dcf9335b.png')] bg-contain bg-no-repeat bg-center cursor-pointer hover:scale-105 transition"
                    />
                    <div className="px-3 py-1 rounded-lg bg-slate-900 border border-slate-800 text-amber-400 font-mono font-bold text-xs">
                        {Number(balance).toLocaleString(undefined, {minimumFractionDigits: 2})} ৳
                    </div>
                </div>
            </div>

            {/* Content Switcher */}
            {gameMode === 'lobby' ? (
                /* ================= LOBBY ================= */
                <div className="relative z-20 flex-1 flex flex-col items-center justify-between p-6">
                    <img src="/heads-or-tails/logo-start.8deede2e669d.png" alt="Heads or Tails" className="max-w-[260px] drop-shadow-[0_0_20px_rgba(245,200,66,0.6)]" />

                    <div className="flex flex-col md:flex-row items-stretch justify-center gap-8 max-w-4xl w-full my-4">
                        {/* Fixed Stake */}
                        <div className="flex-1 max-w-[380px] flex flex-col items-center rounded-2xl overflow-hidden shadow-2xl border border-amber-600/40 hover:-translate-y-1 transition duration-300">
                            <div className="w-full h-16 bg-gradient-to-b from-orange-700 via-orange-900 to-amber-950 border-b-2 border-amber-600 flex items-center justify-center relative">
                                <div className="absolute -top-4 w-12 h-12 rounded-full bg-gradient-to-br from-yellow-300 to-amber-800 border-2 border-amber-900 flex items-center justify-center shadow-lg">
                                    <img src="/heads-or-tails/wheel.5b83100ce091.png" alt="Wheel" className="w-8 h-8 object-contain" />
                                </div>
                                <h3 className="font-serif font-black text-sm text-white uppercase drop-shadow">FIXED STAKE</h3>
                            </div>
                            <div className="w-full flex-1 p-6 flex flex-col items-center justify-between min-h-[240px] text-amber-950 text-center text-xs font-bold -mt-3" style={{ backgroundImage: "url('/heads-or-tails/assets/parchment_scroll.png')", backgroundSize: "100% 100%", backgroundRepeat: "no-repeat" }}>
                                <p className="leading-relaxed mt-2">Choose your stake and flip the coin.<br/>Guessed right? Congratulations!<br/>Your stake is doubled! Take your winnings!</p>
                                <button
                                    onClick={() => { gameAudio.playSFX('click'); setGameMode('fixed'); }}
                                    className="w-40 h-12 bg-[url('/heads-or-tails/btnBliks.36ba16bbd08c.png')] bg-contain bg-no-repeat bg-center font-serif font-black text-sm text-green-950 uppercase tracking-widest hover:scale-105 transition mb-1"
                                >
                                    PLAY
                                </button>
                            </div>
                        </div>

                        {/* Doubling Stake */}
                        <div className="flex-1 max-w-[380px] flex flex-col items-center rounded-2xl overflow-hidden shadow-2xl border border-amber-600/40 hover:-translate-y-1 transition duration-300 relative">
                            <div className="w-full h-16 bg-gradient-to-b from-orange-700 via-orange-900 to-amber-950 border-b-2 border-amber-600 flex items-center justify-center relative">
                                <div className="absolute -top-4 flex items-center gap-1">
                                    <img src="/heads-or-tails/assets/coin_icon_gold_10.png" alt="10" className="w-8 h-8 object-contain drop-shadow" />
                                    <img src="/heads-or-tails/assets/coin_icon_gold_kraken.png" alt="Kraken" className="w-8 h-8 object-contain drop-shadow" />
                                </div>
                                <h3 className="font-serif font-black text-sm text-white uppercase drop-shadow">DOUBLING YOUR STAKE</h3>
                                <div className="absolute -right-2 -top-2 w-16 h-16 pointer-events-none">
                                    <canvas ref={fireCanvasRef} className="w-full h-full" />
                                </div>
                            </div>
                            <div className="w-full flex-1 p-6 flex flex-col items-center justify-between min-h-[240px] text-amber-950 text-center text-xs font-bold -mt-3" style={{ backgroundImage: "url('/heads-or-tails/assets/parchment_scroll.png')", backgroundSize: "100% 100%", backgroundRepeat: "no-repeat" }}>
                                <p className="leading-relaxed mt-2">Start with a bet of 5 EUR and flip the coin.<br/>Guessed right? You can take your winnings of 10 EUR<br/>or flip the coin again...</p>
                                <button
                                    onClick={() => { gameAudio.playSFX('click'); setGameMode('doubling'); }}
                                    className="w-40 h-12 bg-[url('/heads-or-tails/btnBliks.36ba16bbd08c.png')] bg-contain bg-no-repeat bg-center font-serif font-black text-sm text-green-950 uppercase tracking-widest hover:scale-105 transition mb-1"
                                >
                                    PLAY
                                </button>
                            </div>
                        </div>
                    </div>

                    <div className="w-full flex items-center justify-between max-w-4xl px-4 mt-2">
                        <div className="w-[280px] h-[92px] bg-[url('/heads-or-tails/assets/lobby_bottom_dock.png')] bg-[length:100%_100%] bg-no-repeat flex items-end justify-center gap-4 pb-3 mx-auto drop-shadow-xl">
                            <button onClick={() => { setRulesType('rules'); setShowRulesModal(true); }} className="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-300 to-amber-700 border-2 border-amber-900 text-amber-950 font-black flex items-center justify-center shadow hover:scale-110 transition">?</button>
                            <button onClick={() => setSoundMuted(!soundMuted)} className="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-300 to-amber-700 border-2 border-amber-900 text-amber-950 flex items-center justify-center shadow hover:scale-110 transition">
                                {soundMuted ? <VolumeX className="w-4 h-4" /> : <Volume2 className="w-4 h-4" />}
                            </button>
                        </div>
                        <div onClick={() => setIsDemo(!isDemo)} className={`absolute right-6 bottom-6 px-4 py-1.5 rounded-md text-xs font-black cursor-pointer uppercase ${isDemo ? 'bg-sky-600 text-white' : 'bg-green-600 text-white'}`}>
                            {isDemo ? '● DEMO MODE' : '● REAL MONEY'}
                        </div>
                    </div>
                </div>
            ) : (
                /* ================= IN-GAME PLAY (EXACT FIT) ================= */
                <div className="relative z-20 flex-1 flex items-stretch justify-between p-4 md:p-6 gap-6">
                    
                    <div className="flex-1 flex flex-col items-center justify-between">
                        
                        {/* Top Banner with Mode Seal & Fire */}
                        <div className="w-[580px] max-w-full h-24 bg-[url('/heads-or-tails/assets/top_banner.png')] bg-[length:100%_100%] bg-no-repeat flex items-center justify-center relative drop-shadow-xl">
                            {gameMode === 'fixed' ? (
                                <div className="absolute -top-5 left-1/2 -translate-x-1/2 flex items-center justify-center">
                                    <img src="/heads-or-tails/wheel.5b83100ce091.png" alt="Wheel" className="w-12 h-12 object-contain" />
                                    <img src="/heads-or-tails/assets/coin_icon_gold_kraken.png" alt="Kraken" className="w-7 h-7 object-contain absolute" />
                                </div>
                            ) : (
                                <div className="absolute -top-5 left-1/2 -translate-x-1/2 flex items-center gap-1">
                                    <img src="/heads-or-tails/assets/coin_icon_gold_kraken.png" alt="Kraken" className="w-7 h-7 object-contain drop-shadow" />
                                    <img src="/heads-or-tails/assets/coin_icon_gold_10.png" alt="10" className="w-7 h-7 object-contain drop-shadow" />
                                </div>
                            )}

                            <span className="font-serif font-black text-xs sm:text-sm tracking-wider text-[#2b1103] uppercase px-12 text-center pt-3 drop-shadow-[0_1px_0_rgba(255,255,255,0.4)]">
                                {statusMessage}
                            </span>
                            
                            {gameMode === 'doubling' && (
                                <div className="absolute right-1 top-2 w-16 h-16 pointer-events-none">
                                    <canvas ref={fireCanvasRef} className="w-full h-full" />
                                </div>
                            )}
                        </div>

                        {/* Free-Floating 3D Coin with Continuous 3D Spin */}
                        <div className="my-auto py-4" style={{ perspective: '1200px' }}>
                            <div
                                className={`w-36 h-36 sm:w-44 sm:h-44 relative ${isFlipping ? 'animate-[spin_0.25s_linear_infinite]' : 'animate-[coin3dSpin_3.5s_linear_infinite]'}`}
                                style={{
                                    transformStyle: 'preserve-3d',
                                }}
                            >
                                <div
                                    className="absolute inset-0 w-full h-full rounded-full"
                                    style={{
                                        backgroundImage: "url('/heads-or-tails/assets/coin_heads.png')",
                                        backgroundSize: 'contain',
                                        backgroundRepeat: 'no-repeat',
                                        backgroundPosition: 'center',
                                        backfaceVisibility: 'hidden',
                                        WebkitBackfaceVisibility: 'hidden',
                                        filter: 'drop-shadow(0 12px 25px rgba(0,0,0,0.9)) drop-shadow(0 0 25px rgba(245,200,66,0.6))'
                                    }}
                                />
                                <div
                                    className="absolute inset-0 w-full h-full rounded-full"
                                    style={{
                                        backgroundImage: "url('/heads-or-tails/assets/coin_tails.png')",
                                        backgroundSize: 'contain',
                                        backgroundRepeat: 'no-repeat',
                                        backgroundPosition: 'center',
                                        transform: 'rotateY(180deg)',
                                        backfaceVisibility: 'hidden',
                                        WebkitBackfaceVisibility: 'hidden',
                                        filter: 'drop-shadow(0 12px 25px rgba(0,0,0,0.9)) drop-shadow(0 0 25px rgba(245,200,66,0.6))'
                                    }}
                                />
                            </div>
                        </div>

                        {/* Bottom Controls Group with Base Plank */}
                        <div className="flex flex-col items-center w-full max-w-[560px]">
                            
                            {/* Choice Pills Row */}
                            <div className="grid grid-cols-2 gap-4 w-full max-w-[420px] -mb-4 z-20">
                                <button
                                    onClick={() => { gameAudio.playSFX('click'); setChoice('heads'); }}
                                    className={`py-2 px-4 rounded-full font-serif font-black text-xs sm:text-sm tracking-wider flex items-center justify-between transition ${choice === 'heads' ? 'bg-gradient-to-r from-sky-400 to-sky-600 text-white ring-2 ring-sky-300 shadow-[0_0_16px_rgba(56,189,248,0.8)]' : 'bg-slate-900/90 text-slate-400 border border-slate-700'}`}
                                >
                                    <img src="/heads-or-tails/assets/coin_icon_gold_kraken.png" alt="Kraken" className="w-7 h-7 object-contain" />
                                    <span>HEADS</span>
                                    <div className="w-5" />
                                </button>
                                <button
                                    onClick={() => { gameAudio.playSFX('click'); setChoice('tails'); }}
                                    className={`py-2 px-4 rounded-full font-serif font-black text-xs sm:text-sm tracking-wider flex items-center justify-between transition ${choice === 'tails' ? 'bg-gradient-to-r from-yellow-400 to-amber-500 text-amber-950 ring-2 ring-yellow-200 shadow-[0_0_16px_rgba(250,204,21,0.8)]' : 'bg-slate-900/90 text-slate-400 border border-slate-700'}`}
                                >
                                    <div className="w-5" />
                                    <span>TAILS</span>
                                    <img src="/heads-or-tails/assets/coin_icon_gold_10.png" alt="10" className="w-7 h-7 object-contain" />
                                </button>
                            </div>

                            {/* Base Plank Dock (Mode Dependent) */}
                            {gameMode === 'fixed' ? (
                                <div className="w-full h-36 bg-[url('/heads-or-tails/assets/fixed_bottom_dock.png')] bg-[length:100%_100%] bg-no-repeat p-3 flex flex-col justify-between drop-shadow-2xl z-10">
                                    <div className="flex flex-col items-center mt-1">
                                        <span className="text-[9.5px] font-black text-[#3b1805] uppercase tracking-wider">YOUR STAKE</span>
                                        <div className="flex items-center gap-2 mt-0.5">
                                            {[10, 20, 50, 100, 250, 500].map(val => (
                                                <button
                                                    key={val}
                                                    onClick={() => { gameAudio.playSFX('click'); setBetAmount(val); }}
                                                    className={`px-2.5 py-0.5 rounded-full text-xs font-mono font-bold transition ${betAmount === val ? 'bg-amber-400 text-amber-950 ring-1 ring-yellow-200' : 'bg-black/60 text-amber-200 border border-amber-800/80'}`}
                                                >
                                                    {val}
                                                </button>
                                            ))}
                                        </div>
                                    </div>

                                    <div className="flex items-center justify-between px-2">
                                        <div className="flex items-center gap-2">
                                            <button onClick={() => { setRulesType('rules'); setShowRulesModal(true); }} className="w-9 h-9 rounded-full bg-gradient-to-br from-yellow-300 to-amber-700 border border-amber-900 text-amber-950 font-black text-xs flex items-center justify-center shadow">?</button>
                                            <button onClick={() => setSoundMuted(!soundMuted)} className="w-9 h-9 rounded-full bg-gradient-to-br from-yellow-300 to-amber-700 border border-amber-900 text-amber-950 text-xs flex items-center justify-center shadow">
                                                {soundMuted ? <VolumeX className="w-3.5 h-3.5" /> : <Volume2 className="w-3.5 h-3.5" />}
                                            </button>
                                        </div>

                                        <button
                                            disabled={isFlipping}
                                            onClick={handleToss}
                                            className={`w-14 h-14 rounded-full bg-gradient-to-b from-sky-400 via-sky-500 to-sky-700 border-2 border-sky-200 text-white flex items-center justify-center shadow-[0_0_20px_rgba(56,189,248,0.9)] hover:scale-110 active:scale-95 transition ${isFlipping ? 'opacity-50 pointer-events-none' : ''}`}
                                        >
                                            <Play className="w-6 h-6 fill-white" />
                                        </button>

                                        <div onClick={() => setShowStakeModal(true)} className="px-4 py-1.5 rounded-2xl bg-[#1c0b02] border border-[#78350f] text-right cursor-pointer hover:border-amber-400 transition flex items-center gap-2">
                                            <span className="font-mono font-bold text-xs text-white">{betAmount}</span>
                                            <span className="text-amber-400 text-xs">✕</span>
                                        </div>
                                    </div>
                                </div>
                            ) : (
                                <div className="w-full h-36 bg-[url('/heads-or-tails/assets/wooden_bottom_plank.png')] bg-[length:100%_100%] bg-no-repeat p-4 flex items-end justify-between drop-shadow-2xl z-10">
                                    <div className="flex items-center gap-2 mb-2">
                                        <button onClick={() => { setRulesType('rules'); setShowRulesModal(true); }} className="w-9 h-9 rounded-full bg-gradient-to-br from-yellow-300 to-amber-700 border border-amber-900 text-amber-950 font-black text-xs flex items-center justify-center shadow">?</button>
                                        <button onClick={() => setSoundMuted(!soundMuted)} className="w-9 h-9 rounded-full bg-gradient-to-br from-yellow-300 to-amber-700 border border-amber-900 text-amber-950 text-xs flex items-center justify-center shadow">
                                            {soundMuted ? <VolumeX className="w-3.5 h-3.5" /> : <Volume2 className="w-3.5 h-3.5" />}
                                        </button>
                                    </div>

                                    <button
                                        disabled={isFlipping}
                                        onClick={handleToss}
                                        className={`w-14 h-14 rounded-full bg-gradient-to-b from-sky-400 via-sky-500 to-sky-700 border-2 border-sky-200 text-white flex items-center justify-center shadow-[0_0_20px_rgba(56,189,248,0.9)] hover:scale-110 active:scale-95 transition mb-3 ${isFlipping ? 'opacity-50 pointer-events-none' : ''}`}
                                    >
                                        <Play className="w-6 h-6 fill-white" />
                                    </button>

                                    <div onClick={() => setShowStakeModal(true)} className="px-4 py-1.5 rounded-2xl bg-[#1c0b02] border border-[#78350f] text-right cursor-pointer hover:border-amber-400 transition mb-2">
                                        <span className="block text-[9px] text-[#fdba74] uppercase font-bold">Current stake:</span>
                                        <span className="font-mono font-bold text-xs text-white">{betAmount} ৳</span>
                                    </div>
                                </div>
                            )}

                        </div>

                    </div>

                    {/* Right Sidebar Panel */}
                    <div className="w-72 hidden lg:flex flex-col items-center">
                        <div className="relative -mb-5 z-10">
                            <button
                                onClick={() => { gameAudio.playSFX('click'); setGameMode('lobby'); }}
                                className="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-300 to-amber-700 border-2 border-amber-900 text-amber-950 flex items-center justify-center shadow-lg hover:scale-110 transition"
                            >
                                <Home className="w-5 h-5" />
                            </button>
                        </div>

                        <div className="w-full h-[520px] bg-[url('/heads-or-tails/assets/ladder_wood_panel.png')] bg-[length:100%_100%] bg-no-repeat p-5 pt-8 flex flex-col gap-1.5 drop-shadow-2xl">
                            <h4 className="font-serif font-black text-[11px] text-[#3b1805] text-center tracking-wider uppercase mb-1 drop-shadow-[0_1px_0_rgba(255,255,255,0.4)]">
                                {gameMode === 'fixed' ? 'FIXED STAKE' : 'DOUBLING YOUR STAKE'}
                            </h4>
                            
                            {gameMode === 'doubling' && (
                                <>
                                    {[7, 6, 5, 4, 3, 2, 1].map(step => {
                                        const mult = Math.pow(2, step);
                                        const isCurrent = step === doublingStep;
                                        const isPast = step < doublingStep;
                                        return (
                                            <div
                                                key={step}
                                                className={`w-full h-8 rounded-full px-4 flex items-center justify-between text-xs font-mono font-bold transition ${isCurrent ? 'bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-300 text-amber-950 scale-105 shadow-[0_0_16px_rgba(250,204,21,0.9)] ring-1 ring-white' : isPast ? 'bg-[#14532d] text-[#4ade80] border border-[#22c55e]' : 'bg-[#2b1103]/85 text-[#fdba74] border border-[#5a2306]'}`}
                                            >
                                                <span>{(betAmount * mult).toLocaleString()} ৳</span>
                                                <span className="text-[10px] uppercase font-black text-[#9a3412]">{mult}X</span>
                                            </div>
                                        );
                                    })}

                                    {currentDoublingWin > 0 && (
                                        <button
                                            onClick={handleCashout}
                                            className="mt-2 w-full py-2 rounded-full bg-gradient-to-b from-green-400 to-green-700 border border-green-300 text-white font-serif font-black text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition"
                                        >
                                            TAKE ({currentDoublingWin.toLocaleString()} ৳)
                                        </button>
                                    )}
                                </>
                            )}
                        </div>
                    </div>

                    {gameMode === 'fixed' && (
                        <div className="hidden lg:flex flex-col items-center">
                            <button
                                onClick={() => { gameAudio.playSFX('click'); setGameMode('lobby'); }}
                                className="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-300 to-amber-700 border-2 border-amber-900 text-amber-950 flex items-center justify-center shadow-lg hover:scale-110 transition"
                            >
                                <Home className="w-5 h-5" />
                            </button>
                        </div>
                    )}

                </div>
            )}

            {/* Stake Modal */}
            {showStakeModal && (
                <div className="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                    <div className="max-w-md w-full bg-gradient-to-b from-orange-800 to-amber-950 border-2 border-amber-600 rounded-3xl p-6 shadow-2xl flex flex-col gap-4">
                        <div className="flex items-center justify-between">
                            <h3 className="font-serif font-black text-amber-200 text-base uppercase">SELECT STAKE</h3>
                            <button onClick={() => setShowStakeModal(false)} className="text-amber-400 text-lg font-bold">✕</button>
                        </div>

                        <div className="flex items-center gap-2">
                            <button onClick={() => setBetAmount(prev => Math.max(10, Math.floor(prev / 2)))} className="w-12 h-10 rounded-xl bg-black/40 border border-amber-700 text-amber-300 font-bold">/2</button>
                            <input
                                type="number"
                                value={betAmount}
                                onChange={(e) => setBetAmount(Math.max(1, Number(e.target.value)))}
                                className="flex-1 h-10 bg-black/60 border border-amber-600 rounded-xl text-center font-mono font-bold text-amber-300"
                            />
                            <button onClick={() => setBetAmount(prev => prev * 2)} className="w-12 h-10 rounded-xl bg-black/40 border border-amber-700 text-amber-300 font-bold">2X</button>
                        </div>

                        <div className="grid grid-cols-4 gap-2">
                            {[10, 50, 100, 250, 500, 1000, 2500, 5000].map(val => (
                                <button
                                    key={val}
                                    onClick={() => setBetAmount(val)}
                                    className={`py-2 rounded-xl text-xs font-mono font-bold border transition ${betAmount === val ? 'bg-amber-400 text-amber-950 border-yellow-200' : 'bg-black/40 text-amber-200 border-amber-800'}`}
                                >
                                    {val} ৳
                                </button>
                            ))}
                        </div>

                        <button
                            onClick={() => setShowStakeModal(false)}
                            className="w-full py-3 rounded-full bg-gradient-to-b from-green-400 to-green-700 border border-green-300 text-white font-serif font-black text-sm uppercase tracking-wider shadow-lg"
                        >
                            CONFIRM STAKE
                        </button>
                    </div>
                </div>
            )}

            {/* Rules Modal */}
            {showRulesModal && (
                <div className="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                    <div className="max-w-md w-full bg-gradient-to-b from-orange-800 to-amber-950 border-2 border-amber-600 rounded-3xl p-6 shadow-2xl flex flex-col gap-4">
                        <div className="flex items-center justify-between">
                            <h3 className="font-serif font-black text-amber-200 text-base uppercase">
                                {rulesType === 'jackpot' ? '1XGAMES JACKPOT' : 'GAME RULES'}
                            </h3>
                            <button onClick={() => setShowRulesModal(false)} className="text-amber-400 text-lg font-bold">✕</button>
                        </div>

                        <div className="max-h-72 overflow-y-auto text-xs text-amber-100/90 leading-relaxed flex flex-col gap-3">
                            <p><b>Fixed Stake Mode:</b> Choose either Heads (Kraken) or Tails (Gold 10) and flip the coin. Guessed right? Your stake is instantly doubled!</p>
                            <p><b>Doubling Stake Mode:</b> Start with a base bet. Each consecutive correct prediction doubles your payout up to 128X at Step 7! You can take your winnings at any point or flip again.</p>
                        </div>

                        <button
                            onClick={() => setShowRulesModal(false)}
                            className="w-full py-2.5 rounded-full bg-gradient-to-b from-amber-500 to-amber-700 border border-yellow-200 text-amber-950 font-serif font-black text-xs uppercase tracking-wider shadow-lg"
                        >
                            CLOSE
                        </button>
                    </div>
                </div>
            )}

        </div>
    );
}
