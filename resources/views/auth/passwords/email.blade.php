@extends('layouts.app')

@section('content')

<div class="mx-3 sm:mx-auto sm:max-w-sm mb-12 mt-12">
    
    <div class="card rounded bg-white shadow-lg">
        
        <div class="card-header p-6 lg:p-8 border-b lg:border-grey-lighter flex items-center justify-center">
                            
            <span class="font-semibold text-lg leading-normal text-blue-dark">Reset your password</span>
            
        </div> <!-- end .card-header -->

        <div class="card-body p-6 lg:p-10">

            @if (session('status'))
                <div class="bg-green-lightest border-l-4 border-green p-6 text-green-darker rounded mb-6" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="w-full">

                    <label class="block font-bold text-sm text-blue-darker mb-2" for="email">Email</label>

                    <input type="email" id="email" name="email" class="font-bold w-full focus:outline-none appearance-none p-4 bg-grey-lighter rounded leading-tight text-grey-darkest" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <p class="has-error text-sm mt-1 text-red-dark">{{ $errors->first('email') }}</p>
                    @endif
                    
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="w-full btn btn-blue">Reset password</button>
                </div>
                
            </form>

        </div> {{-- end .card-body --}}

        <div class="card-footer bg-grey-lightest p-8 border-t border-grey-lighter flex items-center justify-center text-sm"> 
            
            <a href="{{ route('login') }}" class="font-bold text-blue-dark no-underline hover:text-blue-darker">I remembered it!</a>
            
        </div>

    </div>
</div>
@endsection