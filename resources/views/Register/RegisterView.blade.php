<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Athlentry — Student Registration</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --maroon:#8B1E2F; --maroon-dark:#5e101b; }
    body { font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto;
           background: linear-gradient(135deg,#fbfbfe,#f6f5fb); }
    .fade { opacity:0; transform:translateY(10px); transition:.4s ease; }
    .fade.show { opacity:1; transform:translateY(0); }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

  <div id="box" class="fade w-full max-w-lg bg-white rounded-2xl shadow-xl p-8">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <img src="{{ asset('images/Athlentry-logo.jpg') }}" alt="Athlentry Logo" class="h-14 object-contain">
    </div>

    <h1 class="text-2xl font-semibold text-center mb-1 text-slate-800">Create your account</h1>
    <p class="text-center text-sm text-slate-500 mb-6">Join Athlentry to register as a student athlete</p>

    @if ($errors->any())
      <div class="mb-4 text-sm text-red-700 bg-red-50 p-3 rounded">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('student.register.submit') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
        <input type="text" name="Name" value="{{ old('Name') }}" required
               class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[color:var(--maroon)]">
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Matric Number</label>
        <input type="text" name="MatricNo" value="{{ old('MatricNo') }}" required
               class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[color:var(--maroon)]">
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <input type="email" name="Email" value="{{ old('Email') }}" required
               class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[color:var(--maroon)]">
      </div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
          <input type="password" name="Password" required
                 class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[color:var(--maroon)]">
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
          <input type="password" name="Password_confirmation" required
                 class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[color:var(--maroon)]">
        </div>
      </div>

      <button type="submit"
              class="w-full py-3 rounded-lg text-white font-semibold shadow-lg transition-transform duration-300 hover:-translate-y-0.5"
              style="background: linear-gradient(90deg,var(--maroon),var(--maroon-dark));">
        Register
      </button>
    </form>

    <div class="text-center mt-6">
      <p class="text-sm text-slate-600">
        Already have an account?
        <a href="{{ route('login.view') }}"
           class="text-[color:var(--maroon)] font-semibold hover:underline">
          Back to Login
        </a>
      </p>
    </div>

    <p class="text-xs text-center text-slate-400 mt-4">
      © {{ date('Y') }} Athlentry
    </p>
  </div>

  <script>
    window.addEventListener('load', ()=> document.getElementById('box').classList.add('show'));
  </script>
</body>
</html>
