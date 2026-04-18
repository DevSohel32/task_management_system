@extends('layouts.app')

@section('content')
    <div class="hero min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 font-sans">
        <div class="hero-content flex-col lg:flex-row-reverse gap-12 lg:gap-24 p-6">

            <div class="text-center lg:text-left max-w-lg">
                <div class="badge badge-primary badge-outline mb-4 px-4 py-3 font-bold gap-2 animate-pulse">
                    <i class="fa-solid fa-rocket text-xs"></i> New Features Available
                </div>
                <h1 class="text-4xl lg:text-6xl font-black text-slate-800 leading-tight lg:leading-[1.2]">
                    Welcome back to <span class="text-primary italic">Task Flow</span>
                </h1>
                <p class="py-6 text-slate-500 text-lg leading-relaxed">
                    Log in to sync your tasks and pick up exactly where you left off. Precision and productivity at your
                    fingertips.
                </p>

                <div class="hidden lg:flex flex-wrap gap-6 mt-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-white shadow-md flex items-center justify-center text-primary border border-blue-50">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-700 leading-none">Fast Sync</p>
                            <p class="text-xs text-slate-400 mt-1">Real-time updates</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-white shadow-md flex items-center justify-center text-success border border-green-50">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-700 leading-none">Enterprise Security</p>
                            <p class="text-xs text-slate-400 mt-1">End-to-end encrypted</p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="card shrink-0 w-full max-w-[500px] bg-white/80 backdrop-blur-xl border border-white shadow-2xl rounded-[2.5rem] overflow-hidden">
                <form action="{{ route('login') }}" method="POST" class="card-body p-8 lg:p-12">
                    @csrf

                    <div class="mb-8">
                        <h2 class="card-title text-3xl font-extrabold text-slate-800">Sign In</h2>
                        <p class="text-slate-400 text-sm mt-1 font-medium italic">Welcome back! Please enter your details.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold text-slate-600">Full Name</span></label>
                            <input type="text" name="name" placeholder="John Doe"
                                class="input input-bordered input-primary w-full bg-white/50 focus:shadow-lg transition-all rounded-2xl @error('email') border-red-500 @enderror" />
                                @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold text-slate-600">Password</span></label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="input input-bordered input-primary w-full bg-white/50 focus:shadow-lg transition-all rounded-2xl"
                                required />
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <label class="label cursor-pointer justify-start gap-3 p-0">
                            <input type="checkbox" name="remember"
                                class="checkbox checkbox-primary checkbox-sm rounded-lg" />
                            <span class="label-text text-slate-500 text-xs font-bold">Keep me logged in</span>
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-primary hover:underline">Forgot?</a>
                        </label>
                    </div>

                    <div class="form-control mt-8">
                        <button type="submit"
                            class="btn btn-primary px-6 py-3 text-lg btn-lg shadow-xl shadow-blue-200 normal-case rounded-2xl font-black group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 transition-all text-white">
                            Login

                        </button>
                    </div>

                    <div class="divider text-slate-300 text-[10px] font-bold tracking-[0.2em] my-6">OR CONTINUE WITH</div>

                    <p class="text-center font-bold text-slate-500 text-sm">
                        Don't have an account ? <a href="{{ route('register') }}"
                            class="text-primary hover:underline underline-offset-4">Create One</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
