<!doctype html>
<html lang="en" class="antialiased">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Forgot Password — Athlentry</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --maroon:#8B1E2F;
      --maroon-dark:#5e101b;
      --muted:#6b7280;
      --surface:#ffffff;
    }

    html,body { height:100%; margin:0; }
    body{
      font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      background: linear-gradient(180deg,#fbfbfe,#f6f5fb);
    }

    /* full-bleed split layout */
    .panel-grid { min-height:100vh; display:grid; grid-template-columns:1fr; }
    @media(min-width:768px){ .panel-grid { grid-template-columns:1fr 520px; } }

    .left-illustration {
      padding:5rem 3rem;
      background:
        radial-gradient(circle at 10% 20%, rgba(139,30,47,0.04) 0.6px, transparent 0.6px),
        linear-gradient(180deg,#fff6f6,#ffffff);
      display:flex;
      flex-direction:column;
      justify-content:space-between;
    }

    /* Form panel has NO centered card / container — inputs sit directly on panel */
    .form-panel {
      display:flex;
      align-items:center;
      justify-content:center;
      padding:3rem 2rem;
      background:var(--surface);
    }

    .form-body {
      width:100%;
      max-width:36rem;
    }

    .form-section {
      background: transparent; /* no card background */
      border-radius: 0;
      padding: 0;
    }

    .form-input:focus {
      outline:none;
      box-shadow: 0 10px 28px rgba(139,30,47,0.08), 0 0 0 4px rgba(139,30,47,0.06);
      border-color: var(--maroon);
    }

    .role-pill { display:inline-flex; align-items:center; gap:.5rem; padding:.45rem .7rem; border-radius:999px; font-weight:600; cursor:pointer; }
    .role-pill[aria-selected="true"] { background:var(--maroon); color:white; }
    .role-pill[aria-selected="false"] { background:#f3f3f4; color:var(--muted); }

    .hint { color:var(--muted); font-size:.95rem; }
    .muted-link { color:var(--maroon); font-weight:600; }
  </style>
</head>
<body>

  @php $isAdmin = request()->query('role') === 'admin'; @endphp

  <!-- Full-bleed split panels (no centered container) -->
  <main class="panel-grid">

    <!-- Left: branding & illustration (hidden on small screens) -->
    <aside class="left-illustration hidden md:flex" aria-hidden="true">
      <div>
        <div class="flex items-center gap-3 mb-6">
          <img src="{{ asset('images/Athlentry-logo.png') }}" class="h-12 w-auto object-contain" alt="Athlentry logo">
          <span class="inline-block bg-[color:var(--maroon)] text-white text-sm px-3 py-1 rounded-full font-semibold">Athlentry</span>
        </div>

        <h2 class="text-3xl font-bold text-slate-900 leading-tight mb-3">Reset your password</h2>
        <p class="hint max-w-xs">Use this form to reset your student password. Admin accounts cannot reset here — contact IT/support.</p>

        <div class="mt-8">
          <svg viewBox="0 0 560 300" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <ellipse cx="280" cy="200" rx="220" ry="70" fill="rgba(139,30,47,0.06)" />
            <circle cx="120" cy="120" r="26" fill="white" stroke="rgba(139,30,47,0.18)" stroke-width="3"/>
            <circle cx="420" cy="210" r="34" fill="white" stroke="rgba(94,16,27,0.18)" stroke-width="3"/>
            <path d="M80 200 Q260 120 520 190" stroke="rgba(139,30,47,0.25)" stroke-width="18" stroke-linecap="round"/>
          </svg>
        </div>
      </div>

      <div class="text-xs text-slate-400">© {{ date('Y') }} Athlentry</div>
    </aside>

    <!-- Right: form panel (no container) -->
    <section class="form-panel">
      <div class="form-body">

        <div class="form-section mb-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-semibold text-slate-900">Forgot password</h1>
              <p class="text-sm hint mt-1">Student password recovery</p>
            </div>

            <a href="{{ route('login.view') }}" class="text-sm hint hover:underline">Back</a>
          </div>
        </div>

        {{-- Session / errors --}}
        @if(session('status'))
          <div class="mb-4 rounded-md bg-green-50 border border-green-100 text-green-700 p-3 text-sm">
            {{ session('status') }}
          </div>
        @endif

        @if($errors->any())
          <div class="mb-4 rounded-md bg-red-50 border border-red-100 text-red-700 p-3 text-sm">
            {!! implode('<br>', $errors->all()) !!}
          </div>
        @endif

        @if($isAdmin)
          <div class="mb-4 rounded-md bg-yellow-50 border border-yellow-100 text-yellow-800 p-3 text-sm">
            Admin accounts cannot reset passwords here. Please contact IT/support.
          </div>
        @endif

        <!-- FORM: kept server behavior unchanged -->
        <form id="forgotForm" method="POST" action="{{ route('student.password.reset') }}" class="@if($isAdmin) opacity-70 pointer-events-none @endif">
          @csrf

          <!-- role pills for clarity -->
          <div class="mb-4 flex items-center gap-3" role="tablist" aria-label="Role">
            <div class="role-pill" role="tab" aria-selected="{{ $isAdmin ? 'false' : 'true' }}" data-role="student">Student</div>
            <div class="role-pill" role="tab" aria-selected="{{ $isAdmin ? 'true' : 'false' }}" data-role="admin">Admin</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Matric Number</label>
            <input id="matric_no" name="matric_no" type="text" value="{{ old('matric_no') }}" required
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg" placeholder="e.g. CB22047">
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Email (optional)</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg" placeholder="your@campus.edu">
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
            <div class="relative">
              <input id="new_password" name="password" type="password" required
                     class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg" placeholder="At least 8 characters">
              <button type="button" id="toggleNewPwd" class="absolute right-2 top-2.5 text-sm text-slate-500 hover:text-slate-700">Show</button>
            </div>
            <p id="pwStrength" class="text-xs hint mt-2">Strength: <strong id="strengthLabel">—</strong></p>
          </div>

          <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 mb-1">Confirm New Password</label>
            <input id="new_password_confirm" name="password_confirmation" type="password" required
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg" placeholder="Retype new password">
          </div>

          <div id="clientMsg" class="hidden mb-4 text-sm rounded p-3"></div>

          <div class="mb-3">
            <button type="submit" id="forgotSubmit" class="w-full py-3 rounded-lg text-white font-semibold" style="background: linear-gradient(90deg,var(--maroon),var(--maroon-dark));">
              Reset Password
            </button>
          </div>

          <div class="mb-6">
            <button type="button" class="w-full py-3 rounded-lg border border-slate-200 text-slate-700 text-sm" onclick="window.location.href='{{ route('login.view') }}'">
              Contact IT / Help
            </button>
          </div>

          <p class="text-xs hint">Note: Server-side validation ensures only students can reset here.</p>
        </form>
      </div>
    </section>
  </main>

  <script>
    // simple reveal for form body
    window.addEventListener('load', () => {
      document.querySelector('.form-body')?.classList.add('show');
    });

    // password toggle, strength and basic client checks
    (function(){
      const toggle = document.getElementById('toggleNewPwd');
      const pwd = document.getElementById('new_password');
      const pwdConfirm = document.getElementById('new_password_confirm');
      const strengthLabel = document.getElementById('strengthLabel');
      const clientMsg = document.getElementById('clientMsg');
      const form = document.getElementById('forgotForm');
      const submitBtn = document.getElementById('forgotSubmit');

      toggle && toggle.addEventListener('click', () => {
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
        toggle.textContent = pwd.type === 'password' ? 'Show' : 'Hide';
      });

      function scorePassword(password) {
        let score = 0;
        if (!password) return score;
        if (password.length >= 8) score++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) score++;
        if (password.match(/\d/)) score++;
        if (password.match(/[\W_]/)) score++;
        return score;
      }

      function strengthText(score) {
        switch(score) {
          case 0: return '—';
          case 1: return 'Very weak';
          case 2: return 'Weak';
          case 3: return 'Good';
          case 4: return 'Strong';
          default: return '—';
        }
      }

      pwd && pwd.addEventListener('input', function(){
        const s = scorePassword(pwd.value);
        strengthLabel.textContent = strengthText(s);
      });

      form && form.addEventListener('submit', function(e){
        clientMsg.classList.add('hidden');
        const pw = pwd.value || '';
        const pwc = pwdConfirm.value || '';
        const matric = document.getElementById('matric_no').value || '';

        if (!matric.trim()) {
          e.preventDefault();
          clientMsg.className = 'mb-3 text-sm rounded p-3 bg-red-50 text-red-700';
          clientMsg.textContent = 'Please enter your Matric Number.';
          clientMsg.classList.remove('hidden');
          window.scrollTo({ top: 0, behavior: 'smooth' });
          return;
        }
        if (pw.length < 8) {
          e.preventDefault();
          clientMsg.className = 'mb-3 text-sm rounded p-3 bg-red-50 text-red-700';
          clientMsg.textContent = 'Password must be at least 8 characters.';
          clientMsg.classList.remove('hidden');
          return;
        }
        if (pw !== pwc) {
          e.preventDefault();
          clientMsg.className = 'mb-3 text-sm rounded p-3 bg-red-50 text-red-700';
          clientMsg.textContent = 'Passwords do not match.';
          clientMsg.classList.remove('hidden');
          return;
        }

        // disable to avoid duplicates
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
      });
    })();
  </script>
</body>
</html>