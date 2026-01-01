<!doctype html>
<html lang="en" class="antialiased">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Athlentry — Sign in</title>

  <!-- Tailwind (CDN for prototyping) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --maroon: #8B1E2F;
      --maroon-dark:#5e101b;
      --accent: #FFB703;
      --surface: #ffffff;
      --muted: #6b7280;
    }

    html,body { height:100%; }
    body{
      font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      background: linear-gradient(180deg,#fbfbfe,#f6f5fb);
      margin:0;
    }

    /* subtle card animation */
    .card-appear { opacity: 0; transform: translateY(8px) scale(.995); transition: all .36s cubic-bezier(.2,.9,.3,1); }
    .card-appear.show { opacity: 1; transform: translateY(0) scale(1); }

    /* input focus */
    .form-input:focus {
      outline: none;
      box-shadow: 0 8px 28px rgba(139,30,47,0.08), 0 0 0 4px rgba(139,30,47,0.06);
      border-color: var(--maroon);
    }

    /* small helpers */
    .brand-btn {
      background: linear-gradient(90deg,var(--maroon),var(--maroon-dark));
    }

    /* subtle left panel texture */
    .left-illustration { background:
      radial-gradient(circle at 10% 20%, rgba(139,30,47,0.04) 0.5px, transparent 0.5px),
      linear-gradient(180deg, rgba(139,30,47,0.03), rgba(94,16,27,0.02)); }

    /* make layout full-bleed */
    .full-bleed { width: 100%; max-width: none; border-radius: 0; box-shadow: none; }

    /* ensure left panel and form area have generous padding on large screens */
    .left-panel { padding: 4.5rem 3rem; }
    .form-panel { padding: 3.5rem 2.25rem; }

    @media(min-width:1024px) {
      .left-panel { padding: 5.5rem 4rem; }
      .form-panel { padding: 4.5rem 4rem; }
    }

    /* remove rounded corners on full-bleed look */
    .rounded-none-md { border-radius: 0; }
  </style>
</head>
<body class="min-h-screen">

  <!-- FULL-BLEED LAYOUT: left branding + right form, stretches edge-to-edge -->
  <main class="card-appear grid grid-cols-1 md:grid-cols-2 full-bleed bg-[color:var(--surface)]">
    <!-- Left: Branding / Illustration (md+) -->
    <section class="hidden md:flex left-panel left-illustration flex-col justify-between gap-6">
      <div>
        <div class="flex items-center gap-3 mb-6">
          <img src="{{ asset('images/Athlentry-logo.png') }}" alt="Athlentry" class="h-12 w-auto object-contain">
          <span class="inline-block bg-[color:var(--maroon)] text-white text-sm px-3 py-1 rounded-full font-semibold">Athlentry</span>
        </div>

        <h2 class="text-3xl font-bold text-slate-900 leading-tight mb-2">Welcome back</h2>
        <p class="text-sm text-[color:var(--muted)] max-w-xs">Sign in to apply for matches, view updates, and manage applications.</p>
      </div>

      <div class="mt-6">
        <!-- Decorative SVG -->
        <svg viewBox="0 0 560 360" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
          <defs>
            <linearGradient id="lg" x1="0" x2="1">
              <stop offset="0" stop-color="#fff1f2" />
              <stop offset="1" stop-color="#fff7f8" />
            </linearGradient>
          </defs>
          <rect width="560" height="360" rx="18" fill="url(#lg)"/>
          <g transform="translate(20,20)" opacity="0.95">
            <ellipse cx="240" cy="170" rx="180" ry="70" fill="rgba(139,30,47,0.06)"/>
            <circle cx="70" cy="120" r="28" fill="#fff" stroke="rgba(139,30,47,0.08)"/>
            <circle cx="420" cy="220" r="34" fill="#fff" stroke="rgba(94,16,27,0.06)"/>
          </g>
        </svg>
      </div>

      <p class="text-xs text-[color:var(--muted)]">Faculty of Computing Sports — simple, fast, athlete-first.</p>
    </section>

    <!-- Right: Form area (spans 2 cols on md) -->
    <section class="form-panel flex items-center">
      <div class="w-full">
        <div class="max-w-xl">
          <header class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-900">Sign in</h1>
            <p class="text-sm text-[color:var(--muted)] mt-1">Use your Matric Number or Admin ID to access your account.</p>
          </header>

          {{-- Validation errors --}}
          @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 border border-red-100 p-3 text-red-700 text-sm">
              {!! implode('<br>', $errors->all()) !!}
            </div>
          @endif

          {{-- Login form --}}
          <form id="loginForm" method="POST" action="{{ route('login.submit') }}" class="space-y-4" novalidate>
            @csrf

            <!-- role tabs -->
            <div class="flex items-center gap-2 mb-2" role="tablist" aria-label="Select role">
              <button type="button" class="role-tab px-4 py-2 rounded-full text-sm font-medium bg-[color:var(--maroon)] text-white" data-role="student" role="tab" aria-selected="true">Student</button>
              <button type="button" class="role-tab px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-slate-700" data-role="admin" role="tab" aria-selected="false">Admin</button>
            </div>

            <div>
              <label id="identifierLabel" for="identifier" class="block text-sm font-medium text-slate-700">Matric Number</label>
              <input id="identifier" name="identifier" type="text" value="{{ old('identifier') }}" required
                     class="form-input mt-2 w-full px-4 py-3 border border-slate-200 rounded-lg shadow-sm" placeholder="e.g. CB22047" aria-describedby="identifierHelp" />
              <p id="identifierHelp" class="text-xs text-[color:var(--muted)] mt-2">Enter matric number or admin ID depending on role.</p>
            </div>

            <div>
              <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <a href="{{ route('login.forgot.view') }}" class="text-sm text-[color:var(--muted)] hover:underline">Forgot?</a>
              </div>
              <div class="relative mt-2">
                <input id="password" name="password" type="password" required
                       class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg shadow-sm" aria-describedby="passwordHelp" />
                <button type="button" id="togglePassword" aria-label="Toggle show password" class="absolute right-2 top-2.5 text-sm text-slate-500 hover:text-slate-700">Show</button>
              </div>
              <p id="passwordHelp" class="text-xs text-[color:var(--muted)] mt-2">Use the password provided by the organiser or reset if forgotten.</p>
            </div>

            <div class="flex items-center justify-between">
              <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300">
                <span class="text-slate-700">Remember me</span>
              </label>

              <div class="text-sm">
                <a href="{{ route('student.register.view') }}" class="text-[color:var(--maroon)] font-semibold hover:underline">Register</a>
              </div>
            </div>

            <!-- hidden compatibility field (if controllers expect matric_no) -->
            <input type="hidden" name="matric_no" id="matric_no_hidden" value="">

            <div>
              <button id="submitBtn" type="submit" class="w-full py-3 rounded-lg text-white font-semibold brand-btn shadow">
                Sign In
              </button>
            </div>

            <div class="mt-6 text-xs text-[color:var(--muted)]">
              © {{ date('Y') }} Athlentry — Faculty of Computing Sports
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>

  <!-- Scripts -->
  <script>
    // reveal card (now full-bleed) on load
    window.addEventListener('load', () => {
      document.querySelector('.card-appear')?.classList.add('show');
    });

    // role tab logic
    (function () {
      const roleTabs = Array.from(document.querySelectorAll('.role-tab'));
      const form = document.getElementById('loginForm');
      const identifier = document.getElementById('identifier');
      const hiddenMatric = document.getElementById('matric_no_hidden');

      function setRole(role) {
        roleTabs.forEach(btn => {
          const is = btn.dataset.role === role;
          btn.classList.toggle('bg-[color:var(--maroon)]', is);
          btn.classList.toggle('text-white', is);
          btn.classList.toggle('bg-gray-100', !is);
          btn.classList.toggle('text-slate-700', !is);
          btn.setAttribute('aria-selected', is ? 'true' : 'false');
        });

        // change form action depending on role
        if (role === 'admin') {
          form.action = "{{ route('admin.login.submit') }}";
          identifier.placeholder = 'ADMIN001';
          document.getElementById('identifierLabel').textContent = 'Admin ID';
        } else {
          form.action = "{{ route('login.submit') }}";
          identifier.placeholder = 'e.g. CB22047';
          document.getElementById('identifierLabel').textContent = 'Matric Number';
        }
      }

      roleTabs.forEach(btn => btn.addEventListener('click', () => setRole(btn.dataset.role)));

      // initialize from default (student)
      setRole('student');

      // password toggle
      const toggle = document.getElementById('togglePassword');
      const pwd = document.getElementById('password');
      toggle.addEventListener('click', () => {
        if (pwd.type === 'password') { pwd.type = 'text'; toggle.textContent = 'Hide'; }
        else { pwd.type = 'password'; toggle.textContent = 'Show'; }
      });

      // on submit copy identifier to matric_no_hidden for backward compatibility
      form.addEventListener('submit', () => {
        hiddenMatric.value = identifier.value || '';
      });

      // accessibility: keyboard switching of role tabs
      roleTabs.forEach((tab, i) => {
        tab.addEventListener('keydown', (e) => {
          if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            const next = roleTabs[(i + (e.key === 'ArrowRight' ? 1 : roleTabs.length - 1)) % roleTabs.length];
            next.focus();
            setRole(next.dataset.role);
          }
        });
      });
    })();
  </script>
</body>
</html>