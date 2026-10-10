import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const ROMAN_SYMBOLS = {
    gladiator: { icon: '⚔️', name: 'Gladiator (x20.0)' },
    emperor: { icon: '👑', name: 'Caesar Emperor (x15.0)' },
    shield: { icon: '🛡️', name: 'Roman Shield (x8.0)' },
    chariot: { icon: '🐎', name: 'War Chariot (x5.0)' },
    colosseum: { icon: '🏛️', name: 'Colosseum Scatter' },
    eagle: { icon: '🦅', name: 'Imperial Eagle Wild' },
    coin: { icon: '🪙', name: 'Denarius Coin (x2.0)' }
};

export default function RomanSlots({ config = {} }) {
    return (
        <SlotEngine
            title="Roman Gladiator Slots"
            gameKey="roman-slots"
            rows={3}
            cols={5}
            symbols={ROMAN_SYMBOLS}
            spinUrl="/games/roman-slots/spin"
            stateUrl="/games/roman-slots/state"
            bgImage={config.bg_image || '/roman-slot/assets/images/bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Enter the Roman Arena! Line up gladiators, chariots and imperial eagles for glorious victories."
        />
    );
}
