import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const FORTUNE_GEMS_SYMBOLS = {
    garuda: { icon: '🦅', name: 'Garuda Wild (x25.0)' },
    red_gem: { icon: '💎', name: 'Red Ruby (x15.0)' },
    blue_gem: { icon: '🔷', name: 'Blue Gem (x10.0)' },
    green_gem: { icon: '🟢', name: 'Green Gem (x8.0)' },
    ace: { icon: '🅰️', name: 'Ace (x5.0)' },
    king: { icon: '👑', name: 'King (x3.0)' },
    queen: { icon: '👸', name: 'Queen (x2.0)' },
    jack: { icon: '🃏', name: 'Jack (x1.0)' },
    mult_15x: { icon: '15X', name: '15x Multiplier' },
    mult_10x: { icon: '10X', name: '10x Multiplier' },
};

export default function FortuneGems({ config = {} }) {
    return (
        <SlotEngine
            title="Fortune Gems 2"
            gameKey="fortune-gems-2"
            rows={3}
            cols={4}
            symbols={FORTUNE_GEMS_SYMBOLS}
            spinUrl="/games/fortune-gems-2/spin"
            stateUrl="/games/fortune-gems-2/state"
            bgImage={config.bg_image || '/images/gems-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="3x3 grid with special 4th Multiplier Wheel reel that multiplies all wins up to 15X!"
        />
    );
}
