import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const EMIRATE_SYMBOLS = {
    sheikh: { icon: '👳', name: 'Arabian Sheikh (x50.0)' },
    princess: { icon: '🧕', name: 'Desert Princess (x30.0)' },
    falcon: { icon: '🦅', name: 'Royal Falcon (x20.0)' },
    dagger: { icon: '🗡️', name: 'Golden Dagger (x15.0)' },
    teapot: { icon: '🫖', name: 'Golden Teapot (x10.0)' },
    palm_tree: { icon: '🌴', name: 'Palm Tree Scatter' },
    camel: { icon: '🐫', name: 'Desert Camel (x5.0)' }
};

export default function TheEmirate({ config = {} }) {
    return (
        <SlotEngine
            title="The Emirate Dubai Slots"
            gameKey="the-emirate"
            rows={3}
            cols={5}
            symbols={EMIRATE_SYMBOLS}
            spinUrl="/games/the-emirate/spin"
            stateUrl="/games/the-emirate/state"
            bgImage={config.bg_image || '/images/dubai-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Experience the wealth of the Emirates across 5 luxurious reels with Arab sheikhs and royal falcons."
        />
    );
}
