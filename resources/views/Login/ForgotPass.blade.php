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
      --brand: #800000;
      --brand-dark: #4a0000;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #0c0c0c;
      color: #f8fafc;
    }

    /* Studio Glass Effect */
    .glass-panel {
      background: rgba(255, 255, 255, 0.03);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.08);
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
      background: radial-gradient(circle at 0% 0%, #3a0000 0%, #0c0c0c 70%);
      overflow: hidden;
    }

    .form-input {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: white;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.08);
      border-color: var(--brand);
      box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.2);
    }

    .btn-studio {
      background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
      box-shadow: 0 10px 30px rgba(128, 0, 0, 0.3);
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
      transition: all 0.3s ease;
    }

    .fade-in { animation: fadeIn 0.8s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    .blur-blob {
      position: absolute;
      width: 400px;
      height: 400px;
      background: var(--brand);
      filter: blur(120px);
      opacity: 0.15;
    }
  </style>
</head>
<body>

@php $isAdmin = request()->query('role') === 'admin'; @endphp

<main class="panel-grid">

  {{-- LEFT SIDE: EDITORIAL BRANDING --}}
  <aside class="hero-side hidden lg:flex flex-col justify-between p-16">
    <div class="blur-blob top-0 left-0"></div>
    
    <div class="relative z-10">
      <div class="flex items-center gap-4 mb-12">
        <div class="w-12 h-12 bg-[color:var(--brand)] rounded-2xl flex items-center justify-center shadow-lg shadow-red-900/40">
           <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <h1 class="text-2xl font-extrabold tracking-tighter italic uppercase">ATHLENTRY <span class="text-[color:var(--brand)] not-italic">STUDIO</span></h1>
      </div>

      <div class="max-w-md">
        <h2 class="text-6xl font-black leading-[0.9] tracking-tighter mb-6 uppercase italic">Recover <br><span class="text-[color:var(--brand)] not-italic">Access.</span></h2>
        <p class="text-slate-400 text-lg font-medium leading-relaxed">
          Security protocol initiated. Students may verify their identity to establish a new access key. Admin accounts require manual authorization.
        </p>
      </div>
    </div>

    <div class="relative z-10 flex items-center gap-8 text-[10px] font-black uppercase tracking-[0.3em] text-slate-500">
      <span>© {{ date('Y') }} Security Module</span>
      <div class="w-12 h-px bg-slate-800"></div>
      <span>v2.0 Beta</span>
    </div>
  </aside>

  {{-- RIGHT SIDE: RECOVERY FORM --}}
  <section class="flex items-center justify-center p-8 lg:p-16 bg-[#0f0f0f] border-l border-white/5">
    <div class="w-full max-w-lg fade-in">
      
      <div class="mb-10">
        <div class="flex justify-between items-end mb-2">
          <h2 class="text-3xl font-black tracking-tight uppercase italic">IDENTITY <span class="text-[color:var(--brand)] not-italic">RECOVERY</span></h2>
          <a href="{{ route('login.view') }}" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors">← Back</a>
        </div>
        <div class="h-1 w-12 bg-[color:var(--brand)] rounded-full"></div>
      </div>

      {{-- Alerts --}}
      @if(session('status'))
        <div class="mb-6 p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-bold uppercase tracking-wide">
          {{ session('status') }}
        </div>
      @endif

      @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold uppercase tracking-wide">
          {!! implode('<br>', $errors->all()) !!}
        </div>
      @endif

      @if($isAdmin)
        <div class="mb-6 p-5 rounded-[2rem] bg-yellow-500/10 border border-yellow-500/20 text-yellow-500">
          <p class="text-[10px] font-black uppercase tracking-widest leading-relaxed">
            Administrative Alert: Self-service recovery is restricted for level-1 access. Please contact the Systems Administrator.
          </p>
        </div>
      @endif

      <form id="forgotForm" method="POST" action="{{ route('student.password.reset') }}" class="space-y-6 @if($isAdmin) opacity-30 pointer-events-none @endif" novalidate>
        @csrf

        {{-- Role View (Static) --}}
        <div class="flex items-center gap-3 mb-8">
            <span class="role-pill {{ $isAdmin ? 'bg-slate-800 text-slate-500' : 'bg-[color:var(--brand)] text-white shadow-lg shadow-red-900/20' }}">Student</span>
            <span class="role-pill {{ $isAdmin ? 'bg-[color:var(--brand)] text-white shadow-lg shadow-red-900/20' : 'bg-slate-800 text-slate-500' }}">Admin</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Matric Number</label>
            <input id="matric_no" name="matric_no" type="text" value="{{ old('matric_no') }}" required
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm" placeholder="CB22000">
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Email (Optional)</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm" placeholder="you@campus.edu">
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">New Access Key</label>
          <div class="relative">
            <input id="new_password" name="password" type="password" required
                   class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm" placeholder="Min. 8 Characters">
            <button type="button" id="toggleNewPwd" class="absolute right-4 top-1/2 -translate-y-1/2 text-[9px] font-black uppercase text-slate-500 hover:text-white">Show</button>
          </div>
          <div class="flex items-center justify-between px-1 mt-2">
            <div class="flex gap-1">
                <div id="str-1" class="h-1 w-4 rounded-full bg-slate-800 transition-all"></div>
                <div id="str-2" class="h-1 w-4 rounded-full bg-slate-800 transition-all"></div>
                <div id="str-3" class="h-1 w-4 rounded-full bg-slate-800 transition-all"></div>
                <div id="str-4" class="h-1 w-4 rounded-full bg-slate-800 transition-all"></div>
            </div>
            <span id="strengthLabel" class="text-[9px] font-black uppercase tracking-widest text-slate-600">Strength: —</span>
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Confirm New Key</label>
          <input id="new_password_confirm" name="password_confirmation" type="password" required
                 class="form-input w-full rounded-2xl px-5 py-4 font-bold text-sm" placeholder="Retype Password">
        </div>

        <div id="clientMsg" class="hidden text-[10px] font-bold uppercase tracking-wide text-red-500 p-2"></div>

        <div class="pt-4 space-y-4">
          <button type="submit" id="forgotSubmit"
                  class="btn-studio w-full rounded-2xl py-5 text-white text-[11px] font-black uppercase tracking-[0.2em]">
            Authorize Reset
          </button>
          
          <button type="button" class="w-full py-4 rounded-2xl border border-white/5 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-white/5 transition-all" 
                  onclick="window.location.href='{{ route('login.view') }}'">
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
    const pwdConfirm = document.getElementById('new_password_confirm');
    const strengthLabel = document.getElementById('strengthLabel');
    const form = document.getElementById('forgotForm');
    const submitBtn = document.getElementById('forgotSubmit');
    const clientMsg = document.getElementById('clientMsg');

    // Toggle Password
    document.getElementById('toggleNewPwd').addEventListener('click', function() {
      pwd.type = pwd.type === 'password' ? 'text' : 'password';
      this.textContent = pwd.type === 'password' ? 'Show' : 'Hide';
    });

    // Password strength logic
    pwd.addEventListener('input', function() {
      let score = 0;
      const val = pwd.value;
      if (val.length >= 8) score++;
      if (/[A-Z]/.test(val)) score++;
      if (/\d/.test(val)) score++;
      if (/[\W_]/.test(val)) score++;

      const colors = ['#1e293b', '#ef4444', '#f59e0b', '#10b981', '#800000'];
      const labels = ['—', 'Very weak', 'Weak', 'Good', 'Strong'];
      
      strengthLabel.textContent = `Strength: ${labels[score]}`;
      strengthLabel.style.color = score > 0 ? colors[score] : '#475569';
      
      for(let i=1; i<=4; i++) {
        document.getElementById(`str-${i}`).style.backgroundColor = (i <= score) ? colors[score] : '#1e293b';
      }
    });

    // Client Validation
    form.addEventListener('submit', function(e) {
      clientMsg.classList.add('hidden');
      
      if (pwd.value.length < 8) {
        e.preventDefault();
        clientMsg.textContent = "Security constraint: Minimum 8 characters required.";
        clientMsg.classList.remove('hidden');
        return;
      }
      if (pwd.value !== pwdConfirm.value) {
        e.preventDefault();
        clientMsg.textContent = "Credential mismatch: Confirmation does not match.";
        clientMsg.classList.remove('hidden');
        return;
      }

      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="animate-pulse tracking-[0.4em]">PROCESSING...</span>';
    });
  })();
</script>

</body>
</html>