/**
 * accessibility.js — Psyche 15A Spacecraft Exhibit
 *
 * Provides:
 *   - Settings button injected into every page header
 *   - Settings panel (WAI-ARIA dialog pattern)
 *   - Font scaling (5 steps, CSS custom property)
 *   - High contrast mode toggle (dark background + white text)
 *   - Vertical scrolling when scaled text overflows
 *   - sessionStorage persistence (resets between visits)
 */
(function () {
  'use strict';

  /* ── Constants ──────────────────────────────────────────────────────────── */
  var SCALE_STEPS   = [1, 1.5, 2];
  var SCALE_LABELS  = ['Small', 'Medium', 'Large'];
  var STORAGE_SCALE = 'a11y-font-scale-index';
  var STORAGE_CVD   = 'a11y-colorblind';
  var PANEL_ID      = 'a11y-panel';
  var TRIGGER_ID    = 'a11y-settings-trigger';
  var STATUS_ID     = 'a11y-status';

  /* ── State ──────────────────────────────────────────────────────────────── */
  var scaleIndex = parseInt(sessionStorage.getItem(STORAGE_SCALE) || '0', 10);
  var cvdOn      = sessionStorage.getItem(STORAGE_CVD) === 'true';

  /* ── Init ───────────────────────────────────────────────────────────────── */
  document.addEventListener('DOMContentLoaded', function () {
    injectStatusRegion();
    injectSettingsButton();
    injectPanel();
    applyScale(scaleIndex, false);
    applyCvd(cvdOn, false);
  });

  /* ── Status region (aria-live, visually hidden) ─────────────────────────── */
  function injectStatusRegion() {
    var el = document.createElement('div');
    el.id = STATUS_ID;
    el.className = 'a11y-status';
    el.setAttribute('aria-live', 'polite');
    el.setAttribute('aria-atomic', 'true');
    document.body.appendChild(el);
  }

  function announce(msg) {
    var el = document.getElementById(STATUS_ID);
    if (!el) return;
    el.textContent = '';
    // Small delay so screen readers notice the change
    setTimeout(function () { el.textContent = msg; }, 50);
  }

  /* ── Settings button injection ──────────────────────────────────────────── */
  function injectSettingsButton() {
    var btn = document.createElement('button');
    btn.id = TRIGGER_ID;
    btn.setAttribute('aria-label', 'Open accessibility settings');
    btn.setAttribute('aria-expanded', 'false');
    btn.setAttribute('aria-controls', PANEL_ID);
    btn.innerHTML =
      '<span class="a11y-gear-icon" aria-hidden="true">&#9881;</span>' +
      '<span class="a11y-settings-label">Settings</span>';
    btn.addEventListener('click', openPanel);

    var header = document.querySelector('.header');
    if (header) {
      /* Standard section pages — insert inside .header */
      btn.className = 'a11y-settings-btn';
      header.appendChild(btn);
    } else {
      /* index.html — no .header; use floating fixed button */
      btn.className = 'a11y-settings-btn-float';
      document.body.appendChild(btn);
    }
  }

  /* ── Panel HTML ─────────────────────────────────────────────────────────── */
  function injectPanel() {
    var overlay = document.createElement('div');
    overlay.id = PANEL_ID;
    overlay.className = 'a11y-overlay';
    overlay.setAttribute('hidden', '');
    overlay.addEventListener('click', function (e) {
      /* Dismiss when tapping the backdrop (outside the card) */
      if (e.target === overlay) closePanel();
    });

    overlay.innerHTML =
      '<div class="a11y-panel" role="dialog" ' +
           'aria-modal="true" ' +
           'aria-labelledby="a11y-panel-heading">' +

        '<h2 id="a11y-panel-heading" class="a11y-panel-heading">' +
          'Accessibility Settings' +
        '</h2>' +

        '<button class="a11y-close-btn" id="a11y-close-btn" ' +
                'aria-label="Close accessibility settings">' +
          '&#x2715;' +
        '</button>' +

        /* ── Text Size ── */
        '<div class="a11y-control-group" role="group" ' +
             'aria-labelledby="a11y-size-label">' +
          '<span id="a11y-size-label" class="a11y-control-label">' +
            'Text Size (some text may require you to scroll)' +
          '</span>' +
          '<div class="a11y-size-row">' +
            '<button class="a11y-size-btn" id="a11y-size-decrease" ' +
                    'aria-label="Decrease text size">' +
              'A&#8722;' +
            '</button>' +
            '<span class="a11y-scale-display" id="a11y-scale-display" ' +
                  'aria-live="polite" aria-atomic="true">' +
            '</span>' +
            '<button class="a11y-size-btn" id="a11y-size-increase" ' +
                    'aria-label="Increase text size">' +
              'A+' +
            '</button>' +
            '<span class="a11y-size-preview" id="a11y-size-preview" ' +
                  'aria-hidden="true">' +
              'Aa' +
            '</span>' +
          '</div>' +
        '</div>' +

        /* ── Colour-Blind Mode ── */
        '<div class="a11y-toggle-row">' +
          '<div class="a11y-toggle-info">' +
            '<span class="a11y-toggle-name">High Contrast Mode</span>' +
            '<span class="a11y-toggle-desc">' +
              'Switches to a high contrast palette' +
            '</span>' +
          '</div>' +
          '<button class="a11y-toggle-switch" id="a11y-cvd-toggle" ' +
                  'role="switch" aria-checked="false" ' +
                  'aria-label="Color-blind mode">' +
          '</button>' +
        '</div>' +

      '</div>'; /* end .a11y-panel */

    document.body.appendChild(overlay);

    /* Wire up controls */
    document.getElementById('a11y-close-btn')
      .addEventListener('click', closePanel);
    document.getElementById('a11y-size-decrease')
      .addEventListener('click', decreaseScale);
    document.getElementById('a11y-size-increase')
      .addEventListener('click', increaseScale);
    document.getElementById('a11y-cvd-toggle')
      .addEventListener('click', toggleCvd);
  }

  /* ── Panel open / close ─────────────────────────────────────────────────── */
  function openPanel() {
    var overlay = document.getElementById(PANEL_ID);
    var trigger = document.getElementById(TRIGGER_ID);
    if (!overlay) return;

    overlay.removeAttribute('hidden');
    trigger.setAttribute('aria-expanded', 'true');

    updatePanelUI();

    /* Move focus to the panel card for screen readers */
    var panel = overlay.querySelector('.a11y-panel');
    if (panel) {
      panel.setAttribute('tabindex', '-1');
      panel.focus();
    }
  }

  function closePanel() {
    var overlay = document.getElementById(PANEL_ID);
    var trigger = document.getElementById(TRIGGER_ID);
    if (!overlay) return;

    overlay.setAttribute('hidden', '');
    if (trigger) {
      trigger.setAttribute('aria-expanded', 'false');
      trigger.focus(); /* return focus to trigger */
    }
  }

  /* ── Font scale ──────────────────────────────────────────────────────────── */
  function increaseScale() {
    if (scaleIndex < SCALE_STEPS.length - 1) {
      applyScale(scaleIndex + 1, true);
    }
  }

  function decreaseScale() {
    if (scaleIndex > 0) {
      applyScale(scaleIndex - 1, true);
    }
  }

  function applyScale(index, save) {
    scaleIndex = index;
    var scale  = SCALE_STEPS[index];

    /* Update CSS custom property on root */
    document.documentElement.style.setProperty('--a11y-font-scale', scale);

    /* Allow page to scroll when text is larger than viewport */
    if (scale > 1) {
      document.body.classList.add('a11y-scaled');
    } else {
      document.body.classList.remove('a11y-scaled');
    }

    if (save) {
      sessionStorage.setItem(STORAGE_SCALE, index);
      announce('Text size ' + SCALE_LABELS[index]);
    }

    updatePanelUI();
  }

  /* ── High contrast mode ─────────────────────────────────────────────────── */
  function toggleCvd() {
    applyCvd(!cvdOn, true);
  }

  function applyCvd(on, save) {
    cvdOn = on;

    if (on) {
      document.body.classList.add('a11y-cvd');
    } else {
      document.body.classList.remove('a11y-cvd');
    }

    if (save) {
      sessionStorage.setItem(STORAGE_CVD, on ? 'true' : 'false');
      announce('High contrast mode ' + (on ? 'on' : 'off'));
    }

    updatePanelUI();
  }

  /* ── Sync panel controls to current state ───────────────────────────────── */
  function updatePanelUI() {
    /* Scale display */
    var display  = document.getElementById('a11y-scale-display');
    var preview  = document.getElementById('a11y-size-preview');
    var decBtn   = document.getElementById('a11y-size-decrease');
    var incBtn   = document.getElementById('a11y-size-increase');
    var cvdToggle = document.getElementById('a11y-cvd-toggle');

    if (display)  display.textContent = SCALE_LABELS[scaleIndex];
    if (preview)  preview.style.fontSize = (SCALE_STEPS[scaleIndex] * 24) + 'px';
    if (decBtn)   decBtn.disabled  = (scaleIndex === 0);
    if (incBtn)   incBtn.disabled  = (scaleIndex === SCALE_STEPS.length - 1);

    /* CVD toggle */
    if (cvdToggle) {
      cvdToggle.setAttribute('aria-checked', cvdOn ? 'true' : 'false');
    }
  }

})();
