import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';

// Game Components Imports
import IndianPoker from './games/IndianPoker/IndianPoker';
import CardGames21 from './games/CardGames21/CardGames21';
import UnderAndOver7 from './games/UnderAndOver7/UnderAndOver7';
import HeadsOrTails from './games/HeadsOrTails/HeadsOrTails';
import Crystal from './games/Crystal/Crystal';
import JuiceSlots from './games/JuiceSlots/JuiceSlots';
import EasterSlots from './games/EasterSlots/EasterSlots';
import BurningHot from './games/BurningHot/BurningHot';
import RomanSlots from './games/RomanSlots/RomanSlots';
import GatesOfOlympus from './games/GatesOfOlympus/GatesOfOlympus';
import FortuneGems from './games/FortuneGems/FortuneGems';
import BigBass from './games/BigBass/BigBass';
import BoxingKing from './games/BoxingKing/BoxingKing';
import BonBonBonanza from './games/BonBonBonanza/BonBonBonanza';
import LuckyJoker from './games/LuckyJoker/LuckyJoker';
import TheEmirate from './games/TheEmirate/TheEmirate';
import RoyalEmirates from './games/RoyalEmirates/RoyalEmirates';
import WesternVault from './games/WesternVault/WesternVault';
import TempleOfFortune from './games/TempleOfFortune/TempleOfFortune';
import SuperAceDeluxe from './games/SuperAce/SuperAceDeluxe';
import ElvesKingdom from './games/ElvesKingdom/ElvesKingdom';
import TreasureClimb from './games/TreasureClimb/TreasureClimb';
import CrashGame from './games/CrashGame/CrashGame';
import WinGo from './games/WinGo/WinGo';
import K3 from './games/K3/K3';
import TrxWinGo from './games/TrxWinGo/TrxWinGo';
import GemsMines from './games/GemsMines/GemsMines';

const GAME_MAP = {
    'indian-poker': IndianPoker,
    'card-games-21': CardGames21,
    'under-and-over-7': UnderAndOver7,
    'heads-or-tails': HeadsOrTails,
    'heads-or-tails-doubling': HeadsOrTails,
    'heads-or-tails-game': HeadsOrTails,
    'crystal': Crystal,
    'juice-slots': JuiceSlots,
    'easter-slots': EasterSlots,
    'burning-hot': BurningHot,
    'roman-slots': RomanSlots,
    'gates-of-olympus': GatesOfOlympus,
    'fortune-gems-2': FortuneGems,
    'big-bass-splash': BigBass,
    'boxing-king': BoxingKing,
    'bonbon-bonanza': BonBonBonanza,
    'lucky-joker-100': LuckyJoker,
    'the-emirate': TheEmirate,
    'royal-emirates': RoyalEmirates,
    'western-vault': WesternVault,
    'western-slot': WesternVault,
    'western': WesternVault,
    'temple-of-fortune': TempleOfFortune,
    'abyss-of-glory': TempleOfFortune,
    'super-ace-deluxe': SuperAceDeluxe,
    'elves-kingdom': ElvesKingdom,
    'treasure-climb': TreasureClimb,
    'helicopterx': CrashGame,
    '1xaero': CrashGame,
    'aero': CrashGame,
    'crashx': CrashGame,
    'crash': CrashGame,
    'wingo': WinGo,
    'k3': K3,
    'trx-wingo': TrxWinGo,
    'gems-mines': GemsMines,
};

document.addEventListener('DOMContentLoaded', () => {
    const rootEl = document.getElementById('react-game-root');
    if (rootEl) {
        const gameKey = rootEl.getAttribute('data-game');
        const configAttr = rootEl.getAttribute('data-config');
        let config = {};
        try {
            if (configAttr) config = JSON.parse(configAttr);
        } catch (e) {
            console.warn('Invalid data-config JSON', e);
        }

        const GameComponent = GAME_MAP[gameKey];
        if (GameComponent) {
            const root = createRoot(rootEl);
            root.render(<GameComponent config={config} />);
        } else {
            console.warn(`No React Game component found for key: "${gameKey}"`);
        }
    }
});
