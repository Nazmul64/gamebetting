import React, { useEffect, useRef, useImperativeHandle, forwardRef, useState } from 'react';
import { JuiceParticleEngine } from './JuiceParticleEngine';
import './FoodFruitVfxStyles.css';

/**
 * FoodFruitVFXOverlay - Full-screen / In-Reel HTML5 Canvas Particle Engine & VFX Controller
 */
const FoodFruitVFXOverlay = forwardRef(({ isShaking = false }, ref) => {
    const canvasRef = useRef(null);
    const engineRef = useRef(null);
    const [shakeClass, setShakeClass] = useState('');

    useEffect(() => {
        if (canvasRef.current) {
            engineRef.current = new JuiceParticleEngine(canvasRef.current);
        }

        return () => {
            if (engineRef.current) {
                engineRef.current.destroy();
            }
        };
    }, []);

    const triggerScreenShake = (duration = 450) => {
        setShakeClass('vfx-screen-shake');
        setTimeout(() => {
            setShakeClass('');
        }, duration);
    };

    useImperativeHandle(ref, () => ({
        splash: (x, y, fruitType, count) => {
            if (engineRef.current) {
                engineRef.current.emitJuiceSplash(x, y, fruitType, count);
            }
        },
        slice: (x, y, icon, fruitType) => {
            if (engineRef.current) {
                engineRef.current.emitFruitSlice(x, y, icon, fruitType);
            }
        },
        candyBomb: (x, y, multiplier) => {
            if (engineRef.current) {
                engineRef.current.emitCandyBombBlast(x, y, multiplier);
                triggerScreenShake(500);
            }
        },
        bigWinRain: (durationMs) => {
            if (engineRef.current) {
                engineRef.current.triggerBigWinRain(durationMs);
                triggerScreenShake(600);
            }
        },
        shake: (duration) => {
            triggerScreenShake(duration);
        },
        clear: () => {
            if (engineRef.current) {
                engineRef.current.clear();
            }
        }
    }));

    return (
        <div className={`absolute inset-0 pointer-events-none z-30 overflow-hidden ${shakeClass}`}>
            <canvas
                ref={canvasRef}
                className="w-full h-full pointer-events-none block"
            />
        </div>
    );
});

export default FoodFruitVFXOverlay;
