@extends('layouts.app')

@section('content')



<div class="mx-3 sm:mx-auto sm:max-w-sm mb-4 sm:mb-10 sm:mt-10">

    <div class="card rounded bg-white shadow-lg">
        
        <div class="card-body p-6 lg:p-8">

            <form method="POST" action="{{ route('register') }}" class="m-0">
                @csrf

                <div>

                    <label class="block font-bold text-sm text-blue-darker mb-2" for="name">Name</label>

                    <input type="text" id="name" name="name" class="font-bold w-full focus:outline-none appearance-none p-4 bg-grey-lighter rounded leading-tight text-grey-darkest" value="{{ old('name') }}" required>

                    @if ($errors->has('name'))
                        <p class="has-error text-sm mt-1 text-red-dark">{{ $errors->first('name') }}</p>
                    @endif
                    
                </div>

                <div class="mt-6">

                    <label class="block font-bold text-sm text-blue-darker mb-2" for="email">Email</label>

                    <input type="email" id="email" name="email" class="font-bold w-full focus:outline-none appearance-none p-4 bg-grey-lighter rounded leading-tight text-grey-darkest" value="{{ old('email') }}" required>

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

                    <label class="block font-bold text-sm text-blue-darker mb-2" for="password_confirmation">Confirm password</label>

                    <input type="password" id="password_confirmation" name="password_confirmation" class="font-bold w-full focus:outline-none appearance-none p-4 bg-grey-lighter rounded leading-tight text-grey-darkest" required>

                    @if ($errors->has('password_confirmation'))
                        <p class="has-error text-sm mt-1 text-red-dark">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                    
                </div>

                <div class="mt-6">
                    <label class="block flex items-center">
                        <input class="mr-2" type="checkbox" name="terms_of_use" {{ old('terms_of_use') ? 'checked' : '' }} required>
                        <span class="text-sm text-grey-darker leading-normal cursor-pointer">
                            I agree with the site's <a href="#terms" class="text-blue-dark hover:text-blue-darker">terms &amp; conditions</a> and <a href="#privacy" class="text-blue-dark hover:text-blue-darker">privacy policy</a>.
                        </span>
                    </label>
                    @if ($errors->has('terms_of_use'))
                        <p class="has-error text-sm mt-1 text-red-dark">{{ $errors->first('terms_of_use') }}</p>
                    @endif
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="w-full btn btn-blue">Create account</button>
                </div>
                
            </form>
        </div> {{-- end .card-body --}}

        <div class="card-footer bg-grey-lightest p-8 border-t border-grey-lighter flex items-center justify-center text-sm"> 
            
            <a href="{{ route('login') }}" class="font-bold text-blue-dark no-underline hover:text-blue-darker">Already have an account?</a>
            
        </div>

    </div>
</div>
@endsection