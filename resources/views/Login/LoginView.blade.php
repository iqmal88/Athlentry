<!doctype html>
<html lang="en" class="antialiased scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Athlentry — Access Portal</title>

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

    /* Glass Panels */
    .glass-card {
      background: rgba(255, 255, 255, 0.75);
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

    /* Input Styling */
    .form-input {
      background: #ffffff;
      border: 1px solid rgba(15, 23, 42, 0.15);
      color: #0f172a;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-input:focus {
      outline: none;
      background: #ffffff;
      border-color: var(--brand);
      box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.15);
    }

    /* Animations */
    .fade-in { animation: fadeIn 0.8s ease-out forwards; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .blur-blob {
      position: absolute;
      width: 500px;
      height: 500px;
      background: var(--brand);
      filter: blur(120px);
      opacity: 0.08;
      z-index: 0;
    }
  </style>
</head>
<body class="overflow-hidden">

<main class="panel-grid relative">
  <div class="blur-blob -top-24 -left-24"></div>

  {{-- LEFT SIDE: BRANDING --}}
  <aside class="hidden lg:flex flex-col justify-between p-16 relative z-10 bg-gradient-to-br from-white to-slate-100">
    <div>
      <div class="flex items-center gap-4 mb-20">
        <div class="w-12 h-12 bg-[color:var(--brand)] rounded-2xl flex items-center justify-center shadow-lg shadow-red-900/20">
          <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <h1 class="text-2xl font-extrabold tracking-tighter italic uppercase text-slate-900">
          ATHLENTRY <span class="text-[color:var(--brand)] not-italic">STUDIO</span>
        </h1>
      </div>

      <div class="max-w-md">
        <h2 class="text-7xl font-black leading-[0.85] tracking-tighter mb-8 uppercase italic text-slate-900">
          Enter the <br><span class="text-[color:var(--brand)] not-italic">Arena.</span>
        </h2>
        <p class="text-slate-700 text-lg font-medium leading-relaxed">
          The unified registry for student athletes. Securely manage your matches, track progress, and stay updated with the sports community.
        </p>
      </div>
    </div>

    <div class="flex items-center gap-8 text-[10px] font-black uppercase tracking-[0.4em] text-slate-500">
      <span>Persatuan Mahasiswa Teknologi Komputer</span>
      <div class="w-12 h-px bg-slate-300"></div>
      <span>Faculty of Computing</span>
    </div>
  </aside>

  {{-- RIGHT SIDE: LOGIN --}}
  <section class="flex items-center justify-center p-8 lg:p-16 bg-white relative z-10 border-l border-slate-200">
    <div class="w-full max-w-md fade-in">

      <header class="mb-10 text-center lg:text-left">
        <h2 class="text-3xl font-black tracking-tight uppercase italic mb-2 text-slate-900">
          Access <span class="text-[color:var(--brand)] not-italic">Portal</span>
        </h2>
        <p class="text-slate-600 text-sm font-bold uppercase tracking-widest">
          Login to continue
        </p>
      </header>

      {{-- Error Alert --}}
      @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-600 text-xs font-bold uppercase tracking-wide">
          {!! implode('<br>', $errors->all()) !!}
        </div>
      @endif

      <form id="loginForm" method="POST" action="{{ route('login.submit') }}" class="space-y-6" novalidate>
        @csrf

        {{-- Role Selector --}}
        <div class="p-1 bg-slate-100 rounded-2xl flex gap-1 mb-8">
          <button type="button" class="role-tab flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest bg-[color:var(--brand)] text-white shadow-lg" data-role="student">
            Student
          </button>
          <button type="button" class="role-tab flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-slate-900" data-role="admin">
            Administrator
          </button>
        </div>

        {{-- Identifier --}}
        <div class="space-y-2">
          <label id="identifierLabel" class="text-[10px] font-black uppercase tracking-widest text-slate-600 ml-1">
            Matric ID
          </label>
          <input id="identifier" name="identifier" type="text" required
                 value="{{ old('identifier') }}"
                 class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm"
                 placeholder="e.g. CB22047">
        </div>

        {{-- Password --}}
        <div class="space-y-2">
          <div class="flex items-center justify-between px-1">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-600">Password</label>
            <a href="{{ route('login.forgot.view') }}" class="text-[9px] font-black uppercase tracking-widest text-slate-500 hover:text-[color:var(--brand)]">
              Forgot Password?
            </a>
          </div>
          <div class="relative">
            <input id="password" name="password" type="password" required
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm"
                   placeholder="••••••••">
            <button type="button" id="togglePassword"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[9px] font-black uppercase tracking-tighter text-slate-500 hover:text-slate-900">
              Show
            </button>
          </div>
        </div>

        {{-- Utilities --}}
        <div class="flex items-center justify-between px-1">
          <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-slate-300 bg-white text-[color:var(--brand)] focus:ring-0">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">
              Remember Me
            </span>
          </label>
          <a href="{{ route('student.register.view') }}"
             class="text-[10px] font-black uppercase tracking-widest text-[color:var(--brand)] underline underline-offset-4">
            Register
          </a>
        </div>

        <input type="hidden" name="matric_no" id="matric_no_hidden">

        <button id="submitBtn" type="submit"
                class="w-full py-5 rounded-2xl text-white text-[11px] font-black uppercase tracking-[0.3em]"
                style="background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
                       box-shadow: 0 10px 30px rgba(128, 0, 0, 0.25);">
          Login
        </button>
      </form>

      <footer class="mt-12 text-center">
        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-500">
          Official Tournament System <br> © {{ date('Y') }} All Rights Reserved
        </p>
      </footer>

    </div>
  </section>
</main>

<script>
(function () {
  const roleTabs = document.querySelectorAll('.role-tab');
  const form = document.getElementById('loginForm');
  const identifier = document.getElementById('identifier');
  const label = document.getElementById('identifierLabel');
  const hiddenMatric = document.getElementById('matric_no_hidden');
  const btn = document.getElementById('submitBtn');

  function setRole(role) {
    roleTabs.forEach(tab => {
      const active = tab.dataset.role === role;
      tab.classList.toggle('bg-[color:var(--brand)]', active);
      tab.classList.toggle('text-white', active);
      tab.classList.toggle('shadow-lg', active);
      tab.classList.toggle('text-slate-500', !active);
    });

    if (role === 'admin') {
      form.action = "{{ route('admin.login.submit') }}";
      label.textContent = 'Admin ID';
      identifier.placeholder = 'ADMIN-8820';
    } else {
      form.action = "{{ route('login.submit') }}";
      label.textContent = 'Matric ID';
      identifier.placeholder = 'e.g. CB22047';
    }
  }

  roleTabs.forEach(tab => tab.addEventListener('click', () => setRole(tab.dataset.role)));
  setRole('student');

  document.getElementById('togglePassword').onclick = () => {
    const pwd = document.getElementById('password');
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
  };

  form.addEventListener('submit', () => {
    hiddenMatric.value = identifier.value;
    btn.innerHTML = 'Authorizing...';
    btn.style.opacity = '0.7';
  });
})();
</script>

</body>
</html>
