@extends('layouts.app')

@section('content')
<div class="hero min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 font-sans">
    <div class="hero-content flex-col lg:flex-row gap-12 lg:gap-24 p-6">

        <div class="text-center lg:text-left max-w-lg">
            <div class="badge badge-accent badge-outline mb-4 px-4 py-3 font-bold gap-2 shadow-sm">
                <i class="fa-solid fa-envelope-open-text text-xs"></i> Action Required
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-slate-800 leading-tight">
                Check your <span class="text-primary italic">Inbox.</span>
            </h1>
            <p class="py-6 text-slate-500 text-lg leading-relaxed">
                Thanks for signing up! We've sent a verification link to your email. Please click it to activate your account and start using <span class="font-bold text-slate-700">Task Flow</span>.
            </p>

            <div class="flex items-center justify-center lg:justify-start gap-4">
                <div class="avatar-group -space-x-4 rtl:space-x-reverse">
                    <div class="avatar placeholder">
                        <div class="bg-blue-100 text-blue-600 w-10 rounded-full border-2 border-white">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Verification Pending</p>
            </div>
        </div>

        <div class="card shrink-0 w-full max-w-[500px] bg-white/80 backdrop-blur-xl border border-white shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] rounded-[2.5rem] overflow-hidden">
            <div class="card-body p-8 lg:p-12">

                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 text-primary rounded-full mb-4 animate-bounce">
                        <i class="fa-solid fa-paper-plane text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight">Verify Email</h2>
                    <p class="text-slate-400 text-sm mt-2 font-medium italic">Didn't get the email? We can send another.</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success shadow-lg mb-8 rounded-2xl bg-emerald-50 border-emerald-100 text-emerald-700 font-bold text-sm animate-in fade-in slide-in-from-top-4 duration-500">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>A fresh link has been sent to your email!</span>
                    </div>
                @endif

                <div class="space-y-6">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-full h-14 text-lg shadow-xl shadow-blue-100 normal-case rounded-2xl font-black border-none bg-gradient-to-r from-blue-600 to-indigo-600 hover:scale-[1.02] active:scale-[0.98] transition-all text-white">
                            Resend Link
                        </button>
                    </form>

                    <div class="divider text-slate-300 text-[10px] font-bold tracking-[0.3em] my-6">OR</div>

                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-colors uppercase tracking-widest flex items-center justify-center gap-2 mx-auto">
                            <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            Log Out
                        </button>
                    </form>
                </div>

                <div class="mt-10 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] text-slate-400 text-center font-medium leading-relaxed uppercase tracking-tighter">
                        Check your spam or junk folder if you don't see the email in your primary inbox.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
