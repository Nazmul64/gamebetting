// Crystal Rules Modal & Jackpot Counter Manager

class RulesModalManager {
  constructor() {
    this.modalEl = document.getElementById('rules-modal') || document.getElementById('info-modal');
  }

  open() {
    const el = document.getElementById('rules-modal') || document.getElementById('info-modal');
    if (el) el.style.display = 'flex';
  }

  close() {
    const el = document.getElementById('rules-modal') || document.getElementById('info-modal');
    if (el) el.style.display = 'none';
  }
}

window.rulesModal = new RulesModalManager();

function openModal() {
  window.rulesModal.open();
}
window.openModal = openModal;

function closeModal() {
  window.rulesModal.close();
}
window.closeModal = closeModal;

function toggleJackpotDropdown() {
  const dd = document.getElementById('jackpot-dropdown');
  if (dd) {
    dd.classList.toggle('active');
  }
}

function openDemoDrawer() {
  const drawer = document.getElementById('demo-drawer');
  const pill = document.getElementById('demo-pill');
  if (drawer) drawer.classList.add('open');
  if (pill) pill.style.display = 'none';
}

function closeDemoDrawer() {
  const drawer = document.getElementById('demo-drawer');
  const pill = document.getElementById('demo-pill');
  if (drawer) drawer.classList.remove('open');
  if (pill) pill.style.display = 'flex';
}

function selectBalanceOption(val) {
  if (window.setGameBalance) {
    window.setGameBalance(val);
  }
  closeDemoDrawer();
}

// Live incremental jackpot ticker
setInterval(() => {
  const dHourly = document.getElementById('digits-hourly');
  if (dHourly) {
    let current = parseInt(dHourly.innerText.replace(/\s+/g, '')) || 707;
    current += Math.floor(Math.random() * 3) + 1;
    const str = current.toString().padStart(3, '0');
    dHourly.innerHTML = str.split('').map(c => `<span class="jackpot-digit">${c}</span>`).join('');
  }
}, 4000);
