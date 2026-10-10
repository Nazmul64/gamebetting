import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const ROYAL_EMIRATES_SYMBOLS = {
    golden_lamp: { icon: '🪔', name: 'Magic Lamp (x50.0)' },
    gold_coin: { icon: '🪙', name: 'Bonus Coin (Hold & Spin)' },
    crown: { icon: '👑', name: 'Emirate Crown (x25.0)' },
    car: { icon: '🏎️', name: 'Supercar (x15.0)' },
    yacht: { icon: '🛥️', name: 'Luxury Yacht (x10.0)' },
    palace: { icon: '🏰', name: 'Palace Scatter' },
    ace: { icon: '🅰️', name: 'Ace' }
};

export default function RoyalEmirates({ config = {} }) {
    return (
        <SlotEngine
            title="Royal Emirates Hold & Spin"
            gameKey="royal-emirates"
            rows={3}
            cols={5}
            symbols={ROYAL_EMIRATES_SYMBOLS}
            spinUrl="/games/royal-emirates/spin"
            stateUrl="/games/royal-emirates/state"
            bgImage={config.bg_image || '/images/royal-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="6+ Gold Coins trigger the Hold and Spin Jackpot Respin bonus feature for Grand, Major, and Minor prizes!"
        />
    );
}
