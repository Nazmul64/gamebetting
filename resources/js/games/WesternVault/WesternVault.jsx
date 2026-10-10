import React from 'react';
import SlotEngine from '../../components/SlotEngine';

const WESTERN_SYMBOLS = {
    safe_vault: { icon: '🗄️', name: 'Gold Vault (x50.0)' },
    sheriff_star: { icon: '⭐', name: 'Sheriff Badge WILD' },
    revolver: { icon: '🔫', name: 'Revolver Gun (x25.0)' },
    gold_bars: { icon: '🧈', name: 'Gold Bullion (x15.0)' },
    cowboy_hat: { icon: '🤠', name: 'Cowboy Hat (x10.0)' },
    dynamite: { icon: '🧨', name: 'Dynamite Scatter' },
    horseshoe: { icon: '🧲', name: 'Horseshoe (x5.0)' }
};

export default function WesternVault({ config = {} }) {
    return (
        <SlotEngine
            title="Western Vault Slot"
            gameKey="western-vault"
            rows={3}
            cols={5}
            symbols={WESTERN_SYMBOLS}
            spinUrl="/games/western-vault/bet"
            stateUrl="/games/western-vault/state"
            bgImage={config.bg_image || '/images/western-bg.jpg'}
            bgMusicUrl={config.bg_audio || null}
            rules="Blast open the Western Vault with dynamites and sheriff wild badges for big frontier bounties!"
        />
    );
}
