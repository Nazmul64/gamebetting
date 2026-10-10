import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const JOKER_SYMBOLS = {
    joker_lady: { icon: '🃏', name: 'Lucky Lady Joker WILD' },
    red_seven: { icon: '7️⃣', name: 'Lucky 7 (x30.0)' },
    horseshoe: { icon: '🧲', name: 'Golden Horseshoe (x20.0)' },
    star_scatter: { icon: '⭐', name: 'Star Scatter (x15.0)' },
    bell: { icon: '🔔', name: 'Bell (x10.0)' },
    grapes: { icon: '🍇', name: 'Grapes (x5.0)' },
    watermelon: { icon: '🍉', name: 'Melon (x5.0)' },
    lemon: { icon: '🍋', name: 'Lemon (x2.0)' },
    cherry: { icon: '🍒', name: 'Cherry (x2.0)' }
};

export default function LuckyJoker({ config = {} }) {
    return (
        <SlotEngine
            title="Lucky Joker 100"
            gameKey="lucky-joker-100"
            rows={4}
            cols={5}
            symbols={JOKER_SYMBOLS}
            spinUrl="/games/lucky-joker-100/spin"
            stateUrl="/games/lucky-joker-100/state"
            bgImage={config.bg_image || '/images/joker-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="100 paylines of fast excitement with Expanding Wild Joker Lady covering entire reels!"
        />
    );
}
