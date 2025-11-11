// Minimal global interactions (placeholder for future JS needs)
document.addEventListener('DOMContentLoaded', () => {
  // Accessibility: focus ring helper
  document.body.addEventListener('keyup', (e) => {
    if (e.key === 'Tab') document.body.classList.add('outline-enabled');
  });

  // Desktop nav dropdown hover delay
  var dropdownParents = document.querySelectorAll('header nav .relative.group');
  dropdownParents.forEach(function(parent){
    var panel = parent.querySelector('.absolute');
    var button = parent.querySelector('button');
    if (!panel || !button) return;
    var hideTimer = null;

    function openPanel(){
      clearTimeout(hideTimer);
      panel.classList.remove('hidden');
      panel.classList.add('block');
    }
    function scheduleClose(){
      clearTimeout(hideTimer);
      hideTimer = setTimeout(function(){
        panel.classList.add('hidden');
        panel.classList.remove('block');
      }, 250); // delay hide to avoid early disappearance
    }

    parent.addEventListener('mouseenter', openPanel);
    parent.addEventListener('mouseleave', scheduleClose);
    panel.addEventListener('mouseenter', openPanel);
    panel.addEventListener('mouseleave', scheduleClose);
    button.addEventListener('focus', openPanel);
    button.addEventListener('blur', scheduleClose);
  });
});
// Mobile navigation overlay toggle
document.addEventListener('DOMContentLoaded', function() {
  var toggle = document.getElementById('mobileNavToggle');
  var menu = document.getElementById('mobileNav');
  var backdrop = document.getElementById('mobileNavBackdrop');
  var closeBtn = document.getElementById('mobileNavClose');

  function openMenu() {
    if (!menu) return;
    menu.classList.remove('hidden');
    if (toggle) toggle.setAttribute('aria-expanded', 'true');
    document.body.classList.add('overflow-hidden');
  }

  function closeMenu() {
    if (!menu) return;
    menu.classList.add('hidden');
    if (toggle) toggle.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('overflow-hidden');
  }

  if (toggle) {
    toggle.addEventListener('click', function() {
      var isHidden = menu && menu.classList.contains('hidden');
      if (isHidden) openMenu(); else closeMenu();
    });
  }

  if (backdrop) {
    backdrop.addEventListener('click', closeMenu);
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', closeMenu);
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeMenu();
  });
});

// Hero slider
document.addEventListener('DOMContentLoaded', function() {
  var slider = document.getElementById('heroSlider');
  if (!slider) return;
  var slides = slider.querySelectorAll('[data-slide]');
  var dots = slider.querySelectorAll('[data-dot]');
  var prev = document.getElementById('heroPrev');
  var next = document.getElementById('heroNext');
  var index = 0;
  var timer = null;

  function show(i) {
    index = (i + slides.length) % slides.length;
    slides.forEach(function(s, idx) {
      if (idx === index) {
        s.classList.remove('opacity-0');
        s.classList.add('opacity-100');
        s.setAttribute('aria-hidden', 'false');
      } else {
        s.classList.remove('opacity-100');
        s.classList.add('opacity-0');
        s.setAttribute('aria-hidden', 'true');
      }
    });
    dots.forEach(function(d, idx) {
      d.classList.toggle('bg-mission_orange', idx === index);
      d.classList.toggle('bg-white/60', idx !== index);
    });
  }

  function start() {
    stop();
    timer = setInterval(function() { show(index + 1); }, 5000);
  }
  function stop() { if (timer) { clearInterval(timer); timer = null; } }

  dots.forEach(function(d, idx) {
    d.addEventListener('click', function() { show(idx); start(); });
  });
  if (prev) prev.addEventListener('click', function() { show(index - 1); start(); });
  if (next) next.addEventListener('click', function() { show(index + 1); start(); });

  // Pause on hover (desktop)
  slider.addEventListener('mouseenter', stop);
  slider.addEventListener('mouseleave', start);

  show(0);
  start();
});

// Testimonials slider (center-mode: one card centered, adjacent peeking, infinite)
document.addEventListener('DOMContentLoaded', function() {
  var root = document.getElementById('testimonialsSlider');
  if (!root) return;
  var viewport = root.querySelector('.overflow-hidden');
  var track = root.querySelector('[data-track]');
  if (!track) return;
  var prev = document.getElementById('testimonialsPrev');
  var next = document.getElementById('testimonialsNext');
  var dots = root.querySelectorAll('[data-dot]');
  var timer = null;

  // Prepare items and clones for infinite loop
  var originalItems = Array.prototype.slice.call(track.children);
  var itemCount = originalItems.length;
  if (itemCount === 0) return;
  if (itemCount > 1) {
    var firstClone = originalItems[0].cloneNode(true);
    var lastClone = originalItems[itemCount - 1].cloneNode(true);
    firstClone.setAttribute('data-clone', 'first');
    lastClone.setAttribute('data-clone', 'last');
    track.insertBefore(lastClone, originalItems[0]);
    track.appendChild(firstClone);
  }
  var items = Array.prototype.slice.call(track.children);
  var index = itemCount > 1 ? 1 : 0; // start at first real item when clones exist

  function centerTo(i, withTransition) {
    if (!viewport) return;
    if (withTransition) {
      track.style.transition = 'transform 500ms ease';
    } else {
      track.style.transition = 'none';
    }
    var target = items[i];
    if (!target) return;
    var containerWidth = viewport.clientWidth;
    var targetCenter = target.offsetLeft + (target.offsetWidth / 2);
    var translate = targetCenter - (containerWidth / 2);
    track.style.transform = 'translateX(' + (-translate) + 'px)';

    // Update dots (map clone-aware index back to original range)
    var activeDot = itemCount > 1 ? ((i - 1 + itemCount) % itemCount) : i;
    dots.forEach(function(d, di){
      d.classList.toggle('bg-mission_orange', di === activeDot);
      d.classList.toggle('bg-white/60', di !== activeDot);
    });
  }

  function show(i) {
    index = i;
    centerTo(index, true);
  }

  function start() { stop(); timer = setInterval(function(){ nextClick(); }, 6000); }
  function stop() { if (timer) { clearInterval(timer); timer = null; } }

  function nextClick() { show(index + 1); start(); }
  function prevClick() { show(index - 1); start(); }

  // Seamless loop handling after transition completes
  track.addEventListener('transitionend', function() {
    var current = items[index];
    if (!current) return;
    if (current.getAttribute('data-clone') === 'first') {
      // moved past last real item to first clone => jump to first real
      index = 1;
      centerTo(index, false);
    } else if (current.getAttribute('data-clone') === 'last') {
      // moved before first real item to last clone => jump to last real
      index = itemCount;
      centerTo(index, false);
    }
  });

  dots.forEach(function(d){
    var di = parseInt(d.getAttribute('data-dot') || '0', 10);
    d.addEventListener('click', function(){
      index = itemCount > 1 ? di + 1 : di; // account for leading clone
      centerTo(index, true);
      start();
    });
  });
  if (prev) prev.addEventListener('click', prevClick);
  if (next) next.addEventListener('click', nextClick);

  root.addEventListener('mouseenter', stop);
  root.addEventListener('mouseleave', start);

  centerTo(index, false);
  start();
});

// Generic center-mode slider initializer for reusable sections (e.g., team sliders on About page)
document.addEventListener('DOMContentLoaded', function() {
  var roots = document.querySelectorAll('[data-center-slider]');
  if (!roots || roots.length === 0) return;

  roots.forEach(function(root){
    var viewport = root.querySelector('.overflow-hidden');
    var track = root.querySelector('[data-track]');
    if (!track || !viewport) return;
    var prev = root.querySelector('[data-prev]');
    var next = root.querySelector('[data-next]');
    var dots = root.querySelectorAll('[data-dot]');
    var timer = null;

    // Prepare items and clones for infinite loop
    var originalItems = Array.prototype.slice.call(track.children);
    var itemCount = originalItems.length;
    if (itemCount === 0) return;
    if (itemCount > 1) {
      var firstClone = originalItems[0].cloneNode(true);
      var lastClone = originalItems[itemCount - 1].cloneNode(true);
      firstClone.setAttribute('data-clone', 'first');
      lastClone.setAttribute('data-clone', 'last');
      track.insertBefore(lastClone, originalItems[0]);
      track.appendChild(firstClone);
    }
    var items = Array.prototype.slice.call(track.children);
    var index = itemCount > 1 ? 1 : 0; // start at first real item when clones exist

    function centerTo(i, withTransition) {
      if (!viewport) return;
      if (withTransition) {
        track.style.transition = 'transform 500ms ease';
      } else {
        track.style.transition = 'none';
      }
      var target = items[i];
      if (!target) return;
      var containerWidth = viewport.clientWidth;
      var targetCenter = target.offsetLeft + (target.offsetWidth / 2);
      var translate = targetCenter - (containerWidth / 2);
      track.style.transform = 'translateX(' + (-translate) + 'px)';

      // Update dots (map clone-aware index back to original range)
      if (dots && dots.length) {
        var activeDot = itemCount > 1 ? ((i - 1 + itemCount) % itemCount) : i;
        dots.forEach(function(d, di){
          d.classList.toggle('bg-mission_orange', di === activeDot);
          d.classList.toggle('bg-white/60', di !== activeDot);
        });
      }
    }

    function show(i) { index = i; centerTo(index, true); }
    function start() { stop(); timer = setInterval(function(){ nextClick(); }, 6000); }
    function stop() { if (timer) { clearInterval(timer); timer = null; } }
    function nextClick() { show(index + 1); start(); }
    function prevClick() { show(index - 1); start(); }

    // Seamless loop handling after transition completes
    track.addEventListener('transitionend', function() {
      var current = items[index];
      if (!current) return;
      if (current.getAttribute('data-clone') === 'first') {
        index = 1; // jump to first real
        centerTo(index, false);
      } else if (current.getAttribute('data-clone') === 'last') {
        index = itemCount; // jump to last real
        centerTo(index, false);
      }
    });

    if (dots && dots.length) {
      dots.forEach(function(d){
        var di = parseInt(d.getAttribute('data-dot') || '0', 10);
        d.addEventListener('click', function(){
          index = itemCount > 1 ? di + 1 : di; // account for leading clone
          centerTo(index, true);
          start();
        });
      });
    }

    if (prev) prev.addEventListener('click', prevClick);
    if (next) next.addEventListener('click', nextClick);

    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);

    centerTo(index, false);
    start();
  });
});

// Engagement panel (bottom-right) show + close logic (renamed from promo to avoid ad-blockers)
document.addEventListener('DOMContentLoaded', function() {
  var panel = document.getElementById('engagePanel');
  if (!panel) return;
  var closeEls = panel.querySelectorAll('[data-engage-close]');
  var key = 'rcn_engage_dismissed';

  function showPanel() {
    if (!panel) return;
    try { if (localStorage.getItem(key) === '1') return; } catch(e) {}
    // Move to body to avoid ancestor overflow/transform affecting fixed positioning
    try {
      if (panel.parentElement && panel.parentElement !== document.body) {
        document.body.appendChild(panel);
      }
    } catch (_) {}

    // Ensure visibility regardless of utility classes
    panel.classList.remove('hidden', 'opacity-0', 'translate-y-6', 'invisible');
    panel.classList.add('opacity-100', 'translate-y-0', 'block');
    panel.style.display = 'block';
    panel.style.visibility = 'visible';
    panel.style.opacity = '1';
    panel.style.transform = 'translateY(0)';
    if (!panel.style.zIndex) panel.style.zIndex = '9999';
  }

  function dismissPanel() {
    try { localStorage.setItem(key, '1'); } catch(e) {}
    panel.classList.add('opacity-0', 'translate-y-6');
    panel.style.opacity = '0';
    panel.style.transform = 'translateY(1.5rem)';
    setTimeout(function(){
      panel.classList.add('hidden');
      panel.style.display = 'none';
      panel.style.visibility = 'hidden';
    }, 250);
  }

  setTimeout(showPanel, 800); // slight delay after load
  closeEls.forEach(function(el){ el.addEventListener('click', dismissPanel); });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape') dismissPanel(); });
});