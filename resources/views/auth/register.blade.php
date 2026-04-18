@extends('layouts.app')

@section('content')
 <div class="hero min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 font-sans">
    <div class="hero-content flex-col lg:flex-row-reverse gap-12 lg:gap-24 p-6">

        <div class="text-center lg:text-left max-w-lg">
            <div class="badge badge-primary badge-outline mb-4 px-4 py-3 font-bold gap-2">
                <i class="fa-solid fa-rocket text-xs"></i> New Features Available
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-slate-800 leading-tight lg:leading-[1.2]">
                Streamline with <span class="text-primary italic">Task Flow</span>
            </h1>
            <p class="py-6 text-slate-500 text-lg leading-relaxed">
                Experience the most intuitive task management system. Join 10k+ users who have optimized their daily productivity.
            </p>

            <div class="flex flex-wrap gap-4 mt-2 justify-center lg:justify-start">
                <div class="flex items-center gap-2 text-sm font-bold text-slate-600">
                    <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-primary border border-slate-100 italic">Q</div>
                    Instant Setup
                </div>
                <div class="flex items-center gap-2 text-sm font-bold text-slate-600">
                    <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-success border border-slate-100">✓</div>
                    Cloud Sync
                </div>
            </div>
        </div>

        <div class="card shrink-0 w-full max-w-[550px] bg-white/80 backdrop-blur-xl border border-white shadow-2xl rounded-[2.5rem] overflow-hidden">
            <form action="{{ route('register') }}" method="POST" class="card-body p-8 lg:p-12">
                @csrf

                <div class="mb-8">
                    <h2 class="card-title text-3xl font-extrabold text-slate-800">Sign Up</h2>
                    <p class="text-slate-400 text-sm mt-1 font-medium italic">Start your journey today.</p>
                </div>

                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-bold text-slate-600">Full Name</span></label>
                        <input type="text" name="name" placeholder="John Doe"
                            class="input input-bordered input-primary w-full bg-white/50 focus:shadow-lg transition-all rounded-2xl" required />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text font-bold text-slate-600">Email Address</span></label>
                        <input type="email" name="email" placeholder="john@example.com"
                            class="input input-bordered input-primary w-full bg-white/50 focus:shadow-lg transition-all rounded-2xl" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold text-slate-600">Password</span></label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="input input-bordered input-primary w-full bg-white/50 focus:shadow-lg transition-all rounded-2xl" required />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold text-slate-600">Confirm</span></label>
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                class="input input-bordered input-primary w-full bg-white/50 focus:shadow-lg transition-all rounded-2xl" required />
                        </div>
                    </div>
                </div>

                <div class="form-control mt-4">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" class="checkbox checkbox-primary checkbox-sm rounded-lg" required />
                        <span class="label-text text-slate-500 text-xs font-medium">I accept the <a href="#" class="link link-primary font-bold">Terms of Service</a></span>
                    </label>
                </div>

                <div class="form-control mt-8">
                    <button type="submit" class="btn btn-primary px-6 py-3 text-lg btn-lg shadow-xl shadow-blue-200 normal-case rounded-2xl font-black group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 transition-all text-white">
                       Sign Up

                    </button>
                </div>

                <div class="divider text-slate-300 text-[10px] font-bold tracking-[0.2em] my-6">ALREADY A MEMBER?</div>

                <p class="text-center font-bold text-slate-500 text-sm">
                    Have an account? <a href="{{ route('login') }}" class="text-primary hover:underline underline-offset-4">Log In</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
