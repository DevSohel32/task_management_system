@extends('layouts.app')

@section('content')
<div class="hero min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 font-sans">
    <div class="hero-content grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 p-6">

        <div class="text-center lg:text-left">
            <div class="badge badge-secondary badge-outline mb-4 px-4 py-3 font-bold gap-2">
                <i class="fa-solid fa-key text-xs"></i> Security First
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-slate-800 leading-tight">
                Forgot <span class="text-primary italic">Password?</span>
            </h1>
            <p class="py-6 text-slate-500 text-lg leading-relaxed">
                No problem! It happens to the best of us. Just enter your email and we'll send you a secure link to reset it.
            </p>

            <a href="{{ route('login') }}" class="btn btn-ghost gap-2 normal-case font-bold text-slate-600">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Login
            </a>
        </div>

        <div class="card shrink-0 w-full bg-white/80 backdrop-blur-xl border border-white shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] rounded-[2.5rem] overflow-hidden">
            <div class="card-body p-8 lg:p-12">

                <div class="mb-8">
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight">Reset Access</h2>
                    <p class="text-slate-400 text-sm mt-2 font-medium">We'll email you a magic link to get back in.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success shadow-sm mb-6 rounded-2xl bg-emerald-50 border-emerald-100 text-emerald-700 text-sm font-bold">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-bold text-slate-700 uppercase text-xs tracking-wider">Email Address</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="your-email@example.com"
                            class="input input-bordered input-primary w-full bg-white/50 h-14 rounded-2xl focus:shadow-xl transition-all @error('email') border-red-500 @enderror"
                            required autofocus />

                        @error('email')
                            <span class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control mt-8">
                        <button type="submit" class="btn btn-primary h-14 text-lg shadow-xl shadow-blue-100 normal-case rounded-2xl font-black border-none bg-gradient-to-r from-blue-600 to-indigo-600 hover:scale-[1.02] active:scale-[0.98] transition-all text-white px-6">
                            Submit
                        </button>
                    </div>
                </form>

                <div class="divider text-slate-300 text-[10px] font-bold tracking-[0.3em] my-10 uppercase">Security Check</div>

                <p class="text-center font-bold text-slate-400 text-xs">
                    Didn't receive the email? Check your spam folder.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
