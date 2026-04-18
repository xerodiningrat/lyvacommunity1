<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'LYVA Community')</title>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Rajdhani:wght@400;500;600;700&family=Exo+2:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
:root{--bg0:#010714;--bg1:#030d1f;--bg2:#061428;--card:#091833;--border:rgba(30,80,160,0.35);--border2:rgba(50,120,220,0.55);--border3:rgba(80,150,255,0.75);--accent:#1a6ef5;--accent2:#3d8eff;--accent3:#6ab0ff;--gold:#f5c842;--gold2:#ffd966;--teal:#00e5b8;--pink:#ff4fa3;--red:#ff4444;--green:#22c55e;--text:#cce0ff;--text2:#7aa5d8;--text3:#3d6a9e;--white:#ffffff;--r-sm:10px;--r-md:14px;--r-lg:20px;--r-xl:28px;}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
body{background:var(--bg0);color:var(--text);font-family:'Exo 2',sans-serif;overflow-x:hidden;line-height:1.6;}
a{text-decoration:none;color:inherit;}
button{font:inherit;}
::-webkit-scrollbar{width:5px;}::-webkit-scrollbar-track{background:var(--bg0);}::-webkit-scrollbar-thumb{background:var(--border2);border-radius:3px;}
#starCanvas{position:fixed;inset:0;width:100%;height:100%;z-index:0;pointer-events:none;}
nav{position:fixed;top:0;left:0;right:0;z-index:900;display:flex;align-items:center;justify-content:space-between;padding:0 clamp(16px,4vw,48px);height:68px;background:rgba(1,7,20,.82);backdrop-filter:blur(24px) saturate(1.4);border-bottom:1px solid var(--border);transition:background .3s,box-shadow .3s;}
nav.scrolled{background:rgba(1,7,20,.97);box-shadow:0 4px 30px rgba(0,0,0,.5);}
.nav-logo{display:flex;align-items:center;flex-shrink:0;}
.nav-logo-mark{display:block;height:48px;width:auto;max-width:min(220px,36vw);object-fit:contain;filter:drop-shadow(0 0 18px rgba(140,188,255,.28)) drop-shadow(0 0 36px rgba(26,110,245,.18));}
.nav-links{display:flex;align-items:center;gap:4px;list-style:none;}
.nav-links a,.nav-drawer a{border:1px solid transparent;transition:all .22s;text-transform:uppercase;}
.nav-links a{color:var(--text2);font-size:12px;font-weight:600;letter-spacing:.8px;padding:7px 13px;border-radius:8px;white-space:nowrap;}
.nav-links a:hover,.nav-links a.act{color:var(--white);background:rgba(26,110,245,.12);border-color:var(--border2);}
.nav-cta{background:linear-gradient(135deg,var(--accent),#0c49c7)!important;color:#fff!important;border-color:var(--accent)!important;box-shadow:0 0 16px rgba(26,110,245,.4);}
.nav-cta:hover{box-shadow:0 0 28px rgba(26,110,245,.7)!important;transform:translateY(-1px);}
.nav-hamburger{display:none;flex-direction:column;justify-content:center;gap:5px;width:38px;height:38px;padding:8px;background:var(--card);border:1px solid var(--border);border-radius:9px;cursor:pointer;z-index:910;}
.nav-hamburger span{display:block;height:2px;border-radius:2px;background:var(--text2);transition:all .3s;}
.nav-hamburger.open span:nth-child(1){transform:translateY(7px) rotate(45deg);}
.nav-hamburger.open span:nth-child(2){opacity:0;transform:scaleX(0);}
.nav-hamburger.open span:nth-child(3){transform:translateY(-7px) rotate(-45deg);}
.nav-drawer{display:none;position:fixed;top:68px;left:0;right:0;bottom:0;background:rgba(1,7,20,.97);backdrop-filter:blur(20px);z-index:899;flex-direction:column;align-items:center;justify-content:center;gap:8px;transform:translateY(-100%);transition:transform .38s cubic-bezier(.4,0,.2,1);}
.nav-drawer.open{transform:translateY(0);}
.nav-drawer a{color:var(--text);font-size:20px;font-weight:600;font-family:'Orbitron',monospace;letter-spacing:3px;padding:14px 40px;border-radius:12px;width:280px;text-align:center;}
.nav-drawer a:hover,.nav-drawer a.act{color:var(--white);background:var(--card);border-color:var(--border2);}
.nav-drawer .m-cta{margin-top:12px;background:linear-gradient(135deg,var(--accent),#0c49c7);color:#fff!important;border-color:var(--accent)!important;box-shadow:0 0 22px rgba(26,110,245,.4);}
.hero,.page-hero{position:relative;z-index:1;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;overflow:hidden;padding-inline:clamp(16px,5vw,60px);}
.hero{min-height:100dvh;padding-block:clamp(100px,12vh,140px) 60px;}
.page-hero{min-height:52dvh;padding-block:140px 80px;}
.hero-glow,.page-glow{position:absolute;width:min(700px,90vw);height:min(700px,90vw);background:radial-gradient(circle,rgba(26,110,245,.1) 0%,transparent 68%);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;animation:hGlow 5s ease-in-out infinite;}
@keyframes hGlow{0%,100%{opacity:.7;transform:translate(-50%,-50%) scale(1);}50%{opacity:1;transform:translate(-50%,-50%) scale(1.12);}}
.hero-badge,.page-kicker{display:inline-flex;align-items:center;gap:8px;background:rgba(26,110,245,.1);border:1px solid rgba(61,142,255,.4);border-radius:50px;padding:8px 22px;font-size:11px;font-weight:700;letter-spacing:2.5px;color:var(--accent3);text-transform:uppercase;margin-bottom:28px;}
.hero-badge::before{content:'';width:8px;height:8px;border-radius:50%;background:var(--green);animation:blink 1.6s infinite;}
@keyframes blink{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.4;transform:scale(1.5);}}
.hero-title,.page-title{font-family:'Orbitron',monospace;font-weight:900;line-height:1.02;color:var(--white);}
.hero-title{font-size:clamp(40px,9vw,96px);letter-spacing:2px;margin-bottom:8px;text-shadow:0 0 50px rgba(26,110,245,.45);}
.page-title{font-size:clamp(34px,6vw,68px);letter-spacing:1px;text-shadow:0 0 30px rgba(26,110,245,.25);}
.hero-title .ol{color:transparent;-webkit-text-stroke:2px var(--accent2);filter:drop-shadow(0 0 12px var(--accent));}
.hero-sub,.page-copy{font-size:clamp(15px,2.2vw,19px);color:var(--text2);max-width:700px;margin:20px auto 38px;line-height:1.75;}
.hero-btns,.page-actions{display:flex;gap:14px;flex-wrap:wrap;justify-content:center;}
.btn{display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border-radius:var(--r-sm);font-family:'Exo 2',sans-serif;font-weight:700;font-size:13px;letter-spacing:1.5px;text-transform:uppercase;border:none;cursor:pointer;transition:all .28s;white-space:nowrap;}
.btn-p{background:linear-gradient(135deg,var(--accent),#0c49c7);color:white;box-shadow:0 0 22px rgba(26,110,245,.45),0 4px 18px rgba(26,110,245,.3);}
.btn-p:hover{transform:translateY(-3px);box-shadow:0 0 38px rgba(26,110,245,.7),0 8px 28px rgba(26,110,245,.4);}
.btn-g{background:rgba(26,110,245,.08);color:var(--accent3);border:1.5px solid rgba(61,142,255,.4);}
.btn-g:hover{background:rgba(26,110,245,.15);border-color:var(--accent2);transform:translateY(-3px);}
.hero-stats{display:flex;align-items:stretch;justify-content:center;gap:clamp(18px,3.4vw,42px);flex-wrap:nowrap;margin-top:62px;padding:0 clamp(12px,2vw,24px);width:min(760px,100%);}
.h-stat{min-width:0;flex:1;text-align:center;}
.h-stat-n{font-family:'Orbitron',monospace;font-size:clamp(26px,4.4vw,48px);font-weight:800;line-height:1;color:#f2f7ff;letter-spacing:-1px;text-shadow:0 0 18px rgba(120,190,255,.18);}
.h-stat-l{font-size:11px;color:#4f74aa;letter-spacing:3px;text-transform:uppercase;margin-top:14px;}
.h-div{width:1px;min-height:72px;background:linear-gradient(180deg,rgba(46,96,173,0),rgba(61,142,255,.58),rgba(46,96,173,0));align-self:center;}
.sw{position:relative;z-index:1;width:100%;max-width:1220px;margin:0 auto;padding:clamp(56px,8vw,100px) clamp(16px,4vw,48px);}
.sh{text-align:center;margin-bottom:clamp(36px,5vw,56px);}
.stag{display:inline-block;font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--accent3);margin-bottom:10px;}
.stitle{font-family:'Orbitron',monospace;font-size:clamp(22px,4vw,38px);font-weight:700;color:var(--white);letter-spacing:2px;text-shadow:0 0 20px rgba(26,110,245,.35);}
.sdesc{font-size:15px;color:var(--text2);margin-top:12px;max-width:560px;margin-inline:auto;}
.divl{position:relative;z-index:1;height:1px;width:100%;background:linear-gradient(90deg,transparent 0%,rgba(50,120,220,.4) 30%,rgba(80,150,255,.6) 50%,rgba(50,120,220,.4) 70%,transparent 100%);}
.feat-grid,.shop-grid,.mem-grid,.rules-grid{display:grid;gap:16px;}
.feat-grid{grid-template-columns:repeat(auto-fit,minmax(min(280px,100%),1fr));}
.shop-grid{grid-template-columns:repeat(auto-fill,minmax(min(220px,100%),1fr));}
.mem-grid{grid-template-columns:repeat(auto-fill,minmax(min(160px,100%),1fr));}
.rules-grid{grid-template-columns:repeat(auto-fit,minmax(min(280px,100%),1fr));}
.fc,.sc,.mc,.rc,.gi,.evc,.lbc{border:1px solid var(--border);transition:all .32s;}
.fc,.rc,.evc,.lbc,.ann{background:linear-gradient(145deg,rgba(10,26,55,.94),rgba(7,16,38,.98));}
.fc,.sc,.mc{border-radius:var(--r-lg);}
.fc{position:relative;overflow:hidden;padding:32px 26px;}
.fc:hover,.sc:hover,.mc:hover,.rc:hover,.evc:hover,.lbc:hover{border-color:var(--border2);transform:translateY(-6px);box-shadow:0 18px 44px rgba(0,0,0,.45);}
.fc-icon{width:58px;height:58px;border-radius:15px;margin-bottom:20px;display:flex;align-items:center;justify-content:center;background:rgba(26,110,245,.1);border:1px solid rgba(61,142,255,.25);font-size:26px;}
.fc-name,.sc-name,.mc-name,.ev-name,.lb-name,.rc-title,.ann-title{font-family:'Rajdhani',sans-serif;font-weight:700;color:var(--white);}
.fc-name{font-size:19px;margin-bottom:10px;}
.fc-desc,.rc-desc,.ev-desc,.ann-text{font-size:13.5px;color:var(--text2);line-height:1.72;}
.fc-arr{position:absolute;bottom:24px;right:24px;font-size:18px;color:var(--border2);}
.ann-list,.ev-list,.lb-list{display:flex;flex-direction:column;gap:14px;}
.ann{display:flex;gap:18px;align-items:flex-start;border:1px solid var(--border);border-radius:var(--r-md);padding:22px;position:relative;overflow:hidden;}
.ann::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--accent);}
.ann.at::before{background:var(--teal);}
.ann.ag::before{background:var(--gold);}
.ann-em{font-size:24px;flex-shrink:0;margin-top:2px;}
.ann-top{display:flex;align-items:flex-start;gap:10px;margin-bottom:7px;flex-wrap:wrap;}
.ann-time,.gi-meta,.ev-mon,.mc-role,.sc-pu,.lb-sub{font-size:11px;color:var(--text3);}
.gal-grid{display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:180px;gap:14px;}
.gi{position:relative;overflow:hidden;border-radius:var(--r-md);cursor:pointer;background:#091327;}
.gi:hover{transform:scale(1.03);border-color:var(--border3);box-shadow:0 10px 40px rgba(26,110,245,.25);}
.gi.s2{grid-column:span 2;}
.gi.tall{grid-row:span 2;}
.gi-media{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s ease,filter .4s ease;filter:saturate(1.02) contrast(1.02);}
.gi:hover .gi-media{transform:scale(1.06);filter:saturate(1.08) contrast(1.05);}
.gi-ph{width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;background:linear-gradient(135deg,#0a1933,#10264d);}
.gi-em{font-size:52px;line-height:1;}
.gi-lsm{font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--text3);}
.gi-ov{position:absolute;inset:0;background:linear-gradient(to top,rgba(1,7,20,.96) 0%,rgba(1,7,20,.28) 42%,transparent 72%);display:flex;align-items:flex-end;padding:16px 18px;}
.gi-name{font-family:'Rajdhani',sans-serif;font-size:16px;font-weight:700;color:#fff;}
.sc{background:linear-gradient(160deg,rgba(10,27,56,.98),rgba(6,16,34,1));overflow:hidden;position:relative;isolation:isolate;}
.sc-img{position:relative;aspect-ratio:1;display:flex;align-items:center;justify-content:center;font-size:62px;overflow:hidden;}
.sc-img::after{content:'';position:absolute;bottom:0;left:0;right:0;height:50%;background:linear-gradient(to top,rgba(6,16,34,1),transparent);pointer-events:none;}
.sc-shine{position:absolute;top:-40%;left:-40%;width:80%;height:80%;background:radial-gradient(circle,rgba(255,255,255,.04),transparent 70%);}
.sc-badge{position:absolute;top:10px;right:10px;z-index:2;font-size:9px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;padding:4px 9px;border-radius:50px;}
.bh{background:rgba(255,107,53,.2);color:#ff6b35;border:1px solid rgba(255,107,53,.4);}
.bn{background:rgba(0,229,184,.15);color:var(--teal);border:1px solid rgba(0,229,184,.35);}
.br{background:rgba(245,200,66,.15);color:var(--gold);border:1px solid rgba(245,200,66,.35);}
.bv{background:rgba(168,85,247,.15);color:#c084fc;border:1px solid rgba(168,85,247,.35);}
.sc-body{padding:16px 16px 18px;}
.sc-name{font-size:16px;margin-bottom:8px;}
.sc-pr{display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;}
.sc-pv,.lb-pts,.ev-day{font-family:'Orbitron',monospace;font-weight:700;}
.sc-pv{font-size:15px;color:var(--gold);}
.sc-stars{font-size:11px;color:var(--gold2);}
.sc-btn{width:100%;padding:10px;border-radius:9px;background:rgba(26,110,245,.1);border:1px solid var(--border2);color:var(--accent3);font-size:11.5px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;cursor:pointer;transition:all .25s;}
.sc-btn:hover{background:var(--accent);color:white;border-color:var(--accent);}
.mc{padding:26px 16px 22px;text-align:center;position:relative;overflow:hidden;background:linear-gradient(160deg,rgba(10,27,56,.97),rgba(6,16,34,1));}
.mc-avw{position:relative;width:64px;height:64px;margin:0 auto 14px;}
.mc-av{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;border:2px solid var(--border2);background:rgba(26,110,245,.08);}
.mc-av-img{width:100%;height:100%;display:block;object-fit:cover;border-radius:50%;}
.mc-on{position:absolute;bottom:1px;right:1px;width:13px;height:13px;border-radius:50%;background:var(--green);border:2.5px solid var(--bg1);}
.mc-meta{font-size:12px;color:var(--text2);margin:10px 0 0;line-height:1.55;}
.mc-role{font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:4px 12px;border-radius:50px;display:inline-block;}
.ro{background:rgba(245,200,66,.14);color:var(--gold);border:1px solid rgba(245,200,66,.3);}
.ra{background:rgba(255,79,163,.12);color:var(--pink);border:1px solid rgba(255,79,163,.28);}
.rm{background:rgba(26,110,245,.12);color:var(--accent3);border:1px solid rgba(61,142,255,.3);}
.rl{background:rgba(0,229,184,.1);color:var(--teal);border:1px solid rgba(0,229,184,.25);}
.rp{background:rgba(168,85,247,.12);color:#c084fc;border:1px solid rgba(168,85,247,.3);}
.evc{display:flex;align-items:center;gap:18px;border-radius:var(--r-md);padding:20px 22px;position:relative;overflow:hidden;}
.ev-date{background:rgba(26,110,245,.1);border:1px solid rgba(61,142,255,.3);border-radius:12px;padding:10px 14px;text-align:center;flex-shrink:0;min-width:58px;}
.ev-day{font-size:24px;color:var(--accent2);line-height:1;}
.ev-ic{font-size:28px;flex-shrink:0;}
.ev-inf{flex:1;min-width:0;}
.ev-name{font-size:18px;margin-bottom:5px;}
.evb{font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:5px 13px;border-radius:50px;white-space:nowrap;flex-shrink:0;}
.evl{background:rgba(34,197,94,.12);color:var(--green);border:1px solid rgba(34,197,94,.3);}
.evs{background:rgba(245,200,66,.12);color:var(--gold);border:1px solid rgba(245,200,66,.3);}
.evd{background:rgba(30,80,160,.1);color:var(--text3);border:1px solid var(--border);}
.lbc{display:flex;align-items:center;gap:16px;border-radius:var(--r-md);padding:16px 20px;}
.lbc.t1{background:linear-gradient(135deg,rgba(30,22,5,.9),rgba(40,28,0,.9));border-color:rgba(245,200,66,.3);}
.lbc.t2{background:linear-gradient(135deg,rgba(12,16,22,.9),rgba(18,22,28,.9));border-color:rgba(192,192,192,.2);}
.lbc.t3{background:linear-gradient(135deg,rgba(20,12,6,.9),rgba(28,16,8,.9));border-color:rgba(205,127,50,.2);}
.lb-rank{font-family:'Orbitron',monospace;font-size:20px;font-weight:900;min-width:36px;text-align:center;}
.r1{color:var(--gold);}.r2{color:#c0c0c0;}.r3{color:#cd7f32;}.rn{color:var(--text3);font-size:15px;}
.lb-av{font-size:28px;}
.lb-inf{flex:1;min-width:0;}
.lb-name{font-size:16px;}
.lb-pts{font-size:14px;color:var(--accent3);white-space:nowrap;}
.lb-bar-w{width:80px;background:rgba(26,110,245,.08);border-radius:4px;height:6px;overflow:hidden;}
.lb-bar{height:100%;border-radius:4px;background:linear-gradient(90deg,var(--accent),var(--accent3));}
.rc{display:flex;gap:16px;border-radius:var(--r-md);padding:22px 20px;}
.rc-num{font-family:'Orbitron',monospace;font-size:30px;font-weight:900;color:var(--border2);line-height:1;flex-shrink:0;width:42px;}
.mbg{position:fixed;inset:0;z-index:9800;background:rgba(0,0,0,.75);backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .3s;}
.mbg.open{opacity:1;pointer-events:all;}
.mbox{background:linear-gradient(160deg,rgba(10,28,58,.99),rgba(7,16,38,1));border:1px solid var(--border2);border-radius:var(--r-xl);padding:clamp(28px,5vw,44px);width:100%;max-width:460px;position:relative;box-shadow:0 30px 80px rgba(0,0,0,.7);}
.mcl{position:absolute;top:16px;right:18px;background:rgba(26,110,245,.1);border:1px solid var(--border);color:var(--text2);width:30px;height:30px;border-radius:8px;font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;}
.mt{font-family:'Orbitron',monospace;font-size:22px;font-weight:700;color:var(--white);margin-bottom:8px;}
.ms{font-size:14px;color:var(--text2);line-height:1.65;margin-bottom:24px;}
.mi{width:100%;background:rgba(6,20,46,.8);border:1px solid var(--border);border-radius:11px;padding:13px 16px;color:var(--text);font-size:14px;margin-bottom:12px;outline:none;}
.mck{display:flex;align-items:center;gap:10px;font-size:13px;color:var(--text2);margin-bottom:22px;cursor:pointer;}
.mbtns{display:flex;gap:10px;flex-wrap:wrap;}
.mbtns .btn{flex:1;min-width:120px;justify-content:center;}
.toast{position:fixed;bottom:24px;right:24px;z-index:9900;background:rgba(10,26,55,.97);border:1px solid var(--accent);border-radius:14px;padding:14px 20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:600;color:var(--text);box-shadow:0 8px 32px rgba(0,0,0,.5);transform:translateX(calc(100% + 30px));transition:transform .42s cubic-bezier(.34,1.2,.64,1);max-width:min(340px,calc(100vw - 48px));}
.toast.show{transform:translateX(0);}
footer{position:relative;z-index:1;background:linear-gradient(to bottom,var(--bg1),var(--bg0));border-top:1px solid var(--border);padding:clamp(48px,7vw,80px) clamp(16px,4vw,48px) clamp(24px,4vw,40px);}
.fi{max-width:1220px;margin:0 auto;display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:clamp(24px,4vw,48px);margin-bottom:clamp(36px,5vw,48px);}
.flr{display:flex;align-items:center;gap:12px;margin-bottom:16px;}
.fli{width:40px;height:40px;border-radius:11px;background:linear-gradient(135deg,var(--accent),var(--accent3));display:flex;align-items:center;justify-content:center;font-size:18px;}
.fln{font-family:'Orbitron',monospace;font-size:16px;font-weight:900;color:var(--white);letter-spacing:3px;}
.ftag{font-size:13px;color:var(--text2);line-height:1.75;max-width:250px;margin-bottom:20px;}
.fsoc{display:flex;gap:8px;flex-wrap:wrap;}
.fsb{width:36px;height:36px;background:var(--card);border:1px solid var(--border);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;}
.fch{font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:var(--white);letter-spacing:2px;text-transform:uppercase;margin-bottom:14px;}
.flinks{list-style:none;display:flex;flex-direction:column;gap:9px;}
.flinks a{font-size:13px;color:var(--text2);transition:color .2s,transform .2s;display:inline-block;}
.flinks a:hover{color:var(--accent3);transform:translateX(4px);}
.fbot{max-width:1220px;margin:0 auto;border-top:1px solid var(--border);padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.fbot-c,.fbot-h{font-size:12px;color:var(--text3);}
.fbot-h span{color:var(--pink);}
@media(max-width:900px){.nav-links{display:none;}.nav-hamburger{display:flex;}.nav-drawer{display:flex;}.gal-grid{grid-template-columns:repeat(2,1fr);grid-auto-rows:160px;}.gi.s2{grid-column:span 1;}.fi{grid-template-columns:1fr 1fr;}}
@media(max-width:640px){nav{padding:0 16px;height:62px;}.nav-logo-mark{height:40px;max-width:min(180px,52vw);}.hero-stats{gap:16px;flex-wrap:wrap;width:100%;max-width:420px;}.h-stat{flex:0 0 calc(50% - 8px);}.h-stat-n{font-size:clamp(24px,8vw,34px);}.h-stat-l{letter-spacing:2.2px;margin-top:10px;}.h-div{display:none;}.gal-grid{grid-template-columns:1fr 1fr;grid-auto-rows:130px;}.gi.tall{grid-row:span 1;}.shop-grid{grid-template-columns:repeat(2,1fr);gap:12px;}.mem-grid{grid-template-columns:repeat(3,1fr);}.evc{flex-wrap:wrap;gap:12px;}.lb-bar-w{display:none;}.fi{grid-template-columns:1fr;}.ftag{max-width:100%;}}
@media(max-width:420px){.shop-grid{grid-template-columns:1fr;}.mem-grid{grid-template-columns:repeat(2,1fr);}.gal-grid{grid-template-columns:1fr;}.hero-btns,.page-actions{flex-direction:column;align-items:center;}.hero-btns .btn,.page-actions .btn{width:100%;max-width:280px;justify-content:center;}.mbtns{flex-direction:column;}}
</style>
</head>
<body>
<canvas id="starCanvas"></canvas>
<div class="toast" id="toast"><span id="tIcon">✅</span><span id="tMsg">Ok!</span></div>

<div class="mbg" id="mJoin">
  <div class="mbox">
    <button class="mcl" onclick="cm('mJoin')">✕</button>
    <div class="mt">🎮 Join LYVA</div>
    <div class="ms">Masukkan data kamu untuk bergabung dengan komunitas Roblox terbaik Indonesia!</div>
    <input type="text" class="mi" id="jUser" placeholder="Username Roblox kamu...">
    <input type="text" class="mi" id="jDisc" placeholder="Discord tag (opsional)">
    <label class="mck"><input type="checkbox" id="jAgree"> Saya setuju dengan peraturan LYVA Community</label>
    <div class="mbtns">
      <button class="btn btn-p" onclick="submitJoin()">🚀 Join Sekarang!</button>
      <button class="btn btn-g" onclick="cm('mJoin')">Batal</button>
    </div>
  </div>
</div>

<nav id="nav">
  <div class="nav-logo">
    <a href="{{ route('home') }}"><img src="{{ asset('lyva-navbar-logo.png') }}" alt="LYVA Community" class="nav-logo-mark"></a>
  </div>
  <ul class="nav-links">
    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'act' : '' }}">🏠 Home</a></li>
    <li><a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'act' : '' }}">🖼️ Gallery</a></li>
    <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'act' : '' }}">🛒 Shop</a></li>
    <li><a href="{{ route('members') }}" class="{{ request()->routeIs('members') ? 'act' : '' }}">👥 Members</a></li>
    <li><a href="{{ route('events') }}" class="{{ request()->routeIs('events') ? 'act' : '' }}">🎉 Events</a></li>
    <li><a href="{{ route('leaderboard') }}" class="{{ request()->routeIs('leaderboard') ? 'act' : '' }}">🏆 Rank</a></li>
    <li><a href="#" class="nav-cta" onclick="om('mJoin');return false">✨ Join</a></li>
  </ul>
  <button class="nav-hamburger" id="hbg" onclick="toggleMenu()"><span></span><span></span><span></span></button>
</nav>
<nav class="nav-drawer" id="nDrawer">
  <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'act' : '' }}" onclick="closeMenu()">🏠 Home</a>
  <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'act' : '' }}" onclick="closeMenu()">🖼️ Gallery</a>
  <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'act' : '' }}" onclick="closeMenu()">🛒 Shop</a>
  <a href="{{ route('members') }}" class="{{ request()->routeIs('members') ? 'act' : '' }}" onclick="closeMenu()">👥 Members</a>
  <a href="{{ route('events') }}" class="{{ request()->routeIs('events') ? 'act' : '' }}" onclick="closeMenu()">🎉 Events</a>
  <a href="{{ route('leaderboard') }}" class="{{ request()->routeIs('leaderboard') ? 'act' : '' }}" onclick="closeMenu()">🏆 Ranking</a>
  <a href="#" class="m-cta" onclick="om('mJoin');closeMenu();return false">✨ Join LYVA</a>
</nav>

@yield('content')

<div class="divl"></div>

<footer>
  <div class="fi">
    <div><div class="flr"><div class="fli">🎮</div><div class="fln">LYVA</div></div><div class="ftag">Komunitas Roblox terbaik dan paling aktif di Indonesia. Bergabunglah dan rasakan gaming yang luar biasa!</div><div class="fsoc"><div class="fsb">💬</div><div class="fsb">📺</div><div class="fsb">🎵</div><div class="fsb">📸</div><div class="fsb">🐦</div></div></div>
    <div><div class="fch">Navigasi</div><ul class="flinks"><li><a href="{{ route('home') }}">Home</a></li><li><a href="{{ route('gallery') }}">Gallery</a></li><li><a href="{{ route('shop') }}">Shop</a></li><li><a href="{{ route('events') }}">Events</a></li><li><a href="{{ route('leaderboard') }}">Ranking</a></li></ul></div>
    <div><div class="fch">Komunitas</div><ul class="flinks"><li><a href="{{ route('members') }}">Members</a></li><li><a href="{{ route('events') }}">Turnamen</a></li><li><a href="{{ route('gallery') }}">Screenshots</a></li><li><a href="#" onclick="om('mJoin');return false;">Gabung</a></li></ul></div>
    <div><div class="fch">Discord</div><ul class="flinks"><li><a href="{{ $discordCommunity['invite_url'] ?? '#' }}" target="_blank" rel="noreferrer">Join Server</a></li><li><a href="{{ route('gallery') }}">Gallery Discord</a></li><li><a href="{{ route('leaderboard') }}">Top Players</a></li></ul></div>
  </div>
  <div class="fbot"><div class="fbot-c">© 2026 LYVA Community. All Rights Reserved.</div><div class="fbot-h">Made with <span>♥</span> for Roblox Indonesia</div></div>
</footer>

<script>
const cv=document.getElementById('starCanvas'),cx=cv.getContext('2d');
function rsz(){cv.width=window.innerWidth;cv.height=window.innerHeight;}rsz();window.addEventListener('resize',rsz);
const ST=Array.from({length:220},()=>({x:Math.random()*cv.width,y:Math.random()*cv.height,r:Math.random()*1.4+.2,a:Math.random(),da:Math.random()*.018+.004,d:Math.random()>.5?1:-1}));
const SH=[];
function spSH(){SH.push({x:Math.random()*cv.width*.72,y:Math.random()*cv.height*.45,len:Math.random()*130+70,spd:Math.random()*9+6,a:1,ang:Math.PI/4+(Math.random()-.5)*.45});}
setInterval(spSH,1800);
function frm(){cx.clearRect(0,0,cv.width,cv.height);ST.forEach(s=>{s.a+=s.da*s.d;if(s.a>1||s.a<.1)s.d*=-1;cx.beginPath();cx.arc(s.x,s.y,s.r,0,Math.PI*2);cx.fillStyle=`rgba(180,215,255,${s.a})`;cx.fill();});for(let i=SH.length-1;i>=0;i--){const s=SH[i];const g=cx.createLinearGradient(s.x,s.y,s.x-Math.cos(s.ang)*s.len,s.y-Math.sin(s.ang)*s.len);g.addColorStop(0,`rgba(120,190,255,${s.a})`);g.addColorStop(.5,`rgba(70,150,255,${s.a*.4})`);g.addColorStop(1,'rgba(0,0,0,0)');cx.beginPath();cx.moveTo(s.x,s.y);cx.lineTo(s.x-Math.cos(s.ang)*s.len,s.y-Math.sin(s.ang)*s.len);cx.strokeStyle=g;cx.lineWidth=1.8;cx.stroke();s.x+=Math.cos(s.ang)*s.spd;s.y+=Math.sin(s.ang)*s.spd;s.a-=.02;if(s.a<=0||s.x>cv.width||s.y>cv.height)SH.splice(i,1);}requestAnimationFrame(frm);}frm();
window.addEventListener('scroll',()=>document.getElementById('nav').classList.toggle('scrolled',window.scrollY>60));
function toggleMenu(){document.getElementById('hbg').classList.toggle('open');document.getElementById('nDrawer').classList.toggle('open');}
function closeMenu(){document.getElementById('hbg').classList.remove('open');document.getElementById('nDrawer').classList.remove('open');}
function om(id){document.getElementById(id).classList.add('open');}
function cm(id){document.getElementById(id).classList.remove('open');}
document.querySelectorAll('.mbg').forEach(m=>m.addEventListener('click',e=>{if(e.target===m)m.classList.remove('open');}));
let tt;function toast(msg){clearTimeout(tt);document.getElementById('tMsg').textContent=msg;const t=document.getElementById('toast');t.classList.add('show');tt=setTimeout(()=>t.classList.remove('show'),3400);}
function addCart(name){toast('🛒 '+name+' ditambahkan ke keranjang!');}
function submitJoin(){const u=document.getElementById('jUser').value.trim();const ok=document.getElementById('jAgree').checked;if(!u){toast('⚠️ Masukkan username Roblox dulu!');return;}if(!ok){toast('⚠️ Setujui peraturan komunitas dulu!');return;}cm('mJoin');toast('🎉 Selamat datang di LYVA, '+u+'!');document.getElementById('jUser').value='';document.getElementById('jAgree').checked=false;}
</script>
</body>
</html>
