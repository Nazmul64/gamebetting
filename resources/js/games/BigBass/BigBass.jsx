import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const BIG_BASS_SYMBOLS = {
    truck: { icon: '🛻', name: 'Monster Truck (x50.0)' },
    rod: { icon: '🎣', name: 'Fishing Rod (x30.0)' },
    dragonfly: { icon: '🪰', name: 'Dragonfly (x20.0)' },
    tackle: { icon: '🧰', name: 'Tackle Box (x15.0)' },
    fish_money: { icon: '🐟', name: 'Fish Money (x10.0)' },
    scatter_bass: { icon: '🐠', name: 'Bass Scatter' },
    wild_fisherman: { icon: '🧔', name: 'Fisherman Wild' },
    ace: { icon: '🅰️', name: 'Ace' },
    king: { icon: '👑', name: 'King' },
};

export default function BigBass({ config = {} }) {
    return (
        <SlotEngine
            title="Big Bass Splash"
            gameKey="big-bass-splash"
            rows={3}
            cols={5}
            symbols={BIG_BASS_SYMBOLS}
            spinUrl="/games/big-bass-splash/spin"
            stateUrl="/games/big-bass-splash/state"
            bgImage={config.bg_image || '/images/underwater-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Cast your fishing rod into deep waters! Catch Scatters to unlock Free Spins where Fisherman collects all fish cash prizes!"
        />
    );
}
