<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LYVACOMMUNITY | DASHBOARD</title>
<meta name="theme-color" content="#010714">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="LYVA Community">
<meta name="mobile-web-app-capable" content="yes">
<link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon-180.png') }}">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;700;900&family=Rajdhani:wght@400;500;600;700&family=Exo+2:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{
  --bg0:#010714;--bg1:#030d1f;--bg2:#061428;--side:#040e22;
  --card:#091833;--card2:#0c1f3d;--card3:#0f2548;
  --border:rgba(30,80,160,.3);--border2:rgba(50,120,220,.5);--border3:rgba(80,150,255,.7);
  --accent:#1a6ef5;--accent2:#3d8eff;--accent3:#6ab0ff;
  --glow:rgba(26,110,245,.4);
  --gold:#f5c842;--teal:#00e5b8;--pink:#ff4fa3;--purple:#a855f7;
  --red:#ff4444;--green:#22c55e;--orange:#ff8c42;
  --text:#cce0ff;--text2:#7aa5d8;--text3:#3d6a9e;--white:#fff;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
body{background:var(--bg0);color:var(--text);font-family:'Exo 2',sans-serif;overflow-x:hidden;line-height:1.6;font-size:14px;}
a{text-decoration:none;color:inherit;}
button{font-family:inherit;cursor:pointer;border:none;background:none;color:inherit;}
input,select,textarea{font-family:inherit;}
::-webkit-scrollbar{width:6px;height:6px;}
::-webkit-scrollbar-track{background:var(--bg0);}
::-webkit-scrollbar-thumb{background:var(--border2);border-radius:3px;}

/* STARS BG */
#starBg{position:fixed;inset:0;z-index:0;pointer-events:none;opacity:.4;}

/* ══════════════ LAYOUT ══════════════ */
.app{display:flex;min-height:100vh;position:relative;z-index:1;}

/* ══════════════ SIDEBAR ══════════════ */
.sb{
  position:fixed;top:0;left:0;bottom:0;width:260px;
  background:linear-gradient(180deg,var(--side) 0%,var(--bg1) 100%);
  border-right:1px solid var(--border);z-index:500;
  display:flex;flex-direction:column;overflow-y:auto;
  transition:transform .35s cubic-bezier(.4,0,.2,1);
  touch-action:pan-y;
}
.sb-head{padding:22px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px;flex-shrink:0;}
.sb-logo{width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,rgba(38,120,255,.2),rgba(106,176,255,.12));border:1px solid rgba(106,176,255,.28);display:flex;align-items:center;justify-content:center;box-shadow:0 0 18px var(--glow);flex-shrink:0;overflow:hidden;padding:6px;}
.sb-logo-img{width:100%;height:100%;object-fit:contain;display:block;filter:drop-shadow(0 0 10px rgba(61,142,255,.3));}
.sb-brand{flex:1;min-width:0;}
.sb-name{font-family:'Orbitron',monospace;font-size:17px;font-weight:900;color:var(--white);letter-spacing:3px;text-shadow:0 0 12px var(--accent);}
.sb-sub{font-size:9.5px;color:var(--accent3);letter-spacing:2px;margin-top:-2px;text-transform:uppercase;}
.sb-nav{padding:16px 12px;flex:1;}
.sb-sec{font-size:10px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--text3);padding:14px 12px 8px;}
.sb-item{
  display:flex;align-items:center;gap:12px;padding:11px 14px;
  border-radius:10px;color:var(--text2);font-size:13.5px;font-weight:600;
  cursor:pointer;transition:all .22s;margin-bottom:3px;position:relative;
}
.sb-item:hover{background:rgba(26,110,245,.08);color:var(--text);}
.sb-item.active{
  background:linear-gradient(90deg,rgba(26,110,245,.22),rgba(26,110,245,.05));
  color:var(--white);
  box-shadow:inset 2px 0 0 var(--accent),0 0 20px rgba(26,110,245,.1);
}
.sb-item.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3px;height:60%;background:var(--accent2);border-radius:0 3px 3px 0;box-shadow:0 0 12px var(--accent);}
.sb-ic{font-size:17px;flex-shrink:0;width:22px;text-align:center;}
.sb-lbl{flex:1;}
.sb-bd{font-size:10px;font-weight:800;padding:2px 7px;border-radius:50px;letter-spacing:.5px;}
.bd-new{background:var(--green);color:#012;}
.bd-n{background:var(--pink);color:#fff;}
.bd-live{background:var(--red);color:#fff;animation:bdLive 1.5s infinite;}
@keyframes bdLive{0%,100%{box-shadow:0 0 0 0 rgba(255,68,68,.5);}50%{box-shadow:0 0 0 5px rgba(255,68,68,0);}}
.sb-foot{padding:14px 16px;border-top:1px solid var(--border);flex-shrink:0;}
.sb-user{display:flex;align-items:center;gap:10px;padding:10px;border-radius:11px;background:rgba(26,110,245,.08);border:1px solid var(--border);cursor:pointer;transition:background .2s;}
.sb-user:hover{background:rgba(26,110,245,.14);}
.sb-av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#f5c842,#ff8c42);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;position:relative;}
.sb-av-img{width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;}
.sb-av::after{content:'';position:absolute;bottom:-1px;right:-1px;width:10px;height:10px;border-radius:50%;background:var(--green);border:2px solid var(--side);}
.sb-uinf{flex:1;min-width:0;}
.sb-un{font-size:13px;font-weight:700;color:var(--white);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.sb-ur{font-size:10.5px;color:var(--gold);letter-spacing:1px;text-transform:uppercase;}

/* ══════════════ MAIN ══════════════ */
.main{flex:1;margin-left:260px;min-width:0;transition:margin-left .35s;}

/* TOPBAR */
.tb{
  position:sticky;top:0;z-index:200;height:66px;
  background:rgba(1,7,20,.85);backdrop-filter:blur(22px) saturate(1.4);
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;gap:16px;padding:0 clamp(16px,3vw,28px);
}
.tb-burger{display:none;width:40px;height:40px;background:var(--card);border:1px solid var(--border);border-radius:10px;align-items:center;justify-content:center;font-size:18px;color:var(--text2);}
.tb-burger:hover{background:var(--card2);color:var(--white);}
.tb-title{flex-shrink:0;}
.tb-t{font-family:'Orbitron',monospace;font-size:17px;font-weight:700;color:var(--white);letter-spacing:1.5px;}
.tb-sub{font-size:11px;color:var(--text3);letter-spacing:1px;margin-top:-2px;}
.tb-search{
  flex:1;max-width:420px;position:relative;
}
.tb-search input{
  width:100%;background:rgba(6,20,46,.8);border:1px solid var(--border);
  border-radius:11px;padding:10px 14px 10px 42px;color:var(--text);
  font-size:13px;outline:none;transition:all .25s;
}
.tb-search input:focus{border-color:var(--accent2);box-shadow:0 0 0 3px rgba(26,110,245,.1);}
.tb-search input::placeholder{color:var(--text3);}
.tb-si{position:absolute;top:50%;left:14px;transform:translateY(-50%);font-size:15px;color:var(--text3);}
.tb-sk{position:absolute;top:50%;right:10px;transform:translateY(-50%);font-size:10px;color:var(--text3);background:var(--card);padding:3px 7px;border-radius:5px;border:1px solid var(--border);letter-spacing:.5px;}
.tb-acts{display:flex;align-items:center;gap:8px;margin-left:auto;}
.tb-btn{width:40px;height:40px;border-radius:10px;background:var(--card);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:16px;color:var(--text2);transition:all .22s;position:relative;}
.tb-btn:hover{background:var(--card2);border-color:var(--border2);color:var(--white);transform:translateY(-1px);}
.tb-install{width:auto;padding:0 14px;gap:7px;font-size:12px;font-weight:800;letter-spacing:.8px;text-transform:uppercase;color:var(--accent3);}
.tb-ndot{position:absolute;top:7px;right:7px;width:8px;height:8px;background:var(--red);border-radius:50%;border:2px solid var(--card);animation:bdLive 2s infinite;}

/* ══════════════ CONTENT ══════════════ */
.ct{padding:clamp(18px,3vw,28px);max-width:1600px;margin:0 auto;}

/* PAGE HEAD */
.ph{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:24px;flex-wrap:wrap;}
.ph-l{}
.ph-t{font-family:'Orbitron',monospace;font-size:clamp(20px,2.5vw,26px);font-weight:700;color:var(--white);letter-spacing:1.5px;text-shadow:0 0 15px rgba(26,110,245,.4);margin-bottom:4px;}
.ph-s{font-size:13px;color:var(--text2);}
.ph-r{display:flex;gap:10px;flex-wrap:wrap;}
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 18px;border-radius:10px;font-family:'Exo 2',sans-serif;font-weight:700;font-size:12.5px;letter-spacing:.8px;text-transform:uppercase;transition:all .25s;white-space:nowrap;border:1px solid transparent;}
.btn-p{background:linear-gradient(135deg,var(--accent),#0c49c7);color:#fff;box-shadow:0 0 18px rgba(26,110,245,.35);}
.btn-p:hover{transform:translateY(-2px);box-shadow:0 0 28px rgba(26,110,245,.55);}
.btn-g{background:var(--card);color:var(--text2);border-color:var(--border);}
.btn-g:hover{background:var(--card2);color:var(--white);border-color:var(--border2);}
.btn-sm{padding:7px 13px;font-size:11px;}

/* STAT CARDS */
.stat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(240px,100%),1fr));gap:14px;margin-bottom:24px;}
.st{
  position:relative;overflow:hidden;
  background:linear-gradient(145deg,rgba(12,28,58,.95),rgba(7,18,40,.98));
  border:1px solid var(--border);border-radius:16px;padding:20px 22px;
  transition:all .3s;
}
.st:hover{border-color:var(--border2);transform:translateY(-3px);box-shadow:0 12px 36px rgba(0,0,0,.4),0 0 20px rgba(26,110,245,.15);}
.st::after{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--accent2),transparent);opacity:.7;}
.st.sg::after{background:linear-gradient(90deg,transparent,var(--gold),transparent);}
.st.spk::after{background:linear-gradient(90deg,transparent,var(--pink),transparent);}
.st.st-e::after{background:linear-gradient(90deg,transparent,var(--teal),transparent);}
.st-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;}
.st-ic{width:42px;height:42px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:20px;}
.ic-b{background:rgba(26,110,245,.15);border:1px solid rgba(61,142,255,.3);}
.ic-g{background:rgba(245,200,66,.13);border:1px solid rgba(245,200,66,.28);}
.ic-p{background:rgba(255,79,163,.12);border:1px solid rgba(255,79,163,.28);}
.ic-t{background:rgba(0,229,184,.12);border:1px solid rgba(0,229,184,.28);}
.st-tr{font-size:11px;font-weight:700;letter-spacing:.5px;padding:3px 8px;border-radius:50px;}
.tr-up{background:rgba(34,197,94,.13);color:var(--green);border:1px solid rgba(34,197,94,.28);}
.tr-dn{background:rgba(255,68,68,.13);color:var(--red);border:1px solid rgba(255,68,68,.28);}
.st-v{font-family:'Orbitron',monospace;font-size:28px;font-weight:900;color:var(--white);line-height:1;margin-bottom:6px;text-shadow:0 0 14px rgba(26,110,245,.25);}
.st-l{font-size:12px;color:var(--text3);letter-spacing:1.5px;text-transform:uppercase;font-weight:600;}
.st-spark{margin-top:12px;display:flex;align-items:flex-end;gap:3px;height:28px;}
.spk{flex:1;background:linear-gradient(to top,var(--accent),var(--accent3));border-radius:2px;opacity:.8;transition:all .3s;}
.st:hover .spk{opacity:1;}
.sg .spk{background:linear-gradient(to top,#c99500,var(--gold2,#ffd966));}
.spk .spk{background:linear-gradient(to top,#c72863,var(--pink));}
.st-e .spk{background:linear-gradient(to top,#008a6e,var(--teal));}

/* TWO COL LAYOUT */
.two-col{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:24px;}

/* PANEL */
.pn{
  background:linear-gradient(145deg,rgba(10,27,56,.95),rgba(7,18,40,.97));
  border:1px solid var(--border);border-radius:16px;
  overflow:hidden;
}
.pn-h{display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--border);gap:10px;flex-wrap:wrap;}
.pn-t{font-family:'Rajdhani',sans-serif;font-size:17px;font-weight:700;color:var(--white);letter-spacing:.5px;display:flex;align-items:center;gap:8px;}
.pn-tsub{font-size:11px;color:var(--text3);margin-top:2px;}
.pn-acts{display:flex;gap:6px;align-items:center;}
.pn-tab{padding:6px 12px;border-radius:7px;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.8px;text-transform:uppercase;cursor:pointer;transition:all .22s;}
.pn-tab:hover{background:rgba(26,110,245,.08);color:var(--text2);}
.pn-tab.on{background:rgba(26,110,245,.15);color:var(--accent3);border:1px solid rgba(61,142,255,.35);}
.pn-b{padding:22px;}

/* CHART */
.chart-wrap{position:relative;height:280px;padding:10px 0;}
.chart-svg{width:100%;height:100%;overflow:visible;}

/* ACTIVITY FEED */
.act-list{display:flex;flex-direction:column;gap:12px;max-height:360px;overflow-y:auto;padding-right:4px;}
.act{display:flex;align-items:flex-start;gap:12px;padding:12px;border-radius:11px;background:rgba(6,20,46,.4);border:1px solid transparent;transition:all .22s;cursor:pointer;}
.act:hover{background:rgba(26,110,245,.08);border-color:var(--border);}
.act-ic{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.act-b{flex:1;min-width:0;}
.act-t{font-size:13px;color:var(--text);line-height:1.5;}
.act-t b{color:var(--white);font-weight:700;}
.act-t .hl{color:var(--accent3);}
.act-tm{font-size:10.5px;color:var(--text3);margin-top:3px;letter-spacing:.5px;}

/* TABLE */
.tbl-wrap{overflow-x:auto;}
.tbl{width:100%;border-collapse:collapse;font-size:13px;min-width:600px;}
.tbl th{
  text-align:left;padding:12px 14px;font-size:10.5px;font-weight:700;
  letter-spacing:1.5px;text-transform:uppercase;color:var(--text3);
  border-bottom:1px solid var(--border);
}
.tbl td{padding:13px 14px;border-bottom:1px solid rgba(30,80,160,.15);color:var(--text);vertical-align:middle;}
.tbl tr:hover td{background:rgba(26,110,245,.04);}
.tbl tr:last-child td{border-bottom:none;}
.u-cell{display:flex;align-items:center;gap:10px;}
.u-av{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:15px;border:1.5px solid var(--border2);flex-shrink:0;position:relative;}
.u-av-img{width:100%;height:100%;object-fit:cover;border-radius:50%;}
.u-on{position:absolute;bottom:-1px;right:-1px;width:10px;height:10px;border-radius:50%;background:var(--green);border:2px solid var(--card);}
.u-off{background:#666;}
.u-info{min-width:0;}
.u-n{color:var(--white);font-weight:700;font-size:13.5px;white-space:nowrap;}
.u-id{color:var(--text3);font-size:11px;}
.chip{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:50px;font-size:10.5px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;white-space:nowrap;}
.c-own{background:rgba(245,200,66,.14);color:var(--gold);border:1px solid rgba(245,200,66,.3);}
.c-adm{background:rgba(255,79,163,.12);color:var(--pink);border:1px solid rgba(255,79,163,.28);}
.c-mod{background:rgba(26,110,245,.12);color:var(--accent3);border:1px solid rgba(61,142,255,.3);}
.c-mem{background:rgba(0,229,184,.1);color:var(--teal);border:1px solid rgba(0,229,184,.25);}
.c-pro{background:rgba(168,85,247,.12);color:#c084fc;border:1px solid rgba(168,85,247,.3);}
.st-chip{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:600;}
.st-chip::before{content:'';width:7px;height:7px;border-radius:50%;}
.s-on::before{background:var(--green);box-shadow:0 0 8px var(--green);}
.s-ban::before{background:var(--red);}
.s-pend::before{background:var(--gold);}
.s-on{color:var(--green);}
.s-ban{color:var(--red);}
.s-pend{color:var(--gold);}
.tb-acts-row{display:flex;gap:4px;}
.ta-btn{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:13px;background:var(--card);border:1px solid var(--border);color:var(--text2);transition:all .2s;}
.ta-btn:hover{background:var(--card2);border-color:var(--border2);color:var(--white);}
.ta-btn.dang:hover{background:rgba(255,68,68,.15);border-color:rgba(255,68,68,.4);color:var(--red);}

/* QUICK ACTIONS */
.qa-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;}
.qa{
  padding:18px 14px;text-align:center;border-radius:13px;
  background:linear-gradient(145deg,rgba(10,27,56,.9),rgba(7,18,40,.95));
  border:1px solid var(--border);transition:all .3s;cursor:pointer;
}
.qa:hover{transform:translateY(-4px);border-color:var(--border2);box-shadow:0 10px 28px rgba(0,0,0,.4),0 0 18px rgba(26,110,245,.15);}
.qa-ic{width:50px;height:50px;margin:0 auto 10px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;transition:transform .3s;}
.qa:hover .qa-ic{transform:scale(1.1) rotate(-5deg);}
.qa-t{font-size:13px;font-weight:700;color:var(--white);font-family:'Rajdhani',sans-serif;margin-bottom:3px;}
.qa-d{font-size:10.5px;color:var(--text3);letter-spacing:.5px;}

/* PROGRESS BAR */
.prg{height:7px;background:rgba(26,110,245,.08);border-radius:4px;overflow:hidden;}
.prg-b{height:100%;border-radius:4px;background:linear-gradient(90deg,var(--accent),var(--accent3));transition:width .6s;}

/* GOALS */
.goal-list{display:flex;flex-direction:column;gap:14px;}
.goal{padding:14px;border-radius:12px;background:rgba(6,20,46,.5);border:1px solid var(--border);transition:all .22s;}
.goal:hover{border-color:var(--border2);}
.goal-h{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;gap:8px;}
.goal-t{font-size:13px;font-weight:600;color:var(--white);display:flex;align-items:center;gap:8px;}
.goal-p{font-family:'Orbitron',monospace;font-size:12px;font-weight:700;color:var(--accent3);}
.goal-sub{font-size:11px;color:var(--text3);margin-top:6px;display:flex;justify-content:space-between;}

/* NOTIFICATIONS PANEL */
.ntf-panel{position:fixed;top:66px;right:20px;width:min(380px,calc(100vw - 40px));max-height:calc(100vh - 90px);background:linear-gradient(160deg,rgba(10,28,58,.99),rgba(7,16,38,1));border:1px solid var(--border2);border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.6),0 0 0 1px rgba(61,142,255,.1);z-index:600;overflow:hidden;display:flex;flex-direction:column;opacity:0;pointer-events:none;transform:translateY(-10px) scale(.98);transition:all .25s;}
.ntf-panel.open{opacity:1;pointer-events:all;transform:translateY(0) scale(1);}
.ntf-h{padding:18px 20px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;}
.ntf-t{font-family:'Rajdhani',sans-serif;font-size:16px;font-weight:700;color:var(--white);}
.ntf-c{background:var(--accent);color:#fff;font-size:10px;padding:2px 7px;border-radius:50px;font-weight:800;margin-left:6px;}
.ntf-b{overflow-y:auto;max-height:460px;}
.ntf-i{padding:14px 20px;border-bottom:1px solid rgba(30,80,160,.15);display:flex;gap:12px;cursor:pointer;transition:background .2s;}
.ntf-i:hover{background:rgba(26,110,245,.06);}
.ntf-i.unread{background:rgba(26,110,245,.05);}
.ntf-i.unread::before{content:'';width:6px;height:6px;border-radius:50%;background:var(--accent);flex-shrink:0;margin-top:7px;box-shadow:0 0 8px var(--accent);}
.ntf-ic{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.ntf-info{flex:1;min-width:0;}
.ntf-nt{font-size:13px;color:var(--text);line-height:1.45;}
.ntf-nt b{color:var(--white);}
.ntf-nm{font-size:10.5px;color:var(--text3);margin-top:4px;}
.ntf-f{padding:12px 20px;border-top:1px solid var(--border);text-align:center;}
.ntf-f a{font-size:12px;color:var(--accent3);font-weight:600;letter-spacing:.5px;}

/* CALENDAR */
.cal{background:rgba(6,20,46,.5);border:1px solid var(--border);border-radius:12px;padding:14px;}
.cal-h{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
.cal-m{font-family:'Rajdhani',sans-serif;font-size:15px;font-weight:700;color:var(--white);}
.cal-nav{display:flex;gap:4px;}
.cal-nav button{width:26px;height:26px;border-radius:7px;background:var(--card);border:1px solid var(--border);font-size:12px;color:var(--text2);transition:all .2s;}
.cal-nav button:hover{background:var(--card2);color:var(--white);}
.cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:3px;}
.cal-d{aspect-ratio:1;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:var(--text2);border-radius:6px;cursor:pointer;transition:background .2s;position:relative;}
.cal-d:hover{background:rgba(26,110,245,.1);}
.cal-d.head{color:var(--text3);font-size:10px;pointer-events:none;letter-spacing:1px;text-transform:uppercase;}
.cal-d.today{background:var(--accent);color:#fff;box-shadow:0 0 12px var(--glow);}
.cal-d.ev::after{content:'';position:absolute;bottom:3px;left:50%;transform:translateX(-50%);width:4px;height:4px;border-radius:50%;background:var(--gold);}
.cal-d.muted{color:var(--text3);opacity:.4;}

/* PRODUCT GRID */
.pg{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;}
.prod{background:linear-gradient(160deg,rgba(10,27,56,.98),rgba(6,16,34,1));border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:all .3s;}
.prod:hover{transform:translateY(-5px);border-color:var(--border2);box-shadow:0 14px 36px rgba(0,0,0,.5),0 0 0 1px rgba(61,142,255,.1);}
.prod-img{aspect-ratio:1;display:flex;align-items:center;justify-content:center;font-size:52px;position:relative;}
.prod-bd{position:absolute;top:10px;right:10px;font-size:9px;font-weight:800;letter-spacing:1px;padding:3px 8px;border-radius:50px;text-transform:uppercase;}
.bd-hot{background:rgba(255,107,53,.2);color:#ff6b35;border:1px solid rgba(255,107,53,.4);}
.bd-nw{background:rgba(0,229,184,.15);color:var(--teal);border:1px solid rgba(0,229,184,.35);}
.bd-rr{background:rgba(245,200,66,.15);color:var(--gold);border:1px solid rgba(245,200,66,.35);}
.prod-inf{padding:14px;}
.prod-n{font-family:'Rajdhani',sans-serif;font-size:14.5px;font-weight:700;color:var(--white);margin-bottom:6px;}
.prod-r{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
.prod-p{font-family:'Orbitron',monospace;font-size:13px;font-weight:700;color:var(--gold);}
.prod-sold{font-size:10.5px;color:var(--text3);}
.prod-acts{display:flex;gap:5px;}
.prod-acts .ta-btn{flex:1;width:auto;height:30px;font-size:11px;gap:4px;}

/* DONUT CHART SIDE */
.donut-wrap{display:flex;align-items:center;gap:20px;flex-wrap:wrap;}
.donut{position:relative;width:150px;height:150px;flex-shrink:0;}
.donut-cn{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;}
.donut-v{font-family:'Orbitron',monospace;font-size:22px;font-weight:900;color:var(--white);}
.donut-l{font-size:10px;color:var(--text3);letter-spacing:1.5px;text-transform:uppercase;margin-top:2px;}
.leg{flex:1;min-width:150px;display:flex;flex-direction:column;gap:9px;}
.leg-i{display:flex;align-items:center;gap:10px;font-size:12.5px;}
.leg-d{width:10px;height:10px;border-radius:3px;flex-shrink:0;}
.leg-n{flex:1;color:var(--text);}
.leg-v{font-family:'Orbitron',monospace;font-weight:700;color:var(--white);font-size:11.5px;}

/* MODAL */
.mbg{position:fixed;inset:0;z-index:9800;background:rgba(0,0,0,.78);backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .3s;}
.mbg.open{opacity:1;pointer-events:all;}
.mbox{background:linear-gradient(160deg,rgba(10,28,58,.99),rgba(7,16,38,1));border:1px solid var(--border2);border-radius:20px;padding:clamp(24px,4vw,36px);width:100%;max-width:480px;position:relative;box-shadow:0 30px 80px rgba(0,0,0,.7);transform:translateY(20px) scale(.97);transition:transform .35s cubic-bezier(.34,1.1,.64,1);}
.mbg.open .mbox{transform:translateY(0) scale(1);}
.mcl{position:absolute;top:14px;right:16px;background:var(--card);border:1px solid var(--border);color:var(--text2);width:30px;height:30px;border-radius:8px;font-size:14px;}
.mcl:hover{background:rgba(255,68,68,.15);color:var(--red);border-color:rgba(255,68,68,.3);}
.mt{font-family:'Orbitron',monospace;font-size:19px;font-weight:700;color:var(--white);margin-bottom:6px;letter-spacing:1px;}
.ms{font-size:13px;color:var(--text2);line-height:1.6;margin-bottom:22px;}
.mf{display:flex;flex-direction:column;gap:12px;margin-bottom:20px;}
.mlb{display:block;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--text3);margin-bottom:6px;}
.mi{width:100%;background:rgba(6,20,46,.8);border:1px solid var(--border);border-radius:10px;padding:11px 14px;color:var(--text);font-size:13px;outline:none;transition:border-color .2s;}
.mi:focus{border-color:var(--accent2);box-shadow:0 0 0 3px rgba(26,110,245,.1);}
.mi::placeholder{color:var(--text3);}
select.mi{cursor:pointer;}
.mbtns{display:flex;gap:10px;}
.mbtns .btn{flex:1;justify-content:center;}

/* TOAST */
.toast{position:fixed;bottom:24px;right:24px;z-index:9900;background:rgba(10,26,55,.97);border:1px solid var(--accent);border-radius:13px;padding:13px 18px;display:flex;align-items:center;gap:10px;font-size:13px;font-weight:600;color:var(--text);box-shadow:0 8px 30px rgba(0,0,0,.5);transform:translateX(calc(100% + 30px));transition:transform .42s cubic-bezier(.34,1.2,.64,1);max-width:min(340px,calc(100vw - 48px));}
.toast.show{transform:translateX(0);}

/* OVERLAY */
.sb-ovl{display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:499;opacity:0;transition:opacity .3s;}
.sb-ovl.show{opacity:1;}

/* PAGE SWITCH */
.page{display:none;animation:pgIn .35s ease;}
.page.active{display:block;}
@keyframes pgIn{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}

/* RESPONSIVE */
@media(max-width:1100px){
  .two-col{grid-template-columns:1fr;}
  .chart-wrap{height:240px;}
}
@media(max-width:900px){
  .sb{width:min(300px,86vw);}
  .sb{transform:translateX(-100%);}
  .sb.open{transform:translateX(0);box-shadow:6px 0 28px rgba(0,0,0,.5);}
  .sb-ovl.show{display:block;}
  .main{margin-left:0;}
  .tb-burger{display:flex;}
  .tb-title{display:none;}
  .tb{height:auto;min-height:62px;flex-wrap:wrap;padding:10px 14px;gap:10px;}
  .tb-search{order:3;flex-basis:100%;max-width:none;}
  .tb-acts{margin-left:auto;}
  .ct{padding:16px;}
  .pn-h,.pn-b{padding:16px;}
  .ph{margin-bottom:18px;}
  .ntf-panel{top:74px;right:12px;width:min(380px,calc(100vw - 24px));}
}
@media(max-width:640px){
  .sb{width:min(320px,88vw);}
  .tb{padding:10px 12px;gap:10px;}
  .tb-search{max-width:none;order:2;width:100%;flex-basis:100%;}
  .tb-btn:not(.always){display:none;}
  .tb-search input{padding:9px 12px 9px 36px;font-size:12px;}
  .tb-si{left:12px;}
  .tb-sk{display:none;}
  .ct{padding:12px;}
  .ph{flex-direction:column;align-items:flex-start;}
  .ph-t{font-size:clamp(18px,7vw,22px);letter-spacing:1px;}
  .ph-s{font-size:12px;}
  .stat-grid{grid-template-columns:1fr 1fr;gap:12px;}
  .st{padding:18px 16px;}
  .st-v{font-size:22px;}
  .pn-h{padding:14px 16px;}
  .pn-b{padding:16px;}
  .tbl{min-width:520px;font-size:12px;}
  .u-n{white-space:normal;}
  .pg{grid-template-columns:repeat(2,1fr);}
  .qa-grid{grid-template-columns:repeat(2,1fr);}
  .goal-sub{flex-direction:column;align-items:flex-start;gap:4px;}
  .ntf-panel{top:70px;right:10px;width:calc(100vw - 20px);}
  .toast{left:12px;right:12px;bottom:12px;max-width:none;transform:translateY(calc(100% + 20px));}
  .toast.show{transform:translateY(0);}
}
@media(max-width:420px){
  .sb{width:100vw;}
  .stat-grid{grid-template-columns:1fr;}
  .pg{grid-template-columns:1fr;}
  .qa-grid{grid-template-columns:1fr;}
  .ph-r{width:100%;}
  .ph-r .btn{flex:1;justify-content:center;}
  .tb-btn{width:36px;height:36px;}
  .pn-acts{width:100%;justify-content:flex-start;overflow:auto;padding-bottom:2px;}
  .pn-tab{flex:0 0 auto;}
  .tbl{min-width:480px;}
}
</style>
</head>
<body>

<canvas id="starBg"></canvas>

<!-- TOAST -->
<div class="toast" id="toast"><span id="tIcon">✅</span><span id="tMsg">Ok!</span></div>

<!-- SIDEBAR OVERLAY -->
<div class="sb-ovl" id="sbOvl" onclick="closeSB()"></div>

<!-- NOTIFICATIONS -->
<div class="ntf-panel" id="ntfPanel">
  <div class="ntf-h"><div class="ntf-t">🔔 Notifikasi <span class="ntf-c">5</span></div><button class="btn btn-sm btn-g" onclick="markAllRead()">Tandai Dibaca</button></div>
  <div class="ntf-b">
    <div class="ntf-i unread"><div class="ntf-ic ic-p">🆕</div><div class="ntf-info"><div class="ntf-nt"><b>SakuraX</b> bergabung sebagai member baru!</div><div class="ntf-nm">2 menit lalu</div></div></div>
    <div class="ntf-i unread"><div class="ntf-ic ic-g">💰</div><div class="ntf-info"><div class="ntf-nt"><b>Pembelian baru:</b> Dragon Wings (750 Robux)</div><div class="ntf-nm">8 menit lalu</div></div></div>
    <div class="ntf-i unread"><div class="ntf-ic ic-t">📢</div><div class="ntf-info"><div class="ntf-nt"><b>Event Mega Battle</b> dimulai dalam 30 menit!</div><div class="ntf-nm">15 menit lalu</div></div></div>
    <div class="ntf-i unread"><div class="ntf-ic ic-b">⚠️</div><div class="ntf-info"><div class="ntf-nt"><b>5 laporan</b> baru menunggu review</div><div class="ntf-nm">1 jam lalu</div></div></div>
    <div class="ntf-i unread"><div class="ntf-ic ic-p">🏆</div><div class="ntf-info"><div class="ntf-nt"><b>ThunderZ</b> mencapai Level 98!</div><div class="ntf-nm">2 jam lalu</div></div></div>
    <div class="ntf-i"><div class="ntf-ic ic-g">💎</div><div class="ntf-info"><div class="ntf-nt">Reward harian berhasil didistribusikan ke 1,247 member</div><div class="ntf-nm">5 jam lalu</div></div></div>
    <div class="ntf-i"><div class="ntf-ic ic-t">✅</div><div class="ntf-info"><div class="ntf-nt">Backup database berhasil otomatis</div><div class="ntf-nm">Kemarin</div></div></div>
  </div>
  <div class="ntf-f"><a href="#" onclick="toast('Membuka semua notifikasi...');return false">Lihat semua →</a></div>
</div>

<!-- MODAL: Tambah User -->
<div class="mbg" id="mUser">
  <div class="mbox">
    <button class="mcl" onclick="cm('mUser')">✕</button>
    <div class="mt">👤 Tambah Member</div>
    <div class="ms">Tambahkan member baru ke LYVA Community.</div>
    <div class="mf">
      <div><label class="mlb">Username Roblox</label><input type="text" class="mi" id="nuName" placeholder="StarPlayer_X"></div>
      <div><label class="mlb">Discord Tag</label><input type="text" class="mi" placeholder="user#1234"></div>
      <div><label class="mlb">Role</label>
        <select class="mi"><option>Member</option><option>Pro</option><option>Moderator</option><option>Admin</option></select>
      </div>
    </div>
    <div class="mbtns"><button class="btn btn-p" onclick="addMember()">➕ Tambah</button><button class="btn btn-g" onclick="cm('mUser')">Batal</button></div>
  </div>
</div>

<!-- MODAL: Tambah Event -->
<div class="mbg" id="mEvent">
  <div class="mbox">
    <button class="mcl" onclick="cm('mEvent')">✕</button>
    <div class="mt">🎉 Buat Event Baru</div>
    <div class="ms">Buat event keren untuk komunitas LYVA.</div>
    <div class="mf">
      <div><label class="mlb">Nama Event</label><input type="text" class="mi" placeholder="Mega Battle #13"></div>
      <div><label class="mlb">Tanggal</label><input type="date" class="mi"></div>
      <div><label class="mlb">Tipe</label>
        <select class="mi"><option>Tournament</option><option>Build Challenge</option><option>Cosplay Contest</option><option>Race</option></select>
      </div>
      <div><label class="mlb">Hadiah (Robux)</label><input type="number" class="mi" placeholder="50000"></div>
    </div>
    <div class="mbtns"><button class="btn btn-p" onclick="addEvent()">🚀 Buat Event</button><button class="btn btn-g" onclick="cm('mEvent')">Batal</button></div>
  </div>
</div>

<div class="app">
  <!-- ══════════ SIDEBAR ══════════ -->
  <aside class="sb" id="sb">
    <div class="sb-head">
      <div class="sb-logo">
        <img src="{{ asset('lyva-navbar-logo.png') }}" alt="LYVA Community" class="sb-logo-img">
      </div>
      <div class="sb-brand">
        <div class="sb-name">LYVA</div>
        <div class="sb-sub">Admin Panel</div>
      </div>
    </div>

    <div class="sb-nav">
      <div class="sb-sec">Main</div>
      <div class="sb-item active" data-page="dash" onclick="goPage('dash')"><span class="sb-ic">📊</span><span class="sb-lbl">Dashboard</span></div>
      <div class="sb-item" data-page="analytics" onclick="goPage('analytics')"><span class="sb-ic">📈</span><span class="sb-lbl">Analytics</span><span class="sb-bd bd-new">NEW</span></div>
      <div class="sb-item" data-page="live" onclick="goPage('live')"><span class="sb-ic">🔴</span><span class="sb-lbl">Live Events</span><span class="sb-bd bd-live">LIVE</span></div>

      <div class="sb-sec">Manajemen</div>
      <div class="sb-item" data-page="members" onclick="goPage('members')"><span class="sb-ic">👥</span><span class="sb-lbl">Members</span></div>
      <div class="sb-item" data-page="shop" onclick="goPage('shop')"><span class="sb-ic">🛒</span><span class="sb-lbl">Shop</span></div>
      <div class="sb-item" data-page="events" onclick="goPage('events')"><span class="sb-ic">🎉</span><span class="sb-lbl">Events</span><span class="sb-bd bd-n">3</span></div>
      <div class="sb-item" data-page="rewards" onclick="goPage('rewards')"><span class="sb-ic">🎁</span><span class="sb-lbl">Rewards</span></div>
      <div class="sb-item" data-page="leaderboard" onclick="goPage('leaderboard')"><span class="sb-ic">🏆</span><span class="sb-lbl">Leaderboard</span></div>

      <div class="sb-sec">Komunikasi</div>
      <div class="sb-item" data-page="chat" onclick="goPage('chat')"><span class="sb-ic">💬</span><span class="sb-lbl">Chat Log</span></div>
      <div class="sb-item" data-page="announce" onclick="goPage('announce')"><span class="sb-ic">📢</span><span class="sb-lbl">Pengumuman</span></div>
      <div class="sb-item" data-page="reports" onclick="goPage('reports')"><span class="sb-ic">🚨</span><span class="sb-lbl">Laporan</span><span class="sb-bd bd-n">12</span></div>

      <div class="sb-sec">System</div>
      <div class="sb-item" data-page="settings" onclick="goPage('settings')"><span class="sb-ic">⚙️</span><span class="sb-lbl">Pengaturan</span></div>
      <div class="sb-item" data-page="logs" onclick="goPage('logs')"><span class="sb-ic">📋</span><span class="sb-lbl">Activity Log</span></div>
    </div>

    <div class="sb-foot">
      <div class="sb-user" onclick="toast('Login sebagai {{ $discordAuthUser['name'] ?? 'Admin LYVA' }}')">
        <div class="sb-av">
          @if(!empty($discordAuthUser['avatar_url']))
            <img src="{{ $discordAuthUser['avatar_url'] }}" alt="{{ $discordAuthUser['name'] ?? 'Discord User' }}" class="sb-av-img" referrerpolicy="no-referrer">
          @else
            👑
          @endif
        </div>
        <div class="sb-uinf">
          <div class="sb-un">{{ $discordAuthUser['name'] ?? ($discordAuthUser['username'] ?? 'Admin LYVA') }}</div>
          <div class="sb-ur">{{ strtoupper($discordAuthUser['primary_role'] ?? 'Core Member') }}</div>
        </div>
        <span style="font-size:13px;color:var(--text3)">⚙️</span>
      </div>
    </div>
  </aside>

  <!-- ══════════ MAIN ══════════ -->
  <main class="main">
    <!-- TOPBAR -->
    <div class="tb">
      <button class="tb-burger" onclick="openSB()">☰</button>
      <div class="tb-title"><div class="tb-t" id="pageTitle">Dashboard</div><div class="tb-sub" id="pageSub">Selamat datang kembali, Admin!</div></div>
      <div class="tb-search"><span class="tb-si">🔍</span><input type="text" placeholder="Cari member, event, item..."><span class="tb-sk">⌘ K</span></div>
      <div class="tb-acts">
        <button class="tb-btn tb-install always" type="button" data-install-app hidden>＋ Install</button>
        <button class="tb-btn always" onclick="toggleTheme()" title="Theme">🌙</button>
        <button class="tb-btn always" onclick="toggleNtf()" title="Notifikasi">🔔<span class="tb-ndot"></span></button>
        <button class="tb-btn" onclick="toast('Messages')" title="Messages">✉️</button>
        <button class="tb-btn" onclick="toast('Discord server...')" title="Discord">💬</button>
      </div>
    </div>

    <div class="ct">
      @if (session('status'))
        <div class="pn" style="margin-bottom:18px;border-color:rgba(34,197,94,.35);">
          <div class="pn-b" style="padding:16px 22px;color:var(--green);font-weight:700;">{{ session('status') }}</div>
        </div>
      @endif

      <!-- ══════════ PAGE: DASHBOARD ══════════ -->
      <div class="page active" id="pg-dash">

        <div class="ph">
          <div class="ph-l">
            <div class="ph-t">🚀 Selamat Datang, Admin LYVA!</div>
            <div class="ph-s">{{ $dashboardCommunity['server_name'] ?? 'LYVA Community' }} sekarang punya <span style="color:var(--green);font-weight:700">{{ number_format((int) ($dashboardStats['total_members'] ?? 0)) }} member</span> dengan {{ number_format((int) ($dashboardStats['active_members'] ?? 0)) }} yang lagi aktif.</div>
          </div>
          <div class="ph-r">
            <button class="btn btn-g" onclick="toast('Export berhasil!')">📥 Export</button>
            <a href="{{ route('dashboard.community-events.create') }}" class="btn btn-p">✨ Event Baru</a>
          </div>
        </div>

        <!-- STATS -->
        <div class="stat-grid">
          <div class="st">
            <div class="st-top"><div class="st-ic ic-b">👥</div><div class="st-tr tr-up">↑ 12.4%</div></div>
            <div class="st-v" id="s1" data-counter-target="{{ (int) ($dashboardStats['total_members'] ?? 0) }}">{{ number_format((int) ($dashboardStats['total_members'] ?? 0)) }}</div>
            <div class="st-l">Total Members</div>
            <div class="st-spark"><div class="spk" style="height:30%"></div><div class="spk" style="height:50%"></div><div class="spk" style="height:40%"></div><div class="spk" style="height:65%"></div><div class="spk" style="height:55%"></div><div class="spk" style="height:80%"></div><div class="spk" style="height:70%"></div><div class="spk" style="height:95%"></div></div>
          </div>
          <div class="st sg">
            <div class="st-top"><div class="st-ic ic-g">💰</div><div class="st-tr tr-up">↑ 8.7%</div></div>
            <div class="st-v" id="s2" data-counter-target="{{ (int) ($dashboardStats['catalog_value'] ?? 0) }}">{{ number_format((int) ($dashboardStats['catalog_value'] ?? 0)) }}</div>
            <div class="st-l">Catalog Value (Robux)</div>
            <div class="st-spark"><div class="spk" style="height:40%"></div><div class="spk" style="height:35%"></div><div class="spk" style="height:55%"></div><div class="spk" style="height:45%"></div><div class="spk" style="height:75%"></div><div class="spk" style="height:60%"></div><div class="spk" style="height:85%"></div><div class="spk" style="height:90%"></div></div>
          </div>
          <div class="st spk">
            <div class="st-top"><div class="st-ic ic-p">🔥</div><div class="st-tr tr-up">↑ 24.1%</div></div>
            <div class="st-v" id="s3" data-counter-target="{{ (int) ($dashboardStats['active_members'] ?? 0) }}">{{ number_format((int) ($dashboardStats['active_members'] ?? 0)) }}</div>
            <div class="st-l">Active Now</div>
            <div class="st-spark"><div class="spk" style="height:50%"></div><div class="spk" style="height:60%"></div><div class="spk" style="height:70%"></div><div class="spk" style="height:55%"></div><div class="spk" style="height:80%"></div><div class="spk" style="height:75%"></div><div class="spk" style="height:90%"></div><div class="spk" style="height:100%"></div></div>
          </div>
          <div class="st st-e">
            <div class="st-top"><div class="st-ic ic-t">🎮</div><div class="st-tr tr-dn">↓ 2.3%</div></div>
            <div class="st-v" id="s4" data-counter-target="{{ (int) ($dashboardStats['gallery_media'] ?? 0) }}">{{ number_format((int) ($dashboardStats['gallery_media'] ?? 0)) }}</div>
            <div class="st-l">Gallery Media</div>
            <div class="st-spark"><div class="spk" style="height:70%"></div><div class="spk" style="height:80%"></div><div class="spk" style="height:65%"></div><div class="spk" style="height:75%"></div><div class="spk" style="height:60%"></div><div class="spk" style="height:55%"></div><div class="spk" style="height:50%"></div><div class="spk" style="height:45%"></div></div>
          </div>
        </div>

        <!-- CHART + ACTIVITY -->
        <div class="two-col">
          <div class="pn">
            <div class="pn-h">
              <div><div class="pn-t">📈 Member Growth</div><div class="pn-tsub">Pertumbuhan member 7 hari terakhir</div></div>
              <div class="pn-acts">
                <div class="pn-tab" onclick="switchChart(this,'7d')">7D</div>
                <div class="pn-tab on" onclick="switchChart(this,'30d')">30D</div>
                <div class="pn-tab" onclick="switchChart(this,'3m')">3M</div>
                <div class="pn-tab" onclick="switchChart(this,'1y')">1Y</div>
              </div>
            </div>
            <div class="pn-b">
              <div class="chart-wrap">
                <svg class="chart-svg" viewBox="0 0 700 280" preserveAspectRatio="none">
                  <defs>
                    <linearGradient id="gradArea" x1="0" y1="0" x2="0" y2="1">
                      <stop offset="0%" stop-color="#3d8eff" stop-opacity=".4"/>
                      <stop offset="100%" stop-color="#3d8eff" stop-opacity="0"/>
                    </linearGradient>
                    <linearGradient id="gradLine" x1="0" y1="0" x2="1" y2="0">
                      <stop offset="0%" stop-color="#1a6ef5"/>
                      <stop offset="100%" stop-color="#6ab0ff"/>
                    </linearGradient>
                  </defs>
                  <!-- grid -->
                  <g stroke="rgba(30,80,160,.2)" stroke-width="1">
                    <line x1="40" y1="30" x2="680" y2="30"/>
                    <line x1="40" y1="90" x2="680" y2="90"/>
                    <line x1="40" y1="150" x2="680" y2="150"/>
                    <line x1="40" y1="210" x2="680" y2="210"/>
                    <line x1="40" y1="250" x2="680" y2="250"/>
                  </g>
                  <!-- y labels -->
                  <g fill="#3d6a9e" font-size="11" font-family="Orbitron">
                    <text x="30" y="34" text-anchor="end">5k</text>
                    <text x="30" y="94" text-anchor="end">4k</text>
                    <text x="30" y="154" text-anchor="end">3k</text>
                    <text x="30" y="214" text-anchor="end">2k</text>
                    <text x="30" y="254" text-anchor="end">1k</text>
                  </g>
                  <!-- area -->
                  <path d="M40,230 L100,210 L160,190 L220,195 L280,170 L340,145 L400,135 L460,115 L520,105 L580,80 L640,60 L680,50 L680,250 L40,250 Z" fill="url(#gradArea)"/>
                  <!-- line -->
                  <path d="M40,230 L100,210 L160,190 L220,195 L280,170 L340,145 L400,135 L460,115 L520,105 L580,80 L640,60 L680,50" stroke="url(#gradLine)" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                  <!-- points -->
                  <g fill="#6ab0ff" stroke="#010714" stroke-width="2">
                    <circle cx="40" cy="230" r="4"/>
                    <circle cx="160" cy="190" r="4"/>
                    <circle cx="280" cy="170" r="4"/>
                    <circle cx="400" cy="135" r="4"/>
                    <circle cx="520" cy="105" r="4"/>
                    <circle cx="680" cy="50" r="4.5" fill="#fff"/>
                  </g>
                  <!-- x labels -->
                  <g fill="#3d6a9e" font-size="10" font-family="Exo 2" text-anchor="middle">
                    <text x="40" y="270">01</text>
                    <text x="160" y="270">05</text>
                    <text x="280" y="270">10</text>
                    <text x="400" y="270">15</text>
                    <text x="520" y="270">22</text>
                    <text x="680" y="270">30</text>
                  </g>
                </svg>
              </div>
            </div>
          </div>

          <div class="pn">
            <div class="pn-h">
              <div class="pn-t">⚡ Live Activity</div>
              <button class="btn btn-sm btn-g">🔄</button>
            </div>
            <div class="pn-b">
              <div class="act-list">
                <div class="act"><div class="act-ic ic-p">🎉</div><div class="act-b"><div class="act-t"><b>SakuraX</b> bergabung ke komunitas</div><div class="act-tm">Baru saja</div></div></div>
                <div class="act"><div class="act-ic ic-g">💰</div><div class="act-b"><div class="act-t"><b>DragonLord</b> beli <span class="hl">Dragon Wings</span></div><div class="act-tm">3 menit lalu</div></div></div>
                <div class="act"><div class="act-ic ic-b">🏆</div><div class="act-b"><div class="act-t"><b>ThunderZ</b> menang Mega Battle!</div><div class="act-tm">12 menit lalu</div></div></div>
                <div class="act"><div class="act-ic ic-t">🎮</div><div class="act-b"><div class="act-t"><b>AimBot99</b> mencapai Level 77</div><div class="act-tm">28 menit lalu</div></div></div>
                <div class="act"><div class="act-ic ic-p">🌟</div><div class="act-b"><div class="act-t"><b>MoonGirl</b> claim reward harian</div><div class="act-tm">45 menit lalu</div></div></div>
                <div class="act"><div class="act-ic ic-g">📢</div><div class="act-b"><div class="act-t">Event <span class="hl">Mega Battle</span> dimulai</div><div class="act-tm">1 jam lalu</div></div></div>
                <div class="act"><div class="act-ic ic-b">🛡️</div><div class="act-b"><div class="act-t"><b>GuardByte</b> ban user <span class="hl">SpamBot</span></div><div class="act-tm">2 jam lalu</div></div></div>
                <div class="act"><div class="act-ic ic-t">🎁</div><div class="act-b"><div class="act-t">Reward siap dibagikan ke <b>{{ number_format((int) ($dashboardStats['total_members'] ?? 0)) }} member</b></div><div class="act-tm">5 jam lalu</div></div></div>
              </div>
            </div>
          </div>
        </div>

        <!-- QUICK ACTIONS -->
        <div class="pn" style="margin-bottom:24px;">
          <div class="pn-h"><div class="pn-t">⚡ Quick Actions</div></div>
          <div class="pn-b">
            <div class="qa-grid">
              <div class="qa" onclick="toast('Staff di dashboard ini sinkron dari Discord, jadi editnya dilakukan dari server Discord.')"><div class="qa-ic ic-b">👤</div><div class="qa-t">Kelola Staff</div><div class="qa-d">Sinkron Discord</div></div>
              <a href="{{ route('dashboard.community-events.create') }}" class="qa"><div class="qa-ic ic-p">🎉</div><div class="qa-t">Buat Event</div><div class="qa-d">Kompetisi baru</div></a>
              <div class="qa" onclick="toast('Broadcast siap dikirim ke {{ number_format((int) ($dashboardStats['total_members'] ?? 0)) }} member!')"><div class="qa-ic ic-g">📢</div><div class="qa-t">Broadcast</div><div class="qa-d">Pesan ke semua</div></div>
              <div class="qa" onclick="toast('Reward distribusi...')"><div class="qa-ic ic-t">🎁</div><div class="qa-t">Beri Reward</div><div class="qa-d">Bagi hadiah</div></div>
              <a href="{{ route('dashboard.shop-items.create') }}" class="qa"><div class="qa-ic ic-b">🛒</div><div class="qa-t">Tambah Item</div><div class="qa-d">Shop update</div></a>
              <div class="qa" onclick="toast('Backup dimulai...')"><div class="qa-ic ic-g">💾</div><div class="qa-t">Backup Data</div><div class="qa-d">Save snapshot</div></div>
            </div>
          </div>
        </div>

        <!-- TWO COL: TOP MEMBERS + SHOP STATS -->
        <div class="two-col">
          <div class="pn">
            <div class="pn-h">
              <div><div class="pn-t">🏆 Top Members</div><div class="pn-tsub">Ranking bulan April 2024</div></div>
              <button class="btn btn-sm btn-g" onclick="goPage('leaderboard')">Lihat Semua →</button>
            </div>
            <div class="pn-b" style="padding:8px 22px 22px;">
              <div class="tbl-wrap">
                <table class="tbl">
                  <thead><tr><th>Player</th><th>Wins</th><th>Points</th><th>Season</th></tr></thead>
                  <tbody>
                    @forelse ($dashboardTopPlayers as $index => $player)
                      <tr>
                        <td>
                          <div class="u-cell">
                            <div class="u-av" style="background:{{ $index === 0 ? 'rgba(245,200,66,.15);border-color:rgba(245,200,66,.5)' : ($index === 1 ? 'rgba(192,192,192,.15)' : ($index === 2 ? 'rgba(205,127,50,.15)' : 'rgba(26,110,245,.12)')) }}">{{ $player->avatar_emoji }}</div>
                            <div class="u-info">
                              <div class="u-n">{{ $index === 0 ? '🥇' : ($index === 1 ? '🥈' : ($index === 2 ? '🥉' : '#'.($index + 1))) }} {{ $player->player_name }}</div>
                              <div class="u-id">{{ $player->headline }}</div>
                            </div>
                          </div>
                        </td>
                        <td><b style="color:var(--white)">{{ number_format($player->wins) }}</b></td>
                        <td style="color:var(--accent3);font-family:'Orbitron'">{{ number_format($player->points) }}</td>
                        <td><span class="chip c-pro">{{ $player->season }}</span></td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" style="color:var(--text3);text-align:center;">Belum ada data leaderboard.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="pn">
            <div class="pn-h"><div class="pn-t">🛒 Shop Stats</div></div>
            <div class="pn-b">
              <div class="donut-wrap">
                <div class="donut">
                  <svg viewBox="0 0 100 100" style="width:100%;height:100%;transform:rotate(-90deg);">
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#091833" stroke-width="12"/>
                    @foreach ($dashboardShopStats['inventory_segments'] as $segment)
                      <circle cx="50" cy="50" r="40" fill="none" stroke="{{ $segment['color'] }}" stroke-width="12" stroke-dasharray="{{ $segment['dash_array'] }}" stroke-dashoffset="{{ $segment['dash_offset'] }}" stroke-linecap="round"/>
                    @endforeach
                  </svg>
                  <div class="donut-cn"><div class="donut-v">{{ number_format($dashboardShopStats['item_count']) }}</div><div class="donut-l">Item Aktif</div></div>
                </div>
                <div class="leg">
                  @foreach ($dashboardShopStats['inventory_segments'] as $segment)
                    <div class="leg-i"><div class="leg-d" style="background:{{ $segment['color'] }}"></div><div class="leg-n">{{ $segment['label'] }}</div><div class="leg-v">{{ $segment['count'] }}</div></div>
                  @endforeach
                </div>
              </div>

              <div style="margin-top:22px;padding-top:18px;border-top:1px solid var(--border);">
                <div style="font-size:12px;color:var(--text3);text-transform:uppercase;letter-spacing:1.5px;margin-bottom:10px;font-weight:700;">🎯 Ringkasan Catalog</div>
                <div class="goal-list">
                  <div class="goal">
                    <div class="goal-h"><div class="goal-t">💰 Catalog Value</div><div class="goal-p">{{ number_format($dashboardShopStats['catalog_value']) }}</div></div>
                    <div class="prg"><div class="prg-b" style="width:{{ min((int) round(($dashboardShopStats['catalog_value'] / max($dashboardShopStats['catalog_value'], 1)) * 100), 100) }}%"></div></div>
                    <div class="goal-sub"><span>{{ number_format($dashboardShopStats['catalog_value']) }} Robux</span><span style="color:var(--green)">Data dari backend shop</span></div>
                  </div>
                  <div class="goal">
                    <div class="goal-h"><div class="goal-t">🛍️ Featured Items</div><div class="goal-p">{{ number_format($dashboardShopStats['featured_items']) }}</div></div>
                    <div class="prg"><div class="prg-b" style="width:{{ $dashboardShopStats['item_count'] > 0 ? min((int) round(($dashboardShopStats['featured_items'] / $dashboardShopStats['item_count']) * 100), 100) : 0 }}%;background:linear-gradient(90deg,var(--pink),#ff7fb8)"></div></div>
                    <div class="goal-sub"><span>{{ number_format($dashboardShopStats['featured_items']) }} dari {{ number_format($dashboardShopStats['item_count']) }} item</span><span style="color:var(--green)">HOT / NEW / VIP / RARE</span></div>
                  </div>
                  <div class="goal">
                    <div class="goal-h"><div class="goal-t">🏷️ Avg Price</div><div class="goal-p">{{ number_format($dashboardShopStats['average_price']) }}</div></div>
                    <div class="prg"><div class="prg-b" style="width:{{ $dashboardShopStats['catalog_value'] > 0 ? min((int) round(($dashboardShopStats['average_price'] / $dashboardShopStats['catalog_value']) * 100 * $dashboardShopStats['item_count']), 100) : 0 }}%;background:linear-gradient(90deg,var(--gold),#ffd966)"></div></div>
                    <div class="goal-sub"><span>{{ number_format($dashboardShopStats['average_price']) }} Robux per item</span><span style="color:var(--green)">Rata-rata catalog aktif</span></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- CALENDAR + UPCOMING -->
        <div class="two-col">
          <div class="pn">
            <div class="pn-h"><div class="pn-t">📅 Event Calendar</div><a href="{{ route('dashboard.community-events.create') }}" class="btn btn-sm btn-g">+ New</a></div>
            <div class="pn-b">
              <div class="cal">
                <div class="cal-h">
                  <div class="cal-m">April 2024</div>
                  <div class="cal-nav"><button>◀</button><button>▶</button></div>
                </div>
                <div class="cal-grid" id="calGrid"></div>
              </div>
            </div>
          </div>

          <div class="pn">
            <div class="pn-h"><div class="pn-t">🎉 Upcoming Events</div><button class="btn btn-sm btn-g">Lihat Semua</button></div>
            <div class="pn-b">
              <div class="act-list">
                @forelse ($dashboardEvents as $event)
                  <div class="act">
                    <div class="act-ic {{ $loop->iteration % 4 === 1 ? 'ic-b' : ($loop->iteration % 4 === 2 ? 'ic-g' : ($loop->iteration % 4 === 3 ? 'ic-p' : 'ic-t')) }}">{{ $event->icon }}</div>
                    <div class="act-b">
                      <div class="act-t"><b>{{ $event->name }}</b></div>
                      <div class="act-tm">{{ $event->status_label }} • {{ $event->event_date->translatedFormat('d M Y') }}</div>
                    </div>
                  </div>
                @empty
                  <div style="color:var(--text3);">Belum ada event aktif.</div>
                @endforelse
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- ══════════ PAGE: MEMBERS ══════════ -->
      <div class="page" id="pg-members">
        <div class="ph">
          <div class="ph-l">
            <div class="ph-t">👥 Member Manager</div>
            <div class="ph-s">Kelola semua member LYVA Community</div>
          </div>
          <div class="ph-r">
            <button class="btn btn-g" onclick="toast('Export member data...')">📥 Export CSV</button>
            <button class="btn btn-p" onclick="toast('Member staff di dashboard ini dibaca langsung dari Discord, jadi tambah/edit dilakukan dari Discord ya.')">🔗 Sinkron Discord</button>
          </div>
        </div>

        <div class="stat-grid">
          <div class="st"><div class="st-top"><div class="st-ic ic-b">👥</div><div class="st-tr tr-up">↑ 12%</div></div><div class="st-v">{{ number_format($dashboardMemberStats['total_members']) }}</div><div class="st-l">Total Members</div></div>
          <div class="st st-e"><div class="st-top"><div class="st-ic ic-t">🟢</div></div><div class="st-v">{{ number_format($dashboardMemberStats['active_members']) }}</div><div class="st-l">Online Sekarang</div></div>
          <div class="st sg"><div class="st-top"><div class="st-ic ic-g">⭐</div><div class="st-tr tr-up">↑ 5%</div></div><div class="st-v">{{ number_format($dashboardMemberStats['leadership_members']) }}</div><div class="st-l">Staff Terlacak</div></div>
          <div class="st spk"><div class="st-top"><div class="st-ic ic-p">🛡️</div></div><div class="st-v">{{ number_format($dashboardMemberStats['management_members']) }}</div><div class="st-l">Owner & Admin</div></div>
        </div>

        <div class="pn">
          <div class="pn-h">
            <div class="pn-t">📋 Daftar Member</div>
            <div class="pn-acts">
              <div class="pn-tab on">Semua</div>
              <div class="pn-tab">Online</div>
              <div class="pn-tab">VIP</div>
              <div class="pn-tab">Banned</div>
            </div>
          </div>
          <div class="pn-b" style="padding:0;">
            <div class="tbl-wrap">
              <table class="tbl">
                <thead><tr><th>Member</th><th>Role</th><th>Badge</th><th>Avatar</th><th>Source</th><th>Aksi</th></tr></thead>
                <tbody>
                  @forelse ($dashboardLeadership as $member)
                    <tr>
                      <td>
                        <div class="u-cell">
                          <div class="u-av" style="background:rgba(26,110,245,.12)">
                            @if ($member['avatar_url'])
                              <img src="{{ $member['avatar_url'] }}" alt="{{ $member['name'] }}" class="u-av-img">
                            @else
                              {{ $member['avatar_text'] }}
                            @endif
                          </div>
                          <div class="u-info">
                            <div class="u-n">{{ $member['name'] }}</div>
                            <div class="u-id">{{ $member['meta'] }}</div>
                          </div>
                        </div>
                      </td>
                      <td><span class="chip {{ $member['role_class'] }}">{{ $member['icon'] }} {{ $member['role'] }}</span></td>
                      <td><b style="color:var(--white)">{{ $member['meta'] }}</b></td>
                      <td style="color:var(--text2)">{{ $member['avatar_state'] }}</td>
                      <td><span class="st-chip s-on">Discord</span></td>
                      <td><div class="tb-acts-row"><button class="ta-btn" type="button" onclick="toast('Data staff ini berasal dari Discord.')">👁️</button><button class="ta-btn" type="button" onclick="toast('Edit role dilakukan dari server Discord.')">🔗</button></div></td>
                    </tr>
                  @empty
                    <tr><td colspan="6" style="color:var(--text3);text-align:center;">Belum ada staff Discord yang berhasil dimuat.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- ══════════ PAGE: SHOP ══════════ -->
      <div class="page" id="pg-shop">
        <div class="ph">
          <div class="ph-l"><div class="ph-t">🛒 Shop Manager</div><div class="ph-s">Kelola item dan produk eksklusif</div></div>
          <div class="ph-r">
            <button class="btn btn-g" onclick="toast('Analytics shop...')">📊 Analytics</button>
            <a href="{{ route('dashboard.shop-items.create') }}" class="btn btn-p">➕ Tambah Item</a>
          </div>
        </div>

        <div class="stat-grid">
          <div class="st sg"><div class="st-top"><div class="st-ic ic-g">💰</div><div class="st-tr tr-up">↑ 18%</div></div><div class="st-v">{{ number_format($dashboardShopStats['catalog_value']) }}</div><div class="st-l">Catalog Value</div></div>
          <div class="st"><div class="st-top"><div class="st-ic ic-b">📦</div></div><div class="st-v">{{ number_format($dashboardShopStats['item_count']) }}</div><div class="st-l">Total Items</div></div>
          <div class="st st-e"><div class="st-top"><div class="st-ic ic-t">🛍️</div><div class="st-tr tr-up">↑ 24%</div></div><div class="st-v">{{ number_format($dashboardShopStats['average_price']) }}</div><div class="st-l">Avg Price</div></div>
          <div class="st spk"><div class="st-top"><div class="st-ic ic-p">🔥</div></div><div class="st-v">{{ number_format($dashboardShopStats['featured_items']) }}</div><div class="st-l">Featured Items</div></div>
        </div>

        <div class="pn">
          <div class="pn-h"><div class="pn-t">📦 Inventory</div>
            <div class="pn-acts"><div class="pn-tab on">Semua</div><div class="pn-tab">HOT 🔥</div><div class="pn-tab">NEW ✨</div><div class="pn-tab">RARE 💎</div></div>
          </div>
          <div class="pn-b">
            <div class="pg">
              @forelse ($dashboardShopItems as $shopItem)
                <div class="prod">
                  <div class="prod-img" style="background:linear-gradient(145deg,{{ $shopItem->gradient_from }},{{ $shopItem->gradient_to }})">
                    {{ $shopItem->emoji }}
                    @if ($shopItem->badge_label)
                      <div class="prod-bd {{ $shopItem->badge_class === 'bh' ? 'bd-hot' : ($shopItem->badge_class === 'bn' ? 'bd-nw' : 'bd-rr') }}">{{ $shopItem->badge_label }}</div>
                    @endif
                  </div>
                  <div class="prod-inf">
                    <div class="prod-n">{{ $shopItem->name }}</div>
                    <div class="prod-r">
                      <div class="prod-p">🪙 {{ number_format($shopItem->price) }}</div>
                      <div class="prod-sold">{{ $shopItem->stars }} bintang</div>
                    </div>
                    <div class="prod-acts">
                      <a href="{{ route('dashboard.shop-items.edit', $shopItem) }}" class="ta-btn">✏️ Edit</a>
                      <form method="POST" action="{{ route('dashboard.shop-items.destroy', $shopItem) }}" onsubmit="return confirm('Hapus item ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ta-btn dang">🗑️</button>
                      </form>
                    </div>
                  </div>
                </div>
              @empty
                <div style="color:var(--text3);">Belum ada item shop aktif.</div>
              @endforelse
            </div>
          </div>
        </div>
      </div>

      <!-- ══════════ PAGE: EVENTS ══════════ -->
      <div class="page" id="pg-events">
        <div class="ph">
          <div class="ph-l"><div class="ph-t">🎉 Event Manager</div><div class="ph-s">Kelola event dan kompetisi komunitas</div></div>
          <div class="ph-r"><a href="{{ route('dashboard.community-events.create') }}" class="btn btn-p">✨ Event Baru</a></div>
        </div>

        <div class="stat-grid">
          <div class="st"><div class="st-top"><div class="st-ic ic-b">🎉</div></div><div class="st-v">{{ number_format($dashboardEventStats['total']) }}</div><div class="st-l">Total Event</div></div>
          <div class="st spk"><div class="st-top"><div class="st-ic ic-p">🔴</div></div><div class="st-v">{{ number_format($dashboardEventStats['live']) }}</div><div class="st-l">Live Sekarang</div></div>
          <div class="st sg"><div class="st-top"><div class="st-ic ic-g">⏳</div></div><div class="st-v">{{ number_format($dashboardEventStats['upcoming']) }}</div><div class="st-l">Coming Soon</div></div>
          <div class="st st-e"><div class="st-top"><div class="st-ic ic-t">🏁</div><div class="st-tr tr-up">↑ 30%</div></div><div class="st-v">{{ number_format($dashboardEventStats['finished']) }}</div><div class="st-l">Selesai</div></div>
        </div>

        <div class="pn">
          <div class="pn-h"><div class="pn-t">🎯 Daftar Event</div></div>
          <div class="pn-b" style="padding:0;">
            <div class="tbl-wrap">
              <table class="tbl">
                <thead><tr><th>Event</th><th>Tanggal</th><th>Status</th><th>Detail</th><th>Aksi</th></tr></thead>
                <tbody>
                  @forelse ($dashboardEvents as $event)
                    <tr>
                      <td>
                        <div class="u-cell">
                          <div style="width:36px;height:36px;border-radius:10px;background:rgba(26,110,245,.1);border:1px solid rgba(61,142,255,.3);display:flex;align-items:center;justify-content:center;font-size:17px">{{ $event->icon }}</div>
                          <div class="u-info">
                            <div class="u-n">{{ $event->name }}</div>
                            <div class="u-id">{{ $event->slug }}</div>
                          </div>
                        </div>
                      </td>
                      <td style="color:var(--text)">{{ $event->event_date->translatedFormat('d M Y') }}</td>
                      <td>
                        <span class="chip" style="{{ $event->status === 'live' ? 'background:rgba(255,68,68,.15);color:var(--red);border:1px solid rgba(255,68,68,.4)' : ($event->status === 'soon' ? 'background:rgba(245,200,66,.15);color:var(--gold);border:1px solid rgba(245,200,66,.3)' : 'background:rgba(30,80,160,.1);color:var(--text3);border:1px solid var(--border)') }}">{{ $event->status_label }}</span>
                      </td>
                      <td style="color:var(--text2)">{{ \Illuminate\Support\Str::limit($event->description, 52) }}</td>
                      <td>
                        <div class="tb-acts-row">
                          <button class="ta-btn" type="button" onclick="toast('Preview event dari dashboard.')">👁️</button>
                          <a href="{{ route('dashboard.community-events.edit', $event) }}" class="ta-btn">✏️</a>
                          <form method="POST" action="{{ route('dashboard.community-events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ta-btn dang">🗑️</button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="5" style="color:var(--text3);text-align:center;">Belum ada event di database.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- ══════════ OTHER PAGES (placeholder) ══════════ -->
      <div class="page" id="pg-analytics">
        <div class="ph"><div class="ph-l"><div class="ph-t">📈 Analytics</div><div class="ph-s">Deep insights tentang komunitas LYVA</div></div><div class="ph-r"><button class="btn btn-g">📥 Export PDF</button></div></div>
        <div class="stat-grid">
          <div class="st"><div class="st-top"><div class="st-ic ic-b">👁️</div><div class="st-tr tr-up">↑ 32%</div></div><div class="st-v">98.2K</div><div class="st-l">Page Views</div></div>
          <div class="st sg"><div class="st-top"><div class="st-ic ic-g">⏱️</div><div class="st-tr tr-up">↑ 8%</div></div><div class="st-v">4:32</div><div class="st-l">Avg Session</div></div>
          <div class="st st-e"><div class="st-top"><div class="st-ic ic-t">📱</div></div><div class="st-v">67%</div><div class="st-l">Mobile Users</div></div>
          <div class="st spk"><div class="st-top"><div class="st-ic ic-p">💫</div><div class="st-tr tr-up">↑ 15%</div></div><div class="st-v">89%</div><div class="st-l">Retention Rate</div></div>
        </div>
        <div class="pn"><div class="pn-h"><div class="pn-t">📊 Traffic Overview</div></div><div class="pn-b" style="text-align:center;padding:60px;color:var(--text3);">📊 Grafik analytics detail tersedia di versi full<br><br><span style="font-size:13px">Halaman ini untuk demo fitur</span></div></div>
      </div>

      <div class="page" id="pg-live">
        <div class="ph"><div class="ph-l"><div class="ph-t">🔴 Live Events</div><div class="ph-s">Pantau event yang sedang berlangsung</div></div></div>
        <div class="pn"><div class="pn-h"><div class="pn-t">⚔️ Mega Battle Tournament</div><span class="chip" style="background:rgba(255,68,68,.15);color:var(--red);border:1px solid rgba(255,68,68,.4)">🔴 LIVE</span></div><div class="pn-b">
          <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin-bottom:20px;">
            <div style="padding:16px;background:rgba(6,20,46,.5);border:1px solid var(--border);border-radius:12px;text-align:center"><div style="font-family:'Orbitron';font-size:24px;font-weight:900;color:var(--white)">342</div><div style="font-size:11px;color:var(--text3);letter-spacing:1.5px;text-transform:uppercase;margin-top:4px">Peserta Aktif</div></div>
            <div style="padding:16px;background:rgba(6,20,46,.5);border:1px solid var(--border);border-radius:12px;text-align:center"><div style="font-family:'Orbitron';font-size:24px;font-weight:900;color:var(--gold)">01:23:45</div><div style="font-size:11px;color:var(--text3);letter-spacing:1.5px;text-transform:uppercase;margin-top:4px">Waktu Tersisa</div></div>
            <div style="padding:16px;background:rgba(6,20,46,.5);border:1px solid var(--border);border-radius:12px;text-align:center"><div style="font-family:'Orbitron';font-size:24px;font-weight:900;color:var(--teal)">1,247</div><div style="font-size:11px;color:var(--text3);letter-spacing:1.5px;text-transform:uppercase;margin-top:4px">Penonton</div></div>
            <div style="padding:16px;background:rgba(6,20,46,.5);border:1px solid var(--border);border-radius:12px;text-align:center"><div style="font-family:'Orbitron';font-size:24px;font-weight:900;color:var(--pink)">4,892</div><div style="font-size:11px;color:var(--text3);letter-spacing:1.5px;text-transform:uppercase;margin-top:4px">Total Kills</div></div>
          </div>
          <div style="font-size:13px;color:var(--text2);line-height:1.7">Event sedang berjalan dengan baik. Top 3 saat ini: <b style="color:var(--white)">ThunderZ</b> (48 kills), <b style="color:var(--white)">DragonLord</b> (42 kills), <b style="color:var(--white)">AimBot99</b> (38 kills).</div>
        </div></div>
      </div>

      <div class="page" id="pg-rewards"><div class="ph"><div class="ph-l"><div class="ph-t">🎁 Reward Manager</div><div class="ph-s">Kelola hadiah dan bonus untuk member</div></div></div><div class="pn" style="padding:40px;text-align:center;color:var(--text3)">🎁 Halaman reward manager tersedia di versi full dashboard</div></div>
      <div class="page" id="pg-leaderboard"><div class="ph"><div class="ph-l"><div class="ph-t">🏆 Leaderboard</div><div class="ph-s">Ranking player tertinggi</div></div></div><div class="pn" style="padding:40px;text-align:center;color:var(--text3)">🏆 Fitur leaderboard detail tersedia di versi full</div></div>
      <div class="page" id="pg-chat"><div class="ph"><div class="ph-l"><div class="ph-t">💬 Chat Log</div><div class="ph-s">Monitor komunikasi komunitas</div></div></div><div class="pn" style="padding:40px;text-align:center;color:var(--text3)">💬 Fitur chat log tersedia di versi full</div></div>
      <div class="page" id="pg-announce"><div class="ph"><div class="ph-l"><div class="ph-t">📢 Pengumuman</div><div class="ph-s">Kelola broadcast ke komunitas</div></div></div><div class="pn" style="padding:40px;text-align:center;color:var(--text3)">📢 Fitur pengumuman tersedia di versi full</div></div>
      <div class="page" id="pg-reports"><div class="ph"><div class="ph-l"><div class="ph-t">🚨 Laporan</div><div class="ph-s">12 laporan menunggu review</div></div></div><div class="pn" style="padding:40px;text-align:center;color:var(--text3)">🚨 Fitur laporan tersedia di versi full</div></div>
      <div class="page" id="pg-settings"><div class="ph"><div class="ph-l"><div class="ph-t">⚙️ Pengaturan</div><div class="ph-s">Konfigurasi sistem dan komunitas</div></div></div><div class="pn" style="padding:40px;text-align:center;color:var(--text3)">⚙️ Fitur settings tersedia di versi full</div></div>
      <div class="page" id="pg-logs"><div class="ph"><div class="ph-l"><div class="ph-t">📋 Activity Log</div><div class="ph-s">Riwayat aktivitas admin</div></div></div><div class="pn" style="padding:40px;text-align:center;color:var(--text3)">📋 Fitur activity log tersedia di versi full</div></div>

    </div>
  </main>
</div>

<script>
/* STARS BG */
const cv=document.getElementById('starBg'),cx=cv.getContext('2d');
function rsz(){cv.width=window.innerWidth;cv.height=window.innerHeight;}rsz();window.addEventListener('resize',rsz);
const ST=Array.from({length:120},()=>({x:Math.random()*cv.width,y:Math.random()*cv.height,r:Math.random()*1.2+.2,a:Math.random(),da:Math.random()*.015+.003,d:Math.random()>.5?1:-1}));
const SH=[];
function spSH(){SH.push({x:Math.random()*cv.width*.72,y:Math.random()*cv.height*.5,len:Math.random()*100+60,spd:Math.random()*8+5,a:1,ang:Math.PI/4+(Math.random()-.5)*.4});}
setInterval(spSH,2800);
function frm(){cx.clearRect(0,0,cv.width,cv.height);ST.forEach(s=>{s.a+=s.da*s.d;if(s.a>1||s.a<.1)s.d*=-1;cx.beginPath();cx.arc(s.x,s.y,s.r,0,Math.PI*2);cx.fillStyle=`rgba(180,215,255,${s.a*.6})`;cx.fill();});for(let i=SH.length-1;i>=0;i--){const s=SH[i];const g=cx.createLinearGradient(s.x,s.y,s.x-Math.cos(s.ang)*s.len,s.y-Math.sin(s.ang)*s.len);g.addColorStop(0,`rgba(120,190,255,${s.a*.7})`);g.addColorStop(1,'rgba(0,0,0,0)');cx.beginPath();cx.moveTo(s.x,s.y);cx.lineTo(s.x-Math.cos(s.ang)*s.len,s.y-Math.sin(s.ang)*s.len);cx.strokeStyle=g;cx.lineWidth=1.5;cx.stroke();s.x+=Math.cos(s.ang)*s.spd;s.y+=Math.sin(s.ang)*s.spd;s.a-=.025;if(s.a<=0||s.x>cv.width||s.y>cv.height)SH.splice(i,1);}requestAnimationFrame(frm);}
frm();

/* COUNTERS */
function cnt(el,to){
  if(!el){return;}
  let n=0;
  const step=Math.max(to/60,1);
  const t=setInterval(()=>{
    n+=step;
    if(n>=to){
      n=to;
      clearInterval(t);
    }
    el.textContent=Math.floor(n).toLocaleString('en-US');
  },22);
}
window.addEventListener('load',()=>setTimeout(()=>{
  document.querySelectorAll('[data-counter-target]').forEach(el=>cnt(el,Number(el.dataset.counterTarget||0)));
  const page=new URLSearchParams(window.location.search).get('page');
  if(page&&document.getElementById('pg-'+page)){
    goPage(page);
  }
},400));

/* SIDEBAR */
function openSB(){document.getElementById('sb').classList.add('open');document.getElementById('sbOvl').classList.add('show');}
function closeSB(){document.getElementById('sb').classList.remove('open');document.getElementById('sbOvl').classList.remove('show');}

/* SIDEBAR SWIPE */
let sbTouchStartX=0;
let sbTouchCurrentX=0;
let sbTouching=false;
const sbEl=document.getElementById('sb');

function resetSidebarSwipe(){
  sbEl.style.transition='';
  sbEl.style.transform='';
}

sbEl.addEventListener('touchstart',e=>{
  if(window.innerWidth>900||!sbEl.classList.contains('open'))return;
  sbTouchStartX=e.touches[0].clientX;
  sbTouchCurrentX=sbTouchStartX;
  sbTouching=true;
  sbEl.style.transition='none';
},{passive:true});

sbEl.addEventListener('touchmove',e=>{
  if(!sbTouching)return;
  sbTouchCurrentX=e.touches[0].clientX;
  const deltaX=Math.min(0,sbTouchCurrentX-sbTouchStartX);
  sbEl.style.transform=`translateX(${deltaX}px)`;
},{passive:true});

sbEl.addEventListener('touchend',()=>{
  if(!sbTouching)return;
  const deltaX=sbTouchCurrentX-sbTouchStartX;
  sbTouching=false;

  if(deltaX<-70){
    resetSidebarSwipe();
    closeSB();
    return;
  }

  resetSidebarSwipe();
  if(window.innerWidth<=900){
    sbEl.classList.add('open');
  }
});

/* PAGE NAV */
const TITLES={dash:['📊 Dashboard','Selamat datang kembali, Admin!'],members:['👥 Member Manager','Kelola semua member'],shop:['🛒 Shop Manager','Kelola item eksklusif'],events:['🎉 Event Manager','Kelola event dan kompetisi'],analytics:['📈 Analytics','Deep insights komunitas'],live:['🔴 Live Events','Event sedang berlangsung'],rewards:['🎁 Rewards','Kelola reward member'],leaderboard:['🏆 Leaderboard','Ranking player'],chat:['💬 Chat Log','Monitor komunitas'],announce:['📢 Pengumuman','Broadcast komunitas'],reports:['🚨 Laporan','Review laporan user'],settings:['⚙️ Pengaturan','Konfigurasi sistem'],logs:['📋 Activity Log','Riwayat aktivitas']};
function goPage(p){
  document.querySelectorAll('.page').forEach(el=>el.classList.remove('active'));
  document.getElementById('pg-'+p).classList.add('active');
  document.querySelectorAll('.sb-item').forEach(el=>el.classList.remove('active'));
  document.querySelector(`.sb-item[data-page="${p}"]`).classList.add('active');
  if(TITLES[p]){document.getElementById('pageTitle').textContent=TITLES[p][0];document.getElementById('pageSub').textContent=TITLES[p][1];}
  closeSB();
  window.scrollTo({top:0,behavior:'smooth'});
}

/* NOTIFICATION */
function toggleNtf(){document.getElementById('ntfPanel').classList.toggle('open');}
document.addEventListener('click',e=>{const p=document.getElementById('ntfPanel');if(!p.contains(e.target)&&!e.target.closest('[onclick*="toggleNtf"]'))p.classList.remove('open');});
function markAllRead(){document.querySelectorAll('.ntf-i.unread').forEach(el=>el.classList.remove('unread'));toast('✅ Semua notifikasi ditandai dibaca');}

/* MODAL */
function om(id){document.getElementById(id).classList.add('open');}
function cm(id){document.getElementById(id).classList.remove('open');}
document.querySelectorAll('.mbg').forEach(m=>m.addEventListener('click',e=>{if(e.target===m)m.classList.remove('open');}));

/* TOAST */
let tt;
function toast(msg){clearTimeout(tt);document.getElementById('tMsg').textContent=msg;const t=document.getElementById('toast');t.classList.add('show');tt=setTimeout(()=>t.classList.remove('show'),3200);}

/* THEME TOGGLE */
let dark=true;
function toggleTheme(){toast(dark?'☀️ Light mode coming soon!':'🌙 Dark mode aktif');}

/* ACTIONS */
function addMember(){const n=document.getElementById('nuName').value.trim();if(!n){toast('⚠️ Masukkan username!');return;}cm('mUser');toast('✅ Member '+n+' berhasil ditambahkan!');document.getElementById('nuName').value='';}
function addEvent(){cm('mEvent');toast('🎉 Event baru berhasil dibuat!');}
function switchChart(el,t){el.parentElement.querySelectorAll('.pn-tab').forEach(e=>e.classList.remove('on'));el.classList.add('on');toast('📈 Chart diubah ke '+t.toUpperCase());}

/* CALENDAR */
function buildCal(){
  const heads=['M','S','S','R','K','J','S'];
  const evDays=[5,12,18,22,25,28,30];
  const today=18;
  const grid=document.getElementById('calGrid');
  let html='';
  heads.forEach(h=>html+=`<div class="cal-d head">${h}</div>`);
  // April has 30 days, starts on Monday (for demo)
  for(let i=1;i<=30;i++){
    const cls=['cal-d'];
    if(i===today)cls.push('today');
    if(evDays.includes(i))cls.push('ev');
    html+=`<div class="${cls.join(' ')}" onclick="toast('📅 Tanggal '+${i}+' April selected')">${i}</div>`;
  }
  grid.innerHTML=html;
}
buildCal();

/* KEYBOARD SHORTCUTS */
document.addEventListener('keydown',e=>{
  if((e.metaKey||e.ctrlKey)&&e.key==='k'){e.preventDefault();document.querySelector('.tb-search input').focus();}
  if(e.key==='Escape'){document.querySelectorAll('.mbg.open').forEach(m=>m.classList.remove('open'));closeSB();document.getElementById('ntfPanel').classList.remove('open');}
});
</script>
<script src="{{ asset('pwa-register.js') }}" defer></script>
</body>
</html>
