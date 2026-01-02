<!doctype html>
<html lang="en" class="antialiased">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Athlentry — Student Registration</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --maroon: #8B1E2F;
      --maroon-dark: #5e101b;
      --muted: #6b7280;
      --surface: #ffffff;
    }

    html,body { height:100%; margin:0; }
    body{
      font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      background: linear-gradient(180deg,#fbfbfe,#f6f5fb);
    }

    .panel-grid { min-height:100vh; display:grid; grid-template-columns:1fr; }
    @media(min-width:768px){ .panel-grid { grid-template-columns:1fr 560px; } }

    .left-illustration {
      padding:5rem 3rem;
      background:
        radial-gradient(circle at 10% 20%, rgba(139,30,47,0.04) 0.6px, transparent 0.6px),
        linear-gradient(180deg,#fff6f6,#ffffff);
      display:flex;
      flex-direction:column;
      justify-content:space-between;
    }

    .form-panel {
      display:flex;
      align-items:center;
      justify-content:center;
      padding:4rem 3rem;
      background:var(--surface);
    }

    .form-body {
      width:100%;
      max-width:56rem;
    }

    .form-input {
      font-size: 1rem;
      padding: 0.95rem 1rem;
    }
    .form-input:focus {
      outline:none;
      box-shadow: 0 10px 28px rgba(139,30,47,0.08), 0 0 0 4px rgba(139,30,47,0.06);
      border-color: var(--maroon);
    }

    .hint { color:var(--muted); font-size:.95rem; }
    .muted-link { color:var(--maroon); font-weight:700; }

    .btn-primary {
      padding: .95rem 1.1rem;
      font-size: 1rem;
      border-radius: .75rem;
      box-shadow: 0 10px 30px rgba(139,30,47,0.12);
    }

    .fade-up { opacity:0; transform:translateY(8px); transition: all .36s cubic-bezier(.2,.9,.3,1); }
    .fade-up.show { opacity:1; transform:translateY(0); }
  </style>
</head>

<body>

<main class="panel-grid">

  {{-- LEFT PANEL --}}
  <aside class="left-illustration hidden md:flex" aria-hidden="true">
    <div>
      <div class="flex items-center gap-3 mb-6">
        <img src="{{ asset('images/Athlentry-logo.png') }}" class="h-12 w-auto" alt="Athlentry logo">
        <span class="inline-block bg-[color:var(--maroon)] text-white text-sm px-3 py-1 rounded-full font-semibold">
          Athlentry
        </span>
      </div>

      <h2 class="text-3xl font-bold text-slate-900 mb-3">Join Athlentry</h2>
      <p class="hint max-w-xs">
        Register as a student athlete to apply for games, receive updates, and manage your activities.
      </p>

      <div class="mt-10">
        <svg viewBox="0 0 560 300" class="w-full h-auto">
          <ellipse cx="280" cy="200" rx="220" ry="70" fill="rgba(139,30,47,0.06)" />
          <circle cx="120" cy="120" r="26" fill="white" stroke="rgba(139,30,47,0.18)" stroke-width="3"/>
          <circle cx="420" cy="210" r="34" fill="white" stroke="rgba(94,16,27,0.18)" stroke-width="3"/>
          <path d="M80 200 Q260 120 520 190" stroke="rgba(139,30,47,0.25)" stroke-width="18" stroke-linecap="round"/>
        </svg>
      </div>
    </div>

    <div class="text-xs text-slate-400">© {{ date('Y') }} Athlentry</div>
  </aside>

  {{-- RIGHT PANEL --}}
  <section class="form-panel">
    <div class="form-body fade-up" id="formBody">

      <div class="mb-6 flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-semibold text-slate-900">Create your account</h1>
          <p class="hint mt-1">Register as a student athlete</p>
        </div>
        <a href="{{ route('login.view') }}" class="text-sm hint hover:underline">
          Back to Login
        </a>
      </div>

      {{-- Validation Errors --}}
      @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-100 text-red-700 p-3 text-sm">
          <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- FORM --}}
      <form id="registerForm" action="{{ route('student.register.submit') }}" method="POST" class="space-y-6" novalidate>
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium mb-1">Full Name</label>
            <input type="text" name="Name" value="{{ old('Name') }}" required autocomplete="name"
                   class="form-input w-full border border-slate-200 rounded-lg"
                   placeholder="Your full name">
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Matric Number</label>
            <input type="text" name="MatricNo" value="{{ old('MatricNo') }}" required
                   class="form-input w-full border border-slate-200 rounded-lg"
                   placeholder="e.g. CB22047">
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input type="email" name="Email" value="{{ old('Email') }}" required autocomplete="email"
                 class="form-input w-full border border-slate-200 rounded-lg"
                 placeholder="you@campus.edu">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">Password</label>
            <div class="relative">
              <input id="password" type="password" name="password" required autocomplete="new-password"
                     class="form-input w-full border border-slate-200 rounded-lg"
                     placeholder="At least 8 characters">
              <button type="button" id="togglePwd"
                      class="absolute right-3 top-3 text-sm text-slate-500 hover:text-slate-700">
                Show
              </button>
            </div>
            <p class="text-xs hint mt-2">Strength: <strong id="pwdStrength">—</strong></p>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Confirm Password</label>
            <input id="password_confirm" type="password" name="password_confirmation" required
                   autocomplete="new-password"
                   class="form-input w-full border border-slate-200 rounded-lg"
                   placeholder="Retype password">
          </div>
        </div>

        <button type="submit" id="registerBtn"
                class="btn-primary w-full rounded-xl text-white font-semibold tracking-wide"
                style="background: linear-gradient(90deg,var(--maroon),var(--maroon-dark));">
          Register
        </button>
      </form>

      <div class="mt-6 text-center">
        <p class="text-sm hint">
          Already have an account?
          <a href="{{ route('login.view') }}" class="muted-link">Sign in</a>
        </p>
      </div>

    </div>
  </section>

</main>

<script>
  window.addEventListener('load', () => {
    document.getElementById('formBody')?.classList.add('show');
  });

  (function () {
    const form = document.getElementById('registerForm'); // ✅ explicit form
    const pwd = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirm');
    const toggle = document.getElementById('togglePwd');
    const strength = document.getElementById('pwdStrength');
    const btn = document.getElementById('registerBtn');

    if (!form || !pwd || !confirmInput) return;

    // Toggle password visibility
    toggle.addEventListener('click', () => {
      pwd.type = pwd.type === 'password' ? 'text' : 'password';
      toggle.textContent = pwd.type === 'password' ? 'Show' : 'Hide';
    });

    // Password strength meter
    pwd.addEventListener('input', () => {
      let s = 0;
      const val = pwd.value;

      if (val.length >= 8) s++;
      if (/[A-Z]/.test(val) && /[a-z]/.test(val)) s++;
      if (/\d/.test(val)) s++;
      if (/[\W_]/.test(val)) s++;

      strength.textContent = ['—', 'Very weak', 'Weak', 'Good', 'Strong'][s];
    });

    // Submit validation
    form.addEventListener('submit', (e) => {
      const password = pwd.value;
      const confirmPassword = confirmInput.value;

      if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match.');
        return;
      }

      btn.disabled = true;
      btn.textContent = 'Creating...';
    });
  })();
</script>


</body>
</html>
