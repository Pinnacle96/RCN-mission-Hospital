<?php
$page_title = 'Partner With Us - Support Our Mission';
$page_description = 'Choose a secure multi-currency giving option to support medical missions, healthcare outreach, and Gospel-centered service.';
require_once __DIR__ . '/includes/payment_helpers.php';
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php
$paypalAction = PAYPAL_USE_SANDBOX ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
$paypalNotifyUrl = payment_absolute_url('api/paypal/ipn.php');
$paypalReturnUrl = filter_var(PAYPAL_RETURN_URL, FILTER_VALIDATE_URL) ? PAYPAL_RETURN_URL : payment_absolute_url(ltrim(PAYPAL_RETURN_URL, '/'));
$paypalCancelUrl = filter_var(PAYPAL_CANCEL_URL, FILTER_VALIDATE_URL) ? PAYPAL_CANCEL_URL : payment_absolute_url(ltrim(PAYPAL_CANCEL_URL, '/'));
$gatewayAvailability = [
  'paypal' => [
    'enabled' => (bool) PAYPAL_BUSINESS_EMAIL,
    'one_time' => (bool) PAYPAL_BUSINESS_EMAIL,
    'recurring' => (bool) PAYPAL_BUSINESS_EMAIL,
  ],
  'paystack' => [
    'enabled' => (bool) PAYSTACK_SECRET_KEY,
    'one_time' => (bool) PAYSTACK_SECRET_KEY,
    'recurring' => [
      'NGN' => (bool) PAYSTACK_SECRET_KEY,
      'USD' => false,
      'GBP' => false,
      'EUR' => false,
    ],
  ],
  'flutterwave' => [
    'enabled' => (bool) FLUTTERWAVE_SECRET_KEY,
    'one_time' => (bool) FLUTTERWAVE_SECRET_KEY,
    'recurring' => [
      'NGN' => payment_flutterwave_plan_for_currency('NGN') !== '',
      'USD' => payment_flutterwave_plan_for_currency('USD') !== '',
      'GBP' => payment_flutterwave_plan_for_currency('GBP') !== '',
      'EUR' => payment_flutterwave_plan_for_currency('EUR') !== '',
    ],
  ],
];
?>

<section class="relative overflow-hidden bg-slate-950 text-white">
  <div class="absolute inset-0 opacity-25" style="background-image: url('<?php echo url('assets/images/hero4.jpg'); ?>'); background-size: cover; background-position: center;"></div>
  <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900/95 to-blue-950/95"></div>
  <div class="relative max-w-7xl mx-auto px-4 py-24 lg:py-28">
    <div class="grid lg:grid-cols-[1.15fr_0.85fr] gap-12 items-center">
      <div>
        <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-blue-100 mb-6">
          <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
          Global Giving. Local Healing. Gospel Impact.
        </div>
        <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
          Partner With Us Through
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-orange-300 to-yellow-200">Secure Multi-Currency Giving</span>
        </h1>
        <p class="text-lg md:text-xl text-slate-200 max-w-3xl leading-relaxed mb-8">
          Support missions, clinics, community outreach, and compassionate care through Paystack (NGN), Flutterwave (multi-currency), PayPal (USD/GBP/EUR), or direct bank transfer. Choose the currency, donation type, and gateway that work best for you.
        </p>
        <div class="flex flex-wrap gap-4">
          <a href="#donate-now" class="inline-flex items-center justify-center rounded-xl px-7 py-4 font-semibold text-white shadow-xl hover:opacity-95" style="background: <?php echo RCN_GRADIENT; ?>;">
            Start Giving
          </a>
          <a href="#giving-guide" class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-7 py-4 font-semibold text-white hover:bg-white/10">
            Compare Options
          </a>
        </div>
      </div>
      <div class="grid sm:grid-cols-2 gap-4">
        <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur">
          <div class="text-sm uppercase tracking-[0.2em] text-blue-200 mb-2">Giving Channels</div>
          <div class="text-3xl font-bold mb-2">3</div>
          <p class="text-sm text-slate-200">Online gateways plus manual international transfer options.</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur">
          <div class="text-sm uppercase tracking-[0.2em] text-blue-200 mb-2">Currencies</div>
          <div class="text-3xl font-bold mb-2">4</div>
          <p class="text-sm text-slate-200">NGN, USD, GBP, and EUR donation flows with gateway-aware routing.</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur sm:col-span-2">
          <div class="text-sm uppercase tracking-[0.2em] text-blue-200 mb-2">Why It Matters</div>
          <p class="text-slate-100 leading-relaxed">
            Your support funds medical outreach, mission logistics, medicines, training, and compassionate care for communities in need.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="donate-now" class="bg-gradient-to-br from-slate-50 via-white to-blue-50 py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid xl:grid-cols-[1.2fr_0.8fr] gap-8">
      <div class="rounded-3xl border border-slate-200 bg-white shadow-2xl shadow-slate-200/60 overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-950 px-8 py-7 text-white">
          <div class="text-sm uppercase tracking-[0.25em] text-blue-200 mb-2">Donation Planner</div>
          <h2 class="text-3xl font-bold">Choose Amount, Currency, Frequency, and Gateway</h2>
          <p class="text-slate-300 mt-3">We only show gateways that fit your current selection and account setup.</p>
        </div>
        <div class="p-8">
          <form id="donationForm" class="space-y-8">
            <div class="grid md:grid-cols-2 gap-5">
              <div>
                <label for="donorName" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                <input id="donorName" name="name" type="text" placeholder="Your full name" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
              </div>
              <div>
                <label for="donorEmail" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                <input id="donorEmail" name="email" type="email" required placeholder="you@example.com" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
              </div>
            </div>

            <div>
              <div class="block text-sm font-semibold text-slate-700 mb-3">Donation Type</div>
              <div class="grid sm:grid-cols-2 gap-3" id="typeSelector">
                <button type="button" class="donation-toggle active rounded-2xl border border-slate-300 px-5 py-4 text-left transition" data-group="type" data-value="one_time">
                  <span class="block text-sm font-semibold text-slate-900">One-Time Gift</span>
                  <span class="mt-1 block text-sm text-slate-500">Give once right now.</span>
                </button>
                <button type="button" class="donation-toggle rounded-2xl border border-slate-300 px-5 py-4 text-left transition" data-group="type" data-value="recurring">
                  <span class="block text-sm font-semibold text-slate-900">Monthly Partnership</span>
                  <span class="mt-1 block text-sm text-slate-500">Support the mission every month.</span>
                </button>
              </div>
            </div>

            <div>
              <div class="block text-sm font-semibold text-slate-700 mb-3">Currency</div>
              <div class="grid grid-cols-2 md:grid-cols-4 gap-3" id="currencySelector">
                <button type="button" class="currency-toggle active rounded-2xl border border-slate-300 px-4 py-4 font-semibold text-slate-800 transition" data-currency="NGN">NGN</button>
                <button type="button" class="currency-toggle rounded-2xl border border-slate-300 px-4 py-4 font-semibold text-slate-800 transition" data-currency="USD">USD</button>
                <button type="button" class="currency-toggle rounded-2xl border border-slate-300 px-4 py-4 font-semibold text-slate-800 transition" data-currency="GBP">GBP</button>
                <button type="button" class="currency-toggle rounded-2xl border border-slate-300 px-4 py-4 font-semibold text-slate-800 transition" data-currency="EUR">EUR</button>
              </div>
            </div>

            <div>
              <div class="flex items-center justify-between mb-3">
                <label for="donationAmount" class="block text-sm font-semibold text-slate-700">Donation Amount</label>
                <span id="amountHint" class="text-sm text-slate-500">Recommended amounts change with currency.</span>
              </div>
              <div class="relative">
                <span id="amountCurrencyPrefix" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-semibold">NGN</span>
                <input id="donationAmount" name="amount" type="number" min="1" step="0.01" required class="w-full rounded-2xl border border-slate-300 pl-20 pr-4 py-4 text-lg text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" placeholder="10000">
              </div>
              <div id="amountSuggestions" class="mt-3 flex flex-wrap gap-2"></div>
            </div>

            <div>
              <div class="block text-sm font-semibold text-slate-700 mb-3">Available Gateways</div>
              <div id="gatewayOptions" class="space-y-3"></div>
              <p id="gatewaySummary" class="mt-3 text-sm text-slate-600"></p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
              Your donation is processed through secure checkout, and you will see confirmation after payment is successfully completed.
            </div>

            <div class="flex flex-wrap items-center gap-4">
              <button type="submit" id="donationSubmit" class="inline-flex items-center justify-center rounded-2xl px-7 py-4 font-semibold text-white shadow-lg hover:opacity-95" style="background: <?php echo RCN_GRADIENT; ?>;">
                Continue To Secure Checkout
              </button>
              <span class="text-sm text-slate-500">You can also use the manual bank transfer details on the right.</span>
            </div>
          </form>
        </div>
      </div>

      <div class="space-y-6">
        <div id="giving-guide" class="rounded-3xl border border-slate-200 bg-white p-7 shadow-lg">
          <h3 class="text-2xl font-bold text-slate-900 mb-5">Gateway Guide</h3>
          <div class="space-y-4">
            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
              <div class="font-semibold text-blue-900">PayPal</div>
              <p class="mt-1 text-sm text-blue-800">Best for USD, GBP, and EUR international donor familiarity and broad donor comfort.</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
              <div class="font-semibold text-emerald-900">Paystack</div>
              <p class="mt-1 text-sm text-emerald-800">Best for NGN donations with strong Nigeria-focused checkout.</p>
            </div>
            <div class="rounded-2xl border border-purple-100 bg-purple-50 p-4">
              <div class="font-semibold text-purple-900">Flutterwave</div>
              <p class="mt-1 text-sm text-purple-800">Best for broader international card and multi-currency coverage across USD, GBP, EUR, and NGN.</p>
            </div>
          </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-lg">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-2xl font-bold text-slate-900">Bank Transfer</h3>
            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Manual Option</span>
          </div>
          <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200 p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="font-semibold text-slate-900">NGN Account</span>
                <button type="button" class="text-sm font-semibold text-blue-600 hover:text-blue-700" onclick="copyText('First Bank | RCN MEDICAL CENTER | 2045571486', 'NGN details copied')">Copy</button>
              </div>
              <div class="text-sm text-slate-600 space-y-1">
                <div>Bank: First Bank</div>
                <div>Account Name: RCN MEDICAL CENTER</div>
                <div>Account Number: <span class="font-mono text-slate-900">2045571486</span></div>
              </div>
            </div>
            <div class="rounded-2xl border border-slate-200 p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="font-semibold text-slate-900">USD Account</span>
                <button type="button" class="text-sm font-semibold text-blue-600 hover:text-blue-700" onclick="copyText('First Bank | RCN MEDICAL CENTER | 2045578832', 'USD details copied')">Copy</button>
              </div>
              <div class="text-sm text-slate-600 space-y-1">
                <div>Bank: First Bank</div>
                <div>Account Name: RCN MEDICAL CENTER</div>
                <div>Account Number: <span class="font-mono text-slate-900">2045578832</span></div>
              </div>
            </div>
            <div class="rounded-2xl border border-slate-200 p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="font-semibold text-slate-900">GBP Account</span>
                <button type="button" class="text-sm font-semibold text-blue-600 hover:text-blue-700" onclick="copyText('First Bank | RCN MEDICAL CENTER | 2045578894', 'GBP details copied')">Copy</button>
              </div>
              <div class="text-sm text-slate-600 space-y-1">
                <div>Bank: First Bank</div>
                <div>Account Name: RCN MEDICAL CENTER</div>
                <div>Account Number: <span class="font-mono text-slate-900">2045578894</span></div>
              </div>
            </div>
            <div class="rounded-2xl border border-slate-200 p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="font-semibold text-slate-900">EUR Account</span>
                <button type="button" class="text-sm font-semibold text-blue-600 hover:text-blue-700" onclick="copyText('First Bank | RCN MEDICAL CENTER | 2045578966', 'EUR details copied')">Copy</button>
              </div>
              <div class="text-sm text-slate-600 space-y-1">
                <div>Bank: First Bank</div>
                <div>Account Name: RCN MEDICAL CENTER</div>
                <div>Account Number: <span class="font-mono text-slate-900">2045578966</span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-950 p-7 text-white shadow-lg">
          <div class="text-sm uppercase tracking-[0.2em] text-blue-200 mb-3">Monthly Impact</div>
          <div class="space-y-3">
            <div class="rounded-2xl bg-white/10 p-4">Equivalent of a steady supply of medicines, consumables, and patient support for outreach clinics.</div>
            <div class="rounded-2xl bg-white/10 p-4">Supports training, mission logistics, and continuity for local healthcare partnerships.</div>
            <div class="rounded-2xl bg-white/10 p-4">Helps the team respond faster to urgent and seasonal medical needs.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid lg:grid-cols-2 gap-8">
      <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8">
        <div class="text-sm uppercase tracking-[0.2em] text-blue-700 mb-3">Why Monthly Giving</div>
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Predictable Support Creates Sustainable Impact</h2>
        <div class="space-y-4 text-slate-600 leading-relaxed">
          <p>Monthly partners help us plan mission schedules, stock medical supplies, and sustain outreach beyond one-off campaigns.</p>
          <p>Recurring giving also helps the team commit to follow-up care, volunteer coordination, and community health support with confidence.</p>
        </div>
      </div>
      <div class="rounded-3xl border border-slate-200 bg-slate-950 p-8 text-white">
        <div class="text-sm uppercase tracking-[0.2em] text-blue-200 mb-3">Questions</div>
        <div class="space-y-5 text-slate-200">
          <div>
            <div class="font-semibold text-white mb-1">Is my donation secure?</div>
            <p class="text-sm">Yes. Online gateways route to secure hosted payment pages, and successful payments are re-verified server-side before confirmation.</p>
          </div>
          <div>
            <div class="font-semibold text-white mb-1">Which gateway should I use internationally?</div>
            <p class="text-sm">For USD, GBP, and EUR, Flutterwave and PayPal are the primary choices. The form recommends the strongest option based on your selection.</p>
          </div>
          <div>
            <div class="font-semibold text-white mb-1">Can I still give by transfer?</div>
            <p class="text-sm">Yes. Manual bank transfer details for NGN, USD, GBP, and EUR remain available on this page.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function() {
    if (!window.Swal) {
      const script = document.createElement('script');
      script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
      document.head.appendChild(script);
    }

    const state = {
      type: 'one_time',
      currency: 'NGN',
      gateway: null
    };

    const supportMatrix = {
      one_time: {
        NGN: ['paystack', 'flutterwave'],
        USD: ['flutterwave', 'paypal'],
        GBP: ['flutterwave', 'paypal'],
        EUR: ['flutterwave', 'paypal']
      },
      recurring: {
        NGN: ['flutterwave', 'paystack'],
        USD: ['flutterwave', 'paypal'],
        GBP: ['flutterwave', 'paypal'],
        EUR: ['flutterwave', 'paypal']
      }
    };

    const gatewayAvailability = <?php echo json_encode($gatewayAvailability, JSON_UNESCAPED_SLASHES); ?>;
    const paypalConfig = {
      action: <?php echo json_encode($paypalAction); ?>,
      business: <?php echo json_encode(PAYPAL_BUSINESS_EMAIL); ?>,
      notifyUrl: <?php echo json_encode($paypalNotifyUrl); ?>,
      returnUrl: <?php echo json_encode($paypalReturnUrl); ?>,
      cancelUrl: <?php echo json_encode($paypalCancelUrl); ?>
    };

    const amountPresets = {
      NGN: { one_time: [5000, 10000, 25000, 50000], recurring: [5000, 10000, 20000, 50000] },
      USD: { one_time: [25, 50, 100, 250], recurring: [15, 25, 50, 100] },
      GBP: { one_time: [20, 50, 100, 200], recurring: [10, 25, 50, 100] },
      EUR: { one_time: [20, 50, 100, 200], recurring: [10, 25, 50, 100] }
    };

    const gatewayMeta = {
      paypal: {
        title: 'PayPal',
        badge: 'Global',
        border: 'border-blue-200',
        bg: 'bg-blue-50',
        text: 'Best for USD, GBP, and EUR international donor familiarity and broad donor comfort.'
      },
      paystack: {
        title: 'Paystack',
        badge: 'Nigeria-first',
        border: 'border-emerald-200',
        bg: 'bg-emerald-50',
        text: 'Best for NGN donations, including flexible monthly giving with saved card authorization.'
      },
      flutterwave: {
        title: 'Flutterwave',
        badge: 'Multi-currency',
        border: 'border-purple-200',
        bg: 'bg-purple-50',
        text: 'Best for strong international card and multi-currency coverage.'
      }
    };

    const donationForm = document.getElementById('donationForm');
    const donationAmount = document.getElementById('donationAmount');
    const amountPrefix = document.getElementById('amountCurrencyPrefix');
    const amountHint = document.getElementById('amountHint');
    const amountSuggestions = document.getElementById('amountSuggestions');
    const gatewayOptions = document.getElementById('gatewayOptions');
    const gatewaySummary = document.getElementById('gatewaySummary');
    const submitButton = document.getElementById('donationSubmit');

    function notify(icon, title, text) {
      if (window.Swal) {
        Swal.fire({ icon, title, text, confirmButtonColor: '#2563eb' });
      } else {
        window.alert(title + (text ? ': ' + text : ''));
      }
    }

    function toast(message) {
      if (window.Swal) {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2400,
          timerProgressBar: true
        });
        Toast.fire({ icon: 'success', title: message });
      }
    }

    function copyText(value, message) {
      navigator.clipboard.writeText(value).then(function() {
        toast(message || 'Copied');
      }).catch(function() {
        notify('error', 'Copy failed', 'Please copy the details manually.');
      });
    }

    window.copyText = copyText;

    function getGatewayCards() {
      const base = supportMatrix[state.type][state.currency] || [];
      return base.map(function(gateway) {
        const config = gatewayAvailability[gateway] || {};
        let available = false;
        let note = 'Currently unavailable for this option.';

        if (!config.enabled) {
          note = 'Not configured yet.';
        } else if (state.type === 'one_time' && config.one_time) {
          available = true;
          note = 'Available now.';
        } else if (state.type === 'recurring') {
          if (gateway === 'paypal' && config.recurring) {
            available = true;
            note = 'Available now.';
          } else if (config.recurring && config.recurring[state.currency]) {
            available = true;
            note = gateway === 'paystack'
              ? 'Available now. Monthly giving uses a secure first card charge, then reuses the saved authorization for future monthly billing.'
              : 'Available now.';
          } else {
            note = 'Not configured for ' + state.currency + ' monthly giving yet.';
          }
        }

        return {
          gateway: gateway,
          available: available,
          note: note
        };
      });
    }

    function setActiveButton(selector, attribute, value) {
      document.querySelectorAll(selector).forEach(function(button) {
        button.classList.toggle('active', button.getAttribute(attribute) === value);
        if (button.classList.contains('active')) {
          button.classList.add('border-slate-950', 'bg-slate-950', 'text-white', 'shadow-lg');
          button.classList.remove('border-slate-300', 'text-slate-800');
        } else {
          button.classList.remove('border-slate-950', 'bg-slate-950', 'text-white', 'shadow-lg');
          button.classList.add('border-slate-300', 'text-slate-800');
        }
      });
    }

    function renderAmountSuggestions() {
      const presets = (amountPresets[state.currency] || {})[state.type] || [];
      amountPrefix.textContent = state.currency;
      amountHint.textContent = state.type === 'recurring'
        ? 'Choose a monthly amount in ' + state.currency + '.'
        : 'Choose a one-time amount in ' + state.currency + '.';
      amountSuggestions.innerHTML = '';
      presets.forEach(function(value) {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-blue-500 hover:text-blue-700';
        button.textContent = state.currency + ' ' + value;
        button.addEventListener('click', function() {
          donationAmount.value = value;
        });
        amountSuggestions.appendChild(button);
      });
      if (!donationAmount.value) {
        donationAmount.value = presets[1] || presets[0] || '';
      }
    }

    function renderGateways() {
      const gatewayCards = getGatewayCards();
      const availableGateways = gatewayCards.filter(function(item) { return item.available; }).map(function(item) { return item.gateway; });

      if (!gatewayCards.length) {
        state.gateway = null;
        gatewayOptions.innerHTML = '<div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800">No gateway is available for this combination. Try another currency or use bank transfer.</div>';
        gatewaySummary.textContent = 'Manual transfer remains available for all listed currencies.';
        return;
      }

      if (!availableGateways.includes(state.gateway)) {
        state.gateway = availableGateways[0] || null;
      }

      gatewayOptions.innerHTML = gatewayCards.map(function(item) {
        const gateway = item.gateway;
        const meta = gatewayMeta[gateway];
        const checked = state.gateway === gateway;
        const disabled = !item.available;
        return '' +
          '<label class="gateway-card flex items-start gap-4 rounded-2xl border p-4 transition ' + meta.border + ' ' + meta.bg + (disabled ? ' opacity-60 cursor-not-allowed' : ' cursor-pointer') + '">' +
            '<input class="mt-1 h-4 w-4" type="radio" name="gateway" value="' + gateway + '"' + (checked ? ' checked' : '') + (disabled ? ' disabled' : '') + '>' +
            '<div class="flex-1">' +
              '<div class="flex flex-wrap items-center gap-2 mb-1">' +
                '<span class="font-semibold text-slate-900">' + meta.title + '</span>' +
                '<span class="rounded-full bg-white/90 px-2 py-1 text-xs font-semibold text-slate-600">' + meta.badge + '</span>' +
                '<span class="rounded-full px-2 py-1 text-xs font-semibold ' + (item.available ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700') + '">' + (item.available ? 'Available' : 'Unavailable') + '</span>' +
              '</div>' +
              '<p class="text-sm text-slate-600">' + meta.text + '</p>' +
              '<p class="mt-2 text-xs ' + (item.available ? 'text-emerald-700' : 'text-amber-700') + '">' + item.note + '</p>' +
            '</div>' +
          '</label>';
      }).join('');

      gatewayOptions.querySelectorAll('input[name="gateway"]').forEach(function(input) {
        input.addEventListener('change', function() {
          state.gateway = this.value;
          renderGatewaySummary();
        });
      });

      renderGatewaySummary();
    }

    function renderGatewaySummary() {
      if (!state.gateway) {
        gatewaySummary.textContent = 'No online gateway is configured for this selection yet. You can choose another option or use bank transfer.';
        return;
      }
      const label = gatewayMeta[state.gateway].title;
      const frequency = state.type === 'recurring' ? 'monthly' : 'one-time';
      gatewaySummary.textContent = label + ' is ready for your ' + frequency + ' ' + state.currency + ' donation.';
    }

    function buildPaypalReference() {
      return 'paypal_' + Date.now() + '_' + Math.random().toString(36).slice(2, 8);
    }

    function submitPaypal(data) {
      const reference = buildPaypalReference();
      const custom = JSON.stringify({
        gateway: 'paypal',
        type: state.type,
        currency: state.currency,
        reference: reference
      });
      const form = document.createElement('form');
      form.method = 'post';
      form.action = paypalConfig.action;

      const fields = state.type === 'recurring'
        ? {
            cmd: '_xclick-subscriptions',
            business: paypalConfig.business,
            item_name: 'RCN Mission Hospital Monthly Partnership',
            currency_code: state.currency,
            a3: String(data.amount),
            p3: '1',
            t3: 'M',
            src: '1',
            sra: '1',
            no_note: '1',
            return: paypalConfig.returnUrl,
            cancel_return: paypalConfig.cancelUrl,
            notify_url: paypalConfig.notifyUrl,
            custom: custom
          }
        : {
            cmd: '_donations',
            business: paypalConfig.business,
            item_name: 'RCN Mission Hospital Donation',
            currency_code: state.currency,
            amount: String(data.amount),
            no_shipping: '1',
            return: paypalConfig.returnUrl,
            cancel_return: paypalConfig.cancelUrl,
            notify_url: paypalConfig.notifyUrl,
            custom: custom
          };

      Object.keys(fields).forEach(function(key) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = fields[key];
        form.appendChild(input);
      });

      document.body.appendChild(form);
      form.submit();
    }

    async function submitGatewayInit(data) {
      submitButton.disabled = true;
      submitButton.textContent = 'Preparing checkout...';
      try {
        const response = await fetch('<?php echo url('api/payments/init.php'); ?>', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            gateway: state.gateway,
            type: state.type,
            currency: state.currency,
            amount: data.amount,
            email: data.email,
            name: data.name
          })
        });
        const json = await response.json();
        if (!json || !json.ok || !json.data || !json.data.redirect_url) {
          throw new Error((json && json.data && json.data.error) || 'Unable to initialize checkout.');
        }
        window.location.href = json.data.redirect_url;
      } catch (error) {
        notify('error', 'Checkout error', error.message || 'Unable to initialize payment.');
      } finally {
        submitButton.disabled = false;
        submitButton.textContent = 'Continue To Secure Checkout';
      }
    }

    donationForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const email = document.getElementById('donorEmail').value.trim();
      const name = document.getElementById('donorName').value.trim();
      const amount = parseFloat(donationAmount.value);

      if (!email || !/.+@.+\..+/.test(email)) {
        notify('error', 'Invalid email', 'Please enter a valid email address.');
        return;
      }
      if (!amount || amount <= 0) {
        notify('error', 'Invalid amount', 'Please enter a valid donation amount.');
        return;
      }
      if (!state.gateway) {
        notify('error', 'No gateway available', 'Choose another currency or use bank transfer.');
        return;
      }

      const payload = { email: email, name: name || 'Donor', amount: amount };
      if (state.gateway === 'paypal') {
        submitPaypal(payload);
        return;
      }
      submitGatewayInit(payload);
    });

    document.querySelectorAll('.donation-toggle').forEach(function(button) {
      button.addEventListener('click', function() {
        state.type = this.dataset.value;
        setActiveButton('.donation-toggle', 'data-value', state.type);
        renderAmountSuggestions();
        renderGateways();
      });
    });

    document.querySelectorAll('.currency-toggle').forEach(function(button) {
      button.addEventListener('click', function() {
        state.currency = this.dataset.currency;
        setActiveButton('.currency-toggle', 'data-currency', state.currency);
        renderAmountSuggestions();
        renderGateways();
      });
    });

    setActiveButton('.donation-toggle', 'data-value', state.type);
    setActiveButton('.currency-toggle', 'data-currency', state.currency);
    renderAmountSuggestions();
    renderGateways();
  })();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
