<!doctype html>
<html lang="en" class="antialiased scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Athlentry — Join the Studio</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand: #800000;
      --brand-dark: #4a0000;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f8fafc;
      color: #0f172a;
    }

    /* Glass Panel */
    .glass-panel {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border: 1px solid rgba(15, 23, 42, 0.08);
    }

    .panel-grid {
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1fr;
    }

    @media(min-width:1024px) {
      .panel-grid { grid-template-columns: 1.1fr 0.9fr; }
    }

    .hero-side {
      position: relative;
      background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
      overflow: hidden;
    }

    .blur-blob {
      position: absolute;
      width: 420px;
      height: 420px;
      background: var(--brand);
      filter: blur(120px);
      opacity: 0.08;
      z-index: 0;
    }

    .form-input {
      background: #ffffff;
      border: 1px solid rgba(15, 23, 42, 0.15);
      color: #0f172a;
      transition: all 0.3s ease;
    }

    .form-input:focus {
      outline: none;
      border-color: var(--brand);
      box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.15);
      transform: translateY(-1px);
    }

    .form-input::placeholder {
      color: #94a3b8;
    }

    .btn-studio {
      background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
      transition: all 0.3s ease;
      box-shadow: 0 10px 30px rgba(128, 0, 0, 0.25);
    }

    .btn-studio:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 15px 40px rgba(128, 0, 0, 0.35);
      filter: brightness(1.1);
    }

    .btn-studio:active {
      transform: translateY(0);
    }

    .fade-in {
      animation: fadeIn 0.8s ease-out forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>

<main class="panel-grid">

  {{-- LEFT SIDE: BRANDING --}}
  <aside class="hero-side hidden lg:flex flex-col justify-between p-16">
    <div class="blur-blob -top-24 -left-24"></div>

    <div class="relative z-10">
      <div class="flex items-center gap-4 mb-12">
        <div class="w-12 h-12 bg-[color:var(--brand)] rounded-2xl flex items-center justify-center shadow-lg shadow-red-900/20">
          <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <h1 class="text-2xl font-extrabold tracking-tighter italic uppercase text-slate-900">
          ATHLENTRY <span class="text-[color:var(--brand)] not-italic">STUDIO</span>
        </h1>
      </div>

      <div class="max-w-md">
        <h2 class="text-6xl font-black leading-[0.9] tracking-tighter mb-6 uppercase italic text-slate-900">
          Built for the <br>
          <span class="text-[color:var(--brand)] not-italic">ELITE.</span>
        </h2>
        <p class="text-slate-700 text-lg font-medium leading-relaxed">
          The central hub for campus athletes. Register your profile to access premium tournament registries and track your performance history.
        </p>
      </div>
    </div>

    <div class="relative z-10 flex items-center gap-8 text-[10px] font-black uppercase tracking-[0.3em] text-slate-500">
      <span>© {{ date('Y') }} Registry Module</span>
      <div class="w-12 h-px bg-slate-300"></div>
      <span>v2.0 Beta</span>
    </div>
  </aside>

  {{-- RIGHT SIDE: REGISTER FORM --}}
  <section class="flex items-center justify-center p-8 lg:p-16 bg-white">
    <div class="w-full max-w-lg fade-in">

      <div class="mb-10">
        <div class="flex justify-between items-end mb-2">
          <h2 class="text-3xl font-black tracking-tight uppercase italic text-slate-900">
            JOIN THE <span class="text-[color:var(--brand)] not-italic">RANK.</span>
          </h2>
          <a href="{{ route('login.view') }}"
             class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-[color:var(--brand)]">
            Login →
          </a>
        </div>
        <div class="h-1 w-12 bg-[color:var(--brand)] rounded-full"></div>
      </div>

      @if ($errors->any())
        <div class="mb-8 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-600 text-xs font-bold uppercase tracking-wide">
          <ul class="space-y-1">
            @foreach ($errors->all() as $error)
              <li class="flex items-center gap-2">
                <span class="w-1 h-1 bg-red-500 rounded-full"></span>
                {{ $error }}
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      <form id="registerForm" action="{{ route('student.register.submit') }}" method="POST" class="space-y-6" novalidate>
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">Full Name</label>
            <input type="text" name="Name" value="{{ old('Name') }}" required
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm"
                   placeholder="Ahmad Zulkifli">
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">Matric ID</label>
            <input type="text" name="MatricNo" value="{{ old('MatricNo') }}" required
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm uppercase"
                   placeholder="CB22000">
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">Campus Email</label>
          <input type="email" name="Email" value="{{ old('Email') }}" required
                 class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm"
                 placeholder="name@student.edu">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">Access Password</label>
            <div class="relative">
              <input id="password" type="password" name="password" required
                     class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm"
                     placeholder="••••••••">
              <button type="button" id="togglePwd"
                      class="absolute right-4 top-1/2 -translate-y-1/2 text-[9px] font-black uppercase tracking-tighter text-slate-500 hover:text-slate-900">
                Show
              </button>
            </div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">Confirm Access</label>
            <input id="password_confirm" type="password" name="password_confirmation" required
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm"
                   placeholder="••••••••">
          </div>
        </div>

        {{-- Password Strength --}}
        <div class="flex items-center gap-3 px-1">
          <div class="flex-1 h-1 bg-slate-200 rounded-full overflow-hidden">
            <div id="strengthBar" class="h-full w-0 transition-all duration-500"></div>
          </div>
          <span id="pwdStrength" class="text-[9px] font-black uppercase tracking-widest text-slate-500">
            Security: —
          </span>
        </div>

        <div class="pt-4">
          <button type="submit" id="registerBtn"
                  class="btn-studio w-full rounded-2xl py-5 text-white text-[11px] font-black uppercase tracking-[0.2em]">
            Establish Account
          </button>
        </div>

        <p class="text-center text-[10px] text-slate-500 font-bold uppercase tracking-widest">
          By registering, you agree to the
          <a href="#" class="text-slate-900 hover:text-[color:var(--brand)]">Athlete Terms</a>
        </p>
      </form>

    </div>
  </section>

</main>

<script>
(function () {
  const form = document.getElementById('registerForm');
  const pwd = document.getElementById('password');
  const confirmInput = document.getElementById('password_confirm');
  const toggle = document.getElementById('togglePwd');
  const strengthText = document.getElementById('pwdStrength');
  const strengthBar = document.getElementById('strengthBar');
  const btn = document.getElementById('registerBtn');

  toggle.addEventListener('click', () => {
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
    toggle.textContent = pwd.type === 'password' ? 'Show' : 'Hide';
  });

  pwd.addEventListener('input', () => {
    let s = 0;
    const v = pwd.value;
    if (v.length >= 8) s++;
    if (/[A-Z]/.test(v)) s++;
    if (/\d/.test(v)) s++;
    if (/[\W_]/.test(v)) s++;

    const colors = ['#cbd5f5', '#ef4444', '#f59e0b', '#10b981', '#800000'];
    const labels = ['—', 'Weak', 'Fair', 'Good', 'Strong'];
    const widths = ['0%', '25%', '50%', '75%', '100%'];

    strengthBar.style.width = widths[s];
    strengthBar.style.backgroundColor = colors[s];
    strengthText.textContent = `Security: ${labels[s]}`;
    strengthText.style.color = s > 0 ? colors[s] : '#64748b';
  });

  form.addEventListener('submit', e => {
    if (pwd.value !== confirmInput.value) {
      e.preventDefault();
      alert('Credentials do not match.');
      return;
    }
    btn.disabled = true;
    btn.innerHTML = 'INITIALIZING...';
  });
})();
</script>

</body>
</html>
