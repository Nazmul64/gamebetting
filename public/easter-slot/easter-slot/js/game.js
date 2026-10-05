const IMG={Q:"assets/queen.jpg",J:"assets/jack.jpg",U:"assets/egg-blue.jpg",R:"assets/egg-red.jpg",P:"assets/egg-purple.jpg",G:"assets/egg-gold.jpg",B:"assets/bonus.jpg",W:"assets/wild.jpg",C:"assets/scatter.jpg"},W0=1892,H0=849;
const xs=[491,677,863,1049,1236],ys=[218,383,548],cw=170,ch=148;
const BAG='QQQJJJRRRUUUPPGGWBBC'.split('');
const PAY={Q:[0,0,2,5,20],J:[0,0,2,5,15],R:[0,0,4,12,40],U:[0,0,4,12,40],P:[0,0,5,15,50],G:[0,0,8,25,100],W:[0,0,10,40,200]};
const LINES=[[1,1,1,1,1],[0,0,0,0,0],[2,2,2,2,2],[0,1,2,1,0],[2,1,0,1,2],[0,0,1,2,2],[2,2,1,0,0],[1,0,0,0,1],[1,2,2,2,1],[0,1,1,1,0],[2,1,1,1,2],[1,0,1,2,1],[1,2,1,0,1],[0,1,0,1,0],[2,1,2,1,2],[1,1,0,1,1],[1,1,2,1,1],[0,0,2,0,0],[2,2,0,2,2],[0,2,2,2,0]];
const $=id=>document.getElementById(id),st=$('stage');
let bet=20,bal=99986,busy=false,auto=false,grid=[],cells=[];
const rnd=()=>BAG[Math.random()*BAG.length|0];
for(let r=0;r<3;r++){grid.push([]);for(let c=0;c<5;c++){
 const d=document.createElement('div');d.className='cell';
 d.style.cssText=`left:${(xs[c]+3)/W0*100}%;top:${(ys[r]+3)/H0*100}%;width:${(cw-6)/W0*100}%;height:${(ch-6)/H0*100}%`;
 d.innerHTML='<img>';st.appendChild(d);cells.push(d);grid[r].push(rnd());}}
function draw(r,c){cells[r*5+c].firstChild.src=IMG[grid[r][c]]}
function all(){for(let r=0;r<3;r++)for(let c=0;c<5;c++)draw(r,c)}
function ui(){$('tb').textContent=bet;$('bal').textContent=bal}
all();ui();$('win').textContent=0;
function clr(){cells.forEach(d=>d.className='cell')}
function evaluate(){let total=0;const hit=new Set(),lb=bet/20;
 LINES.forEach(L=>{const line=L.map((r,c)=>grid[r][c]);const t=line.find(x=>x!=='W')||'W';
  if(t==='B'||t==='C')return;let n=0;while(n<5&&(line[n]===t||line[n]==='W'))n++;
  if(n>=3){total+=PAY[t][n-1]*lb;for(let i=0;i<n;i++)hit.add(L[i]*5+i)}});
 const sc=[],bo=[];grid.forEach((row,r)=>row.forEach((s,c)=>{if(s==='C')sc.push(r*5+c);if(s==='B')bo.push(r*5+c)}));
 let extra='',scWin=false;
 if(sc.length>=3){total+=bet*[0,0,0,2,10,50][Math.min(sc.length,5)];extra+=' Scatter x'+sc.length+'!';scWin=true;sc.forEach(i=>hit.add(i))}
 if(bo.length>=3){total+=bet*5;extra+=' Bonus x'+bo.length+'!';bo.forEach(i=>hit.add(i))}
 return{total,hit,extra,scWin,sc}}
function spin(){if(busy)return;
 if(bal<bet){$('msg').textContent='Not enough balance';auto=false;$('autob').classList.remove('auto');return}
 busy=true;bal-=bet;ui();$('win').textContent=0;$('msg').textContent='';clr();
 const stop=[0,0,0,0,0];
 const iv=setInterval(()=>{for(let c=0;c<5;c++)if(!stop[c])for(let r=0;r<3;r++){grid[r][c]=rnd();draw(r,c)}},70);
 for(let c=0;c<5;c++)setTimeout(()=>{stop[c]=1;for(let r=0;r<3;r++){grid[r][c]=rnd();draw(r,c)}
  if(c===4){clearInterval(iv);const e=evaluate();
   if(e.total>0||e.hit.size){cells.forEach((d,i)=>{if(e.hit.has(i))d.classList.add(e.scWin&&e.sc.includes(i)?'sc':'win');else d.classList.add('dim')})}
   bal+=e.total;ui();$('win').textContent=e.total;
   $('msg').textContent=e.total?('WIN '+e.total+e.extra):'';
   busy=false;if(auto)setTimeout(spin,e.total?2200:1200)}},600+c*350)}
const setBet=v=>{bet=Math.max(20,Math.min(2000,v));ui()};
$('spin').onclick=spin;$('plus').onclick=()=>setBet(bet+20);$('minus').onclick=()=>setBet(bet-20);
$('max').onclick=()=>{setBet(2000);spin()};
$('autob').onclick=()=>{auto=!auto;$('autob').classList.toggle('auto',auto);if(auto)spin()};
