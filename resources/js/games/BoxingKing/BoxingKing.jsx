import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const BOXING_SYMBOLS = {
    belt: { icon: '🥊', name: 'Golden Belt (x50.0)' },
    red_glove: { icon: '🧤', name: 'Red Gloves (x25.0)' },
    blue_glove: { icon: '🥊', name: 'Blue Gloves (x15.0)' },
    bell: { icon: '🔔', name: 'Round Bell (x10.0)' },
    wild_king: { icon: '👑', name: 'Boxing King WILD' },
    scatter_free: { icon: '⭐', name: 'Free Spin Scatter' },
    ace: { icon: '🅰️', name: 'Ace' },
    king: { icon: '👑', name: 'King' }
};

export default function BoxingKing({ config = {} }) {
    return (
        <SlotEngine
            title="Boxing King Slot"
            gameKey="boxing-king"
            rows={4}
            cols={5}
            symbols={BOXING_SYMBOLS}
            spinUrl="/games/boxing-king/spin"
            stateUrl="/games/boxing-king/state"
            bgImage={config.bg_image || '/images/boxing-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Step into the Boxing ring! Combo clears increase win multipliers with KO free games!"
        />
    );
}
