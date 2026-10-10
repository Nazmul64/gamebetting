import React, { useEffect, useState } from 'react';
import { Flame, Sparkles } from 'lucide-react';

/**
 * JuiceMeterTank - Dynamic Liquid Physics Reservoir & Cocktail Level-up Meter
 * Fills with dynamic swirling juice on wins/fruit matches and triggers bonus frenzy when maxed!
 */
export default function JuiceMeterTank({
    level = 0, // 0 to 100
    maxLevel = 100,
    themeColor = '#ec4899', // Crimson/Magenta/Golden
    title = 'Juice Frenzy Meter',
    onFrenzy = null
}) {
    const [liquidPercent, setLiquidPercent] = useState(0);

    useEffect(() => {
        const clamped = Math.min(100, Math.max(0, (level / maxLevel) * 100));
        setLiquidPercent(clamped);
        if (clamped >= 100 && onFrenzy) {
            onFrenzy();
        }
    }, [level, maxLevel]);

    const isFrenzy = liquidPercent >= 100;

    return (
        <div className="flex flex-col items-center gap-1.5 w-full max-w-[280px]">
            <div className="flex items-center justify-between w-full px-1 text-[11px] font-black uppercase tracking-wider text-amber-300">
                <span className="flex items-center gap-1">
                    <Sparkles className="w-3.5 h-3.5 text-yellow-400 animate-spin" />
                    {title}
                </span>
                <span className={`font-mono ${isFrenzy ? 'text-amber-400 animate-bounce' : 'text-slate-300'}`}>
                    {isFrenzy ? '🔥 FRENZY ACTIVE!' : `${Math.floor(liquidPercent)}%`}
                </span>
            </div>

            {/* Cocktail/Juice Cylinder Container */}
            <div className="relative w-full h-7 rounded-full bg-slate-950/90 border-2 border-amber-400/50 p-0.5 overflow-hidden shadow-[inset_0_2px_8px_rgba(0,0,0,0.8),0_0_15px_rgba(245,158,11,0.25)] flex items-center">
                {/* Background Glass Highlights */}
                <div className="absolute inset-0 bg-gradient-to-b from-white/10 to-transparent pointer-events-none z-20"></div>
                
                {/* Liquid Fill Bar */}
                <div 
                    className="h-full rounded-full relative overflow-hidden transition-all duration-500 ease-out z-10"
                    style={{
                        width: `${liquidPercent}%`,
                        background: isFrenzy 
                            ? 'linear-gradient(90deg, #ef4444, #f59e0b, #ec4899, #8b5cf6)' 
                            : `linear-gradient(90deg, #dc2626, #f97316, #eab308)`,
                        boxShadow: `0 0 16px ${isFrenzy ? '#f59e0b' : '#ef4444'}`
                    }}
                >
                    {/* Liquid Wave Ripple Overlay */}
                    <div 
                        className="absolute inset-0 opacity-40 bg-[radial-gradient(circle_at_50%_120%,rgba(255,255,255,0.8),transparent)] liquid-wave-anim"
                    />

                    {/* Rising Liquid Bubbles */}
                    <div className="absolute inset-0 flex justify-around pointer-events-none">
                        <span className="w-1.5 h-1.5 rounded-full bg-white/70 liquid-bubble-anim" style={{ animationDelay: '0s' }}></span>
                        <span className="w-2 h-2 rounded-full bg-white/70 liquid-bubble-anim" style={{ animationDelay: '0.6s' }}></span>
                        <span className="w-1 h-1 rounded-full bg-white/70 liquid-bubble-anim" style={{ animationDelay: '1.2s' }}></span>
                        <span className="w-2 h-2 rounded-full bg-white/70 liquid-bubble-anim" style={{ animationDelay: '1.8s' }}></span>
                    </div>
                </div>

                {/* Level Milestones */}
                <div className="absolute inset-0 flex justify-between items-center px-4 pointer-events-none z-20">
                    <span className="w-1 h-2 bg-amber-400/40 rounded"></span>
                    <span className="w-1 h-2 bg-amber-400/40 rounded"></span>
                    <span className="w-1 h-2 bg-amber-400/40 rounded"></span>
                    <span className="text-[10px] font-black text-amber-200 drop-shadow flex items-center gap-0.5">
                        <Flame className="w-3 h-3 text-amber-400 animate-pulse" /> 2X BOOST
                    </span>
                </div>
            </div>
        </div>
    );
}
