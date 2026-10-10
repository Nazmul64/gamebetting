import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const OLYMPUS_SYMBOLS = {
    crown: { icon: '👑', name: 'Zeus Crown (x50.0)' },
    hourglass: { icon: '⏳', name: 'Hourglass (x25.0)' },
    ring: { icon: '💍', name: 'Ruby Ring (x15.0)' },
    chalice: { icon: '🏆', name: 'Golden Chalice (x12.0)' },
    red_gem: { icon: '🔴', name: 'Red Gem (x10.0)' },
    purple_gem: { icon: '🟣', name: 'Purple Gem (x8.0)' },
    yellow_gem: { icon: '🟡', name: 'Yellow Gem (x5.0)' },
    green_gem: { icon: '🟢', name: 'Green Gem (x4.0)' },
    blue_gem: { icon: '🔵', name: 'Blue Gem (x2.0)' },
    zeus_scatter: { icon: '⚡', name: 'Zeus Scatter (x100.0)' }
};

export default function GatesOfOlympus({ config = {} }) {
    return (
        <SlotEngine
            title="Gates of Olympus 1000"
            gameKey="olympus"
            rows={5}
            cols={6}
            symbols={OLYMPUS_SYMBOLS}
            spinUrl="/api/olympus/spin"
            stateUrl="/api/olympus/config"
            bgImage={config.bg_image || '/olympus/assets/bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="The Gates of Olympus open with 6x5 tumble grid where symbols pay anywhere on the screen! Look out for Zeus lightning multipliers up to 500X!"
        />
    );
}
