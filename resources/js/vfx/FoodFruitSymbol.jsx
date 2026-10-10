import React from 'react';
import './FoodFruitVfxStyles.css';

/**
 * FoodFruitSymbol - Symbol component with rich Idle & Match FX
 * Supports:
 * - Idle: Subtle breathe animation, pulse glow, shimmer sweep
 * - Win / Match: Fruit Slice Slash, Juice pop burst, golden ray emission
 * - Candy & Multiplier Bombs: Fuse ticking spark, neon glow
 */
export default function FoodFruitSymbol({
    symbolKey = 'watermelon',
    symbolData = null,
    isWinning = false,
    isSpinning = false
}) {
    const sym = symbolData || { icon: '🍉', name: 'Watermelon' };
    const isBomb = String(symbolKey).toLowerCase().includes('bomb') || String(sym.icon || '').includes('💣');
    const isScatter = String(symbolKey).toLowerCase().includes('scatter') || String(sym.icon || '').includes('🍹') || String(sym.icon || '').includes('🍭');

    // Render symbol visual (Image or Emoji icon)
    const renderVisual = () => {
        if (typeof sym === 'string' && (sym.startsWith('/') || sym.startsWith('http'))) {
            return (
                <img
                    src={sym}
                    alt={symbolKey}
                    className={`w-12 h-12 sm:w-16 sm:h-16 object-contain pointer-events-none drop-shadow-lg transition-transform duration-300 ${
                        isWinning ? 'scale-125' : ''
                    }`}
                />
            );
        }

        const icon = typeof sym === 'object' ? sym.icon : sym;

        return (
            <span
                className={`text-3xl sm:text-4xl md:text-5xl drop-shadow-xl transition-all duration-300 select-none ${
                    isWinning ? 'scale-125 brightness-125' : ''
                }`}
            >
                {icon || '🍉'}
            </span>
        );
    };

    return (
        <div
            className={`relative w-full h-full flex flex-col items-center justify-center p-1 rounded-xl transition-all duration-300 overflow-visible ${
                isWinning 
                    ? 'bg-amber-500/20 ring-2 ring-yellow-400 shadow-[0_0_20px_rgba(251,191,36,0.8)] z-20' 
                    : 'bg-transparent'
            }`}
        >
            {/* Golden Win Burst Rays behind the winning symbol */}
            {isWinning && (
                <div 
                    className="absolute inset-[-12px] pointer-events-none rounded-full bg-[radial-gradient(circle,rgba(251,191,36,0.6)_0%,transparent_70%)] animate-pulse"
                />
            )}

            {/* Symbol Body with Idle Breathe or Win Sliced Animation */}
            <div
                className={`relative flex items-center justify-center ${
                    isSpinning 
                        ? 'blur-[1px] opacity-80' 
                        : isWinning 
                            ? 'symbol-win-sliced' 
                            : isBomb 
                                ? 'symbol-bomb-ticking' 
                                : 'symbol-idle-breathe symbol-idle-glow'
                }`}
            >
                {renderVisual()}

                {/* Slicing Blade Trail Flash on Match */}
                {isWinning && (
                    <div className="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div className="w-24 h-1 bg-gradient-to-r from-transparent via-white to-transparent rotate-[-45deg] shadow-[0_0_12px_#ffffff] animate-ping" />
                    </div>
                )}
            </div>

            {/* Sub-label Name (if available) */}
            {typeof sym === 'object' && sym.name && !isSpinning && (
                <span className={`text-[8px] sm:text-[10px] font-black uppercase tracking-tight text-center mt-0.5 truncate max-w-full drop-shadow ${
                    isWinning ? 'text-yellow-300 font-bold' : 'text-amber-200/70'
                }`}>
                    {sym.name}
                </span>
            )}
        </div>
    );
}
