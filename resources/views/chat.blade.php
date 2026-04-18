<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>LYVA Chat — Live Community Chat</title>
<meta name="theme-color" content="#010714">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="LYVA Community">
<meta name="mobile-web-app-capable" content="yes">
<link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon-180.png') }}">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;700;900&family=Rajdhani:wght@500;600;700&family=Exo+2:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
  --mine:#1a6ef5;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html,body{height:100%;overflow:hidden;}
body{background:var(--bg0);color:var(--text);font-family:'Exo 2',sans-serif;line-height:1.5;font-size:14px;}
button{font-family:inherit;cursor:pointer;border:none;background:none;color:inherit;}
input,textarea{font-family:inherit;}
::-webkit-scrollbar{width:6px;height:6px;}
::-webkit-scrollbar-track{background:transparent;}
::-webkit-scrollbar-thumb{background:var(--border2);border-radius:3px;}
::-webkit-scrollbar-thumb:hover{background:var(--border3);}

/* STARS */
#starBg{position:fixed;inset:0;z-index:0;pointer-events:none;opacity:.35;}

/* ═══ APP LAYOUT ═══ */
.app{display:flex;height:100vh;position:relative;z-index:1;}

/* ═══ SIDEBAR ═══ */
.sb{
  width:280px;flex-shrink:0;
  background:linear-gradient(180deg,var(--side),var(--bg1));
  border-right:1px solid var(--border);
  display:flex;flex-direction:column;
  transition:transform .35s cubic-bezier(.4,0,.2,1);
}
.sb-head{padding:18px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px;}
.sb-logo{width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,var(--accent),var(--accent3));display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 0 18px var(--glow);overflow:hidden;padding:7px;}
.sb-logo img,.mlogo img{width:100%;height:100%;object-fit:contain;display:block;filter:drop-shadow(0 0 8px rgba(255,255,255,.18));}
.sb-brand{flex:1;}
.sb-name{font-family:'Orbitron',monospace;font-size:17px;font-weight:900;color:var(--white);letter-spacing:3px;text-shadow:0 0 12px var(--accent);}
.sb-sub{font-size:9.5px;color:var(--accent3);letter-spacing:2px;margin-top:-2px;text-transform:uppercase;}

/* CHANNELS */
.sb-section{padding:18px 16px 8px;font-size:10px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--text3);}
.sb-ch{display:flex;align-items:center;gap:10px;padding:10px 14px;margin:0 8px 2px;border-radius:9px;color:var(--text2);font-size:13.5px;font-weight:500;cursor:pointer;transition:all .2s;position:relative;}
.sb-ch:hover{background:rgba(26,110,245,.08);color:var(--text);}
.sb-ch.active{background:linear-gradient(90deg,rgba(26,110,245,.22),rgba(26,110,245,.04));color:var(--white);font-weight:600;box-shadow:inset 2px 0 0 var(--accent);}
.sb-ch.active::before{content:'';position:absolute;left:-8px;top:50%;transform:translateY(-50%);width:3px;height:55%;background:var(--accent2);border-radius:0 3px 3px 0;box-shadow:0 0 10px var(--accent);}
.ch-ic{font-size:16px;flex-shrink:0;width:20px;text-align:center;}
.ch-l{flex:1;}
.ch-bd{font-size:10px;font-weight:800;padding:2px 7px;border-radius:50px;background:var(--pink);color:#fff;}
.ch-bd.live{background:var(--red);animation:bLive 1.5s infinite;}
@keyframes bLive{0%,100%{box-shadow:0 0 0 0 rgba(255,68,68,.5);}50%{box-shadow:0 0 0 5px rgba(255,68,68,0);}}

/* ONLINE LIST */
.sb-online{padding:14px 16px;flex:1;overflow-y:auto;border-top:1px solid var(--border);margin-top:8px;}
.sb-oh{display:flex;align-items:center;gap:6px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--text3);margin-bottom:10px;}
.sb-oh .dot-live{width:6px;height:6px;border-radius:50%;background:var(--green);box-shadow:0 0 6px var(--green);animation:pulse 2s infinite;}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}
.sb-on-count{font-size:11px;color:var(--green);margin-left:auto;}
.ou{display:flex;align-items:center;gap:10px;padding:7px 10px;border-radius:8px;transition:background .2s;cursor:pointer;margin-bottom:2px;}
.ou:hover{background:rgba(26,110,245,.08);}
.ou-av{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;border:1.5px solid var(--border2);flex-shrink:0;position:relative;background:rgba(26,110,245,.08);}
.ou-av.me{background:linear-gradient(135deg,var(--accent),var(--accent3));border-color:var(--accent2);box-shadow:0 0 10px var(--glow);}
.ou-on{position:absolute;bottom:-2px;right:-2px;width:10px;height:10px;border-radius:50%;background:var(--green);border:2px solid var(--side);}
.ou-n{flex:1;min-width:0;font-size:12.5px;font-weight:500;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.ou-n b{color:var(--white);}
.ou-role{font-size:9px;letter-spacing:1px;padding:2px 6px;border-radius:50px;text-transform:uppercase;font-weight:700;flex-shrink:0;}
.r-own{background:rgba(245,200,66,.15);color:var(--gold);}
.r-adm{background:rgba(255,79,163,.12);color:var(--pink);}
.r-mod{background:rgba(26,110,245,.12);color:var(--accent3);}
.r-me{background:linear-gradient(135deg,var(--accent),var(--accent3));color:#fff;}

/* SB FOOTER */
.sb-foot{padding:12px;border-top:1px solid var(--border);}
.me-box{display:flex;align-items:center;gap:10px;padding:10px;border-radius:11px;background:rgba(26,110,245,.08);border:1px solid var(--border);cursor:pointer;transition:all .2s;}
.me-box:hover{background:rgba(26,110,245,.15);}
.me-av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent3));display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;position:relative;box-shadow:0 0 12px var(--glow);}
.me-av::after{content:'';position:absolute;bottom:-1px;right:-1px;width:10px;height:10px;border-radius:50%;background:var(--green);border:2px solid var(--side);}
.me-info{flex:1;min-width:0;}
.me-n{font-size:13px;font-weight:700;color:var(--white);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.me-s{font-size:10.5px;color:var(--green);letter-spacing:.5px;}
.me-edit{font-size:13px;color:var(--text3);padding:6px;border-radius:7px;}
.me-edit:hover{background:rgba(26,110,245,.15);color:var(--accent3);}

/* ═══ MAIN CHAT ═══ */
.chat{flex:1;display:flex;flex-direction:column;min-width:0;background:var(--bg0);}

/* CHAT HEAD */
.ch-head{
  display:flex;align-items:center;gap:14px;
  padding:0 clamp(16px,3vw,24px);height:64px;
  background:rgba(1,7,20,.85);backdrop-filter:blur(22px);
  border-bottom:1px solid var(--border);flex-shrink:0;z-index:20;
}
.ch-burger{display:none;width:38px;height:38px;border-radius:9px;background:var(--card);border:1px solid var(--border);align-items:center;justify-content:center;font-size:17px;color:var(--text2);}
.ch-burger:hover{background:var(--card2);color:var(--white);}
.ch-icon{width:42px;height:42px;border-radius:12px;background:rgba(26,110,245,.12);border:1px solid var(--border2);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
.ch-title{flex:1;min-width:0;}
.ch-t{font-family:'Rajdhani',sans-serif;font-size:18px;font-weight:700;color:var(--white);letter-spacing:.5px;display:flex;align-items:center;gap:8px;}
.ch-lbd{font-size:10px;font-weight:800;padding:2px 8px;border-radius:50px;background:var(--red);color:#fff;letter-spacing:1px;animation:bLive 1.5s infinite;}
.ch-s{font-size:11.5px;color:var(--text3);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.ch-acts{display:flex;gap:6px;align-items:center;flex-shrink:0;}
.ch-btn{width:38px;height:38px;border-radius:9px;background:var(--card);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--text2);transition:all .22s;}
.ch-btn:hover{background:var(--card2);border-color:var(--border2);color:var(--white);}

/* MESSAGES AREA */
.msgs{
  flex:1;overflow-y:auto;overflow-x:hidden;
  padding:20px clamp(16px,3vw,32px);
  display:flex;flex-direction:column;gap:2px;
  scroll-behavior:smooth;
}
.msgs::-webkit-scrollbar{width:5px;}

/* WELCOME BANNER */
.welcome{
  text-align:center;padding:32px 20px 26px;
  border-bottom:1px solid var(--border);margin-bottom:14px;
}
.welcome-ic{font-size:42px;margin-bottom:10px;}
.welcome-t{font-family:'Orbitron',monospace;font-size:20px;font-weight:700;color:var(--white);letter-spacing:2px;margin-bottom:6px;text-shadow:0 0 18px var(--glow);}
.welcome-s{font-size:13px;color:var(--text2);line-height:1.6;max-width:440px;margin:0 auto;}

/* DAY SEPARATOR */
.day-sep{display:flex;align-items:center;gap:12px;margin:20px 0 14px;color:var(--text3);font-size:10.5px;font-weight:700;letter-spacing:2px;text-transform:uppercase;}
.day-sep::before,.day-sep::after{content:'';flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--border2),transparent);}

/* MESSAGE ITEM */
.msg{
  display:flex;gap:11px;padding:4px 8px;
  border-radius:10px;transition:background .15s;
  animation:msgIn .3s cubic-bezier(.34,1.1,.64,1);
  max-width:100%;
}
@keyframes msgIn{from{opacity:0;transform:translateY(6px);}to{opacity:1;transform:translateY(0);}}
.msg:hover{background:rgba(26,110,245,.04);}
.msg.mine{flex-direction:row-reverse;}

/* AVATAR */
.msg-av{
  width:38px;height:38px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-size:17px;flex-shrink:0;border:1.5px solid var(--border2);
  background:rgba(26,110,245,.1);
}
.msg-av.c-gold{background:rgba(245,200,66,.14);border-color:rgba(245,200,66,.45);}
.msg-av.c-pink{background:rgba(255,79,163,.12);border-color:rgba(255,79,163,.4);}
.msg-av.c-teal{background:rgba(0,229,184,.12);border-color:rgba(0,229,184,.4);}
.msg-av.c-purple{background:rgba(168,85,247,.12);border-color:rgba(168,85,247,.4);}
.msg-av.c-orange{background:rgba(255,140,66,.12);border-color:rgba(255,140,66,.4);}
.msg-av.c-green{background:rgba(34,197,94,.12);border-color:rgba(34,197,94,.4);}

/* CONTENT */
.msg-body{flex:1;min-width:0;max-width:calc(100% - 60px);}
.msg.mine .msg-body{display:flex;flex-direction:column;align-items:flex-end;}
.msg-meta{display:flex;align-items:center;gap:8px;margin-bottom:3px;flex-wrap:wrap;}
.msg.mine .msg-meta{justify-content:flex-end;}
.msg-nm{font-family:'Rajdhani',sans-serif;font-size:14.5px;font-weight:700;color:var(--white);}
.msg-nm.nm-owner{color:var(--gold);}
.msg-nm.nm-admin{color:var(--pink);}
.msg-nm.nm-mod{color:var(--accent3);}
.msg-nm.nm-pro{color:#c084fc;}
.msg-role{font-size:9px;font-weight:800;padding:2px 7px;border-radius:50px;letter-spacing:1px;text-transform:uppercase;}
.msg-tm{font-size:10.5px;color:var(--text3);letter-spacing:.5px;}

/* BUBBLE */
.msg-bubble{
  display:inline-block;padding:9px 14px;
  background:var(--card);border:1px solid var(--border);
  border-radius:4px 14px 14px 14px;
  font-size:14px;line-height:1.5;color:var(--text);
  word-wrap:break-word;word-break:break-word;
  max-width:100%;position:relative;
}
.msg.mine .msg-bubble{
  background:linear-gradient(135deg,var(--accent),#0c49c7);
  color:#fff;border-color:var(--accent);
  border-radius:14px 4px 14px 14px;
  box-shadow:0 4px 14px rgba(26,110,245,.25);
}
.msg-bubble .mention{
  background:rgba(26,110,245,.2);color:var(--accent3);
  padding:1px 5px;border-radius:4px;font-weight:600;
}
.msg.mine .msg-bubble .mention{background:rgba(255,255,255,.2);color:#fff;}
.msg-bubble .emoji-big{font-size:38px;line-height:1.2;}

/* SYSTEM MESSAGE */
.msg-sys{
  text-align:center;margin:12px 0;font-size:12px;color:var(--text3);
  background:rgba(26,110,245,.05);border:1px solid var(--border);
  border-radius:50px;padding:6px 16px;display:inline-flex;align-self:center;gap:6px;
}
.msg-sys-wrap{display:flex;justify-content:center;}
.msg-sys.join{color:var(--green);border-color:rgba(34,197,94,.25);background:rgba(34,197,94,.05);}

/* REACTIONS */
.msg-reacts{display:flex;gap:4px;margin-top:5px;flex-wrap:wrap;}
.msg.mine .msg-reacts{justify-content:flex-end;}
.rc{display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:50px;background:var(--card2);border:1px solid var(--border);font-size:11px;cursor:pointer;transition:all .2s;user-select:none;}
.rc:hover{border-color:var(--border2);transform:scale(1.08);}
.rc.active{background:rgba(26,110,245,.15);border-color:var(--accent2);color:var(--accent3);}
.rc-n{font-weight:700;}

/* HOVER ACTIONS */
.msg-hover{
  position:absolute;top:-8px;right:8px;
  background:var(--card2);border:1px solid var(--border);
  border-radius:10px;padding:3px;gap:1px;display:none;
  box-shadow:0 4px 12px rgba(0,0,0,.4);z-index:5;
}
.msg:hover .msg-hover{display:flex;}
.msg.mine .msg-hover{right:auto;left:8px;}
.mh-btn{width:26px;height:26px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--text2);transition:all .15s;}
.mh-btn:hover{background:var(--card3);color:var(--white);}
.msg-bubble{position:relative;}

/* TYPING INDICATOR */
.typing{padding:4px 20px;color:var(--text3);font-size:12px;font-style:italic;height:24px;display:flex;align-items:center;gap:6px;}
.typing.show{}
.typing-dots{display:inline-flex;gap:3px;}
.typing-dots span{width:4px;height:4px;border-radius:50%;background:var(--accent3);animation:td 1.2s infinite;}
.typing-dots span:nth-child(2){animation-delay:.15s;}
.typing-dots span:nth-child(3){animation-delay:.3s;}
@keyframes td{0%,60%,100%{opacity:.3;transform:translateY(0);}30%{opacity:1;transform:translateY(-3px);}}

/* ═══ INPUT AREA ═══ */
.input-area{
  padding:12px clamp(12px,2.5vw,22px) 14px;
  background:var(--bg1);
  border-top:1px solid var(--border);
  flex-shrink:0;
}
.reply-bar{
  display:none;align-items:center;gap:10px;
  padding:8px 14px;margin-bottom:8px;
  background:rgba(26,110,245,.08);
  border:1px solid var(--border2);
  border-radius:10px;
  border-left:3px solid var(--accent);
}
.reply-bar.show{display:flex;animation:msgIn .2s ease;}
.reply-ic{color:var(--accent3);font-size:13px;}
.reply-txt{flex:1;font-size:12px;color:var(--text2);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.reply-txt b{color:var(--accent3);}
.reply-x{width:24px;height:24px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:12px;color:var(--text3);}
.reply-x:hover{background:rgba(255,68,68,.15);color:var(--red);}

.input-box{
  display:flex;align-items:flex-end;gap:8px;
  background:var(--card);border:1px solid var(--border);
  border-radius:14px;padding:6px 6px 6px 12px;
  transition:border-color .2s,box-shadow .2s;
}
.input-box:focus-within{border-color:var(--accent2);box-shadow:0 0 0 3px rgba(26,110,245,.1);}

.in-btn{
  width:36px;height:36px;border-radius:9px;
  display:flex;align-items:center;justify-content:center;
  font-size:17px;color:var(--text2);transition:all .2s;flex-shrink:0;
}
.in-btn:hover{background:rgba(26,110,245,.12);color:var(--accent3);}

.msg-input{
  flex:1;min-height:24px;max-height:140px;
  background:transparent;border:none;outline:none;
  color:var(--text);font-family:'Exo 2',sans-serif;
  font-size:14px;line-height:1.55;resize:none;
  padding:8px 4px;
}
.msg-input::placeholder{color:var(--text3);}

.send-btn{
  width:40px;height:40px;border-radius:10px;
  background:linear-gradient(135deg,var(--accent),#0c49c7);
  color:#fff;display:flex;align-items:center;justify-content:center;
  font-size:17px;box-shadow:0 0 14px rgba(26,110,245,.35);
  transition:all .22s;flex-shrink:0;
}
.send-btn:hover{transform:scale(1.06);box-shadow:0 0 22px rgba(26,110,245,.6);}
.send-btn:disabled{opacity:.4;cursor:not-allowed;transform:none;box-shadow:none;}

.input-foot{
  display:flex;align-items:center;justify-content:space-between;
  margin-top:6px;padding:0 6px;font-size:11px;color:var(--text3);
}
.input-foot kbd{background:var(--card2);padding:2px 5px;border-radius:4px;font-size:10px;border:1px solid var(--border);font-family:inherit;}

/* EMOJI PICKER */
.emoji-pick{
  position:absolute;bottom:80px;left:20px;
  background:linear-gradient(160deg,rgba(10,28,58,.99),rgba(7,16,38,1));
  border:1px solid var(--border2);border-radius:14px;
  padding:12px;z-index:100;
  box-shadow:0 10px 30px rgba(0,0,0,.5);
  display:none;flex-direction:column;gap:8px;
  max-width:min(340px,calc(100vw - 40px));
  animation:msgIn .2s ease;
}
.emoji-pick.show{display:flex;}
.em-cat{display:flex;gap:4px;padding-bottom:8px;border-bottom:1px solid var(--border);flex-wrap:wrap;}
.em-cat-btn{padding:4px 8px;border-radius:6px;font-size:14px;transition:all .15s;}
.em-cat-btn:hover,.em-cat-btn.on{background:rgba(26,110,245,.15);}
.em-list{display:grid;grid-template-columns:repeat(8,1fr);gap:2px;max-height:180px;overflow-y:auto;}
.em-btn{width:32px;height:32px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:19px;transition:all .15s;}
.em-btn:hover{background:rgba(26,110,245,.15);transform:scale(1.15);}

/* NAME MODAL */
.mbg{position:fixed;inset:0;z-index:9800;background:rgba(0,0,0,.82);backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .3s;}
.mbg.open{opacity:1;pointer-events:all;}
.mbox{background:linear-gradient(160deg,rgba(10,28,58,.99),rgba(7,16,38,1));border:1px solid var(--border2);border-radius:20px;padding:clamp(26px,4vw,38px);width:100%;max-width:420px;position:relative;box-shadow:0 30px 80px rgba(0,0,0,.7);transform:translateY(20px) scale(.97);transition:transform .35s cubic-bezier(.34,1.1,.64,1);text-align:center;}
.mbg.open .mbox{transform:translateY(0) scale(1);}
.mlogo{width:60px;height:60px;margin:0 auto 16px;border-radius:16px;background:linear-gradient(135deg,var(--accent),var(--accent3));display:flex;align-items:center;justify-content:center;box-shadow:0 0 25px var(--glow);overflow:hidden;padding:10px;}
.mt{font-family:'Orbitron',monospace;font-size:22px;font-weight:700;color:var(--white);letter-spacing:2px;margin-bottom:8px;text-shadow:0 0 15px var(--glow);}
.ms{font-size:13.5px;color:var(--text2);line-height:1.65;margin-bottom:22px;}
.mi-group{text-align:left;margin-bottom:14px;}
.mlb{display:block;font-size:10.5px;font-weight:700;letter-spacing:1.8px;text-transform:uppercase;color:var(--text3);margin-bottom:6px;}
.mi{width:100%;background:rgba(6,20,46,.85);border:1px solid var(--border);border-radius:11px;padding:13px 15px;color:var(--text);font-size:14px;outline:none;transition:all .25s;}
.mi:focus{border-color:var(--accent2);box-shadow:0 0 0 3px rgba(26,110,245,.12);}
.mi::placeholder{color:var(--text3);}

.avatar-pick{display:grid;grid-template-columns:repeat(6,1fr);gap:6px;padding:10px;background:rgba(6,20,46,.5);border:1px solid var(--border);border-radius:11px;}
.ap-item{aspect-ratio:1;display:flex;align-items:center;justify-content:center;font-size:20px;border-radius:9px;border:2px solid transparent;transition:all .2s;cursor:pointer;background:var(--card);}
.ap-item:hover{background:var(--card2);transform:scale(1.1);}
.ap-item.sel{background:rgba(26,110,245,.2);border-color:var(--accent2);box-shadow:0 0 10px var(--glow);transform:scale(1.05);}

.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 22px;border-radius:11px;font-family:'Exo 2',sans-serif;font-weight:700;font-size:13px;letter-spacing:1.2px;text-transform:uppercase;transition:all .25s;border:1px solid transparent;width:100%;margin-top:20px;}
.btn-p{background:linear-gradient(135deg,var(--accent),#0c49c7);color:#fff;box-shadow:0 0 20px rgba(26,110,245,.4);}
.btn-p:hover{transform:translateY(-2px);box-shadow:0 0 32px rgba(26,110,245,.6);}

/* TOAST */
.toast{position:fixed;top:80px;right:20px;z-index:9900;background:rgba(10,26,55,.97);border:1px solid var(--accent);border-radius:12px;padding:11px 16px;display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:var(--text);box-shadow:0 8px 28px rgba(0,0,0,.5);transform:translateX(calc(100% + 30px));transition:transform .4s cubic-bezier(.34,1.2,.64,1);max-width:min(320px,calc(100vw - 40px));}
.toast.show{transform:translateX(0);}

/* OVERLAY */
.sb-ovl{display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:499;opacity:0;transition:opacity .3s;}
.sb-ovl.show{display:block;opacity:1;}

/* RESPONSIVE */
@media(max-width:780px){
  .sb{position:fixed;top:0;left:0;bottom:0;z-index:500;transform:translateX(-100%);box-shadow:6px 0 28px rgba(0,0,0,.5);}
  .sb.open{transform:translateX(0);}
  .ch-burger{display:flex;}
}
@media(max-width:480px){
  .sb{width:86vw;}
  .ch-head{gap:9px;padding:0 12px;height:60px;}
  .ch-icon{width:36px;height:36px;font-size:17px;border-radius:11px;}
  .ch-t{font-size:15px;gap:6px;}
  .ch-s{font-size:10.5px;}
  .ch-acts{gap:4px;}
  .ch-btn{width:32px;height:32px;font-size:14px;border-radius:8px;}
  .msg-av{width:34px;height:34px;font-size:15px;}
  .msg-bubble{font-size:13.5px;padding:8px 12px;}
  .msgs{padding:16px 12px;}
  .input-area{padding:10px 12px 12px;}
  .em-list{grid-template-columns:repeat(7,1fr);}
  .welcome-t{font-size:17px;}
}
</style>
</head>
<body>

<canvas id="starBg"></canvas>

<div class="toast" id="toast"><span id="tIcon">✅</span><span id="tMsg">Ok!</span></div>

<!-- NAME MODAL -->
<div class="mbg" id="nameModal">
  <div class="mbox">
    <div class="mlogo">
      <img src="{{ asset('lyva-navbar-logo.png') }}" alt="LYVA Community">
    </div>
    <div class="mt">LYVA CHAT</div>
    <div class="ms">Selamat datang! Pilih username & avatar kamu untuk bergabung dengan live chat komunitas.</div>

    <div class="mi-group">
      <label class="mlb">👤 Username kamu</label>
      <input type="text" class="mi" id="inpName" placeholder="Contoh: StarPlayer_X" maxlength="20">
    </div>

    <div class="mi-group">
      <label class="mlb">🎨 Pilih avatar</label>
      <div class="avatar-pick" id="avPick">
        <div class="ap-item sel" data-av="🎮">🎮</div>
        <div class="ap-item" data-av="⚡">⚡</div>
        <div class="ap-item" data-av="🐉">🐉</div>
        <div class="ap-item" data-av="🦊">🦊</div>
        <div class="ap-item" data-av="🌙">🌙</div>
        <div class="ap-item" data-av="🌸">🌸</div>
        <div class="ap-item" data-av="👑">👑</div>
        <div class="ap-item" data-av="🛡️">🛡️</div>
        <div class="ap-item" data-av="🎯">🎯</div>
        <div class="ap-item" data-av="🔥">🔥</div>
        <div class="ap-item" data-av="💎">💎</div>
        <div class="ap-item" data-av="🚀">🚀</div>
        <div class="ap-item" data-av="🌺">🌺</div>
        <div class="ap-item" data-av="🐺">🐺</div>
        <div class="ap-item" data-av="🦁">🦁</div>
        <div class="ap-item" data-av="🤖">🤖</div>
        <div class="ap-item" data-av="👻">👻</div>
        <div class="ap-item" data-av="🧙">🧙</div>
      </div>
    </div>

    <button class="btn btn-p" onclick="joinChat()">🚀 Masuk ke Chat</button>
    <div style="font-size:11px;color:var(--text3);margin-top:12px;line-height:1.5">⚠️ Pesan tersimpan dan dapat dilihat oleh semua user LYVA</div>
  </div>
</div>

<div class="app">
  <!-- SIDEBAR -->
  <aside class="sb" id="sb">
    <div class="sb-head">
      <div class="sb-logo">
        <img src="{{ asset('lyva-navbar-logo.png') }}" alt="LYVA Community">
      </div>
      <div class="sb-brand">
        <div class="sb-name">LYVA</div>
        <div class="sb-sub">Community Chat</div>
      </div>
    </div>

    <div class="sb-section">💬 Channels</div>
    <div class="sb-ch active"><span class="ch-ic">#</span><span class="ch-l">general</span><span class="ch-bd live">LIVE</span></div>
    <div class="sb-ch" onclick="toast('📢 Channel ini view-only!')"><span class="ch-ic">📢</span><span class="ch-l">announcements</span></div>
    <div class="sb-ch" onclick="toast('⚔️ Channel coming soon!')"><span class="ch-ic">⚔️</span><span class="ch-l">mega-battle</span></div>
    <div class="sb-ch" onclick="toast('🛒 Channel coming soon!')"><span class="ch-ic">🛒</span><span class="ch-l">shop-chat</span></div>
    <div class="sb-ch" onclick="toast('🎉 Channel coming soon!')"><span class="ch-ic">🎉</span><span class="ch-l">events</span></div>
    <div class="sb-ch" onclick="toast('😂 Channel coming soon!')"><span class="ch-ic">😂</span><span class="ch-l">memes</span></div>
    <div class="sb-ch" onclick="toast('❓ Channel coming soon!')"><span class="ch-ic">❓</span><span class="ch-l">help</span></div>

    <div class="sb-online">
      <div class="sb-oh">
        <div class="dot-live"></div>
        <span>Online</span>
        <span class="sb-on-count" id="onCount">1</span>
      </div>
      <div id="onlineList"></div>
    </div>

    <div class="sb-foot">
      <div class="me-box" onclick="changeProfile()">
        <div class="me-av" id="meAv">🎮</div>
        <div class="me-info">
          <div class="me-n" id="meName">Guest</div>
          <div class="me-s">● Online</div>
        </div>
        <div class="me-edit">✏️</div>
      </div>
    </div>
  </aside>

  <div class="sb-ovl" id="sbOvl" onclick="closeSB()"></div>

  <!-- CHAT MAIN -->
  <main class="chat">
    <div class="ch-head">
      <button class="ch-burger" onclick="openSB()">☰</button>
      <div class="ch-icon">#</div>
      <div class="ch-title">
        <div class="ch-t">general <span class="ch-lbd">LIVE</span></div>
        <div class="ch-s" id="chSub">💬 Chat umum komunitas • <span id="onlineTxt">1 online</span></div>
      </div>
      <div class="ch-acts">
        <button class="ch-btn" onclick="toast('🔍 Search coming soon!')" title="Search">🔍</button>
        <button class="ch-btn" onclick="toast('📌 Pinned messages')" title="Pin">📌</button>
        <button class="ch-btn" onclick="refreshChat()" title="Refresh">🔄</button>
      </div>
    </div>

    <div class="msgs" id="msgsList">
      <!-- msgs injected by JS -->
    </div>

    <div class="typing" id="typing"></div>

    <div class="input-area">
      <div class="emoji-pick" id="emojiPick">
        <div class="em-cat">
          <div class="em-cat-btn on" data-cat="smile">😀</div>
          <div class="em-cat-btn" data-cat="love">❤️</div>
          <div class="em-cat-btn" data-cat="game">🎮</div>
          <div class="em-cat-btn" data-cat="anim">🐉</div>
          <div class="em-cat-btn" data-cat="obj">🔥</div>
        </div>
        <div class="em-list" id="emList"></div>
      </div>

      <div class="reply-bar" id="replyBar">
        <span class="reply-ic">↩️</span>
        <div class="reply-txt" id="replyTxt"></div>
        <button class="reply-x" onclick="cancelReply()">✕</button>
      </div>

      <div class="input-box">
        <button class="in-btn" onclick="toggleEmoji()" title="Emoji">😊</button>
        <button class="in-btn" onclick="toast('📎 Attachment coming soon!')" title="Attach">📎</button>
        <textarea class="msg-input" id="msgInput" placeholder="Ketik pesan di #general..." rows="1"></textarea>
        <button class="send-btn" id="sendBtn" onclick="sendMsg()" title="Kirim (Enter)">➤</button>
      </div>
      <div class="input-foot">
        <div>💡 Tekan <kbd>Enter</kbd> kirim • <kbd>Shift + Enter</kbd> baris baru</div>
        <div id="charCount" style="color:var(--text3)">0 / 500</div>
      </div>
    </div>
  </main>
</div>

<script>
/* ══════════════ STARS BG ══════════════ */
const cv=document.getElementById('starBg'),cx=cv.getContext('2d');
function rsz(){cv.width=window.innerWidth;cv.height=window.innerHeight;}rsz();window.addEventListener('resize',rsz);
const ST=Array.from({length:100},()=>({x:Math.random()*cv.width,y:Math.random()*cv.height,r:Math.random()*1.2+.2,a:Math.random(),da:Math.random()*.015+.003,d:Math.random()>.5?1:-1}));
const SH=[];
function spSH(){SH.push({x:Math.random()*cv.width*.72,y:Math.random()*cv.height*.5,len:Math.random()*100+60,spd:Math.random()*8+5,a:1,ang:Math.PI/4+(Math.random()-.5)*.4});}
setInterval(spSH,3500);
function frm(){cx.clearRect(0,0,cv.width,cv.height);ST.forEach(s=>{s.a+=s.da*s.d;if(s.a>1||s.a<.1)s.d*=-1;cx.beginPath();cx.arc(s.x,s.y,s.r,0,Math.PI*2);cx.fillStyle=`rgba(180,215,255,${s.a*.55})`;cx.fill();});for(let i=SH.length-1;i>=0;i--){const s=SH[i];const g=cx.createLinearGradient(s.x,s.y,s.x-Math.cos(s.ang)*s.len,s.y-Math.sin(s.ang)*s.len);g.addColorStop(0,`rgba(120,190,255,${s.a*.6})`);g.addColorStop(1,'rgba(0,0,0,0)');cx.beginPath();cx.moveTo(s.x,s.y);cx.lineTo(s.x-Math.cos(s.ang)*s.len,s.y-Math.sin(s.ang)*s.len);cx.strokeStyle=g;cx.lineWidth=1.3;cx.stroke();s.x+=Math.cos(s.ang)*s.spd;s.y+=Math.sin(s.ang)*s.spd;s.a-=.025;if(s.a<=0||s.x>cv.width||s.y>cv.height)SH.splice(i,1);}requestAnimationFrame(frm);}frm();

/* ══════════════ STATE ══════════════ */
const CHAT_BOOTSTRAP=@json($chatBootstrap ?? []);
const CHAT_ROUTES={
  state:@json(route('chat.state')),
  store:@json(route('chat.store')),
  messagesBase:@json(url('/chat/messages')),
};
const CSRF_TOKEN=document.querySelector('meta[name="csrf-token"]')?.content||'';

let ME=CHAT_BOOTSTRAP.currentUser||null;
let MSGS=Array.isArray(CHAT_BOOTSTRAP.messages)?CHAT_BOOTSTRAP.messages:[];
let ONLINE_USERS=Array.isArray(CHAT_BOOTSTRAP.onlineUsers)?CHAT_BOOTSTRAP.onlineUsers:[];
let REPLY_TO=null;
let POLL_TIMER=null;
let tt;
let LAST_MESSAGES_SIG='';
let LAST_ONLINE_SIG='';
let LAST_ME_SIG='';

async function api(url,{method='GET',body}={}){
  const options={
    method,
    credentials:'same-origin',
    headers:{
      'Accept':'application/json',
      'X-Requested-With':'XMLHttpRequest',
      'X-CSRF-TOKEN':CSRF_TOKEN,
    },
  };

  if(body!==undefined){
    options.headers['Content-Type']='application/json';
    options.body=JSON.stringify(body);
  }

  const response=await fetch(url,options);
  let data={};
  try{data=await response.json();}catch(e){}

  if(!response.ok){
    throw new Error(data.message||'Request gagal diproses');
  }

  return data;
}

function syncMeCard(){
  if(!ME)return;
  document.getElementById('meName').textContent=ME.name||'Discord User';
  document.getElementById('meAv').textContent=ME.avatar||'🎮';
}

function stateSig(value){
  try{return JSON.stringify(value??null);}catch(error){return String(Date.now());}
}

function applyState(data){
  const nextMe=data.currentUser||ME;
  const nextMessages=Array.isArray(data.messages)?data.messages:MSGS;
  const nextOnlineUsers=Array.isArray(data.onlineUsers)?data.onlineUsers:ONLINE_USERS;
  const meSig=stateSig(nextMe);
  const messagesSig=stateSig(nextMessages);
  const onlineSig=stateSig(nextOnlineUsers);

  const meChanged=meSig!==LAST_ME_SIG;
  const messagesChanged=messagesSig!==LAST_MESSAGES_SIG;
  const onlineChanged=onlineSig!==LAST_ONLINE_SIG;

  ME=nextMe;
  MSGS=nextMessages;
  ONLINE_USERS=nextOnlineUsers;

  if(meChanged){
    syncMeCard();
    LAST_ME_SIG=meSig;
  }

  if(messagesChanged){
    renderMsgs();
    LAST_MESSAGES_SIG=messagesSig;
  }

  if(onlineChanged){
    renderOnline(ONLINE_USERS);
    LAST_ONLINE_SIG=onlineSig;
  }
}

async function fetchState({showError=false}={}){
  try{
    const data=await api(CHAT_ROUTES.state);
    applyState(data);
  }catch(error){
    if(showError)toast('⚠️ '+error.message);
  }
}

/* ══════════════ MSG RENDERING ══════════════ */
function formatTime(ts){
  const d=new Date(ts),n=new Date();
  const sameDay=d.toDateString()===n.toDateString();
  const hh=String(d.getHours()).padStart(2,'0');
  const mm=String(d.getMinutes()).padStart(2,'0');
  if(sameDay)return hh+':'+mm;
  return d.toLocaleDateString('id',{day:'numeric',month:'short'})+' '+hh+':'+mm;
}
function dayLabel(ts){
  const d=new Date(ts),n=new Date();
  const sameDay=d.toDateString()===n.toDateString();
  if(sameDay)return '— Hari Ini —';
  const y=new Date(n);y.setDate(y.getDate()-1);
  if(d.toDateString()===y.toDateString())return '— Kemarin —';
  return '— '+d.toLocaleDateString('id',{day:'numeric',month:'long',year:'numeric'})+' —';
}
function escHtml(s){return String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));}
function parseMsg(t){
  let h=escHtml(t);
  h=h.replace(/@(\w+)/g,'<span class="mention">@$1</span>');
  const trim=String(t).trim();
  const emojiOnly=/^(\p{Extended_Pictographic}\uFE0F?|\p{Emoji_Presentation}|\p{Emoji}\u200D?)+$/u.test(trim);
  if(emojiOnly&&trim.length<=6)return '<span class="emoji-big">'+h+'</span>';
  return h;
}

function renderMsgs(){
  const box=document.getElementById('msgsList');
  const wasBottom=isNearBottom();
  const prevTop=box.scrollTop;
  let html='';
  html+=`
    <div class="welcome">
      <div class="welcome-ic">💬</div>
      <div class="welcome-t">SELAMAT DATANG DI #GENERAL</div>
      <div class="welcome-s">Ini adalah chat umum komunitas LYVA. Semua pesan kamu bisa dilihat oleh member lain. Mari bersosialisasi dengan ramah! 🎉</div>
    </div>`;

  let lastDay=null,lastSender=null,lastTime=0;
  MSGS.forEach(m=>{
    const day=dayLabel(m.t);
    if(day!==lastDay){html+=`<div class="day-sep">${day}</div>`;lastDay=day;lastSender=null;}

    if(m.type==='system'){
      html+=`<div class="msg-sys-wrap"><div class="msg-sys join">✨ <b>${escHtml(m.name)}</b> ${escHtml(m.text)}</div></div>`;
      lastSender=null;
      return;
    }

    const mine=ME&&m.uid===ME.id;
    const sameSender=lastSender===m.uid&&(m.t-lastTime)<180000;
    const colorClass=m.color||'';
    const nameClass=m.role==='owner'?'nm-owner':m.role==='admin'?'nm-admin':m.role==='mod'?'nm-mod':m.role==='pro'?'nm-pro':'';
    const roleBadge=m.role==='owner'?'<span class="msg-role r-own">👑 Owner</span>':m.role==='admin'?'<span class="msg-role r-adm">💎 Admin</span>':m.role==='mod'?'<span class="msg-role r-mod">🛡 Mod</span>':'';

    html+=`<div class="msg ${mine?'mine':''}" data-id="${m.id}">`;
    if(!sameSender)html+=`<div class="msg-av ${colorClass}">${m.avatar}</div>`;
    else html+=`<div class="msg-av" style="visibility:hidden;"></div>`;

    html+=`<div class="msg-body">`;
    if(!sameSender){
      html+=`<div class="msg-meta">`;
      html+=`<span class="msg-nm ${nameClass}">${escHtml(m.name)}</span>`;
      html+=roleBadge;
      if(mine&&!m.role)html+='<span class="msg-role r-me">YOU</span>';
      html+=`<span class="msg-tm">${formatTime(m.t)}</span>`;
      html+=`</div>`;
    }

    html+=`<div class="msg-bubble">`;
    if(m.reply){
      html+=`<div style="font-size:11.5px;padding:5px 9px;margin-bottom:6px;border-radius:7px;background:rgba(0,0,0,.18);border-left:2px solid var(--accent3);"><b style="color:var(--accent3)">↩ ${escHtml(m.reply.name)}</b><br><span style="color:${mine?'rgba(255,255,255,.8)':'var(--text2)'};">${escHtml(String(m.reply.text).slice(0,80))}${String(m.reply.text).length>80?'…':''}</span></div>`;
    }
    html+=parseMsg(m.text);
    html+=`<div class="msg-hover"><button class="mh-btn" onclick="replyTo(${m.id})" title="Reply">↩</button><button class="mh-btn" onclick="reactMsg(${m.id},'❤️')" title="React">❤️</button><button class="mh-btn" onclick="reactMsg(${m.id},'🔥')" title="React">🔥</button>${mine?'<button class="mh-btn" onclick="delMsg('+m.id+')" title="Delete">🗑</button>':''}</div>`;
    html+=`</div>`;

    if(m.reacts&&Object.keys(m.reacts).length){
      html+=`<div class="msg-reacts">`;
      Object.entries(m.reacts).forEach(([em,list])=>{
        const active=ME&&Array.isArray(list)&&list.includes(ME.id);
        html+=`<span class="rc ${active?'active':''}" onclick="reactMsg(${m.id},'${em}')"><span>${em}</span><span class="rc-n">${Array.isArray(list)?list.length:0}</span></span>`;
      });
      html+=`</div>`;
    }

    html+=`</div></div>`;
    lastSender=m.uid;
    lastTime=m.t;
  });

  box.innerHTML=html;
  if(wasBottom)scrollBottom();
  else box.scrollTop=prevTop;
}
function scrollBottom(){const box=document.getElementById('msgsList');setTimeout(()=>{box.scrollTop=box.scrollHeight;},10);}
function isNearBottom(){const b=document.getElementById('msgsList');return b.scrollHeight-b.scrollTop-b.clientHeight<120;}

/* ══════════════ ACTIONS ══════════════ */
async function sendMsg(){
  const inp=document.getElementById('msgInput');
  const t=inp.value.trim();
  if(!t||!ME)return;
  if(t.length>500){toast('⚠️ Maksimal 500 karakter!');return;}

  try{
    await api(CHAT_ROUTES.store,{
      method:'POST',
      body:{
        message:t,
        reply_name:REPLY_TO?.name||null,
        reply_text:REPLY_TO?.text||null,
      }
    });
    inp.value='';
    autoGrow();
    updateCharCount();
    cancelReply();
    await fetchState();
    scrollBottom();
  }catch(error){
    toast('⚠️ '+error.message);
  }
}

async function delMsg(id){
  if(!confirm('Hapus pesan ini?'))return;
  try{
    await api(`${CHAT_ROUTES.messagesBase}/${id}`,{method:'DELETE'});
    await fetchState();
    toast('🗑 Pesan dihapus');
  }catch(error){
    toast('⚠️ '+error.message);
  }
}

async function reactMsg(id,em){
  if(!ME)return;
  try{
    await api(`${CHAT_ROUTES.messagesBase}/${id}/react`,{
      method:'POST',
      body:{emoji:em}
    });
    await fetchState();
  }catch(error){
    toast('⚠️ '+error.message);
  }
}

function replyTo(id){
  const m=MSGS.find(x=>x.id===id);if(!m)return;
  REPLY_TO={id:m.id,name:m.name,text:m.text};
  document.getElementById('replyBar').classList.add('show');
  document.getElementById('replyTxt').innerHTML=`Reply ke <b>${escHtml(m.name)}</b>: ${escHtml(String(m.text).slice(0,80))}${String(m.text).length>80?'…':''}`;
  document.getElementById('msgInput').focus();
}
function cancelReply(){REPLY_TO=null;document.getElementById('replyBar').classList.remove('show');}

/* ══════════════ PROFILE / JOIN ══════════════ */
let selAv='🎮';
document.querySelectorAll('.ap-item').forEach(el=>{
  el.addEventListener('click',()=>{
    document.querySelectorAll('.ap-item').forEach(x=>x.classList.remove('sel'));
    el.classList.add('sel');
    selAv=el.dataset.av;
  });
});

async function joinChat(){
  document.getElementById('meName').textContent=ME?.name||'Discord User';
  document.getElementById('meAv').textContent=ME?.avatar||selAv;
  document.getElementById('nameModal').classList.remove('open');
  await fetchState();
  scrollBottom();
  startPolling();
  toast('🎉 Selamat datang, '+(ME?.name||'member LYVA')+'!');
  document.getElementById('msgInput').focus();
}

function changeProfile(){
  toast('👤 Profil chat mengikuti akun Discord yang sedang login.');
}

/* ══════════════ POLLING ══════════════ */
async function tick(){
  await fetchState();
}
function startPolling(){
  if(POLL_TIMER)clearInterval(POLL_TIMER);
  POLL_TIMER=setInterval(tick,3000);
}

function renderOnline(list){
  if(!list||!list.length){
    document.getElementById('onlineList').innerHTML='<div style="font-size:12px;color:var(--text3);padding:8px 10px;font-style:italic">Belum ada yang online</div>';
    document.getElementById('onCount').textContent='0';
    document.getElementById('onlineTxt').textContent='0 online';
    return;
  }

  list.sort((a,b)=>{if(ME&&a.id===ME.id)return -1;if(ME&&b.id===ME.id)return 1;return a.name.localeCompare(b.name);});
  let html='';
  list.forEach(u=>{
    const isMe=ME&&u.id===ME.id;
    const roleBadge=u.role==='owner'?'<span class="ou-role r-own">Owner</span>':u.role==='admin'?'<span class="ou-role r-adm">Admin</span>':u.role==='mod'?'<span class="ou-role r-mod">Mod</span>':isMe?'<span class="ou-role r-me">YOU</span>':'';
    html+=`<div class="ou">
      <div class="ou-av ${isMe?'me':u.color||''}">${u.avatar}<div class="ou-on"></div></div>
      <div class="ou-n">${isMe?'<b>'+escHtml(u.name)+'</b>':escHtml(u.name)}</div>
      ${roleBadge}
    </div>`;
  });
  document.getElementById('onlineList').innerHTML=html;
  document.getElementById('onCount').textContent=list.length;
  document.getElementById('onlineTxt').textContent=list.length+' online';
}

/* ══════════════ INPUT ══════════════ */
const mi=document.getElementById('msgInput');
function autoGrow(){mi.style.height='auto';mi.style.height=Math.min(mi.scrollHeight,140)+'px';}
function updateCharCount(){const n=mi.value.length;document.getElementById('charCount').textContent=n+' / 500';document.getElementById('charCount').style.color=n>450?'var(--orange)':n>=500?'var(--red)':'var(--text3)';}
mi.addEventListener('input',()=>{autoGrow();updateCharCount();});
mi.addEventListener('keydown',e=>{if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();sendMsg();}});

/* ══════════════ EMOJI ══════════════ */
const EMOJIS={
  smile:['😀','😃','😄','😁','😆','😅','😂','🤣','😊','😇','🙂','🙃','😉','😌','😍','🥰','😘','😗','😙','😚','😋','😛','😝','😜','🤪','🤨','🧐','🤓','😎','🤩','🥳','😏','😒','😞','😔','😟','😕','🙁','☹️','😣','😖','😫','😩','🥺','😢','😭','😤','😠','😡','🤬','🤯','😳','🥵','🥶','😱'],
  love:['❤️','🧡','💛','💚','💙','💜','🖤','🤍','🤎','💔','❣️','💕','💞','💓','💗','💖','💘','💝','💟','♥️','💌','💋','😍','🥰','💑','💏','👩‍❤️‍👨','👨‍❤️‍👨','👩‍❤️‍👩','😘'],
  game:['🎮','🕹️','🎯','🎲','🃏','🎰','🎳','🏆','🥇','🥈','🥉','🏅','🎖️','🏵️','⚔️','🛡️','🏰','👑','💎','💰','💸','🪙','🎁','🎊','🎉','🔥','⚡','💥','✨','⭐','🌟','💫','🚀','🛸','👾','🤖'],
  anim:['🐉','🦊','🐺','🦁','🐯','🐻','🐼','🐨','🐸','🐵','🐒','🦍','🦧','🐶','🐱','🐭','🐰','🐹','🐻‍❄️','🦝','🦨','🦡','🦦','🦥','🐾','🦄','🐲','🐢','🦎','🐍','🦂','🕷️','🦇','🦅','🦆','🦉','🦜'],
  obj:['🔥','💧','🌊','⚡','☀️','🌙','⭐','🌟','💫','✨','🌈','☁️','❄️','☃️','🌸','🌺','🌻','🌹','🌷','🌼','🌿','🍀','🍁','🍂','🌴','🌲','🌵','🍎','🍊','🍋','🍉','🍇','🍓','🍑','🍒','🍍','🥝','🍔','🍕','🌮','🍜','🍱','🍣','🍦','🍩','🍪','🎂','☕','🍵','🍷','🍹','🍺']
};
let emCat='smile';
function renderEmojis(){document.getElementById('emList').innerHTML=EMOJIS[emCat].map(e=>`<button class="em-btn" onclick="insertEmoji('${e}')">${e}</button>`).join('');}
function toggleEmoji(){const p=document.getElementById('emojiPick');p.classList.toggle('show');if(p.classList.contains('show'))renderEmojis();}
function insertEmoji(e){mi.value+=e;autoGrow();updateCharCount();mi.focus();}
document.querySelectorAll('.em-cat-btn').forEach(el=>{el.addEventListener('click',()=>{document.querySelectorAll('.em-cat-btn').forEach(x=>x.classList.remove('on'));el.classList.add('on');emCat=el.dataset.cat;renderEmojis();});});
document.addEventListener('click',e=>{const p=document.getElementById('emojiPick');if(!p.contains(e.target)&&!e.target.closest('[onclick*="toggleEmoji"]'))p.classList.remove('show');});

/* ══════════════ SIDEBAR ══════════════ */
function openSB(){document.getElementById('sb').classList.add('open');document.getElementById('sbOvl').classList.add('show');}
function closeSB(){document.getElementById('sb').classList.remove('open');document.getElementById('sbOvl').classList.remove('show');}

/* ══════════════ TOAST ══════════════ */
function toast(msg){clearTimeout(tt);document.getElementById('tMsg').textContent=msg;const t=document.getElementById('toast');t.classList.add('show');tt=setTimeout(()=>t.classList.remove('show'),2800);}
async function refreshChat(){await tick();toast('🔄 Chat di-refresh!');}

/* ══════════════ INIT ══════════════ */
(async function init(){
  applyState({
    currentUser: ME,
    messages: MSGS,
    onlineUsers: ONLINE_USERS,
  });
  scrollBottom();
  document.getElementById('nameModal').classList.remove('open');
  startPolling();
})();

document.getElementById('inpName').addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();joinChat();}});
</script>
<script src="{{ asset('pwa-register.js') }}" defer></script>
</body>
</html>
