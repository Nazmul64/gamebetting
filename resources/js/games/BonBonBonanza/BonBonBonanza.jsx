import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const BONBON_SYMBOLS = {
    heart_candy: { icon: '💖', name: 'Heart Candy (x50.0)' },
    square_candy: { icon: '🟪', name: 'Purple Candy (x25.0)' },
    green_candy: { icon: '🟩', name: 'Green Candy (x15.0)' },
    blue_candy: { icon: '🟦', name: 'Blue Candy (x12.0)' },
    apple: { icon: '🍎', name: 'Red Apple (x10.0)' },
    plum: { icon: '🫐', name: 'Sweet Plum (x8.0)' },
    watermelon: { icon: '🍉', name: 'Watermelon (x5.0)' },
    banana: { icon: '🍌', name: 'Banana (x2.0)' },
    lollipop_scatter: { icon: '🍭', name: 'Lollipop Scatter (x100.0)' },
    bomb_mult: { icon: '💣', name: 'Sugar Bomb 100X' }
};

export default function BonBonBonanza({ config = {} }) {
    return (
        <SlotEngine
            title="BonBon Bonanza Sweet"
            gameKey="bonbon-bonanza"
            rows={5}
            cols={6}
            symbols={BONBON_SYMBOLS}
            spinUrl="/games/bonbon-bonanza/spin"
            stateUrl="/games/bonbon-bonanza/state"
            bgImage={config.bg_image || '/images/sweet-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Tumble all candy symbols anywhere on 6x5 grid! 4+ Lollipops award 10 Free Spins with explosive Multiplier Sugar Bombs!"
        />
    );
}
