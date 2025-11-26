<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Athlentry — Student Registration</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root { --maroon:#8B1E2F; --maroon-dark:#5e101b; }
    body {
      font-family: Poppins, Inter, system-ui;
      background: radial-gradient(circle at 10% 20%, rgba(139,30,47,0.05), transparent 25%),
                  radial-gradient(circle at 90% 80%, rgba(94,16,27,0.06), transparent 25%),
                  linear-gradient(180deg,#fbfbfe,#f6f5fb);
    }

    .fade { opacity:0; transform:translateY(10px); transition:.4s ease; }
    .fade.show { opacity:1; transform:translateY(0); }

    .form-input:focus {
      outline: none;
      border-color: var(--maroon);
      box-shadow: 0 0 0 3px rgba(139,30,47,.15);
    }

    .sport-pattern {
      background-image: radial-gradient(circle, rgba(0,0,0,0.025) 1px, transparent 1px);
      background-size: 14px 14px;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4">

  <div id="box" class="fade w-full max-w-5xl bg-white shadow-2xl rounded-3xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

    <!-- LEFT PANEL -->
    <div class="hidden md:flex flex-col justify-between p-10 sport-pattern bg-gradient-to-b from-white/80 to-white">
      
      <div>
        <div class="flex items-center gap-3 mb-6">
          <div class="p-3 rounded-xl bg-[var(--maroon)] shadow">
            <img src="{{ asset('images/Athlentry-logo.png') }}" class="h-10">
          </div>
          <div>
            <h2 class="text-lg font-semibold text-slate-800">Athlentry</h2>
            <p class="text-xs text-slate-500">Campus sports registration</p>
          </div>
        </div>

        <h1 class="text-3xl font-bold text-slate-800 leading-tight mb-2">Join as a student athlete</h1>
        <p class="text-slate-600 text-sm max-w-sm">
          Create your Athlentry account to register, apply for games, view announcements, and manage your sport activity.
        </p>

        <div class="mt-6">
          <!-- small sport SVG illustration -->
          <svg class="w-64 opacity-95" viewBox="0 0 600 300" fill="none">
            <ellipse cx="300" cy="200" rx="220" ry="70" fill="rgba(139,30,47,0.06)" />
            <circle cx="150" cy="120" r="26" fill="white" stroke="rgba(139,30,47,0.2)" stroke-width="3"/>
            <circle cx="420" cy="210" r="34" fill="white" stroke="rgba(94,16,27,0.2)" stroke-width="3"/>
            <path d="M80 200 Q260 120 520 190" stroke="rgba(139,30,47,0.25)" stroke-width="18" stroke-linecap="round"/>
          </svg>
        </div>
      </div>

      <p class="text-xs text-slate-400 mt-10">© {{ date('Y') }} Athlentry</p>
    </div>

    <!-- RIGHT FORM PANEL -->
    <div class="p-8 md:p-12 flex flex-col justify-center">
      <div class="max-w-md mx-auto w-full">

        <div class="flex justify-center mb-6 md:hidden">
          <img src="{{ asset('images/Athlentry-logo.jpg') }}" class="h-14">
        </div>

        <h1 class="text-2xl font-semibold text-slate-800 text-center md:text-left">
          Create your account
        </h1>
        <p class="text-sm text-slate-500 text-center md:text-left mb-6">
          Register as a student athlete to start using Athlentry
        </p>

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
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg">
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Matric Number</label>
            <input type="text" name="MatricNo" value="{{ old('MatricNo') }}" required
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg">
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="Email" value="{{ old('Email') }}" required
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg">
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
              <input type="password" name="Password" required
                     class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg">
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
              <input type="password" name="Password_confirmation" required
                     class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg">
            </div>
          </div>

          <button type="submit"
                  class="w-full py-3 rounded-lg text-white font-semibold shadow-lg hover:opacity-95 transition"
                  style="background: linear-gradient(90deg,var(--maroon),var(--maroon-dark));">
            Register
          </button>
        </form>

        <div class="text-center mt-6">
          <p class="text-sm text-slate-600">
            Already have an account?
            <a href="{{ route('login.view') }}" class="text-[color:var(--maroon)] font-semibold hover:underline">
              Back to Login
            </a>
          </p>
        </div>

      </div>
    </div>

  </div>

  <script>
    window.addEventListener('load', () => {
      document.getElementById('box').classList.add('show');
    });
  </script>

</body>
</html>
