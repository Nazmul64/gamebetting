import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const EASTER_SYMBOLS = {
    golden_egg: { icon: '🥚', name: 'Golden Egg (x15.0)' },
    bunny: { icon: '🐰', name: 'Easter Bunny (x8.0)' },
    chick: { icon: '🐥', name: 'Chirping Chick (x5.0)' },
    flower: { icon: '🌸', name: 'Spring Flower (x3.0)' },
    basket: { icon: '🧺', name: 'Egg Basket (x2.0)' },
    candy: { icon: '🍬', name: 'Easter Candy (x1.0)' },
    wild: { icon: '🌟', name: 'Wild' }
};

export default function EasterSlots({ config = {} }) {
    return (
        <SlotEngine
            title="Easter Spring Slots"
            gameKey="easter-slots"
            rows={3}
            cols={5}
            symbols={EASTER_SYMBOLS}
            spinUrl="/games/easter-slots/spin"
            stateUrl="/games/easter-slots/state"
            bgImage={config.bg_image || '/easter-slots/assets/images/bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Find the Golden Easter Eggs across 5 reels to win surprise multipliers and free spring spins!"
        />
    );
}
