import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const TEMPLE_SYMBOLS = {
    golden_mask: { icon: '👺', name: 'Mayan Mask (x50.0)' },
    pyramid: { icon: '🏛️', name: 'Pyramid Scatter' },
    jaguar: { icon: '🐆', name: 'Sacred Jaguar (x25.0)' },
    sun_god: { icon: '☀️', name: 'Sun God WILD' },
    emerald_idol: { icon: '🗿', name: 'Emerald Idol (x15.0)' },
    ruby_skull: { icon: '💀', name: 'Crystal Skull (x10.0)' },
    feather_snake: { icon: '🐍', name: 'Quetzalcoatl (x5.0)' }
};

export default function TempleOfFortune({ config = {} }) {
    return (
        <SlotEngine
            title="Temple of Fortune (Abyss)"
            gameKey="temple-of-fortune"
            rows={3}
            cols={5}
            symbols={TEMPLE_SYMBOLS}
            spinUrl="/games/temple-of-fortune/bet"
            stateUrl="/games/temple-of-fortune/state"
            bgImage={config.bg_image || '/images/temple-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Venture deep into the ancient Mayan Temple to uncover hidden golden masks and lost crystal treasures!"
        />
    );
}
