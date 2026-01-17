@extends('layouts.app')

@section('title', 'Edit Athlete Profile')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">

    {{-- HEADER --}}
    <div class="relative px-6 py-6">
        <div class="max-w-5xl mx-auto bg-white border border-slate-100 shadow-sm rounded-[2.5rem] px-10 py-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black italic uppercase tracking-tight text-slate-900">
                    Edit <span class="text-teal-600 not-italic">Profile</span>
                </h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-bold mt-2">Update recruitment details</p>
            </div>
            <a href="{{ route('student.profile.show') }}" class="px-6 py-3 rounded-2xl bg-slate-100 text-slate-600 text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition">← Back</a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 mt-6">
        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-[3rem] p-10 md:p-14 border border-slate-100 shadow-sm space-y-12">

                {{-- PHOTO UPLOAD SECTION --}}
                <div class="flex flex-col md:flex-row items-center gap-10 bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                    <img class="h-32 w-32 object-cover rounded-3xl border-4 border-white shadow-lg" 
                         src="{{ $user->ProfilePhoto ? asset('storage/' . $user->ProfilePhoto) : 'https://ui-avatars.com/api/?name='.urlencode($user->Name).'&background=0D9488&color=fff' }}" 
                         alt="Current photo">
                    <div class="flex-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Profile Photo</label>
                        <input type="file" name="ProfilePhoto" class="mt-3 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-teal-600 file:text-white hover:file:bg-teal-700">
                        <p class="mt-2 text-[9px] font-bold text-slate-400 uppercase tracking-tighter italic italic">PNG, JPG or JPEG (Max 2MB)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Full Name (Locked)</label>
                        <input type="text" value="{{ $user->Name }}" readonly class="mt-2 w-full rounded-2xl bg-slate-100 border border-slate-200 p-4 font-bold text-slate-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email Address</label>
                        <input type="email" name="Email" value="{{ old('Email', $user->Email) }}" required class="mt-2 w-full rounded-2xl border-slate-200 p-4 font-medium focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Matric Number (Locked)</label>
                        <input type="text" value="{{ $user->MatricNo }}" readonly class="mt-2 w-full rounded-2xl bg-slate-100 border border-slate-200 p-4 font-bold text-slate-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Phone Number</label>
                        <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber', $user->PhoneNumber) }}" required class="mt-2 w-full rounded-2xl border-slate-200 p-4 font-medium focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 block">Sports Achievement</label>
                    <textarea name="Achievement" rows="4" class="w-full rounded-2xl border border-slate-200 p-5 font-medium focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500" placeholder="List your relevant sports experience...">{{ old('Achievement', $user->Achievement) }}</textarea>
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 block">Medical History</label>
                    <textarea name="MedicalHistory" rows="4" class="w-full rounded-2xl border border-slate-200 p-5 font-medium focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500" placeholder="Specify any allergies or previous injuries...">{{ old('MedicalHistory', $user->MedicalHistory) }}</textarea>
                </div>

                <div class="flex justify-end gap-4 pt-8 border-t border-slate-100">
                    <a href="{{ route('student.profile.show') }}" class="px-8 py-4 rounded-2xl bg-slate-100 text-slate-500 text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition">Cancel</a>
                    <button type="submit" class="px-10 py-4 rounded-2xl bg-teal-600 text-white text-xs font-black uppercase tracking-widest shadow-lg shadow-teal-600/25 hover:brightness-110 active:scale-95 transition">Save Changes</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection