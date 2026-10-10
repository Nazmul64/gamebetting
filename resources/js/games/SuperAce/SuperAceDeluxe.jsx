import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const SUPER_ACE_SYMBOLS = {
    golden_ace: { icon: '🂡', name: 'Golden Ace (x50.0)' },
    king: { icon: '🂮', name: 'King (x25.0)' },
    queen: { icon: '🂭', name: 'Queen (x15.0)' },
    jack: { icon: '🂫', name: 'Jack (x10.0)' },
    spade: { icon: '♠️', name: 'Spade (x5.0)' },
    heart: { icon: '♥️', name: 'Heart (x5.0)' },
    diamond: { icon: '♦️', name: 'Diamond (x3.0)' },
    club: { icon: '♣️', name: 'Club (x3.0)' },
    joker_wild: { icon: '🃏', name: 'Joker WILD' }
};

export default function SuperAceDeluxe({ config = {} }) {
    return (
        <SlotEngine
            title="Super Ace Deluxe"
            gameKey="super-ace-deluxe"
            rows={4}
            cols={5}
            symbols={SUPER_ACE_SYMBOLS}
            spinUrl="/games/super-ace-deluxe/spin"
            stateUrl="/games/super-ace-deluxe/state"
            bgImage={config.bg_image || '/images/superace-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Super Ace features Golden Playing Cards that transform into Wilds with progressive multipliers up to 1500X!"
        />
    );
}
