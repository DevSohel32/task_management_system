@extends('layouts.app')

@section('content')
<div class="hero min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 font-sans">
    <div class="hero-content flex-col lg:flex-row gap-12 lg:gap-24 p-6">

        <div class="text-center lg:text-left max-w-lg">
            <div class="badge badge-warning badge-outline mb-4 px-4 py-3 font-bold gap-2">
                <i class="fa-solid fa-shield-halved text-xs"></i> Secure Area
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-slate-800 leading-tight">
                Confirm your <span class="text-primary italic">Identity.</span>
            </h1>
            <p class="py-6 text-slate-500 text-lg leading-relaxed">
                This is a secure area of the application. For your safety, please confirm your password before continuing to your profile or settings.
            </p>

            <div class="flex items-center justify-center lg:justify-start gap-4">
                <div class="flex -space-x-2">
                    <div class="w-10 h-10 rounded-full bg-blue-100 border-2 border-white flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">End-to-end encrypted</p>
            </div>
        </div>

        <div class="card shrink-0 w-full max-w-[500px] bg-white/80 backdrop-blur-xl border border-white shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] rounded-[2.5rem] overflow-hidden">
            <div class="card-body p-8 lg:p-12">

                <div class="mb-8">
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight">Security Check</h2>
                    <p class="text-slate-400 text-sm mt-2 font-medium">Verify it's really you.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <div class="form-control">
                        <label class="label mb-1">
                            <span class="label-text font-bold text-slate-700 uppercase text-xs tracking-wider">Your Password</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" placeholder="••••••••"
                                class="input input-bordered input-primary w-full bg-white/50 h-14 rounded-2xl focus:shadow-xl transition-all @error('password') border-red-500 @enderror"
                                required autocomplete="current-password" autofocus />
                            <div class="absolute right-4 top-4 text-slate-300">
                                <i class="fa-solid fa-eye-slash cursor-pointer hover:text-primary transition-colors"></i>
                            </div>
                        </div>

                        @error('password')
                            <span class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control mt-8">
                        <button type="submit" class="btn btn-primary h-14 text-lg shadow-xl shadow-blue-100 normal-case rounded-2xl font-black border-none bg-gradient-to-r from-blue-600 to-indigo-600 hover:scale-[1.02] active:scale-[0.98] transition-all text-white">
                            Confirm Access
                            <i class="fa-solid fa-unlock-alt text-xs ml-2"></i>
                        </button>
                    </div>
                </form>

                <div class="divider text-slate-300 text-[10px] font-bold tracking-[0.3em] my-10 uppercase">Identity Verified</div>

                <p class="text-center font-bold text-slate-500 text-sm italic">
                    Protecting your data at <span class="text-slate-800">Task Flow</span>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
