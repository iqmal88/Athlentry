@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">

    {{-- HEADER --}}
    <div class="relative px-6 py-6">
        <div class="max-w-5xl mx-auto bg-white border border-slate-100 shadow-sm
                    rounded-[2.5rem] px-10 py-8 flex items-center justify-between
                    relative overflow-hidden">

            <div class="absolute -top-24 -right-24 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>

            <div>
                <h1 class="text-3xl font-black italic uppercase tracking-tight text-slate-900">
                    Edit <span class="text-teal-600 not-italic">Profile</span>
                </h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-bold mt-2">
                    Update Athlete Personal Information
                </p>
            </div>

            <a href="{{ route('student.profile.show') }}"
               class="px-6 py-3 rounded-2xl bg-slate-100 text-slate-600
                      text-xs font-black uppercase tracking-widest
                      hover:bg-slate-200 transition">
                ← Back
            </a>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-5xl mx-auto px-6 mt-6 animate-fade-in">

        {{-- ALERTS --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-teal-50 border border-teal-100
                        text-teal-700 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100
                        text-red-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('student.profile.update') }}">
            @csrf

            <div class="bg-white rounded-[3rem] p-10 md:p-14
                        border border-slate-100 shadow-sm space-y-12">

                {{-- BASIC INFO --}}
                <div>
                    <div class="flex items-center gap-4 mb-8">
                        <h3 class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em]">
                            Basic Information
                        </h3>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        {{-- Full Name --}}
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Full Name
                            </label>
                            <input type="text" value="{{ $user->Name }}"
                                   readonly
                                   class="mt-2 w-full rounded-2xl bg-slate-100
                                          border border-slate-200 p-4
                                          font-bold text-slate-600 cursor-not-allowed">
                        </div>

                        {{-- Matric --}}
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Matric Number
                            </label>
                            <input type="text" value="{{ $user->MatricNo }}"
                                   readonly
                                   class="mt-2 w-full rounded-2xl bg-slate-100
                                          border border-slate-200 p-4
                                          font-bold text-slate-600 cursor-not-allowed">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Email Address
                            </label>
                            <input type="email" name="Email"
                                   value="{{ old('Email', $user->Email) }}"
                                   required
                                   class="mt-2 w-full rounded-2xl bg-white
                                          border border-slate-200 p-4
                                          font-medium text-slate-900
                                          focus:ring-2 focus:ring-teal-500/20
                                          focus:border-teal-500">
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Phone Number
                            </label>
                            <input type="text" name="PhoneNumber"
                                   value="{{ old('PhoneNumber', $user->PhoneNumber) }}"
                                   required
                                   class="mt-2 w-full rounded-2xl bg-white
                                          border border-slate-200 p-4
                                          font-medium text-slate-900
                                          focus:ring-2 focus:ring-teal-500/20
                                          focus:border-teal-500">
                        </div>
                    </div>
                </div>

                {{-- MEDICAL --}}
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.3em]
                               text-slate-400 mb-4">
                        Medical History
                    </h3>
                    <textarea name="MedicalHistory" rows="4"
                              class="w-full rounded-2xl bg-white
                                     border border-slate-200 p-5
                                     font-medium text-slate-700
                                     focus:ring-2 focus:ring-teal-500/20
                                     focus:border-teal-500"
                              placeholder="Any medical conditions or injuries...">{{ old('MedicalHistory', $user->MedicalHistory) }}</textarea>
                </div>

                {{-- PASSWORD --}}
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.3em]
                               text-slate-400 mb-4">
                        Change Password (Optional)
                    </h3>
                    <input type="password" name="Password"
                           class="w-full rounded-2xl bg-white
                                  border border-slate-200 p-4
                                  font-medium text-slate-900
                                  focus:ring-2 focus:ring-teal-500/20
                                  focus:border-teal-500"
                           placeholder="Leave blank to keep current password">
                </div>

                {{-- ACTIONS --}}
                <div class="flex justify-end gap-4 pt-8 border-t border-slate-100">
                    <a href="{{ route('student.profile.show') }}"
                       class="px-8 py-4 rounded-2xl bg-slate-100
                              text-slate-500 text-xs
                              font-black uppercase tracking-widest
                              hover:bg-slate-200 transition">
                        Cancel
                    </a>

                    <button type="submit"
                            class="px-10 py-4 rounded-2xl bg-teal-600
                                   text-white text-xs font-black
                                   uppercase tracking-widest
                                   shadow-lg shadow-teal-600/25
                                   hover:brightness-110 active:scale-95 transition">
                        Save Changes
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
