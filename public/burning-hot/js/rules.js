// Rules, Jackpot & Demo Mode Widgets Handlers

function openModal() {
  if (window.audio) {
    window.audio.init();
    window.audio.playClick();
  }
  const modal = document.getElementById('info-modal');
  if (modal) modal.style.display = 'flex';
}

function closeModal() {
  if (window.audio) {
    window.audio.init();
    window.audio.playClick();
  }
  const modal = document.getElementById('info-modal');
  if (modal) modal.style.display = 'none';
}

// Jackpot Dropdown Toggle
function toggleJackpotDropdown() {
  if (window.audio) {
    window.audio.init();
    window.audio.playClick();
  }
  const dropdown = document.getElementById('jackpot-dropdown');
  if (dropdown) {
    const isVisible = dropdown.style.display === 'block';
    dropdown.style.display = isVisible ? 'none' : 'block';
  }
}

// Demo Mode Drawer Handlers
function openDemoDrawer() {
  if (window.audio) {
    window.audio.init();
    window.audio.playClick();
  }
  const pill = document.getElementById('demo-pill');
  const drawer = document.getElementById('demo-drawer');
  if (pill) pill.style.display = 'none';
  if (drawer) drawer.style.display = 'block';
}

function closeDemoDrawer() {
  if (window.audio) {
    window.audio.init();
    window.audio.playClick();
  }
  const pill = document.getElementById('demo-pill');
  const drawer = document.getElementById('demo-drawer');
  if (drawer) drawer.style.display = 'none';
  if (pill) pill.style.display = 'flex';
}

function resetDemoBalance() {
  if (window.audio) {
    window.audio.init();
    window.audio.playClick();
  }
  if (window.setGameBalance) {
    window.setGameBalance(10000);
  }
  const balEl = document.getElementById('demo-card-balance');
  if (balEl) balEl.innerText = '10,000.00 BDT';
  const winEl = document.getElementById('demo-card-winnings');
  if (winEl) winEl.innerText = '0.00 BDT';
}

// Live ticking jackpot simulation
let hourlyJP = 707;
let dailyJP = 1655442;
let weeklyJP = 19980731;
let monthlyJP = 59694643;

function renderDigits(containerId, num) {
  const el = document.getElementById(containerId);
  if (!el) return;
  const str = num.toString();
  el.innerHTML = str.split('').map(d => `<span class="jackpot-digit">${d}</span>`).join('');
}

setInterval(() => {
  hourlyJP += Math.floor(Math.random() * 2) + 1;
  dailyJP += Math.floor(Math.random() * 5) + 2;
  weeklyJP += Math.floor(Math.random() * 15) + 5;
  monthlyJP += Math.floor(Math.random() * 50) + 10;

  renderDigits('digits-hourly', hourlyJP);
  renderDigits('digits-daily', dailyJP);
  renderDigits('digits-weekly', weeklyJP);
  renderDigits('digits-monthly', monthlyJP);
}, 2500);

window.openModal = openModal;
window.closeModal = closeModal;
window.toggleJackpotDropdown = toggleJackpotDropdown;
window.openDemoDrawer = openDemoDrawer;
window.closeDemoDrawer = closeDemoDrawer;
window.resetDemoBalance = resetDemoBalance;
