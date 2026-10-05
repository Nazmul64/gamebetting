/* Symbol images live in images/<name>.svg - replace the files (or PNGs: change the extension below) */
const IMG_EXT='svg';
const SVG=new Proxy({},{get:(_,k)=>`<img src="images/${k}.${IMG_EXT}" alt="${k}" draggable="false">`});
const KEYS=['straw','ban','grape','juice','cup','egg','org'];
const PAY={cup:[20,100,500],juice:[15,75,300],grape:[8,30,120],straw:[6,20,80],org:[5,15,60],ban:[4,12,40],egg:[3,10,30]};
const WILD='juice';
const NAMES={cup:'Trophy',juice:'Juice (wild)',grape:'Grapes',straw:'Strawberry',org:'Orange',ban:'Banana',egg:'Eggplant'};
const LINES=[[1,1,1,1,1],[0,0,0,0,0],[2,2,2,2,2],[0,1,2,1,0],[2,1,0,1,2],[0,0,1,2,2],[2,2,1,0,0],[1,0,0,0,1],[1,2,2,2,1]];
const LCOL=['#ffe600','#00e5ff','#7cff3a','#ff4da6','#fff','#b388ff','#ff9100','#00ff9d','#3d5afe'];
const BETS=[0.01,0.05,0.10,0.25,0.50,1.00];
const $=id=>document.getElementById(id);
const st={credit:30,bet:0.05,lines:9,max:9,spinning:false,mute:false,win:35,big:10};
let grid=[];

/* layout scale */
function fit(){const s=Math.min(innerWidth/1000,innerHeight/520);$('stage').style.transform=`scale(${s})`}
addEventListener('resize',fit);fit();

/* build reels */
const reelsEl=$('reels');
for(let c=0;c<5;c++){const r=document.createElement('div');r.className='reel';for(let i=0;i<3;i++){r.appendChild(Object.assign(document.createElement('div'),{className:'cell'}))}reelsEl.appendChild(r)}
reelsEl.insertAdjacentHTML('beforeend','<svg id="lines" viewBox="0 0 564 312" preserveAspectRatio="none"></svg>');
const cellEl=(c,r)=>reelsEl.children[c].children[r];
const rnd=n=>Math.floor(Math.random()*n);
const rsym=()=>KEYS[rnd(KEYS.length)];
function setCell(c,r,k){const e=cellEl(c,r);e.innerHTML=SVG[k];e.dataset.k=k}
grid=[...Array(5)].map(()=>[rsym(),rsym(),rsym()]);
grid.forEach((col,c)=>col.forEach((k,r)=>setCell(c,r,k)));

/* side line numbers */
const NL=[4,2,8,6,1,7,9,3,5],NR=[4,2,9,6,1,7,8,3,5];
function drawNums(){[['lnL',NL],['lnR',NR]].forEach(([id,a])=>{$(id).innerHTML=a.map(n=>`<span class="${n>st.lines?'off':''}">${n}</span>`).join('')})}

function ui(){
 const total=st.bet*st.lines;
 $('cr').textContent=st.credit.toFixed(2);
 $('bxL').textContent=st.lines;$('bxB').textContent=st.bet.toFixed(2);$('bxT').textContent='BET: '+total.toFixed(2);
 drawNums();
}
function msg(t){$('msg').textContent=t}

/* sound */
let ac;function beep(f,d,t='square',v=.05){if(st.mute)return;try{ac=ac||new (window.AudioContext||window.webkitAudioContext)();const o=ac.createOscillator(),g=ac.createGain();o.type=t;o.frequency.value=f;g.gain.value=v;o.connect(g);g.connect(ac.destination);o.start();g.gain.exponentialRampToValueAtTime(.0001,ac.currentTime+d);o.stop(ac.currentTime+d)}catch(e){}}

/* evaluation */
function evalLine(cells){
 let base=cells.find(k=>k!==WILD)||WILD,n=0;
 for(const k of cells){if(k===base||k===WILD)n++;else break}
 return n>=3?{sym:base,n}:null;
}
function evaluate(g){
 const res=[];
 for(let i=0;i<st.lines;i++){
  const p=st.max===3?[[1,1,1,1,1],[0,0,0,0,0],[2,2,2,2,2]][i]:LINES[i];
  const w=evalLine(p.map((r,c)=>g[c][r]));
  if(w)res.push({line:i,path:p,n:w.n,sym:w.sym,mult:PAY[w.sym][w.n-3]});
 }
 return res;
}

/* result control */
function makeGrid(kind){
 const mk=()=>[...Array(5)].map(()=>[rsym(),rsym(),rsym()]);
 let g=mk();
 if(kind==='lose'){for(let t=0;t<300&&evaluate(g).length;t++)g=mk();return g}
 const bigSet=['cup','juice','grape'],smallSet=['straw','org','ban','egg'];
 const sym=kind==='big'?'cup':(Math.random()<st.big/100?bigSet[rnd(3)]:smallSet[rnd(4)]);
 const n=kind==='big'?5:3+rnd(3);
 const li=rnd(st.lines),p=st.max===3?[[1,1,1,1,1],[0,0,0,0,0],[2,2,2,2,2]][li]:LINES[li];
 for(let c=0;c<n;c++)g[c][p[c]]=sym;
 return g;
}
function pickKind(){
 const pre=$('sPre').value;
 if(pre!=='random'){$('sPre').value='random';return pre}
 if(Math.random()*100<st.win)return Math.random()*100<st.big?'big':'win';
 return 'lose';
}

/* spin */
function clearWin(){document.querySelectorAll('.cell.win').forEach(e=>e.classList.remove('win'));$('lines').innerHTML=''}
function spin(){
 if(st.spinning)return;
 const total=+(st.bet*st.lines).toFixed(2);
 if(st.credit+1e-9<total){msg('Not enough credit');beep(120,.3,'sawtooth');return}
 st.credit=+(st.credit-total).toFixed(2);ui();clearWin();msg('');
 st.spinning=true;setBtns(true);
 $('lever').classList.remove('pull');void $('lever').offsetWidth;$('lever').classList.add('pull');
 const g=makeGrid(pickKind());
 for(let c=0;c<5;c++){
  const reel=reelsEl.children[c];reel.classList.add('spinning');
  const iv=setInterval(()=>{for(let r=0;r<3;r++)setCell(c,r,rsym())},70);
  setTimeout(()=>{clearInterval(iv);reel.classList.remove('spinning');for(let r=0;r<3;r++)setCell(c,r,g[c][r]);grid[c]=g[c];beep(220+c*40,.12);if(c===4)done(g,total)},700+c*350);
 }
}
function done(g,total){
 const w=evaluate(g);
 let win=0;
 w.forEach(x=>{win+=x.mult*st.bet});
 win=+win.toFixed(2);
 if(win>0){
  st.credit=+(st.credit+win).toFixed(2);
  msg('YOU WIN $'+win.toFixed(2)+'!');
  [523,659,784,1047].forEach((f,i)=>setTimeout(()=>beep(f,.18,'triangle',.08),i*110));
  const svg=$('lines');
  w.forEach(x=>{
   x.path.forEach((r,c)=>{if(c<x.n)cellEl(c,r).classList.add('win')});
   const pts=x.path.slice(0,x.n).map((r,c)=>`${c*112.8+56.4},${r*104+52}`).join(' ');
   svg.insertAdjacentHTML('beforeend',`<polyline points="${pts}" fill="none" stroke="${LCOL[x.line]}" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" opacity=".85"/>`);
  });
 }else if(st.credit<st.bet)msg('Game over - reset credit in settings');
 ui();st.spinning=false;setBtns(false);
}
function setBtns(b){['bLines','bBet','bMax','bSpin'].forEach(i=>$(i).disabled=b)}

/* buttons */
$('bSpin').onclick=spin;
$('lever').onclick=spin;
$('bBet').onclick=()=>{const i=BETS.findIndex(b=>Math.abs(b-st.bet)<1e-9);st.bet=BETS[(i+1)%BETS.length];beep(400,.05);ui()};
$('bLines').onclick=()=>{if(st.max===3)return;st.lines=st.lines%st.max+1;beep(500,.05);ui()};
$('bMax').onclick=()=>{st.bet=BETS[BETS.length-1];while(st.bet*st.lines>st.credit&&st.bet>BETS[0])st.bet=BETS[BETS.indexOf(st.bet)-1];st.lines=st.max;ui();spin()};
addEventListener('keydown',e=>{if(e.code==='Space'&&!document.querySelector('.modal.on')){e.preventDefault();spin()}});

/* pay table */
$('pt').innerHTML='<tr><th></th><th>x3</th><th>x4</th><th>x5</th></tr>'+KEYS.slice().sort((a,b)=>PAY[b][2]-PAY[a][2]).map(k=>`<tr><td>${SVG[k]}<br>${NAMES[k]}</td>${PAY[k].map(m=>`<td>${m}x</td>`).join('')}</tr>`).join('');

/* modals */
const open=id=>$(id).classList.add('on');
$('bInfo').onclick=()=>open('mInfo');$('gear').onclick=()=>open('mSet');
document.querySelectorAll('[data-close]').forEach(b=>b.onclick=()=>b.closest('.modal').classList.remove('on'));
$('sMode').onchange=e=>{st.max=+e.target.value;st.lines=st.max;ui()};
$('sMute').onclick=()=>{st.mute=!st.mute;$('sMute').textContent=st.mute?'Off':'On'};
$('sFull').onclick=()=>{if(document.fullscreenElement){document.exitFullscreen();$('sFull').textContent='Enter'}else{(document.documentElement.requestFullscreen||(()=>{})).call(document.documentElement);$('sFull').textContent='Exit'}};
$('sWin').oninput=e=>{st.win=+e.target.value;$('vWin').textContent=st.win};
$('sBig').oninput=e=>{st.big=+e.target.value;$('vBig').textContent=st.big};
$('sReset').onclick=()=>{st.credit=30;ui();msg('')};
$('sExit').onclick=()=>{document.body.innerHTML='<div style="display:flex;height:100%;align-items:center;justify-content:center;font:44px Impact,sans-serif;text-align:center">Thanks for playing!<br>Reload to play again.</div>'};
const shareTxt=()=>encodeURIComponent('I have $'+st.credit.toFixed(2)+' in Juice Slots!');
[['Facebook',()=>'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href)],['X',()=>'https://twitter.com/intent/tweet?text='+shareTxt()],['WhatsApp',()=>'https://wa.me/?text='+shareTxt()],['Telegram',()=>'https://t.me/share/url?url='+encodeURIComponent(location.href)+'&text='+shareTxt()],['Reddit',()=>'https://www.reddit.com/submit?title='+shareTxt()],['LinkedIn',()=>'https://www.linkedin.com/sharing/share-offsite/?url='+encodeURIComponent(location.href)]]
 .forEach(([n,u])=>{const b=document.createElement('button');b.textContent=n;b.style.margin='2px';b.onclick=()=>window.open(u(),'_blank');$('share').appendChild(b)});
ui();
