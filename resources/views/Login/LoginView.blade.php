<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Athlentry Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --maroon: #8B1E2F;
      --maroon-dark:#5e101b;
      --accent: #FFB703;
      --glass: rgba(255,255,255,0.75);
    }

    html,body { height:100%; }
    body{
      font-family: Poppins, Inter, system-ui, -apple-system, "Segoe UI", Roboto;
      background: radial-gradient(1000px 600px at 10% 10%, rgba(139,30,47,0.06), transparent 12%),
                  radial-gradient(900px 500px at 90% 90%, rgba(94,16,27,0.04), transparent 12%),
                  linear-gradient(180deg,#fbfbfe,#f6f5fb);
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* container fade in */
    .fade { opacity:0; transform: translateY(10px) scale(.995); transition: .36s cubic-bezier(.2,.9,.3,1); }
    .fade.show { opacity:1; transform: translateY(0) scale(1); }

    /* subtle sporty texture */
    .sport-pattern {
      background-image: radial-gradient(circle at 10% 20%, rgba(0,0,0,0.02) 0.5px, transparent 0.5px);
      background-size: 14px 14px;
    }

    /* input focus */
    .form-input:focus {
      outline: none;
      box-shadow: 0 6px 18px rgba(139,30,47,0.08), 0 0 0 3px rgba(139,30,47,0.06);
      border-color: var(--maroon);
    }

    /* sporty badge */
    .badge {
      background: linear-gradient(90deg,var(--maroon),var(--maroon-dark));
      color: white;
      font-weight:600;
      padding: .35rem .6rem;
      border-radius: 999px;
      font-size: .75rem;
    }

    /* small svg ball animation */
    @keyframes floaty { 0%{ transform: translateY(0);}50%{ transform: translateY(-6px);}100%{ transform: translateY(0);} }
    .floaty { animation: floaty 3.6s ease-in-out infinite; }

    /* ensure logo doesn't stretch */
    .logo-img { max-height:56px; width:auto; }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

  <div id="box" class="fade w-full max-w-5xl sport-pattern rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
    <!-- Left: Sport identity panel -->
    <div class="relative hidden md:flex flex-col justify-center items-start p-10 gap-6 bg-gradient-to-b from-white/70 to-white/40">
      <div class="flex items-center justify-center md:justify-start mb-6 bg-[var(--maroon)] px-4 py-3 rounded-xl shadow-md">
        <img src="{{ asset('images/Athlentry-logo.png') }}" alt="Logo" class="h-14 object-contain mr-3">
        <span class="badge">Athlentry</span>
      </div>

      <div>
        <h2 class="text-3xl md:text-4xl font-bold text-slate-800 leading-tight">Welcome back</h2>
        <p class="mt-2 text-slate-600 max-w-xs">Sign in to apply for matches, and track results.</p>
      </div>

      <!-- Sport illustration (inline SVG) -->
      <div class="mt-4">
        <svg viewBox="0 0 600 360" class="w-72 floaty" xmlns="http://www.w3.org/2000/svg" fill="none">
          <!-- background swoosh -->
          <defs>
            <linearGradient id="g1" x1="0" x2="1">
              <stop offset="0" stop-color="#FFE6D6" stop-opacity="0.9"/>
              <stop offset="1" stop-color="#FFD7E0" stop-opacity="0.9"/>
            </linearGradient>
          </defs>

          <rect width="600" height="360" rx="20" fill="url(#g1)"/>
          <!-- stylized track -->
          <g transform="translate(20,20)">
            <ellipse cx="280" cy="200" rx="210" ry="80" fill="rgba(139,30,47,0.07)"/>
            <path d="M40 200 Q180 110 420 190" stroke="rgba(139,30,47,0.22)" stroke-width="18" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="150" cy="120" r="28" fill="white" stroke="rgba(139,30,47,0.14)"/>
            <circle cx="420" cy="220" r="34" fill="white" stroke="rgba(94,16,27,0.12)"/>
          </g>

          <!-- sport icons -->
          <g transform="translate(20,20)" opacity="0.95">
            <!-- ball -->
            <g transform="translate(420,80)">
              <circle cx="0" cy="0" r="28" fill="#fff" stroke="rgba(94,16,27,0.18)" />
              <path d="M-6 -6 L6 6 M-6 6 L6 -6" stroke="#8B1E2F" stroke-width="2.5" stroke-linecap="round"/>
            </g>

            <!-- whistle -->
            <g transform="translate(90,240) rotate(-10)">
              <rect x="-12" y="-8" width="40" height="18" rx="4" fill="#fff" stroke="rgba(94,16,27,0.12)"/>
              <circle cx="8" cy="1" r="3.5" fill="#8B1E2F"/>
            </g>
          </g>
        </svg>
      </div>

      <p class="text-xs text-slate-500 mt-auto">Faculty of Computing Sports — simple, fast, and athlete-first.</p>
    </div>

    <!-- Right: Form card -->
    <div class="bg-white p-8 md:p-12 flex flex-col justify-center">
      <div class="max-w-md w-full mx-auto">
        <div class="flex items-center justify-center md:justify-start mb-6">
          <div>
            <h1 class="text-2xl font-semibold text-slate-800">Sign in</h1>
            <p class="text-sm text-slate-500">Use your Matric Number or Admin ID to get started</p>
          </div>
        </div>

        @if ($errors->any())
          <div class="mb-4 text-sm text-red-700 bg-red-50 p-3 rounded">
            {{ $errors->first() }}
          </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
          @csrf

          <div class="mb-4">
            <label id="identifierLabel" class="block text-xs font-medium text-slate-600 mb-2">Matric Number</label>
            <input id="identifier" name="identifier" type="text" value="{{ old('identifier') }}" required
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg shadow-sm focus:ring-0">
          </div>

          <div class="mb-4">
            <div class="flex items-center justify-between mb-1">
              <label class="block text-xs font-medium text-slate-600">Password</label>
              <button type="button" id="togglePassword" class="text-xs text-slate-400 hover:text-slate-600 transition">Show</button>
            </div>
            <input id="password" name="password" type="password" required class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg shadow-sm">
          </div>

          <div class="mb-4">
            <label class="block text-xs font-medium text-slate-600 mb-2">Role</label>
            <select id="role" name="role" class="form-input w-full px-3 py-2 border border-slate-200 rounded-lg">
              <option value="student" selected>Student</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <div class="flex items-center justify-between mb-4 text-sm">
            <label class="inline-flex items-center gap-2">
              <input type="checkbox" name="remember" class="h-4 w-4 rounded border">
              <span class="text-slate-700">Remember me</span>
            </label>
            <a href="{{ route('login.forgot.view') }}" class="text-slate-500 hover:underline">Forgot Password?</a>
          </div>

          <input type="hidden" name="matric_no" id="matric_no_hidden" value="">

          <div>
            <button type="submit" id="submitBtn" class="w-full py-3 rounded-lg text-white font-semibold shadow" style="background: linear-gradient(90deg,var(--maroon),var(--maroon-dark));">
              Sign In
            </button>
          </div>

          <div class="text-center mt-6">
            <p class="text-sm text-slate-600">
              Don't have an account?
              <a href="{{ route('student.register.view') }}" class="text-[color:var(--maroon)] font-semibold hover:underline">Register Here</a>
            </p>
          </div>
        </form>

        <p class="text-xs text-center text-slate-400 mt-6">© {{ date('Y') }} Athlentry</p>
      </div>
    </div>
  </div>

  <script>
    // on load: animate
    window.addEventListener('load', ()=> document.getElementById('box').classList.add('show'));

    // form action switching
    const role = document.getElementById('role');
    const form = document.getElementById('loginForm');
    const identifier = document.getElementById('identifier');
    const hiddenMatric = document.getElementById('matric_no_hidden');

    function setAction() {
      if (role.value === 'admin') {
        form.action = "{{ route('admin.login.submit') }}";
        document.getElementById('identifierLabel').textContent = 'Matric Number';
        identifier.placeholder = 'ADMIN001';
      } else {
        form.action = "{{ route('login.submit') }}";
        document.getElementById('identifierLabel').textContent = 'Matric Number';
        identifier.placeholder = 'e.g. cb22047';
      }
    }
    role.addEventListener('change', setAction);
    setAction();

    // password toggle
    const toggle = document.getElementById('togglePassword');
    const pwd = document.getElementById('password');
    toggle.addEventListener('click', () => {
      if (pwd.type === 'password') { pwd.type = 'text'; toggle.textContent='Hide'; }
      else { pwd.type = 'password'; toggle.textContent='Show'; }
    });

    // optional: on submit, copy identifier to matric hidden if needed by controllers
    form.addEventListener('submit', ()=> {
      // keep old field name compatibility: controllers expect 'matric_no' for admin and 'identifier' for student.
      hiddenMatric.value = identifier.value;
    });
  </script>
</body>
</html>
