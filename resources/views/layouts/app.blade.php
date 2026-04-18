<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'LYVACOMMUNITY | HOME')</title>
<meta name="theme-color" content="#010714">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="LYVA Community">
<meta name="mobile-web-app-capable" content="yes">
<link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon-180.png') }}">
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
.nav-links{position:absolute;left:50%;transform:translateX(-50%);display:flex;align-items:center;justify-content:center;gap:4px;list-style:none;width:max-content;}
.nav-links a,.nav-drawer a{border:1px solid transparent;transition:all .22s;text-transform:uppercase;}
.nav-links a{color:var(--text2);font-size:12px;font-weight:600;letter-spacing:.8px;padding:7px 13px;border-radius:8px;white-space:nowrap;}
.nav-links a:hover,.nav-links a.act{color:var(--white);background:rgba(26,110,245,.12);border-color:var(--border2);}
.nav-auth{display:flex;align-items:center;gap:10px;margin-left:auto;position:relative;z-index:1;flex:0 0 auto;}
.nav-auth-name{max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:11px;font-weight:700;letter-spacing:1.1px;text-transform:uppercase;color:var(--accent3);}
.nav-auth-link{color:var(--text2);font-size:12px;font-weight:700;letter-spacing:.8px;padding:7px 13px;border-radius:8px;border:1px solid transparent;text-transform:uppercase;transition:all .22s;white-space:nowrap;}
.nav-auth-link:hover,.nav-auth-link.act{color:var(--white);background:rgba(26,110,245,.12);border-color:var(--border2);}
.nav-cta{display:inline-flex;align-items:center;justify-content:center;min-height:40px;padding:0 18px;border-radius:12px;border:1px solid rgba(90,157,255,.45);background:linear-gradient(135deg,#2678ff,#0f4fcd)!important;color:#fff!important;box-shadow:0 8px 22px rgba(16,78,206,.32),inset 0 1px 0 rgba(255,255,255,.18);font-size:12px;font-weight:800;letter-spacing:1px;text-transform:uppercase;white-space:nowrap;}
.nav-cta:hover{box-shadow:0 0 28px rgba(26,110,245,.7)!important;transform:translateY(-1px);}
.nav-install{background:rgba(26,110,245,.08)!important;color:var(--accent3)!important;border-color:var(--border2)!important;box-shadow:none!important;}
.nav-install:hover{color:var(--white)!important;background:rgba(26,110,245,.18)!important;}
.nav-hamburger{display:none;flex-direction:column;justify-content:center;gap:5px;width:38px;height:38px;padding:8px;background:var(--card);border:1px solid var(--border);border-radius:9px;cursor:pointer;z-index:910;}
.nav-hamburger span{display:block;height:2px;border-radius:2px;background:var(--text2);transition:all .3s;}
.nav-hamburger.open span:nth-child(1){transform:translateY(7px) rotate(45deg);}
.nav-hamburger.open span:nth-child(2){opacity:0;transform:scaleX(0);}
.nav-hamburger.open span:nth-child(3){transform:translateY(-7px) rotate(-45deg);}
.nav-drawer{display:none;position:fixed;top:68px;left:0;right:0;bottom:0;height:calc(100dvh - 68px);background:rgba(1,7,20,.97);backdrop-filter:blur(20px);z-index:899;flex-direction:column;align-items:stretch;justify-content:flex-start;gap:8px;transform:translateY(-100%);transition:transform .38s cubic-bezier(.4,0,.2,1);padding:18px 16px 28px;border-top:1px solid var(--border);overflow-y:auto;}
.nav-drawer.open{transform:translateY(0);}
.nav-drawer a{color:var(--text);font-size:15px;font-weight:600;font-family:'Orbitron',monospace;letter-spacing:2px;padding:12px 16px;border-radius:12px;width:100%;text-align:left;}
.nav-drawer a:hover,.nav-drawer a.act{color:var(--white);background:var(--card);border-color:var(--border2);}
.nav-drawer .m-cta{margin-top:12px;background:linear-gradient(135deg,var(--accent),#0c49c7);color:#fff!important;border-color:var(--accent)!important;box-shadow:0 0 22px rgba(26,110,245,.4);}
.mobile-bottom-nav{display:none;position:fixed;top:auto;left:0;right:0;bottom:0;height:auto;padding:10px 12px calc(10px + env(safe-area-inset-bottom));z-index:905;grid-template-columns:repeat(5,minmax(0,1fr));gap:8px;background:rgba(4,14,34,.96);backdrop-filter:blur(18px) saturate(1.25);border-top:1px solid var(--border2);border-left:none;border-right:none;border-bottom:none;border-radius:20px 20px 0 0;box-shadow:0 -10px 34px rgba(0,0,0,.38);transition:opacity .22s,transform .22s;}
.mobile-bottom-link,.mobile-bottom-btn{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;min-height:56px;padding:8px 6px;border-radius:16px;color:var(--text2);font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;text-align:center;border:1px solid transparent;background:transparent;transition:all .22s;}
.mobile-bottom-link strong,.mobile-bottom-btn strong{font-size:15px;line-height:1;}
.mobile-bottom-link.act,.mobile-bottom-link:hover,.mobile-bottom-btn:hover,.mobile-bottom-btn.act{color:var(--white);background:rgba(26,110,245,.14);border-color:var(--border2);box-shadow:inset 0 1px 0 rgba(255,255,255,.05);}
.mobile-bottom-btn{cursor:pointer;}
body.menu-open{overflow:hidden;}
body.menu-open .mobile-bottom-nav{opacity:0;pointer-events:none;transform:translateY(18px);}
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
.form-shell{max-width:880px;margin:0 auto;padding:32px;}
.form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(220px,100%),1fr));gap:16px;}
.form-field label{display:block;margin-bottom:8px;color:var(--white);font-weight:700;}
.check-row{display:flex;align-items:center;gap:10px;color:var(--text2);font-weight:600;}
.form-actions{justify-content:flex-start;}
.fc,.sc,.mc,.rc,.gi,.evc,.lbc{border:1px solid var(--border);transition:all .32s;}
.fc,.rc,.evc,.lbc,.ann{background:linear-gradient(145deg,rgba(10,26,55,.94),rgba(7,16,38,.98));}
.fc,.sc,.mc{border-radius:var(--r-lg);}
.fc{position:relative;overflow:hidden;padding:32px 26px;}
.fc:hover,.sc:hover,.mc:hover,.rc:hover,.evc:hover,.lbc:hover{border-color:var(--border2);transform:translateY(-6px);box-shadow:0 18px 44px rgba(0,0,0,.45);}
.fc-icon{width:58px;height:58px;border-radius:15px;margin-bottom:20px;display:flex;align-items:center;justify-content:center;background:rgba(26,110,245,.1);border:1px solid rgba(61,142,255,.25);font-size:26px;}
.fc-name,.sc-name,.mc-name,.ev-name,.lb-name,.rc-title,.ann-title{font-family:'Rajdhani',sans-serif;font-weight:700;color:var(--white);}
.fc-name{font-size:19px;margin-bottom:10px;}
.fc-name,.mc-name,.ev-name,.lb-name,.rc-title,.ann-title,.gi-name{overflow-wrap:anywhere;}
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
.sc-pr{display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;gap:10px;flex-wrap:wrap;}
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
@media(max-width:900px){nav{padding:0 18px;}.nav-links,.nav-auth{display:none;position:static;transform:none;}.nav-hamburger{display:flex;}.nav-drawer{display:flex;}.page-hero{min-height:44svh;padding-block:112px 52px;}.sw{padding:48px 18px 72px;}.gal-grid{grid-template-columns:repeat(2,1fr);grid-auto-rows:160px;}.gi.s2{grid-column:span 1;}.fc{padding:26px 22px 52px;}.fc-arr{bottom:18px;right:18px;}.fi{grid-template-columns:1fr 1fr;}.form-shell{padding:28px 24px;}}
@media(max-width:640px){body{padding-bottom:100px;}nav{padding:0 14px;height:62px;}.nav-logo-mark{height:40px;max-width:min(180px,52vw);}.nav-drawer{top:62px;height:calc(100dvh - 62px);padding:16px 14px calc(112px + env(safe-area-inset-bottom));justify-content:flex-start;overflow-y:auto;align-items:stretch;}.nav-drawer a{font-size:13px;letter-spacing:1.4px;padding:11px 14px;}.mobile-bottom-nav{display:grid;}.hero{min-height:auto;padding-block:92px 40px;}.page-hero{min-height:auto;padding-block:82px 24px;}.hero-badge,.page-kicker{padding:7px 16px;font-size:9px;letter-spacing:1.8px;margin-bottom:20px;max-width:100%;text-align:center;line-height:1.5;flex-wrap:wrap;justify-content:center;}.hero-title{font-size:clamp(28px,11vw,48px);line-height:1.02;letter-spacing:1px;}.hero-title .ol{-webkit-text-stroke:1.2px var(--accent2);}.page-title{font-size:clamp(22px,7vw,32px);line-height:1.08;overflow-wrap:anywhere;}.hero-sub,.page-copy{font-size:12.5px;line-height:1.62;margin:12px auto 22px;max-width:94%;}.hero-btns,.page-actions{gap:10px;}.btn{padding:12px 18px;font-size:11px;letter-spacing:1px;}.hero-stats{gap:12px;flex-wrap:wrap;width:100%;max-width:none;margin-top:34px;padding:0;}.h-stat{flex:0 0 calc(50% - 6px);padding:0 4px;}.h-stat-n{font-size:clamp(22px,7vw,30px);}.h-stat-l{font-size:10px;letter-spacing:1.8px;margin-top:8px;}.h-div{display:none;}.sw{padding:32px 16px 52px;}.sh{margin-bottom:28px;}.stag{font-size:9px;letter-spacing:2px;}.stitle{font-size:clamp(18px,7vw,26px);letter-spacing:.8px;}.sdesc{font-size:13px;max-width:100%;}.gal-grid{grid-template-columns:1fr 1fr;grid-auto-rows:130px;}.gi.tall{grid-row:span 1;}.shop-grid{grid-template-columns:1fr;gap:14px;}.mem-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;}.fc{padding:22px 18px 48px;}.fc-icon{width:48px;height:48px;font-size:22px;margin-bottom:16px;}.fc-name{font-size:17px;}.fc-desc,.rc-desc,.ev-desc,.ann-text,.mc-meta{font-size:13px;}.mc{padding:22px 14px 18px;}.mc-avw{width:58px;height:58px;}.mc-av,.mc-av-img{width:58px;height:58px;}.evc{flex-wrap:wrap;align-items:flex-start;gap:12px;padding:18px 16px;}.ev-date{min-width:52px;padding:8px 10px;}.ev-day{font-size:20px;}.evb{width:100%;text-align:center;justify-content:center;}.lb-bar-w{display:none;}.lbc{flex-wrap:wrap;align-items:center;gap:12px;padding:14px 16px;}.lb-rank{min-width:30px;font-size:18px;}.lb-av{font-size:24px;}.lb-inf{flex:1 1 calc(100% - 58px);}.lb-pts{width:100%;text-align:left;padding-left:46px;}.form-shell{padding:22px 18px;}.form-grid{grid-template-columns:1fr;gap:14px;}.check-row{align-items:flex-start;}.check-row input{margin-top:3px;}.form-actions{justify-content:stretch;}.form-actions .btn{width:100%;justify-content:center;}.fi{grid-template-columns:1fr;gap:24px;}.ftag{max-width:100%;}.toast{display:none !important;}}
@media(max-width:420px){.feat-grid,.shop-grid,.mem-grid,.gal-grid{grid-template-columns:repeat(2,minmax(0,1fr));}.feat-grid{gap:12px;}.fc{padding:18px 14px 42px;border-radius:16px;}.fc-icon{width:42px;height:42px;font-size:18px;margin-bottom:12px;border-radius:12px;}.fc-name{font-size:15px;margin-bottom:8px;}.fc-desc{font-size:12px;line-height:1.6;}.fc-arr{bottom:14px;right:14px;font-size:14px;}.hero-btns,.page-actions,.form-actions{flex-direction:column;align-items:center;}.hero-btns .btn,.page-actions .btn,.form-actions .btn{width:100%;max-width:none;justify-content:center;}.mbtns{flex-direction:column;}.lb-pts{padding-left:0;}}
</style>
</head>
<body>
<canvas id="starCanvas"></canvas>
<div class="toast" id="toast"><span id="tIcon">✅</span><span id="tMsg">Ok!</span></div>

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
    <li><a href="{{ $discordAuthUser ? route('chat') : route('auth.discord.redirect') }}" class="{{ request()->routeIs('chat') ? 'act' : '' }}">💬 Chat</a></li>
    <li><a href="{{ route('leaderboard') }}" class="{{ request()->routeIs('leaderboard') ? 'act' : '' }}">🏆 Rank</a></li>
  </ul>
  <div class="nav-auth">
    <button type="button" class="nav-cta nav-install" data-install-app hidden>＋ Install App</button>
    @if($discordAuthUser)
      <span class="nav-auth-name">{{ \Illuminate\Support\Str::limit($discordAuthUser['name'], 18) }}</span>
      <a href="{{ ($discordAuthUser['is_core_member'] ?? false) ? route('dashboard') : route('home') }}" class="nav-auth-link {{ request()->routeIs('dashboard*') ? 'act' : '' }}">
        {{ ($discordAuthUser['is_core_member'] ?? false) ? '🧭 Dashboard' : '🏠 Home' }}
      </a>
      <a href="{{ route('auth.discord.logout') }}" class="nav-cta">Logout</a>
    @else
      <a href="{{ route('auth.discord.redirect') }}" class="nav-cta">Login</a>
    @endif
  </div>
  <button class="nav-hamburger" id="hbg" onclick="toggleMenu()"><span></span><span></span><span></span></button>
</nav>
<nav class="nav-drawer" id="nDrawer">
  <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'act' : '' }}" onclick="closeMenu()">🏠 Home</a>
  <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'act' : '' }}" onclick="closeMenu()">🖼️ Gallery</a>
  <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'act' : '' }}" onclick="closeMenu()">🛒 Shop</a>
  <a href="{{ route('members') }}" class="{{ request()->routeIs('members') ? 'act' : '' }}" onclick="closeMenu()">👥 Members</a>
  <a href="{{ route('events') }}" class="{{ request()->routeIs('events') ? 'act' : '' }}" onclick="closeMenu()">🎉 Events</a>
  <a href="{{ $discordAuthUser ? route('chat') : route('auth.discord.redirect') }}" class="{{ request()->routeIs('chat') ? 'act' : '' }}" onclick="closeMenu()">💬 Chat</a>
  <a href="{{ route('leaderboard') }}" class="{{ request()->routeIs('leaderboard') ? 'act' : '' }}" onclick="closeMenu()">🏆 Ranking</a>
  @if($discordAuthUser && ($discordAuthUser['is_core_member'] ?? false))
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard*') ? 'act' : '' }}" onclick="closeMenu()">🧭 Dashboard</a>
  @endif
  <button type="button" class="m-cta nav-install" data-install-app hidden>＋ Install App</button>
  @if($discordAuthUser)
    <a href="{{ route('auth.discord.logout') }}" class="m-cta" onclick="closeMenu()">🔓 Logout</a>
  @else
    <a href="{{ route('auth.discord.redirect') }}" class="m-cta" onclick="closeMenu()">🔐 Login Discord</a>
  @endif
</nav>
<nav class="mobile-bottom-nav" aria-label="Navigasi Mobile">
  <a href="{{ route('home') }}" class="mobile-bottom-link {{ request()->routeIs('home') ? 'act' : '' }}">
    <strong>🏠</strong>
    <span>Home</span>
  </a>
  <a href="{{ route('gallery') }}" class="mobile-bottom-link {{ request()->routeIs('gallery') ? 'act' : '' }}">
    <strong>🖼️</strong>
    <span>Gallery</span>
  </a>
  <a href="{{ route('shop') }}" class="mobile-bottom-link {{ request()->routeIs('shop') ? 'act' : '' }}">
    <strong>🛒</strong>
    <span>Shop</span>
  </a>
  <a href="{{ route('members') }}" class="mobile-bottom-link {{ request()->routeIs('members') ? 'act' : '' }}">
    <strong>👥</strong>
    <span>Members</span>
  </a>
  <a href="{{ $discordAuthUser ? route('chat') : route('auth.discord.redirect') }}" class="mobile-bottom-link {{ request()->routeIs('chat') ? 'act' : '' }}">
    <strong>💬</strong>
    <span>Chat</span>
  </a>
</nav>

@yield('content')

<div class="divl"></div>

<footer>
  <div class="fi">
    <div><div class="flr"><div class="fli">🎮</div><div class="fln">LYVA</div></div><div class="ftag">Komunitas Roblox Indonesia yang berfokus pada kolaborasi, aktivitas komunitas, dan pengalaman bermain yang lebih terorganisir.</div><div class="fsoc"><div class="fsb">💬</div><div class="fsb">📺</div><div class="fsb">🎵</div><div class="fsb">📸</div><div class="fsb">🐦</div></div></div>
    <div><div class="fch">Navigasi</div><ul class="flinks"><li><a href="{{ route('home') }}">Home</a></li><li><a href="{{ route('gallery') }}">Gallery</a></li><li><a href="{{ route('shop') }}">Shop</a></li><li><a href="{{ route('events') }}">Events</a></li><li><a href="{{ route('leaderboard') }}">Ranking</a></li></ul></div>
    <div><div class="fch">Komunitas</div><ul class="flinks"><li><a href="{{ route('members') }}">Tim Inti</a></li><li><a href="{{ route('events') }}">Agenda Event</a></li><li><a href="{{ route('gallery') }}">Dokumentasi</a></li><li><a href="{{ $discordAuthUser ? route('auth.discord.logout') : route('auth.discord.redirect') }}">{{ $discordAuthUser ? 'Keluar' : 'Login Discord' }}</a></li></ul></div>
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
function toggleMenu(){const hb=document.getElementById('hbg');const drawer=document.getElementById('nDrawer');hb.classList.toggle('open');drawer.classList.toggle('open');document.body.classList.toggle('menu-open',drawer.classList.contains('open'));}
function closeMenu(){document.getElementById('hbg').classList.remove('open');document.getElementById('nDrawer').classList.remove('open');document.body.classList.remove('menu-open');}
let tt;function toast(msg){clearTimeout(tt);document.getElementById('tMsg').textContent=msg;const t=document.getElementById('toast');t.classList.add('show');tt=setTimeout(()=>t.classList.remove('show'),3400);}
function addCart(name){toast('🛒 '+name+' ditambahkan ke keranjang!');}
</script>
<script src="{{ asset('pwa-register.js') }}" defer></script>
@if (session('toast'))
<script>window.addEventListener('load',()=>toast(@json(session('toast'))));</script>
@endif
</body>
</html>
