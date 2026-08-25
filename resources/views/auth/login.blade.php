@extends('layouts.app')

@section('title', 'Customer Login | Sondhi')

@section('content')
<div class="max-w-md mx-auto my-12 px-4">
    <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                <i class="fa-solid fa-lock text-xl"></i>
            </div>
            <h2 class="font-serif text-2xl font-bold text-gray-900">Welcome Back</h2>
            <p class="text-xs text-gray-500 mt-1">Log in to track orders, manage addresses, and contact support.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold uppercase text-gray-600 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('email')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-xs font-bold uppercase text-gray-600">Password</label>
                    <a href="#" class="text-xs font-semibold text-brand-600 hover:underline">Forgot password?</a>
                </div>
                <input type="password" name="password" id="password" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-xs text-gray-600 font-medium">
                    <input type="checkbox" name="remember" class="rounded text-brand-600 focus:ring-brand-500 mr-2">
                    Remember me
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-500/25 transition-all">
                Sign In to Account
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center text-xs text-gray-500">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:underline ml-1">Create Account</a>
        </div>
    </div>
</div>
@endsection
