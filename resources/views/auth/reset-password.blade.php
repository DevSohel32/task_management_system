@extends('layouts.app')

@section('content')
<div class="hero min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 font-sans">
    <div class="hero-content flex-col lg:flex-row gap-12 lg:gap-24 p-6">

        <div class="text-center lg:text-left max-w-lg">
            <div class="badge badge-primary badge-outline mb-4 px-4 py-3 font-bold gap-2 shadow-sm">
                <i class="fa-solid fa-user-shield text-xs"></i> Account Recovery
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-slate-800 leading-tight">
                Secure your <span class="text-primary italic">Account.</span>
            </h1>
            <p class="py-6 text-slate-500 text-lg leading-relaxed">
                Almost there! Choose a strong password to ensure your data stays protected. We recommend using a mix of letters, numbers, and symbols.
            </p>

            <div class="flex items-center justify-center lg:justify-start gap-4">
                <div class="avatar-group -space-x-4">
                    <div class="avatar placeholder">
                        <div class="bg-emerald-100 text-emerald-600 w-10 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </div>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Identity Verified via Token</p>
            </div>
        </div>

        <div class="card shrink-0 w-full max-w-[500px] bg-white/80 backdrop-blur-xl border border-white shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] rounded-[2.5rem] overflow-hidden">
            <div class="card-body p-8 lg:p-12">

                <div class="mb-8">
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight">New Password</h2>
                    <p class="text-slate-400 text-sm mt-2 font-medium">Update your credentials for <span class="text-slate-700">Task Flow</span>.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-control">
                        <label class="label mb-1">
                            <span class="label-text font-bold text-slate-700 uppercase text-xs tracking-wider">Confirmed Email</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                            class="input input-bordered input-primary w-full bg-slate-50/50 h-14 rounded-2xl opacity-70 cursor-not-allowed"
                            required readonly />
                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label mb-1">
                            <span class="label-text font-bold text-slate-700 uppercase text-xs tracking-wider">New Password</span>
                        </label>
                        <input id="password" type="password" name="password" placeholder="••••••••"
                            class="input input-bordered input-primary w-full bg-white/50 h-14 rounded-2xl focus:shadow-xl transition-all @error('password') border-red-500 @enderror"
                            required autocomplete="new-password" autofocus />
                        @error('password')
                            <span class="text-red-500 text-xs mt-1 font-medium italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label mb-1">
                            <span class="label-text font-bold text-slate-700 uppercase text-xs tracking-wider">Confirm New Password</span>
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••"
                            class="input input-bordered input-primary w-full bg-white/50 h-14 rounded-2xl focus:shadow-xl transition-all"
                            required autocomplete="new-password" />
                        @error('password_confirmation')
                            <span class="text-red-500 text-xs mt-1 font-medium italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control mt-8">
                        <button type="submit" class="btn btn-primary h-14 text-lg shadow-xl shadow-blue-100 normal-case rounded-2xl font-black border-none bg-gradient-to-r from-blue-600 to-indigo-600 hover:scale-[1.02] active:scale-[0.98] transition-all text-white">
                            Reset Password
                            <i class="fa-solid fa-circle-check text-xs ml-2"></i>
                        </button>
                    </div>
                </form>

                <div class="divider text-slate-300 text-[10px] font-bold tracking-[0.3em] my-10 uppercase">Security Protocol</div>

                <p class="text-center font-bold text-slate-500 text-sm">
                    Remember your new password? <a href="{{ route('login') }}" class="text-primary hover:underline underline-offset-4">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
