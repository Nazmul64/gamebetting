const fs = require('fs');

const suits = {
  'S': { sym: '♠', color: '#111827', name: 'spade' },
  'H': { sym: '♥', color: '#dc2626', name: 'heart' },
  'D': { sym: '♦', color: '#dc2626', name: 'diamond' },
  'C': { sym: '♣', color: '#111827', name: 'club' }
};

const ranks = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

if (!fs.existsSync('assets/images/cards')) {
  fs.mkdirSync('assets/images/cards', { recursive: true });
}

// Generate Card Back
const backSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 150">
  <defs>
    <radialGradient id="cardbg" cx="50%" cy="50%" r="70%">
      <stop offset="0%" stop-color="#1e4d8c"/>
      <stop offset="100%" stop-color="#081830"/>
    </radialGradient>
    <pattern id="cardpat" width="10" height="10" patternUnits="userSpaceOnUse">
      <path d="M5 0L10 5L5 10L0 5Z" fill="none" stroke="#d4af37" stroke-width="0.8" opacity="0.6"/>
      <circle cx="5" cy="5" r="1.2" fill="#d4af37" opacity="0.8"/>
    </pattern>
  </defs>
  <rect x="2" y="2" width="96" height="146" rx="6" fill="#ffffff" stroke="#cfd4dc" stroke-width="1.5"/>
  <rect x="5" y="5" width="90" height="140" rx="4" fill="url(#cardbg)"/>
  <rect x="5" y="5" width="90" height="140" rx="4" fill="url(#cardpat)"/>
  <rect x="8" y="8" width="84" height="134" rx="3" fill="none" stroke="#e5c158" stroke-width="1.5"/>
  <circle cx="50" cy="75" r="22" fill="#081830" stroke="#e5c158" stroke-width="2"/>
  <polygon points="50,58 54,71 67,75 54,79 50,92 46,79 33,75 46,71" fill="#e5c158"/>
</svg>`;
fs.writeFileSync('assets/images/cards/back.svg', backSvg);

function getPips(rank, sym) {
  let pips = '';
  const pos = {
    'A': [[50, 75, 42]],
    '2': [[50, 42, 22], [50, 108, 22, 180]],
    '3': [[50, 38, 20], [50, 75, 20], [50, 112, 20, 180]],
    '4': [[32, 40, 20], [68, 40, 20], [32, 110, 20, 180], [68, 110, 20, 180]],
    '5': [[32, 38, 19], [68, 38, 19], [50, 75, 19], [32, 112, 19, 180], [68, 112, 19, 180]],
    '6': [[32, 38, 19], [68, 38, 19], [32, 75, 19], [68, 75, 19], [32, 112, 19, 180], [68, 112, 19, 180]],
    '7': [[32, 38, 18], [68, 38, 18], [50, 56, 18], [32, 75, 18], [68, 75, 18], [32, 112, 18, 180], [68, 112, 18, 180]],
    '8': [[32, 36, 18], [68, 36, 18], [50, 54, 18], [32, 74, 18], [68, 74, 18], [50, 94, 18, 180], [32, 114, 18, 180], [68, 114, 18, 180]],
    '9': [[32, 35, 17], [68, 35, 17], [32, 60, 17], [68, 60, 17], [50, 75, 17], [32, 90, 17, 180], [68, 90, 17, 180], [32, 115, 17, 180], [68, 115, 17, 180]],
    '10': [[32, 34, 16], [68, 34, 16], [50, 48, 16], [32, 64, 16], [68, 64, 16], [32, 86, 16, 180], [68, 86, 16, 180], [50, 102, 16, 180], [32, 116, 16, 180], [68, 116, 16, 180]]
  };

  if (pos[rank]) {
    pos[rank].forEach(p => {
      const [x, y, s, r] = p;
      if (r) {
        pips += `<text x="${x}" y="${y}" font-size="${s}" text-anchor="middle" dominant-baseline="central" transform="rotate(${r} ${x} ${y})">${sym}</text>`;
      } else {
        pips += `<text x="${x}" y="${y}" font-size="${s}" text-anchor="middle" dominant-baseline="central">${sym}</text>`;
      }
    });
  } else if (rank === 'J' || rank === 'Q' || rank === 'K') {
    const label = rank === 'J' ? 'JACK' : rank === 'Q' ? 'QUEEN' : 'KING';
    pips += `
      <rect x="22" y="28" width="56" height="94" rx="4" fill="#faf5eb" stroke="#d4af37" stroke-width="1.5"/>
      <circle cx="50" cy="62" r="18" fill="#f5e6ba" stroke="#8a1a36" stroke-width="1.5"/>
      <text x="50" y="68" font-size="22" text-anchor="middle" font-family="'Trebuchet MS', Arial, sans-serif" font-weight="bold">${rank}</text>
      <text x="50" y="98" font-size="22" text-anchor="middle">${sym}</text>
      <text x="50" y="116" font-size="9" font-family="sans-serif" font-weight="bold" letter-spacing="1" fill="#78350f" text-anchor="middle">${label}</text>
    `;
  }
  return pips;
}

for (let sKey in suits) {
  const suit = suits[sKey];
  ranks.forEach(rank => {
    const cardSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 150">
  <rect x="2" y="2" width="96" height="146" rx="6" fill="#ffffff" stroke="#cfd3dc" stroke-width="1.5"/>
  <g fill="${suit.color}" font-family="'Trebuchet MS', Arial, sans-serif">
    <!-- Top Left -->
    <text x="11" y="19" font-size="15" font-weight="bold" text-anchor="middle">${rank}</text>
    <text x="11" y="32" font-size="14" text-anchor="middle">${suit.sym}</text>
    
    <!-- Bottom Right (Rotated) -->
    <g transform="rotate(180 50 75)">
      <text x="11" y="19" font-size="15" font-weight="bold" text-anchor="middle">${rank}</text>
      <text x="11" y="32" font-size="14" text-anchor="middle">${suit.sym}</text>
    </g>

    <!-- Center Pips -->
    <g font-family="'Segoe UI Emoji', 'Apple Color Emoji', 'Segoe UI Symbol', sans-serif">
      ${getPips(rank, suit.sym)}
    </g>
  </g>
</svg>`;
    fs.writeFileSync(`assets/images/cards/${rank}${sKey}.svg`, cardSvg);
  });
}
console.log('Cards generated successfully!');
