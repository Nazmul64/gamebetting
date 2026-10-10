import React, { useState, useEffect } from 'react';
import { Volume2, VolumeX, Maximize, Minimize, ArrowLeft, HelpCircle, Settings, RefreshCw } from 'lucide-react';
import { gameAudio } from '../audio/GameAudio';

export default function GameWrapper({
    title = 'Casino Game',
    bgImage = null,
    bgMusicUrl = null,
    balance = 0,
    onRefreshBalance = null,
    rules = null,
    children
}) {
    const [isMuted, setIsMuted] = useState(gameAudio.isMuted);
    const [showSettings, setShowSettings] = useState(false);
    const [showRules, setShowRules] = useState(false);
    const [bgmVol, setBgmVol] = useState(gameAudio.bgmVolume);
    const [sfxVol, setSfxVol] = useState(gameAudio.sfxVolume);
    const [isFullscreen, setIsFullscreen] = useState(false);

    useEffect(() => {
        if (bgMusicUrl) {
            gameAudio.setBGM(bgMusicUrl);
        }
        return () => {
            gameAudio.stopBGM();
        };
    }, [bgMusicUrl]);

    const handleToggleMute = () => {
        const muted = gameAudio.toggleMute();
        setIsMuted(muted);
    };

    const handleBgmChange = (e) => {
        const val = parseFloat(e.target.value);
        setBgmVol(val);
        gameAudio.setBGMVolume(val);
    };

    const handleSfxChange = (e) => {
        const val = parseFloat(e.target.value);
        setSfxVol(val);
        gameAudio.setSFXVolume(val);
    };

    const toggleFullscreen = () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(() => {});
            setIsFullscreen(true);
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen().catch(() => {});
                setIsFullscreen(false);
            }
        }
    };

    return (
        <div 
            className="min-h-screen w-full relative flex flex-col justify-between select-none text-slate-100 overflow-x-hidden font-sans"
            style={{
                backgroundImage: bgImage ? `linear-gradient(rgba(10, 14, 26, 0.82), rgba(10, 14, 26, 0.94)), url(${bgImage})` : 'radial-gradient(ellipse at top, #1e1b4b 0%, #090d16 100%)',
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundAttachment: 'fixed',
            }}
        >
            {/* Top Navigation Bar */}
            <header className="sticky top-0 z-40 w-full backdrop-blur-md bg-slate-950/70 border-b border-amber-500/20 px-3 py-2 sm:px-6 sm:py-3 flex items-center justify-between shadow-xl">
                <div className="flex items-center gap-2 sm:gap-4">
                    <a
                        href="/dashboard"
                        className="flex items-center justify-center p-2 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-amber-400 hover:text-amber-300 border border-slate-700 transition active:scale-95"
                        title="Back to Lobby"
                    >
                        <ArrowLeft className="w-5 h-5" />
                    </a>
                    <div>
                        <h1 className="text-base sm:text-lg font-black tracking-wider uppercase bg-gradient-to-r from-amber-200 via-yellow-400 to-amber-500 bg-clip-text text-transparent drop-shadow">
                            {title}
                        </h1>
                        <span className="text-[10px] sm:text-xs text-slate-400 font-medium tracking-wider flex items-center gap-1">
                            <span className="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            PROVABLY FAIR 100%
                        </span>
                    </div>
                </div>

                {/* Balance & Actions */}
                <div className="flex items-center gap-2 sm:gap-3">
                    <div className="flex items-center gap-2 bg-gradient-to-r from-slate-900 to-slate-950 border border-amber-500/40 rounded-xl px-3 py-1.5 shadow-inner">
                        <span className="text-[11px] uppercase tracking-wider text-amber-400 font-bold hidden sm:inline">Balance:</span>
                        <span className="text-sm sm:text-base font-black text-amber-300 tracking-tight font-mono">
                            ৳{Number(balance).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                        </span>
                        {onRefreshBalance && (
                            <button
                                onClick={onRefreshBalance}
                                className="text-slate-400 hover:text-amber-400 transition ml-1"
                                title="Refresh Balance"
                            >
                                <RefreshCw className="w-3.5 h-3.5" />
                            </button>
                        )}
                    </div>

                    <button
                        onClick={handleToggleMute}
                        className={`p-2 rounded-xl border transition ${isMuted ? 'bg-rose-950/50 border-rose-500/40 text-rose-400' : 'bg-slate-800/80 border-slate-700 text-amber-400 hover:text-amber-300'}`}
                        title={isMuted ? 'Unmute Sound' : 'Mute Sound'}
                    >
                        {isMuted ? <VolumeX className="w-5 h-5" /> : <Volume2 className="w-5 h-5" />}
                    </button>

                    <button
                        onClick={() => setShowSettings(!showSettings)}
                        className="p-2 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-300 border border-slate-700 transition"
                        title="Audio & Game Settings"
                    >
                        <Settings className="w-5 h-5" />
                    </button>

                    {rules && (
                        <button
                            onClick={() => setShowRules(true)}
                            className="p-2 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-300 border border-slate-700 transition"
                            title="How to Play"
                        >
                            <HelpCircle className="w-5 h-5" />
                        </button>
                    )}

                    <button
                        onClick={toggleFullscreen}
                        className="hidden sm:flex p-2 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-300 border border-slate-700 transition"
                        title="Toggle Fullscreen"
                    >
                        {isFullscreen ? <Minimize className="w-5 h-5" /> : <Maximize className="w-5 h-5" />}
                    </button>
                </div>
            </header>

            {/* Audio Settings Modal */}
            {showSettings && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm animate-fadeIn">
                    <div className="bg-slate-900 border border-amber-500/30 rounded-2xl p-6 w-full max-w-sm shadow-2xl relative">
                        <h3 className="text-lg font-bold text-amber-400 mb-4 flex items-center gap-2">
                            <Settings className="w-5 h-5" /> Sound & Game Settings
                        </h3>

                        <div className="space-y-4">
                            <div>
                                <div className="flex justify-between text-xs text-slate-300 mb-1">
                                    <span>Background Music (BGM)</span>
                                    <span>{Math.round(bgmVol * 100)}%</span>
                                </div>
                                <input
                                    type="range"
                                    min="0"
                                    max="1"
                                    step="0.05"
                                    value={bgmVol}
                                    onChange={handleBgmChange}
                                    className="w-full accent-amber-400 cursor-pointer h-2 bg-slate-800 rounded-lg"
                                />
                            </div>

                            <div>
                                <div className="flex justify-between text-xs text-slate-300 mb-1">
                                    <span>Sound Effects (SFX)</span>
                                    <span>{Math.round(sfxVol * 100)}%</span>
                                </div>
                                <input
                                    type="range"
                                    min="0"
                                    max="1"
                                    step="0.05"
                                    value={sfxVol}
                                    onChange={handleSfxChange}
                                    className="w-full accent-amber-400 cursor-pointer h-2 bg-slate-800 rounded-lg"
                                />
                            </div>

                            <button
                                onClick={handleToggleMute}
                                className={`w-full py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider border transition ${
                                    isMuted 
                                        ? 'bg-emerald-600/30 text-emerald-400 border-emerald-500/40 hover:bg-emerald-600/40' 
                                        : 'bg-rose-600/30 text-rose-400 border-rose-500/40 hover:bg-rose-600/40'
                                }`}
                            >
                                {isMuted ? '🔊 Unmute All Audio' : '🔇 Mute All Audio'}
                            </button>
                        </div>

                        <button
                            onClick={() => setShowSettings(false)}
                            className="mt-6 w-full py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl font-medium text-sm transition"
                        >
                            Close
                        </button>
                    </div>
                </div>
            )}

            {/* How to Play / Rules Modal */}
            {showRules && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm animate-fadeIn">
                    <div className="bg-slate-900 border border-amber-500/30 rounded-2xl p-6 w-full max-w-lg shadow-2xl relative max-h-[85vh] overflow-y-auto">
                        <h3 className="text-lg font-bold text-amber-400 mb-3 flex items-center gap-2">
                            <HelpCircle className="w-5 h-5" /> Rules & How to Play
                        </h3>
                        <div className="text-slate-300 text-sm space-y-2 leading-relaxed">
                            {typeof rules === 'string' ? <p>{rules}</p> : rules}
                        </div>
                        <button
                            onClick={() => setShowRules(false)}
                            className="mt-6 w-full py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold rounded-xl text-sm transition"
                        >
                            Got It, Let's Play!
                        </button>
                    </div>
                </div>
            )}

            {/* Game Main Body Container */}
            <main className="flex-1 w-full flex flex-col items-center justify-center p-2 sm:p-4 md:p-6 z-10">
                {children}
            </main>
        </div>
    );
}
