(function () {
  'use strict';

  /* ---------- mobile menu ---------- */
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('main-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  /* ---------- flash messages fade out ---------- */
  document.querySelectorAll('.flash-success').forEach(function (el) {
    setTimeout(function () {
      el.classList.add('fade');
      setTimeout(function () { el.remove(); }, 600);
    }, 5000);
  });

  /* ---------- confirm before destructive actions ---------- */
  document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!window.confirm(form.getAttribute('data-confirm'))) e.preventDefault();
    });
  });

  /* ---------- live search on the events page ---------- */
  var search = document.getElementById('q');
  var grid = document.getElementById('event-grid');
  if (search && grid) {
    var cards = Array.prototype.slice.call(grid.querySelectorAll('.event-card'));
    var none = document.getElementById('no-results');
    search.addEventListener('input', function () {
      var term = search.value.trim().toLowerCase();
      var shown = 0;
      cards.forEach(function (c) {
        var match = !term || c.getAttribute('data-search').indexOf(term) !== -1;
        c.hidden = !match;
        if (match) shown++;
      });
      if (none) none.hidden = shown !== 0;
    });
  }

  /* ---------- countdown ---------- */
  var cd = document.querySelector('.countdown');
  if (cd) {
    var target = new Date(cd.getAttribute('data-target')).getTime();
    var pad = function (n) { return String(n).padStart(2, '0'); };
    var tick = function () {
      var diff = Math.max(0, target - Date.now());
      var s = Math.floor(diff / 1000);
      var vals = { d: Math.floor(s / 86400), h: Math.floor(s % 86400 / 3600), m: Math.floor(s % 3600 / 60), s: s % 60 };
      Object.keys(vals).forEach(function (k) {
        var el = cd.querySelector('[data-u="' + k + '"]');
        if (el) el.textContent = k === 'd' ? vals[k] : pad(vals[k]);
      });
    };
    tick();
    setInterval(tick, 1000);
  }

  /* ---------- animated counters ---------- */
  var counters = document.querySelectorAll('[data-count]');
  if (counters.length) {
    var run = function (el) {
      var end = parseInt(el.getAttribute('data-count'), 10) || 0;
      if (end === 0) { el.textContent = '0'; return; }
      var start = null;
      var step = function (ts) {
        if (!start) start = ts;
        var p = Math.min((ts - start) / 900, 1);
        el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3)));
        if (p < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) { run(en.target); io.unobserve(en.target); }
        });
      }, { threshold: .4 });
      counters.forEach(function (c) { io.observe(c); });
    } else {
      counters.forEach(run);
    }
  }

  /* ---------- client-side form validation (server re-checks everything) ---------- */
  var rules = {
    name: [/^[A-Za-z][A-Za-z .'-]{1,59}$/, 'Enter your full name (letters only, 2-60 characters).'],
    email: [/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/, 'Enter a valid email address.'],
    enrollment: [/^[A-Za-z0-9]{6,15}$/, 'Enrolment number should be 6-15 letters or digits.'],
    phone: [/^[6-9][0-9]{9}$/, 'Enter a 10-digit mobile number.'],
    subject: [/^.{3,100}$/, 'Subject should be 3-100 characters.'],
    message: [/^[\s\S]{10,1000}$/, 'Message should be 10-1000 characters.'],
    title: [/^.{3,90}$/, 'Title should be 3-90 characters.'],
    venue: [/^.{2,}$/, 'Enter the venue.'],
    organizer: [/^.{2,}$/, 'Enter the organiser.'],
    description: [/^[\s\S]{20,}$/, 'Describe the event in at least 20 characters.'],
    date: [/^\d{4}-\d{2}-\d{2}$/, 'Pick a valid date.'],
    time: [/^\d{2}:\d{2}$/, 'Pick a valid time.']
  };

  function setError(q, msg) {
    var err = q.querySelector('.err');
    if (!err) { err = document.createElement('small'); err.className = 'err'; q.appendChild(err); }
    err.textContent = msg;
    q.classList.toggle('has-error', !!msg);
  }

  function checkField(input) {
    var q = input.closest('.q');
    if (!q) return true;
    var rule = rules[input.name];
    if (!rule) return true;
    var val = input.value.trim();
    // the first form field "name" on contact form shares the rule key, so only trust the pattern
    var ok = rule[0].test(val);
    setError(q, ok ? '' : rule[1]);
    return ok;
  }

  ['reg-form', 'contact-form', 'event-form'].forEach(function (id) {
    var form = document.getElementById(id);
    if (!form) return;

    form.querySelectorAll('input[type=text], input[type=email], input[type=tel], input[type=date], input[type=time], textarea')
      .forEach(function (input) {
        input.addEventListener('blur', function () { checkField(input); });
        input.addEventListener('input', function () {
          if (input.closest('.q').classList.contains('has-error')) checkField(input);
        });
      });

    var phone = form.querySelector('#phone');
    if (phone) phone.addEventListener('input', function () { phone.value = phone.value.replace(/\D/g, '').slice(0, 10); });
    var enr = form.querySelector('#enrollment');
    if (enr) enr.addEventListener('input', function () { enr.value = enr.value.toUpperCase().replace(/[^A-Z0-9]/g, ''); });

    form.addEventListener('submit', function (e) {
      var firstBad = null;
      form.querySelectorAll('input[type=text], input[type=email], input[type=tel], input[type=date], input[type=time], textarea')
        .forEach(function (input) {
          if (!checkField(input) && !firstBad) firstBad = input;
        });

      var radios = form.querySelectorAll('input[type=radio]');
      if (radios.length) {
        var chosen = form.querySelector('input[type=radio]:checked');
        var fs = radios[0].closest('.q');
        setError(fs, chosen ? '' : 'Select your class.');
        if (!chosen && !firstBad) firstBad = radios[0];
      }
      var consent = form.querySelector('input[name=consent]');
      if (consent) {
        setError(consent.closest('.q'), consent.checked ? '' : 'Please confirm the details are correct.');
        if (!consent.checked && !firstBad) firstBad = consent;
      }

      if (firstBad) {
        e.preventDefault();
        firstBad.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstBad.focus({ preventScroll: true });
      }
    });

    form.addEventListener('change', function (e) {
      if (e.target.type === 'radio' || e.target.type === 'checkbox') {
        var q = e.target.closest('.q');
        if (q) setError(q, '');
      }
    });
  });
})();
