import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const ELVES_SYMBOLS = {
    elf_queen: { icon: '🧝‍♀️', name: 'Elf Queen (x50.0)' },
    elf_king: { icon: '🧝‍♂️', name: 'Elf King (x30.0)' },
    unicorn: { icon: '🦄', name: 'Unicorn (x20.0)' },
    magic_bow: { icon: '🏹', name: 'Magic Bow (x15.0)' },
    tree_of_life: { icon: '🌳', name: 'Tree Scatter' },
    crystal_orb: { icon: '🔮', name: 'Crystal Orb WILD' },
    leaf_pouch: { icon: '🌿', name: 'Leaf Pouch (x5.0)' }
};

export default function ElvesKingdom({ config = {} }) {
    return (
        <SlotEngine
            title="Elves Kingdom Slot"
            gameKey="elves-kingdom"
            rows={3}
            cols={5}
            symbols={ELVES_SYMBOLS}
            spinUrl="/games/elves-kingdom/spin"
            stateUrl="/games/elves-kingdom/state"
            bgImage={config.bg_image || '/images/elves-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Enter the mystical forest of the Elves Kingdom with magic bows, unicorns, and enchanted tree multipliers!"
        />
    );
}
