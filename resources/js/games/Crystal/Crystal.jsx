import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const CRYSTAL_SYMBOLS = {
    red: { icon: '💎', name: 'Ruby (x2.0)' },
    violet: { icon: '🔮', name: 'Amethyst (x1.9)' },
    blue: { icon: '🔷', name: 'Sapphire (x1.5)' },
    yellow: { icon: '⭐', name: 'Topaz (x0.9)' },
    azure: { icon: '💧', name: 'Aquamarine (x0.8)' },
    green: { icon: '🍀', name: 'Emerald (x0.5)' },
    wild: { icon: '👑', name: 'WILD' },
};

export default function Crystal({ config = {} }) {
    return (
        <SlotEngine
            title="Crystal Slot (Gems)"
            gameKey="crystal"
            rows={5}
            cols={5}
            symbols={CRYSTAL_SYMBOLS}
            spinUrl="/games/crystal/spin"
            stateUrl="/games/crystal/state"
            bgImage={config.bg_image || '/crystal/assets/images/bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Match 3 or more shiny crystals horizontally or vertically to trigger explosions, cascades and high payouts!"
        />
    );
}
