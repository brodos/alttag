@extends('layouts.app')

@section('content')

<div class="mx-3 sm:mx-auto sm:max-w-sm mb-12 mt-12">

    <div class="card rounded bg-white shadow-lg">

        <div class="card-body p-6 lg:p-8">
            
            <form method="POST" action="{{ route('login') }}">

                @csrf

                <div class="w-full">

                    <label class="block font-bold text-sm text-blue-darker mb-2" for="email">Email</label>

                    <input type="email" id="email" name="email" class="font-bold w-full focus:outline-none appearance-none p-4 bg-grey-lighter rounded leading-tight text-grey-darkest" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <p class="has-error text-sm mt-1 text-red-dark">{{ $errors->first('email') }}</p>
                    @endif
                    
                </div>

                <div class="mt-6">

                    <label class="block font-bold text-sm text-blue-darker mb-2" for="password">Password</label>

                    <input type="password" id="password" name="password" class="font-bold w-full focus:outline-none appearance-none p-4 bg-grey-lighter rounded leading-tight text-grey-darkest" required>

                    @if ($errors->has('password'))
                        <p class="has-error text-sm mt-1 text-red-dark">{{ $errors->first('password') }}</p>
                    @endif
                    
                </div>

                <div class="mt-6">
                    <label class="block text-grey-darker flex items-center">
                        <input class="mr-2" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="text-sm">Remember me</span>
                    </label>
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="w-full btn btn-blue">Sign In</button>
                </div>
                
            </form>
        </div> {{-- end .card-body --}}

        <div class="card-footer bg-grey-lightest p-8 border-t border-grey-lighter flex items-center justify-between text-sm"> 
            
            <a href="{{ route('register') }}" class="font-bold text-blue-dark no-underline hover:text-blue-darker">Create an account</a>
            <a href="{{ route('password.request') }}" class="text-grey-darker hover:text-black no-underline">Forgot my password</a>
            
        </div>

    </div>
</div>
@endsection