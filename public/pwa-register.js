let deferredInstallPrompt = null;

function installButtons() {
  return Array.from(document.querySelectorAll('[data-install-app]'));
}

function isIos() {
  return /iphone|ipad|ipod/i.test(window.navigator.userAgent);
}

function isStandalone() {
  return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
}

function setInstallVisibility(visible) {
  installButtons().forEach(function (button) {
    button.hidden = !visible;
  });
}

function showInstallHelp() {
  if (typeof window.toast !== 'function') {
    return;
  }

  if (isIos()) {
    window.toast('📲 Di iPhone/iPad: Safari → Share → Add to Home Screen');
    return;
  }

  window.toast('📲 Coba install dari menu browser jika prompt belum muncul');
}

async function triggerInstall() {
  if (deferredInstallPrompt) {
    deferredInstallPrompt.prompt();

    try {
      await deferredInstallPrompt.userChoice;
    } catch (error) {
      // Ignore user cancellation.
    }

    deferredInstallPrompt = null;
    setInstallVisibility(false);
    return;
  }

  showInstallHelp();
}

function bindInstallButtons() {
  installButtons().forEach(function (button) {
    if (button.dataset.installBound === 'true') {
      return;
    }

    button.dataset.installBound = 'true';
    button.addEventListener('click', triggerInstall);
  });
}

window.addEventListener('beforeinstallprompt', function (event) {
  event.preventDefault();
  deferredInstallPrompt = event;
  bindInstallButtons();
  setInstallVisibility(!isStandalone());
});

window.addEventListener('appinstalled', function () {
  deferredInstallPrompt = null;
  setInstallVisibility(false);

  if (typeof window.toast === 'function') {
    window.toast('✅ Aplikasi LYVA berhasil di-install');
  }
});

window.addEventListener('load', function () {
  bindInstallButtons();

  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(function () {
      // Ignore registration errors to avoid breaking the app UI.
    });
  }

  if (!isStandalone() && isIos()) {
    setInstallVisibility(true);
  }
});
