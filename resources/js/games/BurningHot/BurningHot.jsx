import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const BURNING_SYMBOLS = {
    seven: { icon: '🔥7️⃣', name: 'Blazing 7 (x25.0)' },
    clover: { icon: '🍀', name: 'Expanding Clover WILD' },
    dollar: { icon: '💵', name: 'Dollar Scatter (x10.0)' },
    star: { icon: '⭐', name: 'Star Scatter (x5.0)' },
    grapes: { icon: '🍇', name: 'Grapes (x4.0)' },
    watermelon: { icon: '🍉', name: 'Melon (x4.0)' },
    bell: { icon: '🔔', name: 'Golden Bell (x2.0)' },
    cherry: { icon: '🍒', name: 'Cherry (x1.0)' },
    lemon: { icon: '🍋', name: 'Lemon (x1.0)' },
    orange: { icon: '🍊', name: 'Orange (x1.0)' },
    plum: { icon: '🫐', name: 'Plum (x1.0)' }
};

export default function BurningHot({ config = {} }) {
    return (
        <SlotEngine
            title="40 Burning Hot Vegas"
            gameKey="burning-hot"
            rows={4}
            cols={5}
            symbols={BURNING_SYMBOLS}
            spinUrl="/games/burning-hot/spin"
            stateUrl="/games/burning-hot/state"
            bgImage={config.bg_image || '/burning-hot/assets/images/bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Classic 40 lines Vegas fiery slot with expanding four-leaf clover wilds and dollar scatters."
        />
    );
}
