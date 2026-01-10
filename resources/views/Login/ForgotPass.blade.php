<!doctype html>
<html lang="en" class="antialiased scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Forgot Password — Athlentry Studio</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand: #0d9488;
      --brand-dark: #0f766e;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f8fafc;
      color: #0f172a;
    }

    .glass-panel {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(14px);
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
      box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.15);
    }

    .btn-studio {
      background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
      box-shadow: 0 10px 30px rgba(13, 148, 136, 0.25);
      transition: all 0.3s ease;
    }

    .btn-studio:hover:not(:disabled) {
      transform: translateY(-2px);
      filter: brightness(1.1);
    }

    .role-pill {
      padding: 0.5rem 1rem;
      border-radius: 999px;
      font-size: 10px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.1em;
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

@php $isAdmin = request()->query('role') === 'admin'; @endphp

<main class="panel-grid">

  <aside class="hero-side hidden lg:flex flex-col justify-between p-16">
    <div class="blur-blob -top-24 -left-24"></div>

    <div class="relative z-10">
      <div class="flex items-center gap-4 mb-12">
        <div class="w-12 h-12 bg-[color:var(--brand)] rounded-2xl flex items-center justify-center shadow-lg shadow-teal-900/20">
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
          Recover <br><span class="text-[color:var(--brand)] not-italic">Access.</span>
        </h2>
        <p class="text-slate-700 text-lg font-medium leading-relaxed">
          Security protocol initiated. Students may verify identity to establish a new access key.
          Administrative accounts require manual authorization.
        </p>
      </div>
    </div>

    <div class="relative z-10 flex items-center gap-8 text-[10px] font-black uppercase tracking-[0.3em] text-slate-500">
      <span>© {{ date('Y') }} Security Module</span>
      <div class="w-12 h-px bg-slate-300"></div>
      <span>v2.0 Beta</span>
    </div>
  </aside>

  <section class="flex items-center justify-center p-8 lg:p-16 bg-white border-l border-slate-200">
    <div class="w-full max-w-lg fade-in">

      <div class="mb-10">
        <div class="flex justify-between items-end mb-2">
          <h2 class="text-3xl font-black tracking-tight uppercase italic text-slate-900">
            CHANGE YOUR <span class="text-[color:var(--brand)] not-italic">PASSWORD</span>
          </h2>
          <a href="{{ route('login.view') }}"
             class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-[color:var(--brand)]">
            ← Back
          </a>
        </div>
        <div class="h-1 w-12 bg-[color:var(--brand)] rounded-full"></div>
      </div>

      @if(session('status'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-600 text-xs font-bold uppercase tracking-wide">
          {{ session('status') }}
        </div>
      @endif

      @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-600 text-xs font-bold uppercase tracking-wide">
          {!! implode('<br>', $errors->all()) !!}
        </div>
      @endif

      @if($isAdmin)
        <div class="mb-6 p-5 rounded-[2rem] bg-yellow-50 border border-yellow-200 text-yellow-600">
          <p class="text-[10px] font-black uppercase tracking-widest leading-relaxed">
            Administrative Alert: Self-service recovery is restricted. Please contact system administrator.
          </p>
        </div>
      @endif

      <form id="forgotForm" method="POST" action="{{ route('student.password.reset') }}"
            class="space-y-6 @if($isAdmin) opacity-40 pointer-events-none @endif" novalidate>
        @csrf

        <div class="flex items-center gap-3 mb-8">
          <span class="role-pill {{ !$isAdmin ? 'bg-[color:var(--brand)] text-white' : 'bg-slate-200 text-slate-500' }}">Student</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">Matric ID</label>
            <input name="matric_no" type="text" value="{{ old('matric_no') }}" required
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm"
                   placeholder="CB22000">
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">Email (Optional)</label>
            <input name="email" type="email" value="{{ old('email') }}"
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm"
                   placeholder="name@gmail.com">
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">New Password</label>
          <div class="relative">
            <input id="new_password" name="password" type="password" required
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm"
                   placeholder="Min. 8 characters">
            <button type="button" id="toggleNewPwd"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[9px] font-black uppercase text-slate-500 hover:text-slate-900">
              Show
            </button>
          </div>

          <div class="flex items-center justify-between px-1 mt-2">
            <div class="flex gap-1">
              <div id="str-1" class="h-1 w-4 rounded-full bg-slate-200"></div>
              <div id="str-2" class="h-1 w-4 rounded-full bg-slate-200"></div>
              <div id="str-3" class="h-1 w-4 rounded-full bg-slate-200"></div>
              <div id="str-4" class="h-1 w-4 rounded-full bg-slate-200"></div>
            </div>
            <span id="strengthLabel" class="text-[9px] font-black uppercase tracking-widest text-slate-500">
              Strength: —
            </span>
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">Confirm Password</label>
          <input id="new_password_confirm" name="password_confirmation" type="password" required
                 class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm">
        </div>

        <div id="clientMsg" class="hidden text-[10px] font-bold uppercase tracking-wide text-red-600"></div>

        <div class="pt-4 space-y-4">
          <button id="forgotSubmit" type="submit"
                  class="btn-studio w-full rounded-2xl py-5 text-white text-[11px] font-black uppercase tracking-[0.2em]">
            Reset Password
          </button>

          <button type="button"
                  onclick="window.location.href='{{ route('login.view') }}'"
                  class="w-full py-4 rounded-2xl border border-slate-200 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-slate-100">
            Request Support Hub
          </button>
        </div>
      </form>

    </div>
  </section>

</main>

<script>
(function(){
  const pwd = document.getElementById('new_password');
  const confirm = document.getElementById('new_password_confirm');
  const label = document.getElementById('strengthLabel');
  const btn = document.getElementById('forgotSubmit');
  const msg = document.getElementById('clientMsg');

  document.getElementById('toggleNewPwd').onclick = () => {
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
  };

  pwd.addEventListener('input', () => {
    let s = 0, v = pwd.value;
    if (v.length >= 8) s++;
    if (/[A-Z]/.test(v)) s++;
    if (/\d/.test(v)) s++;
    if (/[\W_]/.test(v)) s++;

    const colors = ['#cbd5e1','#ef4444','#f59e0b','#10b981','#0d9488'];
    const labels = ['—','Very weak','Weak','Good','Strong'];

    label.textContent = `Strength: ${labels[s]}`;
    label.style.color = colors[s];

    for(let i=1;i<=4;i++){
      document.getElementById(`str-${i}`).style.backgroundColor =
        i<=s ? colors[s] : '#e5e7eb';
    }
  });

  document.getElementById('forgotForm').onsubmit = e => {
    msg.classList.add('hidden');

    if (pwd.value.length < 8) {
      e.preventDefault();
      msg.textContent = 'Minimum 8 characters required.';
      msg.classList.remove('hidden');
      return;
    }
    if (pwd.value !== confirm.value) {
      e.preventDefault();
      msg.textContent = 'Password confirmation does not match.';
      msg.classList.remove('hidden');
      return;
    }

    btn.disabled = true;
    btn.innerHTML = 'PROCESSING...';
  };
})();
</script>

</body>
</html>
