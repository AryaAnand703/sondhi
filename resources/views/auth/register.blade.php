@extends('layouts.app')

@section('title', 'Create Account | Sondhi')

@section('content')
<div class="max-w-md mx-auto my-12 px-4">
    <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                <i class="fa-solid fa-user-plus text-xl"></i>
            </div>
            <h2 class="font-serif text-2xl font-bold text-gray-900">Create Sondhi Account</h2>
            <p class="text-xs text-gray-500 mt-1">Join to unlock saved addresses, order tracking, and priority support.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-xs font-bold uppercase text-gray-600 mb-1">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-bold uppercase text-gray-600 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-xs font-bold uppercase text-gray-600 mb-1">Phone Number</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+91 9939628020" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('phone') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase text-gray-600 mb-1">Password</label>
                <input type="password" name="password" id="password" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase text-gray-600 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-500/25 transition-all mt-4">
                Create Account
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center text-xs text-gray-500">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:underline ml-1">Sign In</a>
        </div>
    </div>
</div>
@endsection
