<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Athlentry Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{ --maroon: #8B1E2F; --maroon-dark:#5e101b; }
    body{ font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto; background: linear-gradient(180deg,#fbfbfe,#f6f5fb); }
    .fade { opacity:0; transform: translateY(8px); transition: .36s; }
    .fade.show { opacity:1; transform: translateY(0); }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

  <div id="box" class="fade w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
    <div class="flex justify-center mb-6">
      <img src="{{ asset('images/Athlentry-logo.jpg') }}" alt="Logo" class="h-14 object-contain">
    </div>

    <h1 class="text-2xl font-semibold text-center mb-1">Sign in</h1>
    
    @if ($errors->any())
      <div class="mb-4 text-sm text-red-700 bg-red-50 p-3 rounded">
        {{ $errors->first() }}
      </div>
    @endif

    {{-- Single form — JS switches action depending on role --}}
    <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
      @csrf

      <div class="mb-4">
        <label id="identifierLabel" class="block text-xs font-medium text-slate-600 mb-1">Matric Number</label>
        <input id="identifier" name="identifier" type="text" value="{{ old('identifier') }}" required
               class="w-full px-4 py-3 border rounded">
      </div>

      <div class="mb-4">
        <div class="flex items-center justify-between mb-1">
          <label class="block text-xs font-medium text-slate-600">Password</label>
          <button type="button" id="togglePassword" class="text-xs text-slate-400">Show</button>
        </div>
        <input id="password" name="password" type="password" required class="w-full px-4 py-3 border rounded">
      </div>

      <div class="mb-4">
        <label class="block text-xs font-medium text-slate-600 mb-1">Role</label>
        <select id="role" name="role" class="w-full px-3 py-2 border rounded">
          <option value="student" selected>Student</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <div class="flex items-center justify-between mb-4 text-sm">
        <label class="inline-flex items-center gap-2">
          <input type="checkbox" name="remember" class="h-4 w-4 rounded border">
          <span>Remember me</span>
        </label>
        <a href="#" class="text-slate-500 hover:underline">Forgot?</a>
      </div>

      {{-- hidden input to keep API consistent --}}
      <input type="hidden" name="matric_no" id="matric_no_hidden" value="">

      <div>
        <button type="submit" id="submitBtn" class="w-full py-3 rounded-lg text-white font-semibold" style="background: linear-gradient(90deg,var(--maroon),var(--maroon-dark));">
          Sign In
        </button>
      </div>
      <div cladd="text-center mt-6">
        <p class="text-sm text-slate-600">
            Don't have an account?
            <a href="{{ route('student.register.view') }}"
            class="text-[color:var(--maroon)] font-semibold hover:underline">
            Register Here
            </a>
        </p>
    </div>
    </form>

    <p class="text-xs text-center text-slate-400 mt-4">© {{ date('Y') }} Athlentry</p>
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
