const IMG={S:"assets/scatter.jpg",A:"assets/coin-arch.jpg",V:"assets/vase.jpg",W:"assets/wild.jpg",F:"assets/coin-altar.jpg",K:"assets/coin-column.jpg",H:"assets/helmet.jpg",L:"assets/wreath.jpg",N:"assets/coin-lion.jpg",D:"assets/dagger.jpg"},W0=1170,H0=658;
const x0=204,y0=147,cw=152.6,ch=130.0;
// symbol frequency on the reels
const BAG='KKKAAAFFFNNNHHLLVVDDWSS'.split('');
// payout multipliers for 3 / 4 / 5 in a row (x line bet)
const PAY={K:[0,0,2,5,20],F:[0,0,2,5,20],A:[0,0,3,8,30],N:[0,0,3,8,30],H:[0,0,5,12,50],L:[0,0,5,12,50],V:[0,0,8,25,100],D:[0,0,8,25,100],W:[0,0,15,50,300]};
const SCATTER=[0,0,0,2,10,50]; // x total bet for 3/4/5 scatters anywhere
const LINES=[[1,1,1,1,1],[0,0,0,0,0],[2,2,2,2,2],[0,1,2,1,0],[2,1,0,1,2],[0,0,1,2,2],[2,2,1,0,0],[1,0,0,0,1],[1,2,2,2,1],[0,1,1,1,0],[2,1,1,1,2],[1,0,1,2,1],[1,2,1,0,1],[0,1,0,1,0],[2,1,2,1,2],[1,1,0,1,1],[1,1,2,1,1],[0,0,2,0,0],[2,2,0,2,2],[0,2,2,2,0]];
const $=id=>document.getElementById(id),st=$('stage');
let bet=21350,bal=1435560,busy=false,auto=false,grid=[],cells=[];
const rnd=()=>BAG[Math.random()*BAG.length|0];
for(let r=0;r<3;r++){grid.push([]);for(let c=0;c<5;c++){
 const d=document.createElement('div');d.className='cell';
 d.style.cssText=`left:${(x0+c*cw+1)/W0*100}%;top:${(y0+r*ch+1)/H0*100}%;width:${(cw-2)/W0*100}%;height:${(ch-2)/H0*100}%`;
 d.innerHTML='<img>';st.appendChild(d);cells.push(d);grid[r].push(rnd());}}
const draw=(r,c)=>cells[r*5+c].firstChild.src=IMG[grid[r][c]];
const all=()=>{for(let r=0;r<3;r++)for(let c=0;c<5;c++)draw(r,c)};
const ui=()=>{$('tb').textContent=bet;$('bal').textContent=bal};
all();ui();$('win').textContent=0;
const clr=()=>cells.forEach(d=>d.className='cell');
function evaluate(){let total=0;const hit=new Set(),lb=bet/20;
 LINES.forEach(L=>{const line=L.map((r,c)=>grid[r][c]);const t=line.find(x=>x!=='W')||'W';
  if(t==='S')return;let n=0;while(n<5&&(line[n]===t||line[n]==='W'))n++;
  if(n>=3){total+=PAY[t][n-1]*lb;for(let i=0;i<n;i++)hit.add(L[i]*5+i)}});
 const sc=[];grid.forEach((row,r)=>row.forEach((s,c)=>{if(s==='S')sc.push(r*5+c)}));
 let extra='',scWin=false;
 if(sc.length>=3){total+=bet*SCATTER[Math.min(sc.length,5)];extra=' Scatter x'+sc.length+'!';scWin=true;sc.forEach(i=>hit.add(i))}
 return{total,hit,extra,scWin,sc}}
function spin(){if(busy)return;
 if(bal<bet){$('msg').textContent='Not enough balance';auto=false;$('autob').classList.remove('auto');return}
 busy=true;bal-=bet;ui();$('win').textContent=0;$('msg').textContent='';clr();
 const stop=[0,0,0,0,0];
 const iv=setInterval(()=>{for(let c=0;c<5;c++)if(!stop[c])for(let r=0;r<3;r++){grid[r][c]=rnd();draw(r,c)}},70);
 for(let c=0;c<5;c++)setTimeout(()=>{stop[c]=1;for(let r=0;r<3;r++){grid[r][c]=rnd();draw(r,c)}
  if(c===4){clearInterval(iv);const e=evaluate();
   if(e.hit.size)cells.forEach((d,i)=>d.classList.add(e.hit.has(i)?(e.scWin&&e.sc.includes(i)?'sc':'win'):'dim'));
   bal+=e.total;ui();$('win').textContent=e.total;
   $('msg').textContent=e.total?('WIN '+e.total+e.extra):'';
   busy=false;if(auto)setTimeout(spin,e.total?2200:1200)}},600+c*350)}
const setBet=v=>{bet=Math.max(1250,Math.min(250000,v));ui()};
$('spin').onclick=spin;$('plus').onclick=()=>setBet(bet+1250);$('minus').onclick=()=>setBet(bet-1250);
$('max').onclick=()=>{setBet(250000);spin()};
$('autob').onclick=()=>{auto=!auto;$('autob').classList.toggle('auto',auto);if(auto)spin()};
