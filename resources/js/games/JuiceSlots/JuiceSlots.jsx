import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const JUICE_SYMBOLS = {
    watermelon: { icon: '🍉', name: 'Watermelon (x5.0)' },
    grapes: { icon: '🍇', name: 'Grapes (x3.0)' },
    orange: { icon: '🍊', name: 'Orange (x2.0)' },
    lemon: { icon: '🍋', name: 'Lemon (x1.5)' },
    cherry: { icon: '🍒', name: 'Cherry (x1.0)' },
    seven: { icon: '7️⃣', name: 'Lucky 7 (x10.0)' },
    scatter: { icon: '🍹', name: 'Cocktail Scatter' },
    wild: { icon: '⭐', name: 'Wild' },
};

export default function JuiceSlots({ config = {} }) {
    return (
        <SlotEngine
            title="Juice Fresh Slots"
            gameKey="juice-slots"
            rows={3}
            cols={5}
            symbols={JUICE_SYMBOLS}
            spinUrl="/games/juice-slots/spin"
            stateUrl="/games/juice-slots/state"
            bgImage={config.bg_image || '/juice-slots/assets/images/bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Spin 5 fruity reels across 10 paylines. Match 3 or more sweet fruits to squeeze out big juice prizes!"
        />
    );
}
