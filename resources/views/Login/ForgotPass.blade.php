<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Forgot Password — Athlentry</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root { --maroon: #8B1E2F; --maroon-dark:#5e101b; }

    body {
      font-family: Poppins, Inter, system-ui;
      background:
        radial-gradient(circle at 10% 20%, rgba(139,30,47,0.05), transparent 25%),
        radial-gradient(circle at 90% 80%, rgba(94,16,27,0.06), transparent 25%),
        linear-gradient(180deg,#fbfbfe,#f6f5fb);
      -webkit-font-smoothing: antialiased;
    }

    .card {
      max-width: 850px;
      margin: 4rem auto;
      background: white;
      border-radius: 1.4rem;
      box-shadow: 0 18px 45px rgba(15,23,42,0.1);
      overflow: hidden;
      display: grid;
      grid-template-columns: 1fr;
    }

    @media (min-width: 768px) {
      .card { grid-template-columns: 1fr 420px; }
    }

    .form-input:focus {
      outline: none;
      border-color: var(--maroon);
      box-shadow: 0 0 0 3px rgba(139,30,47,0.12);
    }

    .left-panel-bg {
      background:
        radial-gradient(circle, rgba(0,0,0,0.035) 1px, transparent 1px),
        linear-gradient(180deg,#fff6f6,#ffffff);
      background-size: 14px 14px, auto;
    }

    .disabled-overlay {
      pointer-events: none;
      opacity: 0.6;
    }

    .fade { opacity: 0; transform: translateY(10px); transition: .4s ease; }
    .fade.show { opacity: 1; transform: translateY(0); }
  </style>
</head>

<body>

  <div class="card fade">

    <!-- Left identity panel -->
    <div class="p-10 hidden md:flex flex-col justify-between left-panel-bg">

      <div>
        <div class="flex items-center gap-3 mb-8">
          <div class="bg-[var(--maroon)] p-3 rounded-xl shadow">
            <img src="{{ asset('images/Athlentry-logo.png') }}" class="h-10 object-contain">
          </div>
          <div>
            <h3 class="text-lg font-semibold text-slate-800">Athlentry</h3>
            <p class="text-xs text-slate-500">Campus sports, simplified.</p>
          </div>
        </div>

        <h2 class="text-3xl font-bold text-slate-800 leading-snug mb-3">
          Reset your<br>student password
        </h2>

        <p class="text-sm text-slate-600 max-w-sm">
          Only students can use this page. Admin accounts must contact the system administrator or IT support.
        </p>

        <div class="mt-8 opacity-95">
          <svg class="w-72" viewBox="0 0 600 300" fill="none">
            <ellipse cx="300" cy="200" rx="220" ry="70" fill="rgba(139,30,47,0.06)" />
            <circle cx="150" cy="120" r="26" fill="white" stroke="rgba(139,30,47,0.2)" stroke-width="3"/>
            <circle cx="420" cy="210" r="34" fill="white" stroke="rgba(94,16,27,0.2)" stroke-width="3"/>
            <path d="M80 200 Q260 120 520 190" stroke="rgba(139,30,47,0.25)" stroke-width="18" stroke-linecap="round"/>
          </svg>
        </div>
      </div>

      <p class="text-xs text-slate-400 mt-6">© {{ date('Y') }} Athlentry</p>
    </div>

    <!-- Right form panel -->
    <div class="p-8 md:p-10">
      <div class="max-w-md mx-auto">

        @php
          $isAdmin = request()->query('role') === 'admin';
        @endphp

        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div>
              <h1 class="text-xl font-semibold text-slate-800">Forgot Password</h1>
              <p class="text-sm text-slate-500">Student password recovery</p>
            </div>
          </div>

          <a href="{{ route('login.view') }}" class="text-sm text-slate-500 hover:underline">Back</a>
        </div>

        {{-- SESSION SUCCESS --}}
        @if(session('status'))
          <div class="mb-4 text-sm text-green-700 bg-green-50 p-3 rounded">
            {{ session('status') }}
          </div>
        @endif

        {{-- ERRORS --}}
        @if ($errors->any())
          <div class="mb-4 text-sm text-red-700 bg-red-50 p-3 rounded">
            {{ $errors->first() }}
          </div>
        @endif

        {{-- ADMIN WARNING --}}
        @if($isAdmin)
          <div class="mb-4 p-4 rounded bg-yellow-50 text-yellow-800 text-sm">
            Admin accounts cannot reset passwords here. Please contact system administrator or IT support.
          </div>
        @endif

        <!-- FORM -->
        <form id="forgotForm" method="POST" action="{{ route('student.password.reset') }}"
              class="@if($isAdmin) disabled-overlay @endif">

          @csrf

          <div class="mb-3">
            <label class="block text-xs font-medium text-slate-600 mb-1">Matric Number</label>
            <input id="matric_no" name="matric_no" type="text" value="{{ old('matric_no') }}"
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg"
                   placeholder="e.g. cb22047" required>
          </div>

          <div class="mb-3">
            <label class="block text-xs font-medium text-slate-600 mb-1">Email (optional)</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg"
                   placeholder="your@campus.edu">
          </div>

          <div class="mb-3">
            <label class="block text-xs font-medium text-slate-600 mb-1">New Password</label>
            <input id="new_password" name="password" type="password" required
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg"
                   placeholder="At least 8 characters">
          </div>

          <div class="mb-4">
            <label class="block text-xs font-medium text-slate-600 mb-1">Confirm New Password</label>
            <input id="new_password_confirm" name="password_confirmation" type="password" required
                   class="form-input w-full px-4 py-3 border border-slate-200 rounded-lg"
                   placeholder="Retype new password">
          </div>

          <div id="clientMsg" class="hidden mb-3 text-sm rounded p-3"></div>

          <button type="submit" id="forgotSubmit"
                  class="w-full py-3 rounded-lg text-white font-semibold shadow-md hover:opacity-95 transition"
                  style="background: linear-gradient(90deg,var(--maroon),var(--maroon-dark));">
            Reset Password
          </button>

          <button type="button"
                  class="mt-3 w-full py-3 rounded-lg border border-slate-200 text-slate-700 text-sm">
            Contact IT
          </button>
        </form>

        <p class="text-xs text-slate-400 mt-4">
          Note: Server validates that only students can reset passwords here.
        </p>

      </div>
    </div>
  </div>

  <script>
    // Fade in animation
    window.addEventListener("load", () => {
      document.querySelector(".card").classList.add("show");
    });
  </script>

  <!-- Existing JS validation remains intact -->
  <script>
    (function(){
      const isAdmin = {{ $isAdmin ? 'true' : 'false' }};
      const form = document.getElementById('forgotForm');
      const submitBtn = document.getElementById('forgotSubmit');
      const clientMsg = document.getElementById('clientMsg');

      function showMsg(type, text){
        clientMsg.classList.remove('hidden','bg-red-50','text-red-700','bg-green-50','text-green-700');
        clientMsg.classList.add(type === 'error' ? 'bg-red-50' : 'bg-green-50');
        clientMsg.classList.add(type === 'error' ? 'text-red-700' : 'text-green-700');
        clientMsg.textContent = text;
      }

      if (isAdmin) {
        form.addEventListener('submit', function(e){
          e.preventDefault();
          alert('Admin accounts cannot use the student password reset.');
        });
        submitBtn.disabled = true;
      } else {
        form.addEventListener('submit', function(e){
          clientMsg.classList.add('hidden');

          const pw = document.getElementById('new_password').value || '';
          const pwc = document.getElementById('new_password_confirm').value || '';
          const matric = document.getElementById('matric_no').value || '';

          if (!matric.trim()) {
            e.preventDefault();
            showMsg('error', 'Please enter your Matric Number.');
            return;
          }
          if (pw.length < 8) {
            e.preventDefault();
            showMsg('error', 'Password must be at least 8 characters.');
            return;
          }
          if (pw !== pwc) {
            e.preventDefault();
            showMsg('error', 'Passwords do not match.');
            return;
          }

          submitBtn.disabled = true;
          submitBtn.textContent = 'Processing...';
        });
      }
    })();
  </script>

</body>
</html>
